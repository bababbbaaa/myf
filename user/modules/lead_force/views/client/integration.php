<?php

use user\modules\lead_force\controllers\ClientController;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Интеграции';

$integrations_special = \common\models\IntegrationsSpecialParams::find()->asArray()->all();
$leadCategory = \common\models\LeadsCategory::find()->asArray()->all();
if (!empty($leadCategory)) {
    foreach ($leadCategory as $lc) {
        $leadCatArr[$lc['link_name']] = $lc['name'];
    }
}
$LeadParams = \common\models\LeadsParams::find()->asArray()->all();
if (!empty($LeadParams) && !empty($leadCatArr)) {
    foreach ($LeadParams as $p) {
        $paramArray[$leadCatArr[$p['category']]][$p['name']] = $p['description'];
    }
}

$order_id = $_GET['order_id'];
$js = <<< JS
    var webhook = '',
        globalURL = '';
    $('.webhook__confirm').on('click', function() {
      var link = $('input[name="webhook_url"]').val();
      $.ajax({
        url: 'webhook-accept',
        data: {url:link},
        dataType: 'JSON',
        type: 'POST',
      }).done(function(rsp) {
        if (rsp.status === 'success'){
            $('.rsp--ajax__text').text('Данные корректны');
            $('.popup--auct').fadeIn(300);
            $('.confirm_btn-send').prop('disabled', false);
            webhook = link;
            $('.webhook__confirm').prop('disabled', true);
            setTimeout(function() {
                $('.webhook__confirm').prop('disabled', false);
            }, 10000)
            
        } else {
            $('.rsp-ajax-text').html(rsp.message);
            $('.popup--auct-err').fadeIn(300);
        }
      });
    });
    $('.confirm_btn-send').on('click', function() {
        $.ajax({
            url: 'create-integration',
            data: $('.hook_form').serialize(),
            dataType: 'JSON',
            type: 'POST',
        }).done(function(rsp) {
            Swal.fire({
               icon: 'success',
               title: 'Успех!',
               html: "Сохранено",
            }).then((result) => {
            location.reload();
          });
        })
    });
    
    $('.bitrix__correct').on('click', function() {
        var url = $('input[name="bitrix__correct"]').val(),
            checkUrl = null;
        try {
          checkUrl = new URL(url);
        } catch (e) {
            console.log(e);
        }
        if (checkUrl === null){
            $('.rsp-ajax-text').text('Указанный вебхук Битрикс24 не является валидным URL-адресом');
            $('.popup--auct-err').fadeIn(300);
        } else {
            var newUrl = checkUrl.origin,
                splits = checkUrl.pathname.split('/');
            for (var i = 1; i < splits.length; i++) {
                newUrl += "/" + splits[i];
                if (i === 3)
                    break;
            }
            globalURL = newUrl;
            $('#integrations-url').val(newUrl);
            $.ajax({
                url: newUrl + "/crm.lead.fields",
                dataType: 'JSON',
            }).done(function(e) {
              if (e.result === undefined) {
                  $('.rsp-ajax-text').text('Вероятно, указанная ссылка не является валидным вебхуком Битрикс24');
                  $('.popup--auct-err').fadeIn(300);
              } else {
                  var fields = e.result;
                  $('.rsp--ajax__text').text('Ссылка на вебхук корректная, и имеет необходимые привилегии');
                  $('.popup--auct').fadeIn(300);
              }
              var html = '';
              for (var key in fields){
                  if (fields[key].isReadOnly === true)
                      continue;
                  html += '<div class="params_info">';
                  html += '<span class="params__info-title source_pol">'+ key +'</span>';
                  if (fields[key].listLabel !== undefined) {
                   html += '<span class="params__info-name">: ' + fields[key].listLabel + '</span>';
                  } else {
                      html += '<span class="params__info-name">: ' + fields[key].title + '</span>';
                  }
                  if (fields[key].type === 'enumeration'){
                      html += '<div>';
                      for (var keyItem in fields[key].items){
                          html += "<span style='font-size: 11px'>";
                            html += "<i>" + fields[key].items[keyItem].VALUE + "</i>: <b>" + fields[key].items[keyItem].ID + "</b>";
                            html += ", </span>";
                      }
                      html += '</div>';
                  }
                  html += '</div>';
              }
                $('.fade__forms').fadeIn(500);
                  $('#params_field').html(html);
              $.ajax({
                url: newUrl + "/crm.status.entity.items?entityId=SOURCE",
                dataType: "JSON"
              }).done(function(rsp) {
                  var html2 = '';
                if (rsp.result !== undefined){
                    for (var i = 0; i < rsp.result.length; i++){
                        html2 += "<div class='params_info'>";
                        html2 += "<span class='params__info-title source__bitrix' data-id='" + rsp.result[i].STATUS_ID +"'>"+ rsp.result[i].NAME +"</span>";
                        html2 += '<span class="params__info-name">: ' + rsp.result[i].STATUS_ID + '</span>';
                        html2 += '</div>';
                    }               
                    html2 += "<div style='margin: 10px; font-size: 14px' class='btn btn-admin-help addSourceFemida'>Добавить источник Lead.Force</div>";
                    $('#params_sources').html(html2);
                }
              });
               $.ajax({
                    url: newUrl + "/crm.status.entity.items?entityId=STATUS",
                    dataType: "JSON"
                }).done(function (rsp2) {
                    if (rsp2.result !== undefined) {
                        var html3 = '';
                        for (var i = 0; i < rsp2.result.length; i++){
                            html3 += "<div class='params_info'>";
                            html3 += "<span class='params__info-title status__bitrix' data-id='" + rsp2.result[i].STATUS_ID +"'>"+ rsp2.result[i].NAME +":</span>";
                            html3 += '<span class="params__info-name">' + rsp2.result[i].STATUS_ID + '</span>';
                            html3 += '</div>';
                        }
                        $('#params_stat').html(html3);
                    }
                });
            }).fail(function(x) {
              if (x.responseJSON !== undefined && x.responseJSON.error_description !== undefined){
                  $('.rsp-ajax-text').text(x.responseJSON.error_description);
                  $('.popup--auct-err').fadeIn(300);
              } else {
                   $('.rsp-ajax-text').text('Вероятно, указанная ссылка не принадлежит к доменной зоне Битрикс24 или не является валидным вебхуком Битрикс24');
                  $('.popup--auct-err').fadeIn(300);
              }
            });
        }
    });
    $('.body_params').on('click', '.addSourceFemida',function () {
        console.log(globalURL);
    $.ajax({
        url: globalURL + "/crm.status.add?fields[ENTITY_ID]=SOURCE&fields[STATUS_ID]=LeadForce&fields[NAME]=Lead.Force&fields[SORT]=10000",
        dataType: "JSON"
    }).done(function (x) {
        if (x.result !== undefined) {
            urlCheck2.trigger('click');
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Код ошибки BITRIX24:',
                html: x.error_description,
            });
        }
    }).fail(function (x) {
        Swal.fire({
            icon: 'error',
            title: 'Код ошибки BITRIX24:',
            html: x.responseJSON.error_description,
        });
    });
});
    $('.body_params').on('click', '.source_pol', function() {
      var param = $(this).text();
      $('.parameters__name').val(param).focus();
      $('.value__parameter').val();
    });
    $('.body_params').on('click', '.source__bitrix', function() {
      var param = $(this).text(),
            value = $(this).attr('data-id');
      $('.parameters__name').val(param);
      $('.value__parameter').val(value).focus();
    });
    $('.body_params').on('click', '.status__bitrix', function() {
      var param = $(this).text(),
            value = $(this).attr('data-id');
      $('.parameters__name').val(param);
      $('.value__parameter').val(value).focus();
    });
    
     var allParams = {};
    $('.add__parameters').on('click', function() {
      var name = $('.parameters__name').val(),
          values = $('.value__parameter').val(),
          htmls = '';
      if (name.length > 0 && values.length > 0){
        allParams[name] = values;
      }
      for (var key in allParams){
          htmls += '<div class="greenBlock">';
            htmls += "<span class='greenBlock_title'>"+ key +"</span>";
            htmls += "<span class='greenBlock_subtitle'> :  "+ allParams[key] +"</span>";
            htmls += "<button type='button' class='remove__elemets' data-key='"+ key +"'>&times;</button>";
          htmls +=  '</div>';
          $('.showParams').html(htmls);
      }
      $('.parameters__name').val('');
      $('.value__parameter').val('');
    });
    $('.showParams').on('click', '.remove__elemets', function() {
      var id = $(this).attr('data-key'),
            htmls = '';
      delete allParams[id];
      if (Object.keys(allParams).length > 0){
                for (var key in allParams){
          htmls += '<div class="greenBlock">';
            htmls += "<span class='greenBlock_title'>"+ key +"</span>";
            htmls += "<span class='greenBlock_subtitle'> :  "+ allParams[key] +"</span>";
            htmls += "<button type='button' class='remove__elemets' data-key='"+ key +"'>&times;</button>";
          htmls +=  '</div>';
          $('.showParams').html(htmls);
        }
      } else $('.showParams').html('');

    });
    $('.submit__bitrix').on('click', function() {
            allParams.WEBHOOK_URL = globalURL;
            var params = JSON.stringify(allParams),
                type = 'bitrix',
                order_id = $order_id
            $.ajax({
                url: 'create-integration',
                dataType: 'JSON',
                type: 'POST',
                data: {params: params, type_integration: type, order_id: order_id}
            }).done(function(rsp) {
                          Swal.fire({
               icon: 'success',
               title: 'Успех!',
               html: "Сохранено",
            });
            });
    });
    $('.delete__btn').on('click', function() {
      var getParams = (new URL(document.location)).searchParams,
          order_id = getParams.get('order_id'),
          id = $(this).attr('data-id');
        $.ajax({
            url: 'delete-integration',
            dataType: 'JSON',
            type: 'POST',
            data: {id:id, order_id:order_id}
        }).done(function(rsp) {
          Swal.fire({
             icon: 'success',
             title: 'Успех!',
             html: "Удалено!",
          }).then((result) => {
            location.reload();
          });
        });
    });
JS;

$this->registerJsFile(Url::to(['/js/amoIntegration.js']), ['depends' => \yii\web\JqueryAsset::class]);
$this->registerJs($js);
?>

<section class="rightInfo">
    <div class="integration">
        <div class="bcr">
            <?php if (!empty($order_id)): ?>
                <ul class="bcr__list">
                    <li class="bcr__item">
                        <a href="<?= Url::to(['myorders']) ?>" class="bcr__link">
                            Интеграция
                        </a>
                    </li>
                    <li class="bcr__item">
                        <a class="bcr__link">
                            Интеграция заказа № <?= $order_id ?>
                        </a>
                    </li>
                </ul>
            <?php else: ?>
                <ul class="bcr__list">
                    <li class="bcr__item">
                        <a href="<?= Url::to(['integration']) ?>" class="bcr__link">
                            Интеграция
                        </a>
                    </li>
                </ul>
            <?php endif; ?>
        </div>

        <?php if (count($current) < 3): ?>
            <?php if (!empty($order_id)): ?>
                <h1 class="integration__title title-main">
                    Интеграция заказа № <?= $order_id ?>
                </h1>
            <?php else: ?>
                <h1 class="integration__title title-main">
                    Интеграция
                </h1>
            <?php endif; ?>

            <?php if ($integrations > 0 && !empty($order_id)): ?>
                <p class="integration__subtitle"
                   style="font-size: 18px; font-weight: 600; padding: 24px 40px 24px 28px; background-color: white; border: 1px solid #ffa800; border-radius: 10px">
                    У вас уже есть <a style="color:#0036bd;" href="<?= Url::to(['integration']) ?>">общая интеграция</a>
                    однако вы так-же можете добавить интеграцию для этого заказа</p>
            <?php else: ?>
                <p class="integration__subtitle">Добавьте пользовательские интеграции CRM</p>
            <?php endif; ?>
            <div class="integration__change">
                <?php if (empty($current) || !in_array('bitrix', $current)): ?>
                    <label class="integration__label">
                        <input class="check__integration" type="radio" name="integration" value="bitrix">
                        <img src="<?= Url::to(['/img/integration/bitrix_img.png']) ?>" alt="bitrix crm">
                        <p class="settings__integration">Настроить интеграцию</p>
                    </label>
                <?php endif; ?>

                <?php if (empty($current) || !in_array('amo', $current)): ?>
                    <label class="integration__label">
                        <input class="check__integration" type="radio" name="integration" value="amo">
                        <img src="<?= Url::to(['/img/integration/amo_img.png']) ?>" alt="amo crm">
                        <p class="settings__integration">Настроить интеграцию</p>
                    </label>
                <?php endif; ?>

                <?php if (empty($current) || !in_array('webhook', $current)): ?>
                    <label class="integration__label">
                        <input class="check__integration" type="radio" name="integration" value="hook">
                        <img src="<?= Url::to(['/img/integration/hook_img.png']) ?>" alt="webhook">
                        <p class="settings__integration">Настроить интеграцию</p>
                    </label>
                <?php endif; ?>
            </div>
        <?php endif; ?>
        <?php if (!ClientController::fullInfo($client)): ?>
            <div class="mass mass--cab">
                <div class="mass__content mass__content--cab">
                    <p class="mass__text">
                        Пожалуйста, заполните данные профиля, чтобы получить возможность добавлять интеграции
                    </p>
                    <a href="<?= Url::to(['prof']) ?>" class="mass__link btn">
                        Перейти в профиль
                    </a>
                    <span class="mass__close">
            <svg width="11" height="11" viewBox="0 0 11 11" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path fill-rule="evenodd" clip-rule="evenodd"
                    d="M5.28553 4.22487L9.29074 0.21967C9.58363 -0.0732233 10.0585 -0.0732233 10.3514 0.21967C10.6443 0.512563 10.6443 0.987437 10.3514 1.28033L6.34619 5.28553L10.3514 9.29074C10.6443 9.58363 10.6443 10.0585 10.3514 10.3514C10.0585 10.6443 9.58363 10.6443 9.29074 10.3514L5.28553 6.34619L1.28033 10.3514C0.987437 10.6443 0.512563 10.6443 0.21967 10.3514C-0.0732231 10.0585 -0.0732231 9.58363 0.21967 9.29074L4.22487 5.28553L0.21967 1.28033C-0.0732233 0.987437 -0.0732233 0.512563 0.21967 0.21967C0.512563 -0.0732231 0.987437 -0.0732231 1.28033 0.21967L5.28553 4.22487Z"
                    fill="#FFA800"/>
            </svg>
          </span>
                </div>
            </div>
        <?php else: ?>
        <div id="my_form" class="my_integration">
            <?php if (!empty($integration)): ?>
                <h2>Мои интеграции</h2>
                <?php foreach ($integration as $k => $v): ?>
                    <?php $config = json_decode($v['config']) ?>
                    <?php if ($v['integration_type'] === 'amo'): ?>
                        <div class="done__integration">
                            <div class="done__integration-logoDate">
                                <img src="<?= Url::to(['/img/integration/amo_img.png']) ?>" alt="amo logo">
                                <p>Дата создания: <span><?= date('d.m.Y', strtotime($v['date'])) ?></span></p>
                            </div>
                            <div class="done__integration-settings">
                                <a href="<?= Url::to(['update-amo-integration', 'order_id' => $order_id]) ?>"
                                   class="confirm_btn amo__update">Обновить</a>
                                <button data-id="<?= $v['id'] ?>" class="delete__btn">Удалить</button>
                            </div>
                        </div>
                    <?php elseif ($v['integration_type'] === 'bitrix'): ?>
                        <div class="done__integration">
                            <div class="done__integration-logoDate">
                                <img src="<?= Url::to(['/img/integration/bitrix_img.png']) ?>" alt="bitrix logo">
                                <p>Дата создания: <span><?= date('d.m.Y', strtotime($v['date'])) ?></span></p>
                            </div>
                            <div class="done__integration-info">
                                <p>WEBHOOK_URL:</p>
                                <p><a target="_blank" style="font-size: 10px" href="https://api.myforce.ru/rest/<?= $v['uuid'] ?>/crm.lead.list">https://api.myforce.ru/rest/<?= $v['uuid'] ?>/crm.lead.list</a></p>
                            </div>
                            <div class="done__integration-settings">
                                <a href="<?= Url::to(['update-bitrix-integration', 'order_id' => $order_id]) ?>"
                                   class="confirm_btn bitrix__update">Обновить</a>
                                <button data-id="<?= $v['id'] ?>" class="delete__btn">Удалить</button>
                            </div>
                        </div>
                    <?php else: ?>
                        <div class="done__integration">
                            <div class="done__integration-logoDate">
                                <img src="<?= Url::to(['/img/integration/hook_img.png']) ?>" alt="webhook logo">
                                <p>Дата создания: <span><?= date('d.m.Y', strtotime($v['date'])) ?></span></p>
                            </div>
                            <div class="done__integration-info">
                                <p>WEBHOOK_URL:</p>
                                <?php foreach ($config as $key => $val): ?>
                                    <?php if ($key === 'WEBHOOK_URL'): ?>
                                        <p><?= $val ?></p>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </div>
                            <div class="done__integration-settings">
                                <a href="<?= Url::to(['update-webhook-integration', 'order_id' => $order_id]) ?>"
                                   class="confirm_btn webhook__update">Обновить</a>
                                <button data-id="<?= $v['id'] ?>" class="delete__btn">Удалить</button>
                            </div>
                        </div>
                    <?php endif; ?>

                <?php endforeach; ?>
            <?php else: ?>
            <?php if (empty($order_id)): ?>
                <h2>Мои интеграции</h2>
                <h4 style="margin-bottom: 30px; font-weight: 500; font-size: 18px;">У вас пока нет интеграций</h4>
            <?php endif; ?>
        </div>
    <?php endif; ?>
    </div>

    <div class="forms__step" id="bitrix_form">
        <h4>Укажите ссылку на вебхук Битрикс24</h4>
        <p class="bitrix_form-subtitle">После указания ссылки нажмите Запросить информацию</p>
        <div class="request_info">
            <input placeholder="https://mycompany.bitrix24.ru/rest/1/y8kwj0pe126zhdqr/" class="hook_link"
                   name="bitrix__correct" type="text">
            <button type="button" class="confirm_btn bitrix__correct">Запросить информацию</button>
        </div>
        <div class="fade__forms">
            <h4>Выберите параметры для отображения в карточке лида</h4>
            <div style="margin-top: 25px;">
                <div class="params_nav">
                    <div class="params_tab params_tab-active" id="params_fields">Поля</div>
                    <div class="params_tab" id="params_source">Источники</div>
                    <div class="params_tab" id="params_status">Статусы лидов</div>
                </div>
                <div class="body_params">
                    <div id="params_field" class="params__fields" data-id="params_fields">
                    </div>
                    <div id="params_sources" class="params__fields fields__none" data-id="params_source">
                    </div>
                    <div id="params_stat" class="params__fields fields__none" data-id="params_status">
                    </div>
                </div>
            </div>
            <h4>Укажите желаемое значение параметра</h4>
            <p class="bitrix_form-subtitle">Введите значение в виде текста и добавьте параметр в список</p>
            <div class="addParams">
                <div class="addParams__block">
                    <p class="addParams__block-text">Выбранный параметр</p>
                    <input style="margin-bottom: 15px;" type="text" placeholder="TITLE"
                           class="hook_link parameters__name" name="parameter">
                </div>
                <div class="addParams__block">
                    <p class="addParams__block-text">Значение параметра</p>
                    <input style="margin-bottom: 15px;" type="text" placeholder="LEAD_NAME"
                           class="hook_link value__parameter" name="value_parameter">
                </div>
                <button style="margin-bottom: 15px;" type="button" class="confirm_btn add__parameters">Добавить
                    параметр
                </button>
            </div>

            <h4>Добавленные параметры</h4>
            <p class="bitrix_form-subtitle">Сохраните параметры интеграции или удалите ненужные</p>
            <div class="showParams">
            </div>
            <button type="button" style="max-width: fit-content" class="confirm_btn submit__bitrix">Сохранить
                параметры
                интеграции
            </button>
        </div>
    </div>
    <div class="forms__step" id="amo_form">
        <h4>Укажите данные для получения ключа аутентификации</h4>
        <?= Html::beginForm('', 'post', ['class' => 'amo_form']) ?>
        <div>
            <div class="line__Label">
                <label class="amo_form-label mw350">
                    Cсылка на сервер AmoCRM
                    <input id="server" type="text" name="server" value="<?= $_SESSION['amoTOKENS']['raw']['server'] ?>"
                           placeholder="my.amocrm.ru">
                </label>
                <label class="amo_form-label">
                    Идентификатор интеграции
                    <input id="client_id" type="text" name="client_id"
                           value="<?= $_SESSION['amoTOKENS']['raw']['client_id'] ?>"
                           placeholder="amnci9yn-bvki-fh4k-uuri579kod76">
                </label>
            </div>
            <div class="line__Label">
                <label class="amo_form-label mw350">
                    Секретный ключ
                    <input id="client_secret" type="text" name="client_secret"
                           value="<?= $_SESSION['amoTOKENS']['raw']['client_secret'] ?>"
                           placeholder="MCNDK7674JKGNWI76">
                </label>
                <label class="amo_form-label">
                    Код авторизации
                    <input type="text" name="code" value="<?= $_SESSION['amoTOKENS']['raw']['code'] ?>"
                           placeholder="htnh4kvn5nkjeht548fkffvh98y">
                </label>
            </div>
            <button style="max-width: fit-content" type="submit" class="confirm_btn amoGetKey">Получить ключ
                аутентификации
            </button>
        </div>
        <?= Html::endForm(); ?>
        <div class="more__inps">
            <h4>Данные OAuth</h4>
            <div class="line__Label">
                <label class="amo_form-label mw350">
                    EXPIRES IN
                    <input value="<?= $_SESSION['amoTOKENS'] ? date('d.m.Y H:i', $_SESSION['amoTOKENS']['response']['expires_in']) : '' ?>"
                           class="input-amoCrm" id="expires_in" type="text" name="expires_in"
                           placeholder="15.08.2021 15:35">
                </label>
                <label class="amo_form-label mw350">
                    ACCESS TOKEN
                    <input value="<?= $_SESSION['amoTOKENS']['response']['access_token'] ?>" id="access_token"
                           class="input-amoCrm" type="text" name="access_token"
                           placeholder="amnci9ynbvkifh4kuuri579kod76">
                </label>
                <label class="amo_form-label mw350">
                    REFRESH TOKEN
                    <input id="refresh_token" value="<?= $_SESSION['amoTOKENS']['response']['refresh_token'] ?>"
                           class="input-amoCrm" type="text" name="refresh_token"
                           placeholder="amnci9yvkifh4kuuri579kod76">
                </label>
            </div>
            <div class="leads__params">
                <div style="margin-top: 20px;">
                    <div class="block__lead--title">Поля лидов</div>
                    <div class="block__leads lead--show">
                        <div class="block__lead">
                            <span class="block__lead-title">utm_content</span>
                            <span class="block__lead-subtitle"><b>:</b> 600907</span>
                        </div>
                        <div class="block__lead">
                            <span class="block__lead-title">utm_content</span>
                            <span class="block__lead-subtitle"><b>:</b> 600907</span>
                        </div>
                    </div>
                </div>
                <div>
                    <p class="text--addparams">Поле AmoCRM и его значение</p>
                    <div class="addParams__block-flex">
                        <input style="max-width: 250px; margin-bottom: 15px" class="hook_link input-amoCrm" type="text"
                               name="name__lead-title" placeholder="UTM_CAMPAIGN">
                        <input style="max-width: 250px; margin-bottom: 15px" class="hook_link input-amoCrm" type="text"
                               name="value__lead-value" placeholder="6487798">
                        <button style="max-width: fit-content; margin-bottom: 15px;"
                                class="confirm_btn addLeads--params">Добавить параметр
                        </button>
                    </div>
                </div>
            </div>
            <div class="leads__params">
                <div style="margin-top: 20px;">
                    <div class="block__lead--title">Поля контактов</div>
                    <div class="block__leads contact--show">
                        <div class="block__lead">
                            <span class="block__lead-title">utm_content</span>
                            <span class="block__lead-subtitle"><b>:</b> 600907</span>
                        </div>
                        <div class="block__lead">
                            <span class="block__lead-title">utm_content</span>
                            <span class="block__lead-subtitle"><b>:</b> 600907</span>
                        </div>
                    </div>
                </div>
                <div style="display: none" class="text__values">
                    <p class="text--addparams">Поле AmoCRM / Указать значение и тип значения</p>
                    <div class="addParams__block-flex">
                        <input style="max-width: 250px; margin-bottom: 15px" class="hook_link" type="text"
                               name="text__values-input" placeholder="6487798">
                        <input style="max-width: 250px; margin-bottom: 15px" class="hook_link" type="text"
                               name="text__values-lead" placeholder="LEAD_PHONE">
                        <input style="max-width: 250px; margin-bottom: 15px" class="hook_link" type="text"
                               name="text__values-values" placeholder="193228">
                        <button style="max-width: fit-content; margin-bottom: 15px;"
                                class="confirm_btn addMulti--params">Добавить параметр
                        </button>
                    </div>
                </div>
                <div class="string__values">
                    <p class="text--addparams">Поле AmoCRM / Текстовое значение</p>
                    <div class="addParams__block-flex">
                        <input style="max-width: 250px; margin-bottom: 15px" class="hook_link" type="text"
                               name="string__values-input" placeholder="6487798">
                        <input style="max-width: 250px; margin-bottom: 15px" class="hook_link" type="text"
                               name="string__values-lead" placeholder="LEAD_NAME">
                        <button style="max-width: fit-content; margin-bottom: 15px;"
                                class="confirm_btn addText--params">Добавить параметр
                        </button>
                    </div>
                </div>
            </div>
            <div class="leads__params">
                <div style="margin-top: 20px;">
                    <div class="block__lead--title">Воронки</div>
                    <div class="block__leads funnels--show">
                        <div class="block__lead">
                            <span class="block__lead-title">utm_content</span>
                            <span class="block__lead-subtitle"><b>:</b> 600907</span>
                        </div>
                        <div class="block__lead">
                            <span class="block__lead-title">utm_content</span>
                            <span class="block__lead-subtitle"><b>:</b> 600907</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="leads__params">
                <div style="margin-top: 20px;">
                    <div class="block__lead--title">Пользователи</div>
                    <div class="block__leads users--show">
                        <div class="block__lead">
                            <span class="block__lead-title">utm_content</span>
                            <span class="block__lead-subtitle"><b>:</b> 600907</span>
                        </div>
                        <div class="block__lead">
                            <span class="block__lead-title">utm_content</span>
                            <span class="block__lead-subtitle"><b>:</b> 600907</span>
                        </div>
                    </div>
                </div>
            </div>
            <div>
                <h4>Добавленные поля контактов</h4>
                <div class="block__leads show--params__lead">
                    Нет добавленных полей
                </div>
            </div>
            <div>
                <h4>Добавленные поля лидов</h4>
                <div class="block__leads all-params__add">
                    Нет добавленных полей
                </div>
            </div>
            <button style="max-width: fit-content" class="confirm_btn save__amoCrm">Сохранить</button>
        </div>
    </div>
    <div class="forms__step" id="hook_form">
        <h4>URL внешнего вебхука</h4>
        <p class="hook_form--subtitle">Укажите ссылку на внешний сервер, способный принимать внешние POST-запросы</p>
        <?= Html::beginForm('', 'post', ['class' => 'hook_form']) ?>
        <input type="hidden" name="type_integration" value="webhook">
        <input type="hidden" name="order_id" value="<?= $_GET['order_id'] ?? '' ?>">
        <input placeholder="https://mysite.ru/2ejogh48yd" class="hook_link" name="webhook_url" type="text">
        <button type="button" class="confirm_btn webhook__confirm">Подтвердить</button>
        <?= Html::endForm(); ?>
        <p class="hook_form--lasttext">На указанный адрес будет поступать запрос каждый раз при поступлении нового лида.
            Запрос выполняется методом POST.</p>
        <button disabled class="confirm_btn confirm_btn-send">Сохранить интеграцию</button>
    </div>
    <div class="references__int">
        <h3 class="title__references">Справка</h3>
        <div id="amo" class="accortion__reference">
            <div class="header__reference">
                <div class="dot_head">
                    <div class="dot_int"></div>
                    <h4 class="title__reference">Интеграция с AmoCRM</h4>
                </div>
                <svg class="icon_reference" width="10" height="6" viewBox="0 0 10 6" fill="none"
                     xmlns="http://www.w3.org/2000/svg">
                    <path d="M1.06564 0.683058C0.821561 0.438981 0.425834 0.438981 0.181756 0.683058C-0.0623217 0.927136 -0.0623217 1.32286 0.181756 1.56694L4.34842 5.73361C4.5925 5.97769 4.98823 5.97769 5.23231 5.73361L9.39897 1.56694C9.64305 1.32286 9.64305 0.927136 9.39897 0.683058C9.1549 0.438981 8.75917 0.438981 8.51509 0.683058L4.79036 4.40778L1.06564 0.683058Z"
                          fill="#9BA0B7"/>
                </svg>
            </div>
            <div data-id="amo" class="drop__list">
                <ol class="main__list">
                    <li class="main__list-li">
                        Укажите следующие данные для получения ключа аутентификации:
                        <ul class="mark__change" style="padding: 15px 0 0 40px;">
                            <li>Код авторизации</li>
                            <li>ID интеграции</li>
                            <li>Секретный ключ</li>
                            <li>Ссылку на свою AmoCRM в формате company.amocrm.ru</li>
                        </ul>
                    </li>
                    <p class="red__li">Код авторизации годен 20 минут. Интеграция должна быть создана в течение 20
                        минут после ее создания в AmoCRM</p>
                    <li class="main__list-li">Если у вас нет этих данных, можете воспользоваться <a target="_blank"
                                                                                                    style="color:brown;"
                                                                                                    href="<?= Url::to(['/guide_amo.pdf']) ?>">инструкцией
                            AmoCRM</a></li>
                    <li class="main__list-li">Указав данные в соответствующих полях, нажимаете: Получить ключ
                        аутентификации
                    </li>
                    <p class="red__li">Полученный код авторизации можно использовать только 1 раз</p>
                    <li class="main__list-li">
                        Далее появится уведомление об ошибке или корректности ключа. Ключ может быть некорректен в
                        следующих случаях:
                        <ul class="mark__change" style="padding: 12px 0 12px 40px;">
                            <li>просроченный ключ</li>
                            <li>повторное использование кода авторизации</li>
                            <li>ошибка в подставляемых параметрах</li>
                            <li>перепутаны поля, в которые подставляют ключи</li>
                        </ul>
                    </li>
                    <li class="main__list-li">В случае корректности ключа &ndash; вы получите уведомление о сроке
                        годности ключа аутентификации и получите перечень полей лидов и контактов, а также айди воронок,
                        статусов лидов в них и пользователей CRM
                    </li>
                    <li class="main__list-li">
                        Для корректной отправки лидов в вашу АмоСРМ необходимо заполнить поля следующим образом:
                        <ul class="mark__change" style="padding: 12px 0 12px 40px;">
                            <li>Нажмите в "Поля лидов" на <code>Ответственный пользователь (ID)</code> и укажите ID
                                ответсвтенного за лида из перечня пользователей
                            </li>
                            <li>аналогично для <code>Ответственный пользователь (ID)</code> в "Поля контактов" укажите
                                точно такой же ID. Нажимаем <code>Добавить поле</code></li>
                            <li>Нижмите в "Поля лидов" на <code>Воронка (ID)</code> и укажите ID воронки из перечня
                                воронок. Нажмите <code>Добавить поле</code></li>
                            <li>Нажмите в "Поля лидов" на <code>Статус сделки (ID)</code> и укажите ID первого статуса
                                (или на выбор клиента) из перечня статусов (под названием воронки). Нажмите <code>Добавить
                                    поле</code></li>
                            <li>Нажмите в "Поля лидов" на <code>Название сделки</code> и укажите LEAD_NAME. Нажмите
                                <code>Добавить поле</code></li>
                            <li>Нажмите в "Поля контактов" на <code>Название контакта</code> и укажите LEAD_NAME.
                                Нажмите <code>Добавить поле</code></li>
                            <li>Нажмите в "Поля контактов" на <code>Телефон</code> и укажите LEAD_PHONE и ID поля для
                                типа WORK во второе пустое поле. Нажмите <code>Добавить поле</code></li>
                            <li>Нажмите в "Поля контактов" на <code>Email</code> и укажите LEAD_EMAIL и ID поля для типа
                                WORK во второе пустое поле. Нажмите <code>Добавить поле</code></li>
                        </ul>
                    </li>
                    <li class="main__list-li">Выберите, при необходимости, дополнительный параметры из каталога</li>
                    <li class="main__list-li">Введите необходимое значение и нажмите: Добавить параметр</li>
                    <li class="main__list-li">При необходимости &ndash; повторите пункты 7-8</li>
                    <li class="main__list-li">Когда все необходимые параметры добавлены, нажмите: Сохранить
                    </li>
                </ol>
            </div>
        </div>
        <div id="bitrix" class="accortion__reference">
            <div class="header__reference">
                <div class="dot_head">
                    <div class="dot_int"></div>
                    <h4 class="title__reference">Интеграция с Битрикс24</h4>
                </div>
                <svg class="icon_reference" width="10" height="6" viewBox="0 0 10 6" fill="none"
                     xmlns="http://www.w3.org/2000/svg">
                    <path d="M1.06564 0.683058C0.821561 0.438981 0.425834 0.438981 0.181756 0.683058C-0.0623217 0.927136 -0.0623217 1.32286 0.181756 1.56694L4.34842 5.73361C4.5925 5.97769 4.98823 5.97769 5.23231 5.73361L9.39897 1.56694C9.64305 1.32286 9.64305 0.927136 9.39897 0.683058C9.1549 0.438981 8.75917 0.438981 8.51509 0.683058L4.79036 4.40778L1.06564 0.683058Z"
                          fill="#9BA0B7"/>
                </svg>
            </div>

            <div data-id="bitrix" class="drop__list">
                <ol class="main__list">
                    <li class="main__list-li">
                        Для начала интеграции с Битрикс24, вам необходим вебхук. <a style="color: brown" target="_blank"
                                                                                    href="<?= Url::to(['/guide.pdf']) ?>">Инструкция
                            по созданию вебхука Битрикс24</a>
                    </li>
                    <li class="main__list-li">
                        Укажите ссылку на вебхук Битрикс24 и нажмите: Запросить информацию
                    </li>
                    <li class="main__list-li">
                        Наличие ошибки может быть в случае:
                        <ul class="mark__change" style="padding: 15px 0 0 40px;">
                            <li>указанная ссылка не является вебхуком</li>
                            <li>в ссылке присутствует ошибка</li>
                            <li>указанное значение не является ссылкой</li>
                            <li>вебхук не имеет достаточно привилегий</li>
                            <li>вебхук не существует или был удален</li>
                        </ul>
                    </li>
                    <li class="main__list-li">Если вебхук корректный &ndash; появляются поля лидов Битрикс24, список
                        источников и статусов лидов
                    </li>
                    <li class="main__list-li">В появившемся перечне, при необходимости, выберите нужное поле и кликните
                        по нему
                    </li>
                    <li class="main__list-li">Укажите для данного параметра необходимое значение, в текстовом виде или
                        виде специальных значений (приведены ниже)
                    </li>
                    <li class="main__list-li">Когда значение введено, нажмите: Добавить параметр</li>
                    <li class="main__list-li">При необходимости повторите пункты 4-6</li>
                    <li class="main__list-li">Когда все необходимые параметры добавлены, нажмите: Сохранить параметры
                        интеграции
                    </li>
                </ol>
            </div>
        </div>
        <div id="hook" class="accortion__reference">
            <div class="header__reference">
                <div class="dot_head">
                    <div class="dot_int"></div>
                    <h4 class="title__reference">Интеграция с WebHook</h4>
                </div>
                <svg class="icon_reference" width="10" height="6" viewBox="0 0 10 6" fill="none"
                     xmlns="http://www.w3.org/2000/svg">
                    <path d="M1.06564 0.683058C0.821561 0.438981 0.425834 0.438981 0.181756 0.683058C-0.0623217 0.927136 -0.0623217 1.32286 0.181756 1.56694L4.34842 5.73361C4.5925 5.97769 4.98823 5.97769 5.23231 5.73361L9.39897 1.56694C9.64305 1.32286 9.64305 0.927136 9.39897 0.683058C9.1549 0.438981 8.75917 0.438981 8.51509 0.683058L4.79036 4.40778L1.06564 0.683058Z"
                          fill="#9BA0B7"/>
                </svg>
            </div>
            <div data-id="hook" class="drop__list">
                <ol class="main__list">
                    <li class="main__list-li">
                        Если предоставляемый Lead.Force способ интеграции с AmoCRM и Битрикс24 вас не устраивает, или у
                        вас есть самописная СРМ - вы можете воспользоваться вебхуком.
                        <ul class="mark__change" style="padding: 15px 0 0 40px;">
                            <li>Вы можете создать PHP-скрипт или скрипт на любом другом языке, способный принимать HTTP
                                запрос POST в формате JSON
                            </li>
                            <li>Сформировать URL-адрес к данному скрипту</li>
                            <li>Данный URL укажите в соответствующее поле</li>
                            <li>Далее необходимо нажать кнопку <code>Подтвердить</code></li>
                            <li><b>Важно</b>, чтобы предоставленный URL отдавал HTTP код 200. В противном случае -
                                данную ссылку, в качестве вебхука, будет невозможно использовать.
                            </li>
                            <li>Если вебхук был успешно добавлен - нажимаем на кнопку <code>Сохранить</code></li>
                            <li>При каждом новом лиде - на указанный вебхук будут отправлены все данные о лиде в формате
                                JSON, за исключением системных полей.
                            </li>
                            <li>Пример реализации вебхука на PHP:</li>
                        </ul>
                    </li>

                <pre style="font-family: Consolas, monospace;white-space: break-spaces; font-size: 14px; background-color: #303030; color: white; padding: 15px">
&lt;?php
    # получаем данные лида

    <span style="color: orange">$json</span> = <span style="color: #1c94c4">file_get_contents("php://input");</span>
    <span style="color: orange">$data</span> = <span style="color: #1c94c4">json_decode($json, true);</span>

    # в <span style="color: orange">$json</span> хранится вся информация о лиде в формате JSON, в $data - в виде массива
    # запишем <span style="color: orange">$json</span> в файл и посмотрим, какие данные приходят на вебхук

    <span style="color: orange">file_put_contents</span>(<span style="color: #1c94c4">'some_file.log', $json . PHP_EOL, FILE_APPEND</span>);

    # теперь при поступлении лида - вся информация будет сохраняться с каждой новой строки файла
    # <span style="color: orange">JSON</span> данные, записанные в файл, можно использовать для отладки и проверки структуры объекта,
    # который приходит в POST
?&gt;
</pre>
                    <li class="main__list-li">
                        Пример полученных данных в формате JSON:
                    </li>
                <pre style="font-family: Consolas, monospace;white-space: break-spaces; font-size: 14px; background-color: #303030; color: white; padding: 15px">
    {
        <span style="color: orange">"id":</span> 331241,
        <span style="color: orange">"name":</span> "Алексей Архипов",
        <span style="color: orange">"email":</span> "alex.arhipov@mail.ru",
        <span style="color: orange">"phone":</span> "78494489797",
        <span style="color: orange">"region":</span> "Ростовская обл",
        <span style="color: orange">"city":</span> "Ростов-на-Дону",
        <span style="color: orange">"comments":</span> "Есть ипотека, нужно полностью списать долги",
        <span style="color: orange">"params":</span> "{\"sum\":500000}",
        <span style="color: orange">"date":</span> "10.09.2021",
        <span style="color: orange">"integration_type":</span> "Общая интеграция"
    }
</pre>
                </ol>
            </div>
        </div>
        <div id="special" class="accortion__reference">
            <div class="header__reference">
                <div class="dot_head">
                    <div class="dot_int"></div>
                    <h4 class="title__reference">Специальные значения переменных</h4>
                </div>
                <svg class="icon_reference" width="10" height="6" viewBox="0 0 10 6" fill="none"
                     xmlns="http://www.w3.org/2000/svg">
                    <path d="M1.06564 0.683058C0.821561 0.438981 0.425834 0.438981 0.181756 0.683058C-0.0623217 0.927136 -0.0623217 1.32286 0.181756 1.56694L4.34842 5.73361C4.5925 5.97769 4.98823 5.97769 5.23231 5.73361L9.39897 1.56694C9.64305 1.32286 9.64305 0.927136 9.39897 0.683058C9.1549 0.438981 8.75917 0.438981 8.51509 0.683058L4.79036 4.40778L1.06564 0.683058Z"
                          fill="#9BA0B7"/>
                </svg>
            </div>
            <div data-id="special" class="drop__list">
                <?php if (!empty($integrations_special)): ?>
                    <?php foreach ($integrations_special as $param): ?>
                        <div style="display:flex; flex-wrap: wrap; margin-bottom: 12px;">
                            <p style="max-width: 200px; width: 100%; font-weight: 500;font-size: 14px;line-height: 20px;color: #2B3048;"><?= $param['name'] ?></p>
                            <p style="font-weight: normal;font-size: 14px;line-height: 20px;color: #5B617C; max-width: 400px"><?= $param['description'] ?></p>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
                <?php if (!empty($paramArray)): ?>
                    <?php foreach ($paramArray as $key => $item): ?>
                        <p style="font-weight: 600;font-size: 14px;line-height: 20px;color: #2B3048; padding-top: 8px; padding-bottom: 15px;">
                            Специальные значения переменных категории «<?= $key ?>»</p>
                        <div>
                            <?php foreach ($item as $j => $i): ?>
                                <div style="display:flex; flex-wrap: wrap; margin-bottom: 12px;">
                                    <p style="max-width: 200px; word-break: break-word; width: 100%; font-weight: 500;font-size: 14px;line-height: 20px;color: #2B3048;">
                                        LEAD_PARAM_<?= $j ?></p>
                                    <p style="font-weight: normal;font-size: 14px;line-height: 20px;color: #5B617C; max-width: 400px">
                                        Подставит вместо специального значение, в указанном месте, значение праметра
                                        "<?= $i ?>"</p>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <?php endif; ?>
    <div class="popup popup--auct-err">
        <div class="popup__ov">
            <div class="popup__body popup__body--w">
                <div class="popup__content popup__content--err">
                    <p class="popup__title rsp-ajax-title">
                        Ошибка
                    </p>
                    <p class="popup__text rsp-ajax-text">
                    </p>
                </div>
                <div class="popup__close">
                    <img src="<?= Url::to(['/img//close.png']) ?>" alt="close">
                </div>
            </div>
        </div>
    </div>
    <div class="popup popup--auct">
        <div class="popup__ov">
            <div class="popup__body popup__body--ok">
                <div class="popup__content popup__content--ok">
                    <p class="popup__title">Успешно</p>
                    <p class="popup__text rsp--ajax__text">
                        Данные корректные.
                    </p>
                    <button class="popup__btn-lid btn">Продолжить</button>
                </div>
                <div class="popup__close">
                    <img src="<?= Url::to(['/img//close.png']) ?>" alt="close">
                </div>
            </div>
        </div>
    </div>
</section>