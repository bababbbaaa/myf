<?php


$this->title = "Успешно!";

if (!empty($redirect))
    $url = $redirect;
else
    $url = "https://user.myforce.ru";

$js = <<<JS
var 
    url = '$url',
    seconds = 3;
setInterval(function() {
    if(seconds > 0) 
        $('.redirect-sec').text(--seconds);
    else
        location.href = url;
}, 1000);
JS;

$this->registerJs($js);

?>
<style>
    .main-title {
        margin: 200px auto 130px;
        text-align: center;
        font-size: 40px;
    }
</style>
<div class="main-title">
    <p><b>Спасибо за покупку!</b></p>
    <p style="font-size: 20px; margin-top: 20px"><a href="<?= $url ?>">Перенаправление через <span class="redirect-sec">3</span></a></p>
</div>
