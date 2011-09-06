<?php

class ErrorController extends DooController {

    public function index() {
        echo '<h1>Error</h1>';
    }

    public function exception() {
        echo '<h1>'.$this->params['exception'].'</h1>';
    }
}
