<?php
namespace Host\Subdomain\Host\Extension\Service;

use R3m\Io\App;
use R3m\Io\Config;
use R3m\Io\Module\Core;
use R3m\Io\Module\Data;
use R3m\Io\Module\Dir;
use R3m\Io\Module\File;
use R3m\Io\Module\Filter;
use R3m\Io\Module\Handler;
use R3m\Io\Module\Sort;
use R3m\Io\Module\Response;

use Exception;
use ErrorException;
use R3m\Io\Exception\FileNotExistException;
use DateTime;

class FileSystem {
    const TYPE_FILE = 'file';
    const TYPE_DIRECTORY = 'directory';
    const TYPE_TREE = 'tree';
    const TYPE_DESKTOP = 'desktop';
    const TYPE_FAVORITE = 'favorite';

    /**
     * @throws FileNotExistException
     */
    public static function read(App $object): Response
    {
        dd($object->request('node.url'));
        $url = htmlspecialchars_decode($object->request('node.url'), ENT_HTML5);
        if(File::exist($url)){
            $extension = File::extension($url);
            $read = File::read($url);
            return new Response($read, Response::TYPE_FILE);
        }
        throw new FileNotExistException('File (' . $url .') not exist...');
    }

    /*
    public static function write(App $object, $options=[]){
        $url = $object->request('node.url');
        $content = $object->request('node.content');
        File::write($url, $content);
        $result = [];
        $result['url'] = $url;
        $result['size'] = File::size($url);
        $result['isModified'] = new DateTime();

        $response = new Response($result, Response::TYPE_JSON, 200);
        return Response::output($object, $response);
    }

    public static function upload(App $object, $options=[]){
        $directory = $object->request('node.directory');
        if(!Dir::is($directory)){
            Dir::create($directory, Dir::CHMOD);
        }
        $error = [];
        foreach($object->upload()->get() as $nr => $upload){
            $data = new Data($upload);
            if($data->get('error') !== 0){
                $error[] = $data;
                continue;
            }
            if(!File::is_writeable($directory)){
                $data->set('message', 'The directory isn\'t writable...');
                $error[] = $data;
                continue;
            }
            $move = File::upload($data, $directory);
            if($move === false){
                $data->set('message', 'The upload couldn\'t be moved...');
                $error[] = $data;
            }
        }
        $message = [];
        if(!empty($error)){
            foreach($error as $nr => $data){
                if($data->get('message') !== null){
                    $message[] = $data->get('message');
                } else {
                    switch($data->get('error')){
                        case 1 :
                            $message[] =  'The uploaded file exceeds the upload_max_filesize directive in php.ini.';
                        break;
                        case 2 :
                            $message[] =  'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form.';
                        break;
                        case 3 :
                            $message[] =  'The uploaded file was only partially uploaded.';
                        break;
                        case 4 :
                            $message[] =  'No file was uploaded.';
                        break;
                        case 6 :
                            $message[] =  'Missing a temporary folder.';
                        break;
                        case 7 :
                            $message[] =  'Failed to write file to disk.';
                        break;
                        case 8 :
                            $message[] =  'A PHP extension stopped the file upload.';
                        break;
                    }
                }
            }
        }
        if(empty($message)){
            $code = 200;
        } else {
            $code = 405;
        }
        $message = implode("\n", $message);
        $response = new Response($message, Response::TYPE_HTML, $code);
        return Response::output($object, $response);
    }

    public static function delete(App $object, $options=[])
    {
        $url = htmlspecialchars_decode($object->request('node.url'), ENT_HTML5);
        if(File::exist($url)){
            if(Dir::is($url)){
                $is_delete = Dir::remove($url);
            } else {
                $is_delete = File::delete($url);
            }
            if($is_delete === true){
                $result = [];
                $result['isUpdated'] = time();
                return $result;
            }
            elseif(is_object($is_delete) && method_exists($is_delete, 'getMessage')){
                $error = [];
                $error['error'] = [];
                $error['error']['delete'] = $is_delete->getMessage();
                return $error;
            }
            else {
                $error = [];
                $error['error'] = [];
                $error['error']['delete'] = 'Cannot delete file...';
                return $error;
            }
        } else {
            $error = [];
            $error['error'] = [];
            $error['error']['delete'] = 'Cannot delete file, file doesn\'t exist...';
            return $error;
        }
    }

    public static function move(App $object, $options=[]){
        $source = $object->request('node.source');
        $destination = $object->request('node.destination');
        if(File::exist($destination)){
            $error = [];
            $error['error'] = [];
            $error['error']['destination'] = 'Destination already exists...';
            return $error;
        }
        if(File::exist($source)){
            if(Dir::is($source)){
                //false no overwrite
                $move = File::move($source, $destination, false);
                if($move !== true && method_exists($move, 'getMessage')){
                    $error = [];
                    $error['error'] = [];
                    $error['error']['move'] = $move->getMessage();
                    return $error;
                }
            } else {
                //false no overwrite
                $move = File::move($source, $destination, false);
                if($move !== true && method_exists($move, 'getMessage')){
                    $error = [];
                    $error['error'] = [];
                    $error['error']['move'] = $move->getMessage();
                    return $error;
                }
            }
            $result = [];
            $result['isUpdated'] = time();
            return $result;
        } else {
            $error = [];
            $error['error'] = [];
            $error['error']['source'] = 'Source doesn\'t exist...';
            return $error;
        }
    }

    public static function list(App $object, $options=[]){
        $type = $object->request('type');
        $directory = $object->request('directory');
        if(empty($directory)){
            $directory = '/';
        }
        switch(strtolower($type)){
            case FileSystem::TYPE_FILE :
                $dir = new Dir();
                $read = $dir->read($directory);
                if($read){
                    $list_dir = Filter::list($read)->where([
                        'type' => [
                            'operator' => '==',
                            'value' => Dir::TYPE
                        ]
                    ]);
                    $list_file = Filter::list($read)->where([
                        'type' => [
                            'operator' => '==',
                            'value' => File::TYPE
                        ]
                    ]);
                    $list_dir = Sort::list($list_dir)->with(['name' => 'asc', 'mtime' => 'asc']);
                    $list_file = Sort::list($list_file)->with(['name' => 'asc', 'mtime' => 'asc']);
                    $list = [];
                    $list['files'] = array_merge($list_dir, $list_file);
                    $list['dir'] = $directory;
                    foreach($list['files'] as $nr => $node){
                        $list['files'][$nr] = File::info($node);
                    }
                    return $list;
                } else {
                    $list['files'] = [];
                    $list['dir'] = $directory;
                    return $list;
                }
            break;
            case FileSystem::TYPE_DIRECTORY :
                $dir = new Dir();
                $read = $dir->read($directory);
                if($read){
                    $list['files'] = Filter::list($read)->where([
                        'type' => [
                            'operator' => '==',
                            'value' => Dir::TYPE
                        ]
                    ]);
                    foreach($list['files'] as $nr => $node){
                        $list['files'][$nr] = File::info($node);
                        try {
                            $list_sub = $dir->read($node->url);
                            $list_sub = Filter::list($list_sub)->where([
                                'type' => [
                                    'operator' => '==',
                                    'value' => Dir::TYPE
                                ]
                            ]);
                            if(is_array($list_sub) && count($list_sub) > 0){
                                $list['files'][$nr]->has_sub_dir = true;
                            }
                        } catch (Exception | ErrorException $exception){

                        }
                    }
                    $list['files'] = Sort::list($list['files'])->with(['name' => 'asc', 'mtime' => 'asc']);
                    $list['dir'] = $directory;
                    return $list;
                } else {
                    $list['files'] = [];
                    $list['dir'] = $directory;
                    return $list;
                }
            break;
            case FileSystem::TYPE_TREE :
                if(
                    array_key_exists('user', $options) &&
                    array_key_exists('dir', $options['user'])
                ){
                    $read = FileSystem::createTree($object, $options['user']);
                    if($read){
                        return $read->data();
                    }
                }
            break;
        }
        return [];
    }

    private static function createTree(App $object, $user=[]){
        if(!array_key_exists('uuid', $user)){
            return;
        }
        $data = new Data();
        $list = [];
        $record = new Data();
        $record->set('dir', '/Application/Mount/Desktop/');
        $record->set('name', 'Desktop');
        $record->set('icon.class', 'fas fa-desktop');
        $record->set('section.dir', $record->get('name'));
        $list[] = $record->data();
        $record = new Data();
        $record->set('dir', '/Application/Mount/Favorites/');
        $record->set('name', 'Favorites');
        $record->set('icon.class', 'fas fa-star');
        $record->set('section.dir', $record->get('name'));
        $list[] = $record->data();
        $record = new Data();
        $record->set('dir', '/Application/Mount/Documents/');
        $record->set('name', 'Documents');
        $record->set('icon.class', 'fas fa-folder');
        $record->set('section.dir', $record->get('name'));
        $list[] = $record->data();
        $record = new Data();
        $record->set('dir', '/Application/Mount/Audio/');
        $record->set('name', 'Audio');
        $record->set('icon.class', 'fas fa-music');
        $record->set('section.dir', $record->get('name'));
        $list[] = $record->data();
        $record = new Data();
        $record->set('dir', '/Application/Mount/Video/');
        $record->set('name', 'Video');
        $record->set('icon.class', 'fas fa-video');
        $record->set('section.dir', $record->get('name'));
        $list[] = $record->data();
        $record = new Data();
        $record->set('dir', '/');
        $record->set('name', 'Root');
        $record->set('icon.class', 'fas fa-cloud');
        $record->set('section.dir', $record->get('dir'));
        $record->set('rename', false);
        $list[] = $record->data();
        $record = new Data();
        $record->set('dir', '/Application/Mount');
        $record->set('name', 'Mount');
        $record->set('icon.class', 'fas fa-cloud');
        $record->set('section.dir', $record->get('dir'));
        $record->set('rename', false);
        $list[] = $record->data();
        $data->data('tree', $list);
        return $data;
    }
    */
}