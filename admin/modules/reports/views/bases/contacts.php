<?php

/**
 * @var \yii\web\View $this
 */

$this->title = "Контакты";
$this->params['breadcrumbs'][] = [
    'url' => \yii\helpers\Url::to(['/reports/main/index']),
    'label' => 'Статистика'
];
$this->params['breadcrumbs'][] = ['label' => 'Базы', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\bootstrap\BootstrapPluginAsset::register($this);
$cache = Yii::$app->cache;
$this->registerJs("$('.preloader-ajax-forms').hide();");
$view = $cache->get('c_contacts?' . $_SERVER['QUERY_STRING'] ?? '');
if (!$view) {
    $view = $this->render('_cache_contacts', [
        'models' => $models,
        'pages' => $pages,
    ]);
    $dependency = new \yii\caching\DbDependency(['sql' => 'SELECT COUNT(id) FROM bases_contacts']);
    $cache->set('c_contacts?' . $_SERVER['QUERY_STRING'] ?? '', $view, 3600, $dependency);
}

echo $view;