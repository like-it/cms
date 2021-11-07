<?php
namespace Host\Subdomain\Host\Extension\Service;

use R3m\Io\App;
use R3m\Io\Exception\FileWriteException;
use R3m\Io\Module\Core;
use R3m\Io\Module\Dir;
use R3m\Io\Module\File;
use R3m\Io\Module\Response;
use stdClass;
use ZipArchive;

class Import extends Main {
    const ALLOWED_EXTENSION = [
        'zip'
    ];


    public static function import(App $object): Response
    {
        $upload = $object->upload();
        foreach($upload->data() as $file){
            $file->extension = File::extension($file->name);
            if(
                in_array(
                    $file->extension,
                    Import::ALLOWED_EXTENSION
                )
            ){
                $uuid = Core::uuid();
                $target =
                    $object->config('project.dir.data') .
                    'Import' .
                    $object->config('ds') .
                    $uuid .
                    $object->config('ds')
                ;
                Dir::create($target);
                Import::unzip($file->tmp_name, $target);
            }
        }
    }

    public static function unzip($url='', $target=''){
        $zip = new ZipArchive();
        $zip->open($url);
        $dirList = array();
        $fileList = array();
        for ($i = 0; $i < $zip->numFiles; $i++) {
            $node = new stdClass();
            $node->name = $zip->getNameIndex($i);
            if(substr($node->name, -1) == '/'){
                $node->type = 'dir';
            } else {
                $node->type = 'file';
            }
            $node->index = $i;
            $node->url = $target . str_replace(array('/', '\\'), DIRECTORY_SEPARATOR, $node->name);
            if($node->type == 'dir'){
                $dirList[] = $node;
            } else {
                $fileList[] = $node;
            }
        }
        foreach($dirList as $dir){
            if(Dir::is($dir->url) === false){
                Dir::create($dir->url);
            }
        }
        $result = array();
        foreach($fileList as $node){
            $stats = $zip->statIndex($node->index);
            if(!empty($update)){
                if(File::exist($node->url)){
                    $mtime = File::mtime($node->url);
                    if($stats['mtime'] <= $mtime){
                        $result['skip'][] = $node->url;
                        continue;
                    }
                }
            }
            $dir = Dir::name($node->url);
            if(File::exist($dir) && !Dir::is($dir)){
                File::delete($dir);
                Dir::create($dir);
            }
            if(File::exist($dir) === false){
                Dir::create($dir);
            }
            if(File::exist($node->url)){
                File::delete($node->url);
            }
            try {
                $write = File::write($node->url, $zip->getFromIndex($node->index));
                if($write !== false){
                    File::chmod($node->url, File::CHMOD);
                    touch($node->url, $stats['mtime']);
                    $result['unpack'][] = $node->url;
                } else {
                    $result['error'][] = $node->url;
                }
            } catch (FileWriteException $e) {
            }
        }
        $zip->close();
        return $result;
    }
}
