<?php
namespace Host\Subdomain\Host\Extension\Service;

use stdClass;
use R3m\Io\App;
use R3m\Io\Module\Core;
use R3m\Io\Module\Data;
use R3m\Io\Module\Response;

use R3m\Io\Exception\ObjectException;


class Settings extends Main {

    public static function email_create(App $object): Response
    {
        $url = $object->config('project.dir.data') . 'Config' . $object->config('extension.json');
        $object->request('node.uuid', Core::uuid());
        $data = $object->data_read($url);
        if(!$data){
            $data = new Data();
        }
        //make record request node
        $record = $object->request('node');
        return Settings::email_put($object, $data, $record, $url);
    }

    public static function email_read(App $object, $uuid): Response
    {
        $url = $object->config('project.dir.data') . 'Config' . $object->config('extension.json');

        $data = $object->data_read($url);
        if (!$data) {
            $data = new Data();
        }
        $record = $data->get('email.' . $uuid);
        $response = [];
        $response['node'] = $record;
        return new Response($response, Response::TYPE_JSON);
    }

    public static function email_update(App $object, $uuid): Response
    {
        $url = $object->config('project.dir.data') . 'Config' . $object->config('extension.json');
        $data = $object->data_read($url);
        if(!$data){
            $data = new Data();
        }
        $record = $object->request('node');
        return Settings::email_put($object, $data, $record, $url);
    }

    public static function email_delete(App $object, $uuid): Response
    {
        $url = $object->config('project.dir.data') . 'Config' . $object->config('extension.json');

        $data = $object->data_read($url);
        if (!$data) {
            $data = new Data();
        }
        $record = $data->get('email.' . $uuid);
        $data->delete('email.' . $uuid);
        $test = $data->get('email');
        $has_default = false;
        foreach($test as $node_uuid => $node){
            if(
                property_exists($node, 'isDefault') &&
                $node->isDefault === true
            ){
                $has_default = true;
                break;
            }
        }
        if($has_default === false){
            $node = false;
            foreach($test as $node_uuid => $node){
                break;
            }
            if($node){
                $node->isDefault = true;
            }
        }
        $data->write($url);

        $response = [];
        $response['node'] = $record;
        return new Response($response, Response::TYPE_JSON);
    }

    public static function email_list(App $object): Response
    {
        $url = $object->config('project.dir.data') . 'Config' . $object->config('extension.json');

        $data = $object->data_read($url);
        if(!$data){
            $data = new Data();
        }

        $response = [];
        //make nodeList or list
        $response['nodeList'] = $data->data('email');
        return new Response($response, Response::TYPE_JSON);
    }

    public static function email_account_default(App $object): Response
    {
        // add security to controller
        $url = $object->config('project.dir.data') . 'Config' . $object->config('extension.json');

        $data = $object->data_read($url);
        if(!$data){
            $data = new Data();
        }
        $targetDefault = $data->get('email.' . $object->request('uuid'));
        if(empty($targetDefault)){
            $data = [];
            $data['error'] = 'Cannot find target default with uuid: ' . $object->request('uuid');
            return new Response(
                $data,
                Response::TYPE_JSON,
                Response::STATUS_ERROR
            );
        } else {
            $test = $data->get('email');
            foreach($test as $uuid => $record){
                unset($record->isDefault);
            }
            $data->set('email.' . $object->request('uuid') . '.isDefault', true);
            $data->write($url);

            $record = $data->get('email.' . $object->request('uuid'));
            $data = [];
            $data['node'] = $record;
            return new Response($data, Response::TYPE_JSON);
        }
    }

    /**
     * @throws ObjectException
     */
    public static function log_access_read(App $object): Response
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
            $node = Settings::log_access_line_to_object($object, $line);
            $response['nodeList'][$nr] = $node;
        }
        return new Response($response, Response::TYPE_JSON);
    }

    /**
     * @throws ObjectException
     */
    private static function log_access_line_to_object(App $object, $line=''){
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
            $array['status'] = $temp[3];
            $array['size'] = $temp[4];
            $array['referer'] = trim($temp[5], '"');
            $array['user']['agent'] = trim($temp[6], '"');
        }
        return Core::object($array, Core::OBJECT_OBJECT);
    }

    private static function email_put(App $object, Data $data, stdClass $record, $url): Response
    {
        try {
            $validate = Main::validate($object, Settings::email_getValidatorUrl($object), 'email');
            if($validate) {
                if ($validate->success === true) {
                    $test = $data->get('email');
                    if(empty($test) || Core::object_is_empty($test)){
                        $record->isDefault = true;
                    }
                    $data->set('email.' . $record->uuid, $record);
                    $data->write($url);
                    $data = [];
                    $data['node'] = $record;
                    return new Response($data, Response::TYPE_JSON);
                } else {
                    $data = [];
                    $data['error'] = $validate->test;
                    return new Response(
                        $data,
                        Response::TYPE_JSON,
                        Response::STATUS_ERROR
                    );
                }
            }
        } catch (ObjectException $exception) {
        }
    }

    private static function email_getValidatorUrl(App $object): string
    {
        return $object->config('host.dir.data') .
            'Validator' .
            $object->config('ds') .
            'Email' .
            $object->config('extension.json');
    }
}
