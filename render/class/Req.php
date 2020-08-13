<?php

class Req {
    public $name;
    public $id;
    function __construct() {
        if ($_GET['link']) {
            $data = $_GET['link'];
            if (preg_match("/^[a-zA-Z0-9]+$/",$data) === 1) {
                $this->name = $data;
            } else {
                header('Location: /error');
            }    
        }
        if ($_GET['id']) {
            $data = $_GET['id'];
            if (preg_match("/^[0-9]+$/", $data) === 1) {
                $this->id = $data;
            }
        }
    }
}


