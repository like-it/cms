<?php

use R3m\Io\Module\Data;
use R3m\Io\Module\Parse;

function function_controllers_functions_amount(Parse $parse, Data $data, $node = null){
    $object = $parse->object();
    $route = $object->route();
    dd($node);
    $controller = str_replace('/', '.', $node->url);
    if(File::extension($node->url) === 'php'){
        $controller = File::basename($controller, $object->config('extension.php'));
        $controller = str_replace('.Application.Host', 'Host', $controller);
    } else {
        throw new Exception('Cannot process files other than .php');
    }
    $count = 0;
    if($route){
        foreach($route->data() as $key => $record){
            if(property_exists($record, 'controller')){
                if(stristr($record->controller, $controller) !== false){
                    $reverse = strrev($record->controller);
                    $reverse = explode('.', $reverse, 2);
                    $test = false;
                    if(array_key_exists(1, $reverse)){
                        $test = strrev($reverse[1]);
                    }
                    if($test === $controller){
                        $count++;
                    }
                }
            }
        }
    }
    return $count;
}
