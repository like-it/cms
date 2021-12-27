<?php
namespace Host\Subdomain\Host\Extension\Controller;

use R3m\Io\App;
use R3m\Io\Module\View;

use Exception;
use R3m\Io\Exception\LocateException;
use R3m\Io\Exception\UrlEmptyException;
use R3m\Io\Exception\UrlNotExistException;

class Settings extends View {
    const DIR = __DIR__ . DIRECTORY_SEPARATOR;    

    public static function main(App $object){
        $name = Settings::name(__FUNCTION__, __CLASS__, '/');
        try {
            if(App::contentType($object) == App::CONTENT_TYPE_HTML){
                $url = Settings::locate($object, 'Main/Main');
                $object->data('template.name', $name);
                $object->data('template.dir', Settings::DIR);
                $view = Settings::response($object, $url);
            } else {
                $url = Settings::locate($object, $name);
                $view = Settings::response($object, $url);
            }
            return $view;
        } catch (Exception | LocateException | UrlEmptyException | UrlNotExistException $exception){
            return $exception;
        }
    }

    public static function body(App $object){
        $name = Settings::name(__FUNCTION__, __CLASS__, '/');
        try {
            $url = Settings::locate($object, $name);
            return Settings::response($object, $url);
        } catch (Exception | LocateException | UrlEmptyException | UrlNotExistException $exception){
            return $exception;
        }
    }

    public static function basic_site_main(App $object){
        d(file_exists("/Application/Host/Cms/Funda/World/View/Settings/Basic/Site/Main.tpl"));
        dd(File::exist("/Application/Host/Cms/Funda/World/View/Settings/Basic/Site/Main.tpl"));
        $name = Settings::name(__FUNCTION__, __CLASS__, '/');
        $name = explode('.', $name);
        $name = implode('/', $name);
        try {
            if(App::contentType($object) == App::CONTENT_TYPE_HTML){
                $url = Settings::locate($object, 'Main/Main');
                $object->data('template.name', $name);
                $object->data('template.dir', Settings::DIR);
                $view = Settings::response($object, $url);
            } else {
                $url = Settings::locate($object, $name);
                $view = Settings::response($object, $url);
            }
            return $view;
        } catch (Exception | LocateException | UrlEmptyException | UrlNotExistException $exception){
            return $exception;
        }
    }

    public static function export(App $object){
        $name = Settings::name(__FUNCTION__, __CLASS__, '/');
        try {
            $url = Settings::locate($object, $name);
            return Settings::response($object, $url);
        } catch (Exception | LocateException | UrlEmptyException | UrlNotExistException $exception){
            return $exception;
        }
    }

    public static function export_settings(App $object){
        $name = Settings::name(__FUNCTION__, __CLASS__, '/');
        try {
            $url = Settings::locate($object, $name);
            return Settings::response($object, $url);
        } catch (Exception | LocateException | UrlEmptyException | UrlNotExistException $exception){
            return $exception;
        }
    }

    public static function import(App $object){
        $name = Settings::name(__FUNCTION__, __CLASS__, '/');
        try {
            $url = Settings::locate($object, $name);
            return Settings::response($object, $url);
        } catch (Exception | LocateException | UrlEmptyException | UrlNotExistException $exception){
            return $exception;
        }
    }

    public static function email_main(App $object){
        $name = Settings::name(__FUNCTION__, __CLASS__, '/');
        $name = explode('.', $name);
        $name = implode('/', $name);
        try {
            if(App::contentType($object) == App::CONTENT_TYPE_HTML){
                $url = Settings::locate($object, 'Main/Main');
                $object->data('template.name', $name);
                $object->data('template.dir', Settings::DIR);
                $view = Settings::response($object, $url);
            } else {
                $url = Settings::locate($object, $name);
                $view = Settings::response($object, $url);
            }
            return $view;
        } catch (Exception | LocateException | UrlEmptyException | UrlNotExistException $exception){
            return $exception;
        }
    }

    public static function email_main_body(App $object){
        $name = Settings::name(__FUNCTION__, __CLASS__, '/');
        try {
            $url = Settings::locate($object, $name);
            return Settings::response($object, $url);
        } catch (Exception | LocateException | UrlEmptyException | UrlNotExistException $exception){
            return $exception;
        }
    }


    public static function email_settings_body(App $object){
        $name = Settings::name(__FUNCTION__, __CLASS__, '/');
        try {
            $url = Settings::locate($object, $name);
            return Settings::response($object, $url);
        } catch (Exception | LocateException | UrlEmptyException | UrlNotExistException $exception){
            return $exception;
        }
    }

    public static function email_add_body(App $object){
        $name = Settings::name(__FUNCTION__, __CLASS__, '/');
        try {
            $url = Settings::locate($object, $name);
            return Settings::response($object, $url);
        } catch (Exception | LocateException | UrlEmptyException | UrlNotExistException $exception){
            return $exception;
        }
    }

    public static function email_edit_body(App $object){
        $name = Settings::name(__FUNCTION__, __CLASS__, '/');
        try {
            $url = Settings::locate($object, $name);
            return Settings::response($object, $url);
        } catch (Exception | LocateException | UrlEmptyException | UrlNotExistException $exception){
            return $exception;
        }
    }

    public static function logs_and_errors_main(App $object){
        $name = Settings::name(__FUNCTION__, __CLASS__, '/');
        $name = explode('.', $name);
        $name = implode('/', $name);
        try {
            $url = Settings::locate($object, $name);
            return Settings::response($object, $url);
        } catch (Exception | LocateException | UrlEmptyException | UrlNotExistException $exception){
            return $exception;
        }
    }

    public static function logs_and_errors_body(App $object){
        $name = Settings::name(__FUNCTION__, __CLASS__, '/');
        $name = explode('.', $name);
        $name = implode('/', $name);
        try {
            $url = Settings::locate($object, $name);
            return Settings::response($object, $url);
        } catch (Exception | LocateException | UrlEmptyException | UrlNotExistException $exception){
            return $exception;
        }
    }

    public static function logs_and_errors_log_access(App $object){
        $name = Settings::name(__FUNCTION__, __CLASS__, '/');
        $name = explode('.', $name);
        $name = implode('/', $name);
        $name = str_replace('Log/', 'Log.', $name);
        try {
            $url = Settings::locate($object, $name);
            return Settings::response($object, $url);
        } catch (Exception | LocateException | UrlEmptyException | UrlNotExistException $exception){
            return $exception;
        }
    }

    public static function logs_and_errors_log_error(App $object){
        $name = Settings::name(__FUNCTION__, __CLASS__, '/');
        $name = explode('.', $name);
        $name = implode('/', $name);
        $name = str_replace('Log/', 'Log.', $name);
        try {
            $url = Settings::locate($object, $name);
            return Settings::response($object, $url);
        } catch (Exception | LocateException | UrlEmptyException | UrlNotExistException $exception){
            return $exception;
        }
    }

}
