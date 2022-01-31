<?php

use R3m\Io\Module\Data;
use R3m\Io\Module\Parse;

function function_markdown_read(Parse $parse, Data $data, $url = null){
    $object = $parse->object();
    dd(File::extension($url));
    if(File::exist($url) && File::extension($url) === '.md'){
        $read = File::read($url);
        $parsedown = new \Parsedown();
        return $parsedown->text($read);
    } else {
        return 'File not found...';
    }

}
