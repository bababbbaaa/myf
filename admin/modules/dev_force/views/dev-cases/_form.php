<?php

use mihaildev\ckeditor\CKEditor;
use mihaildev\elfinder\InputFile;
use mihaildev\elfinder\ElFinder;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
/* @var $this yii\web\View */
/* @var $model common\models\DevCases */
/* @var $form yii\widgets\ActiveForm */

$services = $model->services;
if (empty($services)) $services = '[]';

$result = $model->results;
if (empty($result)) $result = '[]';

$integration = $model->integrations;
if (empty($integration)) $integration = '[]';
$js = <<<JS
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
    $(document).ready(function() {
      $('#titleInput').on('input',function() {
          let j = rus_to_latin($(this).val());
          j = j.replace(/ /g, '-');
          $('#linkArticle').val(j.toLowerCase());
      });
      var services      = $services;
      var result        = $result;
      var integration   = $integration;
      console.log(integration);
      function renderServices(){
        var html = '';
        if (services.length > 0) {
            for (var i = 0; i < services.length; i++) {
                html += "<div class='DevServices__item block-item' data-id='"+ i +"'>";
                html += services[i];
                html += "</div>";
            }
            $('.DevServices__block').html(html);
            $('#devcases-services').text(JSON.stringify(services));
        }
      }
      $('.add_services').on('click', function() {
        var servicesInfo = $('input[name="services"]');
          services.push(servicesInfo.val());
          servicesInfo.val('');
          renderServices();
      });
      $('.DevServices__block').on('click', '.DevServices__item', function() {
        var id = $(this).attr('data-id');
         services.splice(id, 1);
         renderServices();
      });
      function renderResult(){
        var html = '';
        if (result.length > 0) {
            for (var i = 0; i < result.length; i++) {
                html += "<div class='DevResults__item block-item' data-id='"+ i +"'>";
                html += result[i].name + ' - ' + result[i].val;
                html += "</div>";
            }
            $('.DevResults__block').html(html);
            $('#devcases-results').text(JSON.stringify(result));
        }
      }
      $('.add_result').on('click', function() {
        var resultName = $('input[name="results"]'),
            resultVal  = $('input[name="results-number"]'),
            obj        = {};
            obj.name = resultName.val();
            obj.val = resultVal.val();
            result.push(obj);
            resultName.val('');
            resultVal.val('');
            renderResult();
      });
      $('.DevResults__block').on('click', '.DevResults__item', function() {
        var id = $(this).attr('data-id');
         result.splice(id, 1);
         renderResult();
      });    
      
      function renderIntegration(){
        var html = '';
        if (integration.length > 0) {
            for (var i = 0; i < integration.length; i++) {
                html += "<div class='DevIntegration__item block-item' data-id='"+ i +"'>";
                html += integration[i].image + '; ' + integration[i].name + '; ' + integration[i].desc;
                html += "</div>";
            }
            $('.DevIntegration__block').html(html);
            $('#devcases-integrations').text(JSON.stringify(integration));
        }
      }
      $('.add_integration').on('click', function() {
        var integrationImage = $('input[name="integration-image"]'),
            integrationName  = $('input[name="integration-name"]'),
            integrationDesc  = $('input[name="integration-desc"]'),
            obj        = {};
            obj.image = integrationImage.val();
            obj.name = integrationName.val();
            obj.desc = integrationDesc.val();
            integration.push(obj);
            integrationImage.val('');
            integrationName.val('');
            integrationDesc.val('');
            renderIntegration();
      });
      $('.DevIntegration__block').on('click', '.DevIntegration__item', function() {
        var id = $(this).attr('data-id');
         integration.splice(id, 1);
         renderIntegration();
      });
      renderServices();
      renderResult();
      renderIntegration();
    });
JS;
$this->registerJs($js);

$css =<<< CSS
.block-cases{
    margin: 20px 0;
    border: 1px solid #433f38;
    padding: 10px;
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    gap: 10px;
}
.block-item{
    padding: 5px;
    background-color: #e7e7e7;
    max-width: fit-content;
    cursor: pointer;
}
CSS;
$this->registerCss($css);
?>

<div class="dev-cases-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'logo')->widget(InputFile::className(), [
        'language' => 'ru',
        'controller' => 'elfinder', // вставляем название контроллера, по умолчанию равен elfinder
        'filter' => '',    // фильтр файлов, можно задать массив фильтров https://github.com/Studio-42/elFinder/wiki/Client-configuration-options#wiki-onlyMimes
        'name' => 'material__file',
        'value' => '',
        'template' => '<div class="input-group">{input}<span class="input-group-btn">{button}</span></div>',
        'options' => ['class' => 'form-control material__file', 'placeholder' => 'Логотип кампании'],
        'buttonOptions' => ['class' => 'btn btn-admin', 'style' => 'padding: 6px 15px'],
        'buttonName' => 'Выбрать',
    ]); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true, 'placeholder' => 'На пример: Юридическая служба Правозащитник', 'id' => 'titleInput']) ?>

    <?= $form->field($model, 'link')->textInput(['maxlength' => true, 'id' => 'linkArticle', 'placeholder' => 'uridicheskaya-slujba-pravozashchitnik']) ?>

    <?= $form->field($model, 'description_works')->textInput(['maxlength' => true, 'placeholder' => 'Корпоративный сайт  с возможностью онлайн банкротства через личный кабинет']) ?>

    <?= $form->field($model, 'fone_img')->widget(InputFile::className(), [
        'language' => 'ru',
        'controller' => 'elfinder', // вставляем название контроллера, по умолчанию равен elfinder
        'filter' => '',    // фильтр файлов, можно задать массив фильтров https://github.com/Studio-42/elFinder/wiki/Client-configuration-options#wiki-onlyMimes
        'name' => 'material__file',
        'value' => '',
        'template' => '<div class="input-group">{input}<span class="input-group-btn">{button}</span></div>',
        'options' => ['class' => 'form-control material__file', 'placeholder' => 'Фоновое изображение'],
        'buttonOptions' => ['class' => 'btn btn-admin', 'style' => 'padding: 6px 15px'],
        'buttonName' => 'Выбрать',
    ]); ?>

    <?= $form->field($model, 'client')->textInput(['maxlength' => true, 'placeholder' => 'ООО «Юридическая служба „Правозащитник“»']) ?>

    <?= $form->field($model, 'services')->textarea(['rows' => 6, 'readonly' => true]) ?>

    <div class="DevServices__block block-cases">
        <div class="DevServices__item block-item">Корпоративный сайт</div>
    </div>
    <div style="display: flex; align-items: center; margin-bottom: 20px">
        <input placeholder="Корпоративный сайт" name="services" class="form-control" type="text">
        <button type="button" class="btn btn-primary add_services">Добавить</button>
    </div>

    <?= $form->field($model, 'tags')->textInput(['maxlength' => true, 'placeholder' => 'SEO, Личный Кабинет']) ?>

    <?= $form->field($model, 'sphere')->textInput(['maxlength' => true, 'placeholder' => 'Банкроство']) ?>

    <?= $form->field($model, 'site')->textInput(['maxlength' => true, 'placeholder' => 'uspravozashitnik.ru']) ?>

    <?= $form->field($model, 'project_objective')->widget(CKEditor::className(), ['editorOptions' => ElFinder::ckeditorOptions('elfinder'),]); ?>

    <?= $form->field($model, 'results')->textarea(['rows' => 6, 'readonly' => true]) ?>

    <div class="DevResults__block block-cases">
        <div class="DevResults__item block-item">Конверсия - 8%</div>
    </div>
    <div style="display: flex; align-items: center; margin-bottom: 20px">
        <input placeholder="Конверсия" name="results" class="form-control" type="text">
        <input placeholder="8" name="results-number" class="form-control" type="text">
        <button type="button" class="btn btn-primary add_result">Добавить</button>
    </div>

    <?= $form->field($model, 'done_big_image')->widget(InputFile::className(), [
        'language' => 'ru',
        'controller' => 'elfinder', // вставляем название контроллера, по умолчанию равен elfinder
        'filter' => '',    // фильтр файлов, можно задать массив фильтров https://github.com/Studio-42/elFinder/wiki/Client-configuration-options#wiki-onlyMimes
        'name' => 'material__file',
        'value' => '',
        'template' => '<div class="input-group">{input}<span class="input-group-btn">{button}</span></div>',
        'options' => ['class' => 'form-control material__file', 'placeholder' => 'Что сделано (большое изображение)'],
        'buttonOptions' => ['class' => 'btn btn-admin', 'style' => 'padding: 6px 15px'],
        'buttonName' => 'Выбрать',
    ]); ?>

    <?= $form->field($model, 'done_description')->widget(CKEditor::className(), ['editorOptions' => ElFinder::ckeditorOptions('elfinder'),]); ?>

    <?= $form->field($model, 'done_small_image')->widget(InputFile::className(), [
        'language' => 'ru',
        'controller' => 'elfinder', // вставляем название контроллера, по умолчанию равен elfinder
        'filter' => '',    // фильтр файлов, можно задать массив фильтров https://github.com/Studio-42/elFinder/wiki/Client-configuration-options#wiki-onlyMimes
        'name' => 'material__file',
        'value' => '',
        'template' => '<div class="input-group">{input}<span class="input-group-btn">{button}</span></div>',
        'options' => ['class' => 'form-control material__file', 'placeholder' => 'Что сделано (дополнительное изображение)'],
        'buttonOptions' => ['class' => 'btn btn-admin', 'style' => 'padding: 6px 15px'],
        'buttonName' => 'Выбрать',
    ]); ?>

    <?= $form->field($model, 'done_small_image_description')->textInput(['maxlength' => true, 'placeholder' => 'Ознакомиться с тарифами можно по навигации в главном меню']) ?>

    <?= $form->field($model, 'functionality_lk_text')->widget(CKEditor::className(), ['editorOptions' => ElFinder::ckeditorOptions('elfinder'),]); ?>

    <?= $form->field($model, 'functionality_lk_image')->widget(InputFile::className(), [
        'language' => 'ru',
        'controller' => 'elfinder', // вставляем название контроллера, по умолчанию равен elfinder
        'template' => '<div class="input-group">{input}<span class="input-group-btn">{button}</span></div>',
        'options' => ['class' => 'form-control material__file', 'placeholder' => 'Что сделано (дополнительное изображение)'],
        'buttonOptions' => ['class' => 'btn btn-admin', 'style' => 'padding: 6px 15px'],
        'buttonName' => 'Выбрать',
        'multiple'      => true
    ]); ?>

    <?= $form->field($model, 'site_screenshots')->widget(InputFile::className(), [
        'language' => 'ru',
        'controller' => 'elfinder', // вставляем название контроллера, по умолчанию равен elfinder
        'template' => '<div class="input-group">{input}<span class="input-group-btn">{button}</span></div>',
        'options' => ['class' => 'form-control material__file', 'placeholder' => 'Что сделано (дополнительное изображение)'],
        'buttonOptions' => ['class' => 'btn btn-admin', 'style' => 'padding: 6px 15px'],
        'buttonName' => 'Выбрать',
        'multiple'      => true
    ]); ?>

    <?= $form->field($model, 'integrations')->textarea(['rows' => 6, 'readonly' => true]) ?>

    <div class="DevIntegration__block block-cases">
        <div class="DevIntegration__item block-item">/uploads/envybox.jpg; Битрикс; Создана и настроена воронка взаимодействия с клиентами</div>
    </div>
    <div style="display: flex; flex-direction: column; row-gap: 10px; align-items: center; margin-bottom: 20px">
        <?= InputFile::widget([
            'language' => 'ru',
            'controller' => 'elfinder', // вставляем название контроллера, по умолчанию равен elfinder
            'name' => 'integration-image',
            'template' => '<div class="input-group">{input}<span class="input-group-btn">{button}</span></div>',
            'options' => ['class' => 'form-control material__file', 'placeholder' => 'Что сделано (дополнительное изображение)'],
            'buttonOptions' => ['class' => 'btn btn-admin', 'style' => 'padding: 6px 15px'],
            'buttonName' => 'Выбрать',
            'multiple'      => false,
        ]);
        ?>
        <input placeholder="Битрикс" name="integration-name" class="form-control" type="text">
        <input placeholder="Создана и настроена воронка взаимодействия с клиентами" name="integration-desc" class="form-control" type="text">
        <button type="button" style="margin-right: auto" class="btn btn-primary add_integration">Добавить</button>
    </div>

    <div style="display: none">
        <?= $form->field($model, 'date')->textInput() ?>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-admin']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
