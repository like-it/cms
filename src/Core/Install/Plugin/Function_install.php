<?php

use R3m\Io\Module\Data;
use R3m\Io\Module\Parse;

function function_install(Parse $parse, Data $data){
    $object = $parse->object();
    return \LikeIt\Cms\Core\Install\Service\Install::start($object);

}
