<?php
namespace Host\Subdomain\Host\Extension\Service;


use stdClass;
use R3m\Io\App;
use R3m\Io\Module\Core;
use R3m\Io\Module\Data;
use R3m\Io\Module\Dir;
use R3m\Io\Module\File;
use R3m\Io\Module\Limit;
use R3m\Io\Module\Parse;
use R3m\Io\Module\Sort;
use R3m\Io\Module\Response;

use Exception;
use R3m\Io\Exception\ObjectException;
use R3m\Io\Exception\ErrorException;
use R3m\Io\Exception\FileExistException;
use R3m\Io\Exception\FileMoveException;
use R3m\Io\Exception\FileNotExistException;
use DateTime;

class Settings extends Main {


    /**
     * @throws Exception
     * @throws ObjectException
     */
    public static function controllers_create(App $object): Response
    {
        $domain = Settings::domain_get($object);
        if(
            !property_exists($domain, 'dir') ||
            !property_exists($domain, 'uuid')
        ){
            throw new Exception('Domain dir not set...');
        }
        return Settings::controllers_put($object, $domain);
    }

    /**
     * @throws Exception
     * @throws FileNotExistException
     */
    public static function controllers_read(App $object, $name): Response
    {
        $domain = Settings::domain_get($object);
        if(
            !property_exists($domain, 'dir') ||
            !property_exists($domain, 'uuid')
        ){
            throw new Exception('Domain dir not set...');
        }
        $url = $domain->dir . $object->config('dictionary.controller') . $object->config('ds') . $name;
        if(File::exist($url)){
            $read = File::read($url);
            $record = [];
            $record['key'] = sha1($url);
            $record['name'] = $name;
            $record['url'] = $url;
            $record['content'] = $read;
            $record['domain'] = $domain;
            $response = [];
            $response['node'] = $record;
            return new Response($response, Response::TYPE_JSON);
        } else {
            throw new FileNotExistException('File (' . $url .') not found...');
        }
    }

    /**
     * @throws Exception
     * @throws FileExistException
     */
    public static function controllers_update(App $object, $name): Response
    {
        $name_old = $object->request('node.name_old');
        $class_rename = $object->request('node.class_rename');
        $domain = Settings::domain_get($object);
        if(
            !property_exists($domain, 'dir') ||
            !property_exists($domain, 'uuid')
        ){
            throw new Exception('Domain dir not set...');
        }
        if($name !== $name_old){
            $url = $domain->dir .
                'Controller' .
                $object->config('ds') .
                $name;
            $content = $object->request('node.content');
            $classname_old = File::basename($name_old, '.php');
            $classname = File::basename($name, '.php');
            if($class_rename){
                $content = str_replace([
                    $classname_old . '::',
                    'class ' . $classname_old,
                ], [
                    $classname . '::',
                    'class ' . $classname,

                ], $content);
            }
            if(File::exist($url)){
                throw new FileExistException('Target file (' . $name .') exist.');
            } else {
                File::write($url, $content);
                $url_old = $domain->dir .
                    'Controller' .
                    $object->config('ds') .
                    $name_old;
                File::delete($url_old);
            }
        } else {
            $url = $domain->dir .
                'Controller' .
                $object->config('ds') .
                $name;
            $content = $object->request('node.content');
            $classname_old = File::basename($name_old, '.php');
            $classname = File::basename($name, '.php');
            if($class_rename){
                $content = str_replace([
                    $classname_old . '::',
                    'class ' . $classname_old,
                ], [
                    $classname . '::',
                    'class ' . $classname,

                ], $content);
            }
            File::write($url, $content);
        }
        $response = [];
        $response['node'] = [
            'url' => $url,
            'name' => $name,
            'content' => $content
        ];
        return new Response($response, Response::TYPE_JSON);
    }

    /**
     * @throws Exception
     */
    public static function controllers_delete(App $object, $name): Response
    {
        $domain = Settings::domain_get($object);
        if(
            !property_exists($domain, 'dir') ||
            !property_exists($domain, 'uuid')
        ){
            throw new Exception('Domain dir not set...');
        }
        $url = $domain->dir . $object->config('dictionary.controller') . $object->config('ds') . $name;
        File::delete($url);
        $response = [];
        $response['node'] = [
            'url' => $url,
            'is' => [
                'deleted' => new DateTime('NOW')
            ]
        ];
        return new Response($response, Response::TYPE_JSON);
    }

    /**
     * @throws Exception
     */
    public static function controllers_list(App $object): Response
    {
        $domain = Settings::domain_get($object);
        if(
            !property_exists($domain, 'dir') ||
            !property_exists($domain, 'uuid')
        ){
            throw new Exception('Domain dir not set...');
        }
        $url = $domain->dir . $object->config('dictionary.controller') . $object->config('ds');
        $dir = new Dir();
        $data = new Data();
        $read = $dir->read($url, true);
        if($read){
            foreach($read as $nr => $record){
                if($record->type !== File::TYPE){
                    continue;
                }
                $record->domain = $domain->uuid;
                $key = sha1($record->url);
                $data->set($key, $record);
            }
        }
        if($object->request('page')){
            $page = (int) $object->request('page');
        } else {
            $page = 1;
        }
        $limit = Limit::LIMIT;
        $settings_url = $object->config('controller.dir.data') . 'Settings' . $object->config('extension.json');
        $settings =  $object->data_read($settings_url);
        if($settings->data('controller.default.limit')){
            $limit = $settings->data('controller.default.limit');
        }
        if($object->request('limit')){
            $limit = (int) $object->request('limit');
            if($limit > Limit::MAX){
                $limit = Limit::MAX;
            }
        }
        $response = [];
        $list = Sort::list($data->data())->with(['url' => 'ASC']);
        $response['count'] = count($list);
        $list = Limit::list($list)->with(['page' => $page, 'limit' => $limit]);
        $response['nodeList'] = $list;
        $response['limit'] = $limit;
        $response['page'] = $page;
        $response['max'] = ceil($response['count'] / $response['limit']);
        return new Response($response, Response::TYPE_JSON);
    }

    /**
     * @throws Exception
     * @throws ObjectException;
     */
    private static function controllers_put(App $object, $domain)
    {
        $validate = Main::validate($object, Settings::controllers_getValidatorUrl($object), 'controller');
        if($validate) {
            if ($validate->success === true) {
                $object->request(
                    'url',
                    $domain->dir .
                    $object->config('dictionary.controller') .
                    $object->config('ds') .
                    ucfirst($object->request('node.name')) .
                    $object->request('node.extension')
                );
                if(File::exist($object->request('url'))){
                    $data = [];
                    $data['error'] = [
                        'url' => [
                            'validate_url' => [
                                false
                            ]
                        ]
                    ];
                    return new Response(
                        $data,
                        Response::TYPE_JSON,
                        Response::STATUS_ERROR
                    );
                } else {
                    $source = $object->config('host.dir.data') .
                        'Source' .
                        $object->config('ds') .
                        'Controller' .
                        $object->config('extension.tpl');
                    $parse = new Parse($object);
                    $data = new Data($object->data());
                    $data->set('domain', $domain);
                    $content = $parse->compile(File::read($source), $data->get());
                    $dir = Dir::name($object->request('url'));
                    Dir::create($dir);
                    File::write($object->request('url'), $content);
                    $object->request('node.content', $content);
                    $data = [];
                    $data['node'] = $object->request('node');
                    return new Response($data, Response::TYPE_JSON);
                }
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
            throw new Exception('Cannot validate controller at: ' . Settings::controllers_getValidatorUrl($object));
        }
    }

    private static function controllers_getValidatorUrl(App $object): string
    {
        return $object->config('host.dir.data') .
            'Validator' .
            $object->config('ds') .
            'Controller' .
            $object->config('extension.json');
    }

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
                if(!property_exists($record, 'is')){
                    continue;
                }
                unset($record->is->default);
            }
            $data->set($object->request('uuid') . '.is.default', true);
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
    private static function domains_put(App $object, Data $data, stdClass $record, $url)
    {
        try {
            $validate = Main::validate($object, Settings::domains_getValidatorUrl($object), 'domain');
            if($validate) {
                if ($validate->success === true) {
                    $test = $data->get();
                    if(empty($test) || Core::object_is_empty($test)){
                        if(!property_exists($record, 'is')){
                            $record->is = new stdClass();
                        }
                        $record->is->default = true;
                    } else {
                        $has_default = false;
                        foreach($test as $node){
                            if(!property_exists($node, 'is')){
                                continue;
                            }
                            elseif(!property_exists($node->is, 'default')){
                                continue;
                            }
                            else {
                                $has_default = true;
                                break;
                            }
                        }
                        if(empty($has_default)){
                            if(!property_exists($record, 'is')){
                                $record->is = new stdClass();
                            }
                            $record->is->default = true;
                        }
                    }
                    $original = $data->get($record->uuid);
                    $data->set($record->uuid, Core::object_merge($original, $record));
                    $data->write($url);

                    if(property_exists($record, 'subdomain')){
                        $dir =
                            $object->config('project.dir.host') .
                            ucfirst($record->subdomain) .
                            $object->config('ds') .
                            ucfirst($record->host) .
                            $object->config('ds') .
                            ucfirst($record->extension) .
                            $object->config('ds')
                        ;
                        $destination =
                            $object->config('project.dir.host') .
                            ucfirst($record->subdomain) .
                            $object->config('ds') .
                            ucfirst($record->host) .
                            $object->config('ds') .
                            'Local' .
                            $object->config('ds')
                        ;
                    } else {
                        $dir =
                            $object->config('project.dir.host') .
                            ucfirst($record->host) .
                            $object->config('ds') .
                            ucfirst($record->extension) .
                            $object->config('ds')
                        ;
                        $destination =
                            $object->config('project.dir.host') .
                            ucfirst($record->host) .
                            $object->config('ds') .
                            'Local' .
                            $object->config('ds')
                        ;
                    }
                    Dir::create($dir);
                    if(!File::exist($destination)){
                        Dir::change(Dir::name($dir));
                        $source = ucfirst($record->extension);
                        $destination = 'Local';
                        $output = [];
                        $command = 'funda ln ' . $source . ' ' . $destination;
                        Core::execute($command, $output);
                    }
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

    /**
     * @throws Exception
     * @throws ErrorException
     */
    private static function domain_get(App $object)
    {
        $domain = false;
        $domain_uuid = $object->request('node.domain');
        if($domain_uuid){
            $url = $object->config('project.dir.data') . 'Host' . $object->config('extension.json');
            $data = $object->data_read($url);
            if($data){
                $domain = $data->get($domain_uuid);
            }
        }
        if(!$domain){
            throw new ErrorException('No domain found.');
        }
        if(
            property_exists($domain, 'subdomain') &&
            property_exists($domain, 'host') &&
            property_exists($domain, 'extension')
        ){
            $dir = $object->config('project.dir.host') .
                ucfirst($domain->subdomain) .
                $object->config('ds') .
                ucfirst($domain->host) .
                $object->config('ds') .
                ucfirst($domain->extension) .
                $object->config('ds') .
                'Data' .
                $object->config('ds');
        }
        elseif(
            property_exists($domain, 'host') &&
            property_exists($domain, 'extension')
        ){
            $dir = $object->config('project.dir.host') .
                ucfirst($domain->host) .
                $object->config('ds') .
                ucfirst($domain->extension) .
                $object->config('ds') .
                'Data' .
                $object->config('ds');
        } else {
            throw new Exception('No host & extension found in domain.');
        }
        $object->config('command.dir.data', $dir);
        $domain->dir = Dir::name($dir);
        return $domain;
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

    private static function email_put(App $object, Data $data, stdClass $record, $url)
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
        $domain = Settings::domain_get($object);
        if(
            !property_exists($domain, 'dir') ||
            !property_exists($domain, 'uuid')
        ){
            throw new Exception('Domain dir not set...');
        }
        $url = $domain->dir .
            $object->config('dictionary.data') .
            $object->config('ds') .
            'Command' .
            $object->config('extension.json');

        $route_url = $domain->dir .
            $object->config('dictionary.data') .
            $object->config('ds') .
            'Route' .
            $object->config('extension.json');

        $object->request('node.uuid', Core::uuid());
        $data = $object->data_read($url);
        if(!$data){
            $data = new Data();
        }
        $record = $object->request('node');
        if($object->request('node.path.radio') === 'automatic'){
            unset($record->path);
        } else {
            $record->path = $object->request('node.path.text');
        }
        if($object->request('node.controller.radio') === 'automatic'){
            unset($record->controller);
        } else {
            $record->controller = $object->request('node.controller.text');
        }
        unset($record->domain);
        if(empty($record->submodule)){
            unset($record->submodule);
        }
        if(empty($record->command)){
            unset($record->command);
        }
        if(empty($record->subcommand)){
            unset($record->subcommand);
        }
        $record->name = $record->module;
        if(property_exists($record, 'submodule')){
            $record->name .= '-' . $record->submodule;
        }
        if(property_exists($record, 'command')){
            $record->name .= '-' . $record->command;
        }
        if(property_exists($record, 'subcommand')){
            $record->name .= '-' . $record->subcommand;
        }
        if(
            !property_exists($record, 'submodule') &&
            !property_exists($record, 'command') &&
            !property_exists($record, 'subcommand')
        ){
            $record->name .= '-command';
        }
        return Settings::routes_put($object, $data, $record, $url, $route_url,$domain);
    }

    /**
     * @throws Exception
     */
    public static function routes_read(App $object, $uuid): Response
    {
        $domain = Settings::domain_get($object);
        if(
            !property_exists($domain, 'dir') ||
            !property_exists($domain, 'uuid')
        ){
            throw new Exception('Domain dir not set...');
        }
        $url = $domain->dir .
            $object->config('dictionary.data') .
            $object->config('ds') .
            'Command' .
            $object->config('extension.json');
        $route_url = $domain->dir .
            $object->config('dictionary.data') .
            $object->config('ds') .
            'Route' .
            $object->config('extension.json');
        $data = $object->data_read($url);
        if (!$data) {
            $data = new Data();
        }
        $route = $object->data_read($route_url);
        $record = $data->get($uuid);
        if($route){
            foreach($route->data() as $key => $node){
                if(
                    property_exists($node, 'command') &&
                    $node->command === $uuid
                ){
                    $record->route = $node;
                    $record->route->key = $key;
                    break;
                }
            }
        }
        $response = [];
        $response['node'] = $record;
        return new Response($response, Response::TYPE_JSON);
    }

    /**
     * @throws Exception
     */
    public static function routes_update(App $object, $uuid): Response
    {
        $domain = Settings::domain_get($object);
        if(
            !property_exists($domain, 'dir') ||
            !property_exists($domain, 'uuid')
        ){
            throw new Exception('Domain dir not set...');
        }
        $url = $domain->dir .
            $object->config('dictionary.data') .
            $object->config('ds') .
            'Command' .
            $object->config('extension.json');
        $route_url = $domain->dir .
            $object->config('dictionary.data') .
            $object->config('ds') .
            'Route' .
            $object->config('extension.json');
        $data = $object->data_read($url);
        if(!$data){
            $data = new Data();
        }
        $record = $object->request('node');
        if($object->request('node.path.radio') === 'automatic'){
            unset($record->path);
        } else {
            $record->path = $object->request('node.path.text');
        }
        if($object->request('node.controller.radio') === 'automatic'){
            unset($record->controller);
        } else {
            $record->controller = $object->request('node.controller.text');
        }
        unset($record->domain);
        if(empty($record->submodule)){
            unset($record->submodule);
        }
        if(empty($record->command)){
            unset($record->command);
        }
        if(empty($record->subcommand)){
            unset($record->subcommand);
        }
        $record->name = $record->module;
        if(property_exists($record, 'submodule')){
            $record->name .= '-' . $record->submodule;
        }
        if(property_exists($record, 'command')){
            $record->name .= '-' . $record->command;
        }
        if(property_exists($record, 'subcommand')){
            $record->name .= '-' . $record->subcommand;
        }
        if(
            !property_exists($record, 'submodule') &&
            !property_exists($record, 'command') &&
            !property_exists($record, 'subcommand')
        ){
            $record->name .= '-command';
        }

        return Settings::routes_put($object, $data, $record, $url, $route_url, $domain);
    }

    /**
     * @throws Exception
     */
    public static function routes_delete(App $object, $uuid): Response
    {
        $domain = Settings::domain_get($object);
        if(
            !property_exists($domain, 'dir') ||
            !property_exists($domain, 'uuid')
        ){
            throw new Exception('Domain dir not set...');
        }
        $url = $domain->dir .
            $object->config('dictionary.data') .
            $object->config('ds') .
            'Command' .
            $object->config('extension.json');
        $route_url = $domain->dir .
            $object->config('dictionary.data') .
            $object->config('ds') .
            'Route' .
            $object->config('extension.json');
        $data = $object->data_read($url);
        if (!$data) {
            $data = new Data();
        }
        $record = $data->get($uuid);
        $data->delete($uuid);
        $data->write($url);

        $response = [];
        $response['node'] = $record;
        Settings::routes_command_to_route($object, $url, $route_url, $domain);
        return new Response($response, Response::TYPE_JSON);
    }

    /**
     * @throws Exception
     * @throws ObjectException
     */
    public static function routes_list(App $object): Response
    {
        if($object->request('pagination') === 'false'){
            $object->request('pagination', false);
        }
        $domain = Settings::domain_get($object);
        if(
            !property_exists($domain, 'dir') ||
            !property_exists($domain, 'uuid')
        ){
            throw new Exception('Domain dir not set...');
        }
        $url = $domain->dir .
            $object->config('dictionary.data') .
            $object->config('ds') .
            'Command' .
            $object->config('extension.json');
        $route_url = $domain->dir .
            $object->config('dictionary.data') .
            $object->config('ds') .
            'Route' .
            $object->config('extension.json');
        $data = $object->data_read($url);
        if(!$data){
            $data = new Data();
        }
        $route = $object->data_read($route_url);
        $has_set = false;
        if($route){
            foreach($route->data() as $key => $node){
                if(
                    property_exists($node, 'command') &&
                    $data->has($node->command)
                ){
                    $has_set = true;
                    $data->set($node->command . '.route', $node);
                    $data->set($node->command . '.route.key', $key);
                    $data->set($node->command . '.domain', $domain->uuid);
                }
            }
        }
        $controller_name = $object->request('controller.name');
        $controller_name = File::basename($controller_name, $object->config('extension.php'));
        if($controller_name){
            if(!$has_set){
                throw new ErrorException('Loading routes failed. Command not set in Route');
            }
            $controller =
                'Host.' .
                ucfirst($domain->subdomain) .
                '.' .
                ucfirst($domain->host) .
                '.' .
                ucfirst($domain->extension) .
                '.' .
                ucfirst($object->config('dictionary.controller')) .
                '.' .
                $controller_name;

            foreach($data->data() as $uuid => $command){
                $node = $data->data($uuid . '.route');
                if($node){
                    if(
                        property_exists($node, 'controller') &&
                        stristr($node->controller, $controller) === false
                    ) {
                        $data->data('delete', $uuid);
                    }
                } else {
                    $data->data('delete', $uuid);
                }
            }
        }
        if($object->request('page')){
            $page = (int) $object->request('page');
        } else {
            $page = 1;
        }
        $limit = Limit::LIMIT;
        $settings_url = $object->config('controller.dir.data') . 'Settings' . $object->config('extension.json');
        $settings =  $object->data_read($settings_url);
        if($settings->data('route.default.limit')){
            $limit = $settings->data('route.default.limit');
        }
        if($object->request('limit')){
            $limit = (int) $object->request('limit');
            if($limit > Limit::MAX){
                $limit = Limit::MAX;
            }
        }
        $response = [];
        $list = Sort::list($data->data())->with(['sort' => 'ASC', 'name' => 'ASC'], true);
        if($object->request('pagination') === false){
            if($list){
                $response['count'] = count($list);
            } else {
                $response['count'] = 0;
            }
            $response['nodeList'] = $list;
        } else {
            if($list){
                $response['count'] = count($list);
                $list = Limit::list($list)->with(['page' => $page, 'limit' => $limit]);
            } else {
                $response['count'] = 0;
            }
            $response['nodeList'] = $list;
            $response['limit'] = $limit;
            $response['page'] = $page;
            $response['max'] = ceil($response['count'] / $response['limit']);
        }

        return new Response($response, Response::TYPE_JSON);
    }

    /**
     * @throws Exception
     */
    public static function routes_one_up(App $object)
    {
        $domain = Settings::domain_get($object);
        if(
            !property_exists($domain, 'dir') ||
            !property_exists($domain, 'uuid')
        ){
            throw new Exception('Domain dir not set...');
        }
        $url = $domain->dir .
            $object->config('dictionary.data') .
            $object->config('ds') .
            'Command' .
            $object->config('extension.json');
        $route_url = $domain->dir .
            $object->config('dictionary.data') .
            $object->config('ds') .
            'Route' .
            $object->config('extension.json');
        $data = $object->data_read($url);
        if (!$data) {
            $data = new Data();
        }
        $record = $data->get($object->request('node.uuid'));
        if(
            !$record ||
            !property_exists($record, 'uuid')
        ){
            $data = [];
            $data['error'] = 'Could not find source node with uuid: ' . $object->request('node.uuid');
            return new Response(
                $data,
                Response::TYPE_JSON,
                Response::STATUS_ERROR
            );
        }
        $previous = false;
        $get_previous = false;
        $list = Sort::list($data->get())->with(['sort' => 'ASC', 'name' => 'ASC']);
        foreach($list as $uuid => $node){
            if(
                $uuid == $record->uuid &&
                $previous
            ){
                $get_previous = true;
                break;
            }
            $previous = $node;
        }
        if(
            $previous &&
            $get_previous === true &&
            property_exists($previous, 'uuid') &&
            property_exists($record, 'uuid')
        ){
            $old_sort = $data->get($record->uuid . '.sort');
            $data->set($record->uuid . '.sort', $data->get($previous->uuid . '.sort'));
            $data->set($previous->uuid . '.sort', $old_sort);
            $list = Sort::list($data->get())->with(['sort' => 'ASC', 'name' => 'ASC']);
            $data = new Data();
            $sort = 1;
            foreach($list as $uuid => $node){
                $node->sort = $sort;
                $data->set($uuid, $node);
                $sort++;
            }
            $data->write($url);
            $data = [];
            $data['node'] = $record;
            $data['after'] = $previous;
            Settings::routes_command_to_route($object, $url, $route_url, $domain);
            return new Response($data, Response::TYPE_JSON);
        }
    }

    /**
     * @throws Exception
     */
    public static function routes_one_down(App $object)
    {
        $domain = Settings::domain_get($object);
        if(
            !property_exists($domain, 'dir') ||
            !property_exists($domain, 'uuid')
        ){
            throw new Exception('Domain dir not set...');
        }
        $url = $domain->dir .
            $object->config('dictionary.data') .
            $object->config('ds') .
            'Command' .
            $object->config('extension.json');
        $route_url = $domain->dir .
            $object->config('dictionary.data') .
            $object->config('ds') .
            'Route' .
            $object->config('extension.json');
        $data = $object->data_read($url);
        if (!$data) {
            $data = new Data();
        }
        $record = $data->get($object->request('node.uuid'));
        if(!$record){
            $data = [];
            $data['error'] = 'Could not find source node with uuid: ' . $object->request('node.uuid');
            return new Response(
                $data,
                Response::TYPE_JSON,
                Response::STATUS_ERROR
            );
        }
        $next = false;
        $get_next = false;
        $list = Sort::list($data->get())->with(['sort' => 'ASC', 'name' => 'ASC']);
        foreach($list as $uuid => $node){
            if($uuid == $record->uuid){
                $get_next = true;
                continue;
            }
            if($get_next){
                $next = $node;
                $get_next = false;
                break;
            }
        }
        if(
            $next &&
            property_exists($next, 'uuid') &&
            property_exists($record, 'uuid')
        ){
            $old_sort = $data->get($record->uuid . '.sort');
            $data->set($record->uuid . '.sort', $data->get($next->uuid . '.sort'));
            $data->set($next->uuid . '.sort', $old_sort);
            $list = Sort::list($data->get())->with(['sort' => 'ASC', 'name' => 'ASC']);
            $data = new Data();
            $sort = 1;
            foreach($list as $uuid => $node){
                $node->sort = $sort;
                $data->set($uuid, $node);
                $sort++;
            }
            $data->write($url);
            $data = [];
            $data['node'] = $record;
            $data['before'] = $next;
            Settings::routes_command_to_route($object, $url, $route_url, $domain);
            return new Response($data, Response::TYPE_JSON);
        }
    }

    /**
     * @throws Exception
     */
    private static function routes_put(App $object, Data $data, stdClass $record, $url, $route_url, $domain)
    {
        try {
            if(property_exists($record, 'redirect')){
                $validate = Main::validate($object, Settings::routes_getValidatorUrl($object), 'redirect');
                if($validate) {
                    if ($validate->success === true) {
                        $original = $data->get($record->uuid);
                        if(
                            is_object($original) &&
                            property_exists($original, 'sort') &&
                            empty($original->sort)
                        ){
                            $record = Settings::routes_addSort($object, $data, $record);
                        }
                        else if(empty($original)){
                            $record = Settings::routes_addSort($object, $data, $record);
                        }
                        $data->set($record->uuid, Core::object_merge($original, $record));
                        $data->write($url);
                        $data = [];
                        $data['node'] = $record;
                        Settings::routes_command_to_route($object, $url, $route_url, $domain);
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
                    throw new Exception('Cannot validate route at: ' . Settings::routes_getValidatorUrl($object));
                }
            } else {
                $validate = Main::validate($object, Settings::routes_getValidatorUrl($object), 'command');
                if($validate) {
                    if ($validate->success === true) {
                        $original = $data->get($record->uuid);
                        if(
                            is_object($original) &&
                            property_exists($original, 'sort') &&
                            empty($original->sort)
                        ){
                            $record = Settings::routes_addSort($object, $data, $record);
                        }
                        else if(empty($original)){
                            $record = Settings::routes_addSort($object, $data, $record);
                        }
                        $data->set($record->uuid, Core::object_merge($original, $record));
                        $data->write($url);
                        $data = [];
                        $data['node'] = $record;
                        Settings::routes_command_to_route($object, $url, $route_url, $domain);
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
                    throw new Exception('Cannot validate route at: ' . Settings::routes_getValidatorUrl($object));
                }
            }
        } catch (ObjectException $exception) {
        }
    }

    /**
     * @throws Exception
     */
    private static function routes_command_to_route($object, $url_command, $url_route, $domain){
        $options = [];
        if(property_exists($domain, 'subdomain')){
            $options['subdomain'] = $domain->subdomain;
        }
        if(property_exists($domain, 'host')){
            $options['host'] = $domain->host;
        }
        if(property_exists($domain, 'extension')){
            $options['extension'] = $domain->extension;
        }
        $options['route'] = $url_route;
        $options['command'] = $url_command;
        \LikeIt\Cms\Core\Install\Service\Host::command_add($object, $options);
    }

    private static function routes_getValidatorUrl(App $object): string
    {
        return $object->config('host.dir.data') .
            'Validator' .
            $object->config('ds') .
            'Command' .
            $object->config('extension.json');
    }

    private static function routes_addSort(App $object, Data $data, stdClass $record){
        $record->sort = 1;
        foreach($data->get() as $nr => $node){
            $record->sort++;
        }
        return $record;
    }

    /**
     * @throws Exception
     * @throws FileNotExistException
     */
    public static function server_settings_read(App $object, $url): Response
    {
        if(File::exist($url)){
            $name = File::basename($url);
            $read = File::read($url);
            $record = [];
            $record['key'] = sha1($url);
            $record['name'] = $name;
            $record['url'] = $url;
            $record['extension'] = File::extension($url);
            $record['content'] = base64_encode($read);
            $explode = explode($object->config('project.dir.public'), $url, 2);
            if(array_key_exists(1, $explode)){
                $record['public'] = $object->config('ds') . $explode[1];
            }
            $response = [];
            $response['node'] = $record;
            return new Response($response, Response::TYPE_JSON);
        } else {
            throw new FileNotExistException('File (' . $url .') not found...');
        }
    }

    /**
     * @throws Exception
     * @throws FileExistException
     */
    public static function server_settings_update(App $object, $url): Response
    {
        $url_old = $object->request('node.url_old');
        $domain = Settings::domain_get($object);
        if(
            !property_exists($domain, 'dir') ||
            !property_exists($domain, 'uuid')
        ){
            throw new Exception('Domain dir not set...');
        }
        if($url !== $url_old){
            $content = $object->request('node.content');
            if(File::exist($url)){
                throw new FileExistException('Target url (' . $url .') exist.');
            } else {
                $dir = dir::name($url);
                Dir::create($dir);
                File::write($url, $content);
                File::delete($url_old);
            }
        } else {
            $content = $object->request('node.content');
            File::write($url, $content);
        }
        $response = [];
        $response['node'] = [
            'url' => $url,
            'name' => File::basename($url),
            'content' => $content
        ];
        return new Response($response, Response::TYPE_JSON);
    }

    /**
     * @throws Exception
     */
    public static function server_settings_delete(App $object, $url): Response
    {
        dd($url);

        /*
        $data = $object->data_read($url);
        if (!$data) {
            $data = new Data();
        }
        $record = $data->get($uuid);
        $data->delete($uuid);
        $data->write($url);

        $response = [];
        $response['node'] = $record;
        Settings::routes_command_to_route($object, $url, $route_url, $domain);
        */
        $response = [];
        return new Response($response, Response::TYPE_JSON);
    }

    /**
     * @throws Exception
     */
    public static function server_settings_list(App $object): Response
    {
        $url = $object->config('project.dir.public');
        $dir = new Dir();
        $data = new Data();
        $read = $dir->read($url, true);
        $settings_url = $object->config('controller.dir.data') . 'Settings' . $object->config('extension.json');
        $settings =  $object->data_read($settings_url);
        $protected = [];
        if($settings->data('server.settings.protected')){
            $protected = $settings->data('server.settings.protected');
        }
        if($read){
            foreach($read as $nr => $record){
                if($record->type !== File::TYPE){
                    continue;
                }
                $record->extension = File::extension($record->url);
                if(in_array(
                    $record->url,
                    $protected
                )){
                    $record->protected = true;
                }
                $key = sha1($record->url);
                $data->set($key, $record);
            }
            if($object->request('page')){
                $page = (int) $object->request('page');
            } else {
                $page = 1;
            }
            $limit = Limit::LIMIT;
            if($settings->data('server.settings.default.limit')){
                $limit = $settings->data('server.settings.default.limit');
            }
            if($object->request('limit')){
                $limit = (int) $object->request('limit');
                if($limit > Limit::MAX){
                    $limit = Limit::MAX;
                }
            }
            $response = [];
            $list = Sort::list($data->data())->with(['url' => 'ASC']);
            if($object->request('q')){
                $q = [];
                foreach($list as $key => $record){
                    if(property_exists($record, 'url')){
                        if(stristr($record->url, $object->request('q')) !== false){
                            $q[] = $record;
                        }
                    }
                }
                $list = $q;
                $response['q'] = $object->request('q');
            }
            $response['count'] = count($list);
            $list = Limit::list($list)->with(['page' => $page, 'limit' => $limit]);
            $response['nodeList'] = $list;
            $response['limit'] = $limit;
            $response['page'] = $page;
            $response['max'] = ceil($response['count'] / $response['limit']);
            if(!empty($protected)){
                $response['protected'] = $protected;
            }
            return new Response($response, Response::TYPE_JSON);
        } else {
            $response = [];
            $response['count'] = 0;
            $response['nodeList'] = [];
            return new Response($response, Response::TYPE_JSON);
        }
    }

    /**
     * @throws Exception
     * @throws ErrorException
     * @throws FileMoveException
     */
    public static function server_settings_move_list(App $object): Response
    {
        $nodeList = $object->request('nodeList');
        $list = [];
        if(is_array($nodeList)){
            foreach($nodeList as $nr => $url){
                $basename = File::basename($url);
                if(in_array($basename, $list)){
                    throw new ErrorException('Duplicate basename...');
                }
                $list[] = File::basename($url);
            }
        }
        $overwrite = $object->request('overwrite');
        if(empty($overwrite)){
            $overwrite = false;
        } else {
            $overwrite = true;
        }
        $directory = $object->request('directory');
        $directory = trim($directory, $object->config('ds')) . $object->config('ds');
        $url = $object->config('project.dir.public') . $directory;
        $list = [];
        $error = [];
        if(is_array($nodeList)){
            if(!File::exist($url)){
                Dir::create($url);
            }
            foreach($nodeList as $nr => $source){
                $destination = $url . File::basename($source);
                if($source == $destination){
                    $list[] = $destination;
                    continue;
                }
                $move = File::move($source, $destination, $overwrite);
                $move = false;
                if($move){
                    $list[] = $destination;
                } else {
                    $error[] = $source;
                }
            }
        }
        $response = [];
        $response['nodeList'] = $list;
        if(!empty($error)){
            $response['error'] = $error;
        }
        return new Response($response, Response::TYPE_JSON);
    }

    /**
     * @throws Exception
     * @throws ObjectException;
     */
    private static function server_settings_put(App $object, $domain)
    {
        $object->request('node.extension', File::extension($object->request('node.name')));
        $validate = Main::validate($object, Settings::views_getValidatorUrl($object), 'view');
        $object->request('node.url',
            $domain->dir .
            $object->config('dictionary.view') .
            $object->config('ds') .
            $object->request('node.name')
        );
        if($validate) {
            if ($validate->success === true) {
                if(File::exist($object->request('node.url'))){
                    $data = [];
                    $data['error'] = [
                        'url' => [
                            'validate_url' => [
                                false
                            ]
                        ]
                    ];
                    return new Response(
                        $data,
                        Response::TYPE_JSON,
                        Response::STATUS_ERROR
                    );
                } else {
                    $source = $object->config('host.dir.data') .
                        'Source' .
                        $object->config('ds') .
                        'Template' .
                        '.' .
                        ucfirst(File::extension($object->request('node.name'))) .
                        $object->config('extension.tpl');
                    $parse = new Parse($object);
                    $data = new Data($object->data());
                    $data->set('domain', $domain);
                    $content = $parse->compile(File::read($source), $data->get());
                    $dir = Dir::name($object->request('node.url'));
                    if($dir){
                        Dir::create($dir);
                    }
                    File::write($object->request('node.url'), $content);
                    $object->request('node.content', $content);
                    $data = [];
                    $data['node'] = $object->request('node');
                    return new Response($data, Response::TYPE_JSON);
                }
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
            throw new Exception('Cannot validate view at: ' . Settings::views_getValidatorUrl($object));
        }
    }

    private static function server_settings_getValidatorUrl(App $object): string
    {
        return $object->config('host.dir.data') .
            'Validator' .
            $object->config('ds') .
            'Server.Settings' .
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
    private static function theme_put(App $object, Data $data, stdClass $record, $url)
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

    /**
     * @throws Exception
     * @throws ObjectException
     */
    public static function views_create(App $object): Response
    {
        $domain = Settings::domain_get($object);
        if(
            !property_exists($domain, 'dir') ||
            !property_exists($domain, 'uuid')
        ){
            throw new Exception('Domain dir not set...');
        }
        return Settings::views_put($object, $domain);
    }

    /**
     * @throws Exception
     * @throws FileNotExistException
     */
    public static function views_read(App $object, $url): Response
    {
        $domain = Settings::domain_get($object);
        if(
            !property_exists($domain, 'dir') ||
            !property_exists($domain, 'uuid')
        ){
            throw new Exception('Domain dir not set...');
        }
        if(File::exist($url)){
            $name = File::basename($url);
            $read = File::read($url);
            $record = [];
            $record['key'] = sha1($url);
            $record['name'] = $name;
            $record['url'] = $url;
            $record['content'] = $read;
            $record['domain'] = $domain;
            $response = [];
            $response['node'] = $record;
            return new Response($response, Response::TYPE_JSON);
        } else {
            throw new FileNotExistException('File (' . $url .') not found...');
        }
    }

    /**
     * @throws Exception
     * @throws FileExistException
     */
    public static function views_update(App $object, $url): Response
    {
        $url_old = $object->request('node.url_old');
        $domain = Settings::domain_get($object);
        if(
            !property_exists($domain, 'dir') ||
            !property_exists($domain, 'uuid')
        ){
            throw new Exception('Domain dir not set...');
        }
        if($url !== $url_old){
            $content = $object->request('node.content');
            if(File::exist($url)){
                throw new FileExistException('Target url (' . $url .') exist.');
            } else {
                $dir = dir::name($url);
                Dir::create($dir);
                File::write($url, $content);
                File::delete($url_old);
            }
        } else {
            $content = $object->request('node.content');
            File::write($url, $content);
        }
        $response = [];
        $response['node'] = [
            'url' => $url,
            'name' => File::basename($url),
            'content' => $content
        ];
        return new Response($response, Response::TYPE_JSON);
    }

    /**
     * @throws Exception
     */
    public static function views_delete(App $object, $url): Response
    {
        $domain = Settings::domain_get($object);
        if(
            !property_exists($domain, 'dir') ||
            !property_exists($domain, 'uuid')
        ){
            throw new Exception('Domain dir not set...');
        }
        File::delete($url);
        $response = [];
        $response['node'] = [
            'url' => $url,
            'is' => [
                'deleted' => new DateTime('NOW')
            ]
        ];
        return new Response($response, Response::TYPE_JSON);
    }

    /**
     * @throws Exception
     */
    public static function views_list(App $object): Response
    {
        $domain = Settings::domain_get($object);
        if(
            !property_exists($domain, 'dir') ||
            !property_exists($domain, 'uuid')
        ){
            throw new Exception('Domain dir not set...');
        }
        $url = $domain->dir . $object->config('dictionary.view') . $object->config('ds');
        $dir = new Dir();
        $data = new Data();
        $read = $dir->read($url, true);
        if($read){
            foreach($read as $nr => $record){
                if($record->type !== File::TYPE){
                    continue;
                }
                $record->domain = $domain->uuid;
                $key = sha1($record->url);
                $data->set($key, $record);
            }
            if($object->request('page')){
                $page = (int) $object->request('page');
            } else {
                $page = 1;
            }
            $limit = Limit::LIMIT;
            $settings_url = $object->config('controller.dir.data') . 'Settings' . $object->config('extension.json');
            $settings =  $object->data_read($settings_url);
            if($settings->data('view.default.limit')){
                $limit = $settings->data('view.default.limit');
            }
            if($object->request('limit')){
                $limit = (int) $object->request('limit');
                if($limit > Limit::MAX){
                    $limit = Limit::MAX;
                }
            }
            $response = [];
            $list = Sort::list($data->data())->with(['url' => 'ASC']);
            if($object->request('q')){
                $q = [];
                foreach($list as $key => $record){
                    if(property_exists($record, 'url')){
                        if(stristr($record->url, $object->request('q')) !== false){
                            $q[] = $record;
                        }
                    }
                }
                $list = $q;
                $response['q'] = $object->request('q');
            }
            $response['count'] = count($list);
            $list = Limit::list($list)->with(['page' => $page, 'limit' => $limit]);
            $response['nodeList'] = $list;
            $response['limit'] = $limit;
            $response['page'] = $page;
            $response['max'] = ceil($response['count'] / $response['limit']);
            return new Response($response, Response::TYPE_JSON);
        } else {
            $response = [];
            $response['count'] = 0;
            $response['nodeList'] = [];
            return new Response($response, Response::TYPE_JSON);
        }
    }

    /**
     * @throws Exception
     * @throws ObjectException;
     */
    private static function views_put(App $object, $domain)
    {
        $object->request('node.extension', File::extension($object->request('node.name')));
        $validate = Main::validate($object, Settings::views_getValidatorUrl($object), 'view');
        $object->request('node.url',
            $domain->dir .
            $object->config('dictionary.view') .
            $object->config('ds') .
            $object->request('node.name')
        );
        if($validate) {
            if ($validate->success === true) {
                if(File::exist($object->request('node.url'))){
                    $data = [];
                    $data['error'] = [
                        'url' => [
                            'validate_url' => [
                                false
                            ]
                        ]
                    ];
                    return new Response(
                        $data,
                        Response::TYPE_JSON,
                        Response::STATUS_ERROR
                    );
                } else {
                    $source = $object->config('host.dir.data') .
                        'Source' .
                        $object->config('ds') .
                        'Template' .
                        '.' .
                        ucfirst(File::extension($object->request('node.name'))) .
                        $object->config('extension.tpl');
                    $parse = new Parse($object);
                    $data = new Data($object->data());
                    $data->set('domain', $domain);
                    $content = $parse->compile(File::read($source), $data->get());
                    $dir = Dir::name($object->request('node.url'));
                    if($dir){
                        Dir::create($dir);
                    }
                    File::write($object->request('node.url'), $content);
                    $object->request('node.content', $content);
                    $data = [];
                    $data['node'] = $object->request('node');
                    return new Response($data, Response::TYPE_JSON);
                }
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
            throw new Exception('Cannot validate view at: ' . Settings::views_getValidatorUrl($object));
        }
    }

    private static function views_getValidatorUrl(App $object): string
    {
        return $object->config('host.dir.data') .
            'Validator' .
            $object->config('ds') .
            'View' .
            $object->config('extension.json');
    }
}
