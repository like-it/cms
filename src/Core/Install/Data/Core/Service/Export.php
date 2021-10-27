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
        $dir->ignore([
            '/Application/composer.json',
            '/Local/',
            '/Data/Cache/',
            '/vendor/'
        ]);
        $read = $dir->read($object->config('project.dir.root'), true);
        foreach ($read as $nr => $file){
            if($file->type == Dir::TYPE){
                unset($read[$nr]);
            }
            $file->extension = File::extension($file->url);
            if($file->extension !== 'json'){
                unset($read[$nr]);
            }
        }
        dd($read);
    }
}
