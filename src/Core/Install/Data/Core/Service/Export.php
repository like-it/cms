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
    const FILENAME = 'Funda';

    public static function export(App $object): Response
    {
        $url = Export::do($object);
        $zip = File::read($url);
        return new Response(
            $zip,
            Response::TYPE_FILE
        );
    }

    private static function do(App $object): string
    {
        $dir = new Dir();
        $dir->ignore([
            '/Local/',
            $object->config('project.dir.root') . 'composer.json',
            $object->config('project.dir.data') . 'Cache/',
            $object->config('project.dir.data') . 'Export/',
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
        $target = Export::FILENAME . $object->config('ds') .  Export::VERSION . $object->config('ds');
        $dir = $object->config('host.dir.data'). 'Export' . $object->config('ds');
        Dir::create($dir);
        $url = $dir . Export::FILENAME . '-' . Export::VERSION . $object->config('extension.zip');
        $zip = new ZipArchive();
        $res = $zip->open($url, ZipArchive::CREATE);
        foreach($host as $file){
            $location = substr($target, 0, -1) . $file->url;
            $zip->addFile($file->url, $location);
        }
        $zip->close();
        return $url;
    }
}
