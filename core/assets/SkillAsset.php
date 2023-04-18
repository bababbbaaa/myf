<?php

namespace core\assets;

use yii\web\AssetBundle;
use yii\web\View;

/**
 * Main core application asset bundle.
 */
class SkillAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/slick.css',
        'css/slick-theme.css',
        'css/jquery.formstyler.css',
        'css/jquery.formstyler.theme.css',
        'css/skill.css',
        'css/adaptivskill.css',
    ];
    public $js = [
        'js/jquery.maskedinput.js',
        'js/jquery.formstyler.min.js',
        'js/jquery.fancybox.js',
        'js/slick.min.js',
        'js/skill.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
        'yii\web\JqueryAsset',
    ];
}
