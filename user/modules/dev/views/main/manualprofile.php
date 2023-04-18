<?php

use yii\helpers\Url;

$this->title = 'Руководство по профилю';
?>
<section class="rightInfo">
    <div class="bcr">
        <ul class="bcr__list">
            <li class="bcr__item">
                <a href="<?= Url::to(['index']) ?>" class="bcr__link">
                    Главная
                </a>
            </li>
            <li class="bcr__item">
                <a href="<?= Url::to(['manual']) ?>" class="bcr__link">
                    Руководство пользователя
                </a>
            </li>
            <li class="bcr__item">
                <span class="bcr__span">
                    Профиль
                </span>
            </li>
        </ul>
    </div>
    <h1 class="usermanual_title title-main">Профиль</h1>
    <section class="usermanualmain_info">
        <div class="usermanualmain_info_row">
            <img src="<?= Url::to(['/img/dev/profile-1.png']) ?>" alt="скриншот страницы">
            <div class="usermanualmain_info_row_right">
                <h2 class="usermanualmain_info_row_right-title">
                    Общий вид
                </h2>
                <p class="usermanualmain_info_row_right-text">
                    Перед тем, как пополнять баланс личного кабинета, необходимо заполнить свой профиль.
                </p>
                <p class="usermanualmain_info_row_right-text">
                    В профиле вы можете заполнить личные данные, информацию об оплате услуг кабинета, сменить пароль и настроить уведомления, которые мы вам присылаем.
                </p>
                <p class="usermanualmain_info_row_right-text">
                    Мы подготовили видео-инструкцию, чтобы вам было легче заполнить
                </p>
                <a class="link-video link--purple" href="#?<?= $_SERVER['#'] ?>">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M12 21C16.9706 21 21 16.9706 21 12C21 7.02944 16.9706 3 12 3C7.02944 3 3 7.02944 3 12C3 16.9706 7.02944 21 12 21ZM12 19.6154C7.79414 19.6154 4.38462 16.2059 4.38462 12C4.38462 7.79414 7.79414 4.38462 12 4.38462C16.2059 4.38462 19.6154 7.79414 19.6154 12C19.6154 16.2059 16.2059 19.6154 12 19.6154ZM11.1694 9.29409C10.5031 8.9324 9.69231 9.4148 9.69231 10.173V13.827C9.69231 14.5852 10.503 15.0676 11.1694 14.7059L14.5352 12.8789C15.2324 12.5004 15.2324 11.4996 14.5352 11.1211L11.1694 9.29409Z" fill="#1983FF"/></svg>
                    <p style="margin-left: 4px;">Смотреть видео</p>
                </a>
            </div>
        </div>
        <div class="usermanualmain_info_column-wrapp">
            <h2 class="usermanualmain_info_column-wrapp-title">
                Заполнение профиля
            </h2>
            <div class="usermanualmain_info_column">
                <h3 class="usermanualmain_info_column-title">
                    1. Ваши данные
                </h3>
                <p class="usermanualmain_info_column-text">
                    В пункте «Контактные данные» показаны ваши контакты с регистрации, если они поменялись — можете их сменить. Не забудьте добавить почту, на нее будут присылаться акты выполненных работ и оповещения о начале и окончании отгрузки лидов.
                </p>
                <img src="<?= Url::to(['/img/dev/profile-2.png']) ?>" alt="скриншот страницы">
            </div>
            <div class="usermanualmain_info_column">
                <p class="usermanualmain_info_column-text">
                    Далее вам нужно выбрать в качестве какого лица вы регистрируетесь в личном кабинете — физического или юридического, и заполнить все поля. Данный выбор не влияет на способ оплаты услуг.
                </p>
                <img src="<?= Url::to(['/img/dev/profile-3.png']) ?>" alt="скриншот страницы">
            </div>
            <div class="usermanualmain_info_column">
                <p class="usermanualmain_info_column-text">
                    Не забудьте сохранить изменения!
                </p>
                <img src="<?= Url::to(['/img/dev/profile-4.png']) ?>" alt="скриншот страницы">
            </div>
            <div class="usermanualmain_info_column">
                <h3 class="usermanualmain_info_column-title">
                    2. Информация для оплаты
                </h3>
                <p class="usermanualmain_info_column-text">
                    В этом пункте вы можете выбрать, как хотите оплачивать услуги — как юридическое лицо или как физическое, либо обоими способами сразу.
                    <br>
                    Выберите вид плательщика, заполните поля и сохраните данные.
                </p>
                <img src="<?= Url::to(['/img/dev/profile-5.png']) ?>" alt="скриншот страницы">
            </div>
            <div class="usermanualmain_info_column">
                <p class="usermanualmain_info_column-text">
                    Когда вы создадите первого плательщика (например, как на фото ниже — физическое лицо), у вас есть возможность создать второго плательщика — юридическое лицо. При оплате услуг у вас будет выбор, каким способом оплачивать.
                </p>
                <img src="<?= Url::to(['/img/dev/profile-6.png']) ?>" alt="скриншот страницы">
            </div>
            <div class="usermanualmain_info_column">
                <h3 class="usermanualmain_info_column-title">
                    3. Сменить пароль
                </h3>
                <p class="usermanualmain_info_column-text">
                    Вы можете изменить пароль личного кабинета. Не забудьте сохранить данные!
                </p>
                <img src="<?= Url::to(['/img/dev/profile-7.png']) ?>" alt="скриншот страницы">
            </div>
            <div class="usermanualmain_info_column">
                <h3 class="usermanualmain_info_column-title">
                    4. Уведомления
                </h3>
                <p class="usermanualmain_info_column-text">
                    Вы можете поменять настройки уведомлений, которые приходят на почту и в личном кабинете
                </p>
                <img src="<?= Url::to(['/img/dev/profile-8.png']) ?>" alt="скриншот страницы">
            </div>
        </div>
    </section>
    <section class="usermanualmain_other-sections">
        <h2 class="usermanualmain_other-sections-title">
            Другие разделы
        </h2>
        <a class="usermanualmain_other-sections-link link--purple" href="<?= Url::to(['manualmain']) ?>">
            Главная страница
        </a>
        <a class="usermanualmain_other-sections-link link--purple" href="<?= Url::to(['manualbalance']) ?>">
            Баланс
        </a>
        <a class="usermanualmain_other-sections-link link--purple" href="<?= Url::to(['manualproject']) ?>">
            Мои проекты
        </a>
        <a class="usermanualmain_other-sections-link link--purple" href="<?= Url::to(['manualstart']) ?>">
            Начать проект
        </a>
    </section>
    <aside class="usermanualmain_chat">
        <div class="usermanualmain_chat-text">
            <h3 class="usermanual_chat_title">
                Не нашли ответ?
            </h3>
            <p class="usermanual_chat_text">
                Задайте свой вопрос в чате тех.поддержки, мы поможем
            </p>
            <a class="usermanual_chat_link link--purple" href="<?= $_SERVER['backing'] ?>">
                Перейти в чат
            </a>
        </div>
        <img style="max-width: 134px;" src="<?= Url::to(['/img/dev/manual-aside.png']) ?>" alt="фоновая картинка">
    </aside>
</section>