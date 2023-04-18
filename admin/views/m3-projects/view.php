<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\M3Projects */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Проекты M3', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);

$costs = \common\models\M3Costs::find()->where(['project_id' => $model->id])->asArray()->all();

$js = <<<JS
$('.del-item').on('click', function (e) {
    var id = $(this).attr('data-id');
    e.preventDefault();
    $.ajax({
        data: {id: id},
        dataType: 'JSON',
        type: "POST",
        url: "/m3-projects/del-item"
    }).done(function (response) {
        if (response.status === 'success')
            location.reload();
        else
            alert(response.message);
    });
});
$('.new-cost').on('click', function (e) {
    var project = $(this).attr('data-project');
    e.preventDefault();
    $.ajax({
        url: '/m3-projects/new-item',
        dataType: 'JSON',
        type: "POST",
        data: {project: project}
    }).done(function (response) {
        if (response.status === 'success')
            location.reload();
        else
            alert(response.message);
    });
});
var timer = null;
$('.saver').on('input', function (e) {
    var 
        val = $(this).attr('data-val'),
        id = $(this).attr('data-id'),
        data = $(this).val();
    timer = setTimeout(function (){
        $.ajax({
            data: {val: val, id:id, data:data},
            dataType: "JSON",
            type: "POST",
            url: "/m3-projects/update-item"
        }).done(function (response) {
            if (response.status !== 'success') 
                alert(response.message);
        });
    }, 300);
});
JS;
$this->registerJs($js);
?>
<div class="m3-projects-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Обновить', ['update', 'id' => $model->id], ['class' => 'btn btn-admin']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-admin-delete',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'date_start',
            'date_end',
            'name',
            'source',
            'specs_link',
            'price',
            'status',
            'money_paid',
            'money_got',
            'payment_type',
        ],
    ]) ?>


        <h3>Расходы по проекту</h3>
        <table class="table table-bordered">
            <tr>
                <th>ID</th>
                <th>Объем</th>
                <th>Описание</th>
                <th>Дата</th>
                <th>Удалить</th>
            </tr>
            <?php if (!empty($costs)): ?>
            <?php foreach($costs as $key => $val): ?>
                <tr>
                    <td><?= $val['id'] ?></td>
                    <td><input placeholder="7500" data-val="value" data-id="<?= $val['id'] ?>" type="number" class="form-control saver" value="<?= $val['value'] ?>"></td>
                    <td><input placeholder="Оплата подрядчика" data-val="description" data-id="<?= $val['id'] ?>" type="text" class="form-control saver" value="<?= $val['description'] ?>"></td>
                    <td><?= date("d.m.Y", strtotime($val['date'])) ?></td>
                    <td>
                        <button data-id="<?= $val['id'] ?>" class="btn btn-admin-delete del-item">Х</button>
                    </td>
                </tr>
            <?php endforeach; ?>
            <?php endif; ?>
            <tr>
                <td colspan="5">
                    <button class="btn btn-admin new-cost" data-project="<?= $model->id ?>">Добавить новый</button>
                </td>
            </tr>
        </table>


</div>
