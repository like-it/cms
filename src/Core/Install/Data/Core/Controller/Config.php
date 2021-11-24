<?php
namespace Host\Subdomain\Host\Extension\Controller;

use R3m\Io\App;
use R3m\Io\Module\Data;
use R3m\Io\Module\Response;
use R3m\Io\Module\View;

use Exception;

class Config extends View {
    const DIR = __DIR__ . DIRECTORY_SEPARATOR;    

    public static function version(App $object): Response
    {
        if($object->request('version')){
            $url = $object->config('project.dir.data') . 'Config' . $object->config('extension.json');
            $config = $object->data_read($url);
            if(!$config){
                $config = new Data();
            }
            $config->set('version', $object->request('version'));
            $config->write($url);
            $data = [];
            $data['version'] = $config->get('version');
            return new Response($data, Response::TYPE_JSON);
        } else {
            $url = $object->config('project.dir.data') . 'Config' . $object->config('extension.json');
            $config = $object->data_read($url);
            if(!$config){
                $config = new Data();
            }
            $data = [];
            $data['version'] = $config->get('version');
            return new Response($data, Response::TYPE_JSON);
        }
    }
}
