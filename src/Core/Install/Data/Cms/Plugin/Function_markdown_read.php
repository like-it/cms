<?php

use R3m\Io\Module\Data;
use R3m\Io\Module\Parse;

function function_markdown_read(Parse $parse, Data $data, $url = null){
    $object = $parse->object();
    if(File::exist($url) && File::extension($url) === 'md'){
        $read = File::read($url);
        $parsedown = new \Parsedown();
        $string = $parsedown->text($read);
        try {
            return $parse->compile($string, $data);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    } else {
        return 'File (' . $url . ') not found...';
    }

}
