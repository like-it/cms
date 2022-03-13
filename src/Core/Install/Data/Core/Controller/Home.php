<?php
namespace Host\Subdomain\Host\Extension\Controller;

use R3m\Io\App;
use R3m\Io\Module\Response;
use R3m\Io\Module\View;

class Home extends View {
    const DIR = __DIR__ . DIRECTORY_SEPARATOR;    

    public static function body(App $object): Response
    {
        $data = [];
        return new Response($data, Response::TYPE_JSON);
    }
}
