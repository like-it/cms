<?php
namespace Execute;

trait Cms {

    public function host(){
        dd($this->object());
    }


    public function controller($title=''){
        dd($title);
    }
}