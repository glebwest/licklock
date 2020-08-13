<?php

# API ROUT

class Rout {
    public function answerJson($object) {
        echo (json_encode(array('ans' => $object)));
    }
    public $list = array();
    public $method;
    public $session;
    public $err;
    public $request;
    public function setRout($name,$protect = false) {
        $this->list[] = ['name' => $name, 'rout' => $name, 'protect' => $protect];
    }
    public function includeApp($name) {
        return(include APP . $name . '.php');
    }
    public function checkToken($token,$sys) {
        $sess = R::findOne('session','token = :tok and sys = :sys and valid = :val',[ ':tok' => $token, ':sys' => $sys, ':val' => 1]);
        if ($sess['id'] ) {
            // успех
            return $sess;
        } else {
            // провал
            return false;
        }
    }
    public function getRout($request) {
        $way = $request['method'];
        $token = $request['token'];
        $sys = $request['sys'];
        $this->request = $request;
        if ($way === null ) {
            // ошибка! - нет метода
            $this->answerJson(false);
        } else {
            # check list of routs
            foreach ($this->list as $li) {
                if ($way === $li['name']) {
                    if ($li['protect'] ) {
                        // вызов метода проверки токена
                        if ($result = $this->checkToken($token,$sys) ) {
                            $this->session = $result;
                            $this->method = $li['rout'];
                        }
                    } else {
                        $this->method = $li['rout'];
                    }
                }
            }
            if ($this->method) {
                # return app
                $this->includeApp($this->method);
            } else {
                # app not found
                # it's a error !!!
                $this->answerJson(false);
            }    
        }
    }
}