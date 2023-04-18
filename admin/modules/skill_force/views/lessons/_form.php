<?php

use mihaildev\ckeditor\CKEditor;
use mihaildev\elfinder\ElFinder;
use mihaildev\elfinder\InputFile;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\SkillTrainingsLessons */
/* @var $form yii\widgets\ActiveForm */


$trainings = \common\models\SkillTrainings::find()->select(['name', 'id'])->asArray()->all();
$traArr = [];
if(!empty($trainings)) {
    foreach ($trainings as $item)
        $traArr[$item['id']] = $item['name'];
}

$first = empty($model->training_id) ? array_key_first($traArr) : $model->training_id;

if(empty($first))
    $blocks = \common\models\SkillTrainingsBlocks::find()->select(['name', 'id'])->asArray()->all();
else
    $blocks = \common\models\SkillTrainingsBlocks::find()->select(['name', 'id'])->where(['training_id' => $first])->asArray()->all();
$blArr = [];
if(!empty($blocks)) {
    foreach ($blocks as $item)
        $blArr[$item['id']] = $item['name'];
}

$material = $model->material;
if (!empty($material)){
    $materials = $material;
} else {
    $materials = '[]';
}

$videoInfo = $model->video;
if (!empty($videoInfo))
    $video = $videoInfo;
else
    $video = '[]';

$this->registerCssFile(Url::to(['/css/chosen.min.css']));
$this->registerJsFile(Url::to(['/js/chosen.jquery.min.js']), ['depends' => \yii\web\JqueryAsset::class]);
$js = <<<JS
$(".chosen-select").chosen({disable_search_threshold: 5});
$('.change-lesson').on('change', function() {
    var id = $(this).val();
    $.ajax({
        url: 'get-blocks',
        data: {id:id},
        type: "POST",
    }).done(function(html) {
        $('.replaceBlocks').html(html);
        $('.chosen-select').trigger('chosen:updated');
    });
});

var material = $materials;
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

var videoArr = $video;
function renderVideo(){
    let i = 0;
    $('.videoBlock').html('');
    videoArr.forEach((e) => {
        $('.videoBlock').append(`
            <div class="videoBtn" data-id="`+ i++ +`" style="background-color: #dcdcdc; padding: 5px; border-radius: 5px; max-width: fit-content; cursor: pointer">`
                + e +
            `</div>
        `);
    });
    $('#videoInfo').val(JSON.stringify(videoArr));
}
renderVideo();

$('.videoBlock').on('click', '.videoBtn', function() {
    let info = $(this).attr('data-id');
    videoArr.splice(info, 1);
    renderVideo();
});
$('.addVideo').on('click', function() {
  var input = $('#video-link');
  videoArr.push(input.val());
  input.val('');
  renderVideo();
});

JS;
$this->registerJs($js);

?>

<div class="skill-trainings-lessons-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true, 'placeholder' => 'Эффективные методы определения целевой аудитории', 'id' => 'textToLink']) ?>

    <?= $form->field($model, 'lesson_link')->textInput(['maxlength' => true, 'placeholder' => 'effektivnye-metody-opredeleniya-celevoi-auditorii', 'id' => 'linkText']) ?>

    <?= $form->field($model, 'training_id')->dropDownList($traArr, ['class' => 'form-control chosen-select change-lesson']) ?>

    <?= $form->field($model, 'block_id')->dropDownList($blArr, ['class' => 'form-control chosen-select replaceBlocks']) ?>

    <?= $form->field($model, 'sort_order')->input('number', ['placeholder' => 'На пример: 1']) ?>

    <?= $form->field($model, 'main_text')->widget(CKEditor::className(), ['editorOptions' => ElFinder::ckeditorOptions('elfinder'),]); ?>

    <?= $form->field($model, 'video')->textarea(['placeholder' => 'https://www.youtube.com/watch?v=-FVu9EutRdk&ab_channel=BurgerChannel', 'readonly' => true, 'id' => 'videoInfo']) ?>

    <div>
        <div style="display: flex; gap: 10px; flex-wrap: wrap" class="form-group videoBlock"></div>
        <div style="display: flex; flex-direction: row; column-gap: 15px" class="form-group">
            <input class="form-control" placeholder="https://www.youtube.com/watch?v=-FVu9EutRdk&ab_channel=BurgerChannel" id="video-link" type="text">
            <button class="btn btn-admin-help addVideo" type="button">Добавить видео</button>
        </div>
    </div>

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
        <button type="button" style="margin-bottom: 10px;" class="btn btn-admin-help add__material">Добавить материал</button>
    </div>

    <?= $form->field($model, 'material')->textarea(['class' => 'form-control all__materials', 'placeholder' => 'https://www.youtube.com/watch?v=-FVu9EutRdk&ab_channel=BurgerChannel', 'rows' => 7, 'readonly' => true]) ?>

    <?= $form->field($model, 'content')->widget(CKEditor::className(), ['editorOptions' => ElFinder::ckeditorOptions('elfinder'),]); ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-admin']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
