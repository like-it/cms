<?php
namespace Host\Subdomain\Host\Extension\Service;

use LikeIt\Cms\Core\Install\Service\Update;
use R3m\Io\App;
use R3m\Io\Module\Core;
use R3m\Io\Module\Dir;
use R3m\Io\Module\File;
use R3m\Io\Module\Response;

use R3m\Io\Exception\AuthorizationException;
use R3m\Io\Exception\FileWriteException;

class System extends Main {


    public static function update(App $object){
        return Update::start($object);
    }

    /**
     * @throws AuthorizationException|FileWriteException
     */
    public static function update_cms(App $object): Response
    {
        if(!array_key_exists('HTTP_AUTHORIZATION', $_SERVER)){
            throw new AuthorizationException('Authorization token missing...');
        }
        $token = substr($_SERVER['HTTP_AUTHORIZATION'], 7);
        $execute = '
            funda admin task "
                composer update && 
                funda cache:clear &&
                funda system update ' . $token .' &&
                funda admin taskrunner stop &&
                funda admin taskrunner
            "
        ';
        Core::execute($execute, $output);
        if(array_key_exists(0, $output)){
            $task = $output[0];
            $dir = Dir::name($task);
            $file = File::basename($task, '.task') . '.token';
            $url = $dir . $file;
            $record = [];
            $record['output'] = $object->config('project.dir.data')  . 'Output' . $object->config('ds') . File::basename($task);
            $record['written'] = File::write($url, $token);
            //$record['token'] = $token;
            $response = [];
            $response['node'] = $record;
            return new Response($response, Response::TYPE_JSON);
        }
    }
}
