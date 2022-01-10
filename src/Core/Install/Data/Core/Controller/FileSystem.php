<?php
namespace Host\Subdomain\Host\Extension\Controller;

use R3m\Io\App;
use R3m\Io\Module\View;
use R3m\Io\Module\Response;

use Host\Subdomain\Host\Extension\Service\FileSystem as Service;

use Exception;
use R3m\Io\Exception\FileNotExistException;

class FileSystem extends View {
    const DIR = __DIR__ . DIRECTORY_SEPARATOR;

    public static function read(App $object)
    {
        try {
            return Service::read($object);;
        } catch (Exception | FileNotExistException $exception){
            return $exception;
        }
    }

    public static function delete(App $object)
    {
        try {
            return Service::delete($object);;
        } catch (Exception | FileNotExistException $exception){
            return $exception;
        }
    }

    /*
    public static function write(App $object){
        $name = FileSystem::name(__FUNCTION__, __CLASS__, '/');
        try {
            $url = FileSystem::locate($object, $name);
            return FileSystem::response($object, $url);
        } catch (Exception $exception){
            return $exception;
        }
    }

    public static function delete(App $object){
        $name = FileSystem::name(__FUNCTION__, __CLASS__, '/');
        try {
            $url = FileSystem::locate($object, $name);
            return FileSystem::response($object, $url);
        } catch (Exception $exception){
            return $exception;
        }
    }

    public static function move(App $object){
        $name = FileSystem::name(__FUNCTION__, __CLASS__, '/');
        try {
            $url = FileSystem::locate($object, $name);
            return FileSystem::response($object, $url);
        } catch (Exception $exception){
            return $exception;
        }
    }

    public static function upload(App $object){
        $name = FileSystem::name(__FUNCTION__, __CLASS__, '/');
        try {
            $url = FileSystem::locate($object, $name);
            return FileSystem::response($object, $url);
        } catch (Exception $exception){
            return $exception;
        }
    }


    public static function list(App $object){
        $name = FileSystem::name(__FUNCTION__, __CLASS__, '/');
        try {
            $url = FileSystem::locate($object, $name);
            return FileSystem::response($object, $url);
        } catch (Exception $exception){
            return $exception;
        }
    }
    */
}