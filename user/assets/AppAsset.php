<?php

namespace user\assets;

use yii\web\AssetBundle;

/**
 * Main user application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/jquery.formstyler.css',
        'css/jquery.formstyler.theme.css',
        'css/reset.css',
        'css/femidaclient.css',
        'css/femidaadaptive.css',
        'css/style.css',
        'css/adaptive.css',
        'css/banners.css',
        'css/knowladge.css',
//        'css/site.css',
    ];
    public $js = [
        'js/alert.js',
        'js/jquery.formstyler.js',
        'js/jquery.maskedinput.js',
        'js/script.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
//        'yii\bootstrap\BootstrapAsset',
    ];
}
