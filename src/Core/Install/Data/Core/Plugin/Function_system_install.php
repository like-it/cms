<?php

use Host\Subdomain\Host\Extension\Service\Jwt;
use Host\Subdomain\Host\Extension\Service\User;
use R3m\Io\App;
use R3m\Io\Config;
use R3m\Io\Module\Data;
use R3m\Io\Module\Dir;
use R3m\Io\Module\Core;
use R3m\Io\Module\File;
use R3m\Io\Module\Parse;

function function_system_install(Parse $parse, Data $data, $installation){
    dd($installation);
    $object = $parse->object();
    return \Host\Subdomain\Host\Extension\Service\System::update($object);
}
