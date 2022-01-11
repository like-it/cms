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

function function_system_install(Parse $parse, Data $data, stdClass $installation){
    $object = $parse->object();
    if(property_exists($installation, 'email')){
        $object->request('email', $installation->email);
    }
    if(property_exists($installation, 'password')){
        $object->request('password', $installation->password);
    }
    if(property_exists($installation, 'again')){
        $object->request('password2', $installation->again);
    }
    if(property_exists($installation, 'domain')){
        $object->request('domain', $installation->domain);
    }
    //host dir root

    return \LikeIt\Cms\Core\Install\Service\Install::start($object);
}
