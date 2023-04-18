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


$css =<<< CSS
    .header {
        background: #000E1A;
        border-bottom: none;
    }

    .header__active {
        animation-name: none;
    }

    a,
    a:hover,
    a:active,
    a:focus{
        color: #DF2C56;
    }
CSS;
$this->registerCss($css)
?>
<main class="main">
    <div style="min-height: calc(100vh - 685px)" class="article-1">
        <div style="padding-top: 30px;" class="container">
            <div class="site-error">

                <h1 style="margin-bottom: 15px">Ошибка <?= Html::encode($this->title) ?></h1>

                <div class="alert alert-danger">
                    <b class="monospace" style="color: #303030">Текст ошибки: <?= nl2br(Html::encode($msg)) ?></b>

                </div>

                <p>
                    Техническая поддержка: <a href="tel:84951183934">8 495 118 39 34</a>
                </p>

            </div>
        </div>

    </div>

</main>