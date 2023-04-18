<?php


/**
 * @var \common\models\LeadTemplates $template
 */

use user\modules\lead_force\controllers\ProviderController;
use yii\helpers\Html;
use yii\helpers\Url;

$link = $_GET['link'];

$this->title = "Заказать офферы";

$js = <<<JS
    $("#form-lid").on("submit", function (e) {
        var formThis = this;
        $.ajax({
            url: "create-order-from-template",
            type: "POST",
            data: $(this).serialize(),
            dataType: 'JSON'
        }).done(function (response) {
            if (response.status === 'success') {
                $(formThis).children(".psuccess").fadeIn(300);
            } else {
                $('.rsp-ajax-text').text(response.message);
                $(formThis).children(".popup--auct-err").fadeIn(300);
            }
        });
        e.preventDefault();
    });
    $('.timepick').timepicker({ 'timeFormat': 'H:i', 'step': 60 });
JS;

$this->registerCssFile(Url::to(['/css/jquery.timepicker.css']));
$this->registerJsFile(Url::to(['/js/jquery.timepicker.min.js']), ['depends' => \yii\web\JqueryAsset::class]);
$this->registerJs($js);
?>

<section class="rightInfo">
    <?php if (empty($client) || !ProviderController::fullInfo($client)): ?>
    <section class="rightInfo_no-orders">
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
            <p class="Bal-ttl title-main">Заказать лиды</p>
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
            Заказать лиды
          </span>
                </li>
            </ul>
        </div>

        <h1 class="order-lid__title">
            Заказать лиды
        </h1>

        <div class="order__cards">
            <div class="order__card card">
                <div class="card__box">
                    <h2 class="card__title">
                        <?= $template->name ?>
                    </h2>

                    <div class="card__price">
                        от <?= $template->price ?> рублей/лид
                    </div>
                </div>

                <div class="card__box">
                    <div class="card__subtitle">
                        <?= $template->category ?>
                    </div>

                    <div class="card__country">
                        <?php if(!empty($template->regions)): ?>
                            <?php $regions = json_decode($template->regions, 1); ?>
                            <?php if($regions !== null): ?>
                                <?php if(in_array('Любой', $regions)): ?>
                                    Любой регион
                                <?php else: ?>
                                    <?php foreach($regions as $k => $r):?><?php if($k !== 0): ?>, <?php endif; ?><?= $r ?><?php endforeach; ?><?php endif; ?>
                            <?php else: ?>
                                Любой регион
                            <?php endif; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="order-lid__add">
            <?= Html::beginForm('', 'post', ['id' => 'form-lid']) ?>
            <input type="hidden" value="<?= $_GET['template'] ?>" name="link">
            <div class="order-lid__step1 step">
                <div class="order-lid__inner">
                    <div class="order-lid__aside">
                        <ul class="order-lid__aside-list">
                            <li class="order-lid__aside-item active">Количество</li>
                            <li class="order-lid__aside-item order-lid__aside-item--2">Время получения</li>
                            <li class="order-lid__aside-item order-lid__aside-item--3">Комментарий</li>
                        </ul>
                    </div>

                    <div class="order-lid__main">
                        <h2 class="order-lid__main-title">1. Количество</h2>

                        <p class="order-lid__main-subtitle" style="margin-top: 20px">
                            Сколько всего лидов вы хотите получить
                        </p>

                        <input type="number" step="5" min="10" name="lead_count" value="50" placeholder="Например, 50"
                               class="order-lid__input first-step-create-valid"/>

                        <p class="order-lid__main-subtitle">
                            Сколько лидов в день вы хотите получать
                        </p>

                        <input type="number" step="5" min="5" name="summ-lid" value="5" placeholder="Например, 5"
                               class="order-lid__input first-step-create-valid"/>

                        <div class="create-order-err-block" style="color: red; margin: 10px 0; font-size: 12px">

                        </div>

                        <button type="button" class="order-lid__btn order-lid__btn--1 btn">
                            Далее
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                 xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                      d="M14.2197 16.2803C13.9268 15.9874 13.9268 15.5126 14.2197 15.2197L16.9393 12.5H4.75C4.33579 12.5 4 12.1642 4 11.75C4 11.3358 4.33579 11 4.75 11H16.9393L14.2197 8.28033C13.9268 7.98744 13.9268 7.51256 14.2197 7.21967C14.5126 6.92678 14.9874 6.92678 15.2803 7.21967L19.2803 11.2197C19.5732 11.5126 19.5732 11.9874 19.2803 12.2803L15.2803 16.2803C14.9874 16.5732 14.5126 16.5732 14.2197 16.2803Z"
                                      fill="white"/>
                            </svg>

                        </button>

                        <div class="order-lid__box">
                            <p class="order-lid__box-title">
                                Получите 2 лида <span>в подарок!</span>
                            </p>
                            <p class="order-lid__box-tex">
                                Закажите от 20-ти лидов и 2 лида мы вам подарим!
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="order-lid__step2 step">
                <div class="order-lid__inner">
                    <div class="order-lid__aside">
                        <ul class="order-lid__aside-list">
                            <li class="order-lid__aside-item ok">Количество</li>
                            <li class="order-lid__aside-item order-lid__aside-item--2 active">Время получения</li>
                            <li class="order-lid__aside-item order-lid__aside-item--3">Комментарий</li>
                        </ul>
                    </div>

                    <div class="order-lid__main">
                        <h2 class="order-lid__main-title">2. Время получения</h2>
                        <p class="order-lid__main-subtitle">
                            Выберите дни, в которые хотите получать лиды
                        </p>

                        <div class="order-lid__main-inputs">
                            <input id="inp-day-1" type="checkbox" name="day[]" value="1" class="order-lid__inp"/>
                            <label class="order-lid__lab" for="inp-day-1">Пн</label>

                            <input id="inp-day-2" type="checkbox" name="day[]" value="2" class="order-lid__inp"/>
                            <label class="order-lid__lab" for="inp-day-2">Вт</label>

                            <input id="inp-day-3" type="checkbox" name="day[]" value="3" class="order-lid__inp"/>
                            <label class="order-lid__lab" for="inp-day-3">Ср</label>

                            <input id="inp-day-4" type="checkbox" name="day[]" value="4" class="order-lid__inp"/>
                            <label class="order-lid__lab" for="inp-day-4">Чт</label>

                            <input id="inp-day-5" type="checkbox" name="day[]" value="5" class="order-lid__inp"/>
                            <label class="order-lid__lab" for="inp-day-5">Пт</label>

                            <input id="inp-day-6" type="checkbox" name="day[]" value="6" class="order-lid__inp"/>
                            <label class="order-lid__lab" for="inp-day-6">Сб</label>

                            <input id="inp-day-7" type="checkbox" name="day[]" value="7" class="order-lid__inp"/>
                            <label class="order-lid__lab" for="inp-day-7">Вс</label>
                        </div>

                        <p class="order-lid__main-subtitle">
                            Укажите время, в которое хотите получать лиды
                        </p>

                        <div class="order-lid__main-clock">
                            <label class="order-lid__lab-clock" for="s-clock">c</label>
                            <input id="s-clock" type="num" name="clock[start]" value="9" placeholder="9:00"
                                   class="timepick order-lid__inp-clock"/>

                            <label class="order-lid__lab-clock" for="do-clock">до</label>
                            <input id="do-clock" type="num" name="clock[end]" value="17" placeholder="17:00"
                                   class="timepick order-lid__inp-clock"/>
                        </div>


                        <p class="order-lid__main-info">
                            * Если хотите получать лиды круглосуточно не заполняйте эти поля
                        </p>

                        <button type="button" class="order-lid__btn order-lid__btn--1 btn">
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

            <div class="order-lid__step3 step">
                <div class="order-lid__inner">
                    <div class="order-lid__aside">
                        <ul class="order-lid__aside-list">
                            <li class="order-lid__aside-item ok">Количество</li>
                            <li class="order-lid__aside-item order-lid__aside-item--2 ok">Время получения</li>
                            <li class="order-lid__aside-item order-lid__aside-item--3 active">Комментарий</li>
                        </ul>
                    </div>

                    <div class="order-lid__main">
                        <h2 class="order-lid__main-title">3. Комментарий</h2>
                        <p class="order-lid__main-subtitle">
                            Оставьте свои пожелания, если это необходимо
                        </p>

                        <textarea name="comment" class="order-lid__textarea" placeholder="Введите текст …"></textarea>

                        <button type="submit" class="order-lid__btn btn create-from-template">
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

            <div class="popup psuccess">
                <div class="popup__ov">
                    <div class="popup__body">
                        <div class="popup__lid">
                            <p class="popup__lid-title">
                                Заказ создан!
                            </p>
                            <p class="popup__lid-text">
                                Ваш заказ отправлен на модерацию. Всю информацию о заказе вы можете посмотреть в пункте
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
</section>
