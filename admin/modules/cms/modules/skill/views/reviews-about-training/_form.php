<?php

use mihaildev\elfinder\InputFile;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\SkillReviewsAboutTraining */
/* @var $form yii\widgets\ActiveForm */

$trainings = \common\models\SkillTrainings::find()->select(['name', 'id'])->asArray()->all();

$traArr = [];

if(!empty($trainings)) {
    foreach ($trainings as $item)
        $traArr[$item['id']] = $item['name'];
}
$this->registerCssFile(Url::to(['/css/chosen.min.css']));
$this->registerJsFile(Url::to(['/js/chosen.jquery.min.js']), ['depends' => \yii\web\JqueryAsset::class]);

$js = <<<JS
$(".chosen-select").chosen({disable_search_threshold: 5});
JS;

$this->registerJs($js);

?>

<div class="skill-reviews-about-training-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'training_id')->dropDownList($traArr, ['class' => 'form-control chosen-select']) ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true, 'placeholder' => 'Кирилл Супрунов']) ?>

    <?= $form->field($model, 'grade')->input('number', ['placeholder' => '10', 'min' => 1, 'max' => 10, 'step' => 1]) ?>

    <?= $form->field($model, 'content')->textarea(['rows' => 6, 'placeholder' => 'Отличный курс! Спасибо куратору Игорю за помощь на каждом этапе. Уже месяц зарабатываю тем, что мне действительно нравится']) ?>

    <?= $form->field($model, 'photo')->widget(InputFile::className(), [
        'language'      => 'ru',
        'controller'    => 'elfinder', // вставляем название контроллера, по умолчанию равен elfinder
        'filter'        => 'image',    // фильтр файлов, можно задать массив фильтров https://github.com/Studio-42/elFinder/wiki/Client-configuration-options#wiki-onlyMimes
        'template'      => '<div class="input-group">{input}<span class="input-group-btn">{button}</span></div>',
        'options'       => ['class' => 'form-control', 'placeholder' => 'Фото'],
        'buttonOptions' => ['class' => 'btn btn-admin', 'style' => 'padding: 6px 15px'],
        'buttonName' => 'Выбрать',
        'multiple'      => false       // возможность выбора нескольких файлов
    ]); ?>

    <?= $form->field($model, 'date')->widget(\yii\jui\DatePicker::classname(), ['options' => ['class' => 'form-control', 'placeholder' => date("Y-m-d", time() + 2*3600*24)], 'dateFormat' => 'yyyy-MM-dd']) ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-admin']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
