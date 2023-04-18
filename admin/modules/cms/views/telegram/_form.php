<?php

use kartik\datetime\DateTimePicker;
use mihaildev\ckeditor\CKEditor;
use mihaildev\elfinder\ElFinder;
use mihaildev\elfinder\InputFile;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\TgMessages */
/* @var $form yii\widgets\ActiveForm */

$this->registerCssFile(Url::to(['/css/chosen.min.css']));
$this->registerJsFile(Url::to(['/js/chosen.jquery.min.js']), ['depends' => \yii\web\JqueryAsset::class]);

$js = <<<JS
$('.chosen-select').chosen();
$('#tgmessages-is_loop').on('change', function() {
    $('.show2').hide();
    var val = $(this).val();
    if (val == 1)
        $('.show2[data-type="loop"]').show();
    else
        $('.show2[data-type="once"]').show();
});
JS;
$this->registerJs($js);

?>

<div class="tg-messages-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'peer')->dropDownList($model::$peers) ?>

    <?= $form->field($model, 'bot')->dropDownList($model::$bots) ?>


    <?php echo $form->field($model, 'message')->widget(\yii2mod\markdown\MarkdownEditor::class, [
        'editorOptions' => [
            'showIcons' => ["code", "table"],
            'blockStyles' => ['bold' => '*', 'italic' => '_'],
            'styleSelectedText' => false
        ],
    ]); ?>
    <p style="margin-bottom: 30px; font-size: 12px; color: #9e9e9e">Чтобы добавить в текст emoji - использовать код emoji из <a target="_blank" href="http://apps.timwhitlock.info/emoji/tables/unicode">столбца Bytes по ссылке</a></p>


    <?= $form->field($model, 'image')->widget(InputFile::className(), [
        'language'      => 'ru',
        'controller'    => 'elfinder', // вставляем название контроллера, по умолчанию равен elfinder
        'path' => 'image', // будет открыта папка из настроек контроллера с добавлением указанной под деритории
        'filter'        => 'image',    // фильтр файлов, можно задать массив фильтров https://github.com/Studio-42/elFinder/wiki/Client-configuration-options#wiki-onlyMimes
        'template'      => '<div class="input-group">{input}<span class="input-group-btn">{button}</span></div>',
        'options'       => ['class' => 'form-control', 'placeholder' => 'Картинка для сообщения'],
        'buttonOptions' => ['class' => 'btn btn-admin', 'style' => 'padding: 6px 15px'],
        'buttonName' => 'Выбрать',
        'multiple'      => false       // возможность выбора нескольких файлов
    ]); ?>

    <?= $form->field($model, 'is_loop')->dropDownList([0 => 'нет', 1 => 'да']) ?>

    <div style="display:<?= $model->is_loop === 1 ? 'block' : 'none' ?>;" class="show2" data-type="loop">
        <?= $form->field($model, 'minimum_time')->input('number', ['placeholder' => '9', 'value' => $model->minimum_time ?? 9]) ?>

        <p><b>Дни публикации</b></p>
        <div style="margin-bottom: 10px">
            <select multiple data-placeholder="Выбрать несколько дней" class="form-control chosen-select" name="TgMessages[daysToPublish][]" id="">
                <?php if(empty($model->days_to_post)): ?>
                    <option selected value="1">Понедельник</option>
                    <option selected value="2">Вторник</option>
                    <option selected value="3">Среда</option>
                    <option selected value="4">Четверг</option>
                    <option selected value="5">Пятница</option>
                    <option value="6">Суббота</option>
                    <option value="7">Воскресенье</option>
                <?php else: ?>
                    <?php $json = json_decode($model->days_to_post, 1) ?>
                    <option <?= in_array("1", $json) ? 'selected' : '' ?> value="1">Понедельник</option>
                    <option <?= in_array("2", $json) ? 'selected' : '' ?> value="2">Вторник</option>
                    <option <?= in_array("3", $json) ? 'selected' : '' ?> value="3">Среда</option>
                    <option <?= in_array("4", $json) ? 'selected' : '' ?> value="4">Четверг</option>
                    <option <?= in_array("5", $json) ? 'selected' : '' ?> value="5">Пятница</option>
                    <option <?= in_array("6", $json) ? 'selected' : '' ?> value="6">Суббота</option>
                    <option <?= in_array("7", $json) ? 'selected' : '' ?> value="7">Воскресенье</option>
                <?php endif; ?>
            </select>
        </div>
    </div>

    <div class="show2" data-type="once" style="display:<?= empty($model->id) || $model->is_loop === 0 ? 'block' : 'none' ?>;">
        <?php echo $form->field($model, 'date_to_post')->widget(DateTimePicker::classname(), [
            'options' => ['placeholder' => 'Указать время публикации', 'autocomplete' => 'off'],
            'pluginOptions' => [
                'autoclose' => true,
            ]
        ]); ?>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-admin']) ?>
    </div>

    <?php ActiveForm::end(); ?>

    <div class="rbac-info rbac-info-leads" style="max-width: unset">
        <p><code>Группа</code> &ndash; выбрать группу, в которой находится указанный во втором поле <code>Бот</code></p>
        <p>При заполнении <code>Сообщения для отправки</code> можно использовать только: жирный текст, курсив и вставку ссылок из интерфейса. Поддержка остального функционала не гарантирована.</p>
        <p>Чтобы вставить смайлик &ndash; воспользуйтесь подсказкой под формой для ввода <code>Сообщения</code></p>
        <p>При выборе <code>Зациклено &ndash; да</code> необходимо указать также </p>
        <ul>
            <li>время начала отсчета для сообщения от бота (например с 10 утра)</li>
            <li>дни недели, когда это сообщение будет отправляться</li>
        </ul>
        <p>При выборе <code>Зациклено &ndash; нет</code> необходимо указать также </p>
        <ul>
            <li>точное время &ndash; когда бот отправит данное сообщение. В данном случае сообщение будет отправлено единожды</li>
        </ul>
        <p>Если нужно протестировать сообщение &ndash; указать: <code>группу "Тестовый чат"</code>, <code>Зациклено &ndash; нет</code>, <code>Дата и время публикации &ndash; текущее время</code> и любой тестируемый текст сообщения</p>
    </div>

</div>
