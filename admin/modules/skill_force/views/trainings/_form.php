<?php

use kartik\datetime\DateTimePicker;
use mihaildev\ckeditor\CKEditor;
use mihaildev\elfinder\ElFinder;
use mihaildev\elfinder\InputFile;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\SkillTrainings */
/* @var $form yii\widgets\ActiveForm */

$authors = \common\models\SkillTrainingsAuthors::find()->select(['name', 'id'])->asArray()->all();
$aArr = [];
if (!empty($authors)) {
    foreach ($authors as $item)
        $aArr[$item['id']] = $item['name'];
}

$cats = \common\models\SkillTrainingsCategory::find()->select(['name', 'id'])->asArray()->all();
$catsArr = [];
if (!empty($cats)) {
    foreach ($cats as $item)
        $catsArr[$item['id']] = $item['name'];
}

$parts = \common\models\SkillPartners::find()->select(['name', 'link'])->asArray()->all();
$partsArr = [];
if (!empty($parts)) {
    foreach ($parts as $item)
        $partsArr[$item['link']] = $item['name'];
}

$teacher = \common\models\SkillTrainingsTeachers::find()->select(['name', 'id'])->asArray()->all();
$teacherArr = [];
if (!empty($teacher)) {
    foreach ($teacher as $i)
        $teacherArr[$i['id']] = $i['name'];
}

$material = $model->material;
if (!empty($material)){
    $materials = $material;
} else {
    $materials = '[]';
}
$this->registerCssFile(Url::to(['/css/chosen.min.css']));
$this->registerJsFile(Url::to(['/js/chosen.jquery.min.js']), ['depends' => \yii\web\JqueryAsset::class]);
$js = <<<JS
var for_who = JSON.parse($('#FORWHO').val());
var what_study = JSON.parse($('#WHATSTUDY').val());
$(".chosen-select").chosen({disable_search_threshold: 5});
function render() {
    var html = '';
    for (var i = 0; i < for_who.length; i++){
        html += "<div class='destroy-spec' data-id='"+ i +"'>"+ JSON.stringify(for_who[i]) +"</div>";
    }
    $('.for-who-blocks').html(html);
    $('#FORWHO').text(JSON.stringify(for_who));
}
$('.add_forwho').on('click', function() {
    var val1 = $('.forwho_1').val();
    var val2 = $('.forwho_2').val();
    if(val1.length > 0 && val2.length > 0) {
        for_who.push({title: val1, text: val2}); 
        $('.forwho_1').val('');
        $('.forwho_2').val('');
    }
    render();
});
$('.for-who-blocks').on('click', '.destroy-spec',  function() {
  var
        index = $(this).attr('data-id');
    for_who.splice(index, 1);
    render();
});


function render2() {
    var html = '';
    for (var i = 0; i < what_study.length; i++){
        html += "<div class='destroy-spec' data-id='"+ i +"'>"+ JSON.stringify(what_study[i]) +"</div>";
    }
    $('.what-study-blocks').html(html);
    $('#WHATSTUDY').text(JSON.stringify(what_study));
}
$('.add_whatstudy').on('click', function() {
    var val1 = $('.what_study1').val();
    var val2 = $('.what_study2').val();
    if(val1.length > 0 && val2.length > 0) {
        what_study.push({title: val1, text: val2}); 
        $('.what_study1').val('');
        $('.what_study2').val('');
    }
    render2();
});
$('.what-study-blocks').on('click', '.destroy-spec',  function() {
  var
        index = $(this).attr('data-id');
    what_study.splice(index, 1);
    render2();
});
render();
render2();

var teachArr = {},
    ars = [];
$('.add_teacher').on('click', function() {
    ars.push($('.chosen__take').val())
    teachArr.id = JSON.stringify(ars);
    $('.teacher_id').val(teachArr.id);
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

JS;
$this->registerJs($js);

?>
<style>
    .for-who-blocks, .what-study-blocks {
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
<div class="skill-trainings-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true, 'placeholder' => 'Первый миллион на БФЛ', 'id' => 'textToLink']) ?>

    <?= $form->field($model, 'link')->textInput(['maxlength' => true, 'placeholder' => 'pervyi-million-na-bfl', 'id' => 'linkText']) ?>

    <?= $form->field($model, 'type')->dropDownList(['Курс' => 'Курс', 'Интенсив' => 'Интенсив', 'Вебинар' => 'Вебинар',]) ?>

    <?= $form->field($model, 'discount')->input('number', ['placeholder' => '25']) ?>

    <?= $form->field($model, 'students')->input('number', ['placeholder' => '25']) ?>

    <?= $form->field($model, 'author_id')->dropDownList($aArr, ['class' => 'form-control chosen-select']) ?>

    <div style="display: flex; flex-direction: column;">
        <label style="font-weight: normal">
            Добавить преподавателя
            <?= Html::dropDownList('teach_id', 'null', $teacherArr, ['class' => 'form-control chosen-select chosen__take']) ?>
        </label>
        <button class="btn btn-admin-help add_teacher" style="align-self: flex-start" type="button">Добавить</button>
    </div>


    <?= $form->field($model, 'teacher_id')->input('text', ['class' => 'form-control teacher_id']) ?>

    <?= $form->field($model, 'category_id')->dropDownList($catsArr, ['class' => 'form-control chosen-select']) ?>

    <?= $form->field($model, 'partner_link')->dropDownList($partsArr, ['class' => 'form-control chosen-select']) ?>

    <?= $form->field($model, 'tags')->textInput(['maxlength' => true, 'placeholder' => 'Теги через ";": маркетинг; гарантия трудоустройства; продажи ']) ?>

    <?= $form->field($model, 'preview_logo')->widget(InputFile::className(), [
        'language' => 'ru',
        'controller' => 'elfinder', // вставляем название контроллера, по умолчанию равен elfinder
        'filter' => 'image',    // фильтр файлов, можно задать массив фильтров https://github.com/Studio-42/elFinder/wiki/Client-configuration-options#wiki-onlyMimes
        'template' => '<div class="input-group">{input}<span class="input-group-btn">{button}</span></div>',
        'options' => ['class' => 'form-control', 'placeholder' => 'Превью лого'],
        'buttonOptions' => ['class' => 'btn btn-admin', 'style' => 'padding: 6px 15px'],
        'buttonName' => 'Выбрать',
        'multiple' => false       // возможность выбора нескольких файлов
    ]); ?>

    <?= $form->field($model, 'free_lessons')->input('text', ['class' => 'form-control', 'placeholder' => 'https://www.youtube.com/watch?v=-FVu9EutRdk&ab_channel=BurgerChannel']) ?>

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

    <?= $form->field($model, 'content_subtitle')->textInput(['maxlength' => true, 'placeholder' => 'Практические кейсы по увеличению продаж и прибыли']) ?>

    <?= $form->field($model, 'content_about')->widget(CKEditor::className(), ['editorOptions' => ElFinder::ckeditorOptions('elfinder'),]); ?>

    <?= $form->field($model, 'content_block_income')->input('number', ['maxlength' => true, 'placeholder' => 78000]) ?>

    <?= $form->field($model, 'content_block_description')->textInput(['maxlength' => true, 'placeholder' => 'В среднем зарабатывает специалист по таргетированной рекламе среднего уровня']) ?>

    <?= $form->field($model, 'content_block_tags')->textInput(['maxlength' => true, 'placeholder' => 'Поисковые теги через ";": smm; таргет']) ?>
    <hr>
    <div>
        <div style="margin-bottom: 5px"><b>Кому подойдет курс</b></div>
        <div style="">
            <div style="margin-bottom: 10px;"><input type="text" placeholder="Без опыта" class="form-control forwho_1">
            </div>
            <div style="margin-bottom: 10px;"><textarea name="" id="" cols="30" rows="3" class="form-control forwho_2"
                                                        placeholder="Даже если вы никогда не работали в IT, вы получите востребованную и высокооплачиваемую профессию, а мы поможем вам устроиться на крутую работу"></textarea>
            </div>
            <div style="margin-bottom: 10px;">
                <div class="btn btn-admin-help add_forwho">Добавить</div>
            </div>
        </div>
    </div>
    <div class="for-who-blocks">

    </div>
    <hr>
    <div>
        <div style="margin-bottom: 5px"><b>Что изучаем</b></div>
        <div style="">
            <div style="margin-bottom: 10px;"><input type="text" placeholder="Работать в рекламных кабинетах"
                                                     class="form-control what_study1"></div>
            <div style="margin-bottom: 10px;"><textarea name="" id="" cols="30" rows="3"
                                                        class="form-control what_study2"
                                                        placeholder="Запускать рекламные объявления в Facebook, Instagram, ВКонтакте, myTarget"></textarea>
            </div>
            <div style="margin-bottom: 10px;">
                <div class="btn btn-admin-help add_whatstudy">Добавить</div>
            </div>
        </div>
    </div>
    <div class="what-study-blocks">

    </div>
    <hr>

    <div style="display: none">
        <?= $form->field($model, 'content_for_who')->textarea(['rows' => 6, 'readonly' => true, 'value' => empty($model->content_for_who) ? '[]' : $model->content_for_who, 'id' => 'FORWHO']) ?>
        <?= $form->field($model, 'content_what_study')->textarea(['rows' => 6, 'readonly' => true, 'value' => empty($model->content_what_study) ? '[]' : $model->content_what_study, 'id' => 'WHATSTUDY']) ?>
    </div>

    <?= $form->field($model, 'content_terms')->textInput(['maxlength' => true, 'placeholder' => 'Для поступления на курс не требуются профильные знания. За время обучения вы сможете освоить профессию с нуля']) ?>

    <?= $form->field($model, 'student_level')->dropDownList(['Новичок' => 'Новичок', 'Базовый' => 'Базовый', 'Продвинутый' => 'Продвинутый',]) ?>

    <?= $form->field($model, 'price')->input('number', ['placeholder' => '27800']) ?>

    <?= $form->field($model, 'discount_expiration_date')->widget(\yii\jui\DatePicker::classname(), ['options' => ['class' => 'form-control', 'placeholder' => date("d.m.Y", time() + 4 * 3600 * 24),], 'dateFormat' => 'yyyy-MM-dd']) ?>

    <?= $form->field($model, 'date_meetup')->widget(DateTimePicker::className(), [
            'name' => 'dp_2',
            'type' => DateTimePicker::TYPE_COMPONENT_PREPEND,
            'value' => '',
            'options' => [
                'placeholder' => date('d-M-Y H:i'),
            ],
            'pluginOptions' => [
                'autoclose' => true,
                'format' => 'yyyy-m-d H:i'
            ]]
    ) ?>
    <?= $form->field($model, 'date_end')->widget(DateTimePicker::className(), [
            'name' => 'dp_2',
            'type' => DateTimePicker::TYPE_COMPONENT_PREPEND,
            'value' => '',
            'options' => [
                'placeholder' => date('d-M-Y H:i'),
            ],
            'pluginOptions' => [
                'autoclose' => true,
                'format' => 'yyyy-m-d H:i'
            ]]
    ) ?>

    <?= $form->field($model, 'lessons_count')->input('number', ['placeholder' => '18']) ?>

    <?= $form->field($model, 'study_hours')->input('number', ['placeholder' => '36']) ?>

    <hr>

    <?= $form->field($model, 'exist_videos')->checkbox(['checked' => empty($model->exist_videos) || $model->exist_videos === 1 ? true : false, 'style' => 'vertical-align: sub; width: 18px;   height: 18px;']) ?>

    <?= $form->field($model, 'exist_bonuses')->checkbox(['checked' => $model->exist_bonuses === 1 ? true : false, 'style' => 'vertical-align: sub; width: 18px;   height: 18px;']) ?>

    <?= $form->field($model, 'meta_keywords')->textInput(['maxlength' => true, 'placeholder' => 'маркетинг, продажи, курсы']) ?>

    <?= $form->field($model, 'meta_description')->textInput(['maxlength' => true, 'placeholder' => 'Практический курс по маркетингу от FemidaForce для людей, которые хотят большего']) ?>

    <?= $form->field($model, 'og_image')->widget(InputFile::className(), [
        'language' => 'ru',
        'controller' => 'elfinder', // вставляем название контроллера, по умолчанию равен elfinder
        'filter' => 'image',    // фильтр файлов, можно задать массив фильтров https://github.com/Studio-42/elFinder/wiki/Client-configuration-options#wiki-onlyMimes
        'template' => '<div class="input-group">{input}<span class="input-group-btn">{button}</span></div>',
        'options' => ['class' => 'form-control', 'placeholder' => 'OG-картинка'],
        'buttonOptions' => ['class' => 'btn btn-admin', 'style' => 'padding: 6px 15px'],
        'buttonName' => 'Выбрать',
        'multiple' => false       // возможность выбора нескольких файлов
    ]); ?>

    <?= $form->field($model, 'og_title')->textInput(['maxlength' => true, 'placeholder' => 'Курс по маркетингу от FemidaForce']) ?>

    <?= $form->field($model, 'og_description')->textInput(['maxlength' => true, 'placeholder' => 'Практический курс по маркетингу от FemidaForce для людей, которые хотят большего']) ?>

    <?= $form->field($model, 'active')->checkbox() ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-admin']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
