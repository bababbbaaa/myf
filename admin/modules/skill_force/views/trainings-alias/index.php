<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\SkillTrainingsAliasSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Курсы пользователей';
$this->params['breadcrumbs'][] = ['label' => "Skill.Force", 'url' => '/skill-force/main/index'];
$this->params['breadcrumbs'][] = $this->title;
$users = \common\models\UserModel::find()->where(['status' => 10])->asArray()->select(['username', 'email', 'id'])->all();
$uar = [];
if (!empty($users)) {
    foreach ($users as $item) {
        $uar[$item['id']] = "{$item['username']}";
        if (!empty($item['email']))
            $uar[$item['id']] .= ", {$item['email']}";
    }
}

$crs = \common\models\SkillTrainings::find()->select(['name', 'id'])->asArray()->all();
if (!empty($crs))
    $crs = \yii\helpers\ArrayHelper::map($crs, 'id', 'name');
else
    $crs = [];
?>
<div class="skill-trainings-alias-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Добавить связь', ['create'], ['class' => 'btn btn-admin']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'id',
            [
                'attribute' => 'user_id',
                'value' => function ($model) use ($uar) {
                    return $uar[$model->user_id];
                }
            ],
            [
                'attribute' => 'course_id',
                'value' => function ($model) use ($crs) {
                    return $crs[$model->course_id];
                }
            ],
            'date',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
