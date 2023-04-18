<?php

/* @var $this \yii\web\View */
/* @var $content string */

use admin\assets\AdminAsset;
use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use common\widgets\Alert;
use common\models\RenderProcessor;
use yii\helpers\Url;


AdminAsset::register($this);
$sidebar = RenderProcessor::getSidebarInfo();
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
<?php if(!empty($_SESSION['validation_passed']) && $_SESSION['validation_passed'] === true): ?>
    <div style="background-color: #303030">
        <div class="admin-topline" style="max-width: 2000px; margin: 0 auto">
            <div class="fade-sidebar" style="display: block; position: absolute; top: 11px; right: 60px; cursor: pointer">
                <span class="glyphicon glyphicon-fullscreen" aria-hidden="true" title="Спрятать меню"></span>
            </div>
            <div class="pd020"><a class="not-a-link" href="<?= \yii\helpers\Url::to(['/site/index']) ?>"><strong>MY.FORCE</strong></a></div>
            <?php $module = Yii::$app->controller->module->id; $linkArray = RenderProcessor::renderTopMini(); ?>
            <?php if(!empty($linkArray[$module])): ?>
                <?php foreach($linkArray[$module] as $l => $item): ?>
                    <?php if($user->can($item['access'])): ?>
                        <div class="pd020 hide768"><a class="not-a-link" href="<?= $l ?>"><strong><?= $item['name'] ?></strong></a></div>
                    <?php endif; ?>
                <?php endforeach; ?>
            <?php endif; ?>
            <div class="topline-burger"><span class="glyphicon glyphicon-menu-down" aria-hidden="true"></span></div>
        </div>
    </div>
    <div class="hidden-menu">
        <?php foreach($sidebar as $link => $item): ?>

            <?php if (RenderProcessor::check__if__can($item, $user)): ?>
                <div class="sidebar-div"><a class="sidebar-link" href="<?= $link ?>"><?= $item['title'] ?></a></div>
            <?php endif; ?>
        <?php endforeach; ?>
    </div>
<?php endif; ?>
<div class="admin-container">
    <?php if($user->can('adminLogin') && (!empty($_SESSION['validation_passed']) && $_SESSION['validation_passed'] === true)): ?>
        <div class="menu-bar hide768 <?= !empty($_SESSION['sidebar']) ? 'faded-sidebar' : '' ?>">
            <?php
                $url = Yii::$app->request->getUrl();
                $urlArray = explode('?', $url);
            ?>
            <?php foreach($sidebar as $link => $item): ?>
                <?php $cSmall = ''; $html = ''; ?>
                <?php if (RenderProcessor::check__if__can($item, $user)): ?>
                    <?php
                    if($link !== Yii::$app->homeUrl) {
                        $class = mb_strpos($urlArray[0], $link) !== false ? 'active-sidebar' : '';
                        if (mb_strpos($urlArray[0], '/contact-center/settings/') !== false && $link === '/settings')
                            $class = '';
                        $print = Url::to(["{$link}/main/index"]);
                    }
                    else {
                        if (Yii::$app->controller->module->id === 'app-admin') {
                            $class = 'active-sidebar';
                            $print = Url::to(["{$link}"]);
                        } else {
                            $class = $urlArray[0] === Yii::$app->homeUrl ? 'active-sidebar' : '';
                            $print = Url::to(["{$link}"]);
                        }
                    }

                    ?>
                    <div class="sidebar-div"><a class="sidebar-link <?= $class ?>" href="<?= $print ?>"><span style="font-size: 16px" class="glyphicon glyphicon-<?= $item['glyph'] ?>" aria-hidden="true"></span> <?= $item['title'] ?></a></div>
                <?php endif; ?>
            <?php endforeach; ?>
            <div class="sidebar-div" style="margin-top: auto; ">
                <?= Html::beginForm(['/site/logout'], 'post') ?>
                <?= Html::submitButton(
                    'ВЫХОД (' . $user->identity->username . ')',
                    ['class' => 'logout nocolor sidebar-link monospace', 'style' => 'width:100%; border-top: 1px solid gainsboro; letter-spacing: 0.1em']
                ) ?>
                <?= Html::endForm() ?>
            </div>
        </div>
    <?php endif; ?>
    <div class="content-block <?= !empty($_SESSION['sidebar']) ? 'faded-content' : '' ?>" style="min-height: calc(100vh - 240px)">
        <div class="bread-div"><?= Breadcrumbs::widget([
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            ]) ?></div>
        <div><?= Alert::widget() ?></div>
        <div class="admin-content">
            <div>
                <?= $content ?>
            </div>
            <?php if(!$user->can('adminLogin')): ?>
            <div style="margin-top: 10px">
                <a style="font-size: 20px; font-weight: 700" href="<?= Url::to(['site/logout']) ?>">Выход</a>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>