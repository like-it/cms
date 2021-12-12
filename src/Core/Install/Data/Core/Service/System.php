<?php
namespace Host\Subdomain\Host\Extension\Service;

use stdClass;
use R3m\Io\App;
use R3m\Io\Module\Core;
use R3m\Io\Module\Data;
use R3m\Io\Module\Response;

use R3m\Io\Exception\ObjectException;


class System extends Main {

    public static function update_cms(App $object, $uuid): Response
    {
        $record = [];
        $record['good'] = 'on you';

        $response = [];
        $response['node'] = $record;
        return new Response($response, Response::TYPE_JSON);
    }
}
