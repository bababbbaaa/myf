<?php

namespace core\assets;

use yii\web\AssetBundle;
use yii\web\View;

/**
 * Main core application asset bundle.
 */
class LeadAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/lead.css',
        'css/adaptivlead.css',
        'css/jquery.formstyler.css',
        'css/jquery.formstyler.theme.css',
        'slick/fonts/slick.css',
        'slick/fonts/slick-theme.css',
    ];
    public $js = [
        'js/lead.js',
        'js/jquery.maskedinput.js',
        'slick/slick.min.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
        'yii\web\JqueryAsset',
    ];
}
