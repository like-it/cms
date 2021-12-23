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
     * @throws AuthorizationException
     */
    public static function update_cms(App $object): Response
    {
        if(!array_key_exists('HTTP_AUTHORIZATION', $_SERVER)){
            throw new AuthorizationException('Authorization token missing...');
        }
        $token = substr($_SERVER['HTTP_AUTHORIZATION'], 7);
        $execute = '
            funda admin task "
                composer update --quiet && 
                funda cache:clear &&
                funda system update ' . $token . '                
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
