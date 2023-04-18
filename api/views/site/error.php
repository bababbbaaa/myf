<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use yii\helpers\Html;

$this->title = "#{$exception->statusCode}";


switch ($exception->statusCode) {
    case 404:
        $msg = 'Страница не найдена';
        break;
    case 403:
        $msg = 'Недостаточно привилегий для совершения указанного действия';
        break;
    case 400:
        $msg = 'Неправильный формат запроса';
        break;
    case 500:
        $msg = 'Внутренняя ошибка сервера';
        break;
    case 405:
        $msg = 'Использование запрещенного метода';
        break;
    default:
        $msg = $exception->getMessage();
}


?>
<div class="site-error">
    <h1 class="monospace" style="font-size: 60px; margin-top: 0"><b style="color: #ff5050"><?= Html::encode($this->title) ?></b></h1>

    <div style="margin-bottom: 20px; font-size: 20px">
        <b class="monospace" style="color: wheat"><?= nl2br(Html::encode($msg)) ?></b>
    </div>

    <div class="rbac-info"> Данная ошибка возникла в результате запроса на указанный URL. <br>Для получения дополнительной информации свяжитесь с технической поддержкой, указав код ошибки.</div>

</div>
