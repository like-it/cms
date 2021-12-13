<?php
namespace Host\Subdomain\Host\Extension\Service;


use stdClass;
use R3m\Io\App;
use R3m\Io\Module\Core;
use R3m\Io\Module\Data;

class UserRole extends Main {

    public static function get(App $object, stdClass $user){
        $url = Role::getDataUrl($object);
        $data = $object->data_read($url);
        if(!$data){
            return false;
        }
        if(property_exists($user, 'role')){
            $result = new Data();
            foreach($user->role as $nr => $uuid){
                $result->set($uuid, $data->get($uuid));
            }
            return $result->data();
        }
        return false;
    }
}
