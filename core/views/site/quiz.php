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
                Для чего Вам нужны новые клиенты?
            </h2>

            <div class="quiz-input-group">
                <label class="label">
                    <input class="radio rad" type="radio" name="why"
                           value="Работаю в найме, хочу открыть свою юр. компанию">
                    <p>Работаю в найме, хочу открыть свою юр. компанию</p>
                </label>
                <label class="label">
                    <input class="radio rad" type="radio" name="why" value="Только начал(а) свою практику">
                    <p>Только начал(а) свою практику</p>
                </label>
                <label class="label">
                    <input class="radio rad" type="radio" name="why" value="Уже есть поток клиентов, нужно больше">
                    <p>Уже есть поток клиентов, нужно больше</p>
                </label>
                <label class="label">
                    <input class="radio rad" type="radio" name="why" value="Своя реклама стала работать хуже">
                    <p>Своя реклама стала работать хуже</p>
                </label>
                <label class="label">
                    <input class="radio rad" type="radio" name="why" value="Хочу открыть юридическую компанию">
                    <p>Хочу открыть юридическую компанию</p>
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
                Вам нужно только назначить встречу и заключить договор, привлекать обращения от клиентов будем мы. <br>
                Насколько вам это подходит?
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
                Вы готовы расширить штат сотрудников, если мы закроем вопрос с клиентами?
            </h2>

            <div class="quiz-input-group">
                <label class="label">
                    <input class="radio rad" type="radio" name="ready" value="Конечно, были бы клиенты">
                    <p>Конечно, были бы клиенты</p>
                </label>
                <label class="label">
                    <input class="radio rad" type="radio" name="ready" value="Я пока не готов(а) никого нанимать">
                    <p>Я пока не готов(а) никого нанимать</p>
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
