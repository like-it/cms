<?php

namespace Host\Subdomain\Host\Extension\Service;

use Exception;
use R3m\Io\App;
use R3m\Io\Exception\ObjectException;
use R3m\Io\Module\Core;
use R3m\Io\Module\Validate;


class Main {

    protected static function criteria(App $object){
        $criteria = [];
        foreach($object->request() as $attribute => $value){
            if($attribute === 'request'){
                continue;
            }
            if($attribute === 'page'){
                continue;
            }
            if(substr($attribute, -1, 1) === '!'){
                continue;
            }
            if($value === 'null'){
                $value = null;
            }
            if($value === 'true'){
                $value = 1;
            }
            elseif($value === 'false'){
                $value = 0;
            }
            if(is_object($value)){
                try {
                    $value = Core::object($value, Core::OBJECT_ARRAY);
                } catch (ObjectException $e) {
                }
            }
            $criteria[$attribute] = $value;
        }
        return $criteria;
    }

    protected static function page(App $object, $limit=20){
        $nr = $object->request('page');
        if(empty($nr)){
            $nr = 1;
        }
        if($nr < 1){
            $nr = 1;
        }
        return ($limit * $nr) - $limit;
    }

    public static function validate(App $object, $url){
        $data = $object->data(sha1($url));
        if($data === null){
            $data = $object->parse_read($url, sha1($url));
        }
        if($data){
            $validate = $data->data($object->request('node.type') . '.validate');
            if(empty($validate)){
                return false;
            }
            try {
                return Validate::validate($object, $validate);
            } catch (Exception $e) {
                echo $e;
            }
        }
        return false;
    }
}