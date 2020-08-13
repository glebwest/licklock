<?php

# метод восстановления доступа

/*

error = 
        1 - некорректные данные
        2 - нет такого пользователя


*/

$ans = array(
    'status' => 0,
    'error' => null
);

// 1. Проверить пользователя

$data = $this->request['data'];

if (filter_var($data['email'],FILTER_VALIDATE_EMAIL) != false) {
    //
    includeClass('User');
    
    $USER = new User();
    //
    if ( $USER->getUserByEmail($data['email']) ) {
        $ans['status'] = $USER->recoverPass();
    } else {
        $ans['error'] = 2;
    }
} else {
    $ans['error'] = 1;
}


$this->answerJson($ans);