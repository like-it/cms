<?php
namespace Host\Subdomain\Host\Extension\Service;

use R3m\Io\App;
use R3m\Io\Module\Core;
use R3m\Io\Module\Dir;
use R3m\Io\Module\File;

use Exception;
use R3m\Io\Exception\AuthorizationException;
use R3m\Io\Exception\FileWriteException;

class Source extends Main
{

    public static function toLi(App $object, $read=''){
        dd($read);
    }

}