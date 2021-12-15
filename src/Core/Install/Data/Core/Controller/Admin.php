<?php
/**
 * @author          Remco van der Velde
 * @since           04-01-2019
 * @copyright       (c) Remco van der Velde
 * @license         MIT
 * @version         1.0
 * @changeLog
 *  -    all
 */
namespace Host\Subdomain\Host\Extension\Controller;

use R3m\Io\App;
use R3m\Io\Module\View;

use Exception;
use R3m\Io\Exception\LocateException;
use R3m\Io\Exception\UrlEmptyException;
use R3m\Io\Exception\UrlNotExistException;

class Admin extends View{
    const NAME = 'Admin';
    const DIR = __DIR__;

    const COMMAND_INFO = 'info';
    const COMMAND_TASK = 'task';
    const COMMAND_TASKRUNNER = 'taskrunner';
    const COMMAND = [
        Admin::COMMAND_INFO,
        Admin::COMMAND_TASK,
        Admin::COMMAND_TASKRUNNER
    ];
    const DEFAULT_COMMAND = Admin::COMMAND_INFO;

    const EXCEPTION_COMMAND_PARAMETER = '{$command}';
    const EXCEPTION_COMMAND = 'invalid command (' . Admin::EXCEPTION_COMMAND_PARAMETER . ')' . PHP_EOL;

    const INFO = [
        '{binary()} admin task "<task>"            | Create admin task',
        '{binary()} admin taskrunner               | Execute admin tasks'
    ];

    public static function command(App $object){
        $command = $object->parameter($object, Admin::NAME, 1);
        if($command === null){
            $command = Admin::DEFAULT_COMMAND;
        }
        if(!in_array($command, Admin::COMMAND)){
            $exception = str_replace(
                Admin::EXCEPTION_COMMAND_PARAMETER,
                $command,
                Admin::EXCEPTION_COMMAND
            );
            throw new Exception($exception);
        }
        return Admin::{$command}($object);
    }

    private static function info(App $object)
    {
        try {
            $name = Admin::name(__FUNCTION__, Admin::NAME, '/');
            $url = Admin::locate($object, $name);
            return Admin::response($object, $url);
        } catch (Exception | LocateException | UrlEmptyException | UrlNotExistException $exception) {
            return 'Command undefined.' . PHP_EOL;
        }
    }

    private static function task(App $object){
        try {
            $name = Admin::name(__FUNCTION__, Admin::NAME, '/');
            $url = Admin::locate($object, $name);
            return Admin::response($object, $url);
        } catch (Exception | LocateException | UrlEmptyException | UrlNotExistException $exception) {
            return 'Command undefined.' . PHP_EOL;
        }
    }

    private static function taskrunner(App $object){
        $object->request('module', $object->request(0));
        $object->request('submodule', $object->request(1));
        $object->request('command', $object->request(2));
        try {
            $name = Admin::name(__FUNCTION__, Admin::NAME, '/');
            $url = Admin::locate($object, $name);
            return Admin::response($object, $url);
        } catch (Exception | LocateException | UrlEmptyException | UrlNotExistException $exception) {
            d($exception);
            return 'Command undefined.' . PHP_EOL;
        }
    }

}
