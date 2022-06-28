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
                        //write host state to uuid::
                        $user_id = posix_geteuid();
                        $user_id = 33;
                        $uuid = Core::uuid();
                        $url_state = $object->config('project.dir.data') .
                            "Cache" .
                            $object->config('ds') .
                            $user_id .
                            $object->config('ds') .
                            'State.' .
                            $uuid .
                            $object->config('extension.json')
                        ;
                        $state = new Data();
                        $state->set('host', $host);

                        if(empty($host->subdomain)){
                            $state->set('config.host.dir.root',
                                $object->config('project.dir.host') .
                                ucfirst($host->host) .
                                $object->config('ds') .
                                ucfirst($host->extension) .
                                $object->config('ds')
                            );
                        } else {
                            $state->set('config.host.dir.root',
                                $object->config('project.dir.host') .
                                ucfirst($host->subdomain) .
                                $object->config('ds') .
                                ucfirst($host->host) .
                                $object->config('ds') .
                                ucfirst($host->extension) .
                                $object->config('ds')
                            );
                        }
                        $state->set('config.host.dir.data',
                            $state->get('config.host.dir.root') .
                            $object->config(Config::DICTIONARY . '.' . Config::DATA) .
                            $object->config('ds')
                        );
                        $state->set('config.host.dir.cache',
                            Dir::name($object->config('framework.dir.cache'), 2) .
                            $object->config(Config::DICTIONARY . '.' . Config::HOST) .
                            $object->config('ds')
                        );
                        $state->set('config.host.dir.public',
                            $state->get('config.host.dir.root') .
                            $object->config(Config::DICTIONARY . '.' . Config::PUBLIC) .
                            $object->config('ds'));
                        $state->set('config.host.dir.source',
                            $state->get('config.host.dir.root') .
                            $object->config(Config::DICTIONARY . '.' . Config::SOURCE) .
                            $object->config('ds'));
                        $state->set('config.host.dir.view',
                            $state->get('config.host.dir.root') .
                            $object->config(Config::DICTIONARY . '.' . Config::VIEW) .
                            $object->config('ds')
                        );
                        $controller = [];
                        $controller['name'] = 'settings';
                        $controller['title'] = ucfirst($controller['name']);
                        $controller['class'] = 'Host\\' . ucfirst($host->subdomain) . '\\' . ucfirst($host->host) . '\\' . ucfirst($host->extension) . '\\Controller\\' . $controller['title'];
                        $controller['dir'] = [];
                        $controller['dir']['source'] =  $object->config('project.dir.host') .
                            ucfirst($host->subdomain) .
                            $object->config('ds') .
                            ucfirst($host->host) .
                            $object->config('ds') .
                            ucfirst($host->extension) .
                            $object->config('ds') .
                            'Controller' .
                            $object->config('ds');
                        $controller['dir']['root'] =  $object->config('project.dir.host') .
                            ucfirst($host->subdomain) .
                            $object->config('ds') .
                            ucfirst($host->host) .
                            $object->config('ds') .
                            ucfirst($host->extension) .
                            $object->config('ds');
                        $controller['dir']['data'] = $controller['dir']['root'] .
                            $object->config('dictionary.data') .
                            $object->config('ds');
                        $controller['dir']['node'] = $controller['dir']['root'] .
                            $object->config('dictionary.node') .
                            $object->config('ds');
                        $controller['dir']['plugin'] = $controller['dir']['root'] .
                            $object->config('dictionary.plugin') .
                            $object->config('ds');
                        $controller['dir']['function'] = $controller['dir']['root'] .
                            $object->config('dictionary.function') .
                            $object->config('ds');
                        $controller['dir']['model'] = $controller['dir']['root'] .
                            $object->config('dictionary.model') .
                            $object->config('ds');
                        $controller['dir']['entity'] = $controller['dir']['root'] .
                            $object->config('dictionary.entity') .
                            $object->config('ds');
                        $controller['dir']['service'] = $controller['dir']['root'] .
                            $object->config('dictionary.service') .
                            $object->config('ds');
                        $controller['dir']['component'] = $controller['dir']['root'] .
                            $object->config('dictionary.component') .
                            $object->config('ds');
                        $controller['dir']['view'] = $controller['dir']['root'] .
                            $object->config('dictionary.view') .
                            $object->config('ds');
                        $controller['dir']['public'] = $controller['dir']['root'] .
                            $object->config('dictionary.public') .
                            $object->config('ds') .
                            $controller['title'] .
                            $object->config('ds');
                        $state->set('config.controller', $controller);
                        $state->write($url_state);
                        File::chown($url_state, 'www-data', 'www-data');
                        $command = 'runuser --user www-data -- php /Application/Bin/R3m.php parse compile ' . $optimization->template . ' ' . $optimization->data . ' state ' . $url_state;
                        $output = [];
                        echo $command . PHP_EOL;
                        Core::execute($command, $output);
                        dd($output);
                    }
                }
            }
        }
    }


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
