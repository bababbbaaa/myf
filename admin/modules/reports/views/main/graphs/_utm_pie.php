<?php

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
?>
<div>
    <div class="Statistics">
        <canvas id="leadChart" width="auto" height="100"></canvas>
    </div>
</div>