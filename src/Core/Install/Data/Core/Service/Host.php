<?php
namespace Host\Subdomain\Host\Extension\Service;

use R3m\Io\App;
use R3m\Io\Config;
use R3m\Io\Module\Core;
use R3m\Io\Module\File;

class Host extends Main
{

    public static function dir_root(App $object){
        $host_dir_root = $object->config('host.dir.root');
        if(empty($host_dir_root)){
            $read = File::read($object->config('project.dir.data') . 'Host' . $object->config('extension.json'));
            if($read){
                $read = Core::object($read);
                foreach($read as $uuid => $node){
                    if(
                        property_exists($node, 'is') &&
                        property_exists($node->is, 'core')
                    ){
                        $sentence = Core::ucfirst_sentence(
                            $node->subdomain .
                            $object->config('ds') .
                            $node->host .
                            $object->config('ds') .
                            $node->extension .
                            $object->config('ds'),
                            $object->config('ds')
                        );
                        $sentence = ltrim($sentence, $object->config('ds'));
                        $value =
                            $object->config('project.dir.root') .
                            $object->config(Config::DICTIONARY . '.' . Config::HOST) .
                            $object->config('ds') .
                            $sentence;

                        $object->config('host.dir.root', $value);
                    }
                }
            }
        }
    }

}