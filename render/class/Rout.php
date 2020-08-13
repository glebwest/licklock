<?php

// includeClass('DataBase');

class Rout {
    public $list = array();
    public $id;
    public $method;
    public $way;
    public function setRout($name) {  
        $this->list[] = ['name' => $name, 'rout' => $name];
    }
    public function includePage($name) {
        return(include PAGE . $name . '.php');
    }
    public function getRout($way) {
        if ($way === null) {
            $this->includePage('main');
        } else {
            # check list of routs
            foreach ($this->list as $li) {
                if ($way === $li['name']) {
                    $this->method = $li['rout'];
                }
            }
            if (!$this->method) {
                # page not found, let search into DB
                $this->way = $way;
                $this->includePage('follow');
            } else {
                # return page
                $this->includePage($this->method);
            }    
        }
    }
}