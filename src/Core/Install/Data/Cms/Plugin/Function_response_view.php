<?php

use R3m\Io\Module\Parse;
use R3m\Io\Module\Data;
use R3m\Io\Config;

function function_response_view(Parse $parse, Data $data, $options=[]){
    $object = $parse->object();

    $url = $object->config('project.dir.vendor') . 'r3m/framework/src/Plugin/Function_require.php';

    require_once $url;


    d($options);
    dd($url);





}
