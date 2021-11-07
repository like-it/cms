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
    const FUNDA = 'Funda';
    const UPLOAD_ALLOWED_EXTENSION = [
        'zip'
    ];
    const FILE_EXTENSION_DATA = [
        'json'
    ];

    public static function import(App $object): Response
    {
        $upload = $object->upload();
        foreach($upload->data() as $file){
            $file->extension = File::extension($file->name);
            if(
                in_array(
                    $file->extension,
                    Import::UPLOAD_ALLOWED_EXTENSION
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
                Import::update_files($object, $target);
                Import::update_data($object, $target);
            }
        }
    }

    public static function update_data(App $object, $target=''){

    }

    public static function update_files(App $object, $target=''){
        $dir = new Dir();
        $read = $dir->read($target, true);
        $version = false;
        $funda = false;
        $is_next = false;
        foreach($read as $nr => $file){
            if($is_next === true){
                $version = $file;
                $is_next = false;
            }
            if(
                $version &&
                $funda
            ){
                if($file->type !== Dir::TYPE){
                    $file->extension = File::extension($file->url);
                    if(in_array($file->extension, Import::FILE_EXTENSION_DATA)){
                        continue;
                    }
                    $file_target = explode($funda->name . $object->config('ds') . $version->name, $file->url, 2);
                    if(array_key_exists(1, $file_target)){
                        $file->target = $file_target[1];
                    }
                    dd($file);
                }
            } else {
                if(
                    $file->type === Dir::TYPE &&
                    $file->name === Import::FUNDA
                ){
                    $is_next = true;
                    $funda = $file;
                    continue;
                }
            }
        }
        dd($read);
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
