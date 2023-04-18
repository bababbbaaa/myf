<?php

use yii\helpers\Url;
use yii\helpers\Html;

$js = <<< JS
function inputFile(){
    let inputs = document.querySelectorAll('.input__file');
    Array.prototype.forEach.call(inputs, function (input) {
      let label = input.nextElementSibling,
        labelVal = label.querySelector('.input__file-button-text').innerText;
  
      input.addEventListener('change', function (e) {
        let countFiles = '';
        if (this.files && this.files.length >= 1)
          countFiles = this.files.length;
  
        if (countFiles > 1)
          label.querySelector('.input__file-button-text').innerText = 'Загружено ' + countFiles;
        else if (countFiles = 1)
          label.querySelector('.input__file-button-text').innerText = 'Загружено';
        else
          label.querySelector('.input__file-button-text').innerText = labelVal;
      });
    });
}

inputFile();

    $('.popups-back, .PopapExidIcon, .PopapDCD2_Form-BTN').on('click', function(){
        $('.popups-back').fadeOut(300);
        $('.PopapDBCWrap, .PopapDCD2').fadeOut(300);
    });

    $('.specialistorder-form').on('submit', function (e) {
        $.ajax({
            url: "scripts/",
            method: "POST",
            data: $(this).serialize(),
            beforeSend: function (){
                $('.popups-back, .PopapDBCWrap, .PopapDCD2').fadeIn(300);
            },
        });
        e.preventDefault();
    });
JS;
$this->registerJs($js);

$this->title = 'Предложить заказ';
?>

<section class="rightInfo sp">
    <div class="bcr">
        <ul class="bcr__list">
            <li class="bcr__item">
                <span class="bcr__link">
                    Выбрать исполнителя
                </span>
            </li>
            <li class="bcr__item">
                <a class="bcr__link" href="<?= Url::to(['choose']) ?>">Все исполнители</a>
            </li>
            <li class="bcr__item">
                <span class="bcr__span">
                    Святослав Василевский
                </span>
            </li>
        </ul>
    </div>

    <div class="title_row">
        <h1 class="Bal-ttl title-main">Святослав Василевский</h1>
    </div>

    <article class="choose">
        <div class="choose_main">
            <section class="specialist-main_card">
                <h2 class="specialist-main_card-ttl">Предложение заказа</h2>

                <?= Html::beginForm('', 'post', ['class' => 'specialistorder-form']) ?>
                    <div class="specialistorder_container">
                        <h3 class="specialistorder-ttl">Введите название вашего проекта</h3>
                        <input style="max-width: 446px;" required type="text" name="name" placeholder="Введите текст" minlength="1" class="input-t">
                        <div class="specialistorder-line"></div>
                        <h3 class="specialistorder-ttl">Опишите подробно задачу</h3>
                        <textarea class="input-t input-textarea" name="description" required minlength="1" placeholder="Введите текст"></textarea>
                        <div class="input__wrapper specialistorder_input-file">
                            <input name="file" type="file" id="input__file" class="input input__file">
                            <label for="input__file" class="input__file-button">
                                <span class="input__file-button-text">Прикрепить файл</span>
                            </label>
                        </div>
                        <div class="specialistorder-line"></div>
                        <h3 class="specialistorder-ttl">Укажите дату готовности заказа</h3>
                        <input required style="max-width: 446px;" type="date" placeholder="Введите дату" name="date" class="input-t input-date">
                        <div class="specialistorder-line"></div>
                        <h3 class="specialistorder-ttl">Уточните бюджет проекта</h3>
                        <div class="specialistorder-group">
                            <input required type="number" name="summ" placeholder="Введите сумму" class="input-t input-summ">
                            <p class="specialistorder-group-text">рублей</p>
                        </div>
                        <div class="specialistorder-group-last">
                            <button style="max-width: fit-content;" class="btn--purple">Предложить заказ</button>
                            <a style="text-decoration: none;" class="link--purple" href="javascript:history.back()">Вернуться на страницу исполнителя</a>
                        </div>
                    </div>
                <?= Html::endForm(); ?>
            </section>
        </div>
        <div class="specialist_right">
            <section class="specialist_card">
                <div class="specialist_card_top">
                    <div class="specialist_card_top-image">
                        <img src="<?= Url::to('/img/afo/best1.svg') ?>" alt="1">
                    </div>
                    <div class="specialist_card_top_right">
                        <div class="specialist_card_top_right-top">
                            <p class="spetialist-card_top_right-rating">
                                <svg width="16" height="17" viewBox="0 0 16 17" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M8.27569 12.4208L11.4279 14.4179C11.8308 14.6732 12.3311 14.2935 12.2115 13.8232L11.3008 10.2405C11.2752 10.1407 11.2782 10.0357 11.3096 9.9376C11.3409 9.83946 11.3994 9.75218 11.4781 9.68577L14.3049 7.33306C14.6763 7.02392 14.4846 6.40751 14.0074 6.37654L10.3159 6.13696C10.2165 6.12986 10.1211 6.09465 10.0409 6.03545C9.96069 5.97625 9.89896 5.89548 9.86289 5.80255L8.48612 2.33549C8.44869 2.23685 8.38215 2.15194 8.29532 2.09201C8.2085 2.03209 8.1055 2 8 2C7.89451 2 7.79151 2.03209 7.70468 2.09201C7.61786 2.15194 7.55131 2.23685 7.51389 2.33549L6.13712 5.80255C6.10104 5.89548 6.03931 5.97625 5.95912 6.03545C5.87892 6.09465 5.78355 6.12986 5.68412 6.13696L1.99263 6.37654C1.51544 6.40751 1.32373 7.02392 1.69515 7.33306L4.52185 9.68577C4.60063 9.75218 4.65906 9.83946 4.69044 9.9376C4.72181 10.0357 4.72485 10.1407 4.6992 10.2405L3.85459 13.563C3.71111 14.1274 4.31143 14.583 4.79495 14.2767L7.72431 12.4208C7.8067 12.3683 7.90234 12.3405 8 12.3405C8.09767 12.3405 8.1933 12.3683 8.27569 12.4208Z" fill="#2CCD65" stroke="#2CCD65" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                <span>5.0</span>
                            </p>
                            <div class="spetialist-card_top_right-spetial">
                                <img src="<?= Url::to('/img/afo/best3.svg') ?>" alt="1">
                                <p class="spetialist-card_top_right-spetial-txt">адепт</p>
                            </div>
                        </div>
                        <div class="specialist_card_top_right_btn">
                            <p class="specialist_card_top_right_btn-t">зарегистрирован</p>
                            <p class="specialist_card_top_right_btn-date">12.01.2022</p>
                        </div>
                    </div>
                </div>
                <p class="specialist_card-name">Святослав Василевский</p>
                <p class="specialist_card-ttl">специализации</p>
                <ul class="spetialist-card_tags">
                    <li>#поисковые системы</li>
                    <li>#e-mail маркетинг</li>
                    <li>#Facebook</li>
                    <li>#SEO-оптимизация</li>
                    <li>#e-mail маркетинг</li>
                    <li>#Telegram</li>
                    <li>#SEO-оптимизация</li>
                    <li>#e-mail маркетинг</li>
                    <li>#Facebook</li>
                </ul>
                <p class="specialist_card-ttl">Статистика заказов</p>
                <div class="specialist_card-group">
                    <div class="specialist_card-group-item">
                        <p class="specialist_card-group-item-t">Всего</p>
                        <p class="specialist_card-group-item-t">6</p>
                    </div>
                    <div class="specialist_card-group-item">
                        <p class="specialist_card-group-item-t">В работе</p>
                        <p class="specialist_card-group-item-t">2</p>
                    </div>
                    <div class="specialist_card-group-item">
                        <p class="specialist_card-group-item-t">Завершенные</p>
                        <p class="specialist_card-group-item-t">4</p>
                    </div>
                </div>
            </section>
        </div>
    </article>

    <footer class="footer">
        <div class="container container--body">
            <a href="<?= Url::to(['manual']) ?>" class="footer__link">
                Руководство пользователя
            </a>
            <a href="<?= Url::to(['support']) ?>" class="footer__link">
                Тех.поддержка
            </a>
        </div>
    </footer>
</section>

<div class="popups-back"></div>
<div class="PopapDBCWrap">
    <div class="PopapDCD2">
        <img class="PopapExidIcon uscp" src="<?= Url::to(['/img/delete.png']) ?>" alt="Крестик">
        <div class="PopapDBC-Cont df fdc aic">
            <img class="PopapDCD2img" src="<?= Url::to(['/img/success.svg']) ?>" alt="Галочка">
            <h2 class="PopapDCD2-ttl">Заказ отправлен!</h2>
            <h3 class="PopapDCD2-subttl">Ожидайте ответ исполнителя на странице заказа</h3>
            <p class="btn--purple PopapDCD2_Form-BTN BText df jcc aic uscp">Понятно</p>
        </div>
    </div>
</div>