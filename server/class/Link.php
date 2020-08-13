<?php

class Link {
    public function genString($length = 6,$pattern = false) {
        if (!$pattern) {
            $chars = 'abdefhiknrstyz23456789';
        } else {
            switch ($pattern) {
                case 'pass':
                    $chars = 'abdefhiknrstyzABDEFGHKNQRSTYZ23456789';
                    break;
                case 'crash':
                    $chars = 'abcdef';
                    break;
                case 'uppercase':
                    $chars = 'abdefhiknrstyzABDEFGHKNQRSTYZ';
                    break;
                default:
                    $chars = 'abdefhiknrstyz';
                    break;
            }
        }
        $numChars = strlen($chars);
        $string = '';
        for ($i = 0; $i < $length; $i++) {
            $string .= substr($chars, rand(1, $numChars) - 1, 1);
        }
        return $string;
    }
    function genLink($type = 0) { 
        switch ($type) {
            case 0:  // стандартные 6 символов
                return $this->genString(6, 'uppercase');
                break;
            case 1: // тест на повторы
                return $this->genString(1,'crach');
                break;
            default:
                return $this->genString();
                break;
        }
    }
    public function checkLink($name) {
        // функция проверки линка через БД
        $link = R::findOne('link', 'name = ?', array($name));
        if ($link['id']) {
            // совпадение найдено
            return true;
        } else {
            return false;
        }
    }
    public function newLink() {
        $i = 0;
        do {
            $i = $i + 1;
            $name = $this->genLink();
        } while ( $this->checkLink($name) && ($i < 100) );
        if ($i < 100) {
            return $name;
        } else {
            return false;
        }
    }
    public function setLink($longer,$user = null) {
        $pattern = "/^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/";

        if (preg_match($pattern,$longer) != 1 ) {
            return false;
        } else {
            $namer = $this->newLink();
            if ($namer) {
                $curda = date('Y-m-d H:i:s');
                $query = R::dispense('link');
                if ($user) {
                    $query->user = $user;
                }
                $query->name = $namer;
                $query->longer = $longer;
                $query->timing = $curda;
                R::store($query);
                $id = R::getInsertID();
                return array(
                    'id' => $id,
                    'name' => $namer
                );
                // return $this->checkLink($namer);
            } else {
                return false;
                // return $this->checkLink($namer);
            }
        }
    }
    public function setUserOnLink($linkID,$userID) {
        if ($link = R::findOne('link','id = ?',array($linkID))) {
            if ($link->user) {
                return false;
            } else {
                $link->user = $userID;
                R::store($link);
                return true;
            }
        } else {
            return false;
        }
    }
    public function getLink($name) {
        // функция проверки линка через БД
        $link = R::findOne('link', 'name = ?', array($name));
        return $link;
    }
    public function checkLinkMath($link,$trial = 30) {
        $trial = $trial * 86400;
        if ( strtotime($link) + $trial  > time() ) {
            return true;
        } else {
            return false;
        }
    }
    public function checkLinkValid($link) {
        $ans = array(
            'status' => null,
            'error' => null,
            'link' => null
        );
        if ($link['user'] === '0') {
            // нулевой пользователь, проверить только дату (trial)
            if ($result = $this->checkLinkMath($link['timing'])) {
                //
                $ans['link'] = $link['longer'];
            } else {
                $ans['status'] = 0;
                $ans['error'] = 4;
            }
        } else {
            // 1. Запросить последний статус пользователя по id
            $status = R::getRow('SELECT * FROM status WHERE user = ? and enable = 1 ORDER BY timing DESC LIMIT 1',[$link['user']]);
            if ($status) {
                // 2. Запросить тип соответствующего статуса
                $type = R::findOne('type','id = ?',[$status['type']]);
                if ($this->checkLinkMath($status['timing'],$type['timing'])) {
                    $ans['link'] = $link['longer'];
                } else {
                    $ans['status'] = 0;
                    $ans['error'] = 4;
                }
            } else {
                // статус не подтверждён, проверить только дату (trial)
                if ($this->checkLinkMath($link['timing'])) {
                    $ans['link'] = $link['longer'];
                } else {
                    $ans['status'] = 0;
                    $ans['error'] = 4;
                }
            }
        }
        return $ans;
    }
}