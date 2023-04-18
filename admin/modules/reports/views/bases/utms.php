<?php

/**
 * @var \yii\web\View $this
 */

$this->title = "UTM-метки";
$this->params['breadcrumbs'][] = [
    'url' => \yii\helpers\Url::to(['/reports/main/index']),
    'label' => 'Статистика'
];
$this->params['breadcrumbs'][] = ['label' => 'Базы', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
use yii\helpers\Html;
use yii\widgets\LinkPager;
$prov = \admin\models\Bases::find()->select('provider')->groupBy('provider')->asArray()->all();
?>

<div class="bases-index">
    <h1><?= Html::encode($this->title) ?></h1>
</div>
<div style="margin: 20px 0 15px">
    <?= Html::beginForm('/reports/bases/utms', 'GET') ?>
    <div style="display: flex; flex-wrap: wrap; align-items: flex-end">
        <div style="margin-right: 5px; margin-bottom: 5px">
            <p><b>Метка</b></p>
            <div><input class="form-control" type="text" name="filters[name]" placeholder="221021" value="<?= $_GET['filters']['name'] ?? '' ?>"></div>
        </div>
        <div style="margin-right: 5px; margin-bottom: 5px"><button class="btn btn-admin" type="submit">Поиск</button></div>
    </div>
    <?= Html::endForm() ?>
</div>
<?php if(!empty($models)): ?>
    <table class="table table-bordered table-striped">
        <tr style="background: #303030; color: whitesmoke">
            <th>Метка</th>
            <th>Дата</th>
        </tr>
        <?php foreach($models as $item): ?>
            <tr>
                <td><a href="/reports/bases/view-utm?name=<?= $item['name'] ?>"><?= $item['name'] ?></a></td>
                <td><?= date('d.m.Y H:i', strtotime($item['date'])) ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
    <?php if(!empty($pages)): ?>
        <?php echo LinkPager::widget([
            'pagination' => $pages,
        ]); ?>
    <?php endif; ?>
<?php endif; ?>
