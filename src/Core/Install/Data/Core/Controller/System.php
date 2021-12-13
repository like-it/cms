<?php
namespace Host\Subdomain\Host\Extension\Controller;

use Exception;
use R3m\Io\App;
use R3m\Io\Exception\AuthorizationException;
use R3m\Io\Exception\LocateException;
use R3m\Io\Exception\UrlEmptyException;
use R3m\Io\Exception\UrlNotExistException;
use R3m\Io\Module\Handler;
use R3m\Io\Module\Response;
use R3m\Io\Module\View;

use Host\Subdomain\Host\Extension\Service\System as Service;

class System extends View {
    const DIR = __DIR__ . DIRECTORY_SEPARATOR;
    const NAME = 'Update';

    const COMMAND_INFO = 'info';
    const COMMAND_UPDATE = 'update';
    const COMMAND = [
        System::COMMAND_INFO,
        System::COMMAND_UPDATE,
    ];
    const DEFAULT_COMMAND = System::COMMAND_INFO;

    const EXCEPTION_COMMAND_PARAMETER = '{$command}';
    const EXCEPTION_COMMAND = 'invalid command (' . System::EXCEPTION_COMMAND_PARAMETER . ')' . PHP_EOL;

    const INFO = [
        '{binary()} system update                  | Performs a system update from package like-it/cms',
    ];

    /**
     * @throws Exception
     */
    public static function command(App $object){
        $command = $object->parameter($object, System::NAME, 1);
        if($command === null){
            $command = System::DEFAULT_COMMAND;
        }
        if(!in_array($command, System::COMMAND)){
            $exception = str_replace(
                System::EXCEPTION_COMMAND_PARAMETER,
                $command,
                System::EXCEPTION_COMMAND
            );
            throw new Exception($exception);
        }
        return System::{$command}($object);
    }

    private static function info(App $object)
    {
        try {
            $name = System::name(__FUNCTION__, System::NAME, '/');
            $url = System::locate($object, $name);
            return System::response($object, $url);
        } catch (Exception | LocateException | UrlEmptyException | UrlNotExistException $exception) {
            return 'Command undefined.' . PHP_EOL;
        }
    }

    private static function update(App $object){
        try {
            $name = System::name(__FUNCTION__, System::NAME, '/');
            $url = System::locate($object, $name);
            return System::response($object, $url);
        } catch (Exception | LocateException | UrlEmptyException | UrlNotExistException $exception) {
            return 'Command undefined.' . PHP_EOL;
        }
    }

    public static function information(App $object): Response
    {
        $data = [];
        return new Response($data, Response::TYPE_JSON);
    }

    public static function update_cms(App $object): Exception|AuthorizationException|Response
    {
        try {
            return Service::update_cms($object);
        } catch (AuthorizationException $exception) {
            return $exception;
        }
    }
}
