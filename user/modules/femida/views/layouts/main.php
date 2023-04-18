<?php

/* @var $this \yii\web\View */
/* @var $content string */

use common\models\Clients;
use common\models\Orders;
use user\assets\FemidaAsset;
use yii\helpers\Html;

$user_id = Yii::$app->getUser()->getId();
$client = Clients::find()->where(['user_id' => $user_id])->asArray()->one();
if (!empty($client))
    $order = Orders::find()->asArray()->where(['client' => $client['id']])->andWhere(['status' => Orders::STATUS_PROCESSING])->select('category_link, leads_count, leads_get')->all();

$arr = [];
$percents = 0;
if (!empty($order))
foreach ($order as $v)
    $arr[] = $v['category_link'];
if ($v['category_link'] === 'dolgi'){
    $percent = ($v['leads_get'] * 100) / $v['leads_count'];
    $percents = $percents < $percent ? $percent : $percents;
}

FemidaAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<style>
    .preloader-ajax-forms {
        background-color: rgba(0, 0, 0, 0.85);
        position: fixed;
        top: 0;
        left: 0;
        display: none;
        width: 100%;
        height: 100%;
        z-index: 10000;
        user-select: none;
        cursor: not-allowed;
    }
    .preloader-ajax-forms > div {
        color: white;
        display: flex;
        width: 100%;
        height: 100%;
        justify-content: center;
        align-items: center;
        font-size: 24px;
        font-weight: 500;
    }
</style>
<div class="preloader-ajax-forms">
    <div>
        Пожалуйста, ожидайте. Идет обработка данных...
    </div>
</div>
<section style="position: relative">
    <?php $this->beginBody() ?>
    <div class="right__banners">
        <div style="background-image: url('/img/banners/miniBanner.png')" class="ban__card">
            <a class="all__link-ban" target="_blank" href="https://optimise-your-seo.ru/"></a>
            <h6 class="ban__card-title">Бесплатный SEO-аудит</h6>
            <p class="ban__card-text">За 1 день унайте, как вывести ваш сайт в ТОП-10</p>
            <a target="_blank" class="btn--blue" href="https://optimise-your-seo.ru/">Получить аудит</a>
        </div>
        <?php if (empty($arr)): ?>
            <div style="background-image: url('/img/banners/miniBanner2.png')" class="ban__card">
                <a class="all__link-ban" target="_blank" href="https://user.myforce.ru/lead-force/client/order"></a>
                <h6 class="ban__card-title">Лиды на БФЛ<br><span style="color:#2CCD65;">от 400 рублей!</span></h6>
                <p class="ban__card-text">Брак до 25% есть трафик в вашем городе</p>
                <a style="background: linear-gradient(90deg, #2CCD65 0%, #2096EC 99.96%) " target="_blank" class="btn--blue" href="https://user.myforce.ru/lead-force/client/order">Купить лиды</a>
            </div>
        <?php elseif(in_array('dolgi', $arr)): ?>
            <div style="background-image: url('/img/banners/miniBanner3.png')" class="ban__card">
                <a class="all__link-ban" target="_blank" href="https://user.myforce.ru/femida/client/technology"></a>
                <h6 class="ban__card-title">Технологии эффективного бизнеса</span></h6>
                <div>
                    <div style="display: flex; align-items: center; gap: 9px; margin-bottom: 8px;">
                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M4 2.5C4 2.22386 4.22386 2 4.5 2H11.5C11.7761 2 12 2.22386 12 2.5C12 2.77614 11.7761 3 11.5 3H4.5C4.22386 3 4 2.77614 4 2.5ZM2.90219 6C2.68007 6 2.5 6.18007 2.5 6.40219V12.5978C2.5 12.8199 2.68007 13 2.90219 13H13.0978C13.3199 13 13.5 12.8199 13.5 12.5978V6.40219C13.5 6.18007 13.3199 6 13.0978 6H2.90219ZM1.5 6.40219C1.5 5.62778 2.12778 5 2.90219 5H13.0978C13.8722 5 14.5 5.62778 14.5 6.40219V12.5978C14.5 13.3722 13.8722 14 13.0978 14H2.90219C2.12778 14 1.5 13.3722 1.5 12.5978V6.40219ZM3.5 3.5C3.22386 3.5 3 3.72386 3 4C3 4.27614 3.22386 4.5 3.5 4.5H12.5C12.7761 4.5 13 4.27614 13 4C13 3.72386 12.7761 3.5 12.5 3.5H3.5Z" fill="#EEEEEE"/>
                        </svg>
                        <p class="miniban__list-text">Дистанционные продажи БФЛ</p>
                    </div>
                    <div style="display: flex; align-items: center; gap: 9px; margin-bottom: 8px;">
                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M3.25 3.5C2.55964 3.5 2 4.05964 2 4.75V5.0625H14V4.75C14 4.05964 13.4404 3.5 12.75 3.5H3.25ZM2 11.25V6.9375H14V11.25C14 11.9404 13.4404 12.5 12.75 12.5H3.25C2.55964 12.5 2 11.9404 2 11.25ZM1 4.75C1 3.50736 2.00736 2.5 3.25 2.5H12.75C13.9926 2.5 15 3.50736 15 4.75V11.25C15 12.4926 13.9926 13.5 12.75 13.5H3.25C2.00736 13.5 1 12.4926 1 11.25V4.75ZM4 8.4375C3.48223 8.4375 3.0625 8.85723 3.0625 9.375V10C3.0625 10.5178 3.48223 10.9375 4 10.9375H5.5C6.01777 10.9375 6.4375 10.5178 6.4375 10V9.375C6.4375 8.85723 6.01777 8.4375 5.5 8.4375H4Z" fill="#EEEEEE"/>
                        </svg>
                        <p class="miniban__list-text">Фин.защита</p>
                    </div>
                    <div style="display: flex; align-items: center; gap: 9px; margin-bottom: 8px;">
                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M6.23223 2.73223C6.70107 2.26339 7.33696 2 8 2C8.66304 2 9.29893 2.26339 9.76777 2.73223C10.2366 3.20107 10.5 3.83696 10.5 4.5V5H5.5V4.5C5.5 3.83696 5.76339 3.20107 6.23223 2.73223ZM4.5 5V4.5C4.5 3.57174 4.86875 2.6815 5.52513 2.02513C6.1815 1.36875 7.07174 1 8 1C8.92826 1 9.8185 1.36875 10.4749 2.02513C11.1313 2.6815 11.5 3.57174 11.5 4.5V5H13.5C13.7652 5 14.0196 5.10536 14.2071 5.29289C14.3946 5.48043 14.5 5.73478 14.5 6V12.7891C14.5 14.0247 13.4564 15 12.25 15H3.75C2.52886 15 1.5 13.9711 1.5 12.75V6C1.5 5.73478 1.60536 5.48043 1.79289 5.29289C1.98043 5.10536 2.23478 5 2.5 5H4.5ZM11 6H13.5V12.7891C13.5 13.4434 12.9336 14 12.25 14H3.75C3.08114 14 2.5 13.4189 2.5 12.75L2.5 6H5H11ZM10.3123 7.85957C10.528 8.03207 10.5629 8.34672 10.3904 8.56235L7.59043 12.0623C7.49735 12.1787 7.35723 12.2475 7.20825 12.2499C7.05927 12.2524 6.91695 12.1883 6.82008 12.0751L5.62008 10.6726C5.44056 10.4627 5.46512 10.1471 5.67494 9.96758C5.88476 9.78806 6.20039 9.81262 6.37992 10.0224L7.18706 10.9658L9.60957 7.93765C9.78207 7.72202 10.0967 7.68706 10.3123 7.85957Z" fill="#EEEEEE"/>
                        </svg>
                        <p class="miniban__list-text">Отдел продаж</p>
                    </div>
                </div>
                <a target="_blank" class="btn--text" href="https://user.myforce.ru/femida/client/technology">Выбрать технологию</a>
            </div>
        <?php else: ?>
            <div style="background: #F2F6FF" class="ban__card">
                <a class="all__link-ban" target="_blank" href="https://user.myforce.ru/femida/client/technology"></a>
                <h6 style="font-size: 32px; color: #010101; line-height: 40px" class="ban__card-title">скидка 33% <br> на CRM </h6>
                <p style="color:#010101;" class="ban__card-text">Настройка CRM от сертифицированного партнера</p>
                <a target="_blank" class="btn--blue" href="https://user.myforce.ru/femida/client/technology">Получить скидку</a>
            </div>
        <?php endif; ?>

        <?php if (empty($arr)): ?>
            <div style="background-image: url('/img/banners/miniBanner3-2.png'); padding-top: 33px;" class="ban__card">
                <a class="all__link-ban" target="_blank" href="https://user.myforce.ru/femida/client/catalogpage/franshiza-po-spisaniu-dolgov-i-bankrotstvu"></a>
                <h6 style="margin-bottom: 24px;" class="ban__card-title">Франшиза<br>по банкротству</h6>
                <p style="color: #181240" class="ban__card-text">Зарабатывай<br>от 500 000₽ в месяц</p>
                <a target="_blank" class="btn--red" href="https://user.myforce.ru/femida/client/catalogpage/franshiza-po-spisaniu-dolgov-i-bankrotstvu">Открыть бизнес</a>
            </div>
        <?php elseif (in_array('dolgi', $arr)): ?>
            <div style="background-image: url('/img/banners/miniBanner3-1.png')" class="ban__card">
                <a class="all__link-ban" target="_blank" href="http://arbit.femidafors.ru/"></a>
                <h6 class="ban__card-title">Арбитражные управляющие</h6>
                <p class="ban__card-text">Арбитражное управление<br>за 50 000₽ под ключ<br> <span style="color: white; font-weight: 700">+ аудит банкротов</span></p>
                <a target="_blank" class="btn--orange" href="http://arbit.femidafors.ru/">Подробнее</a>
            </div>
        <?php else: ?>
            <div style="background-image: url('/img/banners/miniBanner3-3.png'); background-position: center; text-align: center; padding-right: 55px;" class="ban__card">
                <a class="all__link-ban" target="_blank" href="https://user.myforce.ru/dev/start-project"></a>
                <h6 style="display: flex; align-items: center; gap: 12px; justify-content: center" class="ban__card-title"><svg width="8" height="8" viewBox="0 0 8 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="4" cy="4" r="4" fill="white"/>
                    </svg>
                    скидка 33%<svg width="8" height="8" viewBox="0 0 8 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="4" cy="4" r="4" fill="white"/>
                    </svg>
                </h6>
                <p class="ban__card-text">Разработка любого сайта с дисконтом</p>
                <a style="margin: 0 auto;" target="_blank" class="btn--blue" href="https://user.myforce.ru/dev/start-project">Начать проект</a>
            </div>
        <?php endif; ?>
        <div style="background-image: url('/img/banners/miniBannerLast.png')" class="ban__card">
            <a class="all__link-ban" target="_blank" href="https://courses.business-bfl.ru/"></a>
            <h6 style="color: #23213D" class="ban__card-title">Скидка 50%<br>на курсы по БФЛ!</h6>
            <p style="color: #23213D" class="ban__card-text">Обучи отдел продаж <br> и Контакт-центр с дисконтом!</p>
            <a target="_blank" class="btn--pink" href="https://courses.business-bfl.ru/">Получить скидку</a>
        </div>
    </div>
    <?php echo $this->render('_header') ?>
    <div class="ban__block">
        <?php if (Yii::$app->controller->action->id !== 'index'): ?>
            <div class="banner">
                <div style="background-image: url('/img/banners/banner_all-page.png')" class="banner_body">
                    <a class="all__link-ban" target="_blank" href="https://myforce-business.ru/"></a>
                    <div class="banner_body-info">
                        <h5>Аудит бизнеса <span>и оптимизация!</span></h5>
                        <p>Внешнее управление, временный руководитель отдела продаж, планирование продаж, аудит рекламы,
                            и многое другое!</p>
                    </div>
                    <a target="_blank" href="https://myforce-business.ru/" class="btn--white">Узнать подробнее</a>
                </div>
            </div>
        <?php else: ?>
            <?php if (empty($arr)): ?>
                <div class="banner">
                    <div class="banner__index">
                        <div class="ban__index-flex" style="display: flex; gap: 20px">
                            <div style="background-image: url('/img/banners/index__not-active.png')"
                                 class="banner__index--left">
                                <a class="all__link-ban" target="_blank" href="https://user.myforce.ru/lead-force/client/order"></a>
                                <div class="banner__index--left-info">
                                    <h5>2000 <span>бонусов</span></h5>
                                    <p class="banner__index--left--text">дарим за первый заказ лидов</p>
                                </div>
                                <a target="_blank" href="https://user.myforce.ru/lead-force/client/order"
                                   class="btn--white">Купить лиды</a>
                            </div>
                            <div style="background-image: url('/img/banners/index__not-active-small.png')"
                                 class="banner__index--right">
                                <a class="all__link-ban" target="_blank" href="https://user.myforce.ru/dev/start-project"></a>
                                <div class="banner__index--right--info right_info">
                                    <h5 class="right_info-title">Landing</h5>
                                    <p class="right_info-text">+ Реклама от маркетологов по БФЛ всего за</p>
                                    <p class="right_info-info">29 900₽ <span class="right_info-info-span">44 500₽</span>
                                    </p>
                                </div>
                                <a target="_blank" href="https://user.myforce.ru/dev/start-project" class="btn--white">Оставить
                                    заявку</a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php elseif($percents > 80): ?>
                <div class="banner">
                    <div class="banner__index">
                        <div class="ban__index-flex" style="display: flex; gap: 20px">
                            <div style="background: #20293A"
                                 class="banner__index--left">
                                <a class="all__link-ban" target="_blank" href="https://user.myforce.ru/lead-force/client/balance"></a>
                                <div style="text-align: center" class="banner__index--left-info">
                                    <div style="display: flex; gap: 8px; justify-content: center">
                                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <rect width="20" height="20" rx="10" fill="#2CCD65"/>
                                            <path d="M8.48643 5.97853C9.32669 5.66228 10.2449 5.61717 11.1121 5.84954C11.3205 5.90538 11.5347 5.78171 11.5905 5.57332C11.6464 5.36494 11.5227 5.15075 11.3143 5.09491C10.2894 4.82029 9.20427 4.8736 8.21123 5.24735C7.2182 5.62111 6.36718 6.29652 5.77769 7.17875C5.18821 8.06097 4.88988 9.10568 4.9246 10.1662C4.95931 11.2266 5.32533 12.2496 5.97125 13.0914C6.61717 13.9331 7.51055 14.5515 8.5259 14.8595C9.54125 15.1675 10.6276 15.1497 11.6323 14.8086C12.637 14.4676 13.5097 13.8204 14.1277 12.9579C14.7458 12.0954 15.0781 11.061 15.0781 10C15.0781 9.78426 14.9032 9.60938 14.6875 9.60938C14.4718 9.60938 14.2969 9.78426 14.2969 10C14.2969 10.8978 14.0157 11.7731 13.4927 12.5028C12.9698 13.2326 12.2313 13.7803 11.3812 14.0688C10.531 14.3574 9.61183 14.3725 8.75269 14.1119C7.89354 13.8512 7.13761 13.328 6.59106 12.6158C6.04451 11.9035 5.7348 11.0379 5.70543 10.1406C5.67605 9.24327 5.92849 8.35928 6.42728 7.61279C6.92607 6.86629 7.64617 6.29478 8.48643 5.97853Z" fill="white"/>
                                            <path d="M14.2134 6.72571C14.3467 6.55608 14.3172 6.31051 14.1476 6.17722C13.978 6.04393 13.7324 6.0734 13.5991 6.24304L9.57425 11.3656L7.93247 9.72379C7.77992 9.57124 7.53259 9.57124 7.38004 9.72379C7.22749 9.87634 7.22749 10.1237 7.38004 10.2762L9.33316 12.2293C9.41215 12.3083 9.52118 12.3497 9.63269 12.3431C9.7442 12.3364 9.84752 12.2823 9.91653 12.1945L14.2134 6.72571Z" fill="white"/>
                                        </svg>
                                        <p style="font-weight: 400; font-size: 14px; line-height: 20px; color: #2CCD65; margin-bottom: 8px;">уже активно</p>
                                    </div>
                                    <h5>5% <span>кэшбек</span></h5>
                                    <p style="margin-bottom: 28px" class="banner__index--left--text">за пролонгацию пакета лидов</p>
                                </div>
                                <a style="background: linear-gradient(90deg, #2CCD65 0%, #2096EC 99.96%); margin: 0 auto" target="_blank" href="https://user.myforce.ru/lead-force/client/balance"
                                   class="btn--white">Получить кэшбек</a>
                            </div>
                            <div style="background-image: url('/img/banners/headBanner4.png')"
                                 class="banner__index--right">
                                <a class="all__link-ban" target="_blank" href="https://user.myforce.ru/dev/start-project"></a>
                                <div class="banner__index--right--info right_info">
                                    <h5 class="right_info-title">SEO-сайт БФЛ</h5>
                                    <p class="right_info-text">+ продвижение</p>
                                    <p class="right_info-info">99 900₽ <span style="color: #7019FF" class="right_info-info-span">149 500₽</span>
                                    </p>
                                </div>
                                <a target="_blank" href="https://user.myforce.ru/dev/start-project" class="btn--blue">Оставить
                                    заявку</a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php elseif (in_array('dolgi', $arr)): ?>
                <div class="banner">
                    <div class="banner__index">
                        <div class="ban__index-flex" style="display: flex; gap: 20px">
                            <div style="background-image: url('/img/banners/headbanner1.png')"
                                 class="banner__index--left">
                                <a class="all__link-ban" target="_blank" href="https://user.myforce.ru/femida/client/technology/2"></a>
                                <div class="banner__index--left-info">
                                    <h5 style="font-size: 28px; margin-bottom: 16px;">Дистанционные продажи БФЛ</h5>
                                    <p style="font-size: 24px; margin-bottom: 28px;" class="banner__index--left--text">часто берут с лидами на банкротство физ.лиц</p>
                                </div>
                                <a style="color: #007FEA;" target="_blank" href="https://user.myforce.ru/femida/client/technology/2"
                                   class="btn--white">Купить технологию</a>
                            </div>
                            <div style="background-image: url('/img/banners/headerBanner2.png'); background-size: contain"
                                 class="banner__index--right">
                                <a class="all__link-ban" target="_blank" href="https://user.myforce.ru/femida/client/catalogpage/franshiza-uslug-chardjbek"></a>
                                <div class="banner__index--right--info right_info">
                                    <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 20px;">
                                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <circle cx="10" cy="10" r="10" fill="#FB593B"/>
                                            <g clip-path="url(#clip0_2174_64549)">
                                                <path d="M7.69267 17.1427C6.10465 11.9099 9.4601 9.99932 9.4601 9.99932C9.22533 12.7916 10.8121 14.9669 10.8121 14.9669C11.3957 14.7909 12.5096 13.9679 12.5096 13.9679C12.5096 14.9669 11.9218 17.1415 11.9218 17.1415C11.9218 17.1415 13.9794 15.5505 14.6271 12.9081C15.274 10.2657 13.395 7.61292 13.395 7.61292C13.5082 9.48316 12.8755 11.3226 11.6359 12.7279C11.6979 12.6563 11.7499 12.5768 11.7899 12.4906C12.0126 12.0452 12.3702 10.8876 12.1608 8.20692C11.8661 4.44395 8.4565 2.85718 8.4565 2.85718C8.75038 5.14992 7.86916 5.67815 5.80494 10.0301C3.74072 14.3813 7.69267 17.1427 7.69267 17.1427Z" fill="white"/>
                                            </g>
                                            <defs>
                                                <clipPath id="clip0_2174_64549">
                                                    <rect width="14.2857" height="14.2857" fill="white" transform="translate(2.85693 2.85718)"/>
                                                </clipPath>
                                            </defs>
                                        </svg>
                                        <p style="font-weight: 400; font-size: 14px; line-height: 20px; color: #7A6BDE;">Возможно вам будет интересно</p>
                                    </div>
                                    <h5 style="color: #2B3048; font-weight: 600; margin-bottom: 28px;" class="right_info-title">Франшиза Чарджбек</h5>
                                </div>
                                <a target="_blank" href="https://user.myforce.ru/femida/client/catalogpage/franshiza-uslug-chardjbek " class="btn--red">Оставить
                                    заявку</a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php elseif (!in_array('dolgi', $arr)): ?>
                <div class="banner">
                    <div class="banner__index">
                        <div class="ban__index-flex" style="display: flex; gap: 20px">
                            <div style="background-image: url('/img/banners/headBanner2.png')"
                                 class="banner__index--left">
                                <a class="all__link-ban" target="_blank" href="https://user.myforce.ru/femida/client/catalog"></a>
                                <div class="banner__index--left-info">
                                    <h5 style="font-size: 32px; margin-bottom: 16px; max-width: 285px">Ищем партнеров в вашем городе! </h5>
                                    <p style="font-size: 24px; margin-bottom: 28px;" class="banner__index--left--text">Изучите предложения</p>
                                </div>
                                <a style="color: #007FEA;" target="_blank" href="https://user.myforce.ru/femida/client/catalog"
                                   class="btn--white">Узнать подробнее</a>
                            </div>
                            <div style="background-image: url('/img/banners/headBanner3.png')"
                                 class="banner__index--right">
                                <a class="all__link-ban" target="_blank" href="https://user.myforce.ru/lead-force/client/bonuses#page3"></a>
                                <div class="banner__index--right--info right_info">
                                    <h5 style="text-align: center" class="right_info-title">Клубная карта <span style="font-weight: 700">MYFORCE</span></h5>
                                    <p style="margin-bottom: 28px; text-align: center" class="right_info-text">доступна для оформления</p>
                                </div>
                                <a style="margin: 0 auto" target="_blank" href="https://user.myforce.ru/lead-force/client/bonuses#page3" class="btn--red">Оформить сейчас</a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        <?php endif; ?>
        <?= $content ?>
        <?php if (empty($arr)): ?>
            <div class="bannerFoot">
                <div style="background-image: url('/img/banners/footerBanner1.png')" class="bannerFoot__body">
                    <a class="all__link-ban" target="_blank" href="https://user.myforce.ru/lead-force/client/order"></a>
                    <div class="bannerFoot__info">
                        <h5>Качественные лиды ждут вас!</h5>
                        <p>Создайте заказ на лиды и получите качественных клиентов в бизнес!</p>
                    </div>
                    <a target="_blank" href="https://user.myforce.ru/lead-force/client/order" class="btn--white">Оставить
                        заявку</a>
                </div>
            </div>
        <?php elseif (!in_array('dolgi', $arr)): ?>
            <div class="bannerFoot">
                <div style="background-image: url('/img/banners/footerBanner3.png')" class="bannerFoot__body">
                    <a class="all__link-ban" target="_blank" href="https://user.myforce.ru/femida/client/catalogpage/franshiza-ekosistemy-dlya-predprinimatelei-myforce"></a>
                    <div class="bannerFoot__info">
                        <h5 style="max-width: 660px">Франшиза Digital-агентства в вашем городе со скидкой до 50%!</h5>
                        <p style="color: #CBD0E8">Откройте digital-агенство в вашем регионе и получайте клиентов <span
                                    style="font-weight: 600; color: white">БЕСПЛАТНО</span></p>
                    </div>
                    <a target="_blank"
                       href="https://user.myforce.ru/femida/client/catalogpage/franshiza-ekosistemy-dlya-predprinimatelei-myforce"
                       class="btn--red">Оставить
                        заявку</a>
                </div>
            </div>
        <?php else: ?>
            <div class="bannerFoot">
                <div style="background-image: url('/img/banners/footerBanner2.png'); text-align: center; display: flex; flex-direction: column; align-items: center"
                     class="bannerFoot__body">
                    <a class="all__link-ban" target="_blank" href="https://myforce-franchise.ru/"></a>
                    <div style="text-align: center" class="bannerFoot__info">
                        <h5 style="max-width: 660px">Франшиза банкротства в вашем городе по скидке до 50%!</h5>
                        <p style="margin: 0 auto 20px auto; max-width: 460px; color: #CBD0E8">Откройте бизнес под
                            брендом
                            <span style="color: white; font-weight: 600">FEMIDAFORCE</span> и получайте клиентов <span
                                    style="color: white; font-weight: 600">БЕСПЛАТНО</span></p>
                    </div>
                    <a style="color: #FB593B;" target="_blank" href="https://myforce-franchise.ru/" class="btn--white">Оставить
                        заявку</a>
                </div>
            </div>
        <?php endif; ?>
        <?php echo $this->render('_footer') ?>
    </div>
</section>
</article>
</main>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
