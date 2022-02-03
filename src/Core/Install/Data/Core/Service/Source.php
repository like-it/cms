<?php
namespace Host\Subdomain\Host\Extension\Service;

use R3m\Io\App;
use R3m\Io\Module\Response;

class Source extends Main
{

    public static function toLi(App $object, $read=''){
        $read = htmlentities($read, ENT_HTML5);
        $explode = explode("\n", $read);
        foreach($explode as $nr => $record){
            $explode[$nr] = '<li><pre>' . $record .'</pre></li>';
        }
        $data = [];
        $data['content'] = implode("\n", $explode);
        return new Response($data, Response::TYPE_JSON);
    }

}