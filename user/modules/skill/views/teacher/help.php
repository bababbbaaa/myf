<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;

$this->title = 'Помогаю проверять';

$js = <<< JS

$('.ChangePage-Item-t').on('click', function(){
    setTimeout(function(){
        let page = location.hash;
        if(page == '#page1'){
            $(".bcr__span.nowpagebrc").text("Проверяю я");
            $('.mytasks_main-page').removeClass('active');
            $('.mytasks_main-page-1').addClass('active');
        }else if(page == '#page2'){
            $(".bcr__span.nowpagebrc").text("Ассистенты");
            $('.mytasks_main-page').removeClass('active');
            $('.mytasks_main-page-2').addClass('active');
        }
    }, 1);
});

let page = location.hash;
if(page == '#page1'){
    $('.mytasks_main-page').removeClass('active');
    $('.mytasks_main-page-1').addClass('active');
    $('.ChangePage-Item-t').removeClass('CIT-active');
    $('.ChangePage-Item-t1').addClass('CIT-active');
    $('.ChangePage-Item-line').removeClass('CIL-active');
    $('.ChangePage-Item-line1').addClass('CIL-active');
}else if(page == '#page2'){
    $('.mytasks_main-page').removeClass('active');
    $('.mytasks_main-page-2').addClass('active');
    $('.ChangePage-Item-t').removeClass('CIT-active');
    $('.ChangePage-Item-t2').addClass('CIT-active');
    $('.ChangePage-Item-line').removeClass('CIL-active');
    $('.ChangePage-Item-line2').addClass('CIL-active');
}

// Выборка заданий требующих проверки при нажетии на фильтр "Нужно проверить"
    $("input[value='Нужно проверить']").on("click", function () {
        $(".mytask_item-date").each(function () {
            if($(this).text().length == 0) {
                var itemTask = $(this).parents(".mytask_item");
                itemTask.css("display", "none");
            }
        });
    });

    $("input[value='Все задания']").on("click", function () {
        $(".mytask_item").css("display", "block");
    });

    $(".programs-filter-submit").on("click",function () {
        if($(this).hasClass("active")) {
            $(".bcr__span.nowpagebrc").text($(this).text());
        }
    });

JS;
$this->registerJs($js);

?>

<section class="rightInfo">
    <div class="bcr">
        <ul class="bcr__list">
            <li class="bcr__item">
                <span class="bcr__link">
                    Помогаю проверять
                </span>
            </li>

            <li class="bcr__item">
                <span class="bcr__span nowpagebrc">Нужно проверить</span>
            </li>
        </ul>
    </div>
    <div class="title_row">
        <h1 class="Bal-ttl title-main">Помогаю проверять</h1>
        <a href="<?= Url::to(['']) ?>" class="link--purple">Что значит помогаю проверять?</a>
    </div>

    <article class="mytasks_main">
        <?= Html::beginForm('', 'post', ['class' => 'mytasks_main-filter-form']) ?>
        <section class="mytasks_main-filter">
            <label class="MyOrders_filter-check-l sendActive programs-filter-submit active">Нужно проверить
                <input class="MyOrders_filter-check" type="checkbox" name="choice" value="Нужно проверить">
            </label>
            <label class="MyOrders_filter-check-l sendActive programs-filter-submit">Все задания
                <input class="MyOrders_filter-check" type="checkbox" name="choice" value="Все задания" checked>
            </label>
        </section>
        <?= Html::endForm(); ?>

        <section class="mytasks_main-page mytasks_main-page-1 active">
            <div class="mytask_page-inner">
                <div class="mytask_page-body">
                    <article class="mytask_item">
                        <a href="<?= Url::to(['help-tasks']) ?>" class="mytask_item-link"></a>
                        <div class="mytask_item-content">
                            <date class="mytask_item-date">До 20.09.2021</date>
                            <p class="mytask_item-subtitle">интенсив “Менеджер продаж”</p>
                            <h2 class="mytask_item-title">10.4 Задание</h2>
                            <p class="mytask_item-text">
                                С помощью представленных инструментов напишите эффективный скрипт для продажи продукта ...
                            </p>
                            <div class="mytask_item-check">
                                <div class="mytask_item-block">
                                    <p class="mytask_item-check-text">Ожидают проверки</p>
                                    <p class="mytask_item-check-num">20</p>
                                </div>
                            </div>
                            <a href="<?= Url::to(['help-tasks']) ?>" class="mytask_item-check-link">Перейти к проверке</a>
                        </div>
                    </article>

                    <article class="mytask_item">
                        <a href="<?= Url::to(['help-tasks']) ?>" class="mytask_item-link"></a>
                        <div class="mytask_item-content">
                            <date class="mytask_item-date"></date>
                            <p class="mytask_item-subtitle">интенсив “Менеджер продаж”</p>
                            <h2 class="mytask_item-title">10.4 Задание</h2>
                            <p class="mytask_item-text">
                                С помощью представленных инструментов напишите эффективный скрипт для продажи продукта ...
                            </p>
                            <div class="mytask_item-check">
                                <div class="mytask_item-block">
                                    <p class="mytask_item-check-text">Ожидают проверки</p>
                                    <p class="mytask_item-check-num">20</p>
                                </div>
                            </div>
                        </div>
                    </article>
                </div>
                <div class="mytask_page-aside">
                    <div class="mytask_page-sorting">
                        <h3 class="mytask_page-sorting-title">
                            Сортировать по программам
                        </h3>
                        <?= Html::beginForm('', 'get', ['class' => 'mytask_page-sorting-form']) ?>
                        <div class="mytask_page-sorting-body">
                            <input id="curs-market" class="mytask_page-sorting-item-check sr-only" type="checkbox" name="type[]" value="курс Маркетинг">
                            <label for="curs-market" class="mytask_page-sorting-item">
                                <p class="mytask_page-sorting-item-subtitle">курс</p>
                                <p class="mytask_page-sorting-item-title">Маркетинг</p>
                            </label>

                            <input id="intensive-market" class="mytask_page-sorting-item-check sr-only" type="checkbox" name="type[]" value="интенсив Маркетинг">
                            <label for="intensive-market" class="mytask_page-sorting-item">
                                <p class="mytask_page-sorting-item-subtitle">интенсив</p>
                                <p class="mytask_page-sorting-item-title">Маркетинг</p>
                            </label>

                            <input id="intensive-manager" class="mytask_page-sorting-item-check sr-only" type="checkbox" name="type[]" value="интенсив Менеджер продаж">
                            <label for="intensive-manager" class="mytask_page-sorting-item">
                                <p class="mytask_page-sorting-item-subtitle">интенсив</p>
                                <p class="mytask_page-sorting-item-title">Менеджер продаж</p>
                            </label>
                        </div>
                        <?= Html::endForm(); ?>
                    </div>
                </div>
            </div>

            <!--Если нет заданий-->
            <section class="courses_none courses_none--tasks">
                <img src="<?= Url::to('../img/skillclient/education-none-curses.png') ?>" alt="icon">
                <p>Здесь будут отражены все ваши активные задания.</p>
            </section>
        </section>
    </article>

    <footer class="footer">
        <div class="">
            <a href="<?= Url::to(['manual']) ?>" class="footer__link">
                Договор-оферта
            </a>
            <a href="<?= Url::to(['manual']) ?>" class="footer__link">
                Руководство пользователя
            </a>
            <a href="<?= Url::to(['support']) ?>" class="footer__link">
                Тех.поддержка
            </a>
        </div>
    </footer>
</section>