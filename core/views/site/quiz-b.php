<?php


use yii\helpers\Html;

?>
<?= Html::beginForm('', 'post', ['class' => 'quiz-form']) ?>
<input type="hidden" name="URL" value="<?= $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] ?>">
<input type="hidden" name="formType" value="Форма обратной связи">
<input type="hidden" name="pipeline" value="104">
<input type="hidden" value="" name="city">
<input type="hidden" value="" name="new_region">
<input type="hidden" name="utm_source" value="<?= $_SESSION['utm_source'] ?>">
<input type="hidden" name="utm_campaign" value="<?= $_SESSION['utm_campaign'] ?>">
<input type="hidden" name="service" value="">
<section class="quiz">
    <div class="Staps Stap1 vis">
        <div class="quiz_container">
            <h2 class="quiz-title">
                Почему Вы хотите привлечь новый поток клиентов?
            </h2>

            <div class="quiz-input-group">
                <label class="label">
                    <input class="radio rad" type="radio" name="why" value="Нет сил искать клиентов">
                    <p>Нет сил искать клиентов</p>
                </label>
                <label class="label">
                    <input class="radio rad" type="radio" name="why" value="Моя рекламная кампания не работает">
                    <p>Моя рекламная кампания не работает</p>
                </label>
                <label class="label">
                    <input class="radio rad" type="radio" name="why" value="Не хватает времени заниматься рекламой">
                    <p>Не хватает времени заниматься рекламой</p>
                </label>
                <label class="label">
                    <input class="radio rad" type="radio" name="why" value="Хочу увеличить свой объем продаж">
                    <p>Хочу увеличить свой объем продаж</p>
                </label>
            </div>

            <div class="quiz_last-row">
                <button type="button" class="btn btn--back">
                    <p class="btn--back-text">Назад</p>
                </button>

                <div class="fill-column">
                    <p class="fill-column-text">1/4</p>

                    <div class="fill-column-fill-wrapp">
                        <div class="fill"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="Staps Stap2">
        <div class="quiz_container">
            <h2 class="quiz-title">
                Привлекать обращения от клиентов будем мы, Вам нужно просто делать свою работу. Насколько Вам это
                удобно?
            </h2>

            <div class="quiz-input-group">
                <label class="label">
                    <input class="radio rad" type="radio" name="convenience" value="Отлично, мне подходит!">
                    <p>Отлично, мне подходит!</p>
                </label>
                <label class="label">
                    <input class="radio rad" type="radio" name="convenience" value="Сомневаюсь дать точный ответ">
                    <p>Сомневаюсь дать точный ответ</p>
                </label>
            </div>

            <div class="quiz_last-row">
                <button type="button" class="btn btn--back">
                    <p class="btn--back-text">Назад</p>
                </button>

                <div class="fill-column">
                    <p class="fill-column-text">2/4</p>

                    <div class="fill-column-fill-wrapp">
                        <div class="fill"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="Staps Stap3">
        <div class="quiz_container">
            <h2 class="quiz-title">
                Когда Вы готовы принять новых клиентов?
            </h2>

            <div class="quiz-input-group">
                <label class="label">
                    <input class="radio rad" type="radio" name="when" value="Хоть сейчас">
                    <p>Хоть сейчас</p>
                </label>
                <label class="label">
                    <input class="radio rad" type="radio" name="when" value="В течение 1-2 недель">
                    <p>В течение 1-2 недель</p>
                </label>
                <label class="label">
                    <input class="radio rad" type="radio" name="when" value="В течение месяца">
                    <p>В течение месяца</p>
                </label>
                <label class="label">
                    <input class="radio rad" type="radio" name="when" value="Пока не знаю">
                    <p>Пока не знаю</p>
                </label>
            </div>

            <div class="quiz_last-row">
                <button type="button" class="btn btn--back">
                    <p class="btn--back-text">Назад</p>
                </button>

                <div class="fill-column">
                    <p class="fill-column-text">3/4</p>

                    <div class="fill-column-fill-wrapp">
                        <div class="fill"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="Staps Stap4">
        <div class="quiz_container">
            <h2 class="quiz-title">
                Вы готовы расширить свой бизнес, если мы закроем вопрос с клиентами?
            </h2>

            <div class="quiz-input-group">
                <label class="label">
                    <input class="radio rad" type="radio" name="ready" value="Мы всегда готовы к расширению компании">
                    <p>Мы всегда готовы к расширению компании</p>
                </label>
                <label class="label">
                    <input class="radio rad" type="radio" name="ready" value="Конечно, были бы клиенты">
                    <p>Конечно, были бы клиенты</p>
                </label>
                <label class="label">
                    <input class="radio rad" type="radio" name="ready" value="Возможно, но нужно обдумать">
                    <p>Возможно, но нужно обдумать</p>
                </label>
                <label class="label">
                    <input class="radio rad" type="radio" name="ready"
                           value="Нет, мне нужно пару клиентов просто для себя">
                    <p>Нет, мне нужно пару клиентов просто для себя</p>
                </label>
            </div>

            <div class="quiz_last-row">
                <button type="button" class="btn btn--back">
                    <p class="btn--back-text">Назад</p>
                </button>

                <div class="fill-column">
                    <p class="fill-column-text">4/4</p>

                    <div class="fill-column-fill-wrapp">
                        <div class="fill"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="Staps Stap5">
        <div class="quiz_container">
            <h2 class="quiz-title">
                Почти готово!
                <br>
                Заполните форму для получения
                <br>
                <span>приветственного бонуса</span>
            </h2>

            <div class="quiz-input-group">
                <input placeholder="Введите имя" class="input-t" required minlength="2" type="text" name="fio">
                <input placeholder="Номер телефона" class="input-t" required type="tel" name="phone">
                <button class="btn btn-quiz-submit" type="submit"><p>Получить бонус</p></button>
                <p class="description">*отправляя формы на данном сайте, вы даете согласие на обработку персональных
                    данных в соответствии с 152-ФЗ</p>
            </div>

            <button type="button" class="btn btn--back">
                <p class="btn--back-text">Назад</p>
            </button>
        </div>
    </div>
</section>
<?= Html::endForm(); ?>
