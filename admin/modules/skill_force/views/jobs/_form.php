<?php

use mihaildev\elfinder\InputFile;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Jobs */
/* @var $form yii\widgets\ActiveForm */

$js =<<< JS
var duties = {};
    $('.add__duties-inp').on('click', function() {
        var inp = '<input placeholder="Работа в графических редакторах" style="margin-top: 10px;" name="duties[]" class="form-control duties__inp" type="text">';
        $('.duties__input-block').append(inp);
    });
    $('.save__duties-inp').on('click', function() {
        var inp = $('.duties__inp'),
            arr = [];
        inp.each(function() {
            if ($(this).val().length > 5){
              arr.push($(this).val());
            }
        })
        duties.info = arr;
        $('#jobs-duties').val(JSON.stringify(duties.info))
    });
    function renderDuties() {
        if ($('#jobs-duties').val().length > 0){
                  var dut = JSON.parse($('#jobs-duties').val());
      for (var i = 0; i < dut.length; i++){
          var inp = '<input placeholder="Работа в графических редакторах" style="margin-top: 10px;" name="duties[]" class="form-control duties__inp" value="'+ dut[i] +'" type="text">';
            $('.duties__input-block').append(inp);
          }
        }
    }
   renderDuties();
var requirements = {};
    $('.add__requirements-inp').on('click', function() {
        var inp = '<input placeholder="Работа в графических редакторах" style="margin-top: 10px;" name="requirements" class="form-control requirements__inp" type="text">';
        $('.requirements__input-block').append(inp);
    });
    $('.save__requirements-inp').on('click', function() {
        var inp = $('.requirements__inp'),
            arr = [];
        inp.each(function() {
            if ($(this).val().length > 5){
              arr.push($(this).val());
            }
        })
        requirements.info = arr;
        $('#jobs-requirements').val(JSON.stringify(requirements.info))
    });
    function renderRequirements() {
        if ($('#jobs-requirements').val().length > 0){
          var dut = JSON.parse($('#jobs-requirements').val());
          for (var i = 0; i < dut.length; i++){
              var inp = '<input placeholder="Работа в графических редакторах" style="margin-top: 10px;" name="requirements" class="form-control requirements__inp" value="'+ dut[i] +'" type="text">';
              $('.requirements__input-block').append(inp);
          }
        }
    }
   renderRequirements();
var working_conditions = {};
    $('.add__working_conditions-inp').on('click', function() {
        var inp = '<input placeholder="Работа в графических редакторах" style="margin-top: 10px;" name="working_conditions" class="form-control working_conditions__inp" type="text">';
        $('.working_conditions__input-block').append(inp);
    });
    $('.save__working_conditions-inp').on('click', function() {
        var inp = $('.working_conditions__inp'),
            arr = [];
        inp.each(function() {
            if ($(this).val().length > 5){
              arr.push($(this).val());
            }
        })
        working_conditions.info = arr;
        console.log(working_conditions.info);
        $('#jobs-working_conditions').val(JSON.stringify(working_conditions.info))
    });
    function renderWorking_conditions() {
        if ($('#jobs-working_conditions').val().length){
          var dut = JSON.parse($('#jobs-working_conditions').val());
          for (var i = 0; i < dut.length; i++){
              var inp = '<input placeholder="Работа в графических редакторах" style="margin-top: 10px;" name="working_conditions" class="form-control working_conditions__inp" value="'+ dut[i] +'" type="text">';
              $('.working_conditions__input-block').append(inp);
          }
        }
    }
   renderWorking_conditions();
JS;
$this->registerJs($js);

?>

<div class="jobs-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'position')->textInput(['maxlength' => true, 'placeholder' => 'Программист']) ?>

    <?= $form->field($model, 'payment')->textInput(['maxlength' => true, 'placeholder' => '35 000 - 40 000']) ?>

    <?= $form->field($model, 'company_name')->textInput(['maxlength' => true, 'placeholder' => 'ООО “Право”']) ?>

    <?= $form->field($model, 'site')->textInput(['maxlength' => true, 'placeholder' => 'CompanyCO.com']) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true, 'placeholder' => 'CompanyCO@gmail.com']) ?>

    <?= $form->field($model, 'city')->textInput(['maxlength' => true, 'placeholder' => 'Москва']) ?>

<!--    --><?//= $form->field($model, 'date')->textInput() ?>

    <?= $form->field($model, 'logo')->widget(InputFile::className(), [
        'language'      => 'ru',
        'controller'    => 'elfinder', // вставляем название контроллера, по умолчанию равен elfinder
        'filter'        => 'image',    // фильтр файлов, можно задать массив фильтров https://github.com/Studio-42/elFinder/wiki/Client-configuration-options#wiki-onlyMimes
        'template'      => '<div class="input-group">{input}<span class="input-group-btn">{button}</span></div>',
        'options'       => ['class' => 'form-control', 'placeholder' => 'Логотип компании'],
        'buttonOptions' => ['class' => 'btn btn-admin', 'style' => 'padding: 6px 15px'],
        'buttonName' => 'Выбрать',
        'multiple'      => false       // возможность выбора нескольких файлов
    ]); ?>

    <?= $form->field($model, 'type_employment')->textInput(['maxlength' => true, 'placeholder' => 'Полная занятость']) ?>

    <?= $form->field($model, 'work_format')->textInput(['maxlength' => true, 'placeholder' => 'В офисе']) ?>

    <div style="display: flex; flex-direction: column;" class="duties form-group">
        <label class="form-group duties__input-block">
            Добавить обязаности
            <input placeholder="Работа в графических редакторах" style="margin-top: 10px;" name="duties[]" class="form-control duties__inp" type="text">
        </label>
        <div class="duties__block">
            <button type="button" class="btn btn-primary add__duties-inp">Добавить</button>
            <button type="button" class="btn btn-success save__duties-inp">Сохранить</button>
        </div>
    </div>

    <?= $form->field($model, 'duties')->textarea(['rows' => 6, 'readonly' => true]) ?>

    <div style="display: flex; flex-direction: column;" class="requirements form-group">
        <label class="form-group requirements__input-block">
            Добавить обязаности
            <input placeholder="Работа в графических редакторах" style="margin-top: 10px;" name="requirements" class="form-control requirements__inp" type="text">
        </label>
        <div class="requirements__block">
            <button type="button" class="btn btn-primary add__requirements-inp">Добавить</button>
            <button type="button" class="btn btn-success save__requirements-inp">Сохранить</button>
        </div>
    </div>

    <?= $form->field($model, 'requirements')->textarea(['rows' => 6, 'readonly' => true]) ?>

    <div style="display: flex; flex-direction: column;" class="working_conditions form-group">
        <label class="form-group working_conditions__input-block">
            Добавить обязаности
            <input placeholder="Работа в графических редакторах" style="margin-top: 10px;" name="working_conditions" class="form-control working_conditions__inp" type="text">
        </label>
        <div class="working_conditions__block">
            <button type="button" class="btn btn-primary add__working_conditions-inp">Добавить</button>
            <button type="button" class="btn btn-success save__working_conditions-inp">Сохранить</button>
        </div>
    </div>

    <?= $form->field($model, 'working_conditions')->textarea(['rows' => 6, 'readonly' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-admin']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
