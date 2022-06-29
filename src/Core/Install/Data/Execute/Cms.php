<?php
namespace Execute;

use R3m\Io\Config;
use R3m\Io\Module\Dir;
use R3m\Io\Module\Host;

trait Cms {

    public function host(){
        $host_url = $this->object()->config('project.dir.data') . 'Host' . $this->object()->config('extension.json');
        $is_cms = false;
        $hosts = $this->object()->data_read($host_url);
        if($hosts){
            foreach($hosts->get() as $uuid => $host){
                if(
                    property_exists($host, 'subdomain') &&
                    $host->subdomain === 'cms'
                ){
                    $is_cms = true;
                    break;
                }
            }
        }
        if(
            $is_cms &&
            !empty($host) &&
            property_exists($host, 'subdomain') &&
            property_exists($host, 'host') &&
            property_exists($host, 'extension') &&
            property_exists($host, 'name')
        ){

            $host->scheme = Host::SCHEME_HTTPS;
            $host->url = $host->scheme . '://' . $host->name . '/';
            $this->object()->set('host', $host);;
        }
    }


    public function controller($title=''){
        $object = $this->object();
        $host = $object->get('host');
        if(
            property_exists($host, 'host') &&
            property_exists($host, 'extension')
        ){
            if(empty($host->subdomain)){
                $object->config('host.dir.root',
                    $object->config('project.dir.host') .
                    ucfirst($host->host) .
                    $object->config('ds') .
                    ucfirst($host->extension) .
                    $object->config('ds')
                );
            } else {
                $object->config('host.dir.root',
                    $object->config('project.dir.host') .
                    ucfirst($host->subdomain) .
                    $object->config('ds') .
                    ucfirst($host->host) .
                    $object->config('ds') .
                    ucfirst($host->extension) .
                    $object->config('ds')
                );
            }
            $object->config('host.dir.data',
                $object->config('host.dir.root') .
                $object->config(Config::DICTIONARY . '.' . Config::DATA) .
                $object->config('ds')
            );
            $object->config('host.dir.cache',
                Dir::name($object->config('framework.dir.cache'), 2) .
                $object->config(Config::DICTIONARY . '.' . Config::HOST) .
                $object->config('ds')
            );
            $object->config('host.dir.public',
                $object->config('host.dir.root') .
                $object->config(Config::DICTIONARY . '.' . Config::PUBLIC) .
                $object->config('ds'));
            $object->config('host.dir.source',
                $object->config('host.dir.root') .
                $object->config(Config::DICTIONARY . '.' . Config::SOURCE) .
                $object->config('ds'));
            $object->config('host.dir.view',
                $object->config('host.dir.root') .
                $object->config(Config::DICTIONARY . '.' . Config::VIEW) .
                $object->config('ds')
            );
        }
        dd($title);
    }
}