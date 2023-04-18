<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\SkillReviewsVideo */

$this->title = 'Добавить видео-отзыв';
$this->params['breadcrumbs'][] = ['label' => 'CMS', 'url' => '/cms/'];
$this->params['breadcrumbs'][] = ['label' => 'SKILL.FORCE', 'url' => ['/cms/skill/']];
$this->params['breadcrumbs'][] = ['label' => 'Отзывы', 'url' => ['/cms/skill/main/reviews']];
$this->params['breadcrumbs'][] = ['label' => 'Видео-отзывы', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="skill-reviews-video-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
