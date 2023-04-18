<?php

use mihaildev\ckeditor\CKEditor;
use mihaildev\elfinder\ElFinder;
use mihaildev\elfinder\InputFile;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $model common\models\SkillTrainingsTasks */
/* @var $form yii\widgets\ActiveForm */

$trainings = \common\models\SkillTrainings::find()->select(['name', 'id'])->asArray()->all();
$questions = $model->questions;
if (!empty($questions)) {
    $quess = $questions;
} else {
    $quess = '[]';
}
$traArr = [];
if (!empty($trainings)) {
    foreach ($trainings as $item)
        $traArr[$item['id']] = $item['name'];
}
$material = $model->materials;
if (!empty($material)) {
    $materials = $material;
} else {
    $materials = '[]';
}

$this->registerCssFile(Url::to(['/css/chosen.min.css']));
$this->registerJsFile(Url::to(['/js/chosen.jquery.min.js']), ['depends' => \yii\web\JqueryAsset::class]);
$js = <<< JS
$(".chosen-select").chosen({disable_search_threshold: 5});

$('.info_id').on('submit', function(e) {
    e.preventDefault();
  $.pjax.reload({
    url: 'create',
    data: {id: $('.id_Info').val()},
    container: '#pjaxReloads',
    type: 'GET'
  })
});

$('.field-skilltrainingstasks-training_id').on('click', '.active-result' ,function(e) {
 var id = $('#skilltrainingstasks-training_id').val();
  $('.id_Info').val(id);
  $('.info_id').submit();
});

var material = $materials;
console.log(material);
function renderMaterial() {
      var html = '';
      if (material.length > 0){
          for (var i = 0; i < material.length; i++) {
            html += '<div data-id="'+ i +'" style="font-size: 16px; background-color: rgba(167,167,167,0.56); padding: 5px; cursor: pointer; max-width: fit-content" class="material__block-item">';
            html += 'Название документа: ' + material[i]['name'];
            html += ' Путь к файлу: ' + material[i]['file'];
            html += "</div>";
        }
      }
      
      $('.all__materials').val(JSON.stringify(material));
      $('.material__block').html(html);
    }
    

$('.add__material').on('click', function() {
  var name = $('.material__name'),
      file = $('.material__file'),
      obj = {};
      obj.name = name.val();
      obj.file = file.val();
      material.push(obj);
      name.val('');
      file.val('');
      
      renderMaterial();
});
    $('.material__block').on('click', '.material__block-item', function() {
      var id = $(this).attr('data-id');
      material.splice(id, 1);
      renderMaterial();
    });
renderMaterial();

var quess = $quess;
function renderQuess(){
    $('.questions_block').html('');
    let i = 0;
    quess.forEach((e) => {
        $('.questions_block').append(`
            <div data-id="`+ i++ +`" class="questions_item">Вопрос: `+ e.title +`;<br>Формат ответа: `+ e.body +`
            </div>
        `);
    });
    $('#skilltrainingstasks-questions').val(JSON.stringify(quess))
}
renderQuess();
$('#add_question').on('click', function() {
  var   title = $('#questions_title'),
        body = $('#questions_body'),
        obj = {};
  obj.title = title.val();
  obj.body = body.val();
  obj.answer = '';
  quess.push(obj);
  title.val('');
  body.val('');
  renderQuess();
});
$('.questions_block').on('click', '.questions_item', function() {
  quess.splice($(this).attr('data-id'), 1);
  renderQuess();
});

JS;
$this->registerJs($js);


?>

<div class="skill-trainings-tasks-form">

    <?= Html::beginForm('', '', ['class' => 'info_id']) ?>
    <input type="hidden" name="id" class="id_Info" value="">
    <?= Html::endForm(); ?>

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'training_id')->dropDownList($traArr, ['class' => 'form-control chosen-select']) ?>

    <?php Pjax::begin(['id' => 'pjaxReloads']) ?>
    <?php $id = $_GET['id'];
    if (!empty($id)) {
        $block = \common\models\SkillTrainingsBlocks::find()->where(['training_id' => $id])->asArray()->all();
        $arrBlock = [];
        if (!empty($block)) {
            foreach ($block as $item)
                $arrBlock[$item['id']] = $item['name'];
        }
    } else {
        $arrBlock = [];
    }
    ?>
    <?= $form->field($model, 'block_id')->dropDownList($arrBlock, ['class' => 'form-control chosen-select']) ?>
    <?php Pjax::end(); ?>

    <?= $form->field($model, 'sort_order')->input('number', ['placeholder' => 'Порядок вывода']) ?>

    <?= $form->field($model, 'content')->widget(CKEditor::className(), ['editorOptions' => ElFinder::ckeditorOptions('elfinder'),]); ?>

    <div>
        <div class="material__block" style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap">
            <div class="material__block-item" style="background-color: rgba(224,220,220,0.66); font-size: 14px; padding: 5px; cursor: pointer;">
                Название: Инструкция; Путь: /uploads/Material/articles.sql.
            </div>
        </div>
        <div style="display: flex; " class="add__materials">
            <label style="width: 100%" class="form-group">
                Добавить материал
                <input type="text" name="material__name" class="form-control material__name" placeholder="Чек лист">
            </label>
            <label style="width: 100%; display: flex; align-self: end" class="form-group">
                <?= InputFile::widget([
                    'language' => 'ru',
                    'controller' => 'elfinder', // вставляем название контроллера, по умолчанию равен elfinder
                    'filter' => '',    // фильтр файлов, можно задать массив фильтров https://github.com/Studio-42/elFinder/wiki/Client-configuration-options#wiki-onlyMimes
                    'name' => 'material__file',
                    'value' => '',
                    'options' => ['class' => 'form-control material__file', 'placeholder' => 'Файл материала'],
                    'buttonOptions' => ['class' => 'btn btn-admin', 'style' => 'padding: 6px 15px'],
                    'buttonName' => 'Выбрать',
                ]); ?>
            </label>
        </div>
        <button type="button" style="margin-bottom: 10px;" class="btn btn-admin-help add__material">Добавить материал
        </button>
    </div>

    <?= $form->field($model, 'materials')->textarea(['class' => 'form-control all__materials', 'placeholder' => 'https://www.youtube.com/watch?v=-FVu9EutRdk&ab_channel=BurgerChannel', 'rows' => 7, 'readonly' => true]) ?>

    <style>
        .questions {
            margin-bottom: 15px;
        }

        .questions_block {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            align-items: center;
            margin-bottom: 10px;
        }

        .questions_item {
            padding: 8px;
            background-color: #dbdbdb;
            border-radius: 8px;
            cursor: pointer;
        }
    </style>

    <?= $form->field($model, 'questions')->textarea(['rows' => 7, 'readonly' => true]) ?>

    <div class="questions">
        <div class="questions_block"></div>
        <div class="questions_form">
            <div class="form-group">
                <label class="control-label" for="">Вопрос</label>
                <input class="form-control" type="text" id="questions_title" placeholder="Как долго вы связаты с БФЛ?">
            </div>
            <div class="form-group">
                <label class="control-label" for="">Формат ответа</label>
                <?= CKEditor::widget([
                    'name' => 'questions_body',
                    'id' => 'questions_body',
                    'editorOptions' => ElFinder::ckeditorOptions('elfinder')
                ]); ?>
            </div>
            <button type="button" id="add_question" class="btn btn-admin-help">Добавить вопрос</button>
        </div>
    </div>

    <?= $form->field($model, 'date')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-admin']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>