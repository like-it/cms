<?php
namespace LikeIt\Cms\Core\Install\Service;

use JetBrains\PhpStorm\NoReturn;
use R3m\Io\App;

use Exception;
use R3m\Io\Module\File;
use R3m\Io\Module\Validate;

class Install {

    public static function start(App $object){
        $email = $object->request('email');
        $password = $object->request('password');
        $password2 = $object->request('password2');
        $domain = $object->request('domain');

        $url = $object->data('controller.dir.data') . File::basename(__CLASS__) . $object->config('extension.json');
        $object->request('node.type', 'user');
        $validate = Install::validate($object, $url);

        if(
            property_exists($validate, 'success') &&
            $validate->success === true
        ){
            //split domain
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
                'node.email' => $object->request('node.email')
            ];
            Install::redirect_post($url, $data);

        } else {
            //validate error return to install
        }
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
