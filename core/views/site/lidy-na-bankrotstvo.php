<?php


use yii\helpers\Html;
use yii\helpers\Url;

$js = <<<JS

    // Первый таб
    const tabLawyers = document.querySelectorAll('.buying-lawyers__tabs-header');
    const lawyersList = document.querySelectorAll('.buying-lawyers__list_active');
    const arrowRotate = document.querySelectorAll('.buying-lawyers__tabs-header img');
    

    for (let i = 0; i < tabLawyers.length; i++) {
        tabLawyers[i].addEventListener('click', () => {
            lawyersList[i].classList.toggle('buying-lawyers__list_active');
            arrowRotate[i].classList.toggle('rotate');
            
        })
    }
    
    
    // Второй табa
    const qualityTab = document.querySelectorAll('.questions-answer__tabs');
    const qualityTabImg1 = document.querySelectorAll('.questions-img-one');
     const qualityTabImg2 = document.querySelectorAll('.questions-img-two');
     const textHidden = document.querySelectorAll('.questions-hidden');
    
        for (let i = 0; i < qualityTab.length; i++) {
        qualityTab[i].addEventListener('click', () => {
                qualityTabImg1[i].classList.toggle('questions-img-one');
                qualityTabImg2[i].classList.toggle('questions-img-two');
                textHidden[i].classList.toggle('questions-hidden');
        })
    }
    // Аудио
     const sound1 = new Howl({
        src: ['/audio/1.mp3'],
        html5: true,
        onplay: function() {
            requestAnimationFrame(step1);
        }
    });

    const sound2 = new Howl({
        src: ['/audio/2.mp3'],
        html5: true,
        onplay: function() {
            requestAnimationFrame(step2);
        }
    });

    const sound3 = new Howl({
        src: ['/audio/3.mp3'],
        html5: true,
        onplay: function() {
            requestAnimationFrame(step3);
        }
    });


    const btn = document.querySelectorAll('.aud-btn-1');
    const btn2 = document.querySelectorAll('.aud-btn-2');

    for (let i = 0; i < btn.length; i++) {
        btn[i].addEventListener('click', (e) => {
            e.preventDefault();
            
          if (i === 0) {
            sound1.play();

        } else if (i === 1) {
            sound2.play();
        } else if (i === 2) {
            sound3.play();
        }
            if(!btn[i].classList.contains('aud-btn-hidden')) {
                btn[i].classList.add('aud-btn-hidden');
                btn2[i].classList.remove('aud-btn-hidden');
            }
        });
    }

    for (let i = 0; i < btn2.length; i++) {
        btn2[i].addEventListener('click', (e) => {
            e.preventDefault();
            
        if (i === 0) {
            sound1.pause();
        } else if (i === 1) {
            sound2.pause();
        } else if (i === 2) {
            sound3.pause();
        }
            if(!btn2[i].classList.contains('aud-btn-hidden')) {
                btn2[i].classList.add('aud-btn-hidden');
                btn[i].classList.remove('aud-btn-hidden');
            }
        });
    }
    // Функция проигрывания звука
    // function play(id = 1) {
    //
    // }

    // Функция паузы звука
    // function pause(id) {
    //     if (id === 1) {
    //         sound1.pause();
    //     } else if (id === 2) {
    //         sound2.pause();
    //     } else if (id === 3) {
    //         sound3.pause();
    //     }
    // }

    function zeroTime (time) {
        if (time < 10) {
            return '0' + time;
        } else {
            return time;
        }
    }

    // Функция отображения времени и полосы прогресса для первого аудиофайла
    function step1() {
        const currentTime = sound1.seek();
        const duration = sound1.duration();
        let progress = (currentTime / duration) * 100;

        const minutes = Math.floor(currentTime / 60);
        const seconds = Math.floor(currentTime % 60);

        document.getElementById('time1').innerHTML = minutes + ':' + seconds + ':' + Math.floor(duration / 60) + ':' + zeroTime(Math.floor(duration % 60));
        document.getElementById('progress_circle1').style.left = progress + '%';

        if (sound1.playing()) {
            requestAnimationFrame(step1);
        }
    };

    // Функция отображения времени и полосы прогресса для второго аудиофайла
    function step2() {
        const currentTime = sound2.seek();
        const duration = sound2.duration();
        let progress = (currentTime / duration) * 100;

        const minutes = Math.floor(currentTime / 60);
        const seconds = Math.floor(currentTime % 60);

        document.getElementById('time2').innerHTML = minutes + ':' + seconds + ':' + Math.floor(duration / 60) + ':' + zeroTime(Math.floor(duration % 60));
        document.getElementById('progress_circle2').style.left = progress + '%';

        if (sound2.playing()) {
            requestAnimationFrame(step2);
        }
    }

    // Функция отображения времени и полосы прогресса для третьего аудиофайла
    function step3() {
        const currentTime = sound3.seek();
        const duration = sound3.duration();
        const progress = (currentTime / duration) * 100;

        const minutes = Math.floor(currentTime / 60);
        const seconds = Math.floor(currentTime % 60);

        document.getElementById('time3').innerHTML = minutes + ':' + seconds + ':' + Math.floor(duration / 60) + ':' + zeroTime(Math.floor(duration % 60));
        document.getElementById('progress_circle3').style.left = progress + '%';

        if (sound3.playing()) {
            requestAnimationFrame(step3);
        }
    }

    // Обновление времени для каждого аудиофайла
    sound1.on('load', function() {
        const duration = sound1.duration();
        document.getElementById('time1').innerHTML = '0:0' + Math.floor(duration / 60) + ':' + zeroTime(Math.floor(duration % 60));
    });

    sound2.on('load', function() {
        const duration = sound2.duration();
        document.getElementById('time2').innerHTML = '0:0' + Math.floor(duration / 60) + ':' + zeroTime(Math.floor(duration % 60));
    });

    sound3.on('load', function() {
        const duration = sound3.duration();
        document.getElementById('time3').innerHTML = '0:0' + Math.floor(duration / 60)  + ':' + zeroTime(Math.floor(duration % 60));
    });
    
    
$('#bankrot__tel').on('submit', function (e) {
    e.preventDefault();

    // Получаем значения полей формы
    var form_data = $("#bankrot__tel").serializeArray();
    
    // Проверяем, заполнены ли обязательные поля

    
    // Отправляем AJAX-запрос
    $.ajax({
        url: "/site/form",
        method: "POST",
        dataType: 'JSON',
        data: form_data,
        beforeSend: function () {

            $('.buyers__form').html($('.By__Leads__popap__card__contant-2').html());
        }
    });
});

JS;




$this->registerCssFile("@web/css/leads-bankruptcy.css");
$this->registerJsFile('@web/js/mainjs/jquery-3.5.1.min.js');

$this->registerJsFile('@web/js/howler.min.js');
$this->registerJs($js);
?>



<section class="leads-bankruptcy__header">
    <div class="container">
        <h1>Лиды на банкротство физических лиц (заявки от целевых клиентов)</h1>

        <p>Как купить лиды на банкротство физических лиц и при этом не получить пустышку</p>

       <p> <span>Из курса лекций "Эффективные продажи Банкротства" Мирослава Масальского</span></p>
    </div>
</section>


<section class="profitable-bankruptcy">
    <div class="container">

        <div class="baners-bankruptcy ">

            <h2>Купите 100 лидов на банкротство физических лиц в своём регионе с конверсией от 10% и получите в подарок ДОГОВОР на банкротство!</h2>
            <button class="showsCard" data-form-name="Купите 100 лидов на банкротство физических лиц в своём регионе с конверсией от 10% и получите в подарок ДОГОВОР на банкротство!">купить</button>

        </div>
        
        <div class="profitable-item">
            <div class="profitable-left-img">
                <img src="img/bankruptcy/buying-leads-img.svg" alt="">
            </div>

            <p>
                <span>Покупка лидов на банкротство</span> — это один из самых простых и распространённых способов получения клиентской базы для юридических компаний в 2023 году. Юридическая компания просто покупает лиды, инвестируя в рекламу, а лидогенератор передаёт уже <span>готовые заявки на услуги по банкротству от клиентов</span>. На сегодняшний момент более 90% компаний покупают именно лиды, а не настраивают рекламу самостоятельно.
            </p>
        </div>

        <div class="profitable-item__mobile">
            <p><span>Покупка лидов на банкротство</span> — это один из самых простых и распространённых способов получения клиентской базы для юридических компаний в 2023 году.</p>
            <div class="profitable-items__mobile">
                <img src="img/bankruptcy/buying-leads-img.svg" alt="">
                <p>Юридическая компания просто покупает лиды, инвестируя в рекламу, а лидогенератор передаёт уже <span>готовые заявки на услуги по банкротству от клиентов</span>.</p>
            </div>
            <p>На сегодняшний момент более 90% компаний покупают именно лиды, а не настраивают рекламу самостоятельно.</p>
        </div>

        <div class="profitable-block">
            <h2>Почему покупка лидов на банкротство физических лиц выгоднее, чем своя реклама</h2>

            <ul class="profitable-list">
                <li>
                    <div class="profitable-list__img">
                        <img src="/img/bankruptcy/buying-warn.png" alt="Предупреждение">
                    </div>
                    <p>Сейчас цена лида с рекламных кампаний, настроенных на банкротную нишу, <span>превышает 1200–1300 рублей</span>. Вызвано это огромным ростом конкуренции в регионах, а также грамотностью должников. О банкротстве уже знают многие, многие рекомендуют юридические компании и частных юристов.</p>
                </li>
                <li>
                    <div class="profitable-list__img">
                        <img src="/img/bankruptcy/buying-warn.png" alt="Предупреждение">
                    </div>
                    <p><span>Цена целевого лида</span>, а это именно тот лид, который согласился на банкротство, достигает <span>более 5 000 ₽</span>. То есть, из 5 лидов, только 1 будет подходит на банкротство по своим параметрам</p>
                </li>
                <li>
                    <div class="profitable-list__img">
                        <img src="/img/bankruptcy/buying-warn.png" alt="Предупреждение">
                    </div>
                    <p><span>Цена договора с клиентом</span> по лидам из Директа составляем <span>примерно</br> 30–35 000 рублей</span>, то есть из 6–7 лидов, у нас будет с вами только 1 договор. В конверсии это звучит неплохо, а именно: 14–16% конверсия в сделку. А вот цена такой сделки совсем не радует.</p>
                </li>
                <li>
                    <div class="profitable-list__img">
                        <img src="/img/bankruptcy/buying-warn.png" alt="Предупреждение">
                    </div>
                    <div class="profitable__wrap">
                        <p>Если взять расходы на процедуру в размере 40 000 ₽, цену договора с рекламы 35 000 ₽, заработную плату юристов, менеджеров, аренду офиса, расходы на телефонию, и прочее, при условии, что договор у нас заключён с клиентом на 140 000–150 000 ₽, <span>то маржа получается совсем минимальная</span>.</p>

                        <p >А при условии, что клиент платит ещё и в рассрочку, <span>начинающий юрист попросту не может потянуть рекламу</span>. У него нет критической массы сделок, которая давала бы ему оборотные средства для поддержания рекламного бюджета. А мы помним, что если реклама хотя бы день не работает, все её алгоритмы рушатся, и цена лида при повторном запуске взлетает вверх!</p>
                    </div>
                </li>



            </ul>

            <p>Выход один - <span>покупа качественных и не таких дорогих лидов</span> у поставщиков!</p>
        </div>
    </div>
</section>


<section class="baners-bankruptcy banners-lidy-one">
    <div class="container">
        <h2>MYFORCE PREMIUM — бесплатные лиды для юристов с пошаговым внедрением воронки продаж</h2>
        <button class="showsCard" data-form-name="MYFORCE PREMIUM — бесплатные лиды для юристов с пошаговым внедрением воронки продаж">получить</button>
    </div>
</section>

<section class="buying-lawyers">
    <div class="container">
        <h3>Какие лиды на банкротство физических лиц покупают юристы</h3>
        <p>Есть разные форматы лидов по банкротству физических лиц, и все они отличаются методом сбора и теплотой подогрева должников. Сейчас на рынке представлены следующие виды лидов:</p>

        <div class="buying-lawyers__tabs-wrap">
            <div class="buying-lawyers__tabs ">
                <div class="buying-lawyers__tabs-header ">
                    <h4>Лиды с рекламных сетей обработанные IVR</h4>
                    <img class="rotate"  src="img/bankruptcy/arrow.png" alt="стрелка">
                </div>
                <ul class="buying-lawyers__list buying-lawyers__list_active">
                    <li>
                        Это заявки от клиентов на банкротство, которые поступили с рекламы в Яндексе или ВКонтакте, попали в систему IVR, где робот их верифицировал (проверил на актуальность).
                    </li>
                    <li>
                        Такие лиды довольно качественные, однако, IVR не всегда понимает ответы, иногда не дозванивается до клиентов, или же путает ответы клиентов.
                    </li>
                    <li>
                        <span>Качество таких лидов на банкротство</span>, одним словом, можно охарактеризовать, как: <span>среднее</span>
                    </li>
                    <li>
                        Цена таких лидов обычно <span>очень высокая</span> по сравнению с другими заявками
                    </li>
                </ul>
            </div>
            <div class="buying-lawyers__tabs ">
                <div class="buying-lawyers__tabs-header">
                    <h4>Лиды с обработки баз</h4>
                    <img class="rotate"  src="img/bankruptcy/arrow.png" alt="стрелка">
                </div>
                <ul class="buying-lawyers__list buying-lawyers__list_active">
                    <li>
                        Качество таких заявок на банкротство довольно низкое, попадается много спама, много недовольных должников, которые хотят поругаться с юристом, а также тех, у кого вообще долгов и проблем нет
                    </li>
                    <li>
                        Такие лиды получаются тем же IVR, вот только робот обрабатывает не тёплые лиды с рекламы, а холодные базы, полученные из разных источников.
                    </li>
                    <li>
                        <span>Качество заявок обычно очень низкое</span>, а вот цены ломят высокие
                    </li>
                </ul>
            </div>
            <div class="buying-lawyers__tabs">
                <div class="buying-lawyers__tabs-header">
                    <h4>Прямые лиды с Директа или Вконтакте</h4>
                    <img class="rotate"  src="img/bankruptcy/arrow.png" alt="стрелка">
                </div>
                <ul class="buying-lawyers__list buying-lawyers__list_active">
                    <li>
                        Лиды дорогие, качество высокое, лидов мало. Это краткое и лаконичное объяснение.
                    </li>
                    <li>
                        Поставщики лидов, которые работают по такой схеме (реклама + посадочная страница) обычно продают лиды только одному или двум юристам в конкретном регионе. Очень часто такие поставщики используют <span>метод расчётов не за целевой лид</span>, как у всех, а берут <span>отдельно оплату за свои услуги</span>, и <span>отдельно просят оплатить рекламный бюджет</span>.
                    </li>
                    <li>
                        Если кратко, то такие лиды на банкротство являются качественными, но их очень мало на рынке, и стоят они нереально дорого.
                    </li>
                    <li>
                        Риски при работе с такими лидами также большие — всегда можно нарваться на маркетолога, который просто сольёт ваш бюджет.
                    </li>
                </ul>
            </div>
            <div class="buying-lawyers__tabs">
                <div class="buying-lawyers__tabs-header">
                    <h4>Лиды на банкротство с органического трафика</h4>
                    <img class="rotate"  src="img/bankruptcy/arrow.png" alt="стрелка">
                </div>
                <ul class="buying-lawyers__list buying-lawyers__list_active">
                    <li>
                        Такие лиды получаются за счёт СЕО статей, блогов, форумов, групп в соц сетях. Лидогенераторы собирают обращения со всех ресурсов в одну кучу, и отправляют юристам.
                    </li>
                    <li>
                        <span>Качество таких лидов самое низкое</span>, а цена зависит от того, с каким поставщиком вы работаете.
                    </li>
                    <li>
                        Если же выбирать между вариантами выше, то этот вариант заявок на банкротство <span> самый худший</span>.
                    </li>
                </ul>
            </div>
            <div class="buying-lawyers__tabs">
                <div class="buying-lawyers__tabs-header ">
                    <h4>Лиды с обработкой живого контакт-центра</h4>
                    <img class="rotate" src="img/bankruptcy/arrow.png" alt="стрелка">
                </div>
                <ul class="buying-lawyers__list buying-lawyers__list_active">
                    <li>
                        Это именно тот трафик, который поставляет <span class="buyers__pik">наша компания</span>. И на наш взгляд, а также по отзывам многих партнеров — это самый целевой трафик с самой оптимальной ценой!
                    </li>
                    <li>
                        За счёт того, что лиды пришедшие с рекламы, обрабатываются контакт-центром, получается отсечь более 95% брака, а также сделать практически <span>100% дозвон </span>до лида.
                    </li>
                    <li>
                        Минусом такой системы лидогенерации является то, что таких лидов также не сильно много. Поэтому мы работаем не со всеми юристами в регионах, а только с теме, кто готов выкупать весь трафик.
                    </li>
                </ul>
            </div>
        </div>
    </div>
</section>

<section class="examples-leads">
    <div class="container">
        <h3>Пример лидов на банкротство с обработкой контакт-центра</h3>
        <p>Чтобы у вас было понимание о том, как наши операторы обрабатывают лиды, мы даём вам возможность послушать часть записей с целевыми лидами:</p>

        <div class="audio__items">


            <div class="audio-block">
                <div class="audio__btn">
                    <button class="aud-btn-1">
                    <img src="/img/bankruptcy/play.svg" alt="начать">
                    </button>
                    <button class="aud-btn-2 aud-btn-hidden" >❚❚</button>
                </div>

                <div class="proggres__wrap">
                    <div class="progress-i" id="progress">
                        <div class="progress_circle" id="progress_circle1"></div>
                        <div class="progress_line" id="progress_line1"></div>

                    </div>
                    <span  class="time" id="time1"></span>
                </div>
            </div>

            <div class="audio-block">
                <div class="audio__btn">
                    <button class="aud-btn-1" >
                        <img src="/img/bankruptcy/play.svg" alt="начать">
                    </button>
                    <button class="aud-btn-2 aud-btn-hidden" >❚❚</button>
                </div>

                <div class="proggres__wrap">
                    <div class="progress-i" id="progress2">
                        <div class="progress_circle" id="progress_circle2"></div>
                        <div class="progress_line" id="progress_line2"></div>

                    </div>
                    <span  class="time" id="time2"></span>
                </div>
            </div>


            <div class="audio-block">
                <div class="audio__btn">
                    <button class="aud-btn-1" >
                        <img src="/img/bankruptcy/play.svg" alt="начать">
                    </button>
                    <button class="aud-btn-2 aud-btn-hidden" >❚❚</button>
                </div>

                <div class="proggres__wrap">
                    <div class="progress-i" id="progress3">
                        <div class="progress_circle" id="progress_circle3"></div>
                        <div class="progress_line" id="progress_line3"></div>

                    </div>
                    <span  class="time" id="time3"></span>
                </div>
            </div>

        </div>
        <div class="examples-leads__wrap">
            <div class="examples-leads__descr">
                <p>Основная задача оператора — <span>верифицировать лид</span>, то есть, узнать имя должника, сумму его долга, понять, как этот долг образовался, а также уточнить, готов ли он дальше общаться с юристами!</p>
                <p>Работать с должниками крайне сложно из-за спама, боязни брать трубку, страха перед коллекторами и банкротством, поэтому из 10 полученных нами лидов, только 2–3 становятся целевыми и передаются партнёрам.</p>
            </div>

            <div class="examples-leads__img">
                <img src="/img/bankruptcy/examples-leads.svg" alt="Пример лидов на банкротство с обработкой контакт-центра">
            </div>
        </div>
    </div>

    </div>


</section>

<section class="baners-bankruptcy  banners-lidy-two br-none">
    <div class="container">
        <h2>Лиды на банкротство обработанные живыми операторами перед отправкой партнёру — зарезервируйте объём и трафик сейчас!</h2>
        <a class="btn-bank" href="/site/registr?site=lead">зарезервировать</a>
    </div>
</section>

<section class="buy-from-us">
    <div class="container">
        <h3>Как купить лиды на банкротство физических лиц у нас</h3>

        <p class="buy-from-us__sub">Порядок получения качественных лидов очень простой:</p>
        
        <ul>
            <li>
                <img src="/img/bankruptcy/buying-one.png" alt="Вы оставляете заявку на нашем сайте">
                <p>Вы оставляете заявку на нашем сайте</p>
            </li>
            <li>
                <img src="/img/bankruptcy/buying-two.png" alt="Ваш персональный менеджер связывается с вами, уточняет регион и ваш рекламный бюджет">
                <p>Ваш персональный менеджер связывается с вами, уточняет регион и ваш рекламный бюджет</p>
            </li>
            <li>
                <img src="/img/bankruptcy/buying-three.png" alt="Проверяет объём трафика и наличие партнёров. И если все гладко, то делает вам коммерческое предложение">
                <p>Проверяет объём трафика и наличие партнёров. И если все гладко, то делает вам коммерческое предложение</p>
            </li>
        </ul>

        <p class="buy-from-us__text">
            Вы регистрируетесь <a href="/site/registr?site=lead">в личном кабинете партнёра</a>, пополняете бюджет, и через 3–5 дней получаете первые лиды
        </p>
        
        <div class="buy-from-us__wrap">
            <div class="buy-from-us__img">
                <img src="/img/bankruptcy/buying-leads-two.svg" alt="">
            </div>
            <div class="buy-from-us__descr">
                <p>В случае, если лид оказался не целевым, а такое бывает, то вы отправляете лид в брак!</p>
                <p class="mob">Мы даём прозрачную систему работы с гарантиями на полученный вами результат</p>
                <div class="buy-from__descr-mob">
                    <img src="/img/bankruptcy/buying-leads-two.svg" alt="">
                    <p>Мы даём прозрачную систему работы с гарантиями на полученный вами результат</p>
                </div>
                <p><span>У нас нет скрытых платежей, комиссий, и прочего</span>. Мы не разделяем стоимость лида на оплату наших услуг и на пополнение рекламного баланса. <span>Вы получаете ровно столько заявок, за сколько вы заплатили!</span></p>
            </div>
        </div>
    </div>
</section>

<section class="baners-bankruptcy  banners-lidy-three br-none">
    <div class="container">
        <h2>Регистрация в личном кабинете MYFORCE - Получите 1000 рублей на баланс лидов!</h2>
        <a class="btn-bank" href="/site/registr?site=lead">зарегестрироваться</a>
    </div>
</section>


<section class="lead-quality">
    <div class="container">
        <h3>Качество наших лидов и замена брака</h3>
        <p>На рынке мы работаем с 2015 года, и точно знаем какое качество лидов нужно именно вам. В данный момент лиды от нашей организации получают более 200 юридических компаний ежедневно. Трафик, который мы генерируем на 100% качественный и отвечает всем стандартам работы:</p>
        <ul>
            <li>
                <img src="img/bankruptcy/quality-one.svg" alt="">
                <p><span>Конверсия в договор: от 10%</span> (при срезе показателя за 3–4 месяца, и при условии обработки по нашей технологии).</p>
            </li>
            <li>
                <img src="img/bankruptcy/quality-two.svg" alt="">
                <p><span>Дозвон до лида: от 95% </span>(все лиды перед отправкой партнёру проверяет оператор в контакт-центре, наши лиды самые качественные по дозвону).</p>
            </li>
            <li>
                <img src="img/bankruptcy/quality-three.svg" alt="">
                <p><span>Замена брака: до 25% </span>(средний показатель брака по всем партнерам не более 12%).</p>
            </li>
            <li>
                <img src="img/bankruptcy/quality-four.svg" alt="">
                <p><span>Количество лидов в день:</span> зависит от региона, условий поставки лидов, и ваших предпочтений.</p>
            </li>
            <li>
                <img src="img/bankruptcy/quality-five.svg" alt="">
                <p><span>Запуск партнера:</span> 3–5 дней в зависимости от заказа.</p>
            </li>
        </ul>

        <p class="text-center "><span>Мы даем реальные лиды по реальным ценам уже более 8 лет!</span></p>
    </div>
</section>

<section class="baners-bankruptcy  banners-lidy-four br-none">
    <div class="container">
        <h2>Франшиза FemidaForce - готовый бизнес по банкротству с качественными лидами на старте!</h2>
        <button class="showsCard" data-form-name="Франшиза FemidaForce - готовый бизнес по банкротству с качественными лидами на старте!">подробнее</button>
    </div>
</section>

<section class="questions-answer">
    <div class="container">
        <h3>Вопросы и ответы по лидам</h3>

        <div class="questions-answer__wrap">
            <div class="questions-answer__item">
                <div class="questions-answer__tabs">
                    <h4 class="questions-text">Какой минимальный бюджет или минимальное количество лидов я могу купить?</h4>
                    <img  class="  questions-img-op-one questions-img-one" src="img/bankruptcy/question-hide.png" alt="Какой минимальный бюджет или минимальное количество лидов я могу купить?">
                    <img  class="questions-img-op-two questions-img-two "  src="img/bankruptcy/quastion-no.png" alt="Какой минимальный бюджет или минимальное количество лидов я могу купить?">
                </div>
                <p class="questions-body questions-hidden">
                    <span>Мы работаем с бюджетами от 50 000 ₽</span>. Меньшие суммы мы не рассматриваем, так как наша задача сделать так, чтобы вы остались довольны качеством лидов, и при этом сохранить гарантированную стоимость заявки.
                </p>
            </div>
            <div class="questions-answer__item">
                <div class="questions-answer__tabs">
                    <h4 class="questions-text">Я могу получить тестовые лиды на проверку?</p>
                    <img  class="  questions-img-op-one questions-img-one" src="img/bankruptcy/question-hide.png" alt="Какой минимальный бюджет или минимальное количество лидов я могу купить?">
                    <img  class="questions-img-op-two questions-img-two "  src="img/bankruptcy/quastion-no.png" alt="Какой минимальный бюджет или минимальное количество лидов я могу купить?">
                </div>
                <p class="questions-body questions-hidden">
                    <span>Мы не предоставляем тестовые лиды на банкротство</span>, так как нам нет нужны их раздавать бесплатно. Мы продаём весь трафик, который у нас есть партнёрам, которые хотят их купить. Смысла нам их отдавать вам бесплатно, если мы можем их продать? Проблем с партнёрами у нас в регионах нет, так как работаем мы с 1–2 юристами, а желающих в разы больше
                </p>
            </div>
            <div class="questions-answer__item">
                <div class="questions-answer__tabs">
                    <h4 class="questions-text">Куда я буду получать заявки от вас?</h4>
                    <img  class="  questions-img-op-one questions-img-one" src="img/bankruptcy/question-hide.png" alt="Какой минимальный бюджет или минимальное количество лидов я могу купить?">
                    <img  class="questions-img-op-two questions-img-two "  src="img/bankruptcy/quastion-no.png" alt="Какой минимальный бюджет или минимальное количество лидов я могу купить?">
                </div>
                <p class="questions-body questions-hidden">
                    <span>Мы поставляем лиды в личный кабинет партнёра</span>. В личном кабинете уже можно обрабатывать заявки, ставить статусы, и заменять браки. Дополнительно мы можем интегрировать заявки в вашу CRM или отправлять их на почту
                </p>
            </div>
            <div class="questions-answer__item">
                <div class="questions-answer__tabs">
                    <h4 class="questions-text">Как много лидов на банкротство физлиц я могу купить у вас?</h4>
                    <img  class="  questions-img-op-one questions-img-one" src="img/bankruptcy/question-hide.png" alt="Какой минимальный бюджет или минимальное количество лидов я могу купить?">
                    <img  class="questions-img-op-two questions-img-two "  src="img/bankruptcy/quastion-no.png" alt="Какой минимальный бюджет или минимальное количество лидов я могу купить?">
                </div>
                <p class="questions-body questions-hidden">
                    Все зависит от региона, в котором вы работаете. В некоторых регионах мы генерируем более 500 лидов на банкротство в месяц, в других 150–200. Из-за жёсткой фильтрации контакт-центром заявок, качественных и целевых лидов получается не так много, как хотелось бы всем. Однако, при отключение опции верификации лида, количество лидов вырастает в десятки раз, а цена падает. Объёмы, стоимость, и качество трафика лучше всего обсуждать с персональным менеджером лично!
                </p>
            </div>
            <div class="questions-answer__item">
                <div class="questions-answer__tabs">
                    <h4 class="questions-text">Как происходит замена брака по вашим лидам?</h4>
                    <img  class="  questions-img-op-one questions-img-one" src="img/bankruptcy/question-hide.png" alt="Какой минимальный бюджет или минимальное количество лидов я могу купить?">
                    <img  class="questions-img-op-two questions-img-two "  src="img/bankruptcy/quastion-no.png" alt="Какой минимальный бюджет или минимальное количество лидов я могу купить?">
                </div>
                <p class="questions-body questions-hidden">
                    Если мы поставляем вам бракованный лид, то значит и гарантировано его меняем. Для нас важно, чтобы лид был вами обработан, чтобы вы пытались ему дозвониться пару дней подряд, правильно начинали диалог с клиентом, а также правильно закрывали его на сделку. Поэтому, иногда, мы просим партнёров предоставить подтверждение брака. Если мы сами видим, что лид бракованный, то замена будет происходит сразу же, без каких-либо обсуждений.
                </p>
            </div>
            <div class="questions-answer__item">
                <div class="questions-answer__tabs">
                    <h4 class="questions-text">Что я могу продать по вашим лидам?</h4>
                    <img  class="  questions-img-op-one questions-img-one" src="img/bankruptcy/question-hide.png" alt="Какой минимальный бюджет или минимальное количество лидов я могу купить?">
                    <img  class="questions-img-op-two questions-img-two "  src="img/bankruptcy/quastion-no.png" alt="Какой минимальный бюджет или минимальное количество лидов я могу купить?">
                </div>
                <p class="questions-body questions-hidden">
                    Вы получаете заявки от клиентов, у которых есть подтверждённая проблема с долгами, кредитами, ЖКХ. Всем им <span>подходят услуги банкротства физ лиц</span>, поэтому вы смело можете продавать им процедуру признания их несостоятельными, или же предлагать другие услуги, например, финансовую защиту, или снижение ежемесячных платежей. Некоторые юристы также продают по нашим лидам защиту от коллекторов и отмену судебных приказов. Иногда предлагают даже рефинансирование или реструктуризацию кредитов. Все зависит от вашего прайса и возможностей отдела продаж.
                </p>
            </div>
            <div class="questions-answer__item">
                <div class="questions-answer__tabs">
                    <h4 class="questions-text">Я могу просить операторов указывать название нашей компании?</h4>
                    <img  class="  questions-img-op-one questions-img-one" src="img/bankruptcy/question-hide.png" alt="Какой минимальный бюджет или минимальное количество лидов я могу купить?">
                    <img  class="questions-img-op-two questions-img-two "  src="img/bankruptcy/quastion-no.png" alt="Какой минимальный бюджет или минимальное количество лидов я могу купить?">
                </div>
                <p class="questions-body questions-hidden">
                    Нет. Операторы работают по единому скрипту, который максимально эффективно верифицирует лиды. Если что-то менять в скриптах и в порядке работы оператора, цена лида непременно будет выше, а этого никто не хочет.
                </p>
            </div>
            <div class="questions-answer__item">
                <div class="questions-answer__tabs">
                    <h4 class="questions-text">Я хочу посмотреть на сайт, с которого вы генерируете трафик на банкротство</h4>
                    <img  class="  questions-img-op-one questions-img-one" src="img/bankruptcy/question-hide.png" alt="Какой минимальный бюджет или минимальное количество лидов я могу купить?">
                    <img  class="questions-img-op-two questions-img-two "  src="img/bankruptcy/quastion-no.png" alt="Какой минимальный бюджет или минимальное количество лидов я могу купить?">
                </div>
                <p class="questions-body questions-hidden">
                    Мы не раскрываем свои технологии генерации трафика на банкротство. Это посадочные страницы, квизы, и лендинги связанные с услугами юристов. Также, мы генерируем трафик с сайта
                    <a target="_blank" href="/femida">femidaforce.ru</a>
                </p>
            </div>
            <div class="questions-answer__item">
                <div class="questions-answer__tabs">
                    <h4 class="questions-text">Мне нужны контакты партнёров, кто уже покупал у вас лиды</h4>
                    <img  class="  questions-img-op-one questions-img-one" src="img/bankruptcy/question-hide.png" alt="Какой минимальный бюджет или минимальное количество лидов я могу купить?">
                    <img  class="questions-img-op-two questions-img-two "  src="img/bankruptcy/quastion-no.png" alt="Какой минимальный бюджет или минимальное количество лидов я могу купить?">
                </div>
                <p class="questions-body questions-hidden">
                    Без проблем! Мы открыты для сотрудничества, а все наши партнёры есть в открытом доступе. Более того, в нашем канале телеграмм (КЭБ) более 15 000 подписчиков. Все это юристы, которые работают с нами, или только задумываются о сотрудничестве. Мы всегда советуем обратиться к вашему персональному менеджеру, чтобы тот посмотрел, кто из партнёров работал в вашем регионе, или работает сейчас. Он предоставит вам контакты людей, у которых вы сможете запросить обратную связь!
                </p>
            </div>
            <div class="questions-answer__item">
                <div class="questions-answer__tabs">
                    <h4 class="questions-text">О вас плохие отзывы, ходят разные мнения?</h4>
                    <img  class="  questions-img-op-one questions-img-one" src="img/bankruptcy/question-hide.png" alt="Какой минимальный бюджет или минимальное количество лидов я могу купить?">
                    <img  class="questions-img-op-two questions-img-two "  src="img/bankruptcy/quastion-no.png" alt="Какой минимальный бюджет или минимальное количество лидов я могу купить?">
                </div>
                <p class="questions-body questions-hidden">
                    <span>Лиды на банкротство — это конкурентный рынок</span>, где каждый выживает как может. Многие небольшие лидогенераторы очень часто очерняют имя крупных поставщиков, только чтобы получить клиентов именно себе. Мы же не занимаемся чёрным пиаром, и никогда не говорим плохо о ком-либо из наших оппонентов. Также, не стоит забывать, что качество лидов — это динамический показатель, то есть, сегодня может быть 0 сделок, а через неделю сразу 5–6. Мы всегда рекомендуем судить о качестве лидов только после получения хотя бы 200–300 шт, и только после обработки их спустя 3–4 месяца.
            </div>
            <div class="questions-answer__item">
                <div class="questions-answer__tabs">
                    <h4 class="questions-text">А если конверсия по лидам будет ниже?</h4>
                    <img  class="  questions-img-op-one questions-img-one" src="img/bankruptcy/question-hide.png" alt="Какой минимальный бюджет или минимальное количество лидов я могу купить?">
                    <img  class="questions-img-op-two questions-img-two "  src="img/bankruptcy/quastion-no.png" alt="Какой минимальный бюджет или минимальное количество лидов я могу купить?">
                </div>
                <p class="questions-body questions-hidden">
                    <span>Средняя конверсия по нашим лидам: от 10%</span>. Она достигается качественной обработкой лидов, а также за счёт грамотной воронки продаж. Если у вас не выходит такая конверсия, то скорее всего вопрос заключается в ваших бизнес-процессах. Не может же быть такого, что у 199 партнёров все хорошо, а у вас плохо?
                </p>
            </div>

        </div>
    </div>
</section>


<section class="baners-bankruptcy  banners-lidy-five br-none">
    <div class="container">
        <h2>Узнай, можно ли купить лиды на банкротство в твоём городе</h2>
        <button class="showsCard" data-form-name="Узнай, можно ли купить лиды на банкротство в твоём городе">подробнее</button>
    </div>
</section>

<section class="buyers">
    <div class="container">
        <h2>Кто уже покупает наши лиды на банкротство</h2>

        <div class="buyers__wrap">
            <div class="buyers__text">
                <p>За 8 лет работы мы наработали обширную базу партнёров, которые каждый день приобретают наши лиды на услуги банкротства физических лиц.</p>
                <p>Сейчас у нас более 200 юристов и юридических офисов, кто ежедневно получает заявки на услуги списания долгов от кредитных должников.</p>
            </div>

            <div class="buyers__bg">
                <img src="img/bankruptcy/buying-leads-three.svg" alt="Кто уже покупает наши лиды на банкротство">
            </div>
        </div>

        <p>Среди них такие крупные компании и федеральные сети по банкротству, как:</p>

        <div class="buyers__partners">
            <ul>
                <li>
                    <img src="img/bankruptcy/logo-one.png" alt="ФЦБ">
                    <p>ФЦБ</p>
                </li>
                <li>
                    <img src="img/bankruptcy/logo-two.svg" alt="Стоп Долг">
                    <p>Стоп Долг</p>
                </li>
                <li>
                    <img src="img/bankruptcy/logo-three.png" alt="Витакон">
                    <p>Витакон</p>
                </li>
                <li>
                    <img src="img/bankruptcy/logo-four.svg" alt="Освободим">
                    <p>Освободим</p>
                </li>
            </ul>

        </div>
        <p>Полный перечень партнеров можно найти на нашем сайте <a href="/femida">femidaforce.ru</a> в разделе партнеры. </p>

        <h3>Отзывы о наших лидах на банкротство</h3>


            <div class="buyers__items">
           <div class="buyers__left">
                    <p>
                        Отзывы о сотрудничестве с нами, вы всегда сможете найти в интернете или <span class="buyers__pik">на нашем сайте</span>. Мы всегда стремимся <span>работать с партнёрами на результат</span>, и делать так, чтобы конверсия с наших лидов была на высоком уровень. Все очень просто, мы ищем партнёров, которые готовы работать с нами в долгую, а значит, и мы должны быть готовы всегда услышать партнера и пойти на встречу!
                    </p>

                <p>
                    Если вы хотите получить реальные отзывы от реальных юристов по банкротству, то оставляйте номер телефона для консультации, менеджер наберёт вас, и отправит контакты.
                </p>
           </div>
                <div class="buyers__right">
                    <?= Html::beginForm('', 'post', ['id' => 'bankrot__tel']) ?>
                    <input type="hidden" name="URL" value="<?= Url::current([], true) ?>">
                    <input type="hidden" name="formType" value="" id="formType">
                    <input type="hidden" name="pipeline" value="104">
                    <input type="hidden" name="utm_source" value="<?= $_SESSION['utm_source'] ?>">
                    <input type="hidden" name="utm_campaign" value="<?= $_SESSION['utm_campaign'] ?>">
                    <input type="hidden" name="service" value="">
                    <div class="buyers__form">
                        <h4>Оставить номер телефона</h4>
                        <input class="buyers__form_tel" required placeholder="+7" form="bankrot__tel" type="tel" name="phone"
                               id="phone_Ca">
                        <button form="bankrot__tel" class="buyers__btn" type="submit">Отправить</button>
                    </div>

                    <div class="By__Leads__popap__card__contant-2">
                        <div class="C_C_up">
                            <div class="C_C_up__wrap">
                                <img src="<?= Url::to(['/img/thanks-popup.svg']) ?>" alt="Спасибо!">

                                <p class="C_C_up-ttl">Спасибо!</p>
                                <p class="C_C_up-sttl text-al-cent">Ваша заявка принята. В ближайшее время с вами свяжутся для
                                    дальнейшей консультации.</p>

                            </div>
                        </div>

                    </div>
                    <?= Html::endForm(); ?>
                </div>
            </div>
    </div>

        </div>
</section>


<section class="regions-leads">
    <div class="container">
        <h2>В каких регионах я могу купить лиды на банкротство физлиц</h2>
        <p class="regions-leads__text">Мы работаем по всем регионам России. Вы можете взять лиды в конкретном регионе, или в нескольких областях, а можете выкупить трафик на всю Россию. С этого года мы также начали продавать лиды по банкротству и на Казахстан!</p>
        <p class="regions-leads__text-two">Если вы хотите купить лиды на банкротство физических лиц с обработкой живого контакт-центра, то вы легко можете заказать их у MYFORCE. Работаем с 2015 года.</p>
        <p class="regions-leads__descr">Лиды на банкротство физических лиц в: Абакан, Азов, Александров, Алексин, Альметьевск, Анапа, Ангарск, Анжеро-Судженск, Апатиты, Арзамас, Армавир, Арсеньев, Артем, Архангельск, Асбест, Астрахань, Ачинск, Балаково, Балахна, Балашиха, Балашов, Барнаул, Батайск, Белгород, Белебей, Белово, Белогорск (Амурская область), Белорецк, Белореченск, Бердск, Березники, Березовский (Свердловская область), Бийск, Биробиджан, Благовещенск (Амурская область), Бор, Борисоглебск, Боровичи, Братск, Брянск, Бугульма, Буденновск, Бузулук, Буйнакск, Великие Луки, Великий Новгород, Верхняя Пышма, Видное, Владивосток, Владикавказ, Владимир, Волгоград, Волгодонск, Волжск, Волжский, Вологда, Вольск, Воркута, Воронеж, Воскресенск, Воткинск, Всеволожск, Выборг, Выкса, Вязьма, Гатчина, Геленджик, Георгиевск, Глазов, Горно-Алтайск, Грозный, Губкин, Гудермес, Гуково, Гусь-Хрустальный, Дербент, Дзержинск, Димитровград, Дмитров, Долгопрудный, Домодедово, Донской, Дубна, Евпатория, Егорьевск, Ейск, Екатеринбург, Елабуга, Елец, Ессентуки, Железногорск (Красноярский край), Железногорск (Курская область), Жигулевск, Жуковский, Заречный, Зеленогорск, Зеленодольск, Златоуст, Иваново, Ивантеевка, Ижевск, Избербаш, Иркутск, Искитим, Ишим, Ишимбай, Йошкар-Ола, Казань, Калининград, Калуга, Каменск-Уральский, Каменск-Шахтинский, Камышин, Канск, Каспийск, Кемерово, Керчь, Кинешма, Кириши, Киров (Кировская область), Кирово-Чепецк, Киселевск, Кисловодск, Клин, Клинцы, Ковров, Когалым, Коломна, Комсомольск-на-Амуре, Копейск, Королев, Кострома, Котлас, Красногорск, Краснодар, Краснокаменск, Краснокамск, Краснотурьинск, Красноярск, Кропоткин, Крымск, Кстово, Кузнецк, Кумертау, Кунгур, Курган, Курск, Кызыл, Лабинск, Лениногорск, Ленинск-Кузнецкий, Лесосибирск, Липецк, Лиски, Лобня, Лысьва, Лыткарино, Люберцы, Магадан, Магнитогорск, Майкоп, Махачкала, Междуреченск, Мелеуз, Миасс, Минеральные Воды, Минусинск, Михайловка, Михайловск (Ставропольский край), Мичуринск, Москва, Мурманск, Муром, Мытищи, Набережные Челны, Назарово, Назрань, Нальчик, Наро-Фоминск, Находка, Невинномысск, Нерюнгри, Нефтекамск, Нефтеюганск, Нижневартовск, Нижнекамск, Нижний Новгород, Нижний Тагил, Новоалтайск, Новокузнецк, Новокуйбышевск, Новомосковск, Новороссийск, Новосибирск, Новотроицк, Новоуральск, Новочебоксарск, Новочеркасск, Новошахтинск, Новый Уренгой, Ногинск, Норильск, Ноябрьск, Нягань, Обнинск, Одинцово, Озерск (Челябинская область), Октябрьский, Омск, Орел, Оренбург, Орехово-Зуево, Орск, Павлово, Павловский Посад, Пенза, Первоуральск, Пермь, Петрозаводск, Петропавловск-Камчатский, Подольск, Полевской, Прокопьевск, Прохладный, Псков, Пушкино, Пятигорск, Раменское, Ревда, Реутов, Ржев, Рославль, Россошь, Ростов-на-Дону, Рубцовск, Рыбинск, Рязань, Салават, Сальск, Самара, Санкт-Петербург, Саранск, Сарапул, Саратов, Саров, Свободный, Севастополь, Северодвинск, Северск, Сергиев Посад, Серов, Серпухов, Сертолово, Сибай, Симферополь, Славянск-на-Кубани, Смоленск, Соликамск, Солнечногорск, Сосновый Бор, Сочи, Ставрополь, Старый Оскол, Стерлитамак, Ступино, Сургут, Сызрань, Сыктывкар, Таганрог, Тамбов, Тверь, Тимашевск, Тихвин, Тихорецк, Тобольск, Тольятти, Томск, Троицк, Туапсе, Туймазы, Тула, Тюмень, Узловая, Улан-Удэ, Ульяновск, Урус-Мартан, Усолье-Сибирское, Уссурийск, Усть-Илимск, Уфа, Ухта, Феодосия, Фрязино, Хабаровск, Ханты-Мансийск, Хасавюрт, Химки, Чайковский, Чапаевск, Чебоксары, Челябинск, Черемхово, Череповец, Черкесск, Черногорск, Чехов, Чистополь, Чита, Шадринск, Шали, Шахты, Шуя, Щекино, Щелково, Электросталь, Элиста, Энгельс, Южно-Сахалинск, Юрга, Якутск, Ялта, Ярославль</p>
    </div>
</section>