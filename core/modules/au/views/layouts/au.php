<?php

/* @var $this \yii\web\View */
/* @var $content string */

use admin\assets\AdminAsset;
use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use common\widgets\Alert;
use common\models\RenderProcessor;
use yii\helpers\Url;


\core\assets\LeadAsset::register($this);
$user = Yii::$app->user;
$css = <<<CSS
    .preloader-ajax-forms {
        background-color: rgba(0, 0, 0, 0.85);
        position: fixed;
        top: 0;
        left: 0;
        display: none;
        width: 100%;
        height: 100%;
        z-index: 10000;
        user-select: none;
        cursor: not-allowed;
    }
    .preloader-ajax-forms > div {
        color: white;
        display: flex;
        width: 100%;
        height: 100%;
        justify-content: center;
        align-items: center;
        font-size: 24px;
        font-weight: 500;
    }
CSS;
$this->registerCss($css);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body class="monospace">
<style>

</style>
<div class="preloader-ajax-forms">
    <div>
        Пожалуйста, ожидайте. Идет обработка данных...
    </div>
</div>
<?php $this->beginBody() ?>
<div class="admin-container">
    <div class="content-block" style="min-height: calc(100vh - 240px)">
        <div class="bread-div"><?= Breadcrumbs::widget([
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            ]) ?></div>
        <div><?= Alert::widget() ?></div>
        <div class="admin-content">
            <div>
                <?= $content ?>
            </div>
        </div>
    </div>
</div>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>