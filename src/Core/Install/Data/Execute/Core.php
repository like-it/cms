<?php
namespace Execute;

trait Core {

    public function async($command){
        \R3m\Io\Module\Core::async($command);
    }

    public function execute($command, &$output, $type){
        \R3m\Io\Module\Core::execute($command, $output, $type);
    }

}