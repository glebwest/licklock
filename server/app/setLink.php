<?php

#   метод генерации короткой ссылки на основе длинной

// токен нужен для проверки авторизации
// если токен есть, то ссылка автоматически будет приписана к аккаунту на условиях его использования


$result = $this->checkToken($this->request['token'],$this->request['sys']);

includeClass('Link');

$Link = new Link();

$this->answerJson($Link->setLink($this->request['data']['longer'],$result['user']));
