<?php

use mihaildev\elfinder\ElFinder;
use mihaildev\elfinder\InputFile;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model common\models\SkillTrainingsTests */
/* @var $form yii\widgets\ActiveForm */


$trainings = \common\models\SkillTrainings::find()->select(['name', 'id'])->asArray()->all();

$traArr = [];
if (!empty($trainings)) {
    foreach ($trainings as $item)
        $traArr[$item['id']] = $item['name'];
}

$renderQuess = \common\models\SkillTrainingsTests::find()->asArray()->where(['id' => $model->id])->select('content')->all();

if (!empty($renderQuess[0]['content'])){
    $content = $renderQuess[0]['content'];
} else {
    $content = '[]';
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
    $('.field-skilltrainingstests-training_id').on('click', '.active-result' ,function(e) {
      var id = $('#skilltrainingstests-training_id').val();
      $('.id_Info').val(id);
      $('.info_id').submit();
    });
    
    /* Переключение типов вопросов */
    $('select[name="test_type"]').on('input', function() {
      var type = $(this).val();
      $(".type__blocks").fadeOut(300, function() {
        if (type === 'text'){
            $('.text--block').fadeIn(300);
        } else if (type === 'select__list') {
            $('.select__list--block').fadeIn(300);
        } else if (type === 'sort__answers'){
            $('.sort__answers--block').fadeIn(300);
        } else {
            $('.correlate--block').fadeIn(300);
        }
      });
    });
    /* Переключение типов вопросов */
    
    /* Выбрать из списка */
    $('select[name="select_list_type"]').on('input', function() {
      var type = $(this).val();
      $('.select_list-type').fadeOut(300, function() {
        if (type === 'text'){
            $('.select_list_type-text').fadeIn(300);
        } else {
            $('.select_list_type-photo').fadeIn(300);
        }
      });
    });
    function renderSelectList() {
      var html = '';
      if (quess.length > 0){
          for (var i = 0; i < quess.length; i++) {
            html += '<div data-id="'+ i +'" style="font-size: 16px; background-color: rgba(167,167,167,0.56); padding: 5px; cursor: pointer; max-width: fit-content" class="select__lict--block--answer-item">';
            html += quess[i]['answerText'] + ' Правильный: ';
            html += quess[i]['correct'];
            html += "</div>";
        }
      }
      $('.select__lict--block--answer').html(html);
    }
    var quess = [];
    $('.select_list_addQuess').on('click', function() {
      var correct = $('input[name="select_list_type-text-correct"]:checked'),
          answerText = $('input[name="select_list_type_text"]'),
          answerPhoto = $('input[name="select_list_type-photo"]'),
          type = $('select[name="select_list_type"]'),
          selectListQuess = {};
      if (type.val() === 'text'){
          selectListQuess.type = type.val();
          selectListQuess.answerText = answerText.val();
          selectListQuess.correct = correct.val();
      } else {
          selectListQuess.type = type.val();
          selectListQuess.answerText = answerPhoto.val();
          selectListQuess.correct = correct.val();
      }
      quess.push(selectListQuess);
      answerText.val('');
      answerPhoto.val('');
      renderSelectList();
    });
    $('.select__lict--block--answer').on('click', '.select__lict--block--answer-item', function() {
      var id = $(this).attr('data-id');
      quess.splice(id, 1);
      renderSelectList();
    });
    /* Выбрать из списка */
    
    /* Упорядочить ответы */
    var sort = [];
    $('select[name="sort__answers_type"]').on('input', function() {
      var type = $(this).val();
      $('.sort__answers--type').fadeOut(300, function() {
        if (type === 'text'){
            $('.sort__answers_type-text').fadeIn(300);
        } else {
            $('.sort__answers_type-photo').fadeIn(300);
        }
      });
    });
    function renderSortList() {
      var html = '';
      if (sort.length > 0){
          for (var i = 0; i < sort.length; i++) {
            html += '<div data-id="'+ i +'" style="font-size: 16px; background-color: rgba(167,167,167,0.56); padding: 5px; cursor: pointer; max-width: fit-content" class="sort__answers--block--answer-item">';
            html += sort[i]['answerText'];
            html += "</div>";
        }
      }
      $('.sort__answers--block--answer').html(html);
    }
    $('.sort__answers--addSort').on('click', function() {
      var sortText = $('input[name="sort__answers_type_text"]'),
          sortPhoto = $('input[name="sort__answers_type-photo"]'),
          type = $('select[name="sort__answers_type"]'),
          sortListQuess = {};
      if (type.val() === 'text'){
          sortListQuess.type = type.val();
          sortListQuess.answerText = sortText.val();
      } else {
          sortListQuess.type = type.val();
          sortListQuess.answerText = sortPhoto.val();
      }
      sort.push(sortListQuess);
      sortText.val('');
      sortPhoto.val('');
      renderSortList();
    });
    $('.sort__answers--block--answer').on('click', '.sort__answers--block--answer-item', function() {
      var id = $(this).attr('data-id');
      sort.splice(id, 1);
      renderSortList();
    });
    /* Упорядочить ответы */
    
    /* Соотнести ответы */
    function renderCategory() {
      var html = '',
          option = '';
      if (category.length > 0){
          for (var i = 0; i < category.length; i++) {
            html += '<div data-id="'+ i +'" style="font-size: 16px; background-color: rgba(167,167,167,0.56); padding: 5px; cursor: pointer; max-width: fit-content" class="correlate--block--category-item--category">';
            html += category[i];
            html += "</div>";
            option += '<option value="'+ category[i] +'">'+ category[i] +'</option>';
        }
      }
      $('select[name="correlate--block--quess-select"]').html(option);
      $('.correlate--block--category').html(html);
    }
    var category = [];
    $('.correlate__addCategory').on('click', function() {
      var categoryName = $('input[name="correlate--block--category-input"]');
      category.push(categoryName.val());
      renderCategory();
      categoryName.val('');
    });
    $('.correlate--block--category').on('click', '.correlate--block--category-item--category', function() {
      var id = $(this).attr('data-id');
      category.splice(id, 1);
      renderCategory();
    });
    
    function renderCorrelateQuess() {
      var html = '';
      if (correlateQuess.length > 0){
          for (var i = 0; i < correlateQuess.length; i++) {
            html += '<div data-id="'+ i +'" style="font-size: 16px; background-color: rgba(167,167,167,0.56); padding: 5px; cursor: pointer; max-width: fit-content" class="correlate--block--quess-item">';
            html += correlateQuess[i]['quess'] + ', Категория: ';
            html += correlateQuess[i]['category'] + ', Тип: ';
            html += correlateQuess[i]['type'];
            html += "</div>";
          }
      }
      $('.correlate--block--quess').html(html);
    }
    var correlateQuess = [];
    $('.correlate__addQuess').on('click', function() {
      var quess = $('input[name="correlate--block--quess-input"]'),
          categoryItem = $('select[name="correlate--block--quess-select"]'),
          type = $('select[name="correlate--block--type-select"]'),
          arrQuess = {};
      arrQuess.quess = quess.val();
      arrQuess.category = categoryItem.val();
      arrQuess.type = type.val();
      correlateQuess.push(arrQuess);
      renderCorrelateQuess();
      quess.val('');
    });
    $('.correlate--block--quess').on('click', '.correlate--block--quess-item', function() {
      var id = $(this).attr('data-id');
      correlateQuess.splice(id, 1);
      renderCorrelateQuess();
    });
    /* Соотнести ответы */
    
    /* Сохранение вопроса */
    function renderAllQuess() {
       var html = '';
      if (arrAllQuess.length > 0){
          for (var i = 0; i < arrAllQuess.length; i++) {
            html += '<div data-id="'+ i +'" style="font-size: 10px; background-color: rgba(167,167,167,0.56); padding: 5px; cursor: pointer; max-width: fit-content" class="quess__block--item">';
            html += 'Вопрос: ' + arrAllQuess[i]['quess'];
            html += ' Тип вопроса: ' + arrAllQuess[i]['type'];
            html += "</div>";
          }
      }
      $('.quess__block').html(html);
      $('input[name="quess__text"]').val('');
      quess = [];
      sort = [];
      category = [];
      correlateQuess = [];
      renderSortList();
      renderSelectList();
      renderCategory();
      renderCorrelateQuess();
      allQuess = JSON.stringify(arrAllQuess);
      $('#skilltrainingstests-content').text(allQuess);
    }
    var allQuess = {},
        arrAllQuess = $content;
    $('.saveQuess').on('click', function() {
        var type = $('select[name="test_type"]'),
            quessText = $('input[name="quess__text"]'),
            arr = {};
        arr.quess = quessText.val();
        arr.type = type.val();
        if (type.val() === 'text'){
            arr.answer = $('input[name="answer__text"]').val();
        } else if (type.val() === 'select__list') {
            arr.answer = quess;
        } else if (type.val() === 'sort__answers') {
            arr.answer = sort;
        } else {
            arr.answer = correlateQuess;
        }
        arrAllQuess.push(arr);
        renderAllQuess();
    });
    $('.quess__block').on('click', '.quess__block--item', function() {
      var id = $(this).attr('data-id');
      arrAllQuess.splice(id, 1);
      renderAllQuess();
    })
    /* Сохранение вопроса */
    console.log(arrAllQuess);
    renderAllQuess();
JS;
$this->registerJs($js);
?>

<div class="skill-trainings-tests-form">
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

    <?= $form->field($model, 'name')->textInput(['placeholder' => 'Название теста']) ?>

    <?= $form->field($model, 'sort_order')->input('number', ['placeholder' => 'Порядок отображения в блоке', 'min' => 0]) ?>

    <?= $form->field($model, 'max_tries')->textInput(['type' => 'number', 'placeholder' => 'Количество попыток']) ?>

    <?= $form->field($model, 'content')->textarea(['rows' => 6, 'readonly' => true]) ?>

    <div>

        <div class="form-group">
            <label>Вопросы</label>
            <div class="quess__block" style="display:flex; gap: 5px; flex-wrap: wrap">
                <div class="quess__block--item"
                     style="font-size: 10px; background-color: rgba(175,171,171,0.63); padding: 5px; cursor: pointer">
                    Вопрос: Какой фрукт вы любите? Вид ответа: text. Ответ: Яблоко
                </div>
            </div>
        </div>


        <div class="form-group">
            <label for="quess__text" class="control-label">Текст вопроса</label>
            <input class="form-control" type="text" id="quess__text"
                   placeholder="На пример: Какой ответ является правильным?" name="quess__text">
        </div>
        <div class="form-group">
            <label for="test_type" class="control-label">Вид ответа</label>
            <select class="form-control" id="test_type" name="test_type">
                <option value="text">Текст</option>
                <option value="select__list">Выбрать из списка</option>
                <option value="sort__answers">Упорядочить ответы</option>
                <option value="correlate">Соотнести текст</option>
                <option value="correlate__image">Соотнести изображения</option>
            </select>
        </div>

        <div style="display: block" class="type__blocks text--block">
            <div class="form-group">
                <label for="answer__text" class="control-label">Введите правильный ответ</label>
                <input type="text" class="form-control" placeholder="На пример: Избавление должника от долгов"
                       name="answer__text" id="answer__text">
            </div>
        </div>

        <div style="display: none" class="type__blocks select__list--block">
            <div class="form-group">
                <label for="select__list--type" class="control-label">Выберите тип</label>
                <select class="form-control" name="select_list_type" id="select__list--type">
                    <option value="text">Текст</option>
                    <option value="photo">Фото</option>
                </select>
            </div>
            <div style="margin-bottom: 15px; display: flex; gap: 10px; align-items: center; flex-wrap: wrap"
                 class="select__lict--block--answer">
                <div style="font-size: 16px; background-color: rgba(167,167,167,0.56); padding: 5px; cursor: pointer; max-width: fit-content"
                     class="select__lict--block--answer-item">
                    Вопрос номер 1
                </div>
            </div>
            <div class="select_list-type form-group select_list_type-text">
                <input type="text" placeholder="Введите текст" name="select_list_type_text" class="form-control">
            </div>
            <div style="display: none" class="select_list-type form-group select_list_type-photo">
                <?= InputFile::widget([
                    'language' => 'ru',
                    'controller' => 'elfinder', // вставляем название контроллера, по умолчанию равен elfinder
                    'filter' => 'image',    // фильтр файлов, можно задать массив фильтров https://github.com/Studio-42/elFinder/wiki/Client-configuration-options#wiki-onlyMimes
                    'name' => 'select_list_type-photo',
                    'template' => '<div class="input-group">{input}<span class="input-group-btn">{button}</span></div>',
                    'options' => ['class' => 'form-control', 'placeholder' => 'Выберите фото-ответ'],
                    'buttonOptions' => ['class' => 'btn btn-admin', 'style' => 'padding: 6px 15px'],
                    'buttonName' => 'Выбрать',
                    'value' => '',
                ]); ?>
            </div>
            <div class="form-group">
                <label for="select_list_type-text-correct-true" class="control-label">Правильный</label>
                <input type="radio" name="select_list_type-text-correct" value="true"
                       id="select_list_type-text-correct-true">
                <label for="select_list_type-text-correct-false" class="control-label">Не правильный</label>
                <input type="radio" name="select_list_type-text-correct" value="false"
                       id="select_list_type-text-correct-false">
            </div>
            <div class="form-group">
                <button type="button" class="btn btn-primary select_list_addQuess">Добавить ответ</button>
            </div>
        </div>

        <div style="display: none" class="type__blocks sort__answers--block">
            <div style="max-width: 100%; margin-bottom: 5px; font-weight: 700; color: red">Введите или прикрепите
                варианты ответов в правильной последовательности
            </div>
            <div class="form-group">
                <label for="sort__answers--type" class="control-label">Выберите тип</label>
                <select class="form-control" name="sort__answers_type" id="sort__answers--type">
                    <option value="text">Текст</option>
                    <option value="photo">Фото</option>
                </select>
            </div>
            <div style="margin-bottom: 15px; gap: 10px; display: flex; align-items: center; flex-wrap: wrap"
                 class="sort__answers--block--answer">
                <div style="font-size: 16px; background-color: rgba(167,167,167,0.56); padding: 5px; cursor: pointer; max-width: fit-content"
                     class="sort__answers--block--answer-item">
                    Вопрос номер 1
                </div>
            </div>
            <div class="form-group sort__answers--type sort__answers_type-text">
                <input type="text" placeholder="Введите текст" name="sort__answers_type_text" class="form-control">
            </div>
            <div style="display: none" class="form-group sort__answers--type sort__answers_type-photo">
                <?= InputFile::widget([
                    'language' => 'ru',
                    'controller' => 'elfinder', // вставляем название контроллера, по умолчанию равен elfinder
                    'filter' => 'image',    // фильтр файлов, можно задать массив фильтров https://github.com/Studio-42/elFinder/wiki/Client-configuration-options#wiki-onlyMimes
                    'name' => 'sort__answers_type-photo',
                    'template' => '<div class="input-group">{input}<span class="input-group-btn">{button}</span></div>',
                    'options' => ['class' => 'form-control', 'placeholder' => 'Выберите фото-ответ'],
                    'buttonOptions' => ['class' => 'btn btn-admin', 'style' => 'padding: 6px 15px'],
                    'buttonName' => 'Выбрать',
                    'value' => '',
                ]); ?>
            </div>
            <div class="form-group">
                <button type="button" class="btn btn-primary sort__answers--addSort">Добавить ответ</button>
            </div>
        </div>

        <div style="display: none" class="type__blocks correlate--block">
            <div style="margin-bottom: 15px; display: flex; align-items: center; gap:10px; flex-wrap: wrap"
                 class="correlate--block--category">
                <div style="font-size: 16px; background-color: rgba(167,167,167,0.56); padding: 5px; cursor: pointer; max-width: fit-content"
                     class="correlate--block--category-item--category">
                    Категория 1
                </div>
            </div>
            <div class="form-group">
                <label for="correlate--block--category-input" class="control-label">Введите названия категорий, к
                    которым необходимо соотнести варианты ответов </label>
                <input type="text" placeholder="На пример: БФЛ" id="correlate--block--category-input"
                       name="correlate--block--category-input" class="form-control">
            </div>
            <div class="form-group">
                <button type="button" class="btn btn-primary correlate__addCategory">Добавить категорию</button>
            </div>
            <div style="margin-bottom: 15px; display: flex; gap: 10px; align-items: center; flex-wrap: wrap"
                 class="correlate--block--quess">
                <div style="font-size: 16px; background-color: rgba(167,167,167,0.56); padding: 5px; cursor: pointer; max-width: fit-content"
                     class="correlate--block--quess-item">
                    Вопрос номер 1
                </div>
            </div>
            <div class="form-group">
                <label for="correlate--block--type-select" class="control-label">Выберите тип ответа</label>
                <select name="correlate--block--type-select" id="correlate--block--type-select" class="form-control">
                    <option value="text">Текст</option>
                    <option value="photo">Фото</option>
                </select>
            </div>
            <div class="form-group">
                <label for="correlate--block--category-input" class="control-label">Введите или загрузите варианты
                    ответов и укажите к каким указанным выше категориям они относятся</label>
                <div class="form-group correlate--block--category-input">
                    <?= InputFile::widget([
                        'language' => 'ru',
                        'controller' => 'elfinder', // вставляем название контроллера, по умолчанию равен elfinder
                        'filter' => 'image',    // фильтр файлов, можно задать массив фильтров https://github.com/Studio-42/elFinder/wiki/Client-configuration-options#wiki-onlyMimes
                        'name' => 'correlate--block--quess-input',
                        'template' => '<div class="input-group">{input}<span class="input-group-btn">{button}</span></div>',
                        'options' => ['class' => 'form-control', 'placeholder' => 'Выберите фото-ответ или введите текст'],
                        'buttonOptions' => ['class' => 'btn btn-admin', 'style' => 'padding: 6px 15px'],
                        'buttonName' => 'Выбрать',
                        'value' => '',
                    ]); ?>
                </div>
            </div>
            <div class="form-group">
                <label for="correlate--block--category-item" class="control-label">Категория</label>
                <select id="correlate--block--category-item" name="correlate--block--quess-select"
                        class="form-control">
                </select>
            </div>
            <div class="form-group">
                <button type="button" class="btn btn-primary correlate__addQuess">Добавить ответ</button>
            </div>
        </div>

        <div class="form-group">
            <button type="button" class="btn btn-success saveQuess">Сохранить вопрос</button>
        </div>

    </div>

    <?= $form->field($model, 'date')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-admin']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
