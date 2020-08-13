<?php

# Метод проверки пользователя перед входом

/*


error = 
        1 - некорректный email
user = 
        0 - пользователя нет
        1 - пользователь уже есть
*/

$ans = array(
    'status' => 0,
    'error' => null,
    'user' => null
);

$data = $this->request['data'];

if (filter_var($data['email'],FILTER_VALIDATE_EMAIL) != false) {

    $ans['status'] = 1;

    includeClass('User');
    
    $USER = new User();

    if (  $USER->getUserByEmail($data['email']) ) {
        $ans['user'] = 1;
    } else {
        $ans['user'] = 0;
    }
} else {
    $ans['error'] = 1;
}

$this->answerJson($ans);