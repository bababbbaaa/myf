<?php


/* @var $this yii\web\View */

use yii\helpers\Url;
use yii\helpers\Html;

$this->title = "Эвент-форма";

?>


<section class="article-1 article-form">
    <div class="article-form__container">
        <?= Html::beginForm(['site/event-send'], 'post', ['class' => "article-event-form"]) ?>
        <div class="article-event-form__container">
            <h3 class="article-form__header">Укажите ваши данные для связи</h3>
            <input type="hidden" class="article-from__event" name="title" value="<?= $title ?>">
            <input required class="article-form__input article-form__name" type="text" name="fio" placeholder="Имя">
            <input required class="article-form__input article-form__tel" type="tel" name="phone" placeholder="Телефон">
            <button type="submit" class="article-form__submit">Принять участие</button>
            <p class="article-form__subtitle">
                Нажимая «Зарегистрироваться» Вы соглашаетесь, что
                ознакомлены с условиями использования и политикой
                конфиденциальности
            </p>
        </div>
        <div class="article-event-form__success">
            <h3 class="article-from__success article-form__header">Благодарим за заявку!</h3>
            <p class="article-from__success article-form__text">
                Менеджер свяжется с вами в течение 3 минут
                и подробно вас проконсультирует
            </p>
        </div>
        <?= Html::endForm() ?>
    </div>
</section>

