<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Clients */

$this->title = "$model->f $model->i";
$this->params['breadcrumbs'][] = ['label' => 'LEAD.FORCE', 'url' => ['/lead-force/main/index']];
$this->params['breadcrumbs'][] = ['label' => 'Клиенты', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="clients-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Обновить', ['update', 'id' => $model->id], ['class' => 'btn btn-admin']) ?>
        <?= Html::a('Данные плательщика', ['advanced-edit', 'id' => $model->id], ['class' => 'btn btn-admin-help']) ?>
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
            [
                'attribute' => 'id',
                'value' => function ($model) {
                    return "#{$model->id} {$model->f} {$model->i} {$model->o}";
                }
            ],
            'email:email',
            'user_id',
            'commentary:ntext',
            [
                'attribute' => 'company_info',
                'format' => 'raw',
                'value' => function ($model) {
                    if (!empty($model->company_info)) {
                        $json = json_decode($model->company_info, 1);
                        $text = '';
                        foreach ($json as $key => $item) {
                            if (is_array($item))
                                $item = json_encode($item, JSON_UNESCAPED_UNICODE);
                            $text .= "<b>{$key}</b>: {$item}<br>";
                        }
                        return $text;
                    } else
                        return null;
                }
            ],
            [
                'attribute' => 'requisites',
                'format' => 'raw',
                'value' => function ($model) {
                    if (!empty($model->requisites)) {
                        $json = json_decode($model->requisites, 1);
                        $text = '';
                        foreach ($json as $key => $item) {
                            if (is_array($item))
                                $item = json_encode($item, JSON_UNESCAPED_UNICODE);
                            $text .= "<b>{$key}</b>: {$item}<br>";
                        }
                        return $text;
                    } else
                        return null;
                }
            ],
            'date',
            [
                'attribute' => 'custom_params',
                'format' => 'raw',
                'value' => function ($model) {
                    if (!empty($model->custom_params)) {
                        $json = json_decode($model->custom_params, 1);
                        $text = '';
                        foreach ($json as $key => $item) {
                            if (is_array($item))
                                $item = json_encode($item, JSON_UNESCAPED_UNICODE);
                            $text .= "<b>{$key}</b>: {$item}<br>";
                        }
                        return $text;
                    } else
                        return null;
                }
            ],
        ],
    ]) ?>

</div>
