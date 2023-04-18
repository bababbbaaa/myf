<?php

namespace core\assets;

use yii\web\AssetBundle;
use yii\web\View;

/**
 * Main core application asset bundle.
 */
class AspbAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        '/css/chosen.min.css',
        'aspb/css/reset.css',
        'aspb/css/aspb.css',
        'aspb/css/adaptive.css',
    ];
    public $js = [
        '/js/chosen.jquery.min.js',
        'aspb/js/aspb.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\web\JqueryAsset',
    ];
}