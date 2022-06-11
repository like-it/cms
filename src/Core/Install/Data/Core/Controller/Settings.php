<?php
namespace Host\Subdomain\Host\Extension\Controller;

use R3m\Io\App;
use R3m\Io\Module\Handler;
use R3m\Io\Module\Response;
use R3m\Io\Module\View;

use Host\Subdomain\Host\Extension\Service\Settings as Service;
use Host\Subdomain\Host\Extension\Service\Log;

use Exception;
use R3m\Io\Exception\ObjectException;

class Settings extends View {
    const DIR = __DIR__ . DIRECTORY_SEPARATOR;    

    public static function body(App $object): Response
    {
        $data = [];
        return new Response($data, Response::TYPE_JSON);
    }

    public static function controllers_settings(App $object)
    {
        try {
            return Service::controllers_list($object);
        } catch (Exception $exception){
            return $exception;
        }
    }

    public static function controllers_add(App $object)
    {
        try {
            return Service::controllers_create($object);
        } catch (Exception $exception){
            return $exception;
        }
    }

    public static function controllers_command(App $object){
        $name = $object->request('node.name');
        try {
            switch (Handler::method()) {
                case 'DELETE' :
                    return Service::controllers_delete($object, $name);
                case 'GET' :
                    return Service::controllers_read($object, $name);
                case 'PUT' :
                    return Service::controllers_update($object, $name);
            }
        } catch (Exception $exception) {
            return $exception;
        }
    }

    public static function components_settings(App $object)
    {
        try {
            return Service::views_list($object);
        } catch (Exception $exception){
            return $exception;
        }
    }

    public static function components_add(App $object)
    {
        try {
            return Service::views_create($object);
        } catch (Exception $exception){
            return $exception;
        }
    }

    public static function components_command(App $object){
        $url = $object->request('node.url');
        $nodeList = $object->request('nodeList');
        try {
            switch (Handler::method()) {
                case 'DELETE' :
                    if($nodeList){
                        return Service::views_delete($object, $nodeList);
                    } elseif($url){
                        return Service::views_delete($object, $url);
                    }
                case 'GET' :
                    return Service::views_read($object, $url);
                case 'PUT' :
                    return Service::views_update($object, $url);
                case 'PATCH' :
                    return Service::views_rename($object, $url);
            }
        } catch (Exception $exception) {
            return $exception;
        }
    }

    public static function components_copy(App $object)
    {
        try {
            return Service::views_copy_list($object);
        } catch (Exception $exception){
            return $exception;
        }
    }

    public static function components_move(App $object)
    {
        try {
            return Service::views_move_list($object);
        } catch (Exception $exception){
            return $exception;
        }
    }

    public static function components_create(App $object)
    {
        $type = $object->request('type');
        try {
            switch (Handler::method()) {
                case 'POST':
                    switch ($type){
                        case 'Directory':
                            return Service::views_create_directory($object);
                        case 'Symlink':
                            return Service::views_create_symlink($object);
                    }
                    break;
            }
        } catch (Exception $exception){
            return $exception;
        }
    }

    public static function components_upload(App $object)
    {
        try {
            return Service::views_upload($object);
        } catch (Exception $exception){
            return $exception;
        }
    }

    public static function domains_settings(App $object): Response
    {
        return Service::domains_list($object);
    }

    /**
     * @throws Exception
     */
    public static function domains_add(App $object): Response
    {
        return Service::domains_create($object);
    }

    public static function domains_default(App $object): Response
    {
        return Service::domains_default($object);
    }

    public static function domains_command(App $object){
        $uuid = $object->request('node.uuid');
        try {
            switch (Handler::method()) {
                case 'DELETE' :
                    return Service::domains_delete($object, $uuid);
                case 'GET' :
                    return Service::domains_read($object, $uuid);
                case 'PUT' :
                    return Service::domains_update($object, $uuid);
            }
        } catch (Exception $exception) {
            return $exception;
        }
    }

    public static function email_settings(App $object): Response
    {
        return Service::email_list($object);
    }

    public static function email_add(App $object): Response
    {
        return Service::email_create($object);
    }


    public static function email_account_default(App $object): Response
    {
        return Service::email_account_default($object);
    }

    public static function email_command(App $object){
        $uuid = $object->request('node.uuid');
        try {
            switch (Handler::method()) {
                case 'DELETE' :
                    return Service::email_delete($object, $uuid);
                case 'GET' :
                    return Service::email_read($object, $uuid);
                case 'PUT' :
                    return Service::email_update($object, $uuid);
            }
        } catch (Exception $exception) {
            return $exception;
        }
    }

    public static function log_access(App $object){
        try {
            return Log::access_read($object);
        } catch (ObjectException $exception){
            return $exception;
        }
    }

    public static function log_app(App $object){
        try {
            return Log::app_read($object);
        } catch (ObjectException $exception){
            return $exception;
        }
    }

    public static function log_error(App $object){
        try {
            return Log::error_read($object);
        } catch (ObjectException $exception){
            return $exception;
        }
    }

    public static function routes_settings(App $object)
    {
        try {
            return Service::routes_list($object);
        } catch (Exception $exception){
            return $exception;
        }
    }

    public static function routes_add(App $object)
    {
        try {
            return Service::routes_create($object);
        } catch (Exception $exception){
            return $exception;
        }
    }

    public static function routes_one_up(App $object)
    {
        try {
            return Service::routes_one_up($object);
        } catch (Exception $exception){
            return $exception;
        }
    }

    public static function routes_one_down(App $object)
    {
        try {
            return Service::routes_one_down($object);
        } catch (Exception $exception){
            return $exception;
        }
    }

    public static function routes_command(App $object){
        $uuid = $object->request('node.uuid');
        try {
            switch (Handler::method()) {
                case 'DELETE' :
                    return Service::routes_delete($object, $uuid);
                case 'GET' :
                    return Service::routes_read($object, $uuid);
                case 'PUT' :
                    return Service::routes_update($object, $uuid);
            }
        } catch (Exception $exception) {
            return $exception;
        }
    }

    public static function server_settings_settings(App $object)
    {
        try {
            return Service::server_settings_list($object);
        } catch (Exception $exception){
            return $exception;
        }
    }

    public static function server_settings_command(App $object){
        $url = $object->request('node.url');
        $nodeList = $object->request('nodeList');
        try {
            switch (Handler::method()) {
                case 'DELETE' :
                    if($url){
                        return Service::server_settings_delete($object, $url);
                    }
                    elseif($nodeList){
                        return Service::server_settings_delete($object, $nodeList);
                    }
                case 'GET' :
                    return Service::server_settings_read($object, $url);
                case 'PUT' :
                    return Service::server_settings_update($object, $url);
                case 'PATCH' :
                    return Service::server_settings_rename($object);
            }
        } catch (Exception $exception) {
            return $exception;
        }
    }

    public static function server_settings_move(App $object)
    {
        try {
            return Service::server_settings_move_list($object);
        } catch (Exception $exception){
            return $exception;
        }
    }

    public static function server_settings_create(App $object)
    {
        $type = $object->request('type');
        try {
            switch (Handler::method()) {
                case 'POST':
                    switch ($type){
                        case 'Directory':
                            return Service::server_settings_create_directory($object);
                        case 'File':
                            return Service::server_settings_create_file($object);
                        case 'Symlink':
                            return Service::server_settings_create_symlink($object);
                    }
                break;
            }
        } catch (Exception $exception){
            return $exception;
        }
    }

    public static function server_settings_upload(App $object)
    {
        try {
            return Service::server_settings_upload($object);
        } catch (Exception $exception){
            return $exception;
        }
    }

    public static function theme_settings(App $object): Response
    {
        return Service::theme_list($object);
    }

    /**
     * @throws Exception
     */
    public static function theme_add(App $object): Response
    {
        return Service::theme_create($object);
    }

    public static function theme_command(App $object){
        $uuid = $object->request('node.uuid');
        try {
            switch (Handler::method()) {
                case 'DELETE' :
                    return Service::theme_delete($object, $uuid);
                case 'GET' :
                    return Service::theme_read($object, $uuid);
                case 'PUT' :
                    return Service::theme_update($object, $uuid);
            }
        } catch (Exception $exception) {
            return $exception;
        }
    }

    public static function views_settings(App $object)
    {
        try {
            return Service::views_list($object);
        } catch (Exception $exception){
            return $exception;
        }
    }

    public static function views_add(App $object)
    {
        try {
            return Service::views_create($object);
        } catch (Exception $exception){
            return $exception;
        }
    }

    public static function views_command(App $object){
        $url = $object->request('node.url');
        $nodeList = $object->request('nodeList');
        try {
            switch (Handler::method()) {
                case 'DELETE' :
                    if($nodeList){
                        return Service::views_delete($object, $nodeList);
                    } elseif($url){
                        return Service::views_delete($object, $url);
                    }
                case 'GET' :
                    return Service::views_read($object, $url);
                case 'PUT' :
                    return Service::views_update($object, $url);
                case 'PATCH' :
                    return Service::views_rename($object, $url);
            }
        } catch (Exception $exception) {
            return $exception;
        }
    }

    public static function views_copy(App $object)
    {
        try {
            return Service::views_copy_list($object);
        } catch (Exception $exception){
            return $exception;
        }
    }

    public static function views_move(App $object)
    {
        try {
            return Service::views_move_list($object);
        } catch (Exception $exception){
            return $exception;
        }
    }

    public static function views_create(App $object)
    {
        $type = $object->request('type');
        try {
            switch (Handler::method()) {
                case 'POST':
                    switch ($type){
                        case 'Directory':
                            return Service::views_create_directory($object);
                        case 'Symlink':
                            return Service::views_create_symlink($object);
                    }
                    break;
            }
        } catch (Exception $exception){
            return $exception;
        }
    }

    public static function views_upload(App $object)
    {
        try {
            return Service::views_upload($object);
        } catch (Exception $exception){
            return $exception;
        }
    }
}
