<?php


/// ЕГО ВЕЛИЧЕСТВО ГЕНЕРАТОР

include TEMP . 'header.php';

?>

<style>

@import url(/render/content/css/gen.css);

</style>


<div class="content">
    <div class="container">
        <h1>Генератор коротких ссылок</h1>
        <form class="linkGen">
            <p class="errMess"></p>
            <input type="text" placeholder="длинная ссылка" class="longer active">
            <input type="button" value="Создать" class="setLink" disabled>
            <div class="resultLink">
                <p>Короткая ссылка: <a class="thisIsLink" href="" target="_blank"></a></p>
                <input type="button" value="Копировать" class="copyLink active">
            </div>
            <div class="saveLinkBlock">
                <p>Сохраните ссылку к аккаунту, чтобы продлить её действие</p>
                <input type="email" class="mailLink active" placeholder="введите email">
                <div class="tax-list">
                    <input type="radio" name="tax" id="r1" value="201">
                    <label for="r1">
                        <h4>FREE</h4>
                        <p>0 р./мес</p>
                        <p>5 ссылок на 30 дней</p>
                    </label>
                    <input type="radio" name="tax" id="r2" value="301" checked>
                    <label for="r2">
                        <h4>BASE</h4>
                        <p>290 р./мес</p>
                        <p>100 ссылок</p>
                    </label>
                    <input type="radio" name="tax" id="r3" value="401">
                    <label for="r3">
                        <h4>PRO</h4>
                        <p>490 р./мес</p>
                        <p>безлимит</p>
                    </label>
                </div>
                <p class="knowThis">Нажимая на кнопку "Продолжить" Вы подтверждаете подробное ознакомление и полное, безоговорочное согласие с <a href="/terms" target="_blank" rel="noopener noreferrer">Правилами работы сайта</a></p>
                <input type="button" value="Продолжить" class="saveLink">
            </div>
            <p class="linkHelper">Продолжить</p>
            <input type="button" value="Создать другую ссылку" class="reloadLink">
            <div class="spin">
                <svg class="spinner" viewBox="0 0 50 50">
                    <circle class="path" cx="25" cy="25" r="20" fill="none" stroke-width="5"></circle>
                </svg>
            </div>
        </form>
    </div>
</div>





<script src="<?php echo JS . 'gen.js' ?>"></script>

<?

include TEMP . 'footer.php';