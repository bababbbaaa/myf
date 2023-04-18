<?php use yii\helpers\Html;

use yii\helpers\Url; ?>
<footer class="footer animate">
    <div class="container">
        <div class="footer_top">
            <div class="footer_top_left">
                <a target="_blank" class="footer_top-links" href="https://www.myforce.ru/about">Узнать больше о
                    проекте</a>
                <a target="_blank" class="footer_top-links" href="https://www.myforce.ru/#partners">Партнеры проекта</a>
            </div>
            <div class="footer_top_rigth">
                <img src="<?= Url::to(['img/quiz-bfl/MYForce.svg']) ?>" alt="MYFORCE">
                <p>Делаем бизнес доступным для всех</p>
            </div>
        </div>
        <div class="footer_bottom">
            <div class="footer_bottom_left">
                <p>ИНН 614709735510</p>
                <p>ОГРН 1156196049415</p>
                <p>© 2015-2021 Все права защищены ООО «ИСМ»</p>
                <a target="_blank" class="footer_bottom-link" href="/policy.html">Политика обработки персональных
                    данных</a>
            </div>
            <div class="footer_bottom_right">
                <a class="footer_bottom-right-phone" href="tel:+7 495 118 39 34">+7 495 118 39 34</a>
                <a target="_blank" class="footer_bottom-link" href="/policy.pdf?v=16">*отправляя формы на данном сайте, вы
                    даете согласие на обработку персональных данных в соответствии с 152-ФЗ</a>
            </div>
        </div>
    </div>
</footer>
</div>

<?php include_once('quiz.php') ?>

<div class="back"></div>
<div class="popup-wrap">
    <section class="popup">
        <button class="btn btn-popup-close">
            <img src="<?= Url::to(['img/quiz-bfl/close.svg']) ?>" alt="close">
        </button>

        <div class="popup_staps popup_stap1">
            <h2 class="popup-title">Заполните форму для получения консультации эксперта</h2>
            <?= Html::beginForm('', 'post', ['class' => 'popup-form']) ?>
            <input type="hidden" name="URL" value="<?= $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] ?>">
            <input type="hidden" name="formType" value="Форма обратной связи">
            <input type="hidden" name="pipeline" value="104">
            <input type="hidden" value="" name="city">
            <input type="hidden" value="" name="new_region">
            <input type="hidden" name="utm_source" value="<?= $_SESSION['utm_source'] ?>">
            <input type="hidden" name="utm_campaign" value="<?= $_SESSION['utm_campaign'] ?>">
            <input type="hidden" name="service" value="">
            <input placeholder="Введите имя" class="input-t" required minlength="2" type="text" name="fio">
            <input placeholder="Номер телефона" class="input-t" required type="tel" name="phone">
            <button class="btn btn-popup" type="submit">Заказать обратный звонок</button>
            <p class="popup-description">*отправляя формы на данном сайте, вы даете согласие на обработку персональных
                данных в соответствии с 152-ФЗ</p>
            <?= Html::endForm(); ?>
        </div>

        <div class="popup_staps popup_stap2">
            <h2 class="popup-title">Спасибо за вашу заявку, <br> в скором времени мы свяжемся с вами</h2>
            <h3 class="popup-under-title">Пока Вы ожидаете звонка нашего специалиста, узнайте больше о продуктах нашей
                компании</h3>
            <a target="_blank" href="https://www.myforce.ru/about" class="btn link-btn"><p>Узнать больше</p></a>
        </div>
    </section>
</div>

<script src="<?= Url::to(['js/quiz-bfl/jquery-3.5.1.min.js']) ?>"></script>
<script type="text/javascript" src="<?= Url::to(['js/quiz-bfl/jquery.maskedinput.js']) ?>"></script>
<script src="<?= Url::to(['js/quiz-bfl/script.js']) ?>"></script>
</body>
</HTML>