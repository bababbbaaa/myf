<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\AuthRule */
/* @var $form yii\widgets\ActiveForm */

$rulesPath = "../modules/rbac/rules";
$scanned_directory = array_diff(scandir($rulesPath), array('..', '.'));
$namesArray = [];
$contentArray = [];
foreach ($scanned_directory as $item) {
    $name = lcfirst(substr($item, 0, -8));
    $namesArray[$name] = $item;
    $contentArray[$name] = file_get_contents($rulesPath . DIRECTORY_SEPARATOR . $item);
}
$json = json_encode($contentArray);
$this->registerCssFile(Url::to(['/css/chosen.min.css']));
$this->registerJsFile(Url::to(['/js/chosen.jquery.min.js']), ['depends' => \yii\web\JqueryAsset::class]);

$js = <<<JS
var obj = {$json};
$(".chosen-select")
    .chosen({disable_search_threshold: 5})
    .on('change', function() {
        $('.change-pre').text(obj[$(this).val()]);
    });
JS;
$this->registerJs($js);

?>

<div class="auth-rule-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')
        ->dropDownList($namesArray, ['class' => 'form-control chosen-select'])
        ->label('Создать правило на основании')?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-admin']) ?>
    </div>

    <hr>

    <h3>Содержание правила</h3>

<?php if(!empty($contentArray)): ?>
    <?php if (empty($model->name)): ?>
<pre class="change-pre">
<?= Html::encode($contentArray[array_key_first($contentArray)]) ?>
</pre>
    <?php else: ?>
<pre class="change-pre">
<?= Html::encode($contentArray[$model->name]) ?>
</pre>
    <?php endif; ?>
<?php endif; ?>

    <?php ActiveForm::end(); ?>

</div>
