<?php

use R3m\Io\Module\Data;
use R3m\Io\Module\Parse;

function function_controllers_functions_amount(Parse $parse, Data $data, $node = null){
    $object = $parse->object();
    $route = $object->route();
    $controller = str_replace('/', '.', $node->url);
    if(File::extension($node->url) === 'php'){
        $controller = File::basename($controller, $object->config('extension.php'));
        $controller = str_replace('.Application.Host', 'Host', $controller);
    } else {
        throw new Exception('Cannot process files other than .php');
    }
    dd($controller);
}
