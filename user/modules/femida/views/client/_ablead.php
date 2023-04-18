<?php

use common\models\LeadsSentReport;
use yii\helpers\Url;

?>

<div class="order-page_lead_popap">
    <img class="order-page_lead_popap-close" src="<?= Url::to(['/img/delete.png']) ?>" alt="Крестик">
    <div class="order-page_lead_popap_top">
        Карточка лида
    </div>
    <div class="order-page_lead_popap_main">
        <div class="order-page_lead_popap_main_row">
            <div class="order-page_lead_popap_main_row_left">
                <p>
                    ID
                </p>
            </div>
            <div class="order-page_lead_popap_main_row_right">
                <p>
                    <?= $popupdata->lead_id ?>
                </p>
            </div>
        </div>
        <div class="order-page_lead_popap_main_row">
            <div class="order-page_lead_popap_main_row_left">
                <p>
                    фио
                </p>
            </div>
            <div class="order-page_lead_popap_main_row_right">
                <p>
                    <?php if (!empty($popupdata->lead->name)): ?>
                        <?= $popupdata->lead->name ?>
                    <?php else: ?>
                        Без имени
                    <?php endif; ?>
                </p>
            </div>
        </div>
        <div class="order-page_lead_popap_main_row">
            <div class="order-page_lead_popap_main_row_left">
                <p>
                    Телефон
                </p>
            </div>
            <div class="order-page_lead_popap_main_row_right">
                <p>
                    <?php if (!empty($popupdata->lead->phone)): ?>
                        <?= $popupdata->lead->phone ?>
                    <?php else: ?>
                        Без телефона
                    <?php endif; ?>
                </p>
            </div>
        </div>
        <div class="order-page_lead_popap_main_row">
            <div class="order-page_lead_popap_main_row_left">
                <p>
                    почта
                </p>
            </div>
            <div class="order-page_lead_popap_main_row_right">
                <p>
                    <?= $popupdata->lead->email ?>
                                        <?php if (!empty($popupdata->lead->email)): ?>
                        <?= $popupdata->lead->email ?>
                    <?php else: ?>
                        Без почты
                    <?php endif; ?>
                </p>
            </div>
        </div>
        <div class="order-page_lead_popap_main_row">
            <div class="order-page_lead_popap_main_row_left">
                <p>
                    статус
                </p>
            </div>

            <?php
            switch ($popupdata->status) {
                case 'подтвержден':
                    $class = 'order-page_leads_name_status-submit';
                    $statusLead = 'Подтвержден';
                    break;
                case 'брак':
                    if ($popupdata->status_confirmed === 0) {
                        $class = 'order-page_leads_name_status-moderation';
                        $statusLead = 'Модерация';
                    } else {
                        $class = 'order-page_leads_name_status-brak';
                        $statusLead = 'Брак';
                    }
                    break;
                case 'отправлен':
                    $class = '';
                    $statusLead = 'Новый';
                    break;
            }
            ?>
            <div class="order-page_lead_popap_main_row_right">
                <p class="order-page_leads_name-4 <?= $class ?>"><?= $statusLead ?></p>
            </div>
        </div>
        <?php if (!empty($params)): ?>
            <?php foreach ($params as $v): ?>
           <?php if (!empty($popupdata->lead->params[$v['name']])): ?>
                    <div class="order-page_lead_popap_main_row">
                        <div class="order-page_lead_popap_main_row_left">
                            <p>
                                <?= $v['description'] ?>
                            </p>
                        </div>
                        <div class="order-page_lead_popap_main_row_right">
                            <p>
                                <?= $popupdata->lead->params[$v['name']] ?>
                            </p>
                        </div>
                    </div>
           <?php endif; ?>
            <?php endforeach; ?>
        <?php endif; ?>

        <div class="order-page_lead_popap_main_row">
            <div class="order-page_lead_popap_main_row_left">
                <p>
                    Регион, город
                </p>
            </div>
            <div class="order-page_lead_popap_main_row_right">
                <p>
                    <?php if (!empty($popupdata->lead->region) || !empty($popupdata->lead->city)): ?>
                    <?= $popupdata->lead->region ?>, город <?= $popupdata->lead->city ?>
                    <?php else: ?>
                        Город не указан
                    <?php endif; ?>
                </p>
            </div>
        </div>
        <div class="order-page_lead_popap_main_row">
            <div class="order-page_lead_popap_main_row_left">
                <p>
                    комментарий
                </p>
            </div>
            <div class="order-page_lead_popap_main_row_right">
                <p>
                    <?php if (!empty($popupdata->lead->comments)): ?>
                        <?= strip_tags($popupdata->lead->comments, '<br><b></b>') ?>
                    <?php else: ?>
                        Нет комментария
                    <?php endif; ?>

                </p>
            </div>
        </div>
        <div class="order-page_lead_popap_main_row">
            <div class="order-page_lead_popap_main_row_left">
                <p>
                    дата
                </p>
            </div>
            <div class="order-page_lead_popap_main_row_right">
                <p>
                    <?= date('d.m.Y H:i', strtotime($popupdata->date)) ?>
                </p>
            </div>
        </div>
<!--        <div class="order-page_lead_popap_main_row">-->
<!--            <div class="order-page_lead_popap_main_row_left">-->
<!--                <p>-->
<!--                    кастомное поле-->
<!--                </p>-->
<!--            </div>-->
<!--            <div class="order-page_lead_popap_main_row_right">-->
<!--                <p>-->
<!--                    Какая-то инфа-->
<!--                </p>-->
<!--            </div>-->
<!--        </div>-->
    </div>
    <div class="order-page_lead_popap_bottom">
        <?php if ($popupdata->status == 'отправлен' && !empty($popupdata->order_id)): ?>
        <button data-id="<?= $popupdata->lead->id ?>" data-pjax="0" class="order-page_leads_filter_BTN-submit confLead">
            Подтвердить
        </button>
        <button style="margin-top: 0;" data-id="<?= $popupdata->lead->id ?>" data-pjax="0" class="order-page_leads_filter_BTN-go-brak wasteLead">
            Отправить в брак
        </button>
        <?php endif; ?>
        <button class="order-page_leads_filter_BTN-close">
            Закрыть
        </button>
    </div>
</div>
<div class="PopapBack"></div>
<div class="PopapDBCWrap Popap-go-brak">
    <div class="PopapDBC Popap-go-brak1 Popap-go-brak1-1">
        <img class="PopapExidIcon uscp" src="<?= Url::to(['/img/delete.png']) ?>" alt="Крестик">
        <div class="PopapDBC-Cont df fdc aic">
            <h2 class="Popap-go-brak-ttl">Отправить в брак</h2>
            <div class="PopapDBC-Form df fdc">
                <p class="PopapDBC-t2 HText">Выберите причину отбраковки</p>
                <select class="PopapSelect leads__Waste__why" name="cause" id="">
                    <option value="<?= LeadsSentReport::REASON_DUPLICATE ?>"><?= LeadsSentReport::REASON_DUPLICATE ?></option>
                    <option value="<?= LeadsSentReport::REASON_NOT_LEAD ?>"><?= LeadsSentReport::REASON_NOT_LEAD ?></option>
                    <option value="<?= LeadsSentReport::REASON_WRONG_PHONE ?>"><?= LeadsSentReport::REASON_WRONG_PHONE ?></option>
                    <option value="<?= LeadsSentReport::REASON_WRONG_REGION ?>"><?= LeadsSentReport::REASON_WRONG_REGION ?></option>
                </select>
                <button class="Popap-order-BTN PopapDBC_Form-BTN BText df  jcc aic uscp" type="submit">Продолжить
                </button>
                <button class="PopapDBC_Form-Reset BText df jcc aic uscp" type="reset">Отмена</button>
            </div>
        </div>
    </div>
    <div class="PopapDCD2 Popap-go-brak2">
        <img class="PopapExidIcon uscp" src="<?= Url::to(['/img/delete.png']) ?>" alt="Крестик">
        <div class="PopapDBC-Cont df fdc aic">
            <img class="PopapDCD2img" src="<?= Url::to(['/img/success.svg']) ?>" alt="Галочка">
            <h2 class="PopapDCD2-ttl">Успешно!</h2>
            <h3 class="PopapDCD2-subttl">Отправлено в брак, ожидайте подтверждения от модератора</h3>
            <p class="PopapDCD2_Form-BTN BText df jcc aic uscp">Продолжить</p>
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
                <button class="popup__btn-close btn">Закрыть</button>
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
                <p class="popup__title">Успех!</p>
                <p class="popup__text"></p>
            </div>
            <div class="popup__close">
                <img src="<?= Url::to(['/img//close.png']) ?>" alt="close">
            </div>
        </div>
    </div>
</div>