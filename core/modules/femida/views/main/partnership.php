<?php


/* @var $this yii\web\View */

use yii\helpers\Url;
use yii\helpers\Html;
use common\models\helpers\UrlHelper;

$regions = \common\models\DbRegion::find()->asArray()->select(['name_with_type'])->orderBy('name_with_type asc')->all();

$js = <<< JS
$(".chosen-select").chosen({disable_search_threshold: 0});
JS;

$this->title = 'Стать партнером';
$this->registerCssFile(UrlHelper::admin('/css/chosen.min.css'));
$this->registerJsFile(UrlHelper::admin('/js/chosen.jquery.min.js'), ['depends' => \yii\web\JqueryAsset::class]);
$this->registerJsFile(Url::to(['/js/femida/getRegionAjax.js']), ['depends' => \yii\web\JqueryAsset::class]);
$this->registerJs($js);
?>

<section class="BSec1">
    <div class="container">
        <div>
            <?= Html::beginForm(Url::to(['/site/form']), 'post', ['class' => 'BSec1Form']) ?>
            <input type="hidden" name="URL" value="<?= $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] ?>">
            <input type="hidden" name="formType" value="Партнерство Квиз">
            <input type="hidden" name="pipeline" value="64">
            <input type="hidden" name="utm_source" value="<?= $_SESSION['utm_source'] ?>">
            <input type="hidden" name="utm_campaign" value="<?= $_SESSION['utm_campaign'] ?>">
            <input type="hidden" name="service" value="">
            <input type="hidden" name="section" value="Продавайте свою франшизу вместе с надежным партнером">
            <div class="BSec1Step1">
                <!-- <div class="pow"> -->
                    <div class="colWids">
                        <h1 class="BSec1StepP1">Продавайте свою франшизу вместе с надежным партнером</h1>
                        <p class="BSec1StepP2">Оставьте заявку и узнайте как FEMIDA.FORCE поможет вам</p>
                        <p class="BSec1StepP3">В каком регионе находится ваш основной бизнес?</p>
                        <div class="region-finder">
                            <select class="inp1 chosen-select partRegion" name="region" id="">
                                <option value="" selected>Указать регион</option>
                                <?php foreach ($regions as $k => $v): ?>
                                    <option value="<?= $v['name_with_type'] ?>"><?= $v['name_with_type'] ?></option>
                                <?php endforeach; ?>
                            </select>

                        </div>
                    </div>
                    <!-- <div class="rol-6 colNone">
                        <img class="BSec1FormImg" src="<?= Url::to(['/img/Bstep1.webp']) ?>" alt="picture of the first step">
                    </div> -->
                <!-- </div> -->
            </div>
            <div class="BSec1Step2">
                <div class="pow">
                    <div class="rol-6 colWids">
                        <p class="BSec1StepP1">Продавайте свою франшизу вместе с надежным партнером</p>
                        <p class="BSec1StepP2">Оставьте заявку и узнайте как FEMIDA.FORCE поможет вам</p>
                        <p class="BSec1StepP3">Минимальные инвестиции для старта вашего бизнеса (для покупателей)</p>
                        <select name="summ" class="inp1">
                            <option disabled selected>Укажите сумму долга</option>
                            <option class="comments[summ]" value="90000">До 100 000 рублей</option>
                            <option class="comments[summ]" value="300000">от 100 000 до 500 000 рублей</option>
                            <option class="comments[summ]" value="500000">от 500 000 рублей</option>
                        </select>
                    </div>
                    <div class="rol-6 colNone">
                        <img class="BSec1FormImg" src="<?= Url::to(['/img/Bstep2.webp']) ?>" alt="picture of the second step">
                    </div>
                </div>
            </div>
            <div class="BSec1Step3">
                <div class="pow">
                    <div class="rol-6 colWids">
                        <p class="BSec1StepP1">Продавайте свою франшизу вместе с надежным партнером</p>
                        <p class="BSec1StepP2">Оставьте заявку и узнайте как FEMIDA.FORCE поможет вам</p>
                        <p class="BSec1StepP3">Укажите ФИО и телефон для регистрации в проекте</p>
                        <input type="text" placeholder="ФИО" name="name" class="inp1 partFio">
                        <input type="tel" placeholder="Телефон" name="phone" class="inp1 partPhone">
                    </div>
                    <div class="rol-6 colNone">
                        <img class="BSec1FormImg" src="<?= Url::to(['/img/Bstep3.webp']) ?>" alt="picture of the third step">
                    </div>
                </div>
            </div>
            <div class="BSec1Step4">
                <div class="pow">
                    <div class="rol-6 colWids">
                        <p class="BSec1StepP1">Продавайте свою франшизу вместе с надежным партнером</p>
                        <p class="BSec1StepP2">Оставьте заявку и узнайте как FEMIDA.FORCE поможет вам</p>
                        <p class="BSec1StepP3">Введите код, полученный на номер телефон +7(999) 999-99-99 (<span
                                    class="changes">изменить</span>) </p>
                        <div class="pow codeGive">
                            <input type="text" placeholder="Код" name="code" class="inp1 rol-6">
                            <a class="rol-4" href="<?= Url::to(['#']) ?>">Отправить код повторно через 59</script></a>
                        </div>
                        <p class="BSec1StepP4">Если Вы не получили код в течении 5 минут — напишите нам на почту <a
                                    href="<?= Url::to(['mailto:general@myforce.ru']) ?>">general@myforce.ru</a></p>
                        <button class="orangeLinkBtn">
                            <span>Завершить регистрацию</span>
                            <img src="<?= Url::to(['/img/whiteShape.svg']) ?>" alt="arrow">
                        </button>
                    </div>
                    <div class="rol-6 colNone">
                        <img class="BSec1FormImg" src="<?= Url::to(['/img/Bstep4.webp']) ?>" alt="picture of the fourth step">
                    </div>
                </div>
            </div>
            <div class="btn__center btn__center-mt">
                <button type="button" class="fadeorangeLinkBtn orangeLinkBtn">
                    <span>Далее</span>
                    <img src="<?= Url::to(['/img/whiteShape.svg']) ?>" alt="arrow">
                </button>
            </div>
            <?= Html::endForm() ?>
        </div>
    </div>
</section>

<section class="BSec2">
    <div class="container">
        <div class="pow BSec2Card">
            <div class="rol-6 Geograf">
                <div class="GeoCard">
                    <p>География</p>
                    <p>Более 200 партнеров по всей стране</p>
                    <p><span>25%</span>Москва</p>
                    <p><span>14%</span>Санкт-Петербург</p>
                </div>
            </div>
            <div class="rol-4 Auditoriya">
                <img src="<?= Url::to(['/img/Ayditor.webp']) ?>" alt="diagram">
                <p>Разогретая целевая аудитория</p>
            </div>
            <div class="rol-2 BazaMail">
                <img src="<?= Url::to(['/img/MailBaz.webp']) ?>" alt="icon list">
                <p>460 309</p>
                <p>База email подписчиков (инвесторов)</p>
            </div>
        </div>
        <div class="pow BSec2Card">
            <div class="rol-7 topVidacha" style="background-image: url('<?= Url::to(['/img/googyand.webp']) ?>')">
                <h3>Топ по выдаче на Yandex и Google</h3>
                <p>Мы входим в Топ выдачи Яндекс и Google по тематическим запросам: «Купить франшизу», «Лучшие
                    франшизы», «Франшизы», «Новые франшизы»</p>
            </div>
            <div class="rol-5 kachestvoFirst">
                <h3>Качество на первом месте!</h3>
                <p>Мы позволяем пользователю спокойно и самостоятельно выбрать франшизу. Мы ничего не навязываем
                    пользователю с помощью «грязной» рекламы. Поэтому качество заявок такое высокое</p>
            </div>
        </div>
    </div>
</section>

<section class="BSec3">
    <div class="container">
        <div class="Bsec3Header">
            <h2>Все сложности мы возьмем на себя</h2>
            <p>Зарабатывайте по франшизе уже через 29 дней!</p>
        </div>
        <div class="Bsec3Cards pow">
            <div class="Bsec3Card rol-4">
                <img src="<?= Url::to(['/img/cardCircle.svg']) ?>" alt="icon pencil">
                <p>Публикация и заполнение информации о вашей франшизе</p>
            </div>
            <div class="Bsec3Card rol-4">
                <img src="<?= Url::to(['/img/cardCircle1.svg']) ?>" alt="icon click">
                <p>Удобный доступ к входящим заявкам и личному кабинету</p>
            </div>
            <div class="Bsec3Card rol-4">
                <img src="<?= Url::to(['/img/cardCircle2.svg']) ?>" alt="icon man">
                <p>Удаленный отдел продаж вашей франшизы</p>
            </div>
            <div class="Bsec3Card rol-4">
                <img src="<?= Url::to(['/img/cardCircle3.svg']) ?>" alt="icon hand">
                <p>Налаженные каналы привлечения клиентов</p>
            </div>
        </div>
        <div class="BSec3Know">
            <h3>Узнайте больше о программе партнерства</h3>
            <p>Задайте все возникшие вопросы специалисту по франшизам</p>
            <a style="cursor:pointer" class="violetLink batpodpShowPop">Узнать</a>
        </div>
    </div>
</section>


