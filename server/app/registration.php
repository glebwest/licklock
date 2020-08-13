<?php

# Метод регистрации пользователя по email

/*

error = 
        1 - некорректный email
        2 - пользователь уже есть

*/

$ans = array(
    'status' => 0,
    'error' => null
);

$data = $this->request['data'];

if (filter_var($data['email'],FILTER_VALIDATE_EMAIL) != false) {

    includeClass('User');
    
    $USER = new User();

    if (  $USER->getUserByEmail($data['email']) ) {
        $ans['error'] = 2;
    } else {
        if ($userID = $USER->newUser($data['email']) ) {
            // внести нулевой статус
            $type = R::findOne('type','code = ?',[201]);
            $USER->setUserStatus($type);
            $ans['status'] = 1;
        }
    }
} else {
    $ans['error'] = 1;
}

$this->answerJson($ans);