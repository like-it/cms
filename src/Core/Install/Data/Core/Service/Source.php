<?php
namespace Host\Subdomain\Host\Extension\Service;

use R3m\Io\App;
use R3m\Io\Module\Response;

class Source extends Main
{

    public static function toLi(App $object, $read=''){
        $explode = explode("\n", $read);
        foreach($explode as $nr => $record){
            $explode[$nr] = htmlentities($record, ENT_HTML5);
        }
        $read = implode("\n", $explode);
        $url = $object->config('host.dir.data') . 'Source.json';
        $data = $object->data_read($url);
        if($data){
            foreach($data->get('replace') as $record){
                if(
                    property_exists($record, 'search') &&
                    property_exists($record, 'replace')
                )
                $read = str_replace($record->search, $record->replace, $read);
            }
        }
        $explode = explode("\n", $read);
        foreach($explode as $nr => $record){
            if(empty($record)){
                $record = '&zerowidthspace;';
            }
            $explode[$nr] = '<li><pre>' . $record .'</pre></li>';
        }
        $data = [];
        $data['content'] = implode("\n", $explode);
        return new Response($data, Response::TYPE_JSON);
    }

}