<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use yii\helpers\Html;

$this->title = "Ошибка #{$exception->statusCode}";
?>
<style>
    .site-error {
        display: flex; align-items: center; flex-direction: column; height: 100%; justify-content: center;
        position: relative;
    }
    .error-wrapper {
        height: 100%; width: 100%; top: 0; left: 0
    }
    .big-error {
        font-size: 100px;
        font-weight: 900;
        line-height: 94px;
        /*background: -webkit-linear-gradient(#ee1f00, #8e3a37);*/
        background: -webkit-linear-gradient(#8c998f, #92e3a9);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        letter-spacing: 0.2em;
    }
</style>
<div class="error-wrapper">
    <div class="site-error" style="">
        <h1 class="big-error"><?= $exception->statusCode ?></h1>

        <div class="alert alert-danger" style="margin-top: 20px; letter-spacing: 0.1em">
            <?= nl2br(Html::encode($exception->getMessage())) ?>
        </div>

        <div>
            <img src="<?= \yii\helpers\Url::to(['img/erpage.png']) ?>" style="max-width: 300px; width: 100%" alt="">
        </div>

        <div class="text__block">

        </div>
        <div style="text-align: center; font-size: 14px; color: #9e9e9e; max-width: 600px; margin: 20px auto">
            <p>
                Техническая поддержка  +7 495 118 39 34
            </p>
            <p style="margin-top: 10px; font-weight: 700;"><a href="javascript:history.go(-1)">вернуться назад</a></p>
        </div>

    </div>
</div>
