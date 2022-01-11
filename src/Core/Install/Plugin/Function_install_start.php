<?php

use R3m\Io\Module\Data;
use R3m\Io\Module\Parse;
use R3m\Io\Module\Core;

function function_install_start(Parse $parse, Data $data){
    $object = $parse->object();
    $result = \LikeIt\Cms\Core\Install\Service\Install::start($object);
    $command = 'chown www-data:www-data /Application/Host/ -R';
    Core::execute($command);
    $command = 'chown www-data:www-data /Application/Data/ -R';
    Core::execute($command);
}
