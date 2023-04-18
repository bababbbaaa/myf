<?php
/**
 * @var \yii\web\View $this
 */

use yii\helpers\Url;

$this->title = $model->name;
$this->params['breadcrumbs'][] = [
    'url' => \yii\helpers\Url::to(['/reports/main/index']),
    'label' => 'Статистика'
];
$this->params['breadcrumbs'][] = ['label' => 'Базы', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
\yii\bootstrap\BootstrapPluginAsset::register($this);
$this->registerCssFile(Url::to(['/css/chosen.min.css']));
$this->registerJsFile(Url::to(['/js/chosen.jquery.min.js']), ['depends' => \yii\web\JqueryAsset::class]);
$js = <<<JS
$('.preloader-ajax-forms').hide();
$('th').on('input', '[name="set_all"]', function() {
    $('.serialized-checkbox').each(function() {
        $(this).prop('checked', !$(this).prop('checked'));
    });
});
var serialized = null;
$('.use-action-base').on('click', function(e) {
    e.preventDefault();
    serialized = $('.serialized-checkbox:checked').serialize();
    var action = $(this).attr('data-action');
    switch (action) {
        case 'download-txt':
            $('input[name="serialized"]').val(serialized);
            $('#serializedSubmit').submit();
            break;
        case 'new-utm':
            $('.admin-simple-modal-bg').css('display', 'flex');
            break;
    }
});
$('.chosen-select').chosen();
$('.utmForm').on('submit', function(e) {
    e.preventDefault();
    $('.hidden_seri').val(serialized);
    var data = $(this).serialize();
    $.ajax({
        data: data,
        dataType: "JSON",
        type: "POST",
        url: '/reports/bases/set-new-utm-data',
        beforeSend: function () {
            $('.preloader-ajax-forms').fadeIn(100);
        }
    }).done(function(rsp) {
        $('.preloader-ajax-forms').fadeOut(100);
        if (rsp.status === 'error') {
            Swal.fire({
              icon: 'error',
              title: 'Ошибка',
              text: rsp.message,
            });
        } else {
            location.reload();
        }
    });
});
JS;
$this->registerJs($js);

$cache = Yii::$app->cache;

$view = $cache->get('c_base_view?' . $_SERVER['QUERY_STRING'] ?? '');
if (!$view) {
    $view = $this->render('_cache_view', [
        'model' => $model,
        'contacts' => $contacts,
        'pages' => $pages
    ]);
    $dependency = new \yii\caching\DbDependency(['sql' => "SELECT COUNT(id) FROM bases_contacts WHERE `base_id` = '{$model->id}'"]);
    $cache->set('c_base_view?' . $_SERVER['QUERY_STRING'] ?? '', $view, 3600, $dependency);
}

echo $view;