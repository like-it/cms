<?php
namespace Host\Subdomain\Host\Extension\Service;


use R3m\Io\App;
use R3m\Io\Module\Core;
use R3m\Io\Module\Data;
use R3m\Io\Module\Dir;
use R3m\Io\Module\File;
use R3m\Io\Module\Response;
use R3m\Io\Module\Sort;

use R3m\Io\Exception\ObjectException;

class Export extends Main {

    public static function export(App $object): Response
    {
        $export = Export::do($object);
        $zip = '';
        return new Response(
            $zip,
            Response::TYPE_FILE
        );
    }

    private static function do(App $object){
        $dir = new Dir();
        $read = $dir->read($object->config('project.dir.root'));
        dd($read);
    }
}
