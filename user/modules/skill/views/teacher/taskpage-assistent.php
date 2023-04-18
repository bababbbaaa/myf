<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;

$this->title = 'Задание';

$js = <<< JS

var statusItamCard = $(".taskpage_solutions-date");
statusItamCard.each(function () {
    if($(this).text() == 'Зачет') {
        $(this).css("color", "#2CCD65");
    } else if($(this).text()  == 'Незачет') {
        $(this).css("color", "#FF6359");
    } else if ($(this).text()  == 'На доработку') {
        $(this).css("color", "#FFA800");
    } else {
        $(this).css("color", "#FFA800");
    }
})

//Копирование ссылки задания студента по клику на блок
$(".taskpage__check-copylink").on("click", function () {
    var tmp = $("<textarea>");
    $("body").append(tmp);
    tmp.val($(this).text()).select();
    document.execCommand("copy");
    tmp.remove();

    setTimeout(() => {
        $(this).next().fadeIn(300);
    }, 300);

    setTimeout(() => {
        $(this).next().fadeOut(300);
    }, 2000);
});

//Действия при проверки задания
$(".taskpage__rating-btn").on("click", function () {
    var taskRating = $(this).parents(".taskpage__rating"),
        taskInput = taskRating.find(".taskpage__rating-input"),
        taskInputVal = taskRating.find(".taskpage__rating-input").val(),
        starRating = taskRating.find(".taskpage__rating-star-input"),
        solutions = $(this).parents(".taskpage_solutions-item"),
        solutionsDate = solutions.find(".taskpage_solutions-date"),
        comment = solutions.find(".taskpage__check-coment--you");

    starRating.attr('disabled', 'disabled');
    taskInput.attr('disabled', 'disabled');
    $(".taskpage__rating-btn").attr('disabled', 'disabled');
    $(this).removeAttr("disabled");
    $(this).addClass("click");
    comment.text(taskInputVal);

    if($(this).hasClass("taskpage__rating-btn--green")) {
        solutionsDate.text('Зачет').css("color", "#2CCD65");
    } else if($(this).hasClass("taskpage__rating-btn--red")) {
        solutionsDate.text('Незачет').css("color", "#FF6359");
    } else if($(this).hasClass("taskpage__rating-btn--yellow")) {
        solutionsDate.text('На доработку').css("color", "#FFA800");
    }
});

    $(".taskpage_solutions-links, .taskpage_solutions-link").on("click", function (e) {
    e.preventDefault();
    var taksItem = $(this).parents(".taskpage_solutions-item");
    var status = taksItem.find(".taskpage_solutions-date").text();
    var comment = taksItem.find(".taskpage__check-coment--you");

    if(status == "Зачет" || status == "Незачет" || status == "На доработку") {
        taksItem.find(".taskpage__check").css("display", "block");
        taksItem.find(".taskpage_solutions-link, .taskpage_solutions-links").css("display", "none");
        if (comment.text().length >= 1) {
            comment.parent(".taskpage__check-block--you").css("display", "block");
        }
    } else {
        taksItem.find(".taskpage__check, .taskpage__rating").css("display", "block");
        taksItem.find(".taskpage_solutions-link, .taskpage_solutions-links").css("display", "none");
    }
});

$(".popup-change_btn").on("click", function () {
    $(".popup-change").addClass("open");
    $("body").addClass("hidden");
});

$(".popup-change__close, .popup-change__cancel").on("click", function () {
    $(".popup-change").removeClass("open");
    $("body").removeClass("hidden");
});

$(".popup-change__body").on("click", function (e) {
    if($(this).has(e.target).length === 0) {
        $(".popup-change").removeClass("open");
        $("body").removeClass("hidden");
    }
});

$(".popup-change__form").on("submit", function (e) {
    $.ajax ({
        url: "/",
        type: "POST",
        data: $(this).serialize(),
        beforeSend: (function () {
            $(".step1").fadeOut(300, function () {
                $(".step2").fadeIn(300);
            });
        }),
    });
    e.preventDefault();
});

JS;

$this->registerJs($js);

?>

<section class="rightInfo">
    <div class="bcr">
        <ul class="bcr__list">
            <li class="bcr__item">
                <span class="bcr__link">Проверка заданий</span>
            </li>
            <li class="bcr__item">
                <span class="bcr__link">Ассистент</span>
            </li>
            <li class="bcr__item">
                <span class="bcr__span nowpagebrc">Задание</span>
            </li>
        </ul>
    </div>
    <div class="title_row">
        <h1 class="Bal-ttl title-main">Задание 10.4</h1>
    </div>

    <article class="taskpage_main">
        <div class="taskpage_main-wrapp">
            <div class="taskpage_main-content">
                <div class="taskpage_main-body">
                    <p class="taskpage_main-text">
                        С помощью представленных инструментов напишите эффективный скрипт для продажи продукта.
                    </p>
                    <p class="taskpage_main-text">
                        В скрипте должно быть использовано следующее:
                    </p>
                    <ul class="taskpage_main-list">
                        <li class="taskpage_main-item">инструмент 1</li>
                        <li class="taskpage_main-item">инструмент 2</li>
                        <li class="taskpage_main-item">инструмент 3</li>
                    </ul>
                    <p class="taskpage_main-text">
                        Сформировать карту взаимодействия с клиентом с учетом потребностей и возможных страхов клиента.
                    </p>
                    <p class="taskpage_main-text">
                        Составить список причин отказа
                    </p>
                    <p class="taskpage_main-text">
                        Проработать варианты для отказа клиента
                    </p>
                </div>
                <div class="taskpage_main-btns">
                    <?= Html::beginForm('', 'post', ['class' => 'taskpage_main-filter-form']) ?>
                    <section class="mytasks_main-filter">
                        <label class="MyOrders_filter-check-l taskpage_main-label sendActive programs-filter-submit active">Нужно проверить
                            <input class="MyOrders_filter-check" type="checkbox" name="task-cat" value="Нужно проверить" checked>
                        </label>
                        <label class="MyOrders_filter-check-l taskpage_main-label sendActive programs-filter-submit ">Проверенные
                            <input class="MyOrders_filter-check" type="checkbox" name="task-cat" value="Проверенные">
                        </label>
                        <label class="MyOrders_filter-check-l taskpage_main-label sendActive programs-filter-submit ">Архив
                            <input class="MyOrders_filter-check" type="checkbox" name="task-cat" value="Архив">
                        </label>
                    </section>
                    <?= Html::endForm(); ?>
                </div>

                <div class="taskpage_solutions">
                    <article class="taskpage_solutions-item">
                        <a href="<?= Url::to(['#']) ?>" class="taskpage_solutions-links"></a>
                        <div class="taskpage_solutions-block">
                            <h2 class="taskpage_solutions-title">Решение студента</h2>
                            <date class="taskpage_solutions-date">На доработку</date>
                        </div>
                        <div class="taskpage_solutions-student">
                            <div class="taskpage_student-post">Студент</div>
                            <p class="taskpage_student-name">Алексей Иванов</p>
                            <date class="taskpage_student-date">25.08.2021</date>
                        </div>
                        <a href="<?= Url::to(['#']) ?>" class="taskpage_solutions-link">Смотреть решение</a>
                        <div class="taskpage__check" style="display: none;">
                            <p class="taskpage__check-revision" style="display: none;">
                                Доработанно <span class="taskpage__check-revision-date">02.12.2022</span>
                            </p>
                            <div class="taskpage__check-block">
                                <p class="taskpage__check-desc">Загруженное решение</p>
                                <div class="taskpage__check-copylink">
                                    <p>http://pdjfvsjnbjkbjntfhymjfghm</p>
                                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M10.9354 6.82205L7.42169 3.30834C6.31279 2.19944 4.49049 2.22387 3.35146 3.3629C2.21243 4.50193 2.188 6.32423 3.2969 7.43313L6.30865 10.4449" stroke="#A5AABE" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                        <path d="M13.7107 9.58463L16.7224 12.5964C17.8313 13.7053 17.8069 15.5276 16.6679 16.6666C15.5288 17.8056 13.7065 17.8301 12.5976 16.7212L9.08393 13.2075" stroke="#A5AABE" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                        <path d="M10.8789 10.8921C12.018 9.75308 12.0424 7.93078 10.9335 6.82188" stroke="#A5AABE" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                        <path d="M9.08396 9.0825C7.94494 10.2215 7.92051 12.0438 9.0294 13.1527" stroke="#A5AABE" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                </div>
                                <p class="taskpage__check-copylink-mass">Ссылка скопированна</p>
                            </div>
                            <div class="taskpage__check-block">
                                <p class="taskpage__check-desc">Комментарий студента</p>
                                <p class="taskpage__check-coment">
                                    Интересное задание. Не смог сообразить с причинами отказа, поэтому создал отдельную ветку ...
                                </p>
                            </div>
                            <div class="taskpage__check-block taskpage__check-block--you" style="display: none;">
                                <p class="taskpage__check-desc">Комментарий</p>
                                <p class="taskpage__check-coment taskpage__check-coment--you"></p>
                            </div>
                        </div>
                    </article>
                </div>
            </div>
            <aside class="taskpage_main-aside">
                <div class="myprogramm_right_top taskpage_right_top">
                    <div class="myprogramm_right_top_spoiler taskpage_right_top_spoiler">
                        <button class="myprogramm_right_top_spoiler-btn taskpage_right_top_spoiler-btn">
                            Действия
                        </button>
                        <ul class="myprogramm_right_top_spoiler_list">
                            <li class="myprogramm_right_top_spoiler_list-item">
                                <button class="myprogramm_right_top_spoiler_list-item-btn popup-change_btn">
                                    Заменить
                                </button>
                            </li>
                        </ul>
                    </div>
                    <div class="taskpage_assistent">
                        <p class="taskpage_assistent-text">Ассистент: <span class="taskpage_assistent-name">Марина Дьярова</span></p>
                    </div>
                </div>

                <div class="taskpage_main-block">
                    <h2 class="taskpage_main-block-title">
                        Все задания курса
                    </h2>
                    <ul class="taskpage_main-block-list">
                        <li class="taskpage_main-block-item">
                            <a href="<?= Url::to(['#']) ?>" class="taskpage_main-block-link">
                                1.4 Инструменты взаимодействия
                            </a>
                        </li>
                        <li class="taskpage_main-block-item">
                            <a href="<?= Url::to(['#']) ?>" class="taskpage_main-block-link">
                                3.2 Инструменты работы с клиентом
                            </a>
                        </li>
                        <li class="taskpage_main-block-item">
                            <a href="<?= Url::to(['#']) ?>" class="taskpage_main-block-link">
                                5.3 Инструменты работы с менеджером
                            </a>
                        </li>
                        <li class="taskpage_main-block-item">
                            <a href="<?= Url::to(['#']) ?>" class="taskpage_main-block-link">
                                6.4 Инструменты интеграции
                            </a>
                        </li>
                        <li class="taskpage_main-block-item">
                            <a href="<?= Url::to(['#']) ?>" class="taskpage_main-block-link active">
                                10.4 Инструменты интеграции
                            </a>
                        </li>
                        <li class="taskpage_main-block-item">
                            <a href="<?= Url::to(['#']) ?>" class="taskpage_main-block-link">
                                6.4 Инструменты интеграции
                            </a>
                        </li>
                    </ul>
                </div>
            </aside>
        </div>
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

    <div class="popup-change">
        <div class="popup-change__body">
            <div class="popup-change__content">
                <div class="popup-change__close">
                    <img src="<?= Url::to(['../img/skillclient/close.svg']) ?>" alt="close">
                </div>
                <?= Html::beginForm('', 'post', ['class' => 'popup-change__form']) ?>
                <div class="popup-change__step step1">
                    <p class="popup-change__title">Заменить ассистента</p>
                    <div class="popup-change__info">
                        <div class="popup-change__block">
                            <label class="popup-change__block-title" for="name-assistent">Укажите данные ассистента</label>
                            <input type="text" name="name" id="name-assistent" class="popup-change__block-input" placeholder="Фамилия Имя" required>
                        </div>
                        <div class="popup-change__block">
                            <label class="popup-change__block-title" for="email-assistent">Укажите электронную почту ассистента
                                <span>(на почту придет приглашение к работе)</span></label>
                            <input type="email" name="email" id="email-assistent" class="popup-change__block-input" placeholder="mail@mail.ru" required>
                        </div>
                        <div class=" popup-change__block">
                            <p class="popup-change__block-title">Добавьте фото ассистента</p>
                            <label class="popup-change__block-file" for="photo-assistent">Загрузить</label>
                            <input type="file" name="photo" id="photo-assistent" class="popup-change__block-input sr-only" required>
                        </div>
                    </div>
                    <div class="popup-change__btns">
                        <button type="submit" class="popup-change__btn popup-change__btn--purpur">Продолжить</button>
                        <button type="button" class="popup-change__btn">Я буду проверять задание</button>
                    </div>
                    <button type="button" class="popup-change__cancel">Отмена</button>
                </div>

                <div class="popup-change__step step2">
                    <p class="popup-change__title popup-change__title--2">Успешно!</p>
                    <div class="popup-change__text">
                        <p>Приглашение отправлено на указанную почту. Ассистенту необходимо принять приглашение в течение 3 дней.</p>
                        <p><span>Важно!</span> Если приглашение не будет принято в течение 3 дней, проверяющий изменен не будет</p>
                    </div>
                    <button type="button" class="popup-change__btn popup-change__btn--purpur popup-change__btn--step2">Продолжить</button>
                </div>
                <?= Html::endForm() ?>
            </div>
        </div>
    </div>
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