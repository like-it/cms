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

class Execute {

    public static function dir_create(App $object, $options=[]){
        if(!array_key_exists('name', $options)){
            return false;
        }
        $dir = new Dir();
        $dir_destination = $object->config('project.dir.root') .
            'Execute' .
            $object->config('ds');
        Dir::create($dir_destination);
        $read = $dir->read(
            $object->config('project.dir.vendor') .
            'like-it' .
            $object->config('ds') .
            'cms' .
            $object->config('ds') .
            'src' .
            $object->config('ds') .
            'Core' .
            $object->config('ds') .
            'Install' .
            $object->config('ds') .
            'Data' .
            $object->config('ds') .
            ucfirst($options['name']) .
            $object->config('ds'),
            true
        );
        foreach($read as $nr => $file){
            if($file->type === File::TYPE){
                $dir = Dir::name($file->url);
                $explode = explode($object->config('project.dir.vendor') .
                    'like-it' .
                    $object->config('ds') .
                    'cms' .
                    $object->config('ds') .
                    'src' .
                    $object->config('ds') .
                    'Core' .
                    $object->config('ds') .
                    'Install' .
                    $object->config('ds') .
                    'Data' .
                    $object->config('ds'),
                    $dir,
                    2
                );
                if(array_key_exists(1, $explode)) {
                    $target = $object->config('project.dir.root') .
                        'Execute' .
                        $object->config('ds') .
                        $explode[1];
                    if(Dir::is($target) === false){
                        Dir::create($target);
                    }
                }
                continue;
            }
            $explode = explode($object->config('project.dir.vendor') .
                'like-it' .
                $object->config('ds') .
                'cms' .
                $object->config('ds') .
                'src' .
                $object->config('ds') .
                'Core' .
                $object->config('ds') .
                'Install' .
                $object->config('ds') .
                'Data' .
                $object->config('ds') .
                $file->url,
                2
            );
            if(array_key_exists(1, $explode)){
                $target = $object->config('project.dir.root') .
                    'Execute' .
                    $object->config('ds') .
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
        $options['name'] = 'Execute';
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
            'src' .
            $object->config('ds');
        $read = $dir->read(
            $object->config('project.dir.vendor') .
            'like-it' .
            $object->config('ds') .
            'cms' .
            $object->config('ds') .
            'src' .
            $object->config('ds') .
            'Core' .
            $object->config('ds') .
            'Install' .
            $object->config('ds') .
            'Data' .
            $object->config('ds') .
            ucfirst($options['name']) .
            $object->config('ds'),
            true
        );
        foreach($read as $nr => $file){
            if($file->type === Dir::TYPE){
                continue;
            }
            $explode = explode($object->config('project.dir.vendor') .
                'like-it' .
                $object->config('ds') .
                'cms' .
                $object->config('ds') .
                'src' .
                $object->config('ds') .
                'Core' .
                $object->config('ds') .
                'Install' .
                $object->config('ds') .
                'Data' .
                $object->config('ds') .
                ucfirst($options['name']) .
                $object->config('ds'),
                $file->url,
                2
            );
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
