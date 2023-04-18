<?php

use mihaildev\ckeditor\CKEditor;
use mihaildev\elfinder\ElFinder;
use mihaildev\elfinder\InputFile;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\CdbArticle */
/* @var $form yii\widgets\ActiveForm */


$categoryArr = [];
$category = \common\models\CdbCategory::find()->asArray()->all();
foreach ($category as $i)
    $categoryArr[$i['id']] = $i['name'];

$subcategoryArr = [];
$subcategory = \common\models\CdbSubcategory::find()->asArray()->all();
foreach ($subcategory as $i)
    $subcategoryArr[$i['id']] = $i['name']


?>

<div class="cdb-article-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'category_id')->dropDownList($categoryArr) ?>

    <?= $form->field($model, 'subcategory_id')->dropDownList($subcategoryArr) ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true, 'id' => 'textToLink', 'placeholder' => 'Нормативные акты регулирующие банкротство физических лиц']) ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6, 'placeholder' => 'Основные нормативные акты, законы, разъяснения, участвующие в процессе регламентирования процедуры Банкротства физического лица в рамках настройки БИЗНЕС-ПРОЦЕССА исполнения услуг и организации продаж Банкротства гражданам.']) ?>

    <?= $form->field($model, 'text')->widget(CKEditor::className(), [
        'editorOptions' => ElFinder::ckeditorOptions('elfinder'),
    ]);
    ?>

    <?= $form->field($model, 'link')->textInput(['maxlength' => true, 'placeholder' => 'normativnye-akty-reguliruushchie-bankrotstvo-fizicheskih-lic', 'id' => 'linkText']) ?>

    <?= $form->field($model, 'date')->widget(\yii\jui\DatePicker::classname(), [
        'language'      => 'ru',
        'dateFormat'    => 'yyyy-MM-dd',
        'options'       => ['class' => 'form-control', 'placeholder' => 'Дата создания'],
    ]) ?>

    <?= $form->field($model, 'img')->widget(InputFile::className(), [
        'language'      => 'ru',
        'controller'    => 'elfinder', // вставляем название контроллера, по умолчанию равен elfinder
        'path' => 'image', // будет открыта папка из настроек контроллера с добавлением указанной под деритории
        'filter'        => 'image',    // фильтр файлов, можно задать массив фильтров https://github.com/Studio-42/elFinder/wiki/Client-configuration-options#wiki-onlyMimes
        'template'      => '<div class="input-group">{input}<span class="input-group-btn">{button}</span></div>',
        'options'       => ['class' => 'form-control', 'placeholder' => 'Изображение статьи'],
        'buttonOptions' => ['class' => 'btn btn-admin', 'style' => 'padding: 6px 15px'],
        'buttonName' => 'Выбрать',
        'multiple'      => false       // возможность выбора нескольких файлов
    ]); ?>

    <?= $form->field($model, 'minimum_status')->textInput(['maxlength' => true, 'placeholder' => 'Заказчик']) ?>

    <?= $form->field($model, 'price')->textInput() ?>

    <?= $form->field($model, 'author')->textInput(['maxlength' => true, 'placeholder' => 'Вероника MYFORCE']) ?>

    <?= $form->field($model, 'tags')->textInput(['maxlength' => true, 'placeholder' => 'банкротство; акты; постановления; законы;']) ?>

    <?= $form->field($model, 'views')->input('number', ['placeholder' => '23']) ?>

    <?= $form->field($model, 'likes')->input('number', ['placeholder' => '23']) ?>

    <?= $form->field($model, 'downloads')->input('number', ['placeholder' => '23']) ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-admin']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
