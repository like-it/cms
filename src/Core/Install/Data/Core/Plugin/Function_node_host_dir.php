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

function function_node_host_dir(Parse $parse, Data $data, $uuid){
    $object = $parse->object();
    $host = $object->data_read($object->config('project.dir.data') . 'Host' . $object->config('extension.json'));
    if($host){
        $node = $host->get($uuid);
        d($node);
    }
    dd($uuid);
}
