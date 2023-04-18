<?php


/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Вход';
$this->params['breadcrumbs'][] = $this->title;
$css =<<< CSS
    .site-login{
        padding: 100px 20px;
        text-decoration: none;
    }
    .title__login__form{
        margin-bottom: 15px;
        text-decoration: none;
        color: #43419e;
    }
    .subtitle__login__form{
        margin-bottom: 20px;
        font-size: 18px;
        color: #43419e;
    }
    .site-login::after{
        display: none;
    }
CSS;
$this->registerCss($css);
?>
<div class="site-login container">
    <h1 class="title__login__form"><?= Html::encode($this->title) ?></h1>

    <p class="subtitle__login__form">Пожалуйста, заполните следующие поля для входа:</p>

    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>

                <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>

                <?= $form->field($model, 'password')->passwordInput() ?>

                <?= $form->field($model, 'rememberMe')->checkbox()->label('Запомнить меня') ?>

                <div style="color:#999;margin:1em 0">
                    Если вы забыли пароль, вы можете <?= Html::a('сбросить его', ['site/request-password-reset']) ?>.
                    <br>
                    Нужна новая проверка электронной почты? <?= Html::a('Отправить', ['site/resend-verification-email']) ?>
                </div>

                <div class="form-group">
                    <?= Html::submitButton('Вход', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
                </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
