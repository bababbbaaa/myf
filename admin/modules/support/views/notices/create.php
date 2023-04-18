<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\UsersNotice */

$this->title = 'Создать уведомление';
$this->params['breadcrumbs'][] = ['label' => 'Поддержка', 'url' => ['/support/main/index']];
$this->params['breadcrumbs'][] = ['label' => 'Уведомления', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="users-notice-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
