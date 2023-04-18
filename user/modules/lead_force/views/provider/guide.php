<?php

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = "Лидогенерация";

$js = <<<JS
$('.inp-spc').on('click', function() {
    $(this).select();
});
$('.newUtm').on('click', function() {
    $.ajax({
        type: "POST",
        data: {create: true},
        dataType: "JSON",
        url: '/lead-force/provider/create-utm'
    }).done(function(e) {
        if (e.status === 'error') {
            Swal.fire({
              icon: 'error',
              title: 'Ошибка',
              text: e.message,
            });
        } else 
            location.reload();
    });
});
$('.removeUtm').on('click', function() {
    var name = $(this).attr('data-name');
    $.ajax({
        type: "POST",
        data: {remove: name},
        dataType: "JSON",
        url: '/lead-force/provider/remove-utm'
    }).done(function(e) {
        if (e.status === 'error') {
            Swal.fire({
              icon: 'error',
              title: 'Ошибка',
              text: e.message,
            });
        } else 
            location.reload();
    });
});
JS;

$this->registerJs($js);

?>
<style>
    .leadgen-main-div {
        font-size: 14px;
        padding: 20px 20px;
    }
    .inp-spc {
        max-width: 450px;
        width: 100%;
        border-radius: 3px;
        border: 1px solid gainsboro;
        padding: 5px 10px;
        letter-spacing: 0.1em;
    }
    .mb15{
        margin-bottom: 25px;
    }
    .header-h {
        letter-spacing: 0.1em;
        color: black;
    }
    .non-header {
        color: #616161;
    }
    code {
        background-color: #2b3048;
        color: white;
        padding: 3px 7px;
        font-size: 12px;
    }
    .flex-api-block {
        display: flex;
        flex-direction: column;
    }
    .flex-api-block > div {
        margin: 5px;
        display: flex;
        align-items: flex-start;
        width: 600px;
        justify-content: space-between;
        border-bottom: 1px solid gainsboro;
        padding-bottom: 10px;
    }
    .flex-api-block > div:last-child {
        border-bottom: unset;
    }
    .flex-api-block.special {
        flex-direction: row;
        width: 100%;
        justify-content: space-between;
    }
    .flex-api-block > div.special {
        border-bottom: 0;
        width: unset;
    }
    .span-desc {
        color: #636363;
    }
    .spc-ul-1 {
        list-style: circle !important;
        padding-left: 25px !important;
    }
    .spc-ul-1 > li {
        margin-bottom: 10px;
    }
    pre {
        overflow-x: auto;
    }
    .spc-bord{
        background: transparent;
        border-color: #ffffff;
        margin: 40px 0 20px;
        box-shadow: unset;
        border: unset;
        padding: 0;
        background-color: transparent;
        border-bottom: 1px solid #e9e9e9;
    }
    .removeUtm {
        transform: rotate(45deg); top: 0; right: 6px; font-size: 16px; position: absolute; cursor: pointer
    }
</style>
<section class="rightInfo adAptive">
    <div class="balance">
        <div class="bcr">
            <ul class="bcr__list">
                <li class="bcr__item">
                  <span class="bcr__link">
                    Лидогенерация
                  </span>
                </li>
            </ul>
        </div>

        <div class="title_row">
            <h1 class="Bal-ttl title-main">Лидогенерация</h1>
        </div>

        <article class="MainInfo">
            <div class="leadgen-main-div">
                <?php if(!empty($provider)): ?>
                    <div class="mb15">
                        <h3 class="header-h">Ваш персональный ключ поставщика</h3>
                    </div>
                    <div class="mb15"><input class="inp-spc" type="text" readonly value="<?= $provider->provider_token ?>"></div>
                    <div class="mb15">
                        <h3 class="header-h">Как поставлять лидов?</h3>
                    </div>
                    <div class="non-header mb15">
                        Используйте один из способов, представленных ниже, для поставки лидов в сервис Lead.Force
                    </div>
                    <div class="mb15">
                        <h3 class="header-h">Вариант 1: Работа с API</h3>
                    </div>
                    <div class="non-header">
                        <p class="mb15" style="max-width: 600px"><span>Добавление лида с вашим ключом поставщика. Метод актуален для любого способа и любого языка программирования &ndash; достаточно отправить <b>HTTP POST</b> запрос с указанными параметрами на указанный URL.</span></p>
                        <div class="flex-api-block">
                            <div><b>Метод: </b><span class="span-desc">POST</span></div>
                            <div><b>URL: </b><input readonly style="text-align: right; max-width: 288px" value="https://api.myforce.ru/lead.add" class="span-desc inp-spc"></div>
                            <div style="border-bottom: 0"><b>Обязательные параметры запроса</b></div>
                            <div style="display: flex; flex-direction: column">
                                <div class="flex-api-block special">
                                    <div class="special"><code>type</code></div>
                                    <div class="special"><span><b>*</b> тип оффера (строка)</span></div>
                                </div>
                                <div class="flex-api-block special">
                                    <div class="special"><code>phone</code></div>
                                    <div class="special"><span><b>*</b> телефон (строка)</span></div>
                                </div>
                                <div class="flex-api-block special">
                                    <div class="special"><code>ip</code></div>
                                    <div class="special"><span><b>*</b> IP лида (строка)<sup style="cursor: help" title="необязательное, если указан регион">(?)</sup></span></div>
                                </div>
                                <div class="flex-api-block special">
                                    <div class="special"><code>region</code></div>
                                    <div class="special"><span><b>*</b> регион лида (строка)<sup style="cursor: help" title="необязательное, если указан IP">(?)</sup></span></div>
                                </div>
                                <div class="flex-api-block special">
                                    <div class="special"><code>provider_token</code></div>
                                    <div class="special"><span><b>*</b> ключ поставщика (строка)</span></div>
                                </div>
                                <div class="flex-api-block special">
                                    <div class="special"><code>offer_token</code></div>
                                    <div class="special"><span><b>*</b> ключ оффера (строка)</span></div>
                                </div>
                            </div>
                            <div style="border-bottom: 0"><b>Необязательные параметры запроса</b></div>
                            <div style="display: flex; flex-direction: column">
                                <div class="flex-api-block special">
                                    <div class="special"><code>name</code></div>
                                    <div class="special"><span>имя лида (строка)</span></div>
                                </div>
                                <div class="flex-api-block special">
                                    <div class="special"><code>email</code></div>
                                    <div class="special"><span>email лида (строка)</span></div>
                                </div>
                                <div class="flex-api-block special">
                                    <div class="special"><code>city</code></div>
                                    <div class="special"><span>город лида (строка)</span></div>
                                </div>
                                <div class="flex-api-block special">
                                    <div class="special"><code>comments</code></div>
                                    <div class="special"><span>комментарии (html-строка)</span></div>
                                </div>
                                <div class="flex-api-block special">
                                    <div class="special"><code>params</code></div>
                                    <div class="special"><span>доп. параметры (json-строка)</span></div>
                                </div>
                                <div class="flex-api-block special">
                                    <div class="special"><code>utm_source</code></div>
                                    <div class="special"><span>UTM source (строка)</span></div>
                                </div>
                                <div class="flex-api-block special">
                                    <div class="special"><code>utm_campaign</code></div>
                                    <div class="special"><span>UTM campaign (строка)</span></div>
                                </div>
                                <div class="flex-api-block special">
                                    <div class="special"><code>utm_medium</code></div>
                                    <div class="special"><span>UTM medium (строка)</span></div>
                                </div>
                                <div class="flex-api-block special">
                                    <div class="special"><code>utm_content</code></div>
                                    <div class="special"><span>UTM content (строка)</span></div>
                                </div>
                                <div class="flex-api-block special">
                                    <div class="special"><code>utm_term</code></div>
                                    <div class="special"><span>UTM term (строка)</span></div>
                                </div>
                                <div class="flex-api-block special">
                                    <div class="special"><code>utm_title</code></div>
                                    <div class="special"><span>UTM title (строка)</span></div>
                                </div>
                                <div class="flex-api-block special">
                                    <div class="special"><code>utm_device_type</code></div>
                                    <div class="special"><span>UTM device type (строка)</span></div>
                                </div>
                                <div class="flex-api-block special">
                                    <div class="special"><code>utm_age</code></div>
                                    <div class="special"><span>UTM age (строка)</span></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="non-header mb15" style="max-width: 600px">
                        <div style="margin-bottom: 10px"><b>Обратите внимание!</b></div>
                        <ul class="spc-ul-1">
                            <li>поля, отмеченные звездочкой (*) &ndash; являются обязательными к заполнению</li>
                            <li>ключ поставщика можно найти на этой странице</li>
                            <li>ключ оффера можно найти на странице оффера, в который вы будете отправлять заявки</li>
                            <li>в случае, если IP-адрес лида не указан &ndash; необходимо обязательно указывать его регион.
                                <b>ВАЖНО:</b> формат указания региона должен соответствовать формату ФИАС.
                                Необходимый формат региона можно найти в столбце <b>name_with_type</b> по
                               <b> <a target="_blank" href="https://github.com/hflabs/region/blob/master/region.csv">ссылке</a></b></li>
                            <li>для генерации лида необходимо указывать только первую группу параметров, однако, указание дополнительных параметров, вроде <b>имени</b>, <b>доп. параметров</b> и <b>комментариев</b> увеличит вероятность того, что лид не будет отбракован</li>
                        </ul>
                    </div>
                    <h3 class="header-h mb15">Пример лидогенерации на PHP <a download href="<?= Url::to(['/templates/example.zip']) ?>">(скачать)</a></h3>
                    <div class="non-header mb15">
                        <style>.arr-elem {color: #2ea26c}</style>
<pre style="color: whitesmoke; background-color: #303030; padding: 20px; ">
&lt;?php

    <span style="color: #a4a4a4"># ниже указаны данные, полученные, например, с одной из форм сайта (лидгена) или др. источников</span>
    <span style="color: violet">$lead_data</span> = [
        <span style="color: #a4a4a4">#обязательные</span>
        <span class="arr-elem">'type'</span>                             => 'dolgi', <span style="color: #a4a4a4"># тип лидов, можно найти в оффере</span>
        <span class="arr-elem">'phone'</span>                         => '8(909)-012-33-34',
        <span class="arr-elem">'ip'</span>                                 => <span style="color: violet">$_SERVER</span>[<span class="arr-elem">'REMOTE_ADDR'</span>], <span style="color: #a4a4a4"># либо указать регион</span>
        <span class="arr-elem">'region'</span>                         => 'Московская обл', <span style="color: #a4a4a4"># либо указать IP</span>
        <span class="arr-elem">'provider_token'</span>        => '<?= $provider->provider_token ?>', <span style="color: #a4a4a4"># ваш ключ поставщика</span>
        <span class="arr-elem">'offer_token'</span>               => '&lt;токен оффера&gt;', <span style="color: #a4a4a4"># ключ оффера можно найти в его карточке</span>

        <span style="color: #a4a4a4">#необязательные</span>
        <span class="arr-elem">'name'</span>                         => 'Вася',
        <span class="arr-elem">'email'</span>                         => 'pupkin.ceo@gmail.co.uk',
        <span class="arr-elem">'city'</span>                             => 'Домодедово',
        <span class="arr-elem">'comments'</span>               => 'Комментарий 1<?= Html::encode("<br>") ?>Комментарий 2',
        <span class="arr-elem">'params'</span>                     => <span style="color: #eedc82">json_encode</span>([<span class="arr-elem">'sum'</span> => 1500000, <span class="arr-elem">'sum_text'</span> => 'от 500 000 рублей'],
                                                                    <span style="color: #0080e0">JSON_UNESCAPED_UNICODE</span>), <span style="color: #a4a4a4"># параметры лидов можно узнать в оффере</span>
        <span class="arr-elem">'utm_source'</span>             => 'some_utm',
        <span class="arr-elem">'utm_campaign'</span>      => 'some_utm',
        <span class="arr-elem">'utm_medium'</span>          => 'some_utm',
        <span class="arr-elem">'utm_content'</span>           => 'some_utm',
        <span class="arr-elem">'utm_term'</span>                 => 'some_utm',
        <span class="arr-elem">'utm_title'</span>                   => 'some_utm',
        <span class="arr-elem">'utm_device_type'</span>  => 'some_utm',
        <span class="arr-elem">'utm_age'</span>                  => 'some_utm',
        <span class="arr-elem">'utm_inst'</span>                   => 'some_utm',
        <span class="arr-elem">'utm_special'</span>            => 'some_utm'
    ];

    <span style="color: violet">$ch</span> = <span style="color: #eedc82">curl_init</span>();

    <span style="color: #eedc82">curl_setopt_array</span>(<span style="color: violet">$ch</span>, [
        <span class="arr-elem">CURLOPT_URL</span>                                   => 'https://api.myforce.ru/lead.add',
        <span class="arr-elem">CURLOPT_POST</span>                                => true,
        <span class="arr-elem">CURLOPT_POSTFIELDS</span>                     => <span style="color: #eedc82">http_build_query</span>(<span style="color: violet">$lead_data</span>),
        <span class="arr-elem">CURLOPT_TIMEOUT</span>                          => 10,
        <span class="arr-elem">CURLOPT_CONNECTTIMEOUT</span>        => 10,
        <span class="arr-elem">CURLOPT_RETURNTRANSFER</span>          => true
    ]);

    <span style="color: violet">$response</span> = <span style="color: #eedc82">curl_exec</span>(<span style="color: violet">$ch</span>); <span style="color: #a4a4a4"># в $response будет лежать ответ сервера в формате json </span>
    <span style="color: violet">if</span> (!<span style="color: violet">$response</span>) <span style="color: #a4a4a4"># если ошибка cURL</span>
            <span style="color: violet">$response</span> = [<span class="arr-elem">'type'</span> => 'error', <span class="arr-elem">'code'</span> => 'curl', <span class="arr-elem">'message'</span> => <span style="color: violet">curl_error</span>(<span style="color: violet">$ch</span>)];
    <span style="color: #eedc82">curl_close</span>(<span style="color: violet">$ch</span>);

?&gt;
</pre>
                        <div><b>Примечание:</b> для работы указанного примера необходимо наличие включенного расширения php-curl</div>
                    </div>
                    <h3 class="header-h">Ответы сервера</h3>
                    <p class="mb15" style="margin-top: 10px">Сервер отвечает на ваши запросы в формате <b>JSON</b>. Ниже представлены коды ответов и примеры</p>
                    <ul class="spc-ul-1 mb15">
                        <li><code>200</code> &ndash; валидация пройдена успешно, лид добавлен с указанным ID</li>
                        <li><code>400</code> &ndash; не указаны параметры из обязательного блока, не указаны геоданные или неизвестный тип лидов, а также ошибка валидации поставляемых данных</li>
                        <li><code>403</code> &ndash; неизестный ключ поставщика или оффера (указаны неверно, либо недействительны)</li>
                        <li><code>405</code> &ndash; не указаны ключ доступа или ключ оффера, либо запрос был выполнен не POST-методом</li>
                        <li><code>-1</code> &ndash; отправлен дубль, в ответе возвращается номер телефона, по которому найден дубль</li>
                    </ul>
                    <p><b>Пример ответа с ошибкой:</b></p>
<pre style="color: whitesmoke; background-color: #303030; padding: 20px; font-family: monospace">
{
    "code":-1,
    "type":"error",
    "message":{
        "MSG":"Дубль",
        "LEAD":"89090123312"
    }
}
</pre>
                <p><b>Пример успешно добавленного лида:</b></p>
<pre style="color: whitesmoke; background-color: #303030; padding: 20px; font-family: monospace">
{
    "offer":"saved",
    "save":{
        "code":200,
        "type":"success",
        "message":{
            "MSG":"Успешно. Лид сохранен",
            "LEAD":2551781
        }
    }
}
</pre>



                        <hr class="spc-bord">
                        <div style="margin-bottom: 10px">
                            <h3>Вариант 2: Использование UTM-метки</h3>
                        </div>
                        <div class="non-header">
                            <p class="mb15" style="max-width: 600px"><span>Данный метод подойдет, если вы хотите просто пускать рекламу на сайт, поставляющий лидов для MYFORCE. Для этого достаточно распространять ссылку со своей UTM-меткой.</span></p>
                        </div>
                        <?php if(!empty($utms)): ?>
                            <div style="margin-bottom: 10px">
                                <p style="margin-bottom: 15px"><b>Мои метки:</b></p>
                                <div style="display: flex; flex-wrap: wrap">
                                    <?php foreach($utms as $item): ?>
                                        <div style="margin-right: 10px; margin-bottom: 10px; background-color: #fafafa; position: relative; border: 1px solid gainsboro; padding: 6px 20px 6px 12px; border-radius: 10px">
                                            <div><?= $item['name'] ?></div>
                                            <div class="removeUtm" data-name="<?= $item['name'] ?>">+</div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        <?php endif; ?>
                        <div class="btn btn-admin newUtm" style="max-width: 300px; margin-bottom: 20px">
                            Создать метку
                        </div>
                        <h3 class="header-h">Как использовать метку?</h3>
                        <div class="non-header" style="margin-top: 15px">
                            <p class="" style="max-width: 600px; margin-bottom: 10px;"><span>1. Уточните у менеджера в <a href="<?= Url::to(['provider/support']) ?>">тех. поддержке</a> (или в других каналах), какой сайт можно использовать для рекламы с указанной вами UTM-меткой</span></p>
                            <p class="mb15" style="max-width: 600px"><span>2. Пускайте траффик на указанный сайт с использованием вашей метки, например*: <span style="color: #006dcc">https://example.com</span>?utm_source=<span style="color: #9e0505">VigsZc12</span>&utm_campaign=<span style="color: #2ea26c">jn547ngf...</span></span></p>
                        </div>
                        <div style="color: #9e9e9e; font-size: 13px">
                            * - здесь красным выделена метка, синим - сам сайт, куда необходимо пускать траффик, зеленым - ключ оффера, в который вы планируете поставлять лиды
                        </div>





                <?php else: ?>
                    <div style="color: #9e9e9e">Для возможности лидогенерации сначала необходимо заполнить <a
                                href="prof">профиль</a></div>
                <?php endif; ?>
            </div>
        </article>
    </div>
</section>