<?php
namespace LikeIt\Cms\Core\Install\Service;

use R3m\Io\App;

use Exception;
use R3m\Io\Module\Core;
use R3m\Io\Module\Dir;
use R3m\Io\Module\File;
use R3m\Io\Module\Parse;
use R3m\Io\Module\Parse\Token;


class Host {

    public static function clear(App $object, $options=[]): bool
    {
        if(!array_key_exists('host', $options)){
            return false;
        }
        if(!array_key_exists('extension', $options)){
            return false;
        }
        if(array_key_exists('subdomain', $options)){
            $execute = 'rm -rf ' .
                $object->config('project.dir.root') . 'Host' . $object->config('ds') .
                ucfirst($options['host']) . $object->config('ds') .
                ucfirst($options['extension']) . $object->config('ds');
        } else {
            $execute = 'rm -rf ' .
                $object->config('project.dir.root') . 'Host' . $object->config('ds') .
                ucfirst($options['subdomain']) . $object->config('ds') .
                ucfirst($options['host']) . $object->config('ds') .
                ucfirst($options['extension']) . $object->config('ds');
        }
        Core::execute($execute, $output);
        return true;
    }

    public static function command_add(App $object, $options=[]){
        if(!array_key_exists('host', $options)){
            return;
        }
        if(!array_key_exists('extension', $options)){
            return;
        }
        if(!array_key_exists('route', $options)){
            return;
        }
        if(!array_key_exists('command', $options)){
            return;
        }
        if(array_key_exists('subdomain', $options)){
            $route = $object->data_read($options['route']);
            $command = $object->data_read($options['command']);
            if(
                $route &&
                $command
            ){
                foreach ($command->data() as $id => $add) {
                    $add->host = [
                        $options['subdomain'] . '.' . $options['host'] . '.' . $options['extension']
                    ];
                    if(
                        property_exists($add, 'module') &&
                        !property_exists($add, 'submodule') &&
                        !property_exists($add, 'command') &&
                        !property_exists($add,'subcommand')
                    ){
                        $key = $options['subdomain'] . '-' . $options['host'] . '-' . $options['extension'] . '-' . $add->module . '-' . 'command';
                        $add->controller = "Host." . ucfirst($options['subdomain']) . '.' . ucfirst($options['host']) . '.' . ucfirst($options['extension']) . '.Controller.' . ucfirst($add->module) . '.' . 'command';
                        if(!property_exists($add, 'path')){
                            $add->path = ucfirst($add->module) . '/';
                        } else {
                            $tree = Token::tree($add->path);
                            dd($tree);
                        }
                    }
                    elseif(
                        property_exists($add, 'module') &&
                        property_exists($add, 'command') &&
                        !property_exists($add, 'submodule') &&
                        !property_exists($add,'subcommand')
                    ) {
                        $key = $options['subdomain'] . '-' . $options['host'] . '-' . $options['extension'] . '-' . $add->module . '-' . $add->command;
                        $add->controller = "Host." . ucfirst($options['subdomain']) . '.' . ucfirst($options['host']) . '.' . ucfirst($options['extension']) . '.Controller.' . ucfirst($add->module) . '.' . $add->command;
                        if(!property_exists($add, 'path')){
                            $add->path = ucfirst($add->module) . '/' . ucfirst($add->command) . '/';
                        }
                    }
                    elseif(
                        property_exists($add, 'module') &&
                        property_exists($add, 'submodule') &&
                        property_exists($add, 'command') &&
                        !property_exists($add,'subcommand')
                    ){
                        $key = $options['subdomain'] . '-' . $options['host'] . '-' . $options['extension'] . '-' . $add->module . '-' . $add->submodule . '-' . $add->command;
                        $add->controller = "Host." . ucfirst($options['subdomain']) . '.' . ucfirst($options['host']) . '.' . ucfirst($options['extension']) . '.Controller.' . ucfirst($add->module) . '.' . $add->submodule . '_' . $add->command;
                        if(!property_exists($add, 'path')){
                            $add->path = ucfirst($add->module) . '/' . ucfirst($add->submodule) . '/' . ucfirst($add->command) . '/';
                        }

                    }
                    elseif(
                        property_exists($add, 'module') &&
                        property_exists($add, 'submodule') &&
                        property_exists($add, 'command') &&
                        property_exists($add,'subcommand')
                    ){
                        $key = $options['subdomain'] . '-' . $options['host'] . '-' . $options['extension'] . '-' . $add->module . '-' . $add->submodule . '-' . $add->command . '-' . $add->subcommand;
                        $add->controller = "Host." . ucfirst($options['subdomain']) . '.' . ucfirst($options['host']) . '.' . ucfirst($options['extension']) . '.Controller.' . ucfirst($add->module) . '.' . $add->submodule . '_' . $add->command . '_' . $add->subcommand;
                        if(!property_exists($add, 'path')) {
                            $add->path = ucfirst($add->module) . '/' . ucfirst($add->submodule) . '/' . ucfirst($add->command) . '/' . ucfirst($add->subcommand) . '/';
                        }
                    } else {
                        throw new exception('need module');
                    }
                    unset($add->module);
                    unset($add->submodule);
                    unset($add->command);
                    unset($add->subcommand);
                    $route->data($key, $add);
                }
                $route->write($options['route']);
                d($route);
                dd($command);
            }
        }
    }

    public static function route_delete(App $object, $options=[]){
        if(!array_key_exists('host', $options)){
            return;
        }
        if(!array_key_exists('extension', $options)){
            return;
        }
        $output = [];
        if(array_key_exists('subdomain', $options)){
            $execute = 'funda configure route delete {\$project.dir.host}'.  $options['subdomain'] . '/' . $options['host'] . '/' . $options['extension'] . '/Data/Route.json';
        } else {
            $execute = 'funda configure route delete {\$project.dir.host}'.  $options['host'] . '/' . $options['extension'] . '/Data/Route.json';
        }
        Core::execute($execute, $output);
        return implode(PHP_EOL, $output);
    }

    public static function domain_add(App $object, $options=[]){
        if(!array_key_exists('host', $options)){
            return;
        }
        if(!array_key_exists('extension', $options)){
            return;
        }
        $output = [];
        if(array_key_exists('subdomain', $options)){
            $execute = 'funda configure domain add ' . $options['subdomain'] . '.' . $options['host'] . '.' .  $options['extension'];
        } else {
            $execute = 'funda configure domain add ' . $options['host'] . '.' .  $options['extension'];
        }
        Core::execute($execute, $output);
        return implode(PHP_EOL, $output);
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
        $read = $dir->read($object->config('controller.dir.data') . ucfirst($options['name']) . $object->config('ds'), true);
        foreach($read as $nr => $file){
            if($file->type === File::TYPE){
                continue;
            }
            $explode = explode($object->config('controller.dir.data') . ucfirst($options['name']) . $object->config('ds'), $file->url, 2);
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

    public static function options(App $object, $options=[]){
        $options['name'] = array_key_exists('subdomain', $options) ? $options['subdomain'] : $options['host'];
        $options['route'] = array_key_exists('subdomain', $options) ?
            $object->config('project.dir.host') .
            ucfirst($options['subdomain']) .
            $object->config('ds') .
            ucfirst($options['host']) .
            $object->config('ds') .
            ucfirst($options['extension']) .
            $object->config('ds') .
            'Data' .
            $object->config('ds') .
            'Route.json'
            :
            $object->config('project.dir.host') .
            ucfirst($options['host']) .
            $object->config('ds') .
            ucfirst($options['extension']) .
            $object->config('ds') .
            'Data' .
            $object->config('ds') .
            'Route.json';
        $options['command'] = array_key_exists('subdomain', $options) ?
            $object->config('project.dir.host') .
            ucfirst($options['subdomain']) .
            $object->config('ds') .
            ucfirst($options['host']) .
            $object->config('ds') .
            ucfirst($options['extension']) .
            $object->config('ds') .
            'Data' .
            $object->config('ds') .
            'Command.json'
            :
            $object->config('project.dir.host') .
            ucfirst($options['host']) .
            $object->config('ds') .
            ucfirst($options['extension']) .
            $object->config('ds') .
            'Data' .
            $object->config('ds') .
            'Command.json';
        return $options;
    }

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
        $read = $dir->read($object->config('controller.dir.data') . ucfirst($options['name']) . $object->config('ds'), true);
        foreach($read as $nr => $file){
            if($file->type === Dir::TYPE){
                continue;
            }
            $explode = explode($object->config('controller.dir.data') . ucfirst($options['name']) . $object->config('ds'), $file->url, 2);
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
                    }
                    /*
                    elseif(stristr($file->url, ucfirst($options['name']) . '/Data/Command.json') !== false){
                        d(Dir::name($file->url));
                        d(Dir::name($target));
                        $read = $object->data_read(Dir::name($file->url) . 'Route.json');
                        $target = Dir::name($target) . 'Route.json';
                        d($target);
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
                            $list = $object->data_read($file->url);
                            foreach ($list->data() as $id => $add) {
                                $add->host = [
                                    $options['subdomain'] . '.' . $options['host'] . '.' . $options['extension']
                                ];
                                $key = $options['subdomain'] . '-' . $options['host'] . '-' . $options['extension'] . '-' . $add->module . '-' . $add->command;
                                $add->controller = "Host." . ucfirst($options['subdomain']) . '.' . ucfirst($options['host']) . '.' . ucfirst($options['extension']) . '.Controller.' . ucfirst($add->module) . '.' . $add->command;
                                $add->path = ucfirst($add->module) . '/' . ucfirst($add->command) . '/';
                                //$add->resource = $has_route->resource;
                                //$data = $object->data_read($target);
                                unset($add->module);
                                unset($add->command);
                                $read->data($key, $add);
                                $read->write($target);
                            }
                        }
                    }*/ else {
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
