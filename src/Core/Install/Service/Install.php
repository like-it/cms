<?php
namespace LikeIt\Cms\Core\Install\Service;

use JetBrains\PhpStorm\NoReturn;
use R3m\Io\App;

use Exception;
use R3m\Io\Module\Core;
use R3m\Io\Module\Data;
use R3m\Io\Module\Dir;
use R3m\Io\Module\File;
use R3m\Io\Module\Parse;
use R3m\Io\Module\Validate;

class Install {
    const SUBDOMAIN_CORE = 'core';
    const SUBDOMAIN_CMS = 'cms';

    public static function start(App $object){
        $email = $object->request('email');
        $password = $object->request('password');
        $password2 = $object->request('password2');
        $domain = $object->request('domain');

        $url = $object->config('controller.dir.data') . File::basename(__CLASS__) . $object->config('extension.json');
        $validate = Install::validate($object, $url, 'user');

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
                $data = new Data();
                $uuid = Core::uuid();
                Install::Host($object, [
                    'host' => $host,
                    'extension' => $extension,
                    'subdomain' => Install::SUBDOMAIN_CORE
                ]);
                $data->set('domain.' . $uuid . '.host', $host);
                $data->set('domain.' . $uuid . '.subdomain', Install::SUBDOMAIN_CORE);
                $data->set('domain.' . $uuid . '.extension', $extension);
                $uuid = Core::uuid();
                Install::Host($object, [
                    'host' => $host,
                    'extension' => $extension,
                    'subdomain' => Install::SUBDOMAIN_CMS
                ]);
                $data->set('domain.' . $uuid . '.host', $host);
                $data->set('domain.' . $uuid . '.subdomain', Install::SUBDOMAIN_CMS);
                $data->set('domain.' . $uuid . '.extension', $extension);
                $url = $object->config('project.dir.data') . 'Install' . $object->config('extension.json');
                $data->write($url);

                $object->config(
                        'host.dir.root',
                        $object->config('project.dir.root') .
                        'Host' .
                        $object->config('ds') .
                        ucfirst(Install::SUBDOMAIN_CORE) .
                        $object->config('ds') .
                        ucfirst($host) .
                        $object->config('ds') .
                        ucfirst($extension) .
                        $object->config('ds')
                );
                $user_service = '\\Host\\' . ucfirst(Install::SUBDOMAIN_CORE) . '\\' . ucfirst($host) . '\\' . ucfirst($extension) . '\\Service\\User';
                $response = $user_service::create($object);
                dd($response->data());

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
                'email' => $object->request('email'),
                'domain' => $object->request('domain')
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
        $options = Host::options($object, $options);
        Host::clear($object, $options);
        Host::route_delete($object, $options);
        Host::domain_add($object, $options);
        Host::dir_create($object, $options);
        Host::file_create($object, $options);
        Host::command_add($object, $options);
    }

    public static function validate(App $object, $url, $type='user'){
        $data = $object->data(sha1($url));
        if($data === null){
            $data = $object->parse_read($url, sha1($url));
        }
        if($data){
            $validate = $data->data($type . '.validate');
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
                function redirect() {

                    document.forms["redirect_post"].submit();
                }
            </script>
        </head>
        <body onload="redirect();">
        <form name="redirect_post" method="post" action="<?php echo $url; ?>">
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
