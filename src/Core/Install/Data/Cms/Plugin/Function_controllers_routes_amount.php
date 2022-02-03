<?php

use R3m\Io\Module\Data;
use R3m\Io\Module\Parse;

function function_controllers_routes_amount(Parse $parse, Data $data, $node = null){
    $object = $parse->object();
    dd($node);
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
