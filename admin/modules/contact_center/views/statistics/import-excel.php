<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\jui\DatePicker;
use yii\bootstrap\Alert;

/**
 * @var $this \yii\web\View
 */

$this->title = 'Импорт по форматированному XLSX';
$this->params['breadcrumbs'][] = [
    'url' => \yii\helpers\Url::to(['main/index']),
    'label' => 'КЦ'
];
$this->params['breadcrumbs'][] = ['label' => 'Статистика', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$responseXls = Yii::$app->session->getFlash('emptyResponse');
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
    <h1>Указать форматированный XLSX</h1>
    <?= Html::beginForm(Url::to(['import-excel']), 'POST', ['id' => 'useFormFilter', 'enctype' => 'multipart/form-data']) ?>
    <div class="row" style="margin-top: 15px;">
        <div class="col-md-8" style="margin-bottom: 10px">
            <p><b>XLSX-файл</b></p>
            <div>
                <input accept=".xlsx" placeholder="SPB" type="file" class="form-control" name="file">
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
    <p><b style="color: red; font-size: 20px;">ВНИМАНИЕ:</b> данный импорт поддерживает только отформатированные специальным образом XLSX-файлы, полученные при "удаляющем экспорте" по метке</p>
</div>
