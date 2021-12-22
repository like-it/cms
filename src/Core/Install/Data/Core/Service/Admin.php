<?php
namespace Host\Subdomain\Host\Extension\Service;

use R3m\Io\App;
use R3m\Io\Module\Core;
use R3m\Io\Module\Dir;
use R3m\Io\Module\File;

use Exception;
use R3m\Io\Exception\FileAppendException;
use R3m\Io\Exception\AuthorizationException;
use R3m\Io\Exception\FileWriteException;

class Admin extends Main
{
    const CRON_INTERVAL = 60;

    public static function task(App $object){
        try {
            $task  = App::parameter($object, 'task', 1);
            $euid = posix_geteuid();
            $dir = $object->config('project.dir.data') .'Input' . $object->config('ds');
            $dir_part = $euid . $object->config('ds');
            Dir::create($dir . $dir_part);
            $uuid = Core::uuid();
            $url_part = $dir_part . $uuid . '.task';
            $url = $dir . $url_part;
            $written = File::write($url, $task);
            if($written === 0){
                throw new FileWriteException('Empty file write');
            }
            return $dir . $url_part . PHP_EOL;
        } catch (FileWriteException $exception) {
            return $exception;
        }

    }

    public static function taskrunner(App $object){
        $start = microtime(true);
        Host::dir_root($object);
        $dir_output = $object->config('project.dir.data') . 'Output' . $object->config('ds');
        Dir::create($dir_output);
        while(true) {
            $current = microtime(true);
            if($current - $start > Admin::CRON_INTERVAL){
                $dir = new Dir();
                $read = $dir->read(
                    $object->config('project.dir.data') . 'Input' . $object->config('ds'),
                    true
                );
                foreach ($read as $nr => $file) {
                    if ($file->type !== File::TYPE) {
                        continue;
                    }
                    if(File::extension($file->url) === 'task') {
                        $url_token = File::basename($file->url, '.task') . '.token';
                        if(File::exist($url_token)){
                            continue;
                        }
                        try {
                            $basename = File::basename($file->url);
                            $url_begin = $dir_output . File::basename($file->url, '.token') . '.begin';
                            $url_end = $dir_output . File::basename($file->url, '.token') . '.end';
                            File::touch($url_begin);
                            $content = 'Token file not found for task: ' . $basename . PHP_EOL;
                            File::write($dir_output . $basename, $content);
                            File::touch($url_end);
                            File::chown(
                                $dir_output,
                                'www-data',
                                'www-data',
                                true
                            );
                            File::delete($file->url);
                        }
                        catch (FileWriteException $e) {
                            File::delete($file->url);
                        }
                    }
                }
                exit();
            }
            $dir = new Dir();
            $read = $dir->read(
                $object->config('project.dir.data') . 'Input' . $object->config('ds'),
                true
            );
            foreach ($read as $nr => $file) {
                if ($file->type !== File::TYPE) {
                    continue;
                }
                if(File::extension($file->url) !== 'token') {
                    continue;
                }
                try {
                    $url = Dir::name($file->url) . File::basename($file->url, '.token') . '.task';
                    $url_begin = $dir_output . File::basename($file->url, '.token') . '.begin';
                    $url_end = $dir_output . File::basename($file->url, '.token') . '.end';
                    $basename = File::basename($url);
                    if (!File::exist($url)) {
                        $content = 'Task File for: ' . $basename . ' doesn\'t exist.' . PHP_EOL;
                        foreach($read as $node){
                            $content .= $node->url . PHP_EOL;
                        }
                        File::write($dir_output . $basename, $content);
                        File::delete($file->url);
                        File::chown(
                            $dir_output,
                            'www-data',
                            'www-data',
                            true
                        );
                        continue;
                    }
                    elseif(File::exist($url_begin)){
                        continue;
                    }
                    $token = File::read($file->url);
                    $token_unencrypted = Jwt::decryptToken($object, $token);
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
                            $user = User::getUserByEmail($object);
                            if (!$user) {
                                $content = 'Cannot find user...';
                                File::write($dir_output . $basename, $content);
                                File::delete($url);
                                File::delete($file->url);
                                File::chown(
                                    $dir_output,
                                    'www-data',
                                    'www-data',
                                    true
                                );
                                continue;
                            }
                        }
                        $is_admin = false;
                        if ($user) {
                            $is_admin = UserRole::has(
                                $object,
                                UserRole::get(
                                    $object,
                                    $user
                                ),
                                'ROLE_IS_ADMIN'
                            );
                        }
                        if ($is_admin === true) {
                            //we have permission to execute
                            File::touch($url_begin);
                            $task = File::read($url);
                            $output = [];
                            Dir::change($object->config('project.dir.root'));
                            Core::execute($task, $output);
                            ob_end_clean();
                            File::write($dir_output . $basename, implode(PHP_EOL, $output));
                        } else {
                            $content = 'No Administrator...' . PHP_EOL;
                            File::write($dir_output . $basename, $content);
                        }
                    } else {
                        $content = 'Invalid claim detected in token...' . PHP_EOL;
                        File::write($dir_output . $basename, $content);
                    }
                    $content = 'Token Delete: ' . File::basename($file->url, '.token') . PHP_EOL;
                    File::append($dir_output . $basename,PHP_EOL . $content);
                    File::delete($file->url);
                    $content = 'Task Delete: ' . File::basename($url, '.task') . PHP_EOL;
                    File::append($dir_output . $basename, PHP_EOL .$content);
                    File::delete($url);
                    File::touch($url_end);
                    File::chown(
                        $dir_output,
                        'www-data',
                        'www-data',
                        true
                    );
                } catch(
                    Exception |
                    FileWriteException |
                    FileAppendException |
                    AuthorizationException
                    $exception
                ){
                    //add output file with $exception
                    File::delete($file->url);
                }
            }
            sleep(1);
        }
    }
}