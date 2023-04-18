<?php

use common\models\DevProjectAllias;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Мои проекты';

$js = <<< JS

//Табы
$('.myprojects_tabs--btn').on('click', function(){
    $('.myprojects_tabs--btn').removeClass('active');
    $(this).addClass('active');
    var tab = $(this).data('tab');
    if(tab == 1){
        if(!$('.myprojects_main-1').is(':visible')){
            $('.myprojects_main').hide();
            $('.myprojects_main-1').show();
        }
    }else if(tab == 2){
        if(!$('.myprojects_main-2').is(':visible')){
            $('.myprojects_main').hide();
            $('.myprojects_main-2').show();
        }
    }
});

//Отрисовка заполнения линии черрез прсчёт процентов
$('.myprojects_main-item').each(function(){
    var num1 = $(this).find('.myprojects_main-item_left-stage span .span1').text();
    var num2 = $(this).find('.myprojects_main-item_left-stage span .span2').text();
    var perc = num1 / num2 * 100 + '%';
    $(this).find('.myprojects_main-item_left-line-fill').css({
        'width': perc,
    });
});

JS;
$this->registerJs($js);

?>

<section class="rightInfo">
    <div class="bcr">
        <ul class="bcr__list">
            <li class="bcr__item">
                <span class="bcr__span">
                    Мои проекты
                </span>
            </li>
        </ul>
    </div>

    <div class="title_row">
        <h1 class="Bal-ttl title-main">Мои проекты</h1>
    </div>

    <section class="myprojects">
        <nav class="myprojects_tabs">
            <button data-tab="1" class="myprojects_tabs--btn active">Активные проекты</button>
            <button data-tab="2" class="myprojects_tabs--btn">Архив</button>
        </nav>

        <article class="myprojects_main myprojects_main-1">
            <div class="myprojects_main_container">
                <?php if (!empty($projectsActive)): ?>
                    <?php foreach ($projectsActive as $k => $v): ?>
                        <div class="myprojects_main-item-wrap">
                            <a href="<?= Url::to(['projectpage', 'link' => $v['link']]) ?>"
                               class="myprojects_main-item-link"></a>
                            <section class="myprojects_main-item">
                                <div class="myprojects_main-item_left">
                                    <p class="myprojects_main-item_left-type"><?= $v['type'] ?></p>
                                    <h2 class="myprojects_main-item_left-name"><?= $v['name'] ?></h2>
                                    <p class="myprojects_main-item_left-stap">завершено</p>
                                    <p class="myprojects_main-item_left-stage"><span><span
                                                    class="span1"><?= DevProjectAllias::find()->where(['project_id' => $v['id']])->count() ?></span>/<span class="span2">8</span></span>
                                        этапов</p>
                                    <div class="myprojects_main-item_left-line">
                                        <div class="myprojects_main-item_left-line-fill"></div>
                                    </div>
                                </div>
                                <div class="myprojects_main-item_right">
                                    <?php if (!empty($v['date_end'])): ?>
                                        <p class="myprojects_main-item_right-text">Предварительная дата
                                            завершения</p>
                                        <p class="myprojects_main-item_right-date"><?= date('d.m.Y', strtotime($v['date_end'])) ?></p>
                                    <?php endif; ?>
                                    <?php switch ($v['type']){
                                        case 'Сайт справочник':
                                            $image = Url::to(['/img/dev/site_sprav.png']);
                                            break;
                                        case 'Посадочная страница':
                                            $image = Url::to(['/img/dev/page.png']);
                                            break;
                                        case 'Корпоративный сайт':
                                            $image = Url::to(['/img/dev/corporat.png']);
                                            break;
                                        case 'Интернет магазин':
                                            $image = Url::to(['/img/dev/internet-magazine.png']);
                                            break;
                                        case 'Моб. приложение':
                                            $image = Url::to(['/img/dev/mobile.png']);
                                            break;
                                        case 'Личный кабинет':
                                            $image = Url::to(['/img/dev/lk.png']);
                                            break;
                                        case 'Веб приложение':
                                            $image = Url::to(['/img/dev/web-application.png']);
                                            break;
                                        case 'CRM система':
                                            $image = Url::to(['/img/dev/integration.png']);
                                            break;
                                        case 'Дизайн / Редизайн':
                                            $image = Url::to(['/img/dev/rediz.png']);
                                            break;
                                        case 'Gamedev':
                                            $image = Url::to(['/img/dev/game.png']);
                                            break;
                                        case 'Другое':
                                            $image = Url::to(['/img/dev/other.png']);
                                            break;
                                    } ?>
                                    <img style="max-width: <?= !empty($v['date_end']) ? '168px' : '' ?>" src="<?= $image ?>" alt="icon">
                                </div>
                            </section>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="myprojects_main-none">
                        <img src="<?= Url::to('/img/dev/myp-back.png') ?>" alt="rocket">
                        <p class="myprojects_main-none-text">Здесь будут отражены все ваши активные проекты.</p>
                        <a class="link--blue" href="<?= Url::to(['startproject']) ?>">Начать проект</a>
                    </div>
                <?php endif; ?>
            </div>
        </article>
        <article class="myprojects_main myprojects_main-2">
            <div class="myprojects_main_container">
                <?php if (!empty($projectsEnd)): ?>
                    <?php foreach ($projectsEnd as $k => $v): ?>
                        <div class="myprojects_main-item-wrap">
                            <a href="<?= Url::to(['projectpage', 'link' => $v['link']]) ?>"
                               class="myprojects_main-item-link"></a>
                            <section class="myprojects_main-item">
                                <div class="myprojects_main-item_left">
                                    <p class="myprojects_main-item_left-type"><?= $v['type'] ?></p>
                                    <h2 class="myprojects_main-item_left-name"><?= $v['name'] ?></h2>
                                    <p class="myprojects_main-item_left-stap">завершено</p>
                                    <p class="myprojects_main-item_left-stage"><span><span
                                                    class="span1"><?= DevProjectAllias::find()->where(['project_id' => $v['id']])->count() ?></span>/<span class="span2">8</span></span> этапов</p>
                                    <div class="myprojects_main-item_left-line">
                                        <div class="myprojects_main-item_left-line-fill"></div>
                                    </div>
                                </div>
                                <div class="myprojects_main-item_right">
                                    <?php switch ($v['type']){
                                        case 'Сайт справочник':
                                            $image = Url::to(['/img/dev/site_sprav.png']);
                                            break;
                                        case 'Посадочная страница':
                                            $image = Url::to(['/img/dev/page.png']);
                                            break;
                                        case 'Корпоративный сайт':
                                            $image = Url::to(['/img/dev/corporat.png']);
                                            break;
                                        case 'Интернет магазин':
                                            $image = Url::to(['/img/dev/internet-magazine.png']);
                                            break;
                                        case 'Моб. приложение':
                                            $image = Url::to(['/img/dev/mobile.png']);
                                            break;
                                        case 'Личный кабинет':
                                            $image = Url::to(['/img/dev/lk.png']);
                                            break;
                                        case 'Веб приложение':
                                            $image = Url::to(['/img/dev/web-application.png']);
                                            break;
                                        case 'CRM система':
                                            $image = Url::to(['/img/dev/integration.png']);
                                            break;
                                        case 'Дизайн / Редизайн':
                                            $image = Url::to(['/img/dev/rediz.png']);
                                            break;
                                        case 'Gamedev':
                                            $image = Url::to(['/img/dev/game.png']);
                                            break;
                                        case 'Другое':
                                            $image = Url::to(['/img/dev/other.png']);
                                            break;
                                    } ?>
                                    <img src="<?= $image ?>" alt="icon">
                                </div>
                            </section>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="myprojects_main-none">
                        <img src="<?= Url::to('/img/dev/myp-back.png') ?>" alt="rocket">
                        <p class="myprojects_main-none-text">Здесь будут отражены все ваши архивные проекты.</p>
                        <a class="link--blue" href="<?= Url::to(['startproject']) ?>">Начать проект</a>
                    </div>
                <?php endif; ?>
            </div>
        </article>
    </section>
</section>