<?php


/// ЛИЧНЫЙ КАБИНЕТ

include TEMP . 'header.php';

?>

<script>
    App.goFlag = false
    App.goValue = 'login'
</script>

<style>

@import url(/render/content/css/lk.css);

</style>



<div class="content">
    <div class="container">
        <h1>Личный кабинет</h1>
    </div>
    <div class="lk">
        <div class="lk-menu">
            <div class="lk-menu-el active" data-tab="pro" data-method="getUserProfile">Профиль</div>
            <div class="lk-menu-el" data-tab="lin" data-method="getUserLinks">Ссылки</div>
            <div class="lk-menu-el" data-tab="paym" data-method="getUserPayment">Счета</div>
        </div>
        <div class="lk-tabs">
            <div class="lk-tab" data-tab="pro"></div>
            <div class="lk-tab" data-tab="lin"></div>
            <div class="lk-tab" data-tab="paym"></div>
            <div class="spin">
                <svg class="spinner" viewBox="0 0 50 50">
                    <circle class="path" cx="25" cy="25" r="20" fill="none" stroke-width="5"></circle>
                </svg>
            </div>
        </div>
    </div>
</div>



<script src="<?php echo JS ?>lk.js?<?php echo $_rand ?>"></script>