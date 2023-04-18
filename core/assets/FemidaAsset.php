<?php

namespace core\assets;

use yii\web\AssetBundle;
use yii\web\View;

/**
 * Main core application asset bundle.
 */
class FemidaAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/femida.css',
        'css/adaptivefemida.css',
    ];
    public $js = [
        'js/jquery.maskedinput.js',
        'js/femida.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
        'yii\web\JqueryAsset',
    ];
}