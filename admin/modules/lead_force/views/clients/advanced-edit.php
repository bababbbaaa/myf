<?php

/**
 * @var \common\models\Clients $model
 */

$this->title = "Расширенный редактор";
$this->params['breadcrumbs'][] = ['label' => 'LEAD.FORCE', 'url' => ['/lead-force/main/index']];
$this->params['breadcrumbs'][] = ['label' => 'Клиенты', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => "$model->f $model->i", 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = $this->title;


$js = <<<JS
$('[name="type"]').on('change', function() {
   $('.hides').hide();
   $('.' + $(this).val() + '_inputs').show();
});
$('.checks').on('change', function() {
    if ($(this).prop('checked'))
        $('.check_' + $(this).val()).show();
    else
        $('.check_' + $(this).val()).hide();
});
JS;
$this->registerJs($js);
$reqs = json_decode($model->requisites, 1);
$profile = json_decode($model->company_info, 1);
?>

<h3>Клиент <?= "$model->f $model->i" ?></h3>
<hr>
<div style="">
    <?= \yii\helpers\Html::beginForm() ?>
    <p><b>Общие данные профиля</b></p>
    <div style="margin-top: 15px">
        <div><input type="radio" <?= empty($profile) || !empty($profile['fiz']) ? 'checked' : '' ?> name="type" value="fiz" id="fiz_rad"> <label for="fiz_rad">Физическое лицо</label></div>
        <div><input type="radio" <?= !empty($profile) && !empty($profile['jur']) ? 'checked' : '' ?> name="type" value="jur" id="jur_rad"> <label for="jur_rad">Юридическое лицо</label></div>
    </div>
    <div class="fiz_inputs hides" style="display: <?= empty($profile) || !empty($profile['fiz']) ? 'block' : 'none' ?>">
        <h4>Физ. лицо</h4>
        <div><b>Адрес по паспорту</b></div>
        <div><input type="text" class="form-control" value="<?= !empty($profile['fiz']['address']) ? $profile['fiz']['address'] : '' ?>" name="fiz_common[address]" placeholder="г. Ростов-на-Дону, ул. Картошки, 11/22"></div>
    </div>
    <div class="jur_inputs hides" style="display: <?= !empty($profile) && !empty($profile['jur']) ? 'block' : 'none' ?>">
        <h4>Юр. лицо</h4>
        <div><b>Полное название организации</b></div>
        <div><input type="text" value="<?= !empty($profile['jur']['companyName']) ? $profile['jur']['companyName'] : '' ?>" class="form-control" name="jur_common[companyName]" placeholder="ООО Ололо"></div>
        <div style="margin-top: 10px"><b>Генеральный директор</b></div>
        <div><input type="text" value="<?= !empty($profile['jur']['director']) ? $profile['jur']['director'] : '' ?>" class="form-control" name="jur_common[director]" placeholder="Петров Алексей Иванович"></div>
        <div style="margin-top: 10px"><b>Юридический адрес</b></div>
        <div><input type="text" value="<?= !empty($profile['jur']['address_jur']) ? $profile['jur']['address_jur'] : '' ?>" class="form-control" name="jur_common[address_jur]" placeholder="343000, г. Ростов-на-Дону, ул. Картошки, 11/22"></div>
        <div style="margin-top: 10px"><b>Фактический адрес</b></div>
        <div><input type="text" value="<?= !empty($profile['jur']['address_real']) ? $profile['jur']['address_real'] : '' ?>" class="form-control" name="jur_common[address_real]" placeholder="343000, г. Ростов-на-Дону, ул. Картошки, 11/22"></div>
        <div style="margin-top: 10px"><b>Веб-сайт</b></div>
        <div><input type="text" value="<?= !empty($profile['jur']['web_site']) ? $profile['jur']['web_site'] : '' ?>" class="form-control" name="jur_common[web_site]" placeholder="mysite.ru"></div>
        <div style="margin-top: 10px"><b>Сфера деятельности</b></div>
        <div><input type="text" value="<?= !empty($profile['jur']['work']) ? $profile['jur']['work'] : '' ?>" class="form-control" name="jur_common[work]" placeholder="Юридические услуги"></div>
    </div>
    <hr>
    <p><b>Плательщики</b></p>
    <div class="row">
        <div class="col-md-6">
            <div><input type="checkbox" <?= !empty($reqs['fiz']) ? 'checked' : '' ?> name="payments[]" class="checks" value="fiz" id="fiz_check"> <label for="fiz_check">Физическое лицо</label></div>
            <div class="show-check check_fiz" style="display: <?= !empty($reqs['fiz']) ? 'block' : 'none' ?>">
                <div style="margin-top: 10px"><b>Фамилия</b></div>
                <div><input type="text" class="form-control" value="<?= !empty($reqs['fiz']['f']) ? $reqs['fiz']['f'] : '' ?>" name="fiz[f]" placeholder="Петров"></div>
                <div style="margin-top: 10px"><b>Имя</b></div>
                <div><input type="text" class="form-control" name="fiz[i]" value="<?= !empty($reqs['fiz']['i']) ? $reqs['fiz']['i'] : '' ?>" placeholder="Алексей"></div>
                <div style="margin-top: 10px"><b>Отчество</b></div>
                <div><input type="text" class="form-control" name="fiz[o]" value="<?= !empty($reqs['fiz']['o']) ? $reqs['fiz']['o'] : '' ?>" placeholder="Иванович"></div>
                <div style="margin-top: 10px"><b>Адрес регистрации</b></div>
                <div><input type="text" class="form-control" name="fiz[address]" value="<?= !empty($reqs['fiz']['address']) ? $reqs['fiz']['address'] : '' ?>" placeholder="г. Иваново, ул. Ташкентская, д.65, кв.8"></div>
                <div style="margin-top: 10px"><b>Номер телефона</b></div>
                <div><input type="text" class="form-control" name="fiz[phone]" value="<?= !empty($reqs['fiz']['phone']) ? $reqs['fiz']['phone'] : '' ?>" placeholder="+7(964) 492-7335"></div>
                <div style="margin-top: 10px"><b>Номер телефона</b></div>
                <div><input type="text" class="form-control" name="fiz[email]" value="<?= !empty($reqs['fiz']['email']) ? $reqs['fiz']['email'] : '' ?>" placeholder="email@mail.ru"></div>
            </div>
        </div>
        <div class="col-md-6">
            <div><input type="checkbox" name="payments[]" <?= !empty($reqs['jur']) ? 'checked' : '' ?> class="checks" value="jur" id="jur_check"> <label for="jur_check">Юридическое лицо</label></div>
            <div class="show-check check_jur" style="display: <?= !empty($reqs['jur']) ? 'block' : 'none' ?>">
                <div style="margin-top: 10px"><b>Полное название организации</b></div>
                <div><input type="text" class="form-control" name="jur[organization]" value="<?= !empty($reqs['jur']['organization']) ? $reqs['jur']['organization'] : '' ?>" placeholder="ООО Ололо"></div>
                <div style="margin-top: 10px"><b>Генеральный директор</b></div>
                <div><input type="text" class="form-control" name="jur[director]" value="<?= !empty($reqs['jur']['director']) ? $reqs['jur']['director'] : '' ?>" placeholder="ООО Ололо"></div>
                <div style="margin-top: 10px"><b>Юридический адрес</b></div>
                <div><input type="text" class="form-control" name="jur[jur_address]" value="<?= !empty($reqs['jur']['jur_address']) ? $reqs['jur']['jur_address'] : '' ?>" placeholder="г. Иваново, ул. Ташкентская, д.65, кв.8"></div>
                <div style="margin-top: 10px"><b>Фактический адрес</b></div>
                <div><input type="text" class="form-control" name="jur[real_address]" value="<?= !empty($reqs['jur']['real_address']) ? $reqs['jur']['real_address'] : '' ?>" placeholder="г. Иваново, ул. Ташкентская, д.65, кв.8"></div>
                <div style="margin-top: 10px"><b>ИНН</b></div>
                <div><input type="text" class="form-control" name="jur[inn]" value="<?= !empty($reqs['jur']['inn']) ? $reqs['jur']['inn'] : '' ?>" placeholder="1212121212"></div>
                <div style="margin-top: 10px"><b>ОГРН(ИП)</b></div>
                <div><input type="text" class="form-control" name="jur[ogrn]" value="<?= !empty($reqs['jur']['ogrn']) ? $reqs['jur']['ogrn'] : '' ?>" placeholder="1212121212123"></div>
                <div style="margin-top: 10px"><b>КПП</b></div>
                <div><input type="text" class="form-control" name="jur[kpp]" value="<?= !empty($reqs['jur']['kpp']) ? $reqs['jur']['kpp'] : '' ?>" placeholder="121212121"></div>
                <div style="margin-top: 10px"><b>Название банка</b></div>
                <div><input type="text" class="form-control" name="jur[bank]" value="<?= !empty($reqs['jur']['bank']) ? $reqs['jur']['bank'] : '' ?>" placeholder="Сбербанк"></div>
                <div style="margin-top: 10px"><b>БИК</b></div>
                <div><input type="text" class="form-control" name="jur[bik]" value="<?= !empty($reqs['jur']['bik']) ? $reqs['jur']['bik'] : '' ?>" placeholder="121212121"></div>
                <div style="margin-top: 10px"><b>Расчетный счет</b></div>
                <div><input type="text" class="form-control" name="jur[rs]" value="<?= !empty($reqs['jur']['rs']) ? $reqs['jur']['rs'] : '' ?>" placeholder="12121212121212121212"></div>
                <div style="margin-top: 10px"><b>Корреспондентский счет</b></div>
                <div><input type="text" class="form-control" name="jur[ks]" value="<?= !empty($reqs['jur']['ks']) ? $reqs['jur']['ks'] : '' ?>" placeholder="12121212121212121212"></div>
            </div>
        </div>
    </div>
    <div style="margin-top: 10px;">
        <button type="submit" class="btn btn-admin">Сохранить</button>
    </div>
    <?= \yii\helpers\Html::endForm() ?>
</div>




