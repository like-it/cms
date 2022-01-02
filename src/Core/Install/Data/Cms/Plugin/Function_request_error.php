<?php

use R3m\Io\Module\Parse;
use R3m\Io\Module\Data;
use R3m\Io\Config;

function function_request_error(Parse $parse, Data $data, $name='', $level=0){
    $object = $parse->object();
    if($object->request('error.' . $name . '.' . $level) === false){
        return true;
    }
    return false;
}
