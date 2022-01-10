<?php
namespace Host\Subdomain\Host\Extension\Controller;

use Exception;
use R3m\Io\App;
use R3m\Io\Exception\ObjectException;
use R3m\Io\Module\Handler;
use R3m\Io\Module\Response;
use R3m\Io\Module\View;

use Host\Subdomain\Host\Extension\Service\Settings as Service;
use Host\Subdomain\Host\Extension\Service\Log;

class Settings extends View {
    const DIR = __DIR__ . DIRECTORY_SEPARATOR;    

    public static function body(App $object): Response
    {
        $data = [];
        return new Response($data, Response::TYPE_JSON);
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

    public static function log_error(App $object){
        try {
            return Log::error_read($object);
        } catch (ObjectException $exception){
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
}
