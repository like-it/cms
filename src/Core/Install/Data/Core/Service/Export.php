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
use ZipArchive;

class Export extends Main {
    const VERSION = '1.0.0';

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
            '/Local/',
            $object->config('project.dir.root') . 'composer.json',
            $object->config('project.dir.data') . 'Cache/',
            $object->config('project.dir.vendor'),
            $object->config('project.dir.host'),
        ]);
        $read = $dir->read($object->config('project.dir.root'), true);
        foreach ($read as $nr => $file){
            if($file->type === Dir::TYPE){
                unset($read[$nr]);
            }
            $file->extension = File::extension($file->url);
            if($file->extension !== 'json'){
                unset($read[$nr]);
            }
        }
        $dir->ignore([
            '/Local/'
        ]);
        $host = $dir->read($object->config('project.dir.host'), true);
        foreach($read as $file){
            $host[] = $file;
        }
        foreach($host as $nr => $file){
            if($file->type === Dir::TYPE){
                unset($host[$nr]);
            }
        }
        $target = 'Funda' . $object->config('ds') .  Export::VERSION . $object->config('ds');
//        $zip = new ZipArchive();
//        $res = $zip->open($target, ZipArchive::CREATE);
        foreach($host as $file){
            $location = $target . $file->url;
            dd($location)l




            $loc = explode($location, $node->url, 2);
            $loc = implode('', $loc);
            $zip->addFile($file->url, $loc);
        }







        dd($host);
    }
}
