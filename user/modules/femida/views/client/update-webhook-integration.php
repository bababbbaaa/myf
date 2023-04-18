<?php

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Обновление вебхука';

$order_id = $_GET['order_id'];
$js = <<< JS
    var webhook = '';
    $('.webhook__confirm').on('click', function() {
      var link = $('input[name="webhook_url"]').val();
      $.ajax({
        url: 'webhook-accept',
        data: {url:link},
        dataType: 'JSON',
        type: 'POST',
      }).done(function(rsp) {
        if (rsp.status === 'success'){
            $('.rsp--ajax__text').text('Данные корректны');
            $('.popup--auct').fadeIn(300);
            $('.confirm_btn-send').prop('disabled', false);
            webhook = link;
            $('.webhook__confirm').prop('disabled', true);
            setTimeout(function() {
                $('.webhook__confirm').prop('disabled', false);
            }, 10000)
        } else {
            $('.rsp-ajax-text').html(rsp.message);
            $('.popup--auct-err').fadeIn(300);
        }
      });
    });
    $('.confirm_btn-send').on('click', function() {
        $.ajax({
            url: 'create-integration',
            data: $('.hook_form').serialize(),
            dataType: 'JSON',
            type: 'POST',
        }).done(function(rsp) {
            Swal.fire({
                icon: 'success',
                title: 'Успех!',
                html: "Сохранено",
            });
        })
    });
JS;
$this->registerJs($js);
?>
<section class="rightInfo">
    <div class="integration">
        <div class="bcr">
            <?php if (!empty($order_id)): ?>
                <ul class="bcr__list">
                    <li class="bcr__item">
                        <a href="<?= Url::to(['myorders']) ?>" class="bcr__link">
                            Интеграция
                        </a>
                    </li>
                    <li class="bcr__item">
                        <a class="bcr__link">Обновление интеграции в заказe № <?= $order_id ?></a>
                    </li>
                </ul>
            <?php else: ?>
                <ul class="bcr__list">
                    <li class="bcr__item">
                        <a href="<?= Url::to(['integration']) ?>" class="bcr__link">
                            Интеграция
                        </a>
                    </li>
                    <li class="bcr__item">
                        <a class="bcr__link">Обновление интеграции</a>
                    </li>
                </ul>
            <?php endif; ?>
        </div>
    </div>
    <?php if (!empty($integer)): ?>
    <?php $hook = json_decode($integer['config']) ?>
        <div style="display: block" class="forms__step" id="hook_form">
            <h4>URL внешнего вебхука</h4>
            <p class="hook_form--subtitle">Укажите ссылку на внешний сервер, способный принимать внешние POST-запросы</p>
            <?= Html::beginForm('', 'post', ['class' => 'hook_form']) ?>
            <input type="hidden" name="type_integration" value="webhook">
            <input type="hidden" name="order_id" value="<?= $_GET['order_id'] ?? '' ?>">
            <input value="<?= $hook->WEBHOOK_URL ?>" placeholder="https://mysite.ru/2ejogh48yd" class="hook_link" name="webhook_url" type="text">
            <button type="button" class="confirm_btn webhook__confirm">Подтвердить</button>
            <?= Html::endForm(); ?>
            <p class="hook_form--lasttext">На указанный адрес будет поступать запрос каждый раз при поступлении нового лида.
                Запрос выполняется методом POST.</p>
            <button disabled class="confirm_btn confirm_btn-send">Сохранить интеграцию</button>
        </div>
    <?php else: ?>
        <h4>Интеграция не найдена</h4>
    <?php endif; ?>



    <div class="references__int">
        <h3 class="title__references">Справка</h3>
        <div id="amo" class="accortion__reference">
            <div class="header__reference">
                <div class="dot_head">
                    <div class="dot_int"></div>
                    <h4 class="title__reference">Интеграция с AmoCRM</h4>
                </div>
                <svg class="icon_reference" width="10" height="6" viewBox="0 0 10 6" fill="none"
                     xmlns="http://www.w3.org/2000/svg">
                    <path d="M1.06564 0.683058C0.821561 0.438981 0.425834 0.438981 0.181756 0.683058C-0.0623217 0.927136 -0.0623217 1.32286 0.181756 1.56694L4.34842 5.73361C4.5925 5.97769 4.98823 5.97769 5.23231 5.73361L9.39897 1.56694C9.64305 1.32286 9.64305 0.927136 9.39897 0.683058C9.1549 0.438981 8.75917 0.438981 8.51509 0.683058L4.79036 4.40778L1.06564 0.683058Z"
                          fill="#9BA0B7"/>
                </svg>
            </div>
            <div data-id="amo" class="drop__list">
                <ol class="main__list">
                    <li class="main__list-li">
                        Укажите следующие данные для получения ключа аутентификации:
                        <ul class="mark__change" style="padding: 15px 0 0 40px;">
                            <li>Код авторизации</li>
                            <li>ID интеграции</li>
                            <li>Секретный ключ</li>
                            <li>Ссылку на свою AmoCRM в формате company.amocrm.ru</li>
                        </ul>
                    </li>
                    <p class="red__li">Код авторизации годен 20 минут. Интеграция должан быть создана в течение 20
                        минут после ее создания в AmoCRM</p>
                    <li class="main__list-li">Указав данные в соответствующих полях, нажимаете Получить ключ
                        аутентификации
                    </li>
                    <p class="red__li">Полученный код авторизации можно использовать только 1 раз</p>
                    <li class="main__list-li">
                        Далее появится уведомление об ошибке или корректности ключа. Ключ может быть некорректен в
                        следующих случаях:
                        <ul class="mark__change" style="padding: 12px 0 12px 40px;">
                            <li>просроченный ключ</li>
                            <li>повторное использование кода авторизации</li>
                            <li>ошибка в подставляемых параметрах</li>
                            <li>перепутаны поля,в которые подставляют ключи</li>
                        </ul>
                    </li>
                    <li class="main__list-li">В случае корректности ключа появятся значения OAuth и вам доступна
                        настройка параметров интеграции
                    </li>
                    <li class="main__list-li">
                        Задайте значения обязательных полей:
                        <ul class="mark__change" style="padding: 12px 0 12px 40px;">
                            <li>Выберите ответственного за лид и контакт. Нажмите Добавить параметр</li>
                            <li>Выберите Воронку. Нажмите Добавить параметр</li>
                            <li>Выберите Статус сделки. Нажмите Добавить параметр</li>
                        </ul>
                    </li>
                    <li class="main__list-li">Выберите дополнительный параметры из каталога ниже</li>
                    <li class="main__list-li">Введите необходимое значение и нажмите Добавить параметр</li>
                    <li class="main__list-li">При необходимости повторите пункты 6-7</li>
                    <li class="main__list-li">Когда все необходимые параметры добавлены, нажмите Сохранить
                        интеграцию
                    </li>
                </ol>
            </div>
        </div>
        <div id="bitrix" class="accortion__reference">
            <div class="header__reference">
                <div class="dot_head">
                    <div class="dot_int"></div>
                    <h4 class="title__reference">Интеграция с Битрикс24</h4>
                </div>
                <svg class="icon_reference" width="10" height="6" viewBox="0 0 10 6" fill="none"
                     xmlns="http://www.w3.org/2000/svg">
                    <path d="M1.06564 0.683058C0.821561 0.438981 0.425834 0.438981 0.181756 0.683058C-0.0623217 0.927136 -0.0623217 1.32286 0.181756 1.56694L4.34842 5.73361C4.5925 5.97769 4.98823 5.97769 5.23231 5.73361L9.39897 1.56694C9.64305 1.32286 9.64305 0.927136 9.39897 0.683058C9.1549 0.438981 8.75917 0.438981 8.51509 0.683058L4.79036 4.40778L1.06564 0.683058Z"
                          fill="#9BA0B7"/>
                </svg>
            </div>

            <div data-id="bitrix" class="drop__list">
                <ol class="main__list">
                    <li class="main__list-li">
                        Укажите ссылку на вебхук Битрикс24 и нажмите Запросить информацию
                    </li>
                    <li class="main__list-li">
                        Указав данные в соответствующих полях, нажимаете Получить ключ аутентификации
                        <ul class="mark__change" style="padding: 15px 0 0 40px;">
                            <li>указанная ссылка не явояется вебхуком</li>
                            <li>в ссылке присутствует ошибка</li>
                            <li>указанное значение не является ссылкой</li>
                            <li>вебхук не имеет достаточно привелегий</li>
                            <li>вебхук не существует или был удален</li>
                        </ul>
                    </li>
                    <li class="main__list-li">Если вебхук корректный появляются поля лидов Битрикс24, список
                        источников и статусов лидов
                    </li>
                    <li class="main__list-li">В появившемся перечне выберите необходимое поле и кликните по нему
                    </li>
                    <li class="main__list-li">Укажите для данного параметра необходимое значение в тексовом виде или
                        виде специальных значений (приведены ниже)
                    </li>
                    <li class="main__list-li">Когда значение введено нажмите Добавить параметр</li>
                    <li class="main__list-li">При необходимости повторите пункты 4-6</li>
                    <li class="main__list-li">Когда все необходимые параметры добавлены, нажмите Сохранить
                        интеграцию
                    </li>
                </ol>
            </div>
        </div>
        <div id="hook" class="accortion__reference">
            <div class="header__reference">
                <div class="dot_head">
                    <div class="dot_int"></div>
                    <h4 class="title__reference">Интеграция с WebHook</h4>
                </div>
                <svg class="icon_reference" width="10" height="6" viewBox="0 0 10 6" fill="none"
                     xmlns="http://www.w3.org/2000/svg">
                    <path d="M1.06564 0.683058C0.821561 0.438981 0.425834 0.438981 0.181756 0.683058C-0.0623217 0.927136 -0.0623217 1.32286 0.181756 1.56694L4.34842 5.73361C4.5925 5.97769 4.98823 5.97769 5.23231 5.73361L9.39897 1.56694C9.64305 1.32286 9.64305 0.927136 9.39897 0.683058C9.1549 0.438981 8.75917 0.438981 8.51509 0.683058L4.79036 4.40778L1.06564 0.683058Z"
                          fill="#9BA0B7"/>
                </svg>
            </div>
            <div data-id="hook" class="drop__list">
                <ol class="main__list">
                    <li class="main__list-li">Укажите ссылку на внешний сервер, способный принимать внешние
                        POST-запросы
                    </li>
                    <li class="main__list-li">Нажмите Подтвердить. Далее появится уведомление о корректности
                        ссылки
                    </li>
                    <li class="main__list-li">Если вебхук корректный кнопка Сохранить интеграцию станет активной
                    </li>
                    <li class="main__list-li">Нажмите сохранить интеграцию</li>
                </ol>
            </div>
        </div>
        <div id="special" class="accortion__reference">
            <div class="header__reference">
                <div class="dot_head">
                    <div class="dot_int"></div>
                    <h4 class="title__reference">Специальные значения переменных</h4>
                </div>
                <svg class="icon_reference" width="10" height="6" viewBox="0 0 10 6" fill="none"
                     xmlns="http://www.w3.org/2000/svg">
                    <path d="M1.06564 0.683058C0.821561 0.438981 0.425834 0.438981 0.181756 0.683058C-0.0623217 0.927136 -0.0623217 1.32286 0.181756 1.56694L4.34842 5.73361C4.5925 5.97769 4.98823 5.97769 5.23231 5.73361L9.39897 1.56694C9.64305 1.32286 9.64305 0.927136 9.39897 0.683058C9.1549 0.438981 8.75917 0.438981 8.51509 0.683058L4.79036 4.40778L1.06564 0.683058Z"
                          fill="#9BA0B7"/>
                </svg>
            </div>
            <div data-id="special" class="drop__list">
                <ol class="main__list">
                    <li class="main__list-li">
                        Укажите следующие данные для получения ключа аутентификации:
                        <ul class="mark__change" style="padding: 15px 0 0 40px;">
                            <li>Код авторизации</li>
                            <li>ID интеграции</li>
                            <li>Секретный ключ</li>
                            <li>Ссылку на свою AmoCRM в формате company.amocrm.ru</li>
                        </ul>
                    </li>
                    <p class="red__li">Код авторизации годен 20 минут. Интеграция должан быть создана в течение 20
                        минут после ее создания в AmoCRM</p>
                    <li class="main__list-li">Указав данные в соответствующих полях, нажимаете Получить ключ
                        аутентификации
                    </li>
                    <p class="red__li">Полученный код авторизации можно использовать только 1 раз</p>
                    <li class="main__list-li">
                        Далее появится уведомление об ошибке или корректности ключа. Ключ может быть некорректен в
                        следующих случаях:
                        <ul class="mark__change" style="padding: 12px 0 12px 40px;">
                            <li>просроченный ключ</li>
                            <li>повторное использование кода авторизации</li>
                            <li>ошибка в подставляемых параметрах</li>
                            <li>перепутаны поля,в которые подставляют ключи</li>
                        </ul>
                    </li>
                    <li class="main__list-li">В случае корректности ключа появятся значения OAuth и вам доступна
                        настройка параметров интеграции
                    </li>
                    <li class="main__list-li">
                        Задайте значения обязательных полей:
                        <ul class="mark__change" style="padding: 12px 0 12px 40px;">
                            <li>Выберите ответственного за лид и контакт. Нажмите Добавить параметр</li>
                            <li>Выберите Воронку. Нажмите Добавить параметр</li>
                            <li>Выберите Статус сделки. Нажмите Добавить параметр</li>
                        </ul>
                    </li>
                    <li class="main__list-li">Выберите дополнительный параметры из каталога ниже</li>
                    <li class="main__list-li">Введите необходимое значение и нажмите Добавить параметр</li>
                    <li class="main__list-li">При необходимости повторите пункты 6-7</li>
                    <li class="main__list-li">Когда все необходимые параметры добавлены, нажмите Сохранить
                        интеграцию
                    </li>
                </ol>
            </div>
        </div>
    </div>
    </div>
    <div class="popup popup--auct-err">
        <div class="popup__ov">
            <div class="popup__body popup__body--w">
                <div class="popup__content popup__content--err">
                    <p class="popup__title rsp-ajax-title">
                        Ошибка
                    </p>
                    <p class="popup__text rsp-ajax-text">
                    </p>
                    <button class="popup__btn-lid btn">Продолжить</button>
                </div>
                <div class="popup__close">
                    <img src="<?= Url::to(['/img//close.png']) ?>" alt="close">
                </div>
            </div>
        </div>
    </div>
    <div class="popup popup--auct">
        <div class="popup__ov">
            <div class="popup__body popup__body--ok">
                <div class="popup__content popup__content--ok">
                    <p class="popup__title">Успешно</p>
                    <p class="popup__text rsp--ajax__text">
                        Данные корректные.
                    </p>
                    <button class="popup__btn-lid btn">Продолжить</button>
                </div>
                <div class="popup__close">
                    <img src="<?= Url::to(['/img//close.png']) ?>" alt="close">
                </div>
            </div>
        </div>
    </div>
</section>