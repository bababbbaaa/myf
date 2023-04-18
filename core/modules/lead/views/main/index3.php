<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\Pjax;
use common\models\helpers\UrlHelper;

$this->title = 'Виды лидов';
$js = <<< JS
    setTimeout(function() {
        $('#link_reload').attr("href","lead?").trigger("click");
    },100)
    $('.filter__form2').on('submit', function(e) {
        $('#link_reload').attr("href","lead?" + $(this).serialize()).trigger("click");
        e.preventDefault();
    });

    $('.filter__form').on('submit', function(e) {
        $('#link_reload').attr("href","lead?" + $(this).serialize()).trigger("click");
        e.preventDefault();
    });

    $('.reload__filter').on('click', function(e) {
        $('#link_reload').attr("href","lead?").trigger("click");
        $('.top_filter').removeClass('active');
        $('.left_filter').removeClass('active');
        e.preventDefault();
    });
    

    $('.filters').on('mouseup', '.top_filter', function() {
        var t = $(this);
        setTimeout(function() {
        if (t.hasClass('active')){
            t.removeClass('active');
        } else {
            t.addClass('active');
        }
        $('.filter__form2').submit();
        }, 300);
    });
    $('.filters').on('mouseup', '.left_filter', function() {
        var t = $(this);
        setTimeout(function() {
        if (t.hasClass('active')){
            t.removeClass('active');
        } else {
            t.addClass('active');
        }
        $('.filter__form').submit();
        }, 300);
    });

JS;
$this->registerJs($js);
$this->registerJsFile(Url::to(['/js/leads-range.js']), ['depends' => [\yii\web\JqueryAsset::className()]]);
$arr = [];
foreach ($region as $k => $v) {
    $json = json_decode($v['regions'], true);
    foreach ($json as $kk => $vv) {
        $arr[] = $vv;
    }
}
$arr = array_unique($arr);
$categoriFind = [];
if (!empty($category) && !empty($leadType)) {
    foreach ($category as $key => $item) {
        $categoriFind[$item['name']] = [];
        foreach ($leadType as $k => $i) {
            if ($i['category'] === $item['name']) {
                $categoriFind[$item['name']][] = $i;
            }
        }
    }
}
?>
<section class="TL_sec1 flex">
    <div class="TL_cont">
        <div class="TL_container1">
            <div class="TL_cont-inner">
                <div class="TL_cont-content">
                    <h1 class="TL_h1">Виды лидов</h1>
                    <h2 class="TL_p1">Качественные лиды для любой отрасли бизнеса</h2>
                    <a href="<?= Url::to(['/registr?site=lead']) ?>" class="btn-1 TL_sec1__btn">Получить лиды</a>
                </div>
                <div class="TL_cont__img">
                    <img src="<?= Url::to(['/img/typslid-img.png']) ?>" alt="картинка лидов"/>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="TL_sec2">
    <div class="TL_cont">
        <h2 class="TL_sec2-title">
            Выберите категорию вашего бизнеса и отфильтруйте по региону и цене лида
        </h2>
        <div class="TL_sec2-inner">
            <aside class="TL_sec2-aside">
                <?= Html::beginForm(Url::to(['index']), 'get', ['class' => 'filter__form']) ?>
                <div class="OF__cards-filters filters">
<!--                    <input class="sr-only" type="checkbox" name="filter[category]" value="all">-->
                    <span style="background: #f16262; color: white" class="filters__btn filters__btn--2 filters__btn--margin reload__filter">Сбросить фильтр</span>
                    <?php foreach ($category as $k => $v): ?>
                        <label class="filters__btn filters__btn--2 left_filter">
                            <input class="sr-only" type="checkbox" name="filter[category][]"
                                   value="<?= $v['link_name'] ?>">
                            <?= $v['name'] ?>
                        </label>
                    <?php endforeach; ?>
                </div>
                <?= Html::endForm(); ?>
            </aside>

            <div class="TL_sec2-content">
                <?= Html::beginForm(Url::to(['index']), 'get', ['class' => 'filter__form2']) ?>
                <div class="OF__cards-filters filters filters--flex">
                    <label class="filters__btn top_filter">
                        <input class="sr-only" type="checkbox" name="filter[new]" value="new">
                        Новые лиды
                    </label>

                    <label class="filters__btn top_filter">
                        <input class="sr-only" type="checkbox" name="filter[price]" value="500">
                        Лиды до 500 ₽
                    </label>
                </div>
                <?= Html::endForm(); ?>

                <div class="TL_sec2-pjax">
                    <!--            pjax     -->
                    <?php Pjax::begin(["id" => 'PjaxCont']); ?>
                    <a href="" id="link_reload"></a>
                    <?php foreach ($categoriFind as $k => $v) : ?>
                        <?php if (!empty($v)) : ?>
                            <h3 class="Head__sort--find"><?= $k ?></h3>
                            <div class="TL_container3 sort__find flex fww">
                                <?php foreach ($v as $key => $value) : ?>
                                    <div class="TL_block1">
                                        <a class="TL_block1--link"
                                           href="<?= Url::to(['lead-plan', 'link' => $value['link']]) ?>"></a>
                                        <div class="TL_block1_1">
                                            <img class="TL_img" src="<?= UrlHelper::admin($value['image']) ?>"
                                                 alt="мешок с $">
                                            <p class="TL_p3"><?= $value['category'] ?></p>
                                        </div>
                                        <div class="TL_p31">
                                            <?php $count = count(json_decode($value['regions'])); ?>
                                            <?php if ($count == 1) : ?>
                                                <?php foreach (json_decode($value['regions']) as $k) : ?>
                                                    <p class="TL_p3_1"><?= $k ?></p>
                                                <?php endforeach; ?>
                                            <?php elseif ($count <= 4) : ?>
                                                <p class="TL_p3_1"><?= $count ?> города</p>
                                            <?php else : ?>
                                                <p class="TL_p3_1"><?= $count ?> городов</p>
                                            <?php endif; ?>
                                            <h3 class="TL_p3_2"><?= $value['name'] ?></h3>
                                            <p class="TL_p3_3">от <?= $value['price'] ?> рублей/лид</p>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                    <?php endforeach; ?>
                    <?php Pjax::end(); ?>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="TL_sec4">
    <div class="TL_cont">
        <div class="TL_container5">
            <div class="TL_container5_1">
                <h3 class="TL_h5_1">Вы платите за целевые лиды</h3>
                <p class="TL_p5_1">В отличие от предложений на рынке, берём комиссию только за качественные целевые
                    лиды: мы обсуждаем с вами критерии и фиксируем их до начала работы, а не постфактум, когда бюджет
                    потрачен</p>
                <?= Html::beginForm('', 'post', ['id' => 'TL_sec4-form']) ?>
                <input type="hidden" name="URL" value="<?= $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] ?>">
                <input type="hidden" name="formType" value="Форма обратной связи">
                <input type="hidden" name="pipeline" value="104">
                <input type="hidden" name="utm_source" value="<?= $_SESSION['utm_source'] ?>">
                <input type="hidden" name="utm_campaign" value="<?= $_SESSION['utm_campaign'] ?>">
                <input type="hidden" name="section" value="Вы платите за целевые лиды">
                <input type="hidden" name="ip" value="<?= $_SERVER['REMOTE_ADDR'] ?>">
                <input type="hidden" name="service" value="">
                <div class="Sec5-step1">
                    <div class="Sec5-inputs">
                        <input class="Sec5-input fcstlt" type="text" name="name" placeholder="Имя" required>
                        <input class="Sec5-input fcstlt" type="tel" name="phone" placeholder="Телефон" required>
                    </div>
                    <button type="sabmit" class="btn-1">Узнать о целевых лидах</button>
                </div>
                <div class="Sec5-step2">
                    <p class="BLS5CDText-1">Благодарим за заявку!</p>
                    <p class="BLS5CDText-2">
                        Наш менеждер проконсультирует вас в ближайшее время
                    </p>
                </div>
                <?= Html::endForm(); ?>
            </div>

            <div class="TL_container5_2">
                <img src="<?= Url::to(['/img/2fon2.webp']) ?>" alt="target">
            </div>
        </div>
    </div>
</section>

<section class="By__Leads__Sec7">
    <div class="By__Leads__Sec7__content">
        <h3 class="Sec7__title">
            Станьте участником бонусной программы MYFORCE
        </h3>
        <p class="Sec7__subtitle">
            Лиды, курсы, скрипты и кэшбек баллами всех сервисов по одной карте
        </p>

        <div class="Sec7__box">
            <div class="Sec7__box-inner">
                <div class="Sec7__item">
                    <p class="Sec7__item-title">
                        Кэшбек за каждую покупку
                    </p>
                    <p class="Sec7__item-text">
                        Получайте еще больше лидов за те же деньги!
                    </p>
                </div>

                <div class="Sec7__item Sec7__item--1">
                    <p class="Sec7__item-title">
                        Бесплатные курсы и скрипты
                    </p>
                    <p class="Sec7__item-text">
                        Получайте скрипты продаж и курсы для менеджеров и оптимизируйте свой бизнес
                    </p>
                </div>

                <div class="Sec7__item Sec7__item--2">
                    <p class="Sec7__item-title">
                        Для всех сервисов MYFORCE
                    </p>
                    <p class="Sec7__item-text">
                        Бонусная программа едина для всей экосистемы MYFORCE. Накопленные баллы вы можете потратить на
                        курсы, услуги для бизнеса и много другое
                    </p>
                </div>

                <div class="Sec7__item Sec7__item--3">
                    <p class="Sec7__item-title">
                        Дополнительная отбраковка
                    </p>
                    <p class="Sec7__item-text">
                        Всем держателям карт доступна дополнительная отбраковка по любым направлениям бизнеса
                    </p>
                </div>
            </div>
            <a href="<?= Url::to(['/club']) ?>" class="Sec7__btn Sec7__box-btn">Узнать подробнее</a>
        </div>

        <div class="Sec7__card">
            <div class="Sec7__card-img">
                <img src="<?= Url::to(['/img/s7-card.png']) ?>" alt="photo cards">
            </div>

            <div class="Sec7__card-content">
                <h3 class="Sec7__card-title">
                    Получите Карту клуба прямо сейчас
                </h3>
                <p class="Sec7__card-text">
                    Получите карту СОВЕРШЕННО БЕСПЛАТНО <br>при покупке 350 лидов для<br> вашего бизнеса
                </p>

                <button type="button" class="Sec7__card-btn Sec7__btn showsCard">Получить карту Клуба</button>
            </div>
        </div>
    </div>
</section>

<section class="TL_sec5">
    <div class="TL_cont">
        <div class="TL_container6">
            <div class="TL_container6_1">
                <h3 class="TL_h6_1">Гарантии качества лидов</h3>
                <p class="TL_p6_1">Три главных отличия наших лидов от других</p>
            </div>
            <div class="TL_container6_2 flex fww jcsb">
                <div class="TL_bl6_1 flex fdc jcc">
                    <div class="TL_img6">
                        <img src="<?= Url::to(['/img/иконка.webp']) ?>" alt="settings">
                    </div>
                    <h4 class="TL_p6_2_1">Ручная модерация</h4>
                    <p class="TL_p6_2_2">Вы можете заказать дополнительный пакет, в котором каждое входящее обращение в
                        нашу систему тщательно обрабатывается и фильтруется нашим call-центром по высшим стандартам
                        качества</p>
                </div>
                <div class="TL_bl6_1 flex fdc jcc">
                    <div class="TL_img6">
                        <img src="<?= Url::to(['/img/иконка2.webp']) ?>" alt="card">
                    </div>
                    <h4 class="TL_p6_2_1">Полная отбраковка</h4>
                    <p class="TL_p6_2_2">Вы не платите за некорректные номера; за неподтвержденные заявки; за недозвоны.
                        Некачественные лиды проходят процесс отбраковки и бесплатно заменяются на полноценные заявки</p>
                </div>
                <div class="TL_bl6_1 flex fdc jcc">
                    <div class="TL_img6">
                        <img src="<?= Url::to(['/img/иконка3.webp']) ?>" alt="credit card">
                    </div>
                    <h4 class="TL_p6_2_1">Честная оплата</h4>
                    <p class="TL_p6_2_2">Вы оплачиваете только валидные и целевые заявки, которые заинтересованы в вашей
                        услуге. Тем самым вы получаете "живых" клиентов и легко увеличиваете свою прибыль</p>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="By__Leads__Sec9">
    <div class="By__Leads__Sec9__content">
        <h3 class="TL_h8v">Рассчитайте свою прибыль<br> и закажите лиды прямо сейчас!</h3>
        <div class="TL_inp8">
            <div class="TL_inp8-content">
                <div class="TL_inputtext flex aic fww">
                    <p class="TL_p8">Количество лидов</p>
                    <input class="TL_input_text tac number1" type="number" min="100" max="1000" step="100" value="500"
                           id="text">
                </div>
                <input class="TL_input_range" type="range" min="0" max="1000" value="500" step="100" id="slider">

                <div class="TL_p88 flex aic fww">
                    <div class="lite__fix">
                        <p class="TL_p8">Средний процент конверсии</p>
                        <h4 class="TL_h8 TL_h8w number1">9,5%</h4>
                    </div>

                    <div class="lite__fix">
                        <p class="TL_p8">Средняя стоимость лида</p>
                        <h4 class="TL_h8 TL_h8w">500 рублей</h4>
                    </div>
                </div>
                <div class="TL_inp9 flex fww">
                    <h4 class="TL_h8 TL_h8 total">Ваша прибыль</h4>
                    <input class="TL_inp9inp tac" type="text" id="result" disabled>
                </div>
            </div>
            <div class="TL_inp8-form">
                <p class="TL_inp8-form-title">
                    Закажите лиды прямой сейчас!
                </p>
                <div class="TL_inp8-form-inner">
                    <?= Html::beginForm(Url::to(['/site/form']), 'post', ['id' => 'form-TL_inp8']) ?>
                    <input type="hidden" name="URL" value="<?= $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] ?>">
                    <input type="hidden" name="formType" value="Форма для получения 10 бесплатных лидов">
                    <input type="hidden" name="pipeline" value="104">
                    <input type="hidden" name="utm_source" value="<?= $_SESSION['utm_source'] ?>">
                    <input type="hidden" name="utm_campaign" value="<?= $_SESSION['utm_campaign'] ?>">
                    <input type="hidden" name="service" value="">

                    <input class="fcstlt TL_inp8-input" required placeholder="Сфера бизнеса" type="text"
                           name="comments[sphere]" id="sphere2">
                    <input type="text" required="required" class="TL_inp8-input region fcstlt" placeholder="Ваш регион"
                           name="region" id="region2">
                    <input class="fcstlt TL_inp8-input" required pattern="[0-9]*" placeholder="Количество лидов в день"
                           type="text" name="comments[lead_day]" id="lids2">
                    <?php if (Yii::$app->user->isGuest):?>
                        <a href="<?= Url::to(["/registr?site=lead"])?>" class="btnsbmtfc">Получить</a>
                    <?php else:?>
                        <button class="btnsbmtfc" type="submit">Получить</button>
                    <?php endif?>
                    <?= Html::endForm(); ?>
                </div>
            </div>
        </div>
    </div>
</section>