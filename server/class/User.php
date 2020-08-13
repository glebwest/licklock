<?php

#       класс USER
#           отвечает за проверку, регистрацию, вход, выход, создание токена

class User {
    public $data = array();
    public function getUserByEmail($email) {
        $user = R::findOne('user','email = ?',[$email]);
        $this->data = $user;
        return ($user);
    }
    public function getUserByID($userID) {
        $user = R::findOne('user','id = ?',[$userID]);
        $this->data = $user;
        return ($user);
    }
    function genPass($len=8) {
        includeClass('Link');
        $Link = new Link();
        return $Link->genString($len,'pass');
    }
    function genToken($userID = null) {
        $token = $userID . time() . random_int(10000,99999);
        $token = password_hash($token,PASSWORD_BCRYPT);
        return $token;
    }
    public function setToken($userID,$sys) {
        $token = $this->genToken($userID);
        $sess = R::dispense('session');
        $sess->user = $userID;
        $sess->timing = date('Y-m-d H:i:s');
        $sess->token = $token;
        $sess->valid = 1;
        $sess->sys = $sys;
        R::store($sess);
        return $token;
    }
    public function newUser($email,$current = 0) {
        $pass = $this->genPass();
        $user = R::dispense('user');
        $user->current = $current;
        $user->email = $email;
        $user->timing = date('Y-m-d H:i:s');
        $user->hash = password_hash($pass,PASSWORD_BCRYPT);
        $user->valid = 1;
        R::store($user);
        $id = R::getInsertID();
        // отправить письмо на почту с паролем
        $to = $email;
        $subject = 'Войти в личный кабинет';
        $message = 'Благодарим за регистрацию на нашем сервисе. Загляните в личный кабинет.
        <br>Ваш логин: ' . $email .'
        <br>Ваш пароль: ' . $pass . '
        <br> Страница входа: <a href="lick.loc/login" target="_blank">lick.loc/login</a>';
        $headers = 'From: noreplay@lick.loc' . "\r\n" .
        'Reply-To: admin@lick.loc' . "\r\n" .
        'Content-type:text/html' . "\r\n";
        mail($to, $subject, $message, $headers);
        //
        $this->data = $user;
        return $id;
    }
    public function recoverPass() {
        $recover = $this->genPass();
        // Записать в базу данных
        $user = $this->data;
        $user->recover = password_hash($recover,PASSWORD_BCRYPT);
        R::store($user);
        // Отправить письмо на почту
        $to = $user['email'];
        $subject = 'Восстановление доступа';
        $message = 'Кто-то пытается восстановить доступ к Вашему аккаунту.
        <br> Если это не Вы, то просто проигнориуйте это письмо.
        <br> Старый пароль всё ещё действует.
        <br>Ваш новый пароль: ' . $recover .'
        <br> Страница входа: <a href="lick.loc/login" target="_blank">lick.loc/login</a>';
        $headers = 'From: noreplay@lick.loc' . "\r\n" .
        'Reply-To: admin@lick.loc' . "\r\n" .
        'Content-type:text/html' . "\r\n";
        mail($to, $subject, $message, $headers);
        return 1;
    }
    public function setUserStatus($type) {
        $user = $this->data;
        $status = R::dispense('status');
        $status->timing = date('Y-m-d H:i:s');
        $status->type = $type['id'];
        $status->user = $user['id'];
        R::store($status);
        $statusID = R::getInsertID();
        return $statusID;
    }
}
