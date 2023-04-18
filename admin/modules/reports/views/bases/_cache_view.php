<?php

use admin\models\BasesUtm;
use yii\bootstrap\Dropdown;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;
use yii\widgets\LinkPager;

/* @var $this yii\web\View */
/* @var $model admin\models\Bases */


?>
<style>.preloader-ajax-forms{display:block;}</style>
<div class="bases-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Обновить', ['update', 'id' => $model->id], ['class' => 'btn btn-admin']) ?>
        <?= Html::a('Добавить контакты', ['add-contacts', 'id' => $model->id], ['class' => 'btn btn-admin-help']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-admin-delete',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            'category',
            'provider',
            'geo',
            'date_create',
            'is_new',
        ],
    ]) ?>

    <?php if(!empty($contacts)): ?>
        <?php
            $idArr = [];
            foreach ($contacts as $item) {
                $idArr[] = $item['id'];
            }
            $utms = BasesUtm::find()->where(['in', 'contact_id', $idArr])->select('name, date, is_1, contact_id')->asArray()->all();
            if (!empty($utms)) {
                $utArr = [];
                foreach ($utms as $item) {
                    $utArr[$item['contact_id']][] = ['name' => $item['name'], 'date' => $item['date'], 'is_1' => $item['is_1']];
                }
            }
        ?>
    test 
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
                <div style="margin-right: 5px">
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
                </div>
                <div style="margin-right: 10px">
                    <a href="/reports/bases/view?id=<?= $model->id ?>&pageSize=500" class="btn btn-admin hvp <?= empty($_GET['pageSize']) || $_GET['pageSize'] == 500 ? 'hoveredPageSize' : '' ?>">500</a>
                </div>
                <div style="margin-right: 10px">
                    <a href="/reports/bases/view?id=<?= $model->id ?>&pageSize=1000" class="btn btn-admin hvp <?= !empty($_GET['pageSize']) && $_GET['pageSize'] == 1000 ? 'hoveredPageSize' : '' ?>">1000</a>
                </div>
                <div style="margin-right: 10px">
                    <a href="/reports/bases/view?id=<?= $model->id ?>&pageSize=2500" class="btn btn-admin hvp <?= !empty($_GET['pageSize']) && $_GET['pageSize'] == 2500 ? 'hoveredPageSize' : '' ?>">2500</a>
                </div>
                <div style="margin-right: 10px">
                    <a href="/reports/bases/view?id=<?= $model->id ?>&pageSize=5000" class="btn btn-admin hvp <?= !empty($_GET['pageSize']) && $_GET['pageSize'] == 5000 ? 'hoveredPageSize' : '' ?>">5000</a>
                </div>
                <div style="margin-right: 10px; margin-bottom: 10px;"><?= Html::a('CLEAR CACHE', ['flush', 'return' => "view?id={$model->id}"], ['class' => 'btn btn-admin-delete']) ?></div>
            </div>
        </div>
        <div style="max-height: 600px; overflow: auto">
            <table class="table table-responsive table-bordered table-striped">
                <tr style="background: #303030; color: white">
                    <th style="width: 50px"><input type="checkbox" name="set_all"></th>
                    <th style="width: 150px">ID</th>
                    <th style="width: 150px">Телефон</th>
                    <th>UTM</th>
                </tr>
                <?php
                /**
                 * @var \admin\models\BasesContacts $item
                 */
                ?>
                <?php foreach($contacts as $item): ?>
                    <tr>
                        <td style="width: 50px"><input class="serialized-checkbox" type="checkbox" name="set[<?= $model->id ?>][]" value="<?= $item['id'] ?>"></td>
                        <td style="width: 150px"><?= $item['id'] ?></td>
                        <td style="width: 150px"><?= $item['phone'] ?></td>
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
        </div>
        <?php if(!empty($pages)): ?>
            <?php echo LinkPager::widget([
                'pagination' => $pages,
            ]); ?>
        <?php endif; ?>
    <?php endif; ?>

</div>
