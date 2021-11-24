<?php
namespace Host\Subdomain\Host\Extension\Controller;

use R3m\Io\App;
use R3m\Io\Module\View;
use Host\Subdomain\Host\Extension\Service\Import as Service;

class Import extends View {
    const DIR = __DIR__ . DIRECTORY_SEPARATOR;    

    public static function command(App $object){
      return Service::import($object);
    }
}
