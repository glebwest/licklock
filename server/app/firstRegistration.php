<?php

# метод регистрации пользователя и прикрепления к нему ссылки + создания транзакции


// status = 0 (если есть ошибки) || 1 (если всё хорошо) || 2 (бесплатный тариф, без транзакции)
// error = код ошибки = 
//                      1 (некорректные данные) 
//                      2 (пользователь уже есть)
//                      3 (неопознанная ошибка) 
// pay = id транзакции для перехода на платёжную страницу

$ans = array(
    'status' => null,
    'error' => null,
    'pay' => null
);


// 0. Валидация данных
// 1. Проверить, корректен ли email

$data = $this->request['data'];

$pattern = '/^[0-9]+$/';

if ( preg_match(
    $pattern,$data['link']) === 1 &&
    preg_match($pattern,$data['tax']) === 1 &&
    filter_var($data['email'], FILTER_VALIDATE_EMAIL) != false ) {
    //
    // 2. Проверить, есть ли пользователь с таким email
    includeClass('User');

    $USER = new User();

    $user = $USER->getUserByEmail($data['email']);

    if ($user) {
        // пользователь есть - ошибка, рекомендуем сначала войти в аккаунт, а уже потом создавать ссылки
        $ans['status'] = 0;
        $ans['error'] = 2;
    } else {
        // пользователя нет - хорошо, продолжаем, создаём нового пользователя
        
        // 3. Зарегистировать нового пользователя (с генерацией пароля)

        $userID = $USER->newUser($data['email']);

        // 4. Прикрепить к ссылке id нового пользователя

        includeClass('Link');

        $Link = new Link();

        if ( $result = $Link->setUserOnLink($data['link'],$userID) ) {
            // 5. Внести пользователя в таблицу статусов
            if ($type = R::findOne('type','code = ? and enable = 1', [ $data['tax'] ])) {
                $statusID = $USER->setUserStatus($type);
                // 6. Создать транзакцию (счёт на оплату)
                if ($type['name'] === 'FREE') {
                    // транзакцию не создаём, сразу выполняем вход в аккаунт
                    $ans['status'] = 2;
                } else {
                    // создаём транзакцию
                    includeClass('Payment');
                    $Pay = new Payment();
                    if ($transID = $Pay->newTransaction($userID,$statusID,$type['summ'])) {
                        $ans['status'] = 1;
                        $ans['pay'] = $transID;
                    }
                }
            } else {
                $ans['status'] = 0;
                $ans['error'] = 1;
            }
        } else {
            $ans['status'] = 0;
            $ans['error'] = 3;
        }
    }

} else {
    $ans['status'] = 0;
    $ans['error'] = 1;
}


// 7. Вернуть результат

$this->answerJson($ans);