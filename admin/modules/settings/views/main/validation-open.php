<?php

$this->title = "Валидация рабочих мест";
$this->params['breadcrumbs'][] = ['label' => "Настройки и мониторинг", 'url' => '/settings/'];
$this->params['breadcrumbs'][] = $this->title;

$js = <<<JS
$('.change-validation-status').on('click', function() {
    $.ajax({
        data: {change: 1},
        dataType: "JSON",
        type: "POST",
        url: "/settings/main/validation-change"
    }).done(function(rsp) {
        if (rsp.status === 'success') {
            location.reload();
        }
        else {
            Swal.fire({
              icon: 'error',
              title: 'Ошибка',
              text: rsp.message,
            });
        }
    });
});
JS;
$this->registerJs($js);
?>

<div>
    <h3><?= $this->title ?></h3>
    <p><b>Текущее состояние ссылки валидации:</b> <?= (int)$validation->hash === 1 ? "<span style='color: green'>открыта</span>" : "<span style='color: red'>закрыта</span>" ?></p>
    <p><a target="_blank" href="<?= \yii\helpers\Url::to(['/site/set-access']) ?>">Ссылка валидации</a></p>
    <p>
        <button class="btn btn-admin change-validation-status"><?= (int)$validation->hash === 1 ? 'Закрыть' : 'Открыть' ?> валидацию</button>
    </p>
</div>


