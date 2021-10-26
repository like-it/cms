<?php
namespace Host\Subdomain\Host\Extension\Controller;


use R3m\Io\App;
use R3m\Io\Module\Handler;
use R3m\Io\Module\View;
use Host\Subdomain\Host\Extension\Service\Export as Service;

use Exception;
use R3m\Io\Exception\LocateException;
use R3m\Io\Exception\UrlEmptyException;
use R3m\Io\Exception\UrlNotExistException;

class Export extends View {
    const DIR = __DIR__ . DIRECTORY_SEPARATOR;    

    public static function command(App $object){
      return Service::export($object);
    }
}
