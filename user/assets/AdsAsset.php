<?php

namespace user\assets;

use yii\web\AssetBundle;

/**
 * Main user application asset bundle.
 */
class AdsAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/jquery.formstyler.css',
        'css/jquery.formstyler.theme.css',
        'css/reset.css',
        'css/style.css',
        'css/femidaclient.css',
        'css/skillclient.css',
        'css/adaptive.css',
        'css/femidaadaptive.css',
        'css/skilladaptive.css',
        'css/devstyle.css',
        'css/devadaptive.css',
        'css/adsstyle.css',
        'css/adsadaptive.css',
        'css/knowladge.css',
    ];
    public $js = [
        'js/alert.js',
        'js/jquery.formstyler.js',
        'js/jquery.maskedinput.js',
        'js/scriptFemida.js',
        'js/scriptSkill.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
    ];
}