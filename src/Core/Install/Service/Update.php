<?php
namespace LikeIt\Cms\Core\Install\Service;

use R3m\Io\App;

use Exception;
use R3m\Io\Module\Core;
use R3m\Io\Module\Data;
use R3m\Io\Module\Dir;
use R3m\Io\Module\File;
use R3m\Io\Module\Validate;

class Update {

    public static function start(App $object){
        $url = $object->config('project.dir.data') . 'Host' . $object->config('extension.json');
        $host_list = $object->data_read($url);
        dd($host_list);
        /*
        $host = $explode[0];
        $extension = $explode[1];
        $data = new Data();
        $uuid = Core::uuid();
        try {
            Update::Host($object, [
                'host' => $host,
                'extension' => $extension,
                'subdomain' => Install::SUBDOMAIN_CORE
            ]);
            Install::Host($object, [
                'host' => $host,
                'extension' => $extension,
                'subdomain' => Install::SUBDOMAIN_CMS
            ]);
            Install::certificate($object);
            install::certificate_config($object);

        } catch (Exception $exception){
            return $exception;
        }
        */
    }

    private static function certificate_config(App $object){
        $url = $object->config('project.dir.data') . 'Config' . $object->config('extension.json');
        $data = $object->data_read($url);
        if(!$data){
            $data = new Data();
        }
        if($data){
            $token_identified_by = Core::uuid();
            $refresh_token_identified_by = Core::uuid();
            $permitted_for = Core::uuid();
            $data->set('token.private_key', "{config('project.dir.data')}Pem/Token_key.pem");
            $data->set('token.certificate', "{config('project.dir.data')}Pem/Token_cert.pem");
            $data->set('token.passhrase', Install::PASSPHRASE);
            $data->set('token.issued_at', Install::NOW);
            $data->set('token.identified_by', $token_identified_by);
            $data->set('token.permitted_for', $permitted_for);
            $data->set('token.can_only_be_used_after', Install::NOW);
            $data->set('token.expires_at', Install::TOKEN_EXPIRE);
            $data->set('token.issued_by', $object->request('domains.core'));
            $data->set('refresh.token.private_key', "{config('project.dir.data')}Pem/RefreshToken_key.pem");
            $data->set('refresh.token.certificate', "{config('project.dir.data')}Pem/RefreshToken_cert.pem");
            $data->set('refresh.token.passhrase', Install::PASSPHRASE);
            $data->set('refresh.token.issued_at', Install::NOW);
            $data->set('refresh.token.identified_by', $refresh_token_identified_by);
            $data->set('refresh.token.permitted_for', $permitted_for);
            $data->set('refresh.token.can_only_be_used_after', Install::NOW);
            $data->set('refresh.token.expires_at', Install::REFRESH_TOKEN_EXPIRE);
            $data->set('refresh.token.issued_by', $object->request('domains.core'));
            $data->write($url);
        }
    }

    private static function certificate(App $object){
        Dir::create($object->config('project.dir.data') . 'Pem' . $object->config('ds'));
        File::copy(
            $object->config('controller.dir.data') . 'Pem' . $object->config('ds') . 'Token_cert.pem',
            $object->config('project.dir.data') . 'Pem' . $object->config('ds') . 'Token_cert.pem'
        );
        File::chmod($object->config('project.dir.data') . 'Pem' . $object->config('ds') . 'Token_cert.pem', File::CHMOD);
        File::copy(
            $object->config('controller.dir.data') . 'Pem' . $object->config('ds') . 'Token_key.pem',
            $object->config('project.dir.data') . 'Pem' . $object->config('ds') . 'Token_key.pem'
        );
        File::chmod($object->config('project.dir.data') . 'Pem' . $object->config('ds') . 'Token_key.pem', File::CHMOD);
        File::copy(
            $object->config('controller.dir.data') . 'Pem' . $object->config('ds') . 'RefreshToken_cert.pem',
            $object->config('project.dir.data') . 'Pem' . $object->config('ds') . 'RefreshToken_cert.pem'
        );
        File::chmod($object->config('project.dir.data') . 'Pem' . $object->config('ds') . 'RefreshToken_cert.pem', File::CHMOD);
        File::copy(
            $object->config('controller.dir.data') . 'Pem' . $object->config('ds') . 'RefreshToken_key.pem',
            $object->config('project.dir.data') . 'Pem' . $object->config('ds') . 'RefreshToken_key.pem'
        );
        File::chmod($object->config('project.dir.data') . 'Pem' . $object->config('ds') . 'RefreshToken_key.pem', File::CHMOD);
    }

    public static function host(App $object, $options=[]){
        if(!array_key_exists('host', $options)){
            return;
        }
        if(!array_key_exists('extension', $options)){
            return;
        }
        $options = Host::options($object, $options);
        try {
            Host::clear($object, $options);
            Host::route_delete($object, $options);
            Host::domain_add($object, $options);
            Host::route_node_delete($object, $options);
            Host::view_delete($object, $options);
            Host::dir_create($object, $options);
            Host::file_create($object, $options);
            Host::command_add($object, $options);
            Host::config_server_url($object, $options);
            Host::route_dedouble($object, $options);
        } catch (Exception $exception){
            return $exception;
        }
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
