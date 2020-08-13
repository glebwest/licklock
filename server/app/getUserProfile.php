<?php

# Метод, который возвращает данные о профиле пользователя из личного кабинета

$ans = array(
    'status' => 0,
    'error' => null,
    'user' => null,
    'lastStatus' => null,
    'countSess' => null,
    'tarif' => null
);

// 1. Пользователь из таблицы USER

includeClass('User');

$USER = new User();

$user = $USER->getUserByID($this->session['user']);

unset($user['hash']);
unset($user['recover']);
unset($user['id']);
unset($user['current']);
unset($user['valid']);

$ans['user'] = $user;

// 2. Последняя валидная запись status

$ans['lastStatus'] = R::getRow('SELECT * FROM status WHERE user = ? and enable = 1 ORDER BY timing DESC LIMIT 1',[$this->session['user']]);

// 3. Количество активных сессий session

$ans['countSess'] = R::count('session','user = ? and valid = 1',[$this->session['user']]);

// 4. Сведения о тарифе

if ($ans['lastStatus']) {
    $ans['tarif'] = R::findOne('type','id = ?',$ans['lastStatus']['type']);
}

if (!$ans['error']) {
    $ans['status'] = 1;
}

$this->answerJson($ans);