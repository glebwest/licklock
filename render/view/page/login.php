<?php


/// Страница входа ГЫ

include TEMP . 'header.php';

?>

<script>
    App.goFlag = true
    App.goValue = 'lk'
</script>

<style>

@import url(/render/content/css/login.css);

</style>


<div class="content">
    <div class="container">
        <h1>Добро пожаловать!</h1>
        <p class="thanksRecomend">Использутей email для входа или создания нового аккаунта</p>
        <form class="logIn">
            <p class="errMess"></p>
            <div class="block block1 active">
                <input type="email" placeholder="логин" class="userName active">
                <input type="button" value="Продолжить" class="letNext active">
                <input type="button" value="Создать аккаунт" class="letReg active">
                <p class="knowThis active">Нажимая на кнопку "Создать аккаунт" Вы подтверждаете подробное ознакомление и полное, безоговорочное согласие с <a href="/terms" target="_blank" rel="noopener noreferrer">Правилами работы сайта</a></p>
            </div>
            <div class="block block2">
                <input type="password" placeholder="пароль" class="userPass active">
                <input type="button" value="Войти" class="letLogin active">
                <input type="button" value="Не помню пароль" class="letRecover active">
            </div>
            <div class="spin">
                <svg class="spinner" viewBox="0 0 50 50">
                    <circle class="path" cx="25" cy="25" r="20" fill="none" stroke-width="5"></circle>
                </svg>
            </div>
        </form>
    </div>
</div>



<script src="<?php echo JS ?>login.js?<?php echo $_rand ?>"></script>