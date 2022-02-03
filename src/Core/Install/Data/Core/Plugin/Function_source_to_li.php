<?php

use R3m\Io\Module\Data;
use R3m\Io\Module\Parse;

function function_source_to_li(Parse $parse, Data $data, $read=''){
    $object = $parse->object();
    return \Host\Subdomain\Host\Extension\Service\Source::toLi($object, $read);
}
