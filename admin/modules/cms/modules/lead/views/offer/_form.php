<?php

use common\models\RenderProcessor;
use mihaildev\ckeditor\CKEditor;
use mihaildev\elfinder\ElFinder;
use mihaildev\elfinder\InputFile;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\Offer;
use common\models\OfferParams;

/* @var $this yii\web\View */
/* @var $model common\models\Offer */
/* @var $form yii\widgets\ActiveForm */

$of = Offer::find()->select('category')->distinct(true)->all();
$area = Offer::find()->select('area')->distinct(true)->all();
if (!empty($area))
    $op = OfferParams::find()->where(['OR', ['area' => $area[0]->area], ['is', 'area', NULL]])->all();
?>

<div class="offer-form">

    <?php $form = ActiveForm::begin(); ?>

    <div style="display: none">
        <?= $form->field($model, 'type')->dropDownList(['поставщик' => 'Провайдерский', 'клиент' => 'Клиентский', ]) ?>
    </div>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true, 'id' => 'textToLink', 'placeholder' => 'Трафик на банкротство физических лиц']) ?>

    <?= $form->field($model, 'link')->textInput(['maxlength' => true, 'id' => 'linkText', 'placeholder' => 'trafik-na-bankrotstvo-fizicheskih-lic']) ?>

    <?= $form->field($model, 'category')->textInput(['maxlength' => true, 'list' => 'categories', 'placeholder' => 'Банкротство физических лиц']) ?>

    <?= $form->field($model, 'area')->textInput(['list' => 'areas', 'placeholder' => 'Долги']) ?>

    <?php if(!empty($of)): ?>
        <datalist id="categories">
            <?php foreach($of as $item): ?>
            <option value="<?= $item->category ?>">
                <?php endforeach; ?>
        </datalist>
    <?php endif; ?>

    <?=
    $form->field($model, 'description')->widget(CKEditor::className(), [
        'editorOptions' => ElFinder::ckeditorOptions('elfinder'),
    ]);
    ?>

    <?= $form->field($model, 'price')->input('number', ['placeholder' => 150]) ?>

    <?php

    echo $form->field($model, 'logo')->widget(InputFile::className(), [
        'language'      => 'ru',
        'controller'    => 'elfinder', // вставляем название контроллера, по умолчанию равен elfinder
        'path' => 'image', // будет открыта папка из настроек контроллера с добавлением указанной под деритории
        'filter'        => 'image',    // фильтр файлов, можно задать массив фильтров https://github.com/Studio-42/elFinder/wiki/Client-configuration-options#wiki-onlyMimes
        'template'      => '<div class="input-group">{input}<span class="input-group-btn">{button}</span></div>',
        'options'       => ['class' => 'form-control', 'placeholder' => 'Иконка оффера'],
        'buttonOptions' => ['class' => 'btn btn-default'],
        'multiple'      => false       // возможность выбора нескольких файлов
    ]);


    ?>

    <?php #TODO: PROPS DIVERSITY ?>

    <?php if(!empty($area)): ?>
        <datalist id="areas">
            <?php foreach($area as $item): ?>
            <option value="<?= $item->area ?>">
                <?php endforeach; ?>
        </datalist>
    <?php endif; ?>

    <hr>

    <h3>Параметры оффера</h3>

   <div style="margin-bottom: 20px">
       <div class="row">
           <div class="col-lg-3">
               <p><label for="">Ключ</label></p>
               <p><input type="text" placeholder="region" class="form-control" name="params[key]"></p>
           </div>
           <div class="col-lg-5">
               <p><label for="">Описание</label></p>
               <p><input type="text" placeholder="Регион получаемых лидов" class="form-control" name="params[key][description]"></p>
           </div>
           <div class="col-lg-3">
               <p><label for="">Значение</label></p>
               <p><input type="text" placeholder="Московская область" class="form-control" name="params[key][value]"></p>
           </div>
       </div>
       <div style="margin-top: 10px">
           <div class="btn btn-admin-help">Добавить еще</div>
       </div>
   </div>

    <?= $form->field($model, 'properties')->textarea(['rows' => 6, 'readonly' => true, 'class' => 'composed-object form-control']) ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-admin']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
