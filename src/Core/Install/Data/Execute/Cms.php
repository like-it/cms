<?php
namespace Execute;

use R3m\Io\Config;
use R3m\Io\Module\Dir;
use R3m\Io\Module\Host;

trait Cms {

    public function host(){
        $object = $this->object();
        $host_url = $object->config('project.dir.data') . 'Host' . $this->object()->config('extension.json');
        $is_cms = false;
        $hosts = $object->data_read($host_url);
        $host = false;
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
            $object->set('host', $host);;
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
        }
        return $host;
    }

    public function controller($title=''){
        $object = $this->object();
        $host = $object->get('host');
        $controller = [];
        $controller['name'] = strtolower($title);
        $controller['title'] = $title;
        $controller['class'] = 'Host\\' . ucfirst($host->subdomain) . '\\' . ucfirst($host->host) . '\\' . ucfirst($host->extension) . '\\Controller\\' . $controller['title'];
        $controller['dir'] = [];
        $controller['dir']['source'] =  $object->config('project.dir.host') .
            ucfirst($host->subdomain) .
            $object->config('ds') .
            ucfirst($host->host) .
            $object->config('ds') .
            ucfirst($host->extension) .
            $object->config('ds') .
            'Controller' .
            $object->config('ds');
        $controller['dir']['root'] =  $object->config('project.dir.host') .
            ucfirst($host->subdomain) .
            $object->config('ds') .
            ucfirst($host->host) .
            $object->config('ds') .
            ucfirst($host->extension) .
            $object->config('ds');
        $controller['dir']['data'] = $controller['dir']['root'] .
            $object->config('dictionary.data') .
            $object->config('ds');
        $controller['dir']['node'] = $controller['dir']['root'] .
            $object->config('dictionary.node') .
            $object->config('ds');
        $controller['dir']['plugin'] = $controller['dir']['root'] .
            $object->config('dictionary.plugin') .
            $object->config('ds');
        $controller['dir']['function'] = $controller['dir']['root'] .
            $object->config('dictionary.function') .
            $object->config('ds');
        $controller['dir']['model'] = $controller['dir']['root'] .
            $object->config('dictionary.model') .
            $object->config('ds');
        $controller['dir']['entity'] = $controller['dir']['root'] .
            $object->config('dictionary.entity') .
            $object->config('ds');
        $controller['dir']['service'] = $controller['dir']['root'] .
            $object->config('dictionary.service') .
            $object->config('ds');
        $controller['dir']['component'] = $controller['dir']['root'] .
            $object->config('dictionary.component') .
            $object->config('ds');
        $controller['dir']['view'] = $controller['dir']['root'] .
            $object->config('dictionary.view') .
            $object->config('ds');
        $controller['dir']['public'] = $controller['dir']['root'] .
            $object->config('dictionary.public') .
            $object->config('ds') .
            $controller['title'] .
            $object->config('ds');
        $object->config('controller', $controller);
        $object->set('controller', $controller);
        return $controller;
    }
}