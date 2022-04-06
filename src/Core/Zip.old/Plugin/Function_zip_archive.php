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

function function_zip_archive(Parse $parse, Data $data, stdClass $installation){
    $object = $parse->object();
    dd($object->request());
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
    if(property_exists($installation, 'port')){
        $object->request('port', $installation->port);
    }
    //host dir root
    $result = \LikeIt\Cms\Core\Install\Service\Install::start($object);
    if(posix_getuid() === 0){
        $command = 'chown www-data:www-data /Application/Host/ -R';
        Core::execute($command);
        $command = 'chown www-data:www-data /Application/Data/ -R';
        Core::execute($command);
    }
    return $result;
}
