<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\jui\DatePicker;
use yii\bootstrap\Alert;

/**
 * @var $this \yii\web\View
 */

$this->title = 'Импорт по TXT';
$this->params['breadcrumbs'][] = [
    'url' => \yii\helpers\Url::to(['main/index']),
    'label' => 'КЦ'
];
$this->params['breadcrumbs'][] = ['label' => 'Статистика', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$responseXls = Yii::$app->session->getFlash('emptyResponse');

$cats = \common\models\LeadsCategory::find()->select(['name', 'link_name'])->asArray()->all();
$c = [];
if (!empty($cats)) {
    foreach ($cats as $i)
        $c[$i['link_name']] = $i['name'];
}
?>
<style>
    .chosen-single {
        border-radius: 0 !important;
    }
</style>
<div>
    <?php if(!empty($responseXls)): ?>
    <?php echo Alert::widget([
            'options' => [
                'class' => 'alert-warning',
            ],
            'body' => $responseXls,
        ]); ?>
    <?php endif; ?>
    <h1>Загрузка TXT-файла</h1>
    <?= Html::beginForm(Url::to(['import-txt']), 'POST', ['id' => 'useFormFilter', 'enctype' => 'multipart/form-data']) ?>
    <div class="row" style="margin-top: 15px;">
        <div class="col-md-8" style="margin-bottom: 10px">
            <p><b>TXT-файл</b></p>
            <div style="margin-bottom: 10px;">
                <input accept=".txt" placeholder="SPB" required type="file" class="form-control" name="file">
            </div>
            <p><b>Источник</b></p>
            <div style="margin-bottom: 10px;">
                <input placeholder="База МСК март" required type="text" class="form-control" name="source">
            </div>
            <p><b>utm_source</b></p>
            <div style="margin-bottom: 10px">
                <input placeholder="msk" type="text" required class="form-control" name="utm_source">
            </div>
            <p><b>Категория лидов</b></p>
            <div>
                <select class="form-control" name="category" required id="">
                    <?php if(!empty($c)): ?>
                        <?php foreach($c as $key => $item): ?>
                            <option value="<?= $key ?>"><?= $item ?></option>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </select>
            </div>
        </div>
    </div>
    <div style="margin-top: 20px; display: flex; ">
        <div style="margin-right: 20px">
            <?= Html::submitButton("<b>ИМПОРТ</b>", ['class' => 'btn btn-admin']) ?>
        </div>
    </div>
    <?= Html::endForm() ?>
</div>
<div style="margin: 40px 0; font-size: 20px;">Справка</div>
<div class="rbac-info rbac-info-leads" style="max-width: unset">
    <p><b style="color: red; font-size: 20px;">ВНИМАНИЕ:</b>
        номера должны быть записаны в столбец - каждый номер с новой строки
    </p>
</div>
