<?php

namespace core\assets;

use yii\web\AssetBundle;

/**
 * Main core application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/maincss/reset.css',
        'css/maincss/style.css',
        'css/maincss/adaptive.css',
        'css/maincss/jquery.formstyler.css',
        'css/maincss/jquery.formstyler.theme.css',
        'css/event-pages/event-pages-linkage.css',

    ];
    public $js = [
        'js/mainjs/jquery.formstyler.js',
        'js/mainjs/jquery.formstyler.min.js',
        'js/mainjs/jquery.maskedinput.js',
        'js/mainjs/script.js',
        'js/mainjs/scroll-nav.js',
        'js/mainjs/accordion.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}