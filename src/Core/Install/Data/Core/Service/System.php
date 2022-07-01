<?php
namespace Host\Subdomain\Host\Extension\Service;

use R3m\Io\Config;
use R3m\Io\Module\Data;
use R3m\Io\Module\Dir;
use stdClass;
use LikeIt\Cms\Core\Install\Service\Update;
use R3m\Io\App;
use R3m\Io\Module\Core;
use R3m\Io\Module\Host;
use R3m\Io\Module\File;
use R3m\Io\Module\Response;

use R3m\Io\Exception\AuthorizationException;
use R3m\Io\Exception\FileWriteException;
use R3m\Io\Exception\ObjectException;

class System extends Main {

    public static function install(App $object, stdClass $installation){

    }


    public static function update(App $object){
        return Update::start($object);
    }

    /**
     * @throws ObjectException
     * @throws FileWriteException
     */
    public static function optimize(App $object){
        $host_url = $object->config('project.dir.data') . 'Host' . $object->config('extension.json');
        $is_cms = false;
        $hosts = $object->data_read($host_url);
        if($hosts){
            foreach($hosts->get() as $uuid => $host){
                if(
                    property_exists($host, 'subdomain') &&
                    $host->subdomain === 'cms'
                ){
                    $is_cms = true;
                    break;
                }
            }
        }
        if(
            $is_cms &&
            !empty($host) &&
            property_exists($host, 'subdomain') &&
            property_exists($host, 'host') &&
            property_exists($host, 'extension') &&
            property_exists($host, 'name')
        ){

            $host->scheme = Host::SCHEME_HTTPS;
            $host->url = $host->scheme . '://' . $host->name . '/';
            $object->data('host', $host);
            $object->data('cms.dir.root',
                $object->config('project.dir.host') .
                ucfirst($host->subdomain) .
                $object->config('ds') .
                ucfirst($host->host) .
                $object->config('ds') .
                ucfirst($host->extension) .
                $object->config('ds')
            );
            $object->data('cms.dir.data',
              $object->data('cms.dir.root') .
              $object->config('dictionary.data') .
              $object->config('ds')
            );
            $object->data('cms.dir.view',
                $object->data('cms.dir.root') .
                $object->config('dictionary.view') .
                $object->config('ds')
            );
        }
        $url = $object->config('controller.dir.data') . 'Optimize' . $object->config('extension.json');
        $optimize = $object->parse_read($url);
        if(
            $optimize &&
            !empty($host)
        ){
            $optimizations = $optimize->get('optimizations');
            if(is_array($optimizations)){
                foreach($optimizations as $optimization){
                    if(
                        property_exists($optimization,'template') &&
                        property_exists($optimization,'data')
                    ){
                        $command = '/sbin/runuser --user www-data -- php /Application/Bin/R3m.php parse compile ' . $optimization->template . ' ' . $optimization->data;
                        echo $command . PHP_EOL;
                        Core::async($command);
                    }
                }
            }
        }
    }

    /*
     *  /*
                        $descriptorspec = array(
                            0 => array("pipe", "r"),  // stdin
                            1 => array("pipe", "w"),  // stdout
                            2 => array("pipe", "w"),  // stderr
                        );

                        $process = proc_open($command, $descriptorspec, $pipes, '/Application', null);
                        $stdout = stream_get_contents($pipes[1]);
                        fclose($pipes[1]);

                        $stderr = stream_get_contents($pipes[2]);
                        fclose($pipes[2]);

                        echo "stdout : \n";
                        var_dump($stdout);

                        echo "stderr :\n";
                        var_dump($stderr);


                        //system($command, $code);
//                        exec($command, $output, $code);
                        //Core::execute($command, $output);
                        //d($code);
                        //dd($output);
     */

    /**
     * @throws AuthorizationException
     */
    public static function update_cms(App $object)
    {
        if(!array_key_exists('HTTP_AUTHORIZATION', $_SERVER)){
            throw new AuthorizationException('Authorization token missing...');
        }
        $token = substr($_SERVER['HTTP_AUTHORIZATION'], 7);
        $execute = '
            funda admin task "
                composer update --quiet && 
                funda cache:clear &&
                funda system update ' . $token . ' &&
                funda cache:clear  &&
                funda system optimize             
            " ' . $token . '
        ';
        Core::execute($execute, $output);
        if(array_key_exists(0, $output)){
            $task = $output[0];
            $record = [];
            $record['output'] = $object->config('project.dir.data')  . 'Output' . $object->config('ds') . File::basename($task);
            $record['files'][] = $object->config('project.dir.data')  . 'Output' . $object->config('ds') . File::basename($task, '.task') . '.begin';
            $record['files'][] = $object->config('project.dir.data')  . 'Output' . $object->config('ds') . File::basename($task, '.task') . '.task';
            $record['files'][] = $object->config('project.dir.data')  . 'Output' . $object->config('ds') . File::basename($task, '.task') . '.end';
            $response = [];
            $response['node'] = $record;
            return new Response($response, Response::TYPE_JSON);
        }
    }
}
