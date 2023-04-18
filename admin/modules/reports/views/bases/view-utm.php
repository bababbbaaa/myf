<?php

/**
 * @var \yii\web\View $this
 */

use yii\helpers\Url;

$this->title = "Просмотр метки \"{$utm->name}\"";
$this->params['breadcrumbs'][] = [
    'url' => \yii\helpers\Url::to(['/reports/main/index']),
    'label' => 'Статистика'
];
$this->params['breadcrumbs'][] = ['label' => 'Базы', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => 'UTM-метки', 'url' => ['utms']];
$this->params['breadcrumbs'][] = $this->title;
$cache = Yii::$app->cache;
\yii\bootstrap\BootstrapPluginAsset::register($this);
$this->registerJsFile(Url::to(['/js/chart.js']), ['depends' => \yii\web\JqueryAsset::class]);
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
            location.href = "/reports/bases/utms";
        }
    });
});
JS;
$this->registerJs($js);


if (!empty($statistics)) {
    $counts = json_encode([$statistics[0]['total'], $statistics[0]['is1Total'], $statistics[0]['isCcTotal']]);
    $js2 = <<<JS
var ctx = document.getElementById('leadChart').getContext('2d');
var leadChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ['Всего контактов', 'Единички', 'Лидов после КЦ'],
        datasets: [{
            label: 'Количество',
            data: $counts,
            backgroundColor: [
                '#6092dd',
                '#db60dd',
                '#60dd7b',
            ],
        }]
    },
    options: {
        indexAxis: 'y',
        responsive: true,
        plugins: {
          legend: {
            position: 'top',
            display: false
          },
          title: {
            display: false,
            text: 'Диаграмма'
          }
        }
  },
});
JS;
    $this->registerJs($js2);
}

$view = $cache->get('c_view-utm?' . $_SERVER['QUERY_STRING'] ?? '');
if (!$view) {
    $view = $this->render('_cache_view_utm', ['models' => $models, 'pages' => $pages, 'utm' => $utm, 'statistics' => $statistics ?? null]);
    $dependency = new \yii\caching\DbDependency(['sql' => "SELECT COUNT(id) FROM bases_utm WHERE `name` = '{$utm->name}'"]);
    $cache->set('c_view-utm?' . $_SERVER['QUERY_STRING'] ?? '', $view, 3600, $dependency);
}

echo $view;