<?php

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Обновление битрикс интеграции';

if (!empty($integer)){
    $config = json_decode($integer['config'], true);
    $params = $integer['config'];
}

$order_id = $_GET['order_id'];
$js = <<< JS
    var globalURL = '';
    function getParamsBitrix(){
        var url = atob($('input[name="bitrix__correct"]').val()),
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
    }
    $('.bitrix__correct').on('click', function() {
        getParamsBitrix();
    });
    $('[name="bitrix__correct0"]').on('input', function () {
        $('[name="bitrix__correct"]').val(btoa($(this).val()));
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
    
    
     var allParams = $params;
     delete allParams['WEBHOOK_URL'];
     
     function renderDataLead(){
         var htmls = '';
         for (var key in allParams){
          htmls += '<div class="greenBlock">';
            htmls += "<span class='greenBlock_title'>"+ key +"</span>";
            htmls += "<span class='greenBlock_subtitle'> :  "+ allParams[key] +"</span>";
            htmls += "<button type='button' class='remove__elemets' data-key='"+ key +"'>&times;</button>";
          htmls +=  '</div>';
          $('.showParams').html(htmls);
      }
     }
    $('.add__parameters').on('click', function() {
      var name = $('.parameters__name').val(),
          values = $('.value__parameter').val();
      if (name.length > 0 && values.length > 0){
        allParams[name] = values;
      }
      renderDataLead();
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
    getParamsBitrix();
    renderDataLead();
JS;

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
                        <a class="bcr__link">Обновление интеграции в заказe № <?= $order_id ?></a>
                    </li>
                </ul>
            <?php else: ?>
                <ul class="bcr__list">
                    <li class="bcr__item">
                        <a href="<?= Url::to(['integration']) ?>" class="bcr__link">
                            Интеграция
                        </a>
                    </li>
                    <li class="bcr__item">
                        <a class="bcr__link">Обновление интеграции</a>
                    </li>
                </ul>
            <?php endif; ?>
        </div>
    </div>
    <?php if (!empty($integer)): ?>
        <div style="display: block" class="forms__step" id="bitrix_form">
            <h4>Укажите ссылку на вебхук Битрикс24</h4>
            <p class="bitrix_form-subtitle">После указания ссылки нажмите Запросить информацию</p>
            <div class="request_info">
                <input placeholder="https://mysite.ru/2ejogh48yd" value="https://api.myforce.ru/rest/<?= $integer['uuid'] ?>/" class="hook_link" name="bitrix__correct0" type="text">
                <button type="button" class="confirm_btn bitrix__correct">Запросить информацию</button>
            </div>
            <div style="display: block" class="fade__forms">
                <h4>Выберите параметры для отображения в карточке лида</h4>
                <div style="margin-top: 25px;">
                    <div class="params_nav">
                        <div class="params_tab params_tab-active" id="params_fields">Поля</div>
                        <div class="params_tab" id="params_source">Источники</div>
                        <div class="params_tab" id="params_status">Статусы лидов</div>
                    </div>
                    <div class="body_params">
                        <div id="params_field" class="params__fields" data-id="params_fields">
                            Загрузка параметров...
                        </div>
                        <div id="params_sources" class="params__fields fields__none" data-id="params_source">
                            Загрузка параметров...
                        </div>
                        <div id="params_stat" class="params__fields fields__none" data-id="params_status">
                            Загрузка параметров...
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
                    <button style="margin-bottom: 15px;" type="button" class="confirm_btn add__parameters">Добавить параметр
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
    <?php else: ?>
        <h4>Интеграция не найдена</h4>
    <?php endif; ?>
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
                    <p class="red__li">Код авторизации годен 20 минут. Интеграция должан быть создана в течение 20
                        минут после ее создания в AmoCRM</p>
                    <li class="main__list-li">Указав данные в соответствующих полях, нажимаете Получить ключ
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
                            <li>перепутаны поля,в которые подставляют ключи</li>
                        </ul>
                    </li>
                    <li class="main__list-li">В случае корректности ключа появятся значения OAuth и вам доступна
                        настройка параметров интеграции
                    </li>
                    <li class="main__list-li">
                        Задайте значения обязательных полей:
                        <ul class="mark__change" style="padding: 12px 0 12px 40px;">
                            <li>Выберите ответственного за лид и контакт. Нажмите Добавить параметр</li>
                            <li>Выберите Воронку. Нажмите Добавить параметр</li>
                            <li>Выберите Статус сделки. Нажмите Добавить параметр</li>
                        </ul>
                    </li>
                    <li class="main__list-li">Выберите дополнительный параметры из каталога ниже</li>
                    <li class="main__list-li">Введите необходимое значение и нажмите Добавить параметр</li>
                    <li class="main__list-li">При необходимости повторите пункты 6-7</li>
                    <li class="main__list-li">Когда все необходимые параметры добавлены, нажмите Сохранить
                        интеграцию
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
                        Укажите ссылку на вебхук Битрикс24 и нажмите Запросить информацию
                    </li>
                    <li class="main__list-li">
                        Вы можете получить ошибку в случае если:
                        <ul class="mark__change" style="padding: 15px 0 0 40px;">
                            <li>указанная ссылка не явояется вебхуком</li>
                            <li>в ссылке присутствует ошибка</li>
                            <li>указанное значение не является ссылкой</li>
                            <li>вебхук не имеет достаточно привелегий</li>
                            <li>вебхук не существует или был удален</li>
                        </ul>
                    </li>
                    <li class="main__list-li">Если вебхук корректный появляются поля лидов Битрикс24, список
                        источников и статусов лидов
                    </li>
                    <li class="main__list-li">В появившемся перечне выберите необходимое поле и кликните по нему
                    </li>
                    <li class="main__list-li">Укажите для данного параметра необходимое значение в тексовом виде или
                        виде специальных значений (приведены ниже)
                    </li>
                    <li class="main__list-li">Когда значение введено нажмите Добавить параметр</li>
                    <li class="main__list-li">При необходимости повторите пункты 4-6</li>
                    <li class="main__list-li">Когда все необходимые параметры добавлены, нажмите Сохранить
                        интеграцию
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
                    <li class="main__list-li">Укажите ссылку на внешний сервер, способный принимать внешние
                        POST-запросы
                    </li>
                    <li class="main__list-li">Нажмите Подтвердить. Далее появится уведомление о корректности
                        ссылки
                    </li>
                    <li class="main__list-li">Если вебхук корректный кнопка Сохранить интеграцию станет активной
                    </li>
                    <li class="main__list-li">Нажмите сохранить интеграцию</li>
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
                    <p class="red__li">Код авторизации годен 20 минут. Интеграция должан быть создана в течение 20
                        минут после ее создания в AmoCRM</p>
                    <li class="main__list-li">Указав данные в соответствующих полях, нажимаете Получить ключ
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
                            <li>перепутаны поля,в которые подставляют ключи</li>
                        </ul>
                    </li>
                    <li class="main__list-li">В случае корректности ключа появятся значения OAuth и вам доступна
                        настройка параметров интеграции
                    </li>
                    <li class="main__list-li">
                        Задайте значения обязательных полей:
                        <ul class="mark__change" style="padding: 12px 0 12px 40px;">
                            <li>Выберите ответственного за лид и контакт. Нажмите Добавить параметр</li>
                            <li>Выберите Воронку. Нажмите Добавить параметр</li>
                            <li>Выберите Статус сделки. Нажмите Добавить параметр</li>
                        </ul>
                    </li>
                    <li class="main__list-li">Выберите дополнительный параметры из каталога ниже</li>
                    <li class="main__list-li">Введите необходимое значение и нажмите Добавить параметр</li>
                    <li class="main__list-li">При необходимости повторите пункты 6-7</li>
                    <li class="main__list-li">Когда все необходимые параметры добавлены, нажмите Сохранить
                        интеграцию
                    </li>
                </ol>
            </div>
        </div>
    </div>
    </div>
    <div class="popup popup--auct-err">
        <div class="popup__ov">
            <div class="popup__body popup__body--w">
                <div class="popup__content popup__content--err">
                    <p class="popup__title rsp-ajax-title">
                        Ошибка
                    </p>
                    <p class="popup__text rsp-ajax-text">
                    </p>
                    <button class="popup__btn-lid btn">Продолжить</button>
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
    <input type="hidden" name="bitrix__correct" value="<?= base64_encode($config['WEBHOOK_URL']) ?>">
</section>