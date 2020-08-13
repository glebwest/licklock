<?php

// страница перехода по ссылке

// отправляет запрос в базу данных, 
// проверяет валидность ссылки, 
// собирает информацию, 
// выполняет переход 
// и всё это из JS 

if ($this->way) {
    $_rand = random_int(10000,99999);
    ?>

<script src="<?php echo JS . 'main.js?' . $_rand ?>"></script>

<script>

let way = '<?php echo $this->way; ?>'

</script>

<script src="<?php echo JS . 'follow.js?' . $_rand ?>"></script>

<?php

} else {
    header('Loaction: /error');
}

