<?php

use yii\bootstrap\Dropdown;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\jui\DatePicker;
use yii\widgets\LinkPager;

/**
 * @var \yii\web\View $this
 */

$b = [];
$bases = \admin\models\Bases::find()->select(['name', 'id'])->asArray()->all();
if (!empty($bases)) {
    foreach ($bases as $item)
        $b[$item['id']] = $item['name'];
}
$this->registerCssFile(Url::to(['/css/chosen.min.css']));
$this->registerJsFile(Url::to(['/js/chosen.jquery.min.js']), ['depends' => \yii\web\JqueryAsset::class]);
$js = <<<JS
$('th').on('input', '[name="set_all"]', function() {
    $('.serialized-checkbox').each(function() {
        $(this).prop('checked', !$(this).prop('checked'));
    });
});
var serialized = null;
$('.use-action-base').on('click', function(e) {
    e.preventDefault();
    serialized = $('.serialized-checkbox:checked').serialize();
    var action = $(this).attr('data-action');
    switch (action) {
        case 'download-txt':
            $('input[name="serialized"]').val(serialized);
            $('#serializedSubmit').submit();
            break;
        case 'new-utm':
            $('.admin-simple-modal-bg').css('display', 'flex');
            break;
    }
});
$('.chosen-select').chosen();
$('.utmForm').on('submit', function(e) {
    e.preventDefault();
    $('.hidden_seri').val(serialized);
    var data = $(this).serialize();
    $.ajax({
        data: data,
        dataType: "JSON",
        type: "POST",
        url: '/reports/bases/set-new-utm-data',
        beforeSend: function () {
            $('.preloader-ajax-forms').fadeIn(100);
        }
    }).done(function(rsp) {
        $('.preloader-ajax-forms').fadeOut(100);
        if (rsp.status === 'error') {
            Swal.fire({
              icon: 'error',
              title: 'Ошибка',
              text: rsp.message,
            });
        } else {
            location.href = "/reports/bases/utms";
        }
    });
});
JS;
$this->registerJs($js);
?>
<style>.preloader-ajax-forms{display:block;}</style>
<div class="bases-index">
    <h1><?= Html::encode($this->title) ?></h1>
</div>
<div style="margin: 20px 0 15px">
    <div style="margin-right: 10px; margin-bottom: 10px;"><?= Html::a('CLEAR CACHE', ['flush', 'return' => 'contacts'], ['class' => 'btn btn-admin-delete']) ?></div>
    <hr>
    <?= Html::beginForm('/reports/bases/contacts', 'GET') ?>
    <div style="display: flex; flex-wrap: wrap; align-items: flex-end">
        <div style="margin-right: 5px; margin-bottom: 5px">
            <p><b>Начиная с даты</b></p>
            <div>
                <?php
                echo DatePicker::widget([
                    'name' => 'filters[date_start]',
                    'options' => ['class' => 'form-control', 'autocomplete' => 'off', 'placeholder' => '01-09-2021'],
                    'value' => $_GET['filters']['date_start'] ?? '',
                    //'language' => 'ru',
                    'dateFormat' => 'dd-MM-yyyy',
                ]);?>
            </div>
        </div>
        <div style="margin-right: 5px; margin-bottom: 5px">
            <p><b>Заканчивая датой</b></p>
            <div>
                <?php
                echo DatePicker::widget([
                    'name' => 'filters[date_stop]',
                    'options' => ['class' => 'form-control', 'autocomplete' => 'off', 'placeholder' => '01-09-2021'],
                    'value' => $_GET['filters']['date_stop'] ?? '',
                    //'language' => 'ru',
                    'dateFormat' => 'dd-MM-yyyy',
                ]);?>
            </div>
        </div>
        <div style="margin-right: 5px; margin-bottom: 5px"><button class="btn btn-admin" type="submit">Поиск</button></div>
        <div style="margin-bottom: 5px; margin-right: 5px"><a href="/reports/bases/contacts" class="btn btn-admin-delete">Сброс</a></div>
    </div>
    <?= Html::endForm() ?>
</div>
<?php if(!empty($models)): ?>
    <hr>
    <div style="">
        <b>На странице: <?= count($models) ?>.</b>
        Показаны <?= empty($_GET['page']) || $_GET['page'] == 1 ? "1 - " . (empty($_GET['pageSize']) ? 500 : $_GET['pageSize']) : (($_GET['page'] - 1) * (empty($_GET['pageSize']) ? 500 : (int)$_GET['pageSize']) + 1) . " - " . ($_GET['page']*(empty($_GET['pageSize']) ? 500 : (int)$_GET['pageSize'])) ?>
    </div>
    <hr>
    <div>
        <div class="admin-simple-modal-bg close-modal-admin">
            <div class="admin-simple-modal">
                <div class="click-destroy close-modal-admin">
                    +
                </div>

                <?= Html::beginForm('set-new-utm-data', 'POST', ['class' => 'utmForm']) ?>
                <input type="hidden" name="seri" class="hidden_seri" value="">
                <p><b>Указать постфикс метки</b></p>
                <p><input autocomplete="off" class="form-control newUtmClass" type="text" name="utm100" placeholder="msk"></p>
                <p style="color: #9e9e9e; font-size: 12px">пример метки: 221021_n43jr_<b style="text-decoration: underline">postfix</b></p>
                <p><button type="submit" class="btn btn-admin newUtmBtn">Подтвердить</button></p>
                <?= Html::endForm() ?>

            </div>
        </div>
    </div>
    <?= Html::beginForm('/reports/bases/get-txt-file', 'POST', ['id' => 'serializedSubmit']) ?>
    <input type="hidden" name="serialized" value="">
    <?= Html::endForm() ?>
    <div style="margin: 20px 0;">
        <div style="display: flex; flex-wrap: wrap">
            <div style="margin-right: 10px; margin-bottom: 10px;" class="dropdown">
                <a href="#" data-toggle="dropdown" class="btn btn-admin-help dropdown-toggle">С выбранными <b class="caret"></b></a>
                <?php
                echo Dropdown::widget([
                    'items' => [
                        ['label' => 'Назначить новую метку', 'url' => '#', 'linkOptions' => ['data-action' => 'new-utm', 'class' => 'use-action-base']],
                        ['label' => 'Выгрузить телефоны для обзвона', 'url' => '#', 'linkOptions' => ['data-action' => 'download-txt', 'class' => 'use-action-base']],
                    ],
                ]);
                ?>
            </div>
            <div style="margin-right: 10px">
                <a href="/reports/bases/contacts?pageSize=500" class="btn btn-admin hvp <?= empty($_GET['pageSize']) || $_GET['pageSize'] == 500 ? 'hoveredPageSize' : '' ?>">500</a>
            </div>
            <div style="margin-right: 10px">
                <a href="/reports/bases/contacts?pageSize=1000" class="btn btn-admin hvp <?= !empty($_GET['pageSize']) && $_GET['pageSize'] == 1000 ? 'hoveredPageSize' : '' ?>">1000</a>
            </div>
            <div style="margin-right: 10px">
                <a href="/reports/bases/contacts?pageSize=2500" class="btn btn-admin hvp <?= !empty($_GET['pageSize']) && $_GET['pageSize'] == 2500 ? 'hoveredPageSize' : '' ?>">2500</a>
            </div>
            <div>
                <a href="/reports/bases/contacts?pageSize=5000" class="btn btn-admin hvp <?= !empty($_GET['pageSize']) && $_GET['pageSize'] == 5000 ? 'hoveredPageSize' : '' ?>">5000</a>
            </div>
        </div>
    </div>
    <table class="table table-bordered table-striped">
        <tr style="background: #303030; color: whitesmoke">
            <th style="width: 50px"><input type="checkbox" name="set_all"></th>
            <th>ID</th>
            <th>Телефон</th>
            <th>База</th>
            <th>Дата</th>
            <th>UTM</th>
        </tr>
        <?php

            $idArr = [];
            foreach ($models as $item) {
                $idArr[] = $item['id'];
            }

            $utms = \admin\models\BasesUtm::find()
                ->where(['in', 'contact_id', $idArr])
                ->select(['contact_id', 'date', 'name', 'is_1', 'id'])
                ->asArray()
                ->all();
            if (!empty($utms)) {
                $utArr = [];
                foreach ($utms as $item) {
                    $utArr[$item['contact_id']][] = ['date' => $item['date'], 'name' => $item['name'], 'is_1' => $item['is_1'], ];
                }
            }

        ?>
        <?php foreach($models as $item): ?>
            <tr>
                <td style="width: 50px"><input class="serialized-checkbox" type="checkbox" name="set[<?= $item['base_id'] ?>][]" value="<?= $item['id'] ?>"></td>
                <td><?= $item['id'] ?></td>
                <td><?= $item['phone'] ?></td>
                <td><a href="/reports/bases/view?id=<?= $item['base_id'] ?>"><?= $b[$item['base_id']] ?></a></td>
                <td><?= date('d.m.Y H:i', strtotime($item['date'])) ?></td>
                <td>
                    <?php if(!empty($utArr[$item['id']])): ?>
                        <table class="table table-bordered">
                            <tr>
                                <th>Дата</th>
                                <th>Метка</th>
                                <th>Единичка?</th>
                            </tr>
                            <?php foreach($utArr[$item['id']] as $i): ?>
                                <tr>
                                    <td><?= date('d.m.Y H:i', strtotime($i['date'])) ?></td>
                                    <td><a href="/reports/bases/view-utm?name=<?= $i['name'] ?>" target="_blank"><?= $i['name'] ?></a></td>
                                    <td><?= $i['is_1'] === 1 ? 'да' : 'нет' ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </table>
                    <?php else: ?>
                        -
                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
    <?php if(!empty($pages)): ?>
        <?php echo LinkPager::widget([
            'pagination' => $pages,
        ]); ?>
    <?php endif; ?>
<?php else: ?>
    <p>Ничего не найдено</p>
<?php endif; ?>
