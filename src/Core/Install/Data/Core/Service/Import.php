<?php
namespace Host\Subdomain\Host\Extension\Service;

use R3m\Io\App;
use R3m\Io\Module\Response;

class Import extends Main {
    
    public static function import(App $object): Response
    {
        d($object->upload());
        dd($object->request());
    }
}
