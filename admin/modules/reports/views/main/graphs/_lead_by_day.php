<?php
$dates = [];
foreach ($range as $date) {
    $dates[] = $date->format('d.m.y');
}
$countByDay = [];
if (!empty($leads)) {
    foreach ($leads as $item)
        $countByDay[date("d.m.y", strtotime($item['date_lead']))] = $item['summ'];
}
$counts = [];
foreach ($dates as $key => $item) {
    if (!empty($countByDay[$item]))
        $counts[] = (int)$countByDay[$item];
    else {
        $counts[] = 0;
    }
}
$counts = json_encode($counts);
$dates = json_encode($dates);
$js2 = <<<JS
var ctx = document.getElementById('leadChart').getContext('2d');
var leadChart = new Chart(ctx, {
    type: 'line',
    data: {
        labels: $dates,
        datasets: [{
            label: 'Количество',
            data: $counts,
            borderColor: [
                '#2ccd65',
            ],
            backgroundColor: [
                '#2ccd65',
            ],
            //cubicInterpolationMode: 'monotone',
        }]
    },
    options: {
        responsive: true,
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    stepSize: 1
                },
                max: Math.max.apply(null, $counts) + 10
            }
        },
    }
});
JS;
$this->registerJs($js2);
?>
<div>
    <div class="Statistics" style="position: relative; height:auto; width:60vw">
        <canvas id="leadChart" width="auto" height="200"></canvas>
    </div>
</div>
