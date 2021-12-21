<?php
namespace LikeIt\Cms\Core\Install\Service;

use R3m\Io\App;

use Exception;
use R3m\Io\Module\Core;
use R3m\Io\Module\Data;
use R3m\Io\Module\Dir;
use R3m\Io\Module\File;
use R3m\Io\Module\Parse;
use R3m\Io\Module\Response;
use R3m\Io\Module\Validate;

class Update {

    public static function start(App $object){
        if(Update::hasUpdate($object)){
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
            $result_list[] = 'Update complete...' . PHP_EOL;
            $result_list[] = Update::installed($object);
            return new Response(implode(PHP_EOL, $result_list), Response::TYPE_HTML);
        } else {
            $result = 'Nothing to update...' . PHP_EOL;
            return new Response($result, Response::TYPE_HTML);
        }
    }

    private static function getInstalledData(App $object){
        $command = 'composer show -P';
        $output = [];
        Core::execute($command, $output);
        $list = [];
        foreach($output as $nr => $line){
            $explode = explode(' /', $line, 2);
            if(array_key_exists(1, $explode)){
                $record = [];
                $record['name'] = trim($explode[0], ' ');
                $record['path'] = '/' . trim($explode[1], ' ');
                $list[] = $record;
            }
        }
        $command = 'composer show';
        $output = [];
        Core::execute($command, $output);
        foreach($output as $nr => $line){
            $explode = explode($list[$nr]['name'], $line);
            if(array_key_exists(1, $explode)){
                $temp = explode(' ', trim($explode[1], ' '), 3);
                if(array_key_exists(2, $temp)){
                    if(empty($temp[1])){
                        $list[$nr]['version'] = $temp[0];
                    } else {
                        $list[$nr]['version'] = $temp[0] . ' ' . $temp[1];
                    }
                    $list[$nr]['description'] = trim($temp[2], ' ');
                }
            }
        }
        return $list;
    }

    public static function hasUpdate(App $object): bool
    {
        $list = Update::getInstalledData($object);
        $url = $object->config('project.dir.data') . 'Installed' . $object->config('extension.json');
        $data = $object->data_read($url);
        if(!$data){
            return true;
        }
        $set = [];
        foreach($data->get() as $node_nr => $node){
            $set[$node->name] = $node;
        }
        foreach($list as $nr => $record){
            if(
                !empty($set[$record['name']]) &&
                $set[$record['name']]->version != $record['version']
            ){
                return true;
            }
        }
        return false;
    }

    public static function installed(App $object){
        $list = Update::getInstalledData($object);
        $url = $object->config('project.dir.data') . 'Installed' . $object->config('extension.json');
        $data = new Data($list);
        $data->write($url);
        $result = [];
        foreach($data->get() as $node){
            dd($node);
        }
    }

    public static function host(App $object, $options=[]){
        if(!array_key_exists('host', $options)){
            return;
        }
        if(!array_key_exists('extension', $options)){
            return;
        }
        $options = Host::options($object, $options);
        if(!array_key_exists('name', $options)){
            return;
        }
        $result = [];
        try {
            $result[] = 'Creating (' . $options['name'] . ') directories...';
            Update::dir_create($object, $options);
            $result[] = 'Copying (' . $options['name'] . ') files...';
            Update::file_create($object, $options);
            $result[] = 'Adding (' . $options['name'] . ') commands...';
            Host::command_add($object, $options);
            $result[] = 'Dedouble (' . $options['name'] . ') routes...';
            Host::route_dedouble($object, $options);
            $result[] = '';
            return implode("\n", $result);
        } catch (Exception $exception){
            return $exception;
        }
    }

    public static function dir_create(App $object, $options=[]): bool
    {
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

    /**
     * @throws \R3m\Io\Exception\FileWriteException
     */
    public static function file_create(App $object, $options=[]): bool
    {
        if (!array_key_exists('name', $options)) {
            return false;
        }
        if (!array_key_exists('host', $options)) {
            return false;
        }
        if (!array_key_exists('extension', $options)) {
            return false;
        }
        $dir = new Dir();
        $url = $object->config('project.dir.vendor') . 'like-it/cms/src/Core/Install/Data/' . ucfirst($options['name']) . $object->config('ds');
        $read = $dir->read($url, true);
        foreach($read as $nr => $file){
            if($file->type === Dir::TYPE){
                continue;
            }
            $explode = explode($url, $file->url, 2);
            if(array_key_exists(1, $explode)){
                if(array_key_exists('subdomain', $options)) {
                    $target = $object->config('project.dir.root') .
                        'Host' . $object->config('ds') .
                        ucfirst($options['subdomain']) . $object->config('ds') .
                        ucfirst($options['host']) . $object->config('ds') .
                        ucfirst($options['extension']) . $object->config('ds') .
                        $explode[1];
                    if(File::Extension($file->url) === 'php'){
                        $read = File::read($file->url);
                        $read = str_replace([
                            '\\Subdomain\\Host\\Extension\\'
                        ],[
                            '\\'. ucfirst($options['subdomain']) . '\\' . ucfirst($options['host']) . '\\' . ucfirst($options['extension']) . '\\'
                        ], $read);
                        File::write($target, $read);
                    }
                    elseif(stristr($file->url, ucfirst($options['name']) . '/Data/Route.json') !== false){
                        $read = $object->data_read($file->url);
                        $parse = new Parse($object);
                        $data = [
                            'subdomain' => $options['subdomain'],
                            'host' => $options['host'],
                            'extension' => $options['extension']
                        ];
                        if ($read) {
                            foreach ($read->data() as $key => $compile) {
                                $parse_key = $parse->compile($key, $data);
                                $compile = $parse->compile($compile, $data);
                                $read->data('delete', $key);
                                $read->data($parse_key, $compile);
                            }
                            $read->write($target);
                        }
                    } else {
                        File::copy($file->url, $target);
                    }
                } else {
                    $target = $object->config('project.dir.root') .
                        'Host' . $object->config('ds') .
                        ucfirst($options['host']) . $object->config('ds') .
                        ucfirst($options['extension']) . $object->config('ds') .
                        $explode[1];
                    if(File::Extension($file->url) === 'php'){
                        $read = File::read($file->url);
                        $read = str_replace([
                            '\\Subdomain\\Host\\Extension\\'
                        ],[
                            '\\' . ucfirst($options['host']) . '\\' . ucfirst($options['extension']) . '\\'
                        ], $read);
                        File::write($target, $read);
                    }
                    elseif(stristr($file->url, ucfirst($options['name']) . '/Data/Route.json') !== false) {
                        $read = $object->data_read($file->url);
                        $parse = new Parse($object);
                        $data = [
                            'host' => $options['host'],
                            'extension' => $options['extension']
                        ];
                        if ($read) {
                            foreach ($read->data() as $key => $compile) {
                                $parse_key = $parse->compile($key, $data);
                                $compile = $parse->compile($compile, $data);
                                $read->data('delete', $key);
                                $read->data($parse_key, $compile);
                            }
                            $read->write($target);
                        }
                    } else {
                        File::copy($file->url, $target);
                    }
                }
            }
        }
        return true;
    }
}
