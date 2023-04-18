<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\SkillReviewsProfession */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'CMS', 'url' => '/cms/'];
$this->params['breadcrumbs'][] = ['label' => 'SKILL.FORCE', 'url' => ['/cms/skill/']];
$this->params['breadcrumbs'][] = ['label' => 'Отзывы', 'url' => ['/cms/skill/main/reviews']];
$this->params['breadcrumbs'][] = ['label' => 'Отзывы о профессиях', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="skill-reviews-profession-view">

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
            'name',
            'whois',
            'content:ntext',
            'date',
            'photo',
        ],
    ]) ?>

</div>
