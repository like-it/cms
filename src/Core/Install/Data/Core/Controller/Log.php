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

class Log extends View {
    const DIR = __DIR__ . DIRECTORY_SEPARATOR;
    const NAME = 'Log';

    const COMMAND_INFO = 'info';
    const COMMAND_ARCHIVE = 'archive';
    const COMMAND = [
        Log::COMMAND_INFO,
        Log::COMMAND_ARCHIVE,
    ];
    const DEFAULT_COMMAND = Log::COMMAND_INFO;

    const EXCEPTION_COMMAND_PARAMETER = '{{$command}}';
    const EXCEPTION_COMMAND = 'invalid command (' . log::EXCEPTION_COMMAND_PARAMETER . ')' . PHP_EOL;

    const INFO = [
        '{{binary()}} log archive /Application/log...| /app.log Zip app.log into app.{literal}{date(\'Y-m-d H:i:s\')}{/literal}.log.zip',
    ];

    /**
     * @throws Exception
     */
    public static function command(App $object){
        $command = $object->parameter($object, Log::NAME, 1);
        if($command === null){
            $command = Log::DEFAULT_COMMAND;
        }
        if(!in_array($command, Log::COMMAND)){
            $exception = str_replace(
                Log::EXCEPTION_COMMAND_PARAMETER,
                $command,
                Log::EXCEPTION_COMMAND
            );
            throw new Exception($exception);
        }
        return Log::{$command}($object);
    }

    private static function info(App $object)
    {
        try {
            $name = Log::name(__FUNCTION__, Log::NAME, '/');
            $url = Log::locate($object, $name);
            return Log::response($object, $url);
        } catch (Exception | LocateException | UrlEmptyException | UrlNotExistException $exception) {
            d($exception);
            return 'Command undefined.' . PHP_EOL;
        }
    }

    private static function archive(App $object){
        try {
            $name = Log::name(__FUNCTION__, Log::NAME, '/');
            $url = Log::locate($object, $name);
            return Log::response($object, $url);
        } catch (Exception | LocateException | UrlEmptyException | UrlNotExistException $exception) {
            d($exception);
            return 'Command undefined.' . PHP_EOL;
        }
    }
}
