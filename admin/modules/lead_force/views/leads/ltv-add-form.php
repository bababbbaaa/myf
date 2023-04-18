<?php

$js = <<<JS
$('#form-product-saver').on('submit', function (e) {
    var form = $(this);
    e.preventDefault();
    $.ajax({
        data: form.serialize(),
        dataType: "JSON",
        type: "POST",
        url: '/lead-force/leads/ltv-save'
    }).done(function (response) {
        if (response.status) {
            location.reload();
        }
        else
            alert(response.message);
    });
});
JS;
$this->registerJs($js);

?>
<?= \yii\helpers\Html::beginForm(['ltv-save'], 'POST', ['id' => 'form-product-saver']) ?>
    <input type="hidden" name="saver-client" value="<?= $id ?>">
<div style="display: flex; gap: 10px; flex-direction: row; align-items: flex-end; margin-bottom: 10px">

    <div style="max-width: 33%; min-width: 150px; width: 100%">
        <div><b>Продукт</b></div>
        <div><input type="text" name="saver-prodname" class="form-control" placeholder="Например, Франшиза БФЛ"></div>
    </div>
    <div style="max-width: 33%; min-width: 150px; width: 100%">
        <div><b>Сумма</b></div>
        <div><input type="number" name="saver-summ" placeholder="Например - 45000" min="0" class="form-control" value=""></div>
    </div>
    <div style="max-width: 33%; min-width: 150px; width: 100%">
        <div></div>
        <div><button type="submit" class="btn btn-admin">Сохранить</button></div>
    </div>


</div>
<?= \yii\helpers\Html::endForm() ?>