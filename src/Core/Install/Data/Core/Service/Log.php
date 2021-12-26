<?php
namespace Host\Subdomain\Host\Extension\Service;

use stdClass;
use R3m\Io\App;
use R3m\Io\Module\Core;
use R3m\Io\Module\Data;
use R3m\Io\Module\Response;

use R3m\Io\Exception\ObjectException;


class Log extends Main {

    /**
     * @throws ObjectException
     */
    public static function access_read(App $object): Response
    {
        $url = $object->config('project.dir.root') .
            'Log' .
            $object->config('ds') .
            'access' .
            $object->config('extension.log');
        $command = 'tail -100 ' . $url;
        $output = [];
        $response = [];
        $response['nodeList'] = [];
        Core::execute($command, $output);
        foreach($output as $nr => $line){
            $node = Log::access_line_to_object($object, $line);
            $response['nodeList'][$nr] = $node;
        }
        return new Response($response, Response::TYPE_JSON);
    }

    /**
     * @throws ObjectException
     */
    public static function error_read(App $object): Response
    {
        $url = $object->config('project.dir.root') .
            'Log' .
            $object->config('ds') .
            'error' .
            $object->config('extension.log');
        $command = 'tail -100 ' . $url;
        $output = [];
        $response = [];
        $response['nodeList'] = [];
        Core::execute($command, $output);
        dd($output);
        foreach($output as $nr => $line){
            $node = Log::error_line_to_object($object, $line);
            $response['nodeList'][$nr] = $node;
        }
        return new Response($response, Response::TYPE_JSON);
    }

    /**
     * @throws ObjectException
     */
    private static function access_line_to_object(App $object, $line=''): stdClass
    {
        $explode = explode('"', $line, 2);
        $array = [];
        if(array_key_exists(1, $explode)){
            $temp = explode('-', $explode[0]);
            $array['ipAddress'] = rtrim($temp[0], ' ');
            $array['user'] = [];
            $array['user']['id'] = trim($temp[1], ' ');
            $time = rtrim(ltrim($temp[2], ' ['), ' ]');
            $array['time'] = strtotime($time);
            $array['date'] = date('Y-m-d H:i:s', $array['time']) . ' +0000';
            $temp = explode(' ', $explode[1], 7);
            $array['method'] = $temp[0];
            $array['path'] = $temp[1];
            $array['protocol'] = $temp[2];
            $array['status'] = $temp[3] + 0;
            $array['size'] = $temp[4] + 0;
            $array['referer'] = trim($temp[5], '"');
            $array['user']['agent'] = trim($temp[6], '"');
        }
        return Core::object($array, Core::OBJECT_OBJECT);
    }
}
