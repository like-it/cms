<?php
namespace Host\Subdomain\Host\Extension\Service;

use stdClass;
use R3m\Io\App;
use R3m\Io\Module\Core;
use R3m\Io\Module\Data;
use R3m\Io\Module\Response;

use R3m\Io\Exception\ObjectException;


class System extends Main {

    public static function update_cms(App $object): Response
    {
        dd($_SERVER['HTTP_AUTHORIZATION']);
        $execute = '
            funda admin task "
                composer update && 
                funda cache:clear &&
                funda info all
            "
        ';
        Core::execute($execute, $output);
        if(array_key_exists(0, $output)){
            $task = $output[0];
            $dir = Dir::name($task);
            $file = File::basename($task, '.task') . '.token';
            $url = $dir . $file;
            try {
                $array = [];
                $array['output'] = $object->config('project.dir.data')  . 'Output' . $object->config('ds') . File::basename($task);
                $array['written'] = File::write($url, $token);
                $array['token'] = $token;
                return Core::object($array);
            } catch (\R3m\Io\Exception\FileWriteException | \R3m\Io\Exception\ObjectException $e) {
            }
        }



        $record = [];
        $record['good'] = 'on you';

        $response = [];
        $response['node'] = $record;
        return new Response($response, Response::TYPE_JSON);
    }
}
