<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel common\models\VoiceLeadsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Голосовые лиды';
$this->params['breadcrumbs'][] = [
    'label' => "LEAD.FORCE",
    'url' => Url::to(['main/index']),
];
$this->params['breadcrumbs'][] = $this->title;
$js = <<<JS
$('.data-action-voice-lead').on('click', function () {
    var 
        id = $(this).attr('data-id'),
        btn = $(this);
    $.ajax({
        data: {id: id},
        type: "POST",
        dataType: "JSON",
        url: '/lead-force/voice-leads/change-status-lead'
    }).done(function (response) {
        if (response.status) {
            $('tr[data-key="'+ response.id +'"]').css('background-color', response.color);
            btn.attr('class', response.class);
            btn.text(response.text);
        } else 
            alert("Возникла ошибка, обратитесь в тех. поддержку");
    });
});
$('.send-all-actual').on('click', function () {
    $.ajax({
        dataType: "JSON",
        url: "/lead-force/voice-leads/send-all-actual"
    }).done(function (response) {
        location.reload();
    });
});
$('.data-send-voice-lead').on('click', function () {
     var 
        id = $(this).attr('data-id'),
        div = $("div[data-div-remove='"+ id +"']");
    $.ajax({
        data: {id: id},
        type: "POST",
        dataType: "JSON",
        url: '/lead-force/voice-leads/send-lead'
    }).done(function (response) {
        if (response.status) {
            $('tr[data-key="'+ id +'"]').css('background-color', '#e5ffed');
            div.remove();
        } else 
            alert("Возникла ошибка, обратитесь в тех. поддержку");
    });
});
JS;
$this->registerJs($js);
?>
<div class="voice-leads-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <div style="margin: 20px 0">
        <div class="btn btn-admin send-all-actual">Отправить всех целевых</div>
    </div>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'rowOptions' => function ($model, $index, $widget, $grid){
            if($model->status === 1){
                return ['style' => 'background-color:#e5ffed'];
            } elseif($model->status === -1) {
                return ['style' => 'background-color:#ffe5e5'];
            }
        },
        'columns' => [
            [
                'format' => "raw",
                'value' => function ($model) {
                    if($model->status === 0) {
                        $class = "btn-admin-delete";
                        $text = "В брак";
                    } else {
                        $class = "btn-admin";
                        $text = "Восстановить";
                    }
                    $btnRemove = Html::button($text, ['class' => "btn {$class} data-action-voice-lead", 'data-id' => $model->id, 'style' => 'width:132px']);
                    $btnSend = Html::button("Отправить", ['class' => "btn btn-admin-help data-send-voice-lead", 'data-id' => $model->id, 'style' => 'width:132px']);
                    return $model->status !== 1 ? Html::tag("div", $btnRemove . "<br><br>" . $btnSend, ['data-div-remove' => $model->id]) : '';
                }
            ],
            'id',
            [
                'attribute' => 'date',
                'value' => function ($model) {
                    return date("d.m.Y H:i", strtotime($model->date));
                }
            ],
            'name',
            'phone',
            'region',
            'sum',
            'ipoteka_zalog',
            [
                'attribute' => 'comments',
                'format' => 'raw'
            ],
            //'status',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
