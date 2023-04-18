<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\DialoguePeer */

$this->title = "Тикет #{$model->id}";
$this->params['breadcrumbs'][] = ['label' => 'Поддержка', 'url' => ['/support/main/index']];
$this->params['breadcrumbs'][] = ['label' => 'Тикеты', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
$id = $model->id;
$this->registerCssFile(Url::to(['/css/chosen.min.css']));
$this->registerJsFile(Url::to(['/js/chosen.jquery.min.js']), ['depends' => \yii\web\JqueryAsset::class]);
$js = <<<JS
$('.chosen-select').chosen();
$('#sendForm').on('submit', function(e) {
    e.preventDefault();
    var 
        form = $(this),
        data = form.serialize(),
        url = form.attr('action');
    if (!form.hasClass('blocked-form')) {
        form.toggleClass('blocked-form');
        $.ajax({
            data: data,
            url: url,
            type: "POST",
            dataType: "JSON"
        }).done(function(response) {
            if (response.status === 'success')
                location.reload();
            else {
                 form.toggleClass('blocked-form');
                 Swal.fire({
                  icon: 'error',
                  title: 'Ошибка',
                  text: response.message,
                });
            }
        });
    }
});
$(".dialogue-chat-block > div").scrollTop($(".dialogue-chat-block > div")[0].scrollHeight);
$('[name="Orders[category_link]"]').on('input', function() {
    $('[name="Orders[category_text]"]').val($("option:selected", this).text());
});
$('.create-order').on('click', function() {
    var data = $('.serialize-order').serialize();
    $.ajax({
        data: data,
        url: 'create-order?id=' + $id,
        type: "POST",
        dataType: "JSON"
    }).done(function(response) {
        if (response.status === 'success') {
            location.href = response.url;
        } else {
            Swal.fire({
              icon: 'error',
              title: 'Ошибка',
              text: response.message,
            });
        }
    });
});
$('.create-offer').on('click', function() {
    var data = $('.serialize-offer').serialize();
    $.ajax({
        data: data,
        url: 'create-offer?id=' + $id,
        type: "POST",
        dataType: "JSON"
    }).done(function(response) {
        if (response.status === 'success') {
            location.href = response.url;
        } else {
            Swal.fire({
              icon: 'error',
              title: 'Ошибка',
              text: response.message,
            });
        }
    });
});
JS;


$this->registerJs($js);
$me = Yii::$app->getUser();
?>

<style>
    .dialogue-chat-block {
        width: 100%; border: 1px solid gainsboro; padding: 20px;
        display: flex; flex-direction: column;
    }
    .dialogue-chat-block > div {
        max-height: 400px;
        overflow: auto;
    }
    .message-pop {
        display: flex; flex-direction: row;
        max-width: 50%;
        margin-bottom: 10px;
    }
    .message-pop-adm {
        margin-left: auto;
    }
    .message-pop-user {
        margin-left: 0;
    }
    .message-pop > div {
        padding: 10px;
        border-radius: 12px;
        border: 1px solid gainsboro;
        background-color: #fafafa;
    }
    .message-pop hr {
        margin: 5px auto;
    }
    .new-glyph {
        width: 5%;
        font-size: 27px;
        vertical-align: sub;
        display: inline-block;
        top: 4px;
        cursor: pointer;
        transition: 0.3s ease;
        border: 0;
        padding: 0;
        background: transparent;
    }
    .new-glyph:hover {
        color: #d9534f;
    }
</style>

<div class="dialogue-peer-view" style="max-width: 1000px; padding-bottom: 200px">

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
            'user_id',
            'date',
            [
                'attribute' => 'status',
                'value' => function ($model) {
                    return \common\models\DialoguePeer::$textStatus[$model->status];
                }
            ],
        ],
    ]) ?>

    <h2>Чат - <?= $model->type ?></h2>
    <?php if(!empty($model->properties)): ?>
        <div><b>Данные предполагаемого <?= $model->type ?>a:</b></div>
        <?php $props = json_decode($model->properties, true); ?>
        <pre style="font-size: 11px"><?php print_r($props) ?></pre>
        <?php $category = \common\models\LeadsCategory::findOne(['name' => $props['Orders']['category_text']]); ?>
        <?php if(empty($category)): ?>
            <p><b style="color: #2a17c1">Категория лидов по указанному значению "<?= $props['Orders']['category_text'] ?>" - не найдена. Необходимо
                    <a target="_blank" href="<?= \yii\helpers\Url::to(['/lead-force/leads-category/create']) ?>">создать новую категорию</a> с указанным названием, или выбрать какую-либо из существующих</b></p>
        <?php endif; ?>
    <?php endif; ?>
    <div class="dialogue-chat-block">
        <?php if(empty($model->messages)): ?>
            <div>Диалог пуст</div>
        <?php else: ?>
            <div style="display: flex; flex-direction: column;">
                <?php foreach($model->messages as $msg): ?>
                <?php if($msg->isSupport === 1): ?>
                    <div class="message-pop message-pop-adm">
                        <div>
                            <div><?= $msg->message ?></div>
                            <hr>
                            <div style="font-size: 10px"><b>Вы</b>, <?= date("d.m.Y H:i", strtotime($msg->date)) ?></div>
                        </div>
                    </div>
                <?php else: ?>
                        <div class="message-pop message-pop-user">
                            <div>
                                <div><?= strip_tags($msg->message, "<br><b>") ?></div>
                                <hr>
                                <div style="font-size: 10px"><b><a target="_blank" href="<?= \yii\helpers\Url::to(['/users/view', 'id' => $model->user_id]) ?>">Пользователь</a></b>, <?= date("d.m.Y H:i", strtotime($msg->date)) ?></div>
                            </div>
                        </div>
                <?php endif; ?>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        <?= Html::beginForm(\yii\helpers\Url::to(['post-message']), 'POST', ['id' => 'sendForm']) ?>
        <div style="width: 100%; margin: 40px 0 5px">
            <input type="hidden" name="user_id" value="<?= $model->user_id ?>">
            <input type="hidden" name="peer_id" value="<?= $model->id ?>">
            <input type="hidden" name="hash" value="<?= md5("{$model->user_id}::{$model->id}::special_hash_to_prevent_hack::9mb21z") ?>">
            <input name="message" placeholder="Введите сообщение..." type="text" class="form-control" style="width: 90%; display: inline-block">
            <button type="submit" class="glyphicon glyphicon-send new-glyph" aria-hidden="true"></button>
        </div>
        <?= Html::endForm() ?>
    </div>

    <?php if($model->type === $model::TYPE_ORDER): ?>
        <?php $cats = \common\models\LeadsCategory::find()->asArray()->all(); ?>
        <input type="hidden" value="<?= $cats[0]['name'] ?>" class="serialize-order" name="Orders[category_text]">
        <h3>Сформировать заказ по указанным данным</h3>
        <div>
            <p><b>Выбрать категорию</b></p>
            <p>
                <select type="select" class="form-control chosen-select serialize-order" name="Orders[category_link]">
                    <?php if(!empty($cats)): ?>
                        <?php foreach($cats as $item): ?>
                            <option value="<?= $item['link_name'] ?>"><?= $item['name'] ?></option>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </select>
            </p>
        </div>
        <div>
            <p><b>Указать название заказа</b></p>
            <p><input type="text" name="Orders[order_name]" class="form-control serialize-order" value="" placeholder="БФЛ МСК от 300"></p>
        </div>
        <div>
            <p><b>Цена за лида, руб.</b></p>
            <p><input type="number" min="50" name="Orders[price]" class="form-control serialize-order" value="500" placeholder="500"></p>
        </div>
    <div class="btn btn-admin create-order">Сформировать заказ</div>
    <p style="margin-top: 15px"><b style="color: red">После формирования заказа - не забудьте ответить в тикет пользователю и закрыть диалог!</b></p>
    <?php elseif ($model->type === $model::TYPE_OFFER): ?>
        <?php $cats = \common\models\LeadsCategory::find()->asArray()->all(); ?>
        <h3>Сформировать оффер по указанным данным</h3>
        <div>
            <p><b>Выбрать категорию</b></p>
            <p>
                <select type="select" class="form-control chosen-select serialize-offer" name="Offers[category]">
                    <?php if(!empty($cats)): ?>
                        <?php foreach($cats as $item): ?>
                            <option value="<?= $item['link_name'] ?>"><?= $item['name'] ?></option>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </select>
            </p>
        </div>
        <div>
            <p><b>Указать название оффера</b></p>
            <p><input type="text" name="Offers[name]" class="form-control serialize-offer" value="" placeholder="БФЛ МСК от 300"></p>
        </div>
        <div>
            <p><b>Цена за лида, руб.</b></p>
            <p><input type="number" min="50" name="Offers[price]" class="form-control serialize-offer" value="150" placeholder="500"></p>
        </div>
        <div class="btn btn-admin create-offer">Сформировать оффер</div>
        <p style="margin-top: 15px"><b style="color: red">После формирования оффера - не забудьте ответить в тикет пользователю и закрыть диалог!</b></p>
    <?php endif; ?>

</div>
