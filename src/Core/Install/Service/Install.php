<?php
namespace LikeIt\Cms\Core\Install\Service;

use JetBrains\PhpStorm\NoReturn;
use R3m\Io\App;

use Exception;
use R3m\Io\Module\Core;
use R3m\Io\Module\Dir;
use R3m\Io\Module\File;
use R3m\Io\Module\Parse;
use R3m\Io\Module\Validate;

class Install {
    const SUBDOMAIN_CORE = 'core';
    const SUBDOMAIN_CMS = 'cms';

    public static function start(App $object){
        $email = $object->request('node.email');
        $password = $object->request('node.password');
        $password2 = $object->request('node.password2');
        $domain = $object->request('node.domain');

        $url = $object->data('controller.dir.data') . File::basename(__CLASS__) . $object->config('extension.json');
        $object->request('node.type', 'user');
        $validate = Install::validate($object, $url);

        if(
            property_exists($validate, 'success') &&
            $validate->success === true
        ){
            //split domain
            $explode = explode('.', $domain, 2);
            if(
                array_key_exists(1, $explode) !== false &&
                !empty($explode[1])
            ){
                $host = $explode[0];
                $extension = $explode[1];
                $subdomain = Install::SUBDOMAIN_CMS;
                Install::Host($object, [
                    'host' => $host,
                    'extension' => $extension,
                    'subdomain' => Install::SUBDOMAIN_CORE
                ]);
                Install::Host($object, [
                    'host' => $host,
                    'extension' => $extension,
                    'subdomain' => Install::SUBDOMAIN_CMS
                ]);


                $dir = new Dir();
                $read = $dir->read($object->config('controller.dir.data') . 'Cms' . $object->config('ds'), true);
                foreach($read as $nr => $file){
                    if($file->type === File::TYPE){
                        continue;
                    }
                    $explode = explode($object->config('controller.dir.data') . 'Cms' . $object->config('ds'), $file->url, 2);
                    if(array_key_exists(1, $explode)){
                        $target = $object->config('project.dir.root') .
                            'Host' . $object->config('ds') .
                            ucfirst($subdomain) . $object->config('ds') .
                            ucfirst($host) . $object->config('ds') .
                            ucfirst($extension) . $object->config('ds') .
                            $explode[1];
                        if(Dir::is($target) === false){
                            Dir::create($target);
                        }

                    }
                }
                foreach($read as $nr => $file){
                    if($file->type === Dir::TYPE){
                        continue;
                    }
                    $explode = explode($object->config('controller.dir.data') . 'Cms' . $object->config('ds'), $file->url, 2);
                    if(array_key_exists(1, $explode)){
                        $target = $object->config('project.dir.root') .
                            'Host' . $object->config('ds') .
                            ucfirst($subdomain) . $object->config('ds') .
                            ucfirst($host) . $object->config('ds') .
                            ucfirst($extension) . $object->config('ds') .
                            $explode[1];
                        if(File::Extension($file->url) === 'php'){
                            $read = File::read($file->url);
                            $read = str_replace([
                                '\\Cms\\Host\\Extension\\'
                            ],[
                                '\\Cms\\' . ucfirst($host) . '\\' . ucfirst($extension) . '\\'
                            ], $read);
                            File::write($target, $read);
                        }
                        elseif(stristr($file->url, 'Cms/Data/Route.json') !== false){
                            $read = $object->data_read($file->url);
                            $parse = new Parse($object);
                            $data = [
                                'subdomain' => $subdomain,
                                'host'=> $host,
                                'extension' => $extension
                            ];
                            if($read){
                                foreach($read->data() as $key => $compile){
                                    $parse_key = $parse->compile($key, $data);
                                    $compile = $parse->compile($compile, $data);
                                    $read->data('delete', $key);
                                    $read->data($parse_key, $compile);
                                }
                                $read->write($target);
                            }

                            /*
                            $read = str_replace([
                                '{$Subdomain}',
                                '{$Host}',
                                '{$Extension}',
                                '{$subdomain}',
                                '{$host}',
                                '{$extension}'
                            ],[
                                ucfirst($subdomain),
                                ucfirst($host),
                                ucfirst($extension),
                                $subdomain,
                                $host,
                                $extension
                            ], $read);
                            File::write($target, $compile);
                            */
                        }
                        elseif(stristr($file->url, 'Cms/Data/Command.json') !== false){
                            $read = $object->data_read($file->url);
                            if($read){
                                foreach($read->data() as $id => $add){
                                    dd($add);
                                }
                            }
                        }
                        /*
                        elseif(stristr($file->url, 'Cms/Data/Command.json') !== false){
                            $read = $object->data_read($file->url);
                            if($read){
                                foreach($read->data() as $id => $add){
                                    $parse = new Parse($object);
                                    $add = $parse->compile($add, [
                                        'module' => $add->module,
                                        'command' => $add->command,
                                        'subdomain' => $subdomain,
                                        'host'=> $host,
                                        'extension' => $extension
                                    ]);
                                    unset($add->module);
                                    unset($add->command);
                                    $add = json_encode($add);
                                    $add = '"' . str_replace('"', '\"', $add);

                                    $execute = 'funda configure route add ' . $add;
                                    Core::execute($execute, $output);
                                    d($execute);
                                    d($output);
                                }
                            }
                        }
                        */
                        else {
                            File::copy($file->url, $target);
                        }
                    }
                }
            }
        }
        elseif(
            property_exists($validate, 'success') &&
            $validate->success === false
        ){
            //form error return to install with a post

            $url = $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['SERVER_NAME'] . ':' . $_SERVER['SERVER_PORT'];

            $data = [
                'error' => str_replace([
                        '"'
                ],[
                        '&quot;'
                ], (json_encode($validate))),
                'node.email' => $object->request('node.email'),
                'node.domain' => $object->request('node.domain')
            ];
            Install::redirect_post($url, $data);

        } else {
            //validate error return to install
        }
    }

    public static function host(App $object, $options=[]){
        if(!array_key_exists('host', $options)){
            return;
        }
        if(!array_key_exists('extension', $options)){
            return;
        }
        $options['name'] = array_key_exists('subdomain', $options) ? $options['subdomain'] : $options['host'];
        Host::clear($object, $options);
        Host::route_delete($object, $options);
        Host::domain_add($object, $options);
        Host::dir_create($object, $options);
        Host::file_create($object, $options);
    }

    public static function validate(App $object, $url){
        $data = $object->data(sha1($url));
        if($data === null){
            $data = $object->parse_read($url, sha1($url));
        }
        if($data){
            $validate = $data->data($object->request('node.type') . '.validate');
            try {
                return Validate::validate($object, $validate);
            } catch (Exception $e) {
                echo $e;
            }
        }
    }

    public static function redirect_post($url, $data = []){
        ?>
        <html xmlns="http://www.w3.org/1999/xhtml">
        <head>
            <script type="text/javascript">
                function closethisasap() {

                    document.forms["redirectpost"].submit();
                }
            </script>
        </head>
        <body onload="closethisasap();">
        <form name="redirectpost" method="post" action="<?php echo $url; ?>">
            <?php
            if ( !is_null($data) ) {
                foreach ($data as $k => $v) {
                    echo '<input type="hidden" name="' . $k . '" value="' . $v . '"> ';
                }
            }
            ?>
        </form>
        </body>
        </html>
        <?php
        exit;
    }
}
