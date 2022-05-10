<?php
namespace LikeIt\Cms\Core\Install\Service;

use R3m\Io\App;

use R3m\Io\Module\Core;
use R3m\Io\Module\Data;
use R3m\Io\Module\Dir;
use R3m\Io\Module\File;
use R3m\Io\Module\Parse;
use R3m\Io\Module\Parse\Token;
use R3m\Io\Module\Response;

use Exception;
use R3m\Io\Exception\ObjectException;
use R3m\Io\Module\Sort;

class Source {

    public static function dir_create(App $object, $options=[]){
        if(!array_key_exists('name', $options)){
            return false;
        }
        $dir = new Dir();
        $dir_destination = $object->config('project.dir.root') .
            ucfirst($options['name']) .
            $object->config('ds');
        $read = $dir->read(
            $object->config('controller.dir.data') . ucfirst($options['name']) . $object->config('ds'),
            true
        );
        foreach($read as $nr => $file){
            if($file->type === File::TYPE){
                continue;
            }
            $explode = explode($object->config('controller.dir.data') . ucfirst($options['name']) . $object->config('ds'), $file->url, 2);
            if(array_key_exists(1, $explode)){
                $target = $object->config('project.dir.root') .
                    'Source' . $object->config('ds') .
                    $explode[1];
                if(Dir::is($target) === false){
                    Dir::create($target);
                }
            }
        }
        return File::chown(
            $dir_destination,
            'www-data',
            'www-data',
            true
        );
    }

    public static function options(App $object, $options=[]){
        $options['name'] = 'Source';
        return $options;
    }

    /**
     * @throws \R3m\Io\Exception\FileWriteException
     */
    public static function file_create(App $object, $options=[]): bool
    {
        if (!array_key_exists('name', $options)) {
            return false;
        }
        $dir = new Dir();
        $dir_destination = $object->config('project.dir.root') .
            ucfirst($options['name']) .
            $object->config('ds');
        $read = $dir->read($object->config('controller.dir.data') . ucfirst($options['name']) . $object->config('ds'), true);
        foreach($read as $nr => $file){
            if($file->type === Dir::TYPE){
                continue;
            }
            $explode = explode($object->config('controller.dir.data') . ucfirst($options['name']) . $object->config('ds'), $file->url, 2);
            if(array_key_exists(1, $explode)){
                $destination = $dir_destination . $explode[1];
                File::copy($file->url, $destination);
            }
        }
        return File::chown(
            $dir_destination,
            'www-data',
            'www-data',
            true
        );
    }
}
