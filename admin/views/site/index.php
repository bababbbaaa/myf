<?php

/* @var $this yii\web\View */

use common\behaviors\JsonQuery;
use common\models\DbPhones;
use common\models\Orders;
use yii\db\Expression;
use yii\helpers\Url;

$this->title = 'MYFORCE Панель';

$js =<<<JS
$('.save-name').on('click', function() {
    var val = $('[name="saveNameCC"]').val();
    $.ajax({
        data: {val: val},
        type: "POST",
        dataType: "JSON",
        url: "/site/save-name"
    }).done(function(rsp) {
        if (rsp.status === 'success')
            location.reload();
        else {
            Swal.fire({
              icon: 'error',
              title: 'Ошибка',
              text: rsp.message,
            });
        }
    });
});
JS;

$this->registerJs($js);
?>
<style>
    .glob-flex {
        display: flex; flex-wrap: wrap
    }
    .glob-flex > div {
        margin-bottom: 10px;
        margin-right: 10px;
        padding: 10px;
        background-color: #fafafa;
        border: 1px solid gainsboro;
        box-shadow: 2px 2px 7px #ededed;
    }
    .sm-flex {
        display: flex;
    }
    .sm-flex > div {
        font-size: 11px;
        padding: 5px 10px;
    }
    .sm-flex > div:last-child {
        margin-left: auto;
        width: 100%;
        text-align: right;
    }
</style>
<div class="monospace" style="max-width: 1000px; margin-top: 10px">
    <div class="admin-h1">MY.FORCE основной раздел</div>
    <p>Сейчас <?= date("d.m.Y H:i") ?></p>
    <p>Вы авторизованы как <b style="color: #d9534f"><?= $myRole ?></b></p>
    <hr>
    <?php if(!empty($statistics)): ?>
    <h3 style="margin-bottom: 22px;">Общая информация</h3>
        <div class="glob-flex">
            <?php if(!empty($statistics['lastUsers'])): ?>
                <div>
                    <div style="margin-bottom: 5px; margin-left: 5px"><b style="">Последние зарегистрированные</b></div>
                    <?php foreach($statistics['lastUsers'] as $item): ?>
                        <div class="sm-flex">
                            <div>
                                <a href="<?= Url::to(['users/view', 'id' => $item['id']]) ?>">#<?= $item['id'] ?></a>
                            </div>
                            <div>
                                <b><?= $item['username'] ?></b>
                            </div>
                            <div>
                                <b><?= $item['email'] ?></b>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
            <?php if(!empty($statistics['lastOrders'])): ?>
                <div>
                    <div style="margin-bottom: 5px; margin-left: 5px"><b style="">Последние заказы</b></div>
                    <?php foreach($statistics['lastOrders'] as $item): ?>
                        <div class="sm-flex">
                            <div>
                                <a href="<?= \yii\helpers\Url::to(['/lead-force/orders/view', 'id' => $item['id']]) ?>" target="_blank">#<?= $item['id'] ?></a>
                            </div>
                            <div>
                                <b><?= !empty($item['order_name']) ? $item['order_name'] : "#{$item['id']} {$item['category_text']}" ?></b>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
            <?php if(!empty($statistics['leadsToSent']) || !empty($statistics['ordersToModerate']) || !empty($statistics['ordersStopped']) || !empty($statistics['ordersPaused'])): ?>
                <div>
                    <?php if(!empty($statistics['leadsToSent'])): ?>
                        <div style="margin-bottom: 5px; margin-left: 5px"><b style=""><a href="<?= \yii\helpers\Url::to(['/lead-force/leads/index']) ?>">Лидов</a> не отправлено: <span style="color: #d9534f"><?= $statistics['leadsToSent'] ?></span></b></div>
                    <?php endif; ?>
                    <?php if(!empty($statistics['ordersToModerate'])): ?>
                        <div style="margin-bottom: 5px; margin-left: 5px"><b style=""><a href="<?= \yii\helpers\Url::to(['/lead-force/orders/index']) ?>">Заказов</a> на модерации: <span style="color: #d9534f"><?= $statistics['ordersToModerate'] ?></span></b></div>
                    <?php endif; ?>
                    <?php if(!empty($statistics['ordersActive'])): ?>
                        <div style="margin-bottom: 5px; margin-left: 5px"><b style=""><a href="<?= \yii\helpers\Url::to(['/lead-force/orders/index']) ?>">Заказов</a> исполняется: <span style="color: #d9534f"><?= $statistics['ordersActive'] ?></span></b></div>
                    <?php endif; ?>
                    <?php if(!empty($statistics['ordersStopped'])): ?>
                        <div style="margin-bottom: 5px; margin-left: 5px"><b style=""><a href="<?= \yii\helpers\Url::to(['/lead-force/orders/index']) ?>">Заказов</a> остановлено: <span style="color: #d9534f"><?= $statistics['ordersStopped'] ?></span></b></div>
                    <?php endif; ?>
                    <?php if(!empty($statistics['ordersPaused'])): ?>
                        <div style="margin-bottom: 5px; margin-left: 5px"><b style=""><a href="<?= \yii\helpers\Url::to(['/lead-force/orders/index']) ?>">Заказов</a> на паузе: <span style="color: #d9534f"><?= $statistics['ordersPaused'] ?></span></b></div>
                    <?php endif; ?>
                    <?php if(!empty($statistics['ordersDone'])): ?>
                        <div style="margin-bottom: 5px; margin-left: 5px"><b style=""><a href="<?= \yii\helpers\Url::to(['/lead-force/orders/index']) ?>">Заказов</a> выполнено всего: <span style="color: #d9534f"><?= $statistics['ordersDone'] ?></span></b></div>
                    <?php endif; ?>
                    <?php if(!empty($statistics['ordersDoneThisMonth'])): ?>
                        <div style="margin-bottom: 5px; margin-left: 5px"><b style=""><a href="<?= \yii\helpers\Url::to(['/lead-force/orders/index']) ?>">Заказов</a> выполнено за месяц: <span style="color: #d9534f"><?= $statistics['ordersDoneThisMonth'] ?></span></b></div>
                    <?php endif; ?>
                    <?php if(!empty($statistics['openedTickets'])): ?>
                        <div style="margin-bottom: 5px; margin-left: 5px"><b style="">Открыто <a href="<?= \yii\helpers\Url::to(['/support/dialogues/index']) ?>">диалогов</a>: <span style="color: #d9534f"><?= $statistics['openedTickets'] ?></span></b></div>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
    <?php endif; ?>
    <?php if(!empty($cc)): ?>
        <h3 style="margin-bottom: 22px;">Информация КЦ</h3>
        <div class="glob-flex">
            <?php if(isset($cc['waiting'])): ?>
                <div>
                    <div style="margin-bottom: 5px; margin-left: 5px"><b style="">Лидов КЦ ожидает обработки: <span style="color: #d9534f"><?= $cc['waiting'] ?></span></b></div>
                </div>
            <?php endif; ?>

            <?php if(isset($cc['waitForOperator'])): ?>
                <div>
                    <div style="margin-bottom: 5px; margin-left: 5px"><b style="">Лидов в КЦ без оператора: <span style="color: #d9534f"><?= $cc['waitForOperator'] ?></span></b></div>
                </div>
            <?php endif; ?>

            <?php if(isset($cc['dailyGet'])): ?>
                <div>
                    <div style="margin-bottom: 5px; margin-left: 5px"><b style="">Сегодня пришло лидов в КЦ: <span style="color: #d9534f"><?= $cc['dailyGet'] ?></span></b></div>
                </div>
            <?php endif; ?>
        </div>
    <?php endif; ?>
    <?php if(!empty($renderInput) && $renderInput): ?>
        <?php if(empty($model['inner_name'])): ?>
            <div style="max-width: 500px">
                <h3>Настройки оператора КЦ</h3>
                <p><b>Укажите ваше имя</b></p>
                <p><input name="saveNameCC" <?= empty($model['inner_name']) ? '' : 'disabled'?> value="<?= $model['inner_name'] ?>" type="text" class="form-control" placeholder="Иван"></p>
                <?php if(empty($model['inner_name'])): ?>
                    <p><button class="btn btn-admin save-name">Сохранить</button></p>
                <?php endif; ?>
            </div>
        <?php else: ?>
            <?php
                $time = (int)date("H");
                if ($time > 5 && $time < 12)
                    $text = "Доброе утро, {$model['inner_name']}";
                else if($time >= 12 && $time < 18)
                    $text = "Добрый день, {$model['inner_name']}";
                else
                    $text = "Добрый вечер, {$model['inner_name']}";
            ?>
            <h3><?= $text ?></h3>
            <?php

                $getMyLeads = \common\models\CcLeads::find()->where(['AND', ['assigned_to' => $model['id']], ['is', 'status', NULL]])->count();

            ?>
            <?php if(!empty($getMyLeads)): ?>
                <p style="color: #d9534f">У вас <?= $getMyLeads ?> лидов ожидают указания финального статуса</p>
            <?php else: ?>
                <p style="color: #d9534f">Лиды без финального статуса не найдены</p>
            <?php endif; ?>
            <div><b>Не забывайте начинать свой рабочий день и заканчивать, используя кнопку в разделе лидов.</b></div>
        <?php endif; ?>
    <?php endif; ?>
    <?php if($user->can('mainPageModeration')): ?>
        <h3 style="margin-bottom: 15px;">Общие настройки и справка</h3>
        <div class="rbac-flex-row">
            <div class="open-rbac-page" data-url="<?= Url::to(['users/index']) ?>">
                <div>
                    <div style="margin-bottom: 5px">
                        <span style="font-weight: 600;">Пользователи</span>
                    </div>
                    <hr class="ap-hr">
                    <div class="small-text-ap">
                        Информация о зарегистрированных пользователях и настройки пользователей
                    </div>
                </div>
            </div>
            <div class="open-rbac-page" data-url="<?= Url::to(['au-user/index']) ?>">
                <div>
                    <div style="margin-bottom: 5px">
                        <span style="font-weight: 600;">Учетные записи АУ</span>
                    </div>
                    <hr class="ap-hr">
                    <div class="small-text-ap">
                        Информация о зарегистрированных пользователях АУ
                    </div>
                </div>
            </div>
        </div>
        <div>
            <h4>Текущий ключ для бота M3</h4>
            <code><?= \admin\models\CookieValidator::findOne(3)->hash ?></code>
        </div>
    <?php endif; ?>
    <h3>Основные разделы навигации</h3>
    <?php $bottomMenu = \common\models\RenderProcessor::getSidebarInfo(); ?>
    <ul style="list-style: none; padding-left: 5px; font-size: 18px;">
        <?php foreach($bottomMenu as $link => $item): ?>
            <?php if(\common\models\RenderProcessor::check__if__can($item, $user)): ?>
                <li><span style="font-size: 12px;" class="glyphicon glyphicon-<?= $item['glyph'] ?>" aria-hidden="true"></span> <a href="<?= Url::to([$link]) ?>"><?= $item['title'] ?></a></li>
            <?php endif; ?>
        <?php endforeach; ?>
    </ul>
</div>
