<?php

use R3m\Io\Module\Parse;
use R3m\Io\Module\Data;
use R3m\Io\Config;

function function_response_view(Parse $parse, Data $data, $options=[]){
    $object = $parse->object();

    $function = $object->config('project.dir.vendor') . 'r3m/framework/src/Plugin/Function_require.php';
    require_once $function;

    $url = $options['prefix'] .
        str_replace('-', $object->config('ds'), Core::ucfirst_sentence($options['submodule'], '-')) .
        $object->config('ds') .
        'Plugin' .
        $object->config('ds') .
        'Function' .
        $object->config('ds') .
        'View.tpl'
    ;
    $data_data = clone($data);
    $data_data->data(Core::object($options, Core::OBJECT_OBJECT));
    $require = function_require($parse, $data_data, $url);

    return $require;
}
