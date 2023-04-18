<?php

$this->title = "Просмотр связей лида №{$model->id}";

$this->params['breadcrumbs'][] = ['label' => 'LEAD.FORCE', 'url' => ['/lead-force/main/index']];
$this->params['breadcrumbs'][] = ['label' => 'Таблица лидов', 'url' => ['/lead-force/leads/index']];
$this->params['breadcrumbs'][] = $this->title;


$js = <<<JS
$('.status-confirm').on('click', function(e) {
    e.preventDefault();
    var id = $(this).attr('data-id');
    $.ajax({
        data: {id:id},
        dataType: "JSON",
        type: "POST",
        url: '/lead-force/leads/confirm-status-waste'
    }).done(function(response) {
        if (response.status === 'success')
            location.reload();
        else {
            Swal.fire({
              icon: 'error',
              title: 'Ошибка',
              text: response.message,
            });
        }
    });
});
JS;

$this->registerJs($js);

use yii\widgets\DetailView; ?>


<h1 style="margin-bottom: 30px"><?= $this->title ?></h1>

<?php if(!empty($model->leadsSentReports)): ?>
    <table class="table table-bordered">
        <tr>
            <th>Дата отправки</th>
            <th>ID лида</th>
            <th>Тип отправки</th>
            <th>ID заказа</th>
            <th>ID клиента</th>
            <th>ID оффера</th>
            <th>ID поставщика</th>
            <th>Статус</th>
            <th>Комментарий к статусу</th>
            <th>Брак подтвержден?</th>
        </tr>
        <?php foreach($model->leadsSentReports as $item): ?>
        <?php if ($item->status === \common\models\Leads::STATUS_WASTE)
                $color = '#A2441B';
            elseif ($item->status === \common\models\Leads::STATUS_SENT)
                $color = '#2ea26c';
            elseif ($item->status === \common\models\Leads::STATUS_MODERATE)
                $color = '#d69759';
            elseif ($item->status === \common\models\Leads::STATUS_INTERVAL)
                $color = '#e013b4';
            elseif ($item->status === \common\models\Leads::STATUS_CONFIRMED)
                $color = '#1d724a';
            elseif ($item->status === \common\models\Leads::STATUS_AUCTION)
                $color = '#13a7e0';
            else
                $color = '#1370e0'; ?>
        <tr>
            <td><?= date("d.m.Y H:i", strtotime($item->date)) ?></td>
            <td><?= $item->lead_id ?></td>
            <td><?= $item->report_type ?></td>
            <td><?= $item->order_id ?></td>
            <td><?= $item->client_id ?></td>
            <td><?= $item->offer_id ?></td>
            <td><?= $item->provider_id ?></td>
            <td style="color: <?= $color ?>"><?= $item->status ?></td>
            <td>
                <?php if($item->status === \common\models\Leads::STATUS_WASTE): ?>
                    <?= $item->status_commentary ?>
                <?php else: ?>
                    -
                <?php endif; ?>
            </td>
            <td style="">
                <?php if($item->status === \common\models\Leads::STATUS_WASTE): ?>
                    <?php if($item->status_confirmed == 1): ?>
                        Да
                    <?php else: ?>
                    Нет

                        <br><a style="font-size: 12px" href="#" class="status-confirm" data-id="<?= $item->id ?>">(подтвердить)</a>

                    <?php endif; ?>
                <?php else: ?>
                -
                <?php endif; ?>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
<?php else: ?>
    <p><b>Связи не найдены.</b> Лид еще никому не отправлялся</p>
<?php endif; ?>

<?= DetailView::widget([
    'model' => $model,
    'attributes' => [
        'id',
        'ip',
        'date_income',
        'date_change',
        'status',
        [
            'attribute' => 'system_data',
            'format' => 'raw',
            'value' => function ($model) {
                $text = '';
                if (!empty($model->system_data)) {
                    foreach ($model->system_data as $key => $value)
                        if(!is_array($value))
                            $text .= strip_tags("{$key}: {$value}") . "<br>";
                        else
                            $text .= strip_tags("{$key}: ") . json_encode($value, JSON_UNESCAPED_UNICODE) . "<br>";
                }
                return $text;
            }
        ],
        'type',
        'name',
        'email:email',
        'phone',
        'region',
        'city',
        'comments:html',
        [
            'attribute' => 'params',
            'format' => 'raw',
            'value' => function ($model) {
                $text = '';
                if (!empty($model->params) )
                    foreach ($model->params as $key => $value)
                        $text .= strip_tags("{$key}: {$value}") . "<br>";
                return $text;
            }
        ],
    ],
]) ?>
