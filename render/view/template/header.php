<?php

$_rand = random_int(10000,99999);

?>

<!DOCTYPE html>
<html lang="ru-RU">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Генератор коротких ссылок</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo CSS . 'main.css?' . $_rand ?>">
    <script src="<?php echo JS ?>main.js?<?php echo $_rand ?>"></script>
</head>
<body>
    
<header>
    <div class="burger">
        <div class="line"></div>
        <div class="line"></div>
        <div class="line"></div>
    </div>
    <div class="menu">
        <a href="/" class="menu-el">Генератор</a>
        <a href="/lk" class="menu-el">Кабинет</a>
        <a href="/cost" class="menu-el">Тарифы</a>
        <a href="/help" class="menu-el">Помощь</a>
    </div>
    <div class="login">
        <div class="login-list">
            <p class="loginName"></p>
            <object data="/render/content/img/svg/login.svg"></object>
        </div>
    </div>
</header>

<script src="<?php echo JS ?>app.js?<?php echo $_rand ?>"></script>