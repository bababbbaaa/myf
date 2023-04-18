<?php

/**
 * @var \yii\web\View $this
 */

use yii\widgets\LinkPager;

$this->title = 'Документы поставщиков';
$this->params['breadcrumbs'][] = [
    'url' => \yii\helpers\Url::to(['/logs/main/index']),
    'label' => 'ЛОГИ'
];
$this->params['breadcrumbs'][] = $this->title;

$js = <<<JS
$('.cnf').on('click', function(e) {
    var id = $(this).attr('data-id');
    var action = $(this).attr('data-action');
    $.ajax({
        data: {id:id, action: action},
        url: "/logs/main/status-provider-docs",
        dataType: "JSON",
        type: "POST"
    }).done(function(rsp) {
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

?>
<style>
    .btn-confirmation {
        background-color: #2ea26c;
        color: white;
        border-radius: 0;
    }
    .btn-confirmation:hover {
        color: white;
        background-color: #23784f;
    }
    .btn-admin-delete {
        padding: 5px 23px;
    }
</style>
<div>
    <h3>Документы поставщиков</h3>
    <?php if(!empty($docs)): ?>
        <table class="table table-responsive table-bordered">
            <tr>
                <th>ID</th>
                <th>Пользователь</th>
                <th>Тип</th>
                <th>Сумма</th>
                <th>Даты</th>
                <th>Файлы</th>
                <th>Статус</th>
            </tr>
            <?php foreach($docs as $item): ?>
                <tr>
                    <td><?= $item['id'] ?></td>
                    <td><a target="_blank" href="<?= \yii\helpers\Url::to(['/users/view', 'id' => $item['user_id']]) ?>">польз. #<?= $item['user_id'] ?></a></td>
                    <td><?= $item['type'] === 'fiz' ? 'Физ.лицо' : 'Счет' ?></td>
                    <td><?= number_format($item['value'], 0, '', ' ') ?> руб.</td>
                    <td>
                        <p><b>Запрошен:</b> <?= date("d.m.Y", strtotime($item['date'])) ?></p>
                        <p><b>Годен до:</b> <?= date("d.m.Y", strtotime($item['date_exp'])) ?></p>
                    </td>
                    <td>
                        <p><a href="<?= \yii\helpers\Url::to([$item['link_report']]) ?>">отчет агента</a></p>
                        <?php if($item['type'] === 'jur'): ?>
                            <p><a href="<?= \yii\helpers\Url::to([$item['link_bill']]) ?>">счет</a></p>
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php if($item['status'] == 0): ?>
                            <p>
                                <button data-id="<?= $item['id'] ?>" class="btn btn-confirmation cnf" data-action="success">подтвердить</button>
                            </p>
                            <p>
                                <button data-id="<?= $item['id'] ?>" class="btn btn-admin-delete cnf" data-action="fail">отказать</button>
                            </p>
                        <?php else: ?>
                        <b style="color: #2ea26c">подтвержден</b>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php else: ?>
    <div style="color: #9e9e9e">Документов, требующих модерации, не обнаружено</div>
    <?php endif; ?>
</div>
