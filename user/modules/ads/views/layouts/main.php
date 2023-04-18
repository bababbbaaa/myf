<?php

use user\assets\AdsAsset;
use yii\helpers\Html;

AdsAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<style>
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
</style>
<div class="preloader-ajax-forms">
    <div>
        Пожалуйста, ожидайте. Идет обработка данных...
    </div>
</div>
<section>
<?php $this->beginBody() ?>

<?php echo $this->render('_header') ?>

        <?= $content ?>

<?php echo $this->render('_footer') ?>
</section>
</article>
</main>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
