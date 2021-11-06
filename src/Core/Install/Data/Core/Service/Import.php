<?php
namespace Host\Subdomain\Host\Extension\Service;

use R3m\Io\App;
use R3m\Io\Module\Response;

class Import extends Main {
    const VERSION = '1.0.0';
    const FILENAME = 'Funda';

    public static function import(App $object): Response
    {
        dd($object->request());
    }
}
