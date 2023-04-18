<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\UsersBills */

$this->title = $model->name;
$this->params['breadcrumbs'][] = [
    'url' => \yii\helpers\Url::to(['/logs/main/index']),
    'label' => 'ЛОГИ'
];
$this->params['breadcrumbs'][] = ['label' => 'Счета пользователей', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);

$js = <<<JS
$('.create-act').on('click', function(e) {
    var link = $(this).attr('href');
    e.preventDefault();
    $.ajax({
        type: "GET",
        dataType: "JSON",
        url: link
    }).done(function(response) {
        if (response.status === 'success') {
            window.open(response.url, "_blank");
            setTimeout(function() {
                location.href = "https://admin.myforce.ru/logs/acts/view?id=" + response.__object;
            }, 1500);
        } else
            alert(response.message);
    });
});
$('.assign-funds').on('click', function(e) {
    var link = $(this).attr('href');
    e.preventDefault();
    $.ajax({
        type: "GET",
        dataType: "JSON",
        url: link
    }).done(function(response) {
        if (response.status === 'success') {
            Swal.fire({
              icon: 'success',
              title: 'Успешно',
              text: "Баланс пользователя пополнен",
              onClose: function(e) {
                  location.reload();
              }
            });
        } else
            alert(response.message);
    });
});
JS;
$this->registerJs($js);


?>
<div class="users-bills-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Сформировать АКТ', ['create-act', 'id' => $model->id], ['class' => 'btn btn-admin create-act']) ?>
        <?php if($model->status === $model::STATUS_WAIT): ?>
            <?= Html::a('Пополнить баланс пользователя', ['add-funds', 'id' => $model->id], ['class' => 'btn btn-admin-help assign-funds']) ?>
    <p style="color: red"><b>Внимание!</b> При наличии у пользователя бонусного кешбека - он будет начислен автоматически при нажатии кнопки пополнения</p>
        <?php endif; ?>
    </p>


    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'user_id',
            [
                'attribute' => 'link',
                'format' => 'html',
                'value' => function ($model) {
                    return Html::a("скачать", \yii\helpers\Url::to([$model->link]));
                }
            ],
            'date',
            'name',
            'value',
            'status',
        ],
    ]) ?>

</div>
