<?php
namespace Host\Subdomain\Host\Extension\Controller;

use R3m\Io\App;
use R3m\Io\Module\Core;
use R3m\Io\Module\File;
use R3m\Io\Module\View;

use Exception;
use R3m\Io\Exception\LocateException;
use R3m\Io\Exception\UrlEmptyException;
use R3m\Io\Exception\UrlNotExistException;

class Settings extends View {
    const DIR = __DIR__ . DIRECTORY_SEPARATOR;    

    public static function main_main(App $object){
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

    public static function main_main_body(App $object){
        $name = Settings::name(__FUNCTION__, __CLASS__, '/');
        //$name = explode('.', $name);
        //$name = implode('/', $name);
        try {
            $url = Settings::locate($object, $name);
            return Settings::response($object, $url);
        } catch (Exception | LocateException | UrlEmptyException | UrlNotExistException $exception){
            return $exception;
        }
    }

    public static function basic_site_main(App $object){
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

    public static function controllers_main(App $object){
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

    public static function controllers_main_body(App $object){
        $name = Settings::name(__FUNCTION__, __CLASS__, '/');
        try {
            $url = Settings::locate($object, $name);
            return Settings::response($object, $url);
        } catch (Exception | LocateException | UrlEmptyException | UrlNotExistException $exception){
            return $exception;
        }
    }

    public static function controllers_settings_body(App $object){
        $name = Settings::name(__FUNCTION__, __CLASS__, '/');
        try {
            $url = Settings::locate($object, $name);
            return Settings::response($object, $url);
        } catch (Exception | LocateException | UrlEmptyException | UrlNotExistException $exception){
            return $exception;
        }
    }

    public static function controllers_add_controller_body(App $object){
        $name = Settings::name(__FUNCTION__, __CLASS__, '/');
        try {
            $url = Settings::locate($object, $name);
            return Settings::response($object, $url);
        } catch (Exception | LocateException | UrlEmptyException | UrlNotExistException $exception){
            return $exception;
        }
    }

    public static function controllers_edit_controller_body(App $object){
        $name = Settings::name(__FUNCTION__, __CLASS__, '/');
        try {
            $url = Settings::locate($object, $name);
            return Settings::response($object, $url);
        } catch (Exception | LocateException | UrlEmptyException | UrlNotExistException $exception){
            return $exception;
        }
    }

    public static function controllers_view_body(App $object){
        $name = Settings::name(__FUNCTION__, __CLASS__, '/');
        try {
            $url = Settings::locate($object, $name);
            return Settings::response($object, $url);
        } catch (Exception | LocateException | UrlEmptyException | UrlNotExistException $exception){
            return $exception;
        }
    }

    public static function controllers_view_routes_body(App $object){
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

    public static function export_main(App $object){
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

    public static function export_settings(App $object){
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

    public static function import_main(App $object){
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

    public static function domains_main(App $object){
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

    public static function domains_main_body(App $object){
        $name = Settings::name(__FUNCTION__, __CLASS__, '/');
        try {
            $url = Settings::locate($object, $name);
            return Settings::response($object, $url);
        } catch (Exception | LocateException | UrlEmptyException | UrlNotExistException $exception){
            return $exception;
        }
    }

    public static function domains_settings_body(App $object){
        $name = Settings::name(__FUNCTION__, __CLASS__, '/');
        try {
            $url = Settings::locate($object, $name);
            return Settings::response($object, $url);
        } catch (Exception | LocateException | UrlEmptyException | UrlNotExistException $exception){
            return $exception;
        }
    }

    public static function domains_add_body(App $object){
        $name = Settings::name(__FUNCTION__, __CLASS__, '/');
        try {
            $url = Settings::locate($object, $name);
            return Settings::response($object, $url);
        } catch (Exception | LocateException | UrlEmptyException | UrlNotExistException $exception){
            return $exception;
        }
    }

    public static function domains_edit_body(App $object){
        $name = Settings::name(__FUNCTION__, __CLASS__, '/');
        try {
            $url = Settings::locate($object, $name);
            return Settings::response($object, $url);
        } catch (Exception | LocateException | UrlEmptyException | UrlNotExistException $exception){
            return $exception;
        }
    }

    public static function routes_main(App $object){
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

    public static function routes_main_body(App $object){
        $name = Settings::name(__FUNCTION__, __CLASS__, '/');
        try {
            $url = Settings::locate($object, $name);
            return Settings::response($object, $url);
        } catch (Exception | LocateException | UrlEmptyException | UrlNotExistException $exception){
            return $exception;
        }
    }

    public static function routes_settings_body(App $object){
        $name = Settings::name(__FUNCTION__, __CLASS__, '/');
        try {
            $url = Settings::locate($object, $name);
            return Settings::response($object, $url);
        } catch (Exception | LocateException | UrlEmptyException | UrlNotExistException $exception){
            return $exception;
        }
    }

    public static function routes_add_route_body(App $object){
        $name = Settings::name(__FUNCTION__, __CLASS__, '/');
        try {
            $url = Settings::locate($object, $name);
            return Settings::response($object, $url);
        } catch (Exception | LocateException | UrlEmptyException | UrlNotExistException $exception){
            return $exception;
        }
    }

    public static function routes_add_redirect_body(App $object){
        $name = Settings::name(__FUNCTION__, __CLASS__, '/');
        try {
            $url = Settings::locate($object, $name);
            return Settings::response($object, $url);
        } catch (Exception | LocateException | UrlEmptyException | UrlNotExistException $exception){
            return $exception;
        }
    }

    public static function routes_edit_route_body(App $object){
        $name = Settings::name(__FUNCTION__, __CLASS__, '/');
        try {
            $url = Settings::locate($object, $name);
            return Settings::response($object, $url);
        } catch (Exception | LocateException | UrlEmptyException | UrlNotExistException $exception){
            return $exception;
        }
    }

    public static function routes_edit_redirect_body(App $object){
        $name = Settings::name(__FUNCTION__, __CLASS__, '/');
        try {
            $url = Settings::locate($object, $name);
            return Settings::response($object, $url);
        } catch (Exception | LocateException | UrlEmptyException | UrlNotExistException $exception){
            return $exception;
        }
    }

    public static function routes_view_body(App $object){
        $name = Settings::name(__FUNCTION__, __CLASS__, '/');
        try {
            $url = Settings::locate($object, $name);
            return Settings::response($object, $url);
        } catch (Exception | LocateException | UrlEmptyException | UrlNotExistException $exception){
            return $exception;
        }
    }

    public static function server_settings_main(App $object){
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

    public static function server_settings_main_body(App $object){
        $name = Settings::name(__FUNCTION__, __CLASS__, '/');
        try {
            $url = Settings::locate($object, $name);
            return Settings::response($object, $url);
        } catch (Exception | LocateException | UrlEmptyException | UrlNotExistException $exception){
            return $exception;
        }
    }

    public static function server_settings_settings_body(App $object){
        $name = Settings::name(__FUNCTION__, __CLASS__, '/');
        try {
            $url = Settings::locate($object, $name);
            return Settings::response($object, $url);
        } catch (Exception | LocateException | UrlEmptyException | UrlNotExistException $exception){
            return $exception;
        }
    }

    public static function server_settings_edit_template_body(App $object){
        $name = Settings::name(__FUNCTION__, __CLASS__, '/');
        try {
            $url = Settings::locate($object, $name);
            return Settings::response($object, $url);
        } catch (Exception | LocateException | UrlEmptyException | UrlNotExistException $exception){
            return $exception;
        }
    }

    public static function server_settings_view_body(App $object){
        $name = Settings::name(__FUNCTION__, __CLASS__, '/');
        try {
            $url = Settings::locate($object, $name);
            return Settings::response($object, $url);
        } catch (Exception | LocateException | UrlEmptyException | UrlNotExistException $exception){
            return $exception;
        }
    }

    public static function theme_main(App $object){
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

    public static function theme_main_body(App $object){
        $name = Settings::name(__FUNCTION__, __CLASS__, '/');
        try {
            $url = Settings::locate($object, $name);
            return Settings::response($object, $url);
        } catch (Exception | LocateException | UrlEmptyException | UrlNotExistException $exception){
            return $exception;
        }
    }

    public static function theme_settings_body(App $object){
        $name = Settings::name(__FUNCTION__, __CLASS__, '/');
        try {
            $url = Settings::locate($object, $name);
            return Settings::response($object, $url);
        } catch (Exception | LocateException | UrlEmptyException | UrlNotExistException $exception){
            return $exception;
        }
    }

    public static function theme_add_body(App $object){
        $name = Settings::name(__FUNCTION__, __CLASS__, '/');
        try {
            $url = Settings::locate($object, $name);
            return Settings::response($object, $url);
        } catch (Exception | LocateException | UrlEmptyException | UrlNotExistException $exception){
            return $exception;
        }
    }

    public static function theme_edit_body(App $object){
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
//        $name = str_replace('Log/', 'Log.', $name);
        try {
            $url = Settings::locate($object, $name);
            return Settings::response($object, $url);
        } catch (Exception | LocateException | UrlEmptyException | UrlNotExistException $exception){
            return $exception;
        }
    }

    public static function logs_and_errors_log_app(App $object){
        $name = Settings::name(__FUNCTION__, __CLASS__, '/');
        $name = explode('.', $name);
        $name = implode('/', $name);
//        $name = str_replace('Log/', 'Log.', $name);
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
//        $name = str_replace('Log/', 'Log.', $name);
        try {
            $url = Settings::locate($object, $name);
            return Settings::response($object, $url);
        } catch (Exception | LocateException | UrlEmptyException | UrlNotExistException $exception){
            return $exception;
        }
    }

    public static function views_main(App $object){
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

    public static function views_main_body(App $object){
        $name = Settings::name(__FUNCTION__, __CLASS__, '/');
        try {
            $url = Settings::locate($object, $name);
            return Settings::response($object, $url);
        } catch (Exception | LocateException | UrlEmptyException | UrlNotExistException $exception){
            return $exception;
        }
    }

    public static function views_settings_body(App $object){
        $name = Settings::name(__FUNCTION__, __CLASS__, '/');
        try {
            $url = Settings::locate($object, $name);
            return Settings::response($object, $url);
        } catch (Exception | LocateException | UrlEmptyException | UrlNotExistException $exception){
            return $exception;
        }
    }

    public static function views_add_template_body(App $object){
        $name = Settings::name(__FUNCTION__, __CLASS__, '/');
        try {
            $url = Settings::locate($object, $name);
            return Settings::response($object, $url);
        } catch (Exception | LocateException | UrlEmptyException | UrlNotExistException $exception){
            return $exception;
        }
    }

    public static function views_edit_template_body(App $object){
        $name = Settings::name(__FUNCTION__, __CLASS__, '/');
        try {
            $url = Settings::locate($object, $name);
            return Settings::response($object, $url);
        } catch (Exception | LocateException | UrlEmptyException | UrlNotExistException $exception){
            return $exception;
        }
    }

    public static function views_view_body(App $object){
        $name = Settings::name(__FUNCTION__, __CLASS__, '/');
        try {
            $url = Settings::locate($object, $name);
            return Settings::response($object, $url);
        } catch (Exception | LocateException | UrlEmptyException | UrlNotExistException $exception){
            return $exception;
        }
    }

    public static function views_view_routes_body(App $object){
        $name = Settings::name(__FUNCTION__, __CLASS__, '/');
        try {
            $url = Settings::locate($object, $name);
            return Settings::response($object, $url);
        } catch (Exception | LocateException | UrlEmptyException | UrlNotExistException $exception){
            return $exception;
        }
    }

}
