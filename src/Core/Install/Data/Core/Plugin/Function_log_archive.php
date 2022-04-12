<?php

use R3m\Io\App;
use R3m\Io\Module\Data;
use R3m\Io\Module\Dir;
use R3m\Io\Module\Core;
use R3m\Io\Module\File;
use R3m\Io\Module\Parse;

function function_log_archive(Parse $parse, Data $data){
    $object = $parse->object();
    $source = $object->parameter($object, 'archive', 1);
    $explode = explode('.', File::basename($source));
    if(array_key_exists(1, $explode)){
        $destination = $object->config('project.dir.log') .
            'Archive' .
            $object->config('ds') .
            $explode[0] .
            '."{date(\'Ymd His\')}".' .
            $explode[1] .
            '.zip'
        ;
        if(array_key_exists('_', $_SERVER)){
            $dirname = \R3m\Io\Module\Dir::name($_SERVER['_']);
            $binary = str_replace($dirname, '', $_SERVER['_']);
            $execute = $binary . ' zip archive ' . $source . ' ' . $destination;
            $output = [];
            Core::execute($execute, $output);
            echo implode(PHP_EOL, $output) . PHP_EOL;
            $dir = Dir::name($destination);
            File::chown($dir, 'www-data', 'www-data', true);
            File::remove($source);
            File::touch($source);
            echo 'Log file has been reset...' . PHP_EOL;
        }




    }
}
