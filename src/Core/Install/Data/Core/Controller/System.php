<?php
namespace Host\Subdomain\Host\Extension\Controller;

use Exception;
use R3m\Io\App;
use R3m\Io\Module\Handler;
use R3m\Io\Module\Response;
use R3m\Io\Module\View;

use Host\Subdomain\Host\Extension\Service\System as Service;

class System extends View {
    const DIR = __DIR__ . DIRECTORY_SEPARATOR;    

    public static function information(App $object): Response
    {
        $data = [];
        return new Response($data, Response::TYPE_JSON);
    }

    public static function update_cms(App $object): Response
    {
        return Service::update_cms($object);
    }
}
