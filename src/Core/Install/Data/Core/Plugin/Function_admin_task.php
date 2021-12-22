<?php

use R3m\Io\App;
use R3m\Io\Module\Data;
use R3m\Io\Module\Dir;
use R3m\Io\Module\Core;
use R3m\Io\Module\File;
use R3m\Io\Module\Parse;

function function_admin_task(Parse $parse, Data $data){
    $object = $parse->object();
    return \Host\Subdomain\Host\Extension\Service\Admin::task($object);
}
