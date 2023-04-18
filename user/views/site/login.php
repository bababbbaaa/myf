<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Вход';
$js =<<< JS
        $('#loginform-username').on('input', function() {
            var name = $(this).val();
            var change = name.replace(/[^0-9]/g, '');
            $(this).val(change);
        })
JS;
$this->registerJs($js);
$css = <<< CSS
    .site-login{
        min-height: 100vh;
        display: flex;
    }
    .site_block{
        margin: auto;
        border: 1px solid #b8c6ff;
        padding: 20px;
        width: 100%;
        max-width: 300px;
        border-radius: 10px;
        box-shadow: 0 0 20px #8a9fff;
    }
    h1{
        text-align: center;
        margin-bottom: 15px;
    }
    .p_login{
        font-size: 14px;
        margin-bottom: 10px;
    }
    .control-label{
        font-size: 16px;
        margin-bottom: 10px;
        font-weight: 600;
    }
    .form-group{
        margin-bottom: 10px;
        justify-content: space-between;
        align-items: center;
        flex-direction: column;
    }
    .form-control{
        padding: 10px;
        border-radius: 10px;
        font-size: 14px;
        color: #0b93d5;
        outline: none;
        background-color: inherit;
        border-image: none;
        border: 1px solid #0b93d5;
    }
    .help-block-error{
        margin: 10px 0;
        color: red;
        font-size: 14px;
    }
    .checkbox label{
        font-size: 14px;
    }
    #login-form {
        max-width: 200px;
        margin: 15px auto;
    }
CSS;
$this->registerCss($css)
?>
<div class="site-login">
    <div class="site_block">
    <h1><?= Html::encode($this->title) ?></h1>

            <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>

                <?= $form->field($model, 'username')->textInput(['class' => 'login_inputsUser form-control', 'autofocus' => true, 'placeholder' => '79_________', 'type' => 'tel'])->label(false) ?>

                <?= $form->field($model, 'password')->passwordInput(['placeholder' => 'Ваш пароль'])->label(false) ?>

                <?= $form->field($model, 'rememberMe')->checkbox()->label('Запомнить меня') ?>

                <div class="form-group">
                    <?= Html::submitButton('Вход', ['class' => 'btn btn-primary btn-block', 'name' => 'login-button']) ?>
                </div>

            <?php ActiveForm::end(); ?>
    </div>
</div>