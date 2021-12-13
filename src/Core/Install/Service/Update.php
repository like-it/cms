<?php
namespace LikeIt\Cms\Core\Install\Service;

use R3m\Io\App;

use Exception;
use R3m\Io\Module\Core;
use R3m\Io\Module\Data;
use R3m\Io\Module\Dir;
use R3m\Io\Module\File;
use R3m\Io\Module\Response;
use R3m\Io\Module\Validate;

class Update {

    public static function start(App $object){
        $url = $object->config('project.dir.data') . 'Host' . $object->config('extension.json');
        $host_list = $object->data_read($url);
        $result_list = [];
        foreach($host_list->data() as $uuid => $record){
            try {
                if(
                    property_exists($record, 'is') &&
                    property_exists($record->is, 'installed') &&
                    $record->is->installed === true
                ){

                    $result_list[] = Update::Host($object, [
                        'host' => $record->host,
                        'extension' => $record->extension,
                        'subdomain' => $record->subdomain
                    ]);
                }

            } catch (Exception $exception){
                return $exception;
            }
        }
        return new Response(implode("\n", $result_list), Response::TYPE_HTML);
    }

    public static function host(App $object, $options=[]){
        if(!array_key_exists('host', $options)){
            return;
        }
        if(!array_key_exists('extension', $options)){
            return;
        }
        $options = Host::options($object, $options);
        $result = [];
        try {
            $result[] = 'Creating directories...';
            Update::dir_create($object, $options);
            $result[] = 'Copying files...';
            Host::file_create($object, $options);
            $result[] = 'Adding commands...';
            Host::command_add($object, $options);
            $result[] = 'Dedouble routes...';
            Host::route_dedouble($object, $options);
            return implode("\n", $result);
        } catch (Exception $exception){
            return $exception;
        }
    }

    public static function dir_create(App $object, $options=[]){
        if(!array_key_exists('name', $options)){
            return false;
        }
        if(!array_key_exists('host', $options)){
            return false;
        }
        if(!array_key_exists('extension', $options)){
            return false;
        }
        $dir = new Dir();
        $url = $object->config('project.dir.vendor') . 'like-it/cms/src/Core/Install/Data/' . ucfirst($options['name']) . $object->config('ds');
        $read = $dir->read($url, true);
        dd($read);
        foreach($read as $nr => $file){
            if($file->type === File::TYPE){
                continue;
            }
            $explode = explode($url, $file->url, 2);
            if(array_key_exists(1, $explode)){
                if(array_key_exists('subdomain', $options)){
                    $target = $object->config('project.dir.root') .
                        'Host' . $object->config('ds') .
                        ucfirst($options['subdomain']) . $object->config('ds') .
                        ucfirst($options['host']) . $object->config('ds') .
                        ucfirst($options['extension']) . $object->config('ds') .
                        $explode[1];
                } else {
                    $target = $object->config('project.dir.root') .
                        'Host' . $object->config('ds') .
                        ucfirst($options['host']) . $object->config('ds') .
                        ucfirst($options['extension']) . $object->config('ds') .
                        $explode[1];
                }
                if(Dir::is($target) === false){
                    Dir::create($target);
                }
            }
        }
        return true;
    }
}
