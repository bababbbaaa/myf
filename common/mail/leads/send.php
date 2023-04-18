<?php
/** @var $this \yii\web\View */
/** @var $lead \common\models\Leads */
/** @var $special__params \common\models\LeadsParams */
?>

<div style="max-width: 1024px; width:auto; margin: 0 auto; padding: 20px; background: linear-gradient(
143deg
, #3cfa7d, #0e7030);
    font-family: system-ui, Arial, serif;     box-shadow: 3px 3px 10px #d0d0d0;">
    <div style="background-color: white; padding: 20px;     box-shadow: inset 3px 3px 9px #d0d0d0;">
        <div style="text-align: center;">
            <b style="font-size: 40px;"><span style="color: #24b054">Lead</span>.Force</b>
        </div>
        <div style="text-align: center; margin: 10px auto 20px; font-size: 20px;">
            <b>Поступил новый лид</b>
        </div>
        <table class="bordered">
            <tr class="first_tr">
                <th>ID</th>
                <td><?= $lead->id ?></td>
            </tr>
            <tr>
                <th>Имя</th>
                <td><?= $lead->name ?></td>
            </tr>
            <tr>
                <th>Email</th>
                <td><?= $lead->email ?></td>
            </tr>
            <tr>
                <th>Телефон</th>
                <td><?= $lead->phone ?></td>
            </tr>
            <tr>
                <th>Регион</th>
                <td><?= $lead->region ?></td>
            </tr>
            <tr>
                <th>Город</th>
                <td><?= $lead->city ?></td>
            </tr>
            <?php if(empty($order_params['delete_comment'])): ?>
                <tr>
                    <th>Комментарий</th>
                    <td><?= $lead->comments ?></td>
                </tr>
            <?php endif; ?>
            <tr>
                <th>Дата</th>
                <td><?= date("d.m.Y H:i") ?></td>
            </tr>
            <?php if(!empty($special__params) && !empty($lead->params)): ?>
                <?php $leadParams = $lead->params; ?>
                <?php foreach($special__params as $param): ?>
                    <?php if(isset($leadParams[$param['name']])): ?>
                        <tr>
                            <th><?= $param['description'] ?></th>
                            <td><?= $leadParams[$param['name']] ?></td>
                        </tr>
                    <?php endif; ?>
                <?php endforeach; ?>
            <?php endif; ?>
        </table>
    </div>
</div>

<div style="font-family: system-ui, Arial, serif; margin: 20px auto; max-width: 1024px; width:100%">
    <p>Письмо сформировано и отправлено автоматически</p>
    <p>С уважением</p>
    <p><b>Команда технической поддержки <span style="color: #24b054">Lead</span>.Force</b></p>
    <div style="margin-top: 15px">
        <div style="margin-bottom: 15px"><b>Полезные сервисы для вас:</b></div>
        <ul style="margin-bottom: 15px">
            <li>Бесплатный СЕО аудит вашего сайта: <a href="https://optimise-your-seo.ru">https://optimise-your-seo.ru</a></li>
            <li>Бесплатный аудит отдела продаж: <a href="https://business-bfl.ru">https://business-bfl.ru</a></li>
            <li>Обучение отдела продаж и контакт-центра: <a href="https://courses.business-bfl.ru">https://courses.business-bfl.ru</a></li>
            <li>Арбитражные управляющие для ваших банкротов: <a href="https://arbit.femidafors.ru">https://arbit.femidafors.ru</a></li>
            <li>Автоматизация бизнеса / Внешнее управление: <a href="https://myforce-business.ru">https://myforce-business.ru</a></li>
            <li>CRM, Сайты, Приложения, Реклама, Дизайн: <a href="https://dev-force.ru">https://dev-force.ru</a></li>
        </ul>
        <div><b>Оставьте отзыв и получите 5000 бонусов на счет личного кабинета</b> <a
                    href="https://yandex.ru/maps/org/myforce/20572719115/?ll=39.714279%2C47.235310&z=14">https://yandex.ru/maps/org/myforce/20572719115/?ll=39.714279%2C47.235310&z=14</a></div>
    </div>
</div>
