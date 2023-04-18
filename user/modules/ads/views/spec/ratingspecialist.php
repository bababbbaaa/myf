<?php

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Рейтинг исполнителей';

$js = <<< JS
JS;
$this->registerJs($js);

?>

<section class="rightInfo">
    <div class="bcr">
        <ul class="bcr__list">
            <li class="bcr__item">
                <span class="bcr__span">
                    Рейтинг исполнителей
                </span>
            </li>
        </ul>
    </div>

    <div class="title_row">
        <h1 class="Bal-ttl title-main">Рейтинг исполнителей</h1>
    </div>

        <ul class="rating_list">
            <li class="rating_list-item">
               <p class="rating_list-item-p">место</p>
               <p class="rating_list-item-p">Исполнитель</p>
               <p class="rating_list-item-p">число выполненных заказов</p>
               <p class="rating_list-item-p">средняя оценка заказов</p>
               <p class="rating_list-item-p">статус</p>
            </li>
            <li class="rating_list-item">
                <div class="rating_list-item_container">
                    <p class="rating_list-item-p">место</p>
                    <p class="rating_list-item-p1">1</p>
                </div>
                <div class="rating_list-item_container">
                    <p class="rating_list-item-p">Исполнитель</p>
                    <div class="rating_list-item-g">
                        <a class="rating-spec-link" href="<?= Url::to(['']) ?>"></a>
                        <div class="rating_list-item-g-img">
                            <img src="<?= Url::to('/img/afo/best1.svg') ?>" alt="specialist-photo">
                        </div>
                        <p class="rating_list-item-g-name">Вероника Кириллова</p>
                    </div>
                </div>
                <div class="rating_list-item_container">
                    <p class="rating_list-item-p">число выполненных заказов</p>
                    <p class="rating_list-item-num">5326</p>
                </div>
                <div class="rating_list-item_container">
                    <p class="rating_list-item-p">средняя оценка заказов</p>
                    <div class="main_specialists_list-item_top-rat rating_list-item-rat spetialist-card_top_right-rating">
                        <svg width="16" height="17" viewBox="0 0 16 17" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M8.27569 12.4208L11.4279 14.4179C11.8308 14.6732 12.3311 14.2935 12.2115 13.8232L11.3008 10.2405C11.2752 10.1407 11.2782 10.0357 11.3096 9.9376C11.3409 9.83946 11.3994 9.75218 11.4781 9.68577L14.3049 7.33306C14.6763 7.02392 14.4846 6.40751 14.0074 6.37654L10.3159 6.13696C10.2165 6.12986 10.1211 6.09465 10.0409 6.03545C9.96069 5.97625 9.89896 5.89548 9.86289 5.80255L8.48612 2.33549C8.44869 2.23685 8.38215 2.15194 8.29532 2.09201C8.2085 2.03209 8.1055 2 8 2C7.89451 2 7.79151 2.03209 7.70468 2.09201C7.61786 2.15194 7.55131 2.23685 7.51389 2.33549L6.13712 5.80255C6.10104 5.89548 6.03931 5.97625 5.95912 6.03545C5.87892 6.09465 5.78355 6.12986 5.68412 6.13696L1.99263 6.37654C1.51544 6.40751 1.32373 7.02392 1.69515 7.33306L4.52185 9.68577C4.60063 9.75218 4.65906 9.83946 4.69044 9.9376C4.72181 10.0357 4.72485 10.1407 4.6992 10.2405L3.85459 13.563C3.71111 14.1274 4.31143 14.583 4.79495 14.2767L7.72431 12.4208C7.8067 12.3683 7.90234 12.3405 8 12.3405C8.09767 12.3405 8.1933 12.3683 8.27569 12.4208Z" fill="#2CCD65" stroke="#2CCD65" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        <span>5.0</spa>
                    </div>
                </div>
                <div class="rating_list-item_container">
                    <p class="rating_list-item-p">статус</p>
                    <div class="rating_list-item-status">
                        <p class="rating_list-item-status-text">экперт</p>
                    </div>
                </div>
            </li>
            <li class="rating_list-item">
                <div class="rating_list-item_container">
                    <p class="rating_list-item-p">место</p>
                    <p class="rating_list-item-p1">1</p>
                </div>
                <div class="rating_list-item_container">
                    <p class="rating_list-item-p">Исполнитель</p>
                    <div class="rating_list-item-g">
                        <a class="rating-spec-link" href="<?= Url::to(['']) ?>"></a>
                        <div class="rating_list-item-g-img">
                            <img src="<?= Url::to('/img/afo/best1.svg') ?>" alt="specialist-photo">
                        </div>
                        <p class="rating_list-item-g-name">Вероника Кириллова</p>
                    </div>
                </div>
                <div class="rating_list-item_container">
                    <p class="rating_list-item-p">число выполненных заказов</p>
                    <p class="rating_list-item-num">5326</p>
                </div>
                <div class="rating_list-item_container">
                    <p class="rating_list-item-p">средняя оценка заказов</p>
                    <div class="main_specialists_list-item_top-rat rating_list-item-rat spetialist-card_top_right-rating">
                        <svg width="16" height="17" viewBox="0 0 16 17" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M8.27569 12.4208L11.4279 14.4179C11.8308 14.6732 12.3311 14.2935 12.2115 13.8232L11.3008 10.2405C11.2752 10.1407 11.2782 10.0357 11.3096 9.9376C11.3409 9.83946 11.3994 9.75218 11.4781 9.68577L14.3049 7.33306C14.6763 7.02392 14.4846 6.40751 14.0074 6.37654L10.3159 6.13696C10.2165 6.12986 10.1211 6.09465 10.0409 6.03545C9.96069 5.97625 9.89896 5.89548 9.86289 5.80255L8.48612 2.33549C8.44869 2.23685 8.38215 2.15194 8.29532 2.09201C8.2085 2.03209 8.1055 2 8 2C7.89451 2 7.79151 2.03209 7.70468 2.09201C7.61786 2.15194 7.55131 2.23685 7.51389 2.33549L6.13712 5.80255C6.10104 5.89548 6.03931 5.97625 5.95912 6.03545C5.87892 6.09465 5.78355 6.12986 5.68412 6.13696L1.99263 6.37654C1.51544 6.40751 1.32373 7.02392 1.69515 7.33306L4.52185 9.68577C4.60063 9.75218 4.65906 9.83946 4.69044 9.9376C4.72181 10.0357 4.72485 10.1407 4.6992 10.2405L3.85459 13.563C3.71111 14.1274 4.31143 14.583 4.79495 14.2767L7.72431 12.4208C7.8067 12.3683 7.90234 12.3405 8 12.3405C8.09767 12.3405 8.1933 12.3683 8.27569 12.4208Z" fill="#2CCD65" stroke="#2CCD65" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        <span>5.0</spa>
                    </div>
                </div>
                <div class="rating_list-item_container">
                    <p class="rating_list-item-p">статус</p>
                    <div class="rating_list-item-status">
                        <p class="rating_list-item-status-text orange">экперт</p>
                    </div>
                </div>
            </li>
            <li class="rating_list-item">
                <div class="rating_list-item_container">
                    <p class="rating_list-item-p">место</p>
                    <p class="rating_list-item-p1">1</p>
                </div>
                <div class="rating_list-item_container">
                    <p class="rating_list-item-p">Исполнитель</p>
                    <div class="rating_list-item-g">
                        <a class="rating-spec-link" href="<?= Url::to(['']) ?>"></a>
                        <div class="rating_list-item-g-img">
                            <img src="<?= Url::to('/img/afo/best1.svg') ?>" alt="specialist-photo">
                        </div>
                        <p class="rating_list-item-g-name">Вероника Кириллова</p>
                    </div>
                </div>
                <div class="rating_list-item_container">
                    <p class="rating_list-item-p">число выполненных заказов</p>
                    <p class="rating_list-item-num">5326</p>
                </div>
                <div class="rating_list-item_container">
                    <p class="rating_list-item-p">средняя оценка заказов</p>
                    <div class="main_specialists_list-item_top-rat rating_list-item-rat spetialist-card_top_right-rating">
                        <svg width="16" height="17" viewBox="0 0 16 17" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M8.27569 12.4208L11.4279 14.4179C11.8308 14.6732 12.3311 14.2935 12.2115 13.8232L11.3008 10.2405C11.2752 10.1407 11.2782 10.0357 11.3096 9.9376C11.3409 9.83946 11.3994 9.75218 11.4781 9.68577L14.3049 7.33306C14.6763 7.02392 14.4846 6.40751 14.0074 6.37654L10.3159 6.13696C10.2165 6.12986 10.1211 6.09465 10.0409 6.03545C9.96069 5.97625 9.89896 5.89548 9.86289 5.80255L8.48612 2.33549C8.44869 2.23685 8.38215 2.15194 8.29532 2.09201C8.2085 2.03209 8.1055 2 8 2C7.89451 2 7.79151 2.03209 7.70468 2.09201C7.61786 2.15194 7.55131 2.23685 7.51389 2.33549L6.13712 5.80255C6.10104 5.89548 6.03931 5.97625 5.95912 6.03545C5.87892 6.09465 5.78355 6.12986 5.68412 6.13696L1.99263 6.37654C1.51544 6.40751 1.32373 7.02392 1.69515 7.33306L4.52185 9.68577C4.60063 9.75218 4.65906 9.83946 4.69044 9.9376C4.72181 10.0357 4.72485 10.1407 4.6992 10.2405L3.85459 13.563C3.71111 14.1274 4.31143 14.583 4.79495 14.2767L7.72431 12.4208C7.8067 12.3683 7.90234 12.3405 8 12.3405C8.09767 12.3405 8.1933 12.3683 8.27569 12.4208Z" fill="#2CCD65" stroke="#2CCD65" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        <span>5.0</spa>
                    </div>
                </div>
                <div class="rating_list-item_container">
                    <p class="rating_list-item-p">статус</p>
                    <div class="rating_list-item-status">
                        <p class="rating_list-item-status-text blue">экперт</p>
                    </div>
                </div>
            </li>
            <li class="rating_list-item">
                <div class="rating_list-item_container">
                    <p class="rating_list-item-p">место</p>
                    <p class="rating_list-item-p1">1</p>
                </div>
                <div class="rating_list-item_container">
                    <p class="rating_list-item-p">Исполнитель</p>
                    <div class="rating_list-item-g">
                        <a class="rating-spec-link" href="<?= Url::to(['']) ?>"></a>
                        <div class="rating_list-item-g-img">
                            <img src="<?= Url::to('/img/afo/best1.svg') ?>" alt="specialist-photo">
                        </div>
                        <p class="rating_list-item-g-name">Вероника Кириллова</p>
                    </div>
                </div>
                <div class="rating_list-item_container">
                    <p class="rating_list-item-p">число выполненных заказов</p>
                    <p class="rating_list-item-num">5326</p>
                </div>
                <div class="rating_list-item_container">
                    <p class="rating_list-item-p">средняя оценка заказов</p>
                    <div class="main_specialists_list-item_top-rat rating_list-item-rat spetialist-card_top_right-rating">
                        <svg width="16" height="17" viewBox="0 0 16 17" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M8.27569 12.4208L11.4279 14.4179C11.8308 14.6732 12.3311 14.2935 12.2115 13.8232L11.3008 10.2405C11.2752 10.1407 11.2782 10.0357 11.3096 9.9376C11.3409 9.83946 11.3994 9.75218 11.4781 9.68577L14.3049 7.33306C14.6763 7.02392 14.4846 6.40751 14.0074 6.37654L10.3159 6.13696C10.2165 6.12986 10.1211 6.09465 10.0409 6.03545C9.96069 5.97625 9.89896 5.89548 9.86289 5.80255L8.48612 2.33549C8.44869 2.23685 8.38215 2.15194 8.29532 2.09201C8.2085 2.03209 8.1055 2 8 2C7.89451 2 7.79151 2.03209 7.70468 2.09201C7.61786 2.15194 7.55131 2.23685 7.51389 2.33549L6.13712 5.80255C6.10104 5.89548 6.03931 5.97625 5.95912 6.03545C5.87892 6.09465 5.78355 6.12986 5.68412 6.13696L1.99263 6.37654C1.51544 6.40751 1.32373 7.02392 1.69515 7.33306L4.52185 9.68577C4.60063 9.75218 4.65906 9.83946 4.69044 9.9376C4.72181 10.0357 4.72485 10.1407 4.6992 10.2405L3.85459 13.563C3.71111 14.1274 4.31143 14.583 4.79495 14.2767L7.72431 12.4208C7.8067 12.3683 7.90234 12.3405 8 12.3405C8.09767 12.3405 8.1933 12.3683 8.27569 12.4208Z" fill="#2CCD65" stroke="#2CCD65" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        <span>5.0</spa>
                    </div>
                </div>
                <div class="rating_list-item_container">
                </div>
            </li>
        </ul>

        <footer class="footer">
        <div class="">
            <a href="<?= Url::to(['manual']) ?>" class="footer__link">
                Руководство пользователя
            </a>
            <a href="<?= Url::to(['support']) ?>" class="footer__link">
                Тех.поддержка
            </a>
        </div>
    </footer>
</section>