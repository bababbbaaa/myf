<?php


$this->title = "Активные бекдоры";

$this->params['breadcrumbs'][] = ['label' => 'LEAD.FORCE', 'url' => ['/lead-force/main/index']];
$this->params['breadcrumbs'][] = ['label' => 'Таблица лидов', 'url' => ['/lead-force/leads/index']];
$this->params['breadcrumbs'][] = ['label' => 'Лиды с бекдора', 'url' => ['/lead-force/leads/backdoor']];
$this->params['breadcrumbs'][] = $this->title;


$js = <<<JS
$('.class-open-form').on('click', function() {
    $('.hidden-form').toggle();
});
$('.save-link').on('click', function() {
    var url = $('.urlinp').val();
    if (url.length > 0) {
        $.ajax({
            data: {url: url},
            dataType: "JSON",
            type: "POST",
            url: 'save-new-hook'
        }).done(function(e) {
            if (e.status === 'success') {
                Swal.fire({
                  icon: 'success',
                  title: 'Бекдор установлен',
                  text: "Активность бекдора будет проверена в 23:45 по МСК",
                }).then((e) => {
                    location.reload();
                });
            }
            else {
                Swal.fire({
                  icon: 'error',
                  title: 'Ошибка',
                  text: e.message,
                });
            }
        });
    }
});
JS;

$this->registerJs($js);

?>

    <style>
        .not_active, .not_active > a {
            color: #9e9e9e !important;
        }
    </style>

<div>
    <h1>Активные бекдоры</h1>
</div>
<div class="btn btn-admin class-open-form" style="margin-bottom: 20px">
    Добавить новый
</div>
<div class="hidden-form" style="margin-bottom: 20px; display: none">
    <div style="display: flex">
        <div style="margin-right: 10px; max-width: 600px;width: 100%"><input autocomplete="off" class="form-control urlinp" type="text" placeholder="https://cfs.bitrix24.ru/rest/11816/owy8ssv5onynllfs/" name="url"></div>
        <div><div class="btn btn-admin-help save-link">Сохранить</div></div>
    </div>
</div>
<?php if(!empty($hooks)): ?>
    <table class="table table-bordered table-responsive">
        <tr>
            <th>ID</th>
            <th>URL</th>
            <th>Дата</th>
        </tr>
        <?php foreach($hooks as $item): ?>
        <tr>
            <td class="<?= $item['status'] == 0 ? 'not_active' : '' ?>"><?= $item['id'] ?></td>
            <td class="<?= $item['status'] == 0 ? 'not_active' : '' ?>"><a target="_blank" href="<?= $item['url'] ?>/crm.lead.list?order[id]=desc"><?= $item['url'] ?></a></td>
            <td class="<?= $item['status'] == 0 ? 'not_active' : '' ?>"><?= date("d.m.Y H:i", strtotime($item['date'])) ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
<?php else: ?>
<p style="color: #9e9e9e">Активные бекдоры</p>
<?php endif; ?>