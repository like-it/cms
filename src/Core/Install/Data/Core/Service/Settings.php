<?php
namespace Host\Subdomain\Host\Extension\Service;

use stdClass;
use R3m\Io\App;
use R3m\Io\Module\Core;
use R3m\Io\Module\Data;
use R3m\Io\Module\Response;

use Exception;
use R3m\Io\Exception\ObjectException;


class Settings extends Main {

    /**
     * @throws Exception
     */
    public static function domains_create(App $object): Response
    {
        $url = $object->config('project.dir.data') . 'Host' . $object->config('extension.json');
        $object->request('node.uuid', Core::uuid());
        $data = $object->data_read($url);
        if(!$data){
            $data = new Data();
        }
        //make record request node
        $object->request('node.name', $object->request('node.subdomain') ?
            $object->request('node.subdomain') . '.' .  $object->request('node.host') . '.' . $object->request('node.extension')
            :
            $object->request('node.host') . '.' . $object->request('node.extension'));
        $record = $object->request('node');

        return Settings::domains_put($object, $data, $record, $url);
    }

    public static function domains_read(App $object, $uuid): Response
    {
        $url = $object->config('project.dir.data') . 'Host' . $object->config('extension.json');

        $data = $object->data_read($url);
        if (!$data) {
            $data = new Data();
        }
        $record = $data->get($uuid);
        $response = [];
        $response['node'] = $record;
        return new Response($response, Response::TYPE_JSON);
    }

    /**
     * @throws Exception
     */
    public static function domains_update(App $object, $uuid): Response
    {
        $url = $object->config('project.dir.data') . 'Host' . $object->config('extension.json');
        $data = $object->data_read($url);
        if(!$data){
            $data = new Data();
        }
        //make record request node
        $object->request('node.name', $object->request('node.subdomain') ?
            $object->request('node.subdomain') . '.' .  $object->request('node.host') . '.' . $object->request('node.extension')
            :
            $object->request('node.host') . '.' . $object->request('node.extension'));
        $record = $object->request('node');
        return Settings::domains_put($object, $data, $record, $url);
    }

    public static function domains_delete(App $object, $uuid): Response
    {
        $url = $object->config('project.dir.data') . 'Host' . $object->config('extension.json');

        $data = $object->data_read($url);
        if (!$data) {
            $data = new Data();
        }
        $record = $data->get($uuid);
        $data->delete($uuid);
        $test = $data->get();
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

    public static function domains_list(App $object): Response
    {
        $url = $object->config('project.dir.data') . 'Host' . $object->config('extension.json');

        $data = $object->data_read($url);
        if(!$data){
            $data = new Data();
        }

        $response = [];
        $response['nodeList'] = $data->data();
        return new Response($response, Response::TYPE_JSON);
    }

    public static function domains_default(App $object): Response
    {
        // add security to controller
        $url = $object->config('project.dir.data') . 'Host' . $object->config('extension.json');
        $data = $object->data_read($url);
        if(!$data){
            $data = new Data();
        }
        $targetDefault = $data->get($object->request('uuid'));
        if(empty($targetDefault)){
            $data = [];
            $data['error'] = 'Cannot find target default with uuid: ' . $object->request('uuid');
            return new Response(
                $data,
                Response::TYPE_JSON,
                Response::STATUS_ERROR
            );
        } else {
            $test = $data->get();
            foreach($test as $uuid => $record){
                unset($record->isDefault);
            }
            $data->set($object->request('uuid') . '.isDefault', true);
            $data->write($url);

            $record = $data->get($object->request('uuid'));
            $data = [];
            $data['node'] = $record;
            return new Response($data, Response::TYPE_JSON);
        }
    }

    /**
     * @throws Exception
     */
    private static function domains_put(App $object, Data $data, stdClass $record, $url): Response
    {
        try {
            $validate = Main::validate($object, Settings::domains_getValidatorUrl($object), 'domain');
            if($validate) {
                if ($validate->success === true) {
                    $test = $data->get();
                    if(empty($test) || Core::object_is_empty($test)){
                        $record->isDefault = true;
                    } else {
                        $has_default = false;
                        foreach($test as $node){
                            if(!property_exists($node, 'isDefault')){
                                continue;
                            } else {
                                $has_default = true;
                                break;
                            }
                        }
                        if(empty($has_default)){
                            $record->isDefault = true;
                        }
                    }
                    $original = $data->get($record->uuid);
                    $data->set($record->uuid, Core::object_merge($original, $record));
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
            } else {
                throw new Exception('Cannot validate domain at: ' . Settings::domains_getValidatorUrl($object));
            }
        } catch (ObjectException $exception) {
        }
    }

    private static function domains_getValidatorUrl(App $object): string
    {
        return $object->config('host.dir.data') .
            'Validator' .
            $object->config('ds') .
            'Domains' .
            $object->config('extension.json');
    }

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

    /**
     * @throws Exception
     */
    public static function routes_create(App $object): Response
    {
        dd($object->request());
        $url = $object->config('controller.dir.data') . 'Command' . $object->config('extension.json');
        dd($url);
        $object->request('node.uuid', Core::uuid());
        $data = $object->data_read($url);
        if(!$data){
            $data = new Data();
        }
        $record = $object->request('node');

        return Settings::routes_put($object, $data, $record, $url);
    }

    public static function routes_read(App $object, $uuid): Response
    {
        $url = $object->config('project.dir.data') . 'Host' . $object->config('extension.json');

        $data = $object->data_read($url);
        if (!$data) {
            $data = new Data();
        }
        $record = $data->get($uuid);
        $response = [];
        $response['node'] = $record;
        return new Response($response, Response::TYPE_JSON);
    }

    /**
     * @throws Exception
     */
    public static function routes_update(App $object, $uuid): Response
    {
        $url = $object->config('project.dir.data') . 'Host' . $object->config('extension.json');
        $data = $object->data_read($url);
        if(!$data){
            $data = new Data();
        }
        //make record request node
        $object->request('node.name', $object->request('node.subdomain') ?
            $object->request('node.subdomain') . '.' .  $object->request('node.host') . '.' . $object->request('node.extension')
            :
            $object->request('node.host') . '.' . $object->request('node.extension'));
        $record = $object->request('node');
        return Settings::domains_put($object, $data, $record, $url);
    }

    public static function routes_delete(App $object, $uuid): Response
    {
        $url = $object->config('project.dir.data') . 'Host' . $object->config('extension.json');

        $data = $object->data_read($url);
        if (!$data) {
            $data = new Data();
        }
        $record = $data->get($uuid);
        $data->delete($uuid);
        $test = $data->get();
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

    public static function routes_list(App $object): Response
    {
        $url = $object->config('project.dir.data') . 'Host' . $object->config('extension.json');

        $data = $object->data_read($url);
        if(!$data){
            $data = new Data();
        }

        $response = [];
        $response['nodeList'] = $data->data();
        return new Response($response, Response::TYPE_JSON);
    }

    /**
     * @throws Exception
     */
    private static function routes_put(App $object, Data $data, stdClass $record, $url): Response
    {
        try {
            $validate = Main::validate($object, Settings::routes_getValidatorUrl($object), 'command');
            if($validate) {
                if ($validate->success === true) {
                    $original = $data->get($record->uuid);
                    $data->set($record->uuid, Core::object_merge($original, $record));
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
            } else {
                throw new Exception('Cannot validate domain at: ' . Settings::domains_getValidatorUrl($object));
            }
        } catch (ObjectException $exception) {
        }
    }

    private static function routes_getValidatorUrl(App $object): string
    {
        return $object->config('host.dir.data') .
            'Validator' .
            $object->config('ds') .
            'Command' .
            $object->config('extension.json');
    }

    /**
     * @throws Exception
     */
    public static function theme_create(App $object): Response
    {
        $url = $object->config('project.dir.data') . 'Theme' . $object->config('extension.json');
        $object->request('node.uuid', Core::uuid());
        $data = $object->data_read($url);
        if(!$data){
            $data = new Data();
        }
        $record = $object->request('node');

        return Settings::theme_put($object, $data, $record, $url);
    }

    public static function theme_read(App $object, $uuid): Response
    {
        $url = $object->config('project.dir.data') . 'Theme' . $object->config('extension.json');

        $data = $object->data_read($url);
        if (!$data) {
            $data = new Data();
        }
        $record = $data->get('theme.' . $uuid);
        $response = [];
        $response['node'] = $record;
        return new Response($response, Response::TYPE_JSON);
    }

    /**
     * @throws Exception
     */
    public static function theme_update(App $object, $uuid): Response
    {
        $url = $object->config('project.dir.data') . 'Theme' . $object->config('extension.json');
        $data = $object->data_read($url);
        if(!$data){
            $data = new Data();
        }
        $record = $object->request('node');
        return Settings::theme_put($object, $data, $record, $url);
    }

    public static function theme_delete(App $object, $uuid): Response
    {
        $url = $object->config('project.dir.data') . 'Theme' . $object->config('extension.json');

        $data = $object->data_read($url);
        if (!$data) {
            $data = new Data();
        }
        $record = $data->get('theme.' . $uuid);
        $data->delete('theme.' . $uuid);
        $data->write($url);

        $response = [];
        $response['node'] = $record;
        return new Response($response, Response::TYPE_JSON);
    }

    public static function theme_list(App $object): Response
    {
        $url = $object->config('project.dir.data') . 'Theme' . $object->config('extension.json');

        $data = $object->data_read($url);
        if(!$data){
            $data = new Data();
        }

        $response = [];
        $response['nodeList'] = $data->data('theme');
        return new Response($response, Response::TYPE_JSON);
    }

    /**
     * @throws Exception
     */
    private static function theme_put(App $object, Data $data, stdClass $record, $url): Response
    {
        try {
            $validate = Main::validate($object, Settings::theme_getValidatorUrl($object), 'theme');
            if($validate) {
                if ($validate->success === true) {
                    $original = $data->get('theme.' . $record->uuid);
                    $data->set('theme.' . $record->uuid, Core::object_merge($original, $record));
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
            } else {
                throw new Exception('Cannot validate theme at: ' . Settings::theme_getValidatorUrl($object));
            }
        } catch (ObjectException $exception) {
        }
    }

    private static function theme_getValidatorUrl(App $object): string
    {
        return $object->config('host.dir.data') .
            'Validator' .
            $object->config('ds') .
            'Theme' .
            $object->config('extension.json');
    }
}
