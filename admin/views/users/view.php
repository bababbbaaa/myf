<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\UserModel */


$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Пользователи', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
$id = $model->id;
$byFranchise = \common\models\ByFranchize::find()->asArray()->where(['user_id' => $id])->all();
$arr = [];
$arrPackage = [];
foreach ($byFranchise as $v) {
    $arr[] = $v['franchize_id'];
    $arrPackage[] = $v['package_id'];
}
$franchise = \common\models\Franchise::find()->where(['id' => $arr])->select(['name', 'id'])->asArray()->all();
$package = \common\models\FranchisePackage::find()->where(['id' => $arrPackage])->select(['name', 'franchise_id'])->asArray()->all();

$this->registerCssFile(Url::to(['/css/chosen.min.css']));
$this->registerJsFile(Url::to(['/js/chosen.jquery.min.js']), ['depends' => \yii\web\JqueryAsset::class]);
$js = <<<JS
$(".chosen-select").chosen({disable_search_threshold: 5});
$('.save-bonus').on('click', function() {
    var data = $('.serialize-input').serialize();
    $.ajax({
        data: data,
        type: "POST",
        dataType: "JSON",
        url: "save-bonus?id=" + $id
    }).done(function(response) {
        if (response.status === 'success')
            location.reload();
        else {
            var msg = response.message;
            if (response.message instanceof Array) {
                for (var i = 0; i < response.message.length; i++)
                    msg += response.message[i] + "<br>";
            }
            Swal.fire({
              icon: 'error',
              title: 'Ошибка',
              text: msg,
            });
        }
    });
});
$('.add-btn').on('click', function() {
    var 
        id = $(this).attr('data-id'),
        hash = $(this).attr('data-hash'),
        value = $('.add-funds').val(),
        cashback = $('.with_cashback').prop('checked') ? 1 : 0;
    $.ajax({
        data: {id: id, hash: hash, value: value, cashback: cashback},
        dataType: "JSON",
        type: "POST",
        url: "add-user-funds"
    }).done(function(response) {
        if (response.status === 'error') {
            Swal.fire({
              icon: 'error',
              title: 'Ошибка',
              text: response.message,
            });
        } else
            location.reload();
    });
});
$('.remove-btn').on('click', function() {
    var 
        id = $(this).attr('data-id'),
        hash = $(this).attr('data-hash'),
        value = $('.remove-funds').val();
    $.ajax({
        data: {id: id, hash: hash, value: value},
        dataType: "JSON",
        type: "POST",
        url: "remove-user-funds"
    }).done(function(response) {
        if (response.status === 'error') {
            Swal.fire({
              icon: 'error',
              title: 'Ошибка',
              text: response.message,
            });
        } else
            location.reload();
    });
});
JS;
$this->registerJs($js);

?>
<div class="user-model-view">

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
            'username',
            'auth_key',
            'password_hash',
            'password_reset_token',
            'email:email',
            'status',
            'created_at',
            'updated_at',
            'verification_token',
            'budget',
            [
                'attribute' => 'is_client',
                'captionOptions' => ['style' => 'color: red'],
                'contentOptions' => ['style' => 'color:red'],
                'value' => function ($model) {
                    return $model->is_client === 1 ? 'да' : 'нет, это поставщик';
                }
            ],
            [
                'attribute' => 'entity',
                'format' => 'raw',
                'value' => function ($model) {
                    if ($model->is_client === 1)
                        $ent = \common\models\Clients::findOne(['user_id' => $model->id]);
                    else
                        $ent = \common\models\Providers::findOne(['user_id' => $model->id]);
                    if (empty($ent))
                        return '<b style="color: red">Сущность не определена (профиль не заполнен)</b>';
                    elseif($ent instanceof \common\models\Clients)
                        return Html::a("Клиент #{$ent->id}", "/lead-force/clients/view?id={$ent->id}");
                    else
                        return Html::a("Поставщик #{$ent->id}", "/lead-force/main/providers?id={$ent->id}");
                }
            ],
            'inner_name',
            'cc_daily_max',
            'cc_daily_get',
            'cc_status',
            [
                'attribute' => 'referal',
                'format' => 'raw',
                'value' => function ($model) {
                    $provider = \common\models\Providers::findOne(['referal' => $model->referal]);
                    return Html::a($model->referal, Url::to(['/lead-force/main/providers', 'id' => $provider->id]), ['target' => '_blank']);
                }
            ]
        ],
    ]) ?>

    <?php if (!empty($franchise)): ?>
        <h2>Франшизы</h2>
        <div>
            <p>
                <b>Купленные франшизы:</b>
                <?php foreach ($franchise as $k => $v): ?>
                    <p>
                        <b><?= $v['name'] ?>:</b>
                        <?php foreach ($package as $key => $val): ?>
                            <?php if ($val['franchise_id'] === $v['id']): ?>
                                пакет - <?= $val['name'] ?>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </p>
                <?php endforeach; ?>
            </p>
        </div>
    <?php endif; ?>


    <?php if (!empty($model->bonuses)): ?>
        <h2>Бонусная программа</h2>
        <div class="row">
            <div class="col-md-4">
                <p><b>Владеет картой?</b></p>
                <p>
                    <select name="UsersBonuses[card]" class="serialize-input form-control" id="">
                        <option value="0" <?= $model->bonuses->card === 0 ? 'selected' : '' ?>>Нет</option>
                        <option value="1" <?= $model->bonuses->card === 1 ? 'selected' : '' ?>>Да</option>
                    </select>
                </p>
            </div>
            <div class="col-md-4">
                <p><b>Бонусные очки, шт.</b></p>
                <p><input type="text" class="serialize-input form-control" value="<?= $model->bonuses->bonus_points ?>"
                          name="UsersBonuses[bonus_points]"></p>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <p><b>Кэшбек, %</b></p>
                <p><input type="text" class="serialize-input form-control" value="<?= $model->bonuses->cashback ?>"
                          name="UsersBonuses[cashback]"></p>
            </div>
            <div class="col-md-4">
                <p><b>Доп. отбраковка, %</b></p>
                <p><input type="text" class="serialize-input form-control"
                          value="<?= $model->bonuses->additional_waste ?>" name="UsersBonuses[additional_waste]"></p>
            </div>
            <div class="col-md-4">
                <p><b>Доп. скидка, %</b></p>
                <p><input type="text" class="serialize-input form-control"
                          value="<?= $model->bonuses->additional_sale ?>" name="UsersBonuses[additional_sale]"></p>
            </div>
        </div>
        <div class="row">
            <div class="col-md-8">
                <p><b>Открыть доп. материалы</b></p>
                <p>
                    <?php $materials = json_decode($model->bonuses->additional_materials, 1) ?>
                    <select multiple name="UsersBonuses[additional_materials][]"
                            class="serialize-input form-control chosen-select" data-placeholder="Выбрать значения"
                            id="">
                        <option value="script" <?= !empty($materials) && in_array('script', $materials) ? 'selected' : '' ?>>
                            Скрипт для эффективной обработки лидов
                        </option>
                        <option value="telegram" <?= !empty($materials) && in_array('telegram', $materials) ? 'selected' : '' ?>>
                            Автоинформирование о новых лида в Telegram на номер
                        </option>
                        <option value="course" <?= !empty($materials) && in_array('course', $materials) ? 'selected' : '' ?>>
                            Курс для менеджера продаж
                        </option>
                        <option value="personal_assistant" <?= !empty($materials) && in_array('personal_assistant', $materials) ? 'selected' : '' ?>>
                            Персональный маркетолог для вашего проекта
                        </option>
                    </select>
                </p>
            </div>
        </div>
        <div class="btn btn-admin-help save-bonus">Сохранить</div>
    <?php endif; ?>

    <h2>Баланс</h2>
    <div><p><b>Текущий баланс:</b> <?= number_format($model->budget, 2, ',', ' ') ?> руб.</p></div>
    <div>
        <div style="display: flex">
            <div style="margin-right: 15px">
                <input type="number" class="form-control add-funds" min="1" placeholder="10000">
            </div>
            <div style="margin-right: 15px">
                <button class="btn btn-admin-help add-btn" data-id="<?= $_GET['id'] ?>"
                        data-hash="<?= md5("{$_GET['id']}::asd4jdf") ?>">Начислить
                </button>
            </div>
            <div style="display: flex">
                <input type="checkbox" class="with_cashback" style="margin-right: 10px"> <span>с учетом кешбека (добавить % к сумме)</span>
            </div>
        </div>
    </div>
    <div style="margin-top: 10px">
        <div style="display: flex">
            <div style="margin-right: 15px">
                <input type="number" class="form-control remove-funds" min="1" placeholder="10000">
            </div>
            <div>
                <button class="btn btn-admin-delete remove-btn" data-id="<?= $_GET['id'] ?>"
                        data-hash="<?= md5("{$_GET['id']}::nedfge33") ?>">Списать
                </button>
            </div>
        </div>
    </div>
</div>
