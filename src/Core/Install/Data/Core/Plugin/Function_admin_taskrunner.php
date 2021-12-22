<?php

use Host\Subdomain\Host\Extension\Service\Jwt;
use Host\Subdomain\Host\Extension\Service\User;
use R3m\Io\App;
use R3m\Io\Config;
use R3m\Io\Exception\AuthorizationException;
use R3m\Io\Module\Data;
use R3m\Io\Module\Dir;
use R3m\Io\Module\Core;
use R3m\Io\Module\File;
use R3m\Io\Module\Parse;

/**
 * @throws Exception
 */
function function_admin_taskrunner(Parse $parse, Data $data){
    $object = $parse->object();
    return \Host\Subdomain\Host\Extension\Service\Admin::taskrunner($object);
}
