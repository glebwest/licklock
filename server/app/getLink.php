<?php

# МЕТОД ВОЗВРАТА ССЫЛКИ ДЛЯ ПЕРЕХОДА И СОХРАНЕНИЯ СТАТИСТИКИ

/*

status = 0 (ошибка) || 1 (всё хорошо)
error = 
        1 - некорректное имя ссылки
        2 - отсутствую данные о пользователе
        3 - неизвестная ошибка
        4 - истёк срок действия ссылки
link = (ссылка для выполнения редиректа)

*/

$ans = array(
    'status' => null,
    'error' => null,
    'link' => null
);


$data = $this->request['data'];

$pattern = '/^[a-zA-Z0-9]+$/';

if ( preg_match( $pattern , $data['name']) === 1) {

    includeClass('Link');

    $Link = new Link();

    if ($link = $Link->getLink($data['name']) ) {

        // +++ ??? - проверить валидность ссылки по статусу пользователя
        $ans = $Link->checkLinkValid($link);
        // 3. Сравнить даты и сделать вывод о действительности статуса
        // 4. Выдать ошибку, если статус недействителен
        if ( !$ans['error'] ) {
            if ($data['follow']  ) {
                function isMobile() { 
                    if (preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"])){
                        return 1;
                    } else {
                        return 0;
                    }
                }
                // валидация данных перед записью ??
                $follow = R::dispense('follow');
                $follow->ip = $_SERVER['REMOTE_ADDR'];
                $follow->ismob = isMobile();
                $follow->year = date('Y');
                $follow->mouth = date('m');
                $follow->day = date('d');
                $follow->hour = date('H');
                $follow->link = $link['id'];
                $follow->tech = $data['follow']['tech'];
                $follow->country = $data['follow']['country'];
                $follow->town = $data['follow']['town'];
                R::store($follow);
                //
                $http = "/^[http]+/";
                if (preg_match($http,$link['longer']) === 1) {
                    // проверка пройдена
                    $ans['link'] = $link['longer'];
                } else {
                    // проверка не пройдена, подставляем http
                    $ans['link'] = 'http://' . $link['longer'];
                }
                $ans['status'] = 1;
            } else {
                // отсутствую данные о пользователе
                $ans['status'] = 0;
                $ans['error'] = 2;
            }
        }
    } else {
        $ans['status'] = 0;
        $ans['error'] = 1;
    }
} else {
    //
    $ans['status'] = 0;
    $ans['error'] = 1;
}


// Ответ сервера

$this->answerJson($ans);