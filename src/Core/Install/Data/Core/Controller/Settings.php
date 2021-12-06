<?php
namespace Host\Subdomain\Host\Extension\Controller;

use R3m\Io\App;
use R3m\Io\Exception\ObjectException;
use R3m\Io\Module\Core;
use R3m\Io\Module\Data;
use R3m\Io\Module\File;
use R3m\Io\Module\Handler;
use R3m\Io\Module\Response;
use R3m\Io\Module\View;

use Host\Subdomain\Host\Extension\Service\Main;


class Settings extends Main {
    const DIR = __DIR__ . DIRECTORY_SEPARATOR;    

    public static function body(App $object): Response
    {
        $data = [];
        return new Response($data, Response::TYPE_JSON);
    }

    public static function export_settings(App $object): Response
    {
        $data = [];
        return new Response($data, Response::TYPE_JSON);
    }

    public static function email_settings(App $object): Response
    {
        $url = $object->config('project.dir.data') . 'Config' . $object->config('extension.json');

        $data = $object->data_read($url);
        if(!$data){
            $data = new Data();
        }

        $response = [];
        $response['email'] = $data->data('email');
        return new Response($response, Response::TYPE_JSON);
    }

    public static function email_add(App $object): Response
    {
        $url = $object->config('project.dir.data') . 'Config' . $object->config('extension.json');

        $data = $object->data_read($url);
        if(!$data){
            $data = new Data();
        }
        $record = [];
        $record['uuid'] = Core::uuid();
        $record['host'] = $object->request('host');
        $record['port'] = $object->request('port');
        $record['from']['name'] = $object->request('from.name');
        $record['from']['email'] = $object->request('from.email');
        $record['username'] = $object->request('username');
        $record['password'] = $object->request('password');

        try {
            $record = Core::object($record, Core::OBJECT_OBJECT);
            $validate = Main::validate($object, Settings::email_getValidatorUrl($object), 'email');
            dd($validate);
            $test = $data->get('email');
            if(empty($test)){
                $record->isDefault = true;
            }
            $data->set('email.' . $record->uuid, $record);
            $data->write($url);
        } catch (ObjectException $exception) {
        }
        $data = [];
        $data['node'] = $record;
        return new Response($data, Response::TYPE_JSON);
    }

    private static function email_getValidatorUrl(App $object): string
    {
        return $object->config('host.dir.data') .
            'Validator' .
            $object->config('ds') .
            'Email' .
            $object->config('extension.json');
    }

    public static function email_account_default(App $object){
        // add security
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

    public static function email_command(App $object){
        $uuid = $object->request('uuid');
        try {
            switch (Handler::method()) {
                case 'DELETE' :
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
                    break;
                case 'GET' :
                    $url = $object->config('project.dir.data') . 'Config' . $object->config('extension.json');

                    $data = $object->data_read($url);
                    if (!$data) {
                        $data = new Data();
                    }
                    $record = $data->get('email.' . $uuid);
                    $response = [];
                    $response['node'] = $record;
                    return new Response($response, Response::TYPE_JSON);
                    break;
                case 'POST' :
                    d($object->request());
                    dd('post');
                    break;
            }
        } catch (Exception $exception) {
            return $exception;
        }




    }
}
