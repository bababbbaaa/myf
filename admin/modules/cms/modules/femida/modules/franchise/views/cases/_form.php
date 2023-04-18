<?php

use common\models\Franchise;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use mihaildev\elfinder\InputFile;

/* @var $this yii\web\View */
/* @var $model common\models\FranchiseCases */
/* @var $form yii\widgets\ActiveForm */

$franchise = Franchise::find()->orderBy('id desc')->all();
$array = [];
if (!empty($franchise)) {
    foreach ($franchise as $item) {
        $array[$item->id] = $item->name;
    }
}

$this->registerCssFile(Url::to(['/css/chosen.min.css']));
$this->registerJsFile(Url::to(['/js/chosen.jquery.min.js']), ['depends' => \yii\web\JqueryAsset::class]);

$js = <<<JS
$(".chosen-select").chosen({disable_search_threshold: 5});
JS;

$this->registerJs($js);

?>

<div class="franchise-cases-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'franchise_id')->dropDownList($array, ['class' => 'form-control chosen-select']) ?>

    <?= $form->field($model, 'is_active')->dropDownList([1 => 'Активен', 0 => "Неактивен"]) ?>

   <?php

   echo $form->field($model, 'img')->widget(InputFile::className(), [
       'language'      => 'ru',
       'controller'    => 'elfinder', // вставляем название контроллера, по умолчанию равен elfinder
       'path' => 'image', // будет открыта папка из настроек контроллера с добавлением указанной под деритории
       'filter'        => 'image',    // фильтр файлов, можно задать массив фильтров https://github.com/Studio-42/elFinder/wiki/Client-configuration-options#wiki-onlyMimes
       'template'      => '<div class="input-group">{input}<span class="input-group-btn">{button}</span></div>',
       'options'       => ['class' => 'form-control', 'placeholder' => 'Фото партнера'],
       'buttonOptions' => ['class' => 'btn btn-default'],
       'multiple'      => false       // возможность выбора нескольких файлов
   ]);

   ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true, 'placeholder' => 'Василий Артин']) ?>

    <?= $form->field($model, 'whois')->textInput(['maxlength' => true, 'placeholder' => 'Основатель и совладелец группы компаний «ФЭС»']) ?>

    <?= $form->field($model, 'status')->textInput(['maxlength' => true, 'placeholder' => 'Партнер с 2017 года']) ?>

    <?= $form->field($model, 'investments')->input('number', ['placeholder' => '250000']) ?>

    <?= $form->field($model, 'feedback')->textInput(['maxlength' => true, 'placeholder' => '4 месяца']) ?>

    <?= $form->field($model, 'income_approx')->textInput(['placeholder' => '490000']) ?>

    <?= $form->field($model, 'offices')->textInput(['maxlength' => true, 'placeholder' => 'г. Ростов-на-Дону, г. Ставрополь, г. Брянске, г. Калуга, г. Краснодар, г. Новороссийск, г. Майкоп']) ?>

    <?= $form->field($model, 'video')->textInput(['maxlength' => true, 'placeholder' => 'https://www.youtube.com/watch?v=9bZkp7q19f0&ab_channel=officialpsy']) ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-admin']) ?>
    </div>

    <?php ActiveForm::end(); ?>



</div>
