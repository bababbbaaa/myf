<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\SystemdSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Фоновые процессы';
$this->params['breadcrumbs'][] = ['label' => "Настройки и мониторинг", 'url' => '/settings/'];
$this->params['breadcrumbs'][] = $this->title;
$user = Yii::$app->getUser();
?>
<div class="systemd-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php if($user->can('daemonCRUD')): ?>
        <p>
            <?= Html::a('Добавить фоновый процесс', ['create'], ['class' => 'btn btn-admin']) ?>
        </p>
    <?php endif; ?>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>


    <?php

    $arr = [
        'name',
        [
            'header' => 'Статус',
            'format' => 'raw',
            'contentOptions' => ['style' => 'max-width:700px'],
            'value' => function ($model) {
                if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
                    return 'Exception: Windows OS';
                } else {
                    $response = [];
                    exec("systemctl status {$model->name}", $response);
                    return "<pre style='max-width: 100%'>". print_r($response, 1) ."</pre>";
                }
            }
        ],
        'service_description',
    ];

    if ($user->can('daemonCRUD'))
        $arr[] = ['class' => 'yii\grid\ActionColumn'];

    ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => $arr
    ]); ?>


</div>
