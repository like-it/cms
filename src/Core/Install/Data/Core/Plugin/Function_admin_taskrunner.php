<?php

use Host\Subdomain\Host\Extension\Service\Jwt;
use Host\Subdomain\Host\Extension\Service\User;
use R3m\Io\App;
use R3m\Io\Module\Data;
use R3m\Io\Module\Dir;
use R3m\Io\Module\Core;
use R3m\Io\Module\File;
use R3m\Io\Module\Parse;

function function_admin_taskrunner(Parse $parse, Data $data){
    $object = $parse->object();
    while(true){
        $dir = new Dir();
        $read = $dir->read($object->config('project.dir.data') . 'Input' . $object->config('ds'), true);
        foreach($read as $nr => $file){
            if($file->type == File::TYPE){
                ob_start();
                if(File::extension($file->url) === 'task'){
                    $url = Dir::name($file->url) . File::basename($file->url, '.task') . '.token';
                    if(!File::exist($url)){
                        sleep(1);
                        if(!File::exist($url)){
                            File::delete($file->url);
                            continue;
                        }
                    }
                    $token = File::read($url);
                    $token_unencrypted = \Host\Subdomain\Host\Extension\Service\Jwt::decryptToken($object, $token);
                    $claims = $token_unencrypted->claims();
                    if($claims->has('user')) {
                        $user = $claims->get('user');
                        $uuid = false;
                        $email = false;
                        if (array_key_exists('uuid', $user)) {
                            $uuid = $user['uuid'];
                        }
                        if (array_key_exists('email', $user)) {
                            $email = $user['email'];
                        }
                        if ($uuid && $email) {
                            $object->request('email', $email);
                            $user = \Host\Subdomain\Host\Extension\Service\User::getUserByEmail($object);
                        }
                        if (
                            array_key_exists('email', $user) &&
                            array_key_exists('role', $user) &&
                            in_array('ROLE_IS_ADMIN', $user['role'])
                        ) {
                            //we have permission to execute
                            $task = File::read($file->url);
                            $output = [];
                            Dir::change($object->config('project.dir.root'));
                            Core::execute($task, $output);
                            echo implode(PHP_EOL, $output);
                            $content = ob_get_contents();
                            ob_end_clean();
                            $basename = File::basename($file->url);
                            $dir = $object->config('project.dir.data') . 'Output' . $object->config('ds');
                            Dir::create($dir);
                            File::write($dir . $basename, $content);
                            File::chown($dir, 'www-data', 'www-data', true);
                            echo $content . PHP_EOL;
                        }
                    }
                    File::delete($url);
                }
                File::delete($file->url);
            }
        }
        sleep(1);
    }
}
