<?php

# метод входа в аккаунт

/*

error = 
        1 - некорректные данные
        2 - нет пользователя
        3 - пароль неверный
*/


$ans = array(
    'status' => 0,
    'error' => null,
    'token' => null
);

$data = $this->request['data'];

$pattern = '/^[a-zA-Z0-9]+$/';

// 1. Проверить пользователя

if (
    filter_var($data['email'],FILTER_VALIDATE_EMAIL) != false &&
    preg_match($pattern,$data['pass']) === 1
) {

    includeClass('User');
    
    $USER = new User();

    if ( $user = $USER->getUserByEmail($data['email']) ) {
        // 2. Проверить пароль
        if (password_verify($data['pass'],$user['hash'])) {
            // пароль совпадает, выполняем генерацию токена и вход
            $user->recover = null;
            R::store($user);
            $ans['token'] = $USER->setToken($user['id'],$this->request['sys']);
            $ans['status'] = 1;
        } else {
            if (password_verify($data['pass'],$user['recover'])) {
                // перезапишем рековер в хэш
                $user->hash = $user['recover'];
                $user->recover = null;
                R::store($user);
                // выполняем генерацию токена и вход
                $ans['token'] = $USER->setToken($user['id'],$this->request['sys']);
                $ans['status'] = 1;
            } else {
                // все пароли неверны
                $ans['error'] = 3;
            }
        }
    } else {
        $ans['error'] = 2;
    }

} else {
    $ans['error'] = 1;
}

$this->answerJson($ans);