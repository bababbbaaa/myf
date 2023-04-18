<?php

use user\modules\lead_force\controllers\ClientController;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;

$this->title = 'Создать свой заказ';
/**
 * @var \yii\web\View $this
 */
$js = <<<JS
    $('.chosen-select').chosen();
    $("#form-lid-add").on("submit", function (e) {
        e.preventDefault();
        var formThis = this;
        $.ajax({
            url: "create-new-order-ticket",
            type: "POST",
            data: $(this).serialize(),
        }).done(function (response) {
            if (response.status === 'success') {
                $(formThis).children(".spop").fadeIn(300);
            } else {
                $('.rsp-ajax-text').text(response.message);
                $(formThis).children(".popup--auct-err").fadeIn(300);
            }
        });
    });
    $('.multi-reg-add').on('input', function() {
        if ($(this).val().length > 0) {
            $(".add--2").prop("disabled", false);
        } else
            $(".add--2").prop("disabled", true);
    });
    $('.timepick').timepicker({ 'timeFormat': 'H:i', 'step': 60 });
    
    var count = 1;
    var timeout = setTimeout(function() {
      $.ajax({
        url: 'input-check',
        dataType: 'JSON',
        data: {count: count},
        type: 'POST',
      }).done(function() {
        $.pjax.reload({container: '#cardContainer'});
      });
    }, 1000);

    $('#leads__count').on('input', function() {
        
        var count = $(this).val();
        if (count.length < 1){
            count = 1;
        }
        clearTimeout(timeout);
        timeout = setTimeout(function() {
          $.pjax.reload({
            url: 'order-lid-add',
            data: {count: count},
            type: 'GET',
            container: '#cardContainer',
          })
        }, 1000);
        });
JS;
$this->registerCssFile(Url::to(['/css/chosen.min.css']));
$this->registerJsFile(Url::to(['/js/chosen.jquery.min.js']), ['depends' => \yii\web\JqueryAsset::class]);
$this->registerCssFile(Url::to(['/css/jquery.timepicker.css']));
$this->registerJsFile(Url::to(['/js/jquery.timepicker.min.js']), ['depends' => \yii\web\JqueryAsset::class]);
$this->registerJs($js);
?>
<style>
    .chosen-container-multi .chosen-choices li.search-field input[type=text] {
        font-family: 'Poppins', sans-serif;
    }
</style>
<section class="rightInfo">

    <?php if (empty($client) || !ClientController::fullInfo($client)): ?>
    <section class="rightInfo rightInfo_no-orders">
        <div class="bcr">
            <ul class="bcr__list">
                <li class="bcr__item">
            <span class="bcr__link">
                Создать заказ
            </span>
                </li>

                <li class="bcr__item">
            <span class="bcr__span">
              Заполните профиль
            </span>
                </li>
            </ul>
        </div>
        <div class="title_row">
            <p class="Bal-ttl title-main">Создать заказ</p>
        </div>
        <section class="rightInfo_no-orders_info">
            <img class="rightInfo_no-orders_info-back"
                 src="<?= Url::to(['/img/rightInfo_no-orders-back.svg']) ?>" alt="иконка">
            <h2 class="rightInfo_no-orders_info_title">
                У вас еще не заполнен профиль
            </h2>
            <p class="rightInfo_no-orders_info-text">
                Вы можете заполнить его прямо сейчас
            </p>
            <!--Ссылка на страницу "Добавить заказ"-->
            <a href="<?= Url::to(['prof#item1']) ?>" class="Hcont_R_R-AddZ-Block uscp df jcsb aic">
                <img src="<?= Url::to(['/img/plass.svg']) ?>" alt="Плюс">
                <p class="BText Hcont_R_R-AddZ-BTN-t">Заполнить профиль</p>
            </a>
        </section>
        <?php else: ?>
            <div class="order-lid">
                <div class="bcr">
                    <ul class="bcr__list">
                        <li class="bcr__item">
                            <a href="<?= Url::to(['order']) ?>" class="bcr__link">
                                Создать заказ
                            </a>
                        </li>
                        <li class="bcr__item">
          <span class="bcr__span">
            Создание индивидуального заказа
          </span>
                        </li>
                    </ul>
                </div>

                <h1 class="order-lid__title">
                    Создание заказа
                </h1>

                <div class="order-lid__add">
                    <?= Html::beginForm('', 'post', ['id' => 'form-lid-add']) ?>

                    <div class="order-lid__step1 order-lid__step1--add step">
                        <div class="order-lid__inner">
                            <div class="order-lid__aside">
                                <ul class="order-lid__aside-list">
                                    <li class="order-lid__aside-item active"><span>Сфера</span></li>
                                    <li class="order-lid__aside-item order-lid__aside-item--2"><span>Регион</span></li>
                                    <li class="order-lid__aside-item order-lid__aside-item--3"><span>Количество</span>
                                    </li>
                                    <li class="order-lid__aside-item order-lid__aside-item--4">
                                        <span>Время получения</span></li>
                                    <li class="order-lid__aside-item order-lid__aside-item--5"><span>Комментарий</span>
                                    </li>
                                </ul>
                            </div>

                            <div class="order-lid__main">
                                <h2 class="order-lid__main-title">1. Сфера</h2>
                                <p class="order-lid__main-subtitle">
                                    Укажите сферу, в которой хотите купить лиды
                                </p>

                                <input type="text" name="sfera" value=""
                                       placeholder="Например, банкротство физических лиц"
                                       class="order-lid__input"/>

                                <button type="button" disabled class="order-lid__btn add add--1 btn">
                                    Далее
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                         xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                              d="M14.2197 16.2803C13.9268 15.9874 13.9268 15.5126 14.2197 15.2197L16.9393 12.5H4.75C4.33579 12.5 4 12.1642 4 11.75C4 11.3358 4.33579 11 4.75 11H16.9393L14.2197 8.28033C13.9268 7.98744 13.9268 7.51256 14.2197 7.21967C14.5126 6.92678 14.9874 6.92678 15.2803 7.21967L19.2803 11.2197C19.5732 11.5126 19.5732 11.9874 19.2803 12.2803L15.2803 16.2803C14.9874 16.5732 14.5126 16.5732 14.2197 16.2803Z"
                                              fill="white"/>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="order-lid__step2 order-lid__step2--add step">
                        <div class="order-lid__inner">
                            <div class="order-lid__aside">
                                <ul class="order-lid__aside-list">
                                    <li class="order-lid__aside-item ok"><span>Сфера</span></li>
                                    <li class="order-lid__aside-item order-lid__aside-item--2 active">
                                        <span>Регион</span></li>
                                    <li class="order-lid__aside-item order-lid__aside-item--3"><span>Количество</span>
                                    </li>
                                    <li class="order-lid__aside-item order-lid__aside-item--4">
                                        <span>Время получения</span></li>
                                    <li class="order-lid__aside-item order-lid__aside-item--5"><span>Комментарий</span>
                                    </li>
                                </ul>
                            </div>

                            <div class="order-lid__main">
                                <h2 class="order-lid__main-title">2. Регион</h2>
                                <p class="order-lid__main-subtitle">
                                    Выберите один или несколько регионов, из которых хотите получать лиды
                                </p>

                                <select multiple name="reg[]" class="form-control chosen-select multi-reg-add"
                                        data-placeholder="Выбрать регионы" style="font-family: 'Poppins', sans-serif">
                                    <option value="Вся Россия" selected>Вся Россия</option>
                                    <?php if (!empty($regions)): ?>
                                        <?php foreach ($regions as $item): ?>
                                            <option value="<?= $item['name_with_type'] ?>"><?= $item['name_with_type'] ?></option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>

                                <button type="button" class="order-lid__btn add add--2 btn" style="margin-top: 15px">
                                    Далее
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                         xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                              d="M14.2197 16.2803C13.9268 15.9874 13.9268 15.5126 14.2197 15.2197L16.9393 12.5H4.75C4.33579 12.5 4 12.1642 4 11.75C4 11.3358 4.33579 11 4.75 11H16.9393L14.2197 8.28033C13.9268 7.98744 13.9268 7.51256 14.2197 7.21967C14.5126 6.92678 14.9874 6.92678 15.2803 7.21967L19.2803 11.2197C19.5732 11.5126 19.5732 11.9874 19.2803 12.2803L15.2803 16.2803C14.9874 16.5732 14.5126 16.5732 14.2197 16.2803Z"
                                              fill="white"/>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="order-lid__step3 order-lid__step3--add step">
                        <div class="order-lid__inner">
                            <div class="order-lid__aside">
                                <ul class="order-lid__aside-list">
                                    <li class="order-lid__aside-item ok"><span>Сфера</span></li>
                                    <li class="order-lid__aside-item order-lid__aside-item--2 ok"><span>Регион</span>
                                    </li>
                                    <li class="order-lid__aside-item order-lid__aside-item--3 active">
                                        <span>Количество</span>
                                    </li>
                                    <li class="order-lid__aside-item order-lid__aside-item--4">
                                        <span>Время получения</span></li>
                                    <li class="order-lid__aside-item order-lid__aside-item--5"><span>Комментарий</span>
                                    </li>
                                </ul>
                            </div>

                            <div class="order-lid__main">
                                <h2 class="order-lid__main-title">3. Количество</h2>

                                <p class="order-lid__main-subtitle" style="margin-top: 15px">
                                    Сколько лидов всего вы хотите получить
                                </p>

                                <input type="number" name="lead_count" id="leads__count" value="50" min="10" max="1000"
                                       placeholder="Например, 10"
                                       class="first-step-create-valid order-lid__input"/>


                                <p class="order-lid__main-subtitle">
                                    Сколько лидов в день вы хотите получать
                                </p>

                                <input type="number" name="summ-lid" value="5" min="5" placeholder="Например, 10"
                                       class="first-step-create-valid order-lid__input"/>

                                <div class="create-order-err-block" style="color: red; margin: 10px 0; font-size: 12px">

                                </div>

                                <button type="button" class="order-lid__btn order-lid__btn--1 add--3 btn">
                                    Далее
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                         xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                              d="M14.2197 16.2803C13.9268 15.9874 13.9268 15.5126 14.2197 15.2197L16.9393 12.5H4.75C4.33579 12.5 4 12.1642 4 11.75C4 11.3358 4.33579 11 4.75 11H16.9393L14.2197 8.28033C13.9268 7.98744 13.9268 7.51256 14.2197 7.21967C14.5126 6.92678 14.9874 6.92678 15.2803 7.21967L19.2803 11.2197C19.5732 11.5126 19.5732 11.9874 19.2803 12.2803L15.2803 16.2803C14.9874 16.5732 14.5126 16.5732 14.2197 16.2803Z"
                                              fill="white"/>
                                    </svg>

                                </button>

                                <?php if ($_GET['count'] < 290): ?>
                                    <?php Pjax::begin(['id' => 'cardContainer']) ?>
                                    <div class="order-lid__box adaptive__settings">
                                        <?= $this->render('_cardbonuse', ['cards' => $cards]) ?>
                                    </div>
                                    <?php Pjax::end(); ?>
                                <?php else: ?>
                                    <?php Pjax::begin(['id' => 'cardContainer']) ?>
                                    <div class="order-lid__box-max">
                                        <?= $this->render('_cardbonuse-max', ['cards' => $cards]) ?>
                                    </div>
                                    <?php Pjax::end(); ?>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <div class="order-lid__step4 order-lid__step4--add step">
                        <div class="order-lid__inner">
                            <div class="order-lid__aside">
                                <ul class="order-lid__aside-list">
                                    <li class="order-lid__aside-item ok"><span>Сфера</span></li>
                                    <li class="order-lid__aside-item order-lid__aside-item--2 ok"><span>Регион</span>
                                    </li>
                                    <li class="order-lid__aside-item order-lid__aside-item--3 ok">
                                        <span>Количество</span></li>
                                    <li class="order-lid__aside-item order-lid__aside-item--4 active">
                                        <span>Время получения</span></li>
                                    <li class="order-lid__aside-item order-lid__aside-item--5"><span>Комментарий</span>
                                    </li>
                                </ul>
                            </div>

                            <div class="order-lid__main">
                                <h2 class="order-lid__main-title">4. Время получения</h2>
                                <div style="display: none">
                                    <p class="order-lid__main-subtitle">
                                        Выберите дни, в которые хотите получать лиды
                                    </p>

                                    <div class="order-lid__main-inputs">
                                        <input id="inp-day-1" type="checkbox" name="day" value="1" class="order-lid__inp"/>
                                        <label class="order-lid__lab" for="inp-day-1">Пн</label>

                                        <input id="inp-day-2" type="checkbox" name="day" value="2" class="order-lid__inp"/>
                                        <label class="order-lid__lab" for="inp-day-2">Вт</label>

                                        <input id="inp-day-3" type="checkbox" name="day" value="3" class="order-lid__inp"/>
                                        <label class="order-lid__lab" for="inp-day-3">Ср</label>

                                        <input id="inp-day-4" type="checkbox" name="day" value="4" class="order-lid__inp"/>
                                        <label class="order-lid__lab" for="inp-day-4">Чт</label>

                                        <input id="inp-day-5" type="checkbox" name="day" value="5" class="order-lid__inp"/>
                                        <label class="order-lid__lab" for="inp-day-5">Пт</label>

                                        <input id="inp-day-6" type="checkbox" name="day" value="6" class="order-lid__inp"/>
                                        <label class="order-lid__lab" for="inp-day-6">Сб</label>

                                        <input id="inp-day-7" type="checkbox" name="day" value="7" class="order-lid__inp"/>
                                        <label class="order-lid__lab" for="inp-day-7">Вс</label>
                                    </div>

                                    <p class="order-lid__main-subtitle">
                                        Укажите время, в которое хотите получать лиды
                                    </p>

                                    <div class="order-lid__main-clock">
                                        <label class="order-lid__lab-clock" for="s-clock">c</label>
                                        <input id="s-clock" type="text" name="clock[start]" value="9:00" placeholder="9:00"
                                               class="order-lid__inp-clock"/>

                                        <label class="order-lid__lab-clock" for="do-clock">до</label>
                                        <input id="do-clock" type="text" name="clock[end]" value="17:00" placeholder="17:00"
                                               class="order-lid__inp-clock"/>
                                    </div>


                                    <p class="order-lid__main-info">
                                        * Если хотите получать лиды круглосуточно не заполняйте эти поля
                                    </p>
                                </div>

                                <div style="margin-bottom: 20px"><span style="color: red; font-size: 12px; font-weight: 400; line-height: 16px">Время получения вы сможете уточнить у технической поддержки после оформления заказа</span></div>

                                <button type="button" class="order-lid__btn add add--5 btn">
                                    Далее
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                         xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                              d="M14.2197 16.2803C13.9268 15.9874 13.9268 15.5126 14.2197 15.2197L16.9393 12.5H4.75C4.33579 12.5 4 12.1642 4 11.75C4 11.3358 4.33579 11 4.75 11H16.9393L14.2197 8.28033C13.9268 7.98744 13.9268 7.51256 14.2197 7.21967C14.5126 6.92678 14.9874 6.92678 15.2803 7.21967L19.2803 11.2197C19.5732 11.5126 19.5732 11.9874 19.2803 12.2803L15.2803 16.2803C14.9874 16.5732 14.5126 16.5732 14.2197 16.2803Z"
                                              fill="white"/>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="order-lid__step5 order-lid__step5--add step">
                        <div class="order-lid__inner">
                            <div class="order-lid__aside">
                                <ul class="order-lid__aside-list">
                                    <li class="order-lid__aside-item ok"><span>Сфера</span></li>
                                    <li class="order-lid__aside-item order-lid__aside-item--2 ok"><span>Регион</span>
                                    </li>
                                    <li class="order-lid__aside-item order-lid__aside-item--3 ok">
                                        <span>Количество</span></li>
                                    <li class="order-lid__aside-item order-lid__aside-item--4 ok">
                                        <span>Время получения</span>
                                    </li>
                                    <li class="order-lid__aside-item order-lid__aside-item--5 active">
                                        <span>Комментарий</span>
                                    </li>
                                </ul>
                            </div>

                            <div class="order-lid__main">
                                <h2 class="order-lid__main-title">5. Комментарий</h2>
                                <p class="order-lid__main-subtitle">
                                    Оставьте свои пожелания, если это необходимо
                                </p>

                                <textarea name="comment" class="order-lid__textarea"
                                          placeholder="Введите текст …"></textarea>

                                <button type="submit" class="order-lid__btn btn">
                                    Далее
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                         xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                              d="M14.2197 16.2803C13.9268 15.9874 13.9268 15.5126 14.2197 15.2197L16.9393 12.5H4.75C4.33579 12.5 4 12.1642 4 11.75C4 11.3358 4.33579 11 4.75 11H16.9393L14.2197 8.28033C13.9268 7.98744 13.9268 7.51256 14.2197 7.21967C14.5126 6.92678 14.9874 6.92678 15.2803 7.21967L19.2803 11.2197C19.5732 11.5126 19.5732 11.9874 19.2803 12.2803L15.2803 16.2803C14.9874 16.5732 14.5126 16.5732 14.2197 16.2803Z"
                                              fill="white"/>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="popup spop">
                        <div class="popup__ov">
                            <div class="popup__body">
                                <div class="popup__lid">
                                    <p class="popup__lid-title">
                                        Заказ создан!
                                    </p>
                                    <p class="popup__lid-text">
                                        Ваш заказ отправлен на модерацию. Всю информацию о заказе вы можете посмотреть в
                                        пункте
                                        меню <a href="<?= Url::to(['myorders']) ?>" class="link">мои заказы</a>
                                    </p>

                                    <a href="<?= Url::to(['myorders']) ?>" class="popup__lid-btn btn">
                                        Продолжить
                                    </a>
                                </div>
                                <div class="popup__close">
                                    <img src="<?= Url::to(['/img/close.png']) ?>" alt="close">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="popup popup--auct-err">
                        <div class="popup__ov">
                            <div class="popup__body popup__body--w">
                                <div class="popup__content popup__content--err">
                                    <p class="popup__title rsp-ajax-title">
                                        Ошибка
                                    </p>
                                    <p class="popup__text rsp-ajax-text">

                                    </p>
                                    <button type="button" class="popup__btn-close btn">Закрыть</button>
                                </div>
                                <div class="popup__close">
                                    <img src="<?= Url::to(['/img//close.png']) ?>" alt="close">
                                </div>
                            </div>
                        </div>
                    </div>
                    <?= Html::endForm(); ?>
                </div>
            </div>

        <?php endif; ?>
    </section>
