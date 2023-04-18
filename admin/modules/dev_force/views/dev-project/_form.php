<?php

use mihaildev\ckeditor\CKEditor;
use mihaildev\elfinder\ElFinder;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\jui\DatePicker;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\DevProject */
/* @var $form yii\widgets\ActiveForm */

$clients = \common\models\Clients::find()->asArray()->select('f, i, user_id')->where(['!=', 'user_id', ''])->all();
$client = [];
foreach ($clients as $v)
    $client[$v['user_id']] = "{$v['f']} {$v['i']}";



$stages = \common\models\DevStageProject::find()->asArray()->select('id, title')->all();
$stage = [];
foreach ($stages as $v)
    $stage[$v['id']] = $v['title'];
$stage[9] = 'Архив';
$js = <<< JS
    $(".chosen-select").chosen({disable_search_threshold: 0});
    function rus_to_latin ( str ) {
        let ru = {
            'а': 'a', 'б': 'b', 'в': 'v', 'г': 'g', 'д': 'd', 
            'е': 'e', 'ё': 'e', 'ж': 'j', 'з': 'z', 'и': 'i', 
            'к': 'k', 'л': 'l', 'м': 'm', 'н': 'n', 'о': 'o', 
            'п': 'p', 'р': 'r', 'с': 's', 'т': 't', 'у': 'u', 
            'ф': 'f', 'х': 'h', 'ц': 'c', 'ч': 'ch', 'ш': 'sh', 
            'щ': 'shch', 'ы': 'y', 'э': 'e', 'ю': 'u', 'я': 'ya'
        }, n_str = [];
        str = str.replace(/[ъь]+/g, '').replace(/й/g, 'i');
        for ( let i = 0; i < str.length; ++i ) {
           n_str.push(
                  ru[ str[i] ]
               || ru[ str[i].toLowerCase() ] === undefined && str[i]
               || ru[ str[i].toLowerCase() ].replace(/^(.)/, function ( match ) { return match.toUpperCase() })
           );
        }
        return n_str.join('');
    }
    $('#titleInput').on('input',function() {
      let j = rus_to_latin($(this).val());
      j = j.replace(/ /g, '-');
      $('#linkArticle').val(j.toLowerCase());
    });
JS;
$this->registerCssFile(Url::to(['/css/chosen.min.css']));
$this->registerJsFile(Url::to(['/js/chosen.jquery.min.js']), ['depends' => \yii\web\JqueryAsset::class]);
$this->registerJs($js);
?>

<div class="dev-project-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'user_id')->dropDownList($client, ['class' => 'form-control chosen-select']) ?>



    <?= $form->field($model, 'type')->dropDownList(['Посадочная страница' => 'Посадочная страница', 'Корпоративный сайт' => 'Корпоративный сайт', 'Сайт справочник' => 'Сайт справочник', 'Интернет магазин' => 'Интернет магазин', 'Моб. приложение' => 'Моб. приложение', 'Личный кабинет' => 'Личный кабинет', 'Веб приложение' => 'Веб приложение', 'CRM система' => 'CRM система', 'Дизайн / Редизайн' => 'Дизайн / Редизайн', 'Gamedev' => 'Gamedev', 'Другое' => 'Другое',]) ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true, 'placeholder' => 'На пример: Лендинг для БЛФ', 'id' => 'titleInput']) ?>

    <?= $form->field($model, 'link')->textInput(['maxlength' => true, 'id' => 'linkArticle', 'placeholder' => 'lending-na-bfl']) ?>

    <?= $form->field($model, 'date_end')->widget(DatePicker::classname(), [
        'language' => 'ru',
        'dateFormat' => 'yyyy-MM-dd',
        'options' => ['class' => 'form-control', 'placeholder' => '2022-03-15'],
    ]) ?>

    <?= $form->field($model, 'status')->dropDownList(['В работе' => 'В работе', 'Выполнен' => 'Выполнен', 'Остановлен' => 'Остановлен', 'Модерация' => 'Модерация',]) ?>

    <?= $form->field($model, 'stage_id')->dropDownList($stage, ['class' => 'form-control chosen-select'])->label('Статус проекта (переключать по порядку)') ?>

    <?= $form->field($model, 'about_project')->widget(CKEditor::className(), ['editorOptions' => ElFinder::ckeditorOptions('elfinder'),]); ?>

    <?= $form->field($model, 'tz_link')->textInput(['maxlength' => true, 'placeholder' => 'https://docs.google.com/spreadsheets/d/1gNYCCB_4FDFSQq4wAHq73H5wAkGhtnXBAMPahckpw3E/edit#gid=1735933618']) ?>

    <?= $form->field($model, 'summ')->input('number', ['placeholder' => '48990']) ?>

    <div style="display:none;">
        <?= $form->field($model, 'date')->textInput() ?>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-admin']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
