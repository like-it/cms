<?php

use R3m\Io\Module\Core;
use R3m\Io\Module\Dir;
use R3m\Io\Module\File;
use R3m\Io\Module\Parse;
use R3m\Io\Module\Data;

function function_response_view(Parse $parse, Data $data, $options=[]){
    $object = $parse->object();
    $function = $object->config('project.dir.vendor') . 'r3m/framework/src/Plugin/Function_require.php';
    require_once $function;
    $list = [];
    $list[] = $options['prefix'] .
        str_replace('-', $object->config('ds'), Core::ucfirst_sentence($options['submodule'], '-')) .
        $object->config('ds') .
        'Function' .
        $object->config('ds') .
        'Response.View.tpl'
    ;
    $list[] = $options['prefix'] .
        'Function' .
        $object->config('ds') .
        'Response.View.tpl'
    ;
    $list[] = Dir::name($options['prefix']) .
        'Function' .
        $object->config('ds') .
        'Response.View.tpl'
    ;
    $data_data = clone($data);
    $data_data->data(Core::object($options, Core::OBJECT_OBJECT));
    foreach($list as $url){
        if(File::exist($url)){
            $require = function_require($parse, $data_data, $url);
            return $require;
        }
    }
}
