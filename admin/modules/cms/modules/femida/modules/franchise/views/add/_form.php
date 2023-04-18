<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\Franchise;
use common\models\RenderProcessor;
use mihaildev\elfinder\InputFile;
use mihaildev\ckeditor\CKEditor;

/* @var $this yii\web\View */
/* @var $model common\models\Franchise */
/* @var $form yii\widgets\ActiveForm */

$franchise = Franchise::find()->select('category')->distinct(true)->all();
$json = null;
if (!empty($model->render_data))
    $json = json_decode($model->render_data, JSON_UNESCAPED_UNICODE);

?>
<div class="franchise-form">
    <hr>

    <h3>Общая информация</h3>

    <?php $form = ActiveForm::begin(['options' => ['class' => 'save-btn-special-query']]); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true, 'placeholder' => 'Банкротство физических лиц', 'id' => 'textToLink']) ?>

    <?= $form->field($model, 'is_active')->dropDownList([1 => 'Активна', 0 => "Неактивна"]) ?>

    <?= $form->field($model, 'link')->textInput(['maxlength' => true, 'placeholder' => 'bankrotstvo-fizicheskih-lic', 'id' => 'linkText']) ?>

    <?= $form->field($model, 'price')->input('number', ['placeholder' => '69000']) ?>

    <?php echo $form->field($model, 'vendor')->widget(InputFile::className(), [
        'language'      => 'ru',
        'controller'    => 'elfinder', // вставляем название контроллера, по умолчанию равен elfinder
        'filter'        => 'image',    // фильтр файлов, можно задать массив фильтров https://github.com/Studio-42/elFinder/wiki/Client-configuration-options#wiki-onlyMimes
        'template'      => '<div class="input-group">{input}<span class="input-group-btn">{button}</span></div>',
        'options'       => ['class' => 'form-control', 'placeholder' => 'Логотип вендора'],
        'buttonOptions' => ['class' => 'btn btn-default'],
        'multiple'      => false       // возможность выбора нескольких файлов
    ]); ?>

    <?= $form->field($model, 'category')->textInput(['maxlength' => true, 'list' => 'categories', 'placeholder' => 'Юридические услуги']) ?>
    <?php if(!empty($franchise)): ?>
    <datalist id="categories">
        <?php foreach($franchise as $item): ?>
            <option value="<?= $item->category ?>">
        <?php endforeach; ?>
    </datalist>
    <?php endif; ?>

    <?= $form->field($model, 'meta_keywords')->textInput(['maxlength' => true, 'placeholder' => 'банкротство франшиза, франшиза femidaforce, франшиза']) ?>

    <?= $form->field($model, 'meta_description')->textInput(['maxlength' => true, 'placeholder' => 'Франшиза для юристов по списанию долгов через процедуру банкротства физического лица и признанию граждан несостоятельными.']) ?>

        <hr>

        <h3>Первая секция</h3>

        <div class="row">
            <div class="col-lg-6 pdb10">
                <?= RenderProcessor::renderDynamicObjectInput(
                    'Заголовок мелкий',
                    'first_section',
                    'small_article',
                    'input',
                    'Бизнес с нуля',
                    '',
                    $json['first_section']['small_article'] ?? ''
                ); ?>
            </div>
            <div class="col-lg-6 pdb10">
                <?= RenderProcessor::renderDynamicObjectInput(
                    'Заголовок большой',
                    'first_section',
                    'big_article',
                    'input',
                    'Франшиза банкротство физических лиц',
                    '',
                    $json['first_section']['big_article'] ?? ''
                ); ?>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-6 pdb10">
                <?= RenderProcessor::renderDynamicObjectInput(
                    'Размер инвестиций',
                    'first_section',
                    'price',
                    'input',
                    'от 69 тыс. рублей',
                    '',
                    $json['first_section']['price'] ?? ''
                ); ?>
            </div>
            <div class="col-lg-6 pdb10">
                <?= RenderProcessor::renderDynamicObjectInput(
                    'Срок окупаемости',
                    'first_section',
                    'feedback',
                    'input',
                    '5 месяцев',
                    '',
                    $json['first_section']['feedback'] ?? ''
                ); ?>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-6 pdb10">
                <div style="padding-bottom: 5px"><b>Картинка первой секции (h:500px, w:380px)</b></div>
                <div>
                    <?php
                    echo InputFile::widget([
                        'language'   => 'ru',
                        'controller' => 'elfinder', // вставляем название контроллера, по умолчанию равен elfinder
                        'path' => 'uploads', // будет открыта папка из настроек контроллера с добавлением указанной под деритории
                        'filter'     => 'image',    // фильтр файлов, можно задать массив фильтров https://github.com/Studio-42/elFinder/wiki/Client-configuration-options#wiki-onlyMimes
                        'name'       => 'first_section[img]',
                        'value'      => $json['first_section']['img'] ?? '',
                        'template'      => '<div class="input-group">{input}<span class="input-group-btn">{button}</span></div>',
                        'options'       => ['class' => 'form-control object-admin-input', 'placeholder' => 'Указать картинку в первой секции'],
                        'buttonOptions' => ['class' => 'btn btn-default'],
                        'buttonName' => 'Выбрать'
                    ]);
                    ?>
                </div>
            </div>
            <div class="col-lg-6 pdb10">
                <?= RenderProcessor::renderDynamicObjectInput(
                    'Вендор франшизы',
                    'first_section',
                    'vendor',
                    'input',
                    'FEMIDA.FORCE',
                    '',
                    $json['first_section']['vendor'] ?? ''
                ); ?>
            </div>
        </div>

        <hr>

        <h3>Вторая секция</h3>

        <div class="row">
            <div class="col-lg-12 pdb10">
                <?= RenderProcessor::renderDynamicObjectInput(
                    'Заголовок',
                    'second_section',
                    'article',
                    'input',
                    'О франшизе по банкротству',
                    '',
                    $json['second_section']['article'] ?? ''
                ); ?>
            </div>
            <div class="col-lg-12 pdb10">
                <div style="padding-bottom: 5px"><b>Текст (о франшизе)</b></div>
                <div>
                    <?php echo
                    CKEditor::widget([
                        'editorOptions' => [
                            'preset' => 'full', //разработанны стандартные настройки basic, standard, full данную возможность не обязательно использовать
                            'inline' => false, //по умолчанию false
                        ],
                        'name' => 'second_section[text]',
                        'options' => ['class' => 'object-admin-input'],
                        'value' => $json['second_section']['text'] ?? ''
                    ]);
                    ?>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4 pdb10">
                <?= RenderProcessor::renderDynamicObjectInput(
                    'Собственных офисов',
                    'second_section',
                    'office',
                    'input',
                    '3',
                    '',
                    $json['second_section']['office'] ?? ''
                ); ?>
            </div>
            <div class="col-md-4 pdb10">
                <?= RenderProcessor::renderDynamicObjectInput(
                    'Франшизных офисов',
                    'second_section',
                    'office_franchise',
                    'input',
                    '56',
                    '',
                    $json['second_section']['office_franchise'] ?? ''
                ); ?>
            </div>
            <div class="col-lg-4 pdb10">
                <?= RenderProcessor::renderDynamicObjectInput(
                    'Год основания франшизы',
                    'second_section',
                    'year',
                    'input',
                    '2015',
                    '',
                    $json['second_section']['year'] ?? ''
                ); ?>
            </div>
        </div>

        <div class="pb10">
            <div style="padding-bottom: 5px"><b>Картинка второй секции (h:300px, w:450px)</b></div>
            <div>
                <?php
                echo InputFile::widget([
                    'language'   => 'ru',
                    'controller' => 'elfinder', // вставляем название контроллера, по умолчанию равен elfinder
                    'path' => 'uploads', // будет открыта папка из настроек контроллера с добавлением указанной под деритории
                    'filter'     => 'image',    // фильтр файлов, можно задать массив фильтров https://github.com/Studio-42/elFinder/wiki/Client-configuration-options#wiki-onlyMimes
                    'name'       => 'second_section[img]',
                    'value'      => $json['second_section']['img'] ?? '',
                    'template'      => '<div class="input-group">{input}<span class="input-group-btn">{button}</span></div>',
                    'options'       => ['class' => 'form-control object-admin-input', 'placeholder' => 'Указать картинку во второй секции'],
                    'buttonOptions' => ['class' => 'btn btn-default'],
                    'buttonName' => 'Выбрать'
                ]);
                ?>
            </div>
        </div>

        <hr>

        <h3>Третья секция</h3>

        <div class="row">
            <div class="col-lg-12 pdb10">
                <?= RenderProcessor::renderDynamicObjectInput(
                    'Заголовок',
                    'third_section',
                    'article',
                    'input',
                    'Преимущества франшизы',
                    '',
                    $json['third_section']['article'] ?? ''
                ); ?>
            </div>
            <div class="col-lg-12 pdb10">
                <?= RenderProcessor::renderDynamicObjectInput(
                    'Мелкий текст',
                    'third_section',
                    'text',
                    'textarea',
                    'Покупая готовую франшизу у нас Вы получаете не просто инструменты ведения бизнеса, но и блок обучения сотрудников, надежного партнера и постоянную поддержку',
                    '',
                    $json['third_section']['text'] ?? ''
                ); ?>
            </div>
        </div>

        <div>
            <?= RenderProcessor::renderDynamicObjectInput(
                'Преимущества',
                'third_section',
                'advantage',
                'input',
                'Полный аутсорсинг юридических услуг — вам нужно только продавать!',
                '[]',
                $json['third_section']['advantage'] ?? '',
                    !empty($json['third_section']['advantage']) ? count($json['third_section']['advantage']) : false,
                true
            ); ?>
        </div>
        <div style="margin-top: 10px">
            <div class="btn btn-admin-help append-btn" data-append-param="third_section" data-append-key="advantage" data-append-block=".append-third_section">Добавить еще</div>
        </div>

        <hr>

        <h3>Четвертая секция</h3>

        <div class="row">
            <div class="col-lg-6 pdb10">
                <?= RenderProcessor::renderDynamicObjectInput(
                    'Заголовок',
                    'fourth_section',
                    'article',
                    'input',
                    'Пакеты готового бизнеса по банкротству физических лиц',
                    '',
                    $json['fourth_section']['article'] ?? ''
                ); ?>
            </div>
            <div class="col-lg-6 pdb10">
                <?= RenderProcessor::renderDynamicObjectInput(
                    'Мелкий текст',
                    'fourth_section',
                    'text',
                    'input',
                    'Пакеты готового бизнеса по банкротству физических лиц',
                    '',
                    $json['fourth_section']['text'] ?? ''
                ); ?>
            </div>
        </div>

        <div class="rbac-info">
            Информация о пакетах для данной франшизы заполняется в разделе "Пакеты" конструктора франшиз, после добавления непосредственно самой франшизы.
        </div>

        <hr>

        <h3>Пятая секция</h3>

        <div class="row">
            <div class="col-lg-6 pdb10">
                <?= RenderProcessor::renderDynamicObjectInput(
                    'Заголовок',
                    'fifth_section',
                    'article',
                    'input',
                    'Как вы будете работать по франшизе',
                    '',
                    $json['fifth_section']['article'] ?? ''
                ); ?>
            </div>
            <div class="col-lg-6 pdb10">
                <?= RenderProcessor::renderDynamicObjectInput(
                    'Мелкий текст',
                    'fifth_section',
                    'text',
                    'input',
                    'Этапы вашей работы с FEMIDA.FORCE',
                    '',
                    $json['fifth_section']['text'] ?? ''
                ); ?>
            </div>
        </div>

        <div class="pb10">
            <div style="padding-bottom: 5px"><b>Картинка пятой секции (h:600px, w:400px)</b></div>
            <div>
                <?php
                echo InputFile::widget([
                    'language'   => 'ru',
                    'controller' => 'elfinder', // вставляем название контроллера, по умолчанию равен elfinder
                    'path' => 'uploads', // будет открыта папка из настроек контроллера с добавлением указанной под деритории
                    'filter'     => 'image',    // фильтр файлов, можно задать массив фильтров https://github.com/Studio-42/elFinder/wiki/Client-configuration-options#wiki-onlyMimes
                    'name'       => 'fifth_section[img]',
                    'value'      => $json['fifth_section']['img'] ?? '',
                    'template'      => '<div class="input-group">{input}<span class="input-group-btn">{button}</span></div>',
                    'options'       => ['class' => 'form-control object-admin-input', 'placeholder' => 'Указать картинку в пятой секции'],
                    'buttonOptions' => ['class' => 'btn btn-default'],
                    'buttonName' => 'Выбрать'
                ]);
                ?>
            </div>
        </div>

        <div style="margin-top: 10px">
            <?= RenderProcessor::renderDynamicObjectInput(
                'Этапы',
                'fifth_section',
                'stage',
                'input',
                'Обработка клиентской базы и назначение встреч в офисе',
                '[]',
                $json['fifth_section']['stage'] ?? '',
                !empty($json['fifth_section']['stage']) ? count($json['fifth_section']['stage']) : false,
                    true
            ); ?>
        </div>
        <div style="margin-top: 10px">
            <div class="btn btn-admin-help append-btn" data-append-param="fifth_section" data-append-key="stage" data-append-block=".append-fifth_section">Добавить еще</div>
        </div>

    <hr>

    <h3>Секция отзывов</h3>

    <div class="rbac-info">
        Информация об отзывах к франшизе заполняется в <a href="<?= \yii\helpers\Url::to(['/cms/femida/franchise/reviews/index']) ?>" target="_blank">соответствующем разделе</a> CMS FEMIDA.FORCE после добавления непосредственно самой франшизы. Также можно добавить успешные <a href="<?= \yii\helpers\Url::to(['/cms/femida/franchise/cases/index']) ?>" target="_blank">кейсы</a>.
    </div>

    <hr>

    <h3>Секция технологий</h3>

    <div class="row">
        <div class="col-lg-12 pdb10">
            <?= RenderProcessor::renderDynamicObjectInput(
                'Заголовок секции',
                'seventh_section',
                'title',
                'input',
                'Полезное для франшизы по банкротству',
                '',
                $json['seventh_section']['title'] ?? ''
            ); ?>
        </div>
    </div>

    <hr>

    <?= $form->field($model, 'render_data')->textarea(['rows' => 6, 'placeholder' => 'json', 'readonly' => true, 'style' => 'resize:none;', 'class' => 'composed-object form-control']) ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-admin']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
