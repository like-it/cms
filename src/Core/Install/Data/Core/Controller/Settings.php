<?php
namespace Host\Subdomain\Host\Extension\Controller;

use R3m\Io\App;
use R3m\Io\Exception\ObjectException;
use R3m\Io\Module\Core;
use R3m\Io\Module\Data;
use R3m\Io\Module\Response;
use R3m\Io\Module\View;


class Settings extends View {
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
        $data = [];
        return new Response($data, Response::TYPE_JSON);
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
            $data->set('email.' . $record->uuid, $record);
            $data->write($url);
        } catch (ObjectException $exception) {
        }
        $data = [];
        $data['node'] = $record;
        return new Response($data, Response::TYPE_JSON);
    }
}
