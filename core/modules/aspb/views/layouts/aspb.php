<?php

/* @var $this \yii\web\View */

/* @var $content string */

use yii\helpers\Html;
use yii\helpers\Url;

\core\assets\AspbAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">

<head>
    <meta name="theme-color" content="#FF6E30">
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>

<body>
    <?php $this->beginBody() ?>
    <div class="wrapper">
        <header class="header">
            <div class="container">
                <?php if (Yii::$app->controller->action->id == 'index') : ?>
                    <nav class="header-nav">
                        <ul class="header-nav-list">
                            <li class="header-nav-list-item">
                                <a class="header--link active" href="#tab1">Прием дел в работу</a>
                            </li>
                            <li class="header-nav-list-item">
                                <a class="header--link" href="#tab2">Финансы АСПБ</a>
                            </li>
                            <li class="header-nav-list-item">
                                <a class="header--link" href="#tab3">Первичный отдел</a>
                            </li>
                            <li class="header-nav-list-item">
                                <a class="header--link" href="#tab4">Дела АСПБ</a>
                            </li>
                            <li class="header-nav-list-item">
                                <a class="header--link" href="#tab5">Снятие в банках</a>
                            </li>
                            <li class="header-nav-list-item">
                                <a class="header--link" href="#tab6">Реестр снятий</a>
                            </li>
                            <li class="header-nav-list-item">
                                <a class="header--link" href="#tab7">Должники и снятия</a>
                            </li>
                        </ul>
                    </nav>

                    <?= Html::beginForm('', '', ['id' => 'aspb_searchform']) ?>
                    <div class="searchform_container">
                        <input placeholder="Поиск..." class="input-t input-search" type="search" name="search">
                        <button class="search--btn"><svg width="25" height="24" viewBox="0 0 25 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M11 19C15.4183 19 19 15.4183 19 11C19 6.58172 15.4183 3 11 3C6.58172 3 3 6.58172 3 11C3 15.4183 6.58172 19 11 19Z" stroke="white" stroke-opacity="0.38" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                <path d="M21 20.9999L16.65 16.6499" stroke="white" stroke-opacity="0.38" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg></button>
                    </div>
                    <?= Html::endForm() ?>
                <?php else : ?>
                    <button onclick="history.back()" class="link--btn">На главную</button>
                <?php endif; ?>
            </div>
        </header>

        <main class="main">
            <?= $content ?>
        </main>

        <footer class="footer">
            <div class="container">

            </div>
        </footer>
        <div class="preloader">
            <div class="lds-dual-ring"></div>
        </div>
        <div class="popup__error--back">
            <div class="popup__error--body">
                <button type="button" class="popup__error--close">&times;</button>
                <img class="popup__error--image" src="<?= Url::to(['/aspb/img/error.png']) ?>" alt="">
                <p class="popup__error--title">Произошла ошибка!</p>
                <p class="popup__error--text">Ошибка созранения данных</p>
                <div class="popup__error--btnGroup">
                    <button type="button" class="popup__error--confirm">Понятно</button>
                </div>
            </div>
        </div>
    </div>
    <?php $this->endBody() ?>
</body>

</html>
<?php $this->endPage() ?>