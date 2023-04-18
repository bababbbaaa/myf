<?php

use yii\helpers\Url;
use yii\helpers\Html;

$this->title = 'API';
$this->params['breadcrumbs'][] = "API";

$js = <<<JS
$('.click-toggle').on('click', function() {
    $(this).next().slideToggle();
});

function url1() {
    var val = '';
    $('.changer-url-1').each(function() {
        var 
            xVal = $(this).val(),
            xName = $(this).attr('name');
        if (xVal.length > 0) {
            if (val.length > 0)
                val += "&" + xName + "=" + xVal;
            else
                val += "?" + xName + "=" + xVal;
        }
    });
    const url = "https://api.myforce.ru/lead.get.from.call";
    $('.url-block-1').html("<code>"+ url + val +"</code>");
}


function url2() {
    var val = '?type=bitrix';
    $('.changer-url-2').each(function() {
        var 
            xVal = $(this).val(),
            xName = $(this).attr('name');
        if (xVal.length > 0) {
           val += "&" + xName + "=" + xVal;
        }
    });
    const url = "https://api.myforce.ru/lead.get.from.call";
    $('.url-block-2').html("<code>"+ url + val +"</code>");
}

function url3() {
    var val = '?cc=1';
    $('.changer-url-3').each(function() {
        var 
            xVal = $(this).val(),
            xName = $(this).attr('name');
        if (xVal.length > 0) {
           val += "&" + xName + "=" + xVal;
        }
    });
    const url = "https://api.myforce.ru/lead.get.from.call";
    $('.url-block-3').html("<code>"+ url + val +"</code>");
}

$('.changer-url-1').on({
    focus: function() {
      url1();
    },
    blur: function() {
      url1()
    },
    input: function() {
      url1()
    },
});

$('.changer-url-3').on({
    focus: function() {
      url3();
    },
    blur: function() {
      url3()
    },
    input: function() {
      url3()
    },
});


$('.generator2').on({
    focus: function() {
      url2();
    },
    blur: function() {
      url2()
    },
    input: function() {
      url2()
    },
}, '.changer-url-2');

$('.add-more').on('click', function() {
    var 
        ifBlock = $('.if-press').last(),
        pressClass = $('.press-class').last(),
        digit = parseInt(ifBlock.attr('data-press')),
        newDigit = digit + 1,
        html = ifBlock[0].outerHTML + pressClass[0].outerHTML,
        re1 = new RegExp('нажал ' + digit, 'gim'),
        re2 = new RegExp('data-press="' + digit + '"', 'gim');
    if (newDigit < 10) {
        html = html.replace(re1, 'нажал ' + newDigit);
        html = html.replace(re2, 'data-press="' + newDigit + '"');
        html = html.replaceAll("ivr["+digit+"]", "ivr["+newDigit+"]");
        pressClass.after(html);
    }
});
JS;


$this->registerJs($js);
$cats = \common\models\LeadsCategory::find()->select(['link_name', 'name'])->asArray()->all();
?>
<style>
    .hidden-toggle {
        display: none;
    }
    .click-toggle {
        color: #d9534f;
        cursor: pointer;
        font-weight: 700;
        font-size: 17px;
        margin-bottom: 15px;
    }
    .click-toggle:hover{
    }
    .hidden-toggle {
        padding: 10px;
        background-color: #303030;
        color: wheat;
        margin: 20px auto;
    }
    ol, ul {
        margin-bottom: 0;
    }
    .spc-b {
        color: #2ea26c;
    }
    li {
        margin: 5px 0;
    }
    .spc-span {
        background-color: #303030;
        color: wheat;
        padding: 2px 7px;
    }
    .hidden-toggle pre {
        background-color: #111111 !important;
        color: #a4e2ff;
        padding: 5px;
        margin: 10px 0;
        border: 1px solid black;
        width: 90%;
    }
    code {
        background-color: #111111;
        color: #a4e2ff;
    }
    .hidden-toggle a:hover, .hidden-toggle a:focus {
        color: #d9534f;
    }
    .generator-inps {
        background-color: wheat; color: #303030; padding: 10px 10px; margin: 10px 0;
        width: 90%;
    }

    .generator-inps > div {
        display: flex;
        flex-wrap: wrap;
        align-items: flex-end;
    }

    .generator-inps > div > div {
        margin-right: 10px;
        margin-bottom: 10px;
    }

    .if-press {
        margin-top: 10px;
    }

</style>
<?php if (Yii::$app->session->hasFlash('import')): ?>
    <div class="alert alert-success alert-dismissable">
        <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
        <?= Yii::$app->session->getFlash('import') ?>
    </div>
<?php endif; ?>
<div class="monospace" style="max-width: 1000px">
    <h1 class="admin-h1">Документация по API</h1>
    <p><b>API</b> — программный интерфейс приложения обработки сервисов MyForce и внешних запросов</p>
    <div class="toggles">

        <div class="click-toggle">
            <span class="glyphicon glyphicon-chevron-right" aria-hidden="true" style="font-size: 16px"></span>
            Добавление нового лида
        </div>
        <div class="hidden-toggle">
            <ul>
                <li><b class="spc-b">URL:</b> <span class="spc-span">https://api.myforce.ru/lead.add</span></li>
                <li><b class="spc-b">HTTP-METHOD:</b> <span class="spc-span">POST</span></li>
                <li><b class="spc-b">Поля запроса</b>
<pre>
# обязательные
'type' => 'dolgi',
'phone' => '8(909)-012-33-34',
'source' => 'спишемдолг.рф',
'ip' => $_SERVER['REMOTE_ADDR'],
'access_token' => *****,

# необязательные
'name' => 'Вася',
'email' => 'pupkin.ceo@gmail.co.uk',
'region' => 'Московская обл',
'city' => 'Домодедово',
'comments' => 'Комментарий 1<?= Html::encode("<br>") ?>Комментарий 2',
'params' => json_encode(['sum' => 1500000, 'sum_text' => 'от 500 000 рублей'],
    JSON_UNESCAPED_UNICODE),
'utm_source' => 'some_utm',
'utm_campaign' => 'some_utm',
'utm_medium' => 'some_utm',
'utm_content' => 'some_utm',
'utm_term' => 'some_utm',
'utm_title' => 'some_utm',
'utm_device_type' => 'some_utm',
'utm_age' => 'some_utm',
'utm_inst' => 'some_utm',
'utm_special' => 'some_utm',
</pre></li>
                <li><b class="spc-b">Особенности запроса:</b>
                <ol>
                    <li>Поле <code>access_token</code> принимает специальные значения, установленные на программном уровне. Значения уточняются у администрации</li>
                    <li>Поле <code>region</code> не является обязательным, т.к. предусмотрено определение региона и города по IP-адресу, на стороне сервера</li>
                    <li>Поле <code>source</code> принимает ТОЛЬКО верифицированные источники, см. <a target="_blank" href="<?= Url::to(['/lead-force/sources']) ?>">раздел источников</a></li>
                    <li>Поле <code>type</code> принимает параметр "Специальная ссылка" ТОЛЬКО для <a target="_blank" href="<?= Url::to(['/lead-force/leads-category']) ?>">существующей категории лидов</a></li>
                    <li>Поле <code>params</code> принимает json-строку с параметрами, которые характерны для указанной категории лидов в <code>type</code>. Перечень возможных параметров можно узнать
                        <a target="_blank" href="<?= Url::to(['/lead-force/leads-params']) ?>">по ссылке</a></li>
                </ol></li>
                <li><b class="spc-b">Коды ответов:</b> <ul>
                        <li><b class="spc-b">200</b> - лид успешно добавлен</li>
                        <li><b class="spc-b" style="color: #d9534f">400</b> - ошибка в параметрах запроса POST (какое-либо значение не указано, или указано не верно)</li>
                        <li><b class="spc-b" style="color: #d9534f">403</b> - ошибка валидации ключа или источника</li>
                        <li><b class="spc-b" style="color: #d9534f">405</b> - использование запрещенного способа доступа к методу API</li>
                    </ul></li>
            </ul>
        </div>

        <div class="click-toggle">
            <span class="glyphicon glyphicon-chevron-right" aria-hidden="true" style="font-size: 16px"></span>
            Получение лида с обзвона для конкретного заказа
        </div>
        <div class="hidden-toggle">
            <ul>
                <li><b class="spc-b">URL:</b> <span class="spc-span">https://api.myforce.ru/lead.get.from.call</span></li>
                <li><b class="spc-b">HTTP-METHOD:</b> <span class="spc-span">GET</span></li>
                <li><b class="spc-b">Поля запроса</b></li>
                    <pre>
# обязательные
type=dolgi,

# необязательные
order=10
utm=some_utm
</pre></li>
                <li><b class="spc-b">Пример ссылки:</b> <span class="spc-span">https://api.myforce.ru/lead.get.from.call?type=dolgi&order=15</span></li>
                <li><b class="spc-b">Особенности запроса:</b>
                    <ol>
                        <li>Поле <code>type</code> принимает параметр "Специальная ссылка" ТОЛЬКО для <a target="_blank" href="<?= Url::to(['/lead-force/leads-category']) ?>">существующей категории лидов</a></li>
                        <li>Поле <code>order</code> принимает ID заказа, если необходимо, чтобы лид записался и сразу попал к указанному заказчику. Если не указывать поле <code>order</code>, то лид запишется в таблицу для распределения в порядке очереди</li>
                    </ol></li>
                <li><b class="spc-b">Использование:</b> указать URL с параметрами в качестве Webhook'а в программе обзвона</li>
                <li><b class="spc-b">Генератор ссылок</b>
                <div class="generator-inps">
                    <div>
                        <div>
                            <div><b>Категория</b></div>
                            <div>
                                <select name="type" id="select-category-1" class="form-control changer-url-1">
                                    <?php foreach($cats as $item): ?>
                                        <option value="<?= $item['link_name'] ?>"><?= $item['name'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div>
                            <div><b>ID заказа</b></div>
                            <div><input type="number" name="order" placeholder="10" class="form-control changer-url-1"></div>
                        </div>
                        <div>
                            <div><b>UTM</b></div>
                            <div><input type="text" name="utm" placeholder="some_utm" class="form-control changer-url-1"></div>
                        </div>
                    </div>
                    <div ><div style="margin-bottom: 5px"><b>URL:</b></div></div>
                    <div class="url-block-1" style=""><code>https://api.myforce.ru/lead.get.from.call?type=dolgi</code></div>
                </div></li>
            </ul>
        </div>

        <div class="click-toggle session-save-bitrix">
            <span class="glyphicon glyphicon-chevron-right" aria-hidden="true" style="font-size: 16px"></span>
            Получение лида с обзвона в Битрикс24
        </div>
        <div class="hidden-toggle" >
            <ul>
                <li><b class="spc-b">URL:</b> <span class="spc-span">https://api.myforce.ru/lead.get.from.call?type=bitrix</span></li>
                <li><b class="spc-b">HTTP-METHOD:</b> <span class="spc-span">GET</span></li>
                <li><b class="spc-b">Поля запроса</b></li>
                <pre>
# обязательные
type=bitrix,

# необязательные
ivr[1][ASSIGNED_BY_ID]=806
ivr[1][CATEGORY_ID]=60
ivr[1][TITLE]=Заголовок лида
ivr[1][COMMENTS]=Комментарий
ivr[2]...
utm=some_utm
</pre></li>
                <li><b class="spc-b">Пример ссылки:</b> <span class="spc-span">https://api.myforce.ru/lead.get.from.call?type=bitrix&ivr[1][ASSIGNED_BY_ID]=806&ivr[1][SOURCE_ID]=82</span></li>
                <li><b class="spc-b">Особенности запроса:</b>
                    <ol>
                        <li>Поле <code>type</code> всегда принимает значение bitrix</li>
                        <li>Поле <code>ivr</code> - массив данных, соответствующих нажатой цифре, который будет записан в Битрикс24 при создании сделки</li>
                    </ol></li>
                <li><b class="spc-b">Использование:</b> указать URL с параметрами в качестве Webhook'а в программе обзвона</li>
                <li><b class="spc-b">Генератор ссылок</b>
                    <div class="generator-inps generator2">
                        <div><a href="?refresh=1">Обновить данные Битрикс24</a></div>

                        <div class="if-press" data-press="1"><b>Если нажал 1</b></div>
                        <div class="press-class" data-press="1">
                            <div>
                                <div><b>Категория сделки</b></div>
                                <div>
                                    <select name="ivr[1][CATEGORY_ID]" class="form-control changer-url-2">
                                        <?php if(!empty($_SESSION['bitrix']['CATEGORY_ID'])): ?>
                                            <option value="">Поумолчанию</option>
                                            <?php foreach($_SESSION['bitrix']['CATEGORY_ID'] as $key => $item): ?>
                                                <option value="<?= $key ?>"><?= $item ?></option>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </select>
                                </div>
                            </div>
                            <div>
                                <div><b>Ответственный за сделку</b></div>
                                <div>
                                    <select name="ivr[1][ASSIGNED_BY_ID]" class="form-control changer-url-2">
                                        <?php if(!empty($_SESSION['bitrix']['ASSIGNED_BY_ID'])): ?>
                                            <option value="">Поумолчанию</option>
                                            <?php foreach($_SESSION['bitrix']['ASSIGNED_BY_ID'] as $key => $item): ?>
                                                <option value="<?= $key ?>"><?= $item ?></option>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </select>
                                </div>
                            </div>
                            <div>
                                <div><b>Источник</b></div>
                                <div>
                                    <select name="ivr[1][SOURCE_ID]" class="form-control changer-url-2">
                                        <?php if(!empty($_SESSION['bitrix']['SOURCE_ID'])): ?>
                                            <option value="">Поумолчанию</option>
                                            <?php foreach($_SESSION['bitrix']['SOURCE_ID'] as $key => $item): ?>
                                                <option value="<?= $key ?>"><?= $item ?></option>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </select>
                                </div>
                            </div>
                            <div>
                                <div><b>Заголовок</b></div>
                                <div>
                                    <input type="text" name="ivr[1][TITLE]" placeholder="ИСЛ Обзвон" class="form-control changer-url-2">
                                </div>
                            </div>
                            <div>
                                <div><b>UTM</b></div>
                                <div>
                                    <input type="text" name="utm" placeholder="some_utm" class="form-control changer-url-2">
                                </div>
                            </div>
                            <div>
                                <div><b>Комментарий</b></div>
                                <div>
                                    <input type="text" name="ivr[1][COMMENTS]" placeholder="нажал 1" class="form-control changer-url-2">
                                </div>
                            </div>
                        </div>


                        <div><div class="btn btn-admin add-more">Добавить ещё одну кнопку</div></div>
                        <div ><div style="margin-bottom: 5px"><b>URL:</b></div></div>
                        <div class="url-block-2" style=""><code>https://api.myforce.ru/lead.get.from.call?type=bitrix</code></div>
                    </div>
                </li>
            </ul>
        </div>

        <div class="click-toggle session-save-bitrix">
            <span class="glyphicon glyphicon-chevron-right" aria-hidden="true" style="font-size: 16px"></span>
            Импорт "Сделка+Контакт" в Битрикс24
        </div>
        <div class="hidden-toggle" >
            <ul>
                <li><b class="spc-b">Использование:</b> выбрать CSV-файл с именами и телефонами для импорта сделок</li>
                <li><b class="spc-b">Особенности:</b> первый столбец - имена, второй столбец - телефоны</li>
                <li><b class="spc-b">Форма импорта</b>
                    <div class="generator-inps generator20">
                        <div><a href="?refresh=1">Обновить данные Битрикс24</a></div>

                        <?= Html::beginForm('/api-docs/main/import-csv', 'POST', ['enctype' => 'multipart/form-data']) ?>
                        <div>
                            <div>
                                <div><b>Категория сделки</b></div>
                                <div>
                                    <select name="CATEGORY_ID" class="form-control import-bitrix">
                                        <?php if(!empty($_SESSION['bitrix']['CATEGORY_ID'])): ?>
                                            <option value="">Поумолчанию</option>
                                            <?php foreach($_SESSION['bitrix']['CATEGORY_ID'] as $key => $item): ?>
                                                <option value="<?= $key ?>"><?= $item ?></option>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </select>
                                </div>
                            </div>
                            <div>
                                <div><b>Ответственный за сделки</b></div>
                                <div>
                                    <select name="ASSIGNED_BY_ID" class="form-control import-bitrix">
                                        <?php if(!empty($_SESSION['bitrix']['ASSIGNED_BY_ID'])): ?>
                                            <option value="">Поумолчанию</option>
                                            <?php foreach($_SESSION['bitrix']['ASSIGNED_BY_ID'] as $key => $item): ?>
                                                <option value="<?= $key ?>"><?= $item ?></option>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </select>
                                </div>
                            </div>
                            <div>
                                <div><b>Источник</b></div>
                                <div>
                                    <select name="SOURCE_ID" class="form-control import-bitrix">
                                        <?php if(!empty($_SESSION['bitrix']['SOURCE_ID'])): ?>
                                            <option value="">Поумолчанию</option>
                                            <?php foreach($_SESSION['bitrix']['SOURCE_ID'] as $key => $item): ?>
                                                <option value="<?= $key ?>"><?= $item ?></option>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </select>
                                </div>
                            </div>
                            <div>
                                <div><b>Заголовок</b></div>
                                <div>
                                    <input type="text" name="TITLE" placeholder="ИСЛ Обзвон" class="form-control import-bitrix">
                                </div>
                            </div>
                            <div>
                                <div><b>UTM</b></div>
                                <div>
                                    <input type="text" name="UTM_SOURCE" placeholder="some_utm" class="form-control import-bitrix">
                                </div>
                            </div>
                            <div>
                                <div><b>Комментарий</b></div>
                                <div>
                                    <input type="text" name="COMMENTS" placeholder="нажал 1" class="form-control import-bitrix">
                                </div>
                            </div>
                            <div>
                                <div><b>CSV-файл</b></div>
                                <div>
                                    <input accept=".csv" type="file" name="file" class="form-control import-bitrix">
                                </div>
                            </div>
                        </div>
                        <div style="margin-top: 20px"><button type="submit" class="btn btn-admin btn-import">Импорт выбранного файла</button></div>
                        <?= Html::endForm() ?>


                    </div>
                </li>
            </ul>
        </div>

        <div class="click-toggle session-save-bitrix">
            <span class="glyphicon glyphicon-chevron-right" aria-hidden="true" style="font-size: 16px"></span>
            Получение лида с обзвона в КЦ
        </div>
        <div class="hidden-toggle">
            <ul>
                <li><b class="spc-b">URL:</b> <span class="spc-span">https://api.myforce.ru/lead.get.from.call?cc=1</span></li>
                <li><b class="spc-b">HTTP-METHOD:</b> <span class="spc-span">GET</span></li>
                <li><b class="spc-b">Поля запроса</b></li>
                <pre>
# обязательные
type=dolgi,
cc=1

# необязательные
utm=some_utm
</pre></li>
                <li><b class="spc-b">Пример ссылки:</b> <span class="spc-span">https://api.myforce.ru/lead.get.from.call?cc=1&type=dolgi</span></li>
                <li><b class="spc-b">Особенности запроса:</b>
                    <ol>
                        <li>Поле <code>type</code> принимает параметр "Специальная ссылка" ТОЛЬКО для <a target="_blank" href="<?= Url::to(['/lead-force/leads-category']) ?>">существующей категории лидов</a></li>
                    </ol></li>
                <li><b class="spc-b">Использование:</b> указать URL с параметрами в качестве Webhook'а в программе обзвона</li>
                <li><b class="spc-b">Генератор ссылок</b>
                    <div class="generator-inps">
                        <div>
                            <div>
                                <div><b>Категория</b></div>
                                <div>
                                    <select name="type" id="select-category-3" class="form-control changer-url-3">
                                        <?php foreach($cats as $item): ?>
                                            <option value="<?= $item['link_name'] ?>"><?= $item['name'] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div>
                                <div><b>UTM</b></div>
                                <div><input type="text" name="utm" placeholder="some_utm" class="form-control changer-url-3"></div>
                            </div>
                        </div>
                        <div ><div style="margin-bottom: 5px"><b>URL:</b></div></div>
                        <div class="url-block-3" style=""><code>https://api.myforce.ru/lead.get.from.call?сс=1&type=dolgi</code></div>
                    </div>
                </li>
            </ul>
        </div>



        <div class="click-toggle session-save-bitrix" style="display: none">
            <span class="glyphicon glyphicon-chevron-right" aria-hidden="true" style="font-size: 16px"></span>
            Получение лидов с бекдора Битрикс24
        </div>
        <div class="hidden-toggle">
            <ul>
                <li><b class="spc-b">URL:</b> <span class="spc-span">https://api.myforce.ru/statistics.push/&lt;uuid&gt;/&lt;lead_id&gt;</span></li>
                <li><b class="spc-b">HTTP-METHOD:</b> <span class="spc-span">GET</span></li>
                <li><b class="spc-b">Поля запроса</b></li>
                <pre>
# обязательные
uuid=b1f674b9-b6bf-4d01-9ec1-561b8268b769,
lead_id=6230
</pre></li>
                <li><b class="spc-b">Пример ссылки:</b> <span class="spc-span">https://api.myforce.ru/statistics.push/b1f674b9-b6bf-4d01-9ec1-561b8268b769/6230</span></li>
                <li><b class="spc-b">Особенности запроса:</b>
                    <ol>
                        <li>Поле <code>uuid</code> принимает параметр "Ключ вебхука" ТОЛЬКО для <a target="_blank" href="<?= Url::to(['/lead-force/backdoor-webhooks']) ?>">существующего вебхука типа Backdoor</a></li>
                        <li>Поле <code>lead_id</code> принимает ID лида Битрикс24, которого необходимо записать в систему</li>
                    </ol></li>
                <li><b class="spc-b">Использование:</b> указать URL с параметрами в качестве Webhook'а в роботах или бизнес-процессах Битрикс24</li>
            </ul>
        </div>

    </div>
</div>
