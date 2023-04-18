<?php

use admin\models\Bases;
use admin\models\BasesUtm;
use yii\bootstrap\Dropdown;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;

/**
 * @var \admin\models\BasesUtm $utm
 */

$bases = \admin\models\Bases::find()->select('name, id')->asArray()->all();
$b = [];
foreach ($bases as $item) {
    $b[$item['id']] = $item['name'];
}

$provs = Bases::find()->select(['provider'])->groupBy('provider')->asArray()->all();
$is1Count = 0;
$isCCCount = 0;
?>
<style>.preloader-ajax-forms{display:block;}</style>
<div class="bases-index">
    <h1><?= Html::encode($this->title) ?></h1>
</div>
<table class="table table-bordered">
    <tr style="background-color: #006dcc; color: whitesmoke">
        <th>Дата</th>
        <th>Метка</th>
        <th>Базы</th>
    </tr>
    <tr>
        <td><?= date('d.m.Y H:i', strtotime($utm->date)) ?></td>
        <td><?= $utm->name ?></td>
        <td>
            <?php if(!empty($utm->bases)): ?>
                <table class="table table-bordered">
                    <tr>
                        <th>Название</th>
                        <th>Поставщик</th>
                        <th>Регион</th>
                    </tr>
                    <?php foreach($utm->bases as $item): ?>
                        <tr>
                            <td><a href="/reports/bases/view?id=<?= $item->id ?>"><?= $item->name ?></a></td>
                            <td><?= $item->provider ?></td>
                            <td><?= $item->geo ?></td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            <?php endif; ?>
        </td>
    </tr>
</table>
<?php if(!empty($models)): ?>
    <?php if(!empty($provs)): ?>
        <datalist id="provs-list">
            <?php foreach($provs as $item): ?>
                <option value="<?= $item['provider'] ?>"><?= $item['provider'] ?></option>
            <?php endforeach; ?>
        </datalist>
    <?php endif; ?>
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
                <a href="/reports/bases/view-utm?name=<?= $_GET['name'] ?>&pageSize=500" class="btn btn-admin hvp <?= empty($_GET['pageSize']) || $_GET['pageSize'] == 500 ? 'hoveredPageSize' : '' ?>">500</a>
            </div>
            <div style="margin-right: 10px">
                <a href="/reports/bases/view-utm?name=<?= $_GET['name'] ?>&pageSize=1000" class="btn btn-admin hvp <?= !empty($_GET['pageSize']) && $_GET['pageSize'] == 1000 ? 'hoveredPageSize' : '' ?>">1000</a>
            </div>
            <div style="margin-right: 10px">
                <a href="/reports/bases/view-utm?name=<?= $_GET['name'] ?>&pageSize=2500" class="btn btn-admin hvp <?= !empty($_GET['pageSize']) && $_GET['pageSize'] == 2500 ? 'hoveredPageSize' : '' ?>">2500</a>
            </div>
            <div style="margin-right: 10px">
                <a href="/reports/bases/view-utm?name=<?= $_GET['name'] ?>&pageSize=5000" class="btn btn-admin hvp <?= !empty($_GET['pageSize']) && $_GET['pageSize'] == 5000 ? 'hoveredPageSize' : '' ?>">5000</a>
            </div>
            <div style="margin-right: 10px; margin-bottom: 10px;"><?= Html::a('CLEAR CACHE', ['flush', 'return' => "view-utm?name={$_GET['name']}"], ['class' => 'btn btn-admin-delete']) ?></div>
        </div>
    </div>
    <div style="max-height: 600px; overflow: auto">
        <table class="table table-bordered table-striped">
            <tr style="background: #303030; color: whitesmoke">
                <th style="width: 50px"><input type="checkbox" name="set_all"></th>
                <th>Дата</th>
                <th>Телефон</th>
                <th>Единичка?</th>
                <th>После КЦ</th>
                <th>База</th>
            </tr>
            <?php
            /**
             * @var \admin\models\BasesContacts $item
             */
            ?>
            <?php
                $mArr = [];
                foreach ($models as $item) {
                    $mArr[] = $item['id'];
                }
                $getUtms = BasesUtm::find()
                    ->where(['in', 'contact_id', $mArr])
                    ->andWhere(['name' => $utm->name])
                    ->asArray()
                    ->select(['is_1', 'is_cc', 'base_id', 'contact_id',])
                    ->all();
                $utArr = [];
                foreach ($getUtms as $item) {
                    $utArr[$item['contact_id']] = ['is_1' => $item['is_1'], 'is_cc' => $item['is_cc'], 'base_id' => $item['base_id'],];
                }

            ?>
            <?php foreach($models as $item): ?>
                <tr>
                    <td style="width: 50px"><input class="serialized-checkbox" type="checkbox" name="set[<?= $item['base_id'] ?>][]" value="<?= $item['id'] ?>"></td>
                    <td><?= date('d.m.Y H:i', strtotime($item['date'])) ?></td>
                    <td><?= $item['phone'] ?></td>
                    <?php $helper = $getUtms[$item['id']];?>
                    <?php if ($helper['is_1']) {
                        $text = 'да';
                        $is1Count++;
                    } else $text = 'нет';
                    ?>
                    <?php if ($helper['is_cc']) {
                        $text2 = 'да';
                        $isCCCount++;
                    } else $text2 = 'нет';
                    ?>
                    <td><?= $text ?></td>
                    <td><?= $text2 ?></td>
                    <td>
                        <a target="_blank" href="/reports/bases/view?id=<?= $item['base_id'] ?>"><?= $b[$item['base_id']] ?></a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
        <?php if(!empty($pages)): ?>
            <?php echo LinkPager::widget([
                'pagination' => $pages,
            ]); ?>
        <?php endif; ?>
    </div>
    <?php $total = count($models) ?>
    <?php if(!empty($statistics)): ?>
        <h3>Статистика по метке</h3>
        <div style="display: block; ">
            <div style="margin-right: 10px; width: 100%">
                <div>
                    <?php if(!empty($statistics)): ?>
                        <table class="table table-bordered">
                            <tr style="background-color: #303030; color: whitesmoke">
                                <?php foreach($statistics as $item): ?>
                                    <td>
                                        <p><b>Дата</b>: <?= date('d.m.Y H:i', strtotime($item['date'])) ?></p>
                                        <span style="color: yellow"><b>Метка</b>: <?= $item['name'] ?></span>
                                    </td>
                                <?php endforeach; ?>
                            </tr>
                            <tr>
                                <?php foreach($statistics as $item): ?>
                                    <?php if ($item['total'] == 0) continue; ?>
                                    <td>
                                        <table class="table table-bordered">
                                            <tr>
                                                <th>Всего</th>
                                                <td><?= $item['total'] ?></td>
                                            </tr>
                                            <tr>
                                                <th>Единичек</th>
                                                <td><?= $item['is1Total'] ?></td>
                                            </tr>
                                            <tr>
                                                <th>После КЦ</th>
                                                <td><?= $item['isCcTotal'] ?></td>
                                            </tr>
                                            <tr>
                                                <th>Конверсии</th>
                                                <td>
                                                    <p>В единичку: <?= round($item['is1Total'] / $item['total'], 3) * 100 ?>%</p>
                                                    <p>В лиды: <?= round($item['isCcTotal'] / $item['total'], 3) * 100 ?>%</p>
                                                    <?php if($item['is1Total'] > 0): ?>
                                                        <p>Из единички в лиды: <?= round($item['isCcTotal'] / $item['is1Total'], 3) * 100 ?>%</p>
                                                    <?php endif; ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Базы</th>
                                                <td>
                                                    <?php foreach($item['bases'] as $k): ?>
                                                        <p><b><?= $k->name ?></b> / <?= $k->geo ?> / <?= $k->provider ?></p>
                                                    <?php endforeach; ?>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                <?php endforeach; ?>
                            </tr>
                        </table>
                    <?php endif; ?>
                </div>
            </div>
            <div>
                <div>

                    <div>
                        <div class="Statistics">
                            <canvas id="leadChart" width="auto" height="100"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
<?php endif; ?>
