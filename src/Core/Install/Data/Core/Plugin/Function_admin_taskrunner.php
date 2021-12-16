<?php

use Host\Subdomain\Host\Extension\Service\Jwt;
use Host\Subdomain\Host\Extension\Service\User;
use R3m\Io\App;
use R3m\Io\Config;
use R3m\Io\Module\Data;
use R3m\Io\Module\Dir;
use R3m\Io\Module\Core;
use R3m\Io\Module\File;
use R3m\Io\Module\Parse;

/**
 * @throws Exception
 */
function function_admin_taskrunner(Parse $parse, Data $data){
    $object = $parse->object();
    if(
        $object->request('module') === 'admin' &&
        $object->request('submodule') === 'taskrunner' &&
        $object->request('command') === 'stop' &&
        !empty($object->request('token'))
    ){
        $token = $object->request('token');
        $token_unencrypted = \Host\Subdomain\Host\Extension\Service\Jwt::decryptToken($object, $token);
        $claims = $token_unencrypted->claims();
        if ($claims->has('user')) {
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
                if (!$user) {
                    echo 'Could not find user...' . PHP_EOL;
                    return;
                }
            }
            $is_admin = false;
            if ($user) {
                $is_admin = \Host\Subdomain\Host\Extension\Service\UserRole::has(
                    $object,
                    \Host\Subdomain\Host\Extension\Service\UserRole::get(
                        $object,
                        $user
                    ),
                    'ROLE_IS_ADMIN'
                );
            }
            if ($is_admin === true) {
                echo $parse->compile('Stopping {binary()} admin taskrunner...' . PHP_EOL, $data);
                $url = $object->config('project.dir.data') . 'Config' . $object->config('extension.json');
                $config = $object->data_read($url);
                if (!$config) {
                    exit();
                }
                $pid = $config->data('admin.taskrunner.pid');
                if ($pid) {
                    if (!defined('SIGHUP')) {
                        define('SIGHUP', 1);
                    }
                    $kill = posix_kill($pid, SIGHUP);
                    if ($kill) {
                        echo 'SIGHUP terminated the process with id: ' . $pid . PHP_EOL;
                    } else {
                        echo 'SIGHUP couldn\'t terminate the process with id: ' . $pid . PHP_EOL;
                    }
                } else {
                    echo 'No admin taskrunner process found...' . $pid . PHP_EOL;
                }
                $config->delete('admin.taskrunner.pid');
                $config->write($url);
            } else {
                echo 'You need to have the role administrator to fulfil this action.' . PHP_EOL;
            }
        } else {
            echo 'Invalid claims detected in token.' . PHP_EOL;
        }
    } else {
        $url = $object->config('project.dir.data') . 'Config' . $object->config('extension.json');
        $config = $object->data_read($url);
        if (!$config) {
            exit();
        }
        $config->data('admin.taskrunner.pid', posix_getpid());
        $config->write($url);
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
        while(true) {
            $dir = new Dir();
            $read = $dir->read($object->config('project.dir.data') . 'Input' . $object->config('ds'), true);
            foreach ($read as $nr => $file) {
                if ($file->type !== File::TYPE) {
                    continue;
                }
                ob_start();
                if(File::extension($file->url) !== 'token') {
                    continue;
                }
                $url = Dir::name($file->url) . File::basename($file->url, '.token') . '.task';
                if (!File::exist($url)) {
                    $content = 'Task File url: ' . $url . ' doesn\'t exist.';
                    $basename = File::basename($url);
                    $dir = $object->config('project.dir.data') . 'Output' . $object->config('ds');
                    Dir::create($dir);
                    File::write($dir . $basename, $content);
                    File::delete($file->url);
                    continue;
                }
                $token = File::read($file->url);
                $token_unencrypted = \Host\Subdomain\Host\Extension\Service\Jwt::decryptToken($object, $token);
                $claims = $token_unencrypted->claims();
                if ($claims->has('user')) {
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
                        if (!$user) {
                            $content = 'Cannot find user...';
                            $basename = File::basename($url);
                            $dir = $object->config('project.dir.data') . 'Output' . $object->config('ds');
                            Dir::create($dir);
                            File::write($dir . $basename, $content);
                            File::delete($url);
                            File::delete($file->url);
                            continue;
                        }
                    }
                    $is_admin = false;
                    if ($user) {
                        $is_admin = \Host\Subdomain\Host\Extension\Service\UserRole::has(
                            $object,
                            \Host\Subdomain\Host\Extension\Service\UserRole::get(
                                $object,
                                $user
                            ),
                            'ROLE_IS_ADMIN'
                        );
                    }
                    if ($is_admin === true) {
                        //we have permission to execute
                        $task = File::read($url);
                        $output = [];
                        Dir::change($object->config('project.dir.root'));
                        Core::execute($task, $output);
                        echo implode(PHP_EOL, $output);
                        $content = ob_get_contents();
                        ob_end_clean();
                        $basename = File::basename($url);
                        $dir = $object->config('project.dir.data') . 'Output' . $object->config('ds');
                        Dir::create($dir);
                        File::write($dir . $basename, $content);
                        File::chown($dir, 'www-data', 'www-data', true);
                        echo $content . PHP_EOL;
                    } else {
                        $content = 'No Administrator...' . PHP_EOL;
                        $basename = File::basename($url);
                        $dir = $object->config('project.dir.data') . 'Output' . $object->config('ds');
                        Dir::create($dir);
                        File::write($dir . $basename, $content);
                    }
                } else {
                    $content = 'Invalid claim detected in token...' . PHP_EOL;
                    $basename = File::basename($url);
                    $dir = $object->config('project.dir.data') . 'Output' . $object->config('ds');
                    Dir::create($dir);
                    File::write($dir . $basename, $content);
                }
                $content = 'Token Delete url: ' . $file->url . PHP_EOL;
                $basename = File::basename($file->url);
                $dir = $object->config('project.dir.data') . 'Output' . $object->config('ds');
                Dir::create($dir);
                File::append($dir . $basename, $content);
                File::delete($file->url);
                $content = 'Task Delete url: ' . $url . PHP_EOL;
                $basename = File::basename($file->url);
                $dir = $object->config('project.dir.data') . 'Output' . $object->config('ds');
                Dir::create($dir);
                File::append($dir . $basename, $content);
                File::delete($url);
            }
            sleep(1);
        }
    }
}
