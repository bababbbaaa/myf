<?php

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = $project['name'];
$id = $project['id'];
$js = <<< JS

$('.activeproject_tabs--btn').on('click', function(){
    if(!$(this).hasClass('active') && $(this).hasClass('activeproject_tabs--btn-1')){
        $('.activeproject_tabs--btn, .activeproject_tab').removeClass('active');
        $(this).addClass('active');
        $('.activeproject_tab-1').addClass('active');
    }else if(!$(this).hasClass('active') && $(this).hasClass('activeproject_tabs--btn-2')){
        $('.activeproject_tabs--btn, .activeproject_tab').removeClass('active');
        $(this).addClass('active');
        $('.activeproject_tab-2').addClass('active');
    }
});

$('.notif_pay-close').on('click', function(){
    $(this).parent().remove();
});

$('.allPay').on('click', function(e) {
    e.preventDefault();
    var btn = $(this);
  $.ajax({
    url: '/dev/main/all-summ-pay',
    data: {summ:btn.attr('data-summ'), id:'$id'},
    dataType: 'JSON',
    type: 'POST',
    beforeSend: function() {
      btn.prop('disabled', true);
    }
  }).done(function(r) {
    if (r.status === 'error'){
        Swal.fire({
            icon: 'error',
            title: 'Ошибка!',
            text: r.message,
            showCancelButton: true,
            confirmButtonText: 'Принять',
            cancelButtonText: 'Отмена',
        }).then((result) => {
            if (result.value === true) {
                location.href = '/dev/main/balance';
            }
        });
    } else {
        Swal.fire({
           icon: 'success',
           title: 'Оплачено!',
           text: r.message, 
           confirmButtonText: 'Принять',
        }).then(() => {
            location.reload();
        });
    }
    
  });
});

$('.onePay').on('click', function() {
  var btn = $(this);
  $.ajax({
    url: '/dev/main/one-pay',
    data: {summ:btn.attr('data-summ'), id:'$id', pay_id:btn.attr('data-pay') },
    dataType: 'JSON',
    type: 'POST',
    beforeSend: function() {
      btn.prop('disabled', true);
    }
  }).done(function(r) {
    if (r.status === 'error'){
        Swal.fire({
            icon: 'error',
            title: 'Ошибка!',
            text: r.message,
            showCancelButton: true,
            confirmButtonText: 'Принять',
            cancelButtonText: 'Отмена',
        }).then((result) => {
            if (result.value === true) {
                location.href = '/dev/main/balance';
            }
        });
    } else {
        Swal.fire({
           icon: 'success',
           title: 'Оплачено!',
           text: r.message, 
           confirmButtonText: 'Принять',
        }).then(() => {
            location.reload();
        });
    }
  });
});
JS;
$this->registerJs($js);

?>

<section class="rightInfo">
    <div class="bcr">
        <ul class="bcr__list">
            <li class="bcr__item">
                <a class="bcr__link" href="<?= Url::to(['myprojects']) ?>">Мои проекты</a>
            </li>
            <li class="bcr__item">
                <a class="bcr__link" href="<?= Url::to(['myprojects']) ?>">Активные</a>
            </li>
            <li class="bcr__item">
                <span class="bcr__span">
                    Мои проекты
                </span>
            </li>
        </ul>
    </div>

    <div class="title_row activeproject-t-row">
        <div class="activeproject-t-row_left">
            <p class="activeproject-t-row_left-text"><?= $project['type'] ?></p>
            <h1 class="Bal-ttl title-main"><?= $project['name'] ?></h1>
        </div>
        <!-- Тут и везде где просто разные цвета, смотри на класс - green, red, blue и т.д., смотри стили и прописывай условия на добавление класса -->
        <?php switch ($project['status']) {
            case 'В работе':
                $color = 'green';
                break;
            case 'Остановлен':
                $color = 'red';
                break;
            case 'Выполнен':
                $color = 'blue';
                break;
            case 'Модерация':
                $color = 'orange';
                break;
        } ?>
        <div class="activeproject-status <?= $color ?> courses_item_top-name">
            <p class="tooltip">Это статус проекта</p>
            <div class="activeproject-status-point"></div>
            <span><?= $project['status'] ?></span>
        </div>
    </div>

    <article class="activeproject">
        <?php if ($project['status'] === 'Остановлен') : ?>
            <section class="notif_pay">
                <button class="notif_pay-close">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M12.2855 11.2249L16.2907 7.21967C16.5836 6.92678 17.0585 6.92678 17.3514 7.21967C17.6443 7.51256 17.6443 7.98744 17.3514 8.28033L13.3462 12.2855L17.3514 16.2907C17.6443 16.5836 17.6443 17.0585 17.3514 17.3514C17.0585 17.6443 16.5836 17.6443 16.2907 17.3514L12.2855 13.3462L8.28033 17.3514C7.98744 17.6443 7.51256 17.6443 7.21967 17.3514C6.92678 17.0585 6.92678 16.5836 7.21967 16.2907L11.2249 12.2855L7.21967 8.28033C6.92678 7.98744 6.92678 7.51256 7.21967 7.21967C7.51256 6.92678 7.98744 6.92678 8.28033 7.21967L12.2855 11.2249Z" fill="#9BA0B7" />
                    </svg>
                </button>

                <h3 class="notif_pay-title">Проект приостановлен
                    <div>
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect width="24" height="24" rx="4" fill="#FEE5B5" />
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M12 5.125C11.6548 5.125 11.375 5.40482 11.375 5.75C11.375 6.09518 11.6548 6.375 12 6.375C12.3452 6.375 12.625 6.09518 12.625 5.75C12.625 5.40482 12.3452 5.125 12 5.125ZM10.125 5.75C10.125 4.71447 10.9645 3.875 12 3.875C13.0356 3.875 13.875 4.71447 13.875 5.75C13.875 6.09114 13.7839 6.41099 13.6247 6.68657C15.2365 7.33152 16.375 8.90755 16.375 10.7497V13.875C16.375 14.3121 16.6033 14.8094 16.895 15.2471C17.0341 15.4557 17.1742 15.6308 17.2792 15.7534C17.3315 15.8144 17.3744 15.8615 17.4032 15.8924C17.4176 15.9078 17.4284 15.9191 17.4351 15.926L17.4419 15.933C17.6205 16.1117 17.6741 16.3807 17.5774 16.6142C17.4807 16.8477 17.2528 17 17 17H14.3907C14.4584 17.1947 14.5 17.4043 14.5 17.625C14.5 19.0057 13.3807 20.125 12 20.125C10.6193 20.125 9.50002 19.0057 9.50002 17.625C9.50002 17.4043 9.54163 17.1947 9.60939 17H7.00002C6.74723 17 6.51933 16.8477 6.42259 16.6142C6.326 16.381 6.37917 16.1126 6.55727 15.9339L6.55779 15.9333L6.56493 15.926C6.5716 15.9191 6.58243 15.9078 6.59682 15.8924C6.62564 15.8615 6.66853 15.8144 6.7208 15.7534C6.82588 15.6308 6.96589 15.4557 7.10499 15.2471C7.39673 14.8094 7.62502 14.3121 7.62502 13.875V10.7497C7.62502 8.90755 8.76357 7.33152 10.3753 6.68657C10.2161 6.41099 10.125 6.09114 10.125 5.75ZM11.0281 17C10.8525 17.2208 10.75 17.4461 10.75 17.625C10.75 18.3154 11.3097 18.875 12 18.875C12.6904 18.875 13.25 18.3154 13.25 17.625C13.25 17.4461 13.1476 17.2208 12.972 17H11.0281ZM15.125 13.875C15.125 14.5904 15.4323 15.2591 15.7331 15.75H8.2669C8.56776 15.2591 8.87502 14.5904 8.87502 13.875V10.7497C8.87502 9.0239 10.2741 7.625 12 7.625C13.726 7.625 15.125 9.0239 15.125 10.7497V13.875Z" fill="#FFA800" />
                        </svg>
                    </div>
                </h3>
                <p class="notif_pay-text">Внесите платеж и работа по проекту будет возобновлена</p>
                <a style="max-width: fit-content;" href="<?= Url::to(['balance']) ?>" class="btn--purple">Перейти к
                    оплате</a>
            </section>
        <?php endif; ?>


        <section class="myprojects_main-item">
            <div class="myprojects_main-item_left">
                <h2 class="activeproject_about-title">О проекте</h2>
                <div class="activeproject_about-text"><?= $project['about_project'] ?></div>
                <?php if (!empty($project['tz_link'])) : ?>
                    <a target="_blank" href="<?= Url::to($project['tz_link']) ?>" class="link--blue">Смотреть ТЗ</a>
                <?php endif; ?>
            </div>

            <div class="myprojects_main-item_right">
                <?php if (!empty($project['date_end'])) : ?>
                    <p class="myprojects_main-item_right-text">Предварительная дата завершения</p>
                    <p class="myprojects_main-item_right-date"><?= date('d.m.Y', strtotime($project['date_end'])) ?></p>
                <?php endif; ?>
                <?php switch ($project['type']) {
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
                <img style="max-width: <?= !empty($project['date_end']) ? '168px' : '' ?>" src="<?= $image ?>" alt="icon">
            </div>
        </section>
        <div class="activeproject_wrap">
            <section class="activeproject_card activeproject_wrap_left">
                <h2 class="activeproject_about-title"><?= $stage['title'] ?></h2>
                <p class="activeproject_card-t">Текущий этап</p>
                <p class="activeproject_about-text"><?= $stage['subtitle'] ?></p>
            </section>

            <section class="activeproject_card activeproject_wrap_right">
                <h2 class="activeproject_about-title">Оплата</h2>
                <?php if ($project['status'] !== 'Модерация') : ?>
                    <?php if (empty($summ)) : ?>
                        <p class="activeproject_about-text">Оплата внесена в полном размере</p>
                    <?php else : ?>
                        <div class="activeproject_wrap_right-row">
                            <div class="activeproject_wrap_right-row_left">
                                <p class="activeproject_wrap_right-row_left-date"><?= date('d.m.Y', strtotime($summ[0]['when_pay'])) ?></p>
                                <p class="activeproject_wrap_right-row_left-text">Дата следующей оплаты</p>
                            </div>
                            <p class="activeproject_wrap_right-row_left-price"><?= number_format($summ[0]['summ'], 0, ' ', ' ') ?>₽</p>
                        </div>
                        <button data-summ="<?= $summ[0]['summ'] ?>" data-pay="<?= $summ[0]['id'] ?>" class="btn--purple onePay">Оплатить</button>
                    <?php endif; ?>
                <?php else : ?>
                    <p class="activeproject_about-text">Заказ на модерации</p>
                <?php endif; ?>
            </section>
        </div>

        <div class="activeproject_tabs">
            <div class="activeproject_tabs_btns">
                <button class="activeproject_tabs--btn activeproject_tabs--btn-1 active">Все этапы проекта</button>
                <button class="activeproject_tabs--btn activeproject_tabs--btn-2">График платежей</button>
            </div>

            <section class="activeproject_tab activeproject_tab-1 active">
                <div class="activeproject_tab_top">
                    <p class="activeproject_tab_top-text activeproject_tab_top-text-wd">Номер</p>
                    <p class="activeproject_tab_top-text activeproject_tab_top-text-wd">Этап</p>
                    <p class="activeproject_tab_top-text activeproject_tab_top-text-wd">статус</p>
                    <p class="activeproject_tab_top-text activeproject_tab_top-text-wd">дата завершения</p>
                </div>
                <?php $arr = [];
                foreach ($stageDone as $v)
                    $arr[] = $v['stage_id']
                ?>
                <ul class="activeproject_tab_main">
                    <?php if (!empty($stages)) : ?>
                        <?php foreach ($stages as $k => $v) : ?>
                            <li class="activeproject_tab_main-row">
                                <p class="activeproject_tab_top-text-wd activeproject_tab_main-row-t1"><?= $k + 1 ?></p>
                                <div class="activeproject_tab_top-text-wd activeproject_tab_main-row-item">
                                    <p class="activeproject_tab_main-row-item-title"><?= $v['title'] ?></p>
                                    <p class="activeproject_tab_main-row-item-text"><?= $v['subtitle'] ?></p>
                                </div>
                                <?php if (in_array($v['id'], $arr)) : ?>
                                    <p class="activeproject_tab_top-text-wd activeproject_tab_main-row-t3 green">
                                        Завершен</p>
                                    <p class="activeproject_tab_top-text-wd activeproject_tab_main-row-t4"><?= date('d.m.Y', strtotime($stageDone[$k]['date'])) ?></p>
                                <?php elseif ($v['id'] == count($arr) + 1) : ?>
                                    <p class="activeproject_tab_top-text-wd activeproject_tab_main-row-t3 yellow">
                                        Текущий</p>
                                    <p class="activeproject_tab_top-text-wd activeproject_tab_main-row-t4"></p>
                                <?php else : ?>
                                    <p class="activeproject_tab_top-text-wd activeproject_tab_main-row-t3 blue">
                                        Будущий</p>
                                    <p class="activeproject_tab_top-text-wd activeproject_tab_main-row-t4"></p>
                                <?php endif; ?>
                            </li>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </ul>
            </section>
            <section class="activeproject_tab activeproject_tab-2">
                <div class="activeproject_tab_top">
                    <p class="activeproject_tab_top-text activeproject_tab_top-text-wd">Номер</p>
                    <p class="activeproject_tab_top-text activeproject_tab_top-text-wd">Сумма платежа</p>
                    <p class="activeproject_tab_top-text activeproject_tab_top-text-wd">дата оплаты</p>
                    <p class="activeproject_tab_top-text activeproject_tab_top-text-wd">статус</p>
                </div>
                <?php if (!empty($payments)) : ?>
                    <ul class="activeproject_tab-2_main">
                        <?php foreach ($payments as $k => $v) : ?>
                            <li class="activeproject_tab-2_main-item">
                                <p class="activeproject_tab-2_main-item-t1 activeproject_tab_top-text-wd"><?= $k + 1 ?></p>
                                <p class="activeproject_tab-2_main-item-t2 activeproject_tab_top-text-wd"><?= number_format($v['summ'], 0, ' ', ' ') ?>₽</p>
                                <p class="activeproject_tab-2_main-item-t3 activeproject_tab_top-text-wd"><?= date('d.m.Y', strtotime($v['when_pay'])) ?></p>
                                <p class="activeproject_tab-2_main-item-t4 <?= $v['status'] === 'Оплачено' ? 'green' : '' ?> activeproject_tab_top-text-wd"><?= $v['status'] ?></p>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>

                <div class="activeproject_tab-2_bottom">
                    <?php if (!empty($summ)) : ?>
                        <button type="button" data-summ="<?= $last__summ ?>" class="btn--purple allPay">Оплатить весь остаток</button>
                    <?php endif; ?>
                    <p style="margin-left: auto" class="activeproject_tab-2_bottom-text">Полная стоимость услуги: <span><?= number_format($project['summ'], 0, ' ', ' ') ?>₽</span></p>
                </div>
            </section>
        </div>
    </article>
</section>