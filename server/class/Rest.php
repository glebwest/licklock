<?php

# API REST

class Rest {
    public $request = array();
    public function answerJson($object) {
        echo (json_encode(array('ans' => $object)));
    }
    public function init() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_REQUEST['JSON'] = json_decode(
                file_get_contents('php://input'), true
            );
            // инициализация выполнена
            if (!$_REQUEST['JSON']['data']) {
                $this->answerJson('Null data');
            } else {
                $this->request = $_REQUEST['JSON'];
            }
        } else {
            // ошибка: запрос не пост и не JSON
            $this->answerJson('Unxepted data');
        }
    }
}