<?php

namespace core\assets;

use yii\web\AssetBundle;
use yii\web\View;

/**
 * Main core application asset bundle.
 */
class DevAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/devforce/devforce.css',
        'css/devforce/devforceadaptive.css',
    ];
    public $js = [
        'js/jquery.maskedinput.js',
        'js/devforce/scriptdevforce.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\web\JqueryAsset',
    ];
}
