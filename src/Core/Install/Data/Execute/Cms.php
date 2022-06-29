<?php
namespace Execute;

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
        dd($this->object()->config('project.dir'));
        d($this->object()->get('host'));
        dd($title);
    }
}