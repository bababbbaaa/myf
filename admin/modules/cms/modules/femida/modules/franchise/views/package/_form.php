<?php

use mihaildev\ckeditor\CKEditor;
use mihaildev\elfinder\ElFinder;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use common\models\Franchise;
use common\models\FranchisePackage;

/* @var $this yii\web\View */
/* @var $model common\models\FranchisePackage */
/* @var $form yii\widgets\ActiveForm */
$franchise = Franchise::find()->orderBy('id desc')->select(['name', 'id'])->all();
$packagesArray = [
        null => "Без наследования"
];
$franchiseArray = [];
if (!empty($franchise)) {
    foreach ($franchise as $item)
        $franchiseArray[$item->id] = $item->name;
}
if (empty($model->id))
    $packages = FranchisePackage::find()->orderBy('id desc')->all();
else
    $packages = FranchisePackage::find()->where(['!=', 'id', $model->id])->orderBy('id desc')->all();
if(!empty($packages)) {
    foreach ($packages as $item) {
        $packagesArray[$franchiseArray[$item->franchise_id]][$item->id] = $item->name;
    }
}

$this->registerCssFile(Url::to(['/css/chosen.min.css']));
$this->registerJsFile(Url::to(['/js/chosen.jquery.min.js']), ['depends' => \yii\web\JqueryAsset::class]);

$js = <<<JS
$(".chosen-select").chosen({disable_search_threshold: 5});
JS;

$this->registerJs($js);
?>

<div class="franchise-package-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true, 'placeholder' => 'Бизнес–парнёр']) ?>

    <?= $form->field($model, 'is_active')->dropDownList([1 => 'Активен', 0 => "Неактивен"]) ?>

    <?= $form->field($model, 'franchise_id')->dropDownList($franchiseArray, ['class' => 'form-control chosen-select']) ?>

    <?= $form->field($model, 'parent_package')->dropDownList($packagesArray, ['class' => 'form-control chosen-select']) ?>


    <div class="row" >
        <div class="col-lg-8 pdb10">
            <?=
            $form->field($model, 'package_content')->widget(CKEditor::className(), [
                'editorOptions' => ElFinder::ckeditorOptions('elfinder'),
            ])->textarea(['value' => empty($model->package_content) ? "<ul><li></li></ul>" : $model->package_content]);
            ?>
        </div>
        <div class="col-lg-4 pdb10">
            <img style="width: 100%; max-width: 280px; padding-top: 25px" src="<?= Url::to(['/images/example.png']) ?>" alt="">
        </div>
    </div>
    <div class="rbac-info" style="margin-bottom: 20px">
        Поле <strong>&laquo;Контент пакета&raquo;</strong> заполняется в виде ненумерованного списка, в котором перечисляются преимущества пакета (см. рис. в правом блоке).<br>
        <br><strong>Обратите внимание: </strong> <u>указанный обычный ненумерованный список будет автоматически стилизован к виду, представленному на рисунке.</u>
    </div>

    <?= $form->field($model, 'price')->input('number', ['placeholder' => '29000']) ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-admin']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
