<?php
namespace Host\Subdomain\Host\Extension\Service;

use R3m\Io\App;
use R3m\Io\Module\File;
use R3m\Io\Module\Response;


class Import extends Main {

    public static function import(App $object): Response
    {
        $upload = $object->upload();
        foreach($upload->data() as $file){
            $file->extension = File::extension($file->name);
            dd($file);
        }



        d($object->upload());
        dd($object->request());
    }
}
