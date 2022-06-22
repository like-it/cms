<?php

use R3m\Io\App;
use R3m\Io\Module\Data;
use R3m\Io\Module\File;
use R3m\Io\Module\Parse;

function function_controllers_functions_amount(Parse $parse, Data $data, $node = null){
    $object = $parse->object();
    $controller = str_replace('/', '.', $node->url);
    if(File::extension($node->url) === 'php'){
        $controller = File::basename($controller, $object->config('extension.php'));
        $controller = str_replace('.Application.Host', 'Host', $controller);
    } else {
        throw new Exception('Cannot process files other than .php');
    }
    $class = str_replace('.', '\\\\', $controller);
    try {
        $autoload = $object->data(App::AUTOLOAD_R3M);
        $url = $autoload->locate($class);
        if($url){
            $read = File::read($url);
            $functions = 0;
            $functions += substr_count($read,"private function");
            $functions += substr_count($read,"protected function");
            $functions += substr_count($read,"public function");
            $functions += substr_count($read,"static function");
            return $functions;
        }
    }
    catch (Exception $exception){
        echo $exception->getMessage();
    }
}