<?php

use mihaildev\ckeditor\CKEditor;
use mihaildev\elfinder\ElFinder;
use mihaildev\elfinder\InputFile;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\SkillTrainingsAuthors */
/* @var $form yii\widgets\ActiveForm */


$js = <<<JS
var obj = JSON.parse($('#specs-area').text());
function render() {
    var html = '';
    for (var i = 0; i < obj.length; i++){
        html += "<div class='destroy-spec' data-id='"+ i +"'>"+ obj[i] +"</div>";
    }
    $('.specs').html(html);
    $('#specs-area').text(JSON.stringify(obj));
}
$('.add-spec-btn').on('click', function() {
    var val = $('.add-spec').val();
    if(val.length > 0 && obj.indexOf(val) === -1)
        obj.push(val); 
    render();
});
$('.specs').on('click', '.destroy-spec',  function() {
  var
        index = $(this).attr('data-id');
    obj.splice(index, 1);
    render();
});
render();
JS;
$this->registerJs($js);
?>
<style>
    .specs{
        display: flex;
        flex-wrap: wrap;
        margin-bottom: 15px
    }
    .destroy-spec {
        margin-right: 10px;
        background-color: #fafafa;
        border: 1px solid gainsboro;
        padding: 5px 10px;
        border-radius: 6px;
        cursor: pointer;
        margin-top: 10px;

    }
</style>
<div class="skill-trainings-authors-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true, 'placeholder' => 'Василий Артин', 'id' => 'textToLink']) ?>

    <?= $form->field($model, 'link')->textInput(['maxlength' => true, 'placeholder' => 'vasilii-artin', 'id' => 'linkText']) ?>

    <?= $form->field($model, 'small_description')->textInput(['maxlength' => true, 'placeholder' => 'Генеральный директор ООО ФЭС, руководитель образовательных программ']) ?>

    <?= $form->field($model, 'practice')->textInput(['type' => 'number','maxlength' => true, 'placeholder' => 'Опыт автора']) ?>

    <?= $form->field($model, 'photo')->widget(InputFile::className(), [
        'language'      => 'ru',
        'controller'    => 'elfinder', // вставляем название контроллера, по умолчанию равен elfinder
        'path' => 'image', // будет открыта папка из настроек контроллера с добавлением указанной под деритории
        'filter'        => 'image',    // фильтр файлов, можно задать массив фильтров https://github.com/Studio-42/elFinder/wiki/Client-configuration-options#wiki-onlyMimes
        'template'      => '<div class="input-group">{input}<span class="input-group-btn">{button}</span></div>',
        'options'       => ['class' => 'form-control', 'placeholder' => 'Фото'],
        'buttonOptions' => ['class' => 'btn btn-admin', 'style' => 'padding: 6px 15px'],
        'buttonName' => 'Выбрать',
        'multiple'      => false       // возможность выбора нескольких файлов
    ]); ?>

    <?= $form->field($model, 'about')->widget(CKEditor::className(), ['editorOptions' => ElFinder::ckeditorOptions('elfinder'),]); ?>

    <div style="margin-bottom: 5px"><b>Добавить специализации</b></div>
    <div style="display: flex; flex-wrap: wrap; ">
        <div style="margin-right: 10px;">
            <input type="text" class="form-control add-spec" placeholder="Маркетинг">
        </div>
        <div>
            <div class="btn btn-admin-help add-spec-btn">Добавить</div>
        </div>
    </div>
    <div class="specs">

    </div>

    <div style="display: none">
        <?= $form->field($model, 'specs')->textarea(['rows' => 6, 'readonly' => true, 'value' => empty($model->specs) ? '[]' : $model->specs, 'id' => 'specs-area']) ?>
    </div>

    <?= $form->field($model, 'video')->textInput(['maxlength' => true, 'placeholder' => 'https://www.youtube.com/watch?v=WXQCo9fLYWI&ab_channel=h3h3Productions']) ?>

    <?= $form->field($model, 'comment_article')->textInput(['maxlength' => true, 'placeholder' => 'Не надо бояться начать новую жизнь!']) ?>

    <?= $form->field($model, 'comment_text')->textInput(['maxlength' => true, 'placeholder' => 'Каждый день мы делаем выбор, идти вперед или оглядывать в прошлое. Я помогу вам изменить ваше будущее, стоит только начать!']) ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-admin']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
