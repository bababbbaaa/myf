<?php

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Начать проект';

$js = <<< JS
var step = 1;
function nextStep() {
  $('.Stap' + step++).fadeOut(300, function() {
      $('.Stap' + step).fadeIn(300);
      if($('.Stap5').is(':visible')){
            $('.create-resume-form_left-list-item:nth-child(5)').addClass('active');
            $('.create-resume-form_left-list-item:nth-child(5) .create-resume-form_left-list-item-indicator').addClass('active');
            $('.create-resume-form_left-list-item:nth-child(4) .create-resume-form_left-list-item-indicator').addClass('done').text('✓');
        }else if($('.Stap4').is(':visible')){
            $('.create-resume-form_left-list-item:nth-child(4)').addClass('active');
            $('.create-resume-form_left-list-item:nth-child(4) .create-resume-form_left-list-item-indicator').addClass('active');
            $('.create-resume-form_left-list-item:nth-child(3) .create-resume-form_left-list-item-indicator').addClass('done').text('✓');
            $('.create-course_modules-group').addClass('hide');
        }else if($('.Stap3').is(':visible')){
            $('.create-resume-form_left-list-item:nth-child(3)').addClass('active');
            $('.create-resume-form_left-list-item:nth-child(3) .create-resume-form_left-list-item-indicator').addClass('active');
            $('.create-resume-form_left-list-item:nth-child(2) .create-resume-form_left-list-item-indicator').addClass('done').text('✓');
        }else if($('.Stap2').is(':visible')){
            $('.create-resume-form_left-list-item:nth-child(2)').addClass('active');
            $('.create-resume-form_left-list-item:nth-child(2) .create-resume-form_left-list-item-indicator').addClass('active');
            $('.create-resume-form_left-list-item:nth-child(1) .create-resume-form_left-list-item-indicator').addClass('done').text('✓');
            $('.addprogram_anket-save').attr('disabled', false);
        }
  });
}
$('.button__next').on('click', function() {
    if (step === 1 && $('input[name="project-name"]').val() !== '' && $('input[name="project-link"]').val() !== '') nextStep();
    else if (step === 2) nextStep();
    else if (step === 3 && $(".input-textarea").val() !== '') nextStep();
    else if (step === 4 && $('input[name="project-servises[]"]').is(':checked')) $('.startproject-form').submit();
});

$('.startproject-form').on('submit', function (e) {
  $.ajax({
      url: "/dev/main/create-project",
      method: "POST",
      data: $(this).serialize(),
      beforeSend: function (){
          $('.button__next').css('disabled', true);
      },
  }).done(function(r) {
    if (r.status === 'error'){
        Swal.fire({
        icon: 'error',
        title: 'Ошибка!',
        text: r.message,
        confirmButtonText: 'Принять',
    });
    } else {
        Swal.fire({
           icon: 'success',
           title: 'Проект создан!',
           text: r.message, 
           confirmButtonText: 'Принять',
        }).then(() => {
            location.href = '/dev/my-projects';
        });
    }
  });
  e.preventDefault();
});
function rus_to_latin ( str ) {
    let ru = {
        'а': 'a', 'б': 'b', 'в': 'v', 'г': 'g', 'д': 'd', 
        'е': 'e', 'ё': 'e', 'ж': 'j', 'з': 'z', 'и': 'i', 
        'к': 'k', 'л': 'l', 'м': 'm', 'н': 'n', 'о': 'o', 
        'п': 'p', 'р': 'r', 'с': 's', 'т': 't', 'у': 'u', 
        'ф': 'f', 'х': 'h', 'ц': 'c', 'ч': 'ch', 'ш': 'sh', 
        'щ': 'shch', 'ы': 'y', 'э': 'e', 'ю': 'u', 'я': 'ya'
    }, n_str = [];
    str = str.replace(/[ъь]+/g, '').replace(/й/g, 'i');
    for ( let i = 0; i < str.length; ++i ) {
       n_str.push(
              ru[ str[i] ]
           || ru[ str[i].toLowerCase() ] === undefined && str[i]
           || ru[ str[i].toLowerCase() ].replace(/^(.)/, function ( match ) { return match.toUpperCase() })
       );
    }
    return n_str.join('');
}
$('#titleInput').on('input',function() {
  let j = rus_to_latin($(this).val());
  j = j.replace(/ /g, '-');
  $('#linkArticle').val(j.toLowerCase());
});

JS;
$this->registerJs($js);


$css =<<< CSS

.name__valid:invalid{
    border: 1px solid red;
}
.nave__valid:invalid:not(:focus){
    border: 1px solid grey;
}
.name__valid:valid{
    border: 1px solid green;
}
CSS;
$this->registerCss($css);
?>

<section class="rightInfo">
    <div class="bcr">
        <ul class="bcr__list">
            <li class="bcr__item">
                <span class="bcr__span">
                    Начать проект
                </span>
            </li>
        </ul>
    </div>

    <div class="title_row">
        <h1 class="Bal-ttl title-main">Начать проект</h1>
    </div>

    <section class="startproject">
        <div class="create-resume-form_container">
            <div class="create-resume-form_left">
                <div class="create-resume-form_left">
                    <div class="create-resume-form_left-line"></div>
                    <ul class="create-resume-form_left-list">
                        <li class="create-resume-form_left-list-item active">
                            <div class="create-resume-form_left-list-item-indicator active">1</div>
                            <p class="create-resume-form_left-list-item-text">Тип проекта</p>
                        </li>
                        <li class="create-resume-form_left-list-item">
                            <div class="create-resume-form_left-list-item-indicator ">2</div>
                            <p class="create-resume-form_left-list-item-text">Бюджет</p>
                        </li>
                        <li class="create-resume-form_left-list-item">
                            <div class="create-resume-form_left-list-item-indicator ">3</div>
                            <p class="create-resume-form_left-list-item-text">Задача</p>
                        </li>
                        <li class="create-resume-form_left-list-item">
                            <div class="create-resume-form_left-list-item-indicator ">4</div>
                            <p class="create-resume-form_left-list-item-text">Интеграции</p>
                        </li>
                    </ul>
                </div>
            </div>
            <?= Html::beginForm('', '', ['class' => 'startproject-form']) ?>
                <section class="create-resume-form_main">
                    <div class="create-resume-form_main_staps Stap1">
                        <div class="create-resume-form_main_container">
                            <h2 class="create-resume-form_main-title">1. Тип проекта</h2>
                            <h4 class="create-resume-form_main-subtitle">
                                Укажите, какой проект вы планируете запустить
                            </h4>
                            <div class="checkbox-group">
                                <label class="input-checkbox-wrapper">
                                    <input checked class="input-hide" type="radio" name="project-type" value="Корпоративный сайт">
                                    <span class="input-checkbox-indicator">Корпоративный сайт</span>
                                </label>
                                <label class="input-checkbox-wrapper">
                                    <input class="input-hide" type="radio" name="project-type" value="Посадочная страница">
                                    <span class="input-checkbox-indicator">Посадочная страница</span>
                                </label>
                                <label class="input-checkbox-wrapper">
                                    <input class="input-hide" type="radio" name="project-type" value="Сайт справочник">
                                    <span class="input-checkbox-indicator">Сайт справочник</span>
                                </label>
                                <label class="input-checkbox-wrapper">
                                    <input class="input-hide" type="radio" name="project-type" value="Интернет магазин">
                                    <span class="input-checkbox-indicator">Интернет магазин</span>
                                </label>
                                <label class="input-checkbox-wrapper">
                                    <input class="input-hide" type="radio" name="project-type" value="Моб. приложение">
                                    <span class="input-checkbox-indicator">Моб. приложение</span>
                                </label>
                                <label class="input-checkbox-wrapper">
                                    <input class="input-hide" type="radio" name="project-type" value="Личный кабинет">
                                    <span class="input-checkbox-indicator">Личный кабинет</span>
                                </label>
                                <label class="input-checkbox-wrapper">
                                    <input class="input-hide" type="radio" name="project-type" value="Веб приложение">
                                    <span class="input-checkbox-indicator">Веб приложение</span>
                                </label>
                                <label class="input-checkbox-wrapper">
                                    <input class="input-hide" type="radio" name="project-type" value="CRM система">
                                    <span class="input-checkbox-indicator">CRM система</span>
                                </label>
                                <label class="input-checkbox-wrapper">
                                    <input class="input-hide" type="radio" name="project-type" value="Дизайн / Редизайн">
                                    <span class="input-checkbox-indicator">Дизайн / Редизайн</span>
                                </label>
                                <label class="input-checkbox-wrapper">
                                    <input class="input-hide" type="radio" name="project-type" value="Gamedev">
                                    <span class="input-checkbox-indicator">Gamedev</span>
                                </label>
                                <label class="input-checkbox-wrapper">
                                    <input class="input-hide" type="radio" name="project-type" value="Другое">
                                    <span class="input-checkbox-indicator">Другое</span>
                                </label>
                            </div>
                            <label class="input__wrapper">
                                <p class="create-resume-form_main-text">Укажите название проекта</p>
                                <input name="project-name" required placeholder="Например: myforce" id="titleInput" type="text" class="input-t name__valid">
                                <input type="hidden" name="project-link" id="linkArticle" value="">
                            </label>
                            <div class="create-resume-form_main_btns">
                                <button class="btn--purple button__next btn--next" type="button">
                                    Далее  ➜
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="create-resume-form_main_staps Stap2">
                        <div class="create-resume-form_main_container">
                            <h2 class="create-resume-form_main-title">2. Бюджет</h2>
                            <h4 class="create-resume-form_main-subtitle">
                                Укажите примерную сумму комфортных инвестиций в разработку
                            </h4>
                            <div class="radio-group">
                                <label class="radio-wrapper">
                                    <input checked class="input-hide" type="radio" name="project-summ" value="80000">
                                    <div class="radio-indicator">
                                        <div class="radio-indicator-cube"><svg width="8" height="6" viewBox="0 0 8 6" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M7.7 0.3C7.3 -0.1 6.7 -0.1 6.3 0.3L3 3.6L1.7 2.3C1.3 1.9 0.7 1.9 0.3 2.3C-0.1 2.7 -0.1 3.3 0.3 3.7L2.3 5.7C2.5 5.9 2.7 6 3 6C3.3 6 3.5 5.9 3.7 5.7L7.7 1.7C8.1 1.3 8.1 0.7 7.7 0.3Z" fill="white"/></svg></div>
                                        <span>менее 100 000 руб.</span>
                                    </div>
                                </label>
                                <label class="radio-wrapper">
                                    <input class="input-hide" type="radio" name="project-summ" value="200000">
                                    <div class="radio-indicator">
                                        <div class="radio-indicator-cube"><svg width="8" height="6" viewBox="0 0 8 6" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M7.7 0.3C7.3 -0.1 6.7 -0.1 6.3 0.3L3 3.6L1.7 2.3C1.3 1.9 0.7 1.9 0.3 2.3C-0.1 2.7 -0.1 3.3 0.3 3.7L2.3 5.7C2.5 5.9 2.7 6 3 6C3.3 6 3.5 5.9 3.7 5.7L7.7 1.7C8.1 1.3 8.1 0.7 7.7 0.3Z" fill="white"/></svg></div>
                                        <span>от 100 000 до 300 000 руб.</span>
                                    </div>
                                </label>
                                <label class="radio-wrapper">
                                    <input class="input-hide" type="radio" name="project-summ" value="400000">
                                    <div class="radio-indicator">
                                        <div class="radio-indicator-cube"><svg width="8" height="6" viewBox="0 0 8 6" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M7.7 0.3C7.3 -0.1 6.7 -0.1 6.3 0.3L3 3.6L1.7 2.3C1.3 1.9 0.7 1.9 0.3 2.3C-0.1 2.7 -0.1 3.3 0.3 3.7L2.3 5.7C2.5 5.9 2.7 6 3 6C3.3 6 3.5 5.9 3.7 5.7L7.7 1.7C8.1 1.3 8.1 0.7 7.7 0.3Z" fill="white"/></svg></div>
                                        <span>от 300 000 до 600 000 руб.</span>
                                    </div>
                                </label>
                                <label class="radio-wrapper">
                                    <input class="input-hide" type="radio" name="project-summ" value="1000000">
                                    <div class="radio-indicator">
                                        <div class="radio-indicator-cube"><svg width="8" height="6" viewBox="0 0 8 6" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M7.7 0.3C7.3 -0.1 6.7 -0.1 6.3 0.3L3 3.6L1.7 2.3C1.3 1.9 0.7 1.9 0.3 2.3C-0.1 2.7 -0.1 3.3 0.3 3.7L2.3 5.7C2.5 5.9 2.7 6 3 6C3.3 6 3.5 5.9 3.7 5.7L7.7 1.7C8.1 1.3 8.1 0.7 7.7 0.3Z" fill="white"/></svg></div>
                                        <span>от 600 000 до 1,5 млн. рублей</span>
                                    </div>
                                </label>
                                <label class="radio-wrapper">
                                    <input class="input-hide" type="radio" name="project-summ" value="1500000">
                                    <div class="radio-indicator">
                                        <div class="radio-indicator-cube"><svg width="8" height="6" viewBox="0 0 8 6" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M7.7 0.3C7.3 -0.1 6.7 -0.1 6.3 0.3L3 3.6L1.7 2.3C1.3 1.9 0.7 1.9 0.3 2.3C-0.1 2.7 -0.1 3.3 0.3 3.7L2.3 5.7C2.5 5.9 2.7 6 3 6C3.3 6 3.5 5.9 3.7 5.7L7.7 1.7C8.1 1.3 8.1 0.7 7.7 0.3Z" fill="white"/></svg></div>
                                        <span>свыше 1,5 млн рублей</span>
                                    </div>
                                </label>
                            </div>
                            <div class="create-resume-form_main_btns">
                                <button class="btn--purple button__next btn--next" type="button">
                                    Далее  ➜
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="create-resume-form_main_staps Stap3">
                        <div class="create-resume-form_main_container">
                            <h2 class="create-resume-form_main-title">3. Задача</h2>
                            <h4 class="create-resume-form_main-subtitle">
                            Расскажите подробно о своём проекте. Можете прикрепить файл с описанием
                            </h4>
                            <label>
                                <textarea required class="input-t input-textarea name__valid" name="projects-targer" placeholder="Проект создается с целью ..."></textarea>
                            </label>
                            <label class="input__wrapper">
                                <p class="create-resume-form_main-text">Ссылка на ТЗ</p>
                                <input name="about-project" placeholder="https://docs.google.com/spreadsheets/d/17TyMNGJ4sdpseH7PdAfgdex31D2yZtn_Q2y770Zv-n9P3rqrMiNo/edit#gid=17023240887" type="text" id="input__file" class="input-t">
                            </label>
                            <div class="create-resume-form_main_btns">
                                <button class="btn--purple button__next btn--next" type="button">
                                    Далее  ➜
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="create-resume-form_main_staps Stap4">
                        <div class="create-resume-form_main_container">
                            <h2 class="create-resume-form_main-title">4. Интеграции</h2>
                            <h4 class="create-resume-form_main-subtitle">
                                Укажите важные особенности разработки
                            </h4>
                            <div class="radio-group">
                                <label class="radio-wrapper">
                                    <input checked class="input-hide" type="checkbox" name="project-servises[]" value="Подключение к CRM">
                                    <div class="radio-indicator">
                                        <div class="radio-indicator-cube"><svg width="8" height="6" viewBox="0 0 8 6" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M7.7 0.3C7.3 -0.1 6.7 -0.1 6.3 0.3L3 3.6L1.7 2.3C1.3 1.9 0.7 1.9 0.3 2.3C-0.1 2.7 -0.1 3.3 0.3 3.7L2.3 5.7C2.5 5.9 2.7 6 3 6C3.3 6 3.5 5.9 3.7 5.7L7.7 1.7C8.1 1.3 8.1 0.7 7.7 0.3Z" fill="white"/></svg></div>
                                        <span>Подключение к CRM</span>
                                    </div>
                                </label>
                                <label class="radio-wrapper">
                                    <input class="input-hide" type="checkbox" name="project-servises[]" value="Подключение онлайн-кассы">
                                    <div class="radio-indicator">
                                        <div class="radio-indicator-cube"><svg width="8" height="6" viewBox="0 0 8 6" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M7.7 0.3C7.3 -0.1 6.7 -0.1 6.3 0.3L3 3.6L1.7 2.3C1.3 1.9 0.7 1.9 0.3 2.3C-0.1 2.7 -0.1 3.3 0.3 3.7L2.3 5.7C2.5 5.9 2.7 6 3 6C3.3 6 3.5 5.9 3.7 5.7L7.7 1.7C8.1 1.3 8.1 0.7 7.7 0.3Z" fill="white"/></svg></div>
                                        <span>Подключение онлайн-кассы</span>
                                    </div>
                                </label>
                                <label class="radio-wrapper">
                                    <input class="input-hide" type="checkbox" name="project-servises[]" value="Подключение внешних скриптов">
                                    <div class="radio-indicator">
                                        <div class="radio-indicator-cube"><svg width="8" height="6" viewBox="0 0 8 6" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M7.7 0.3C7.3 -0.1 6.7 -0.1 6.3 0.3L3 3.6L1.7 2.3C1.3 1.9 0.7 1.9 0.3 2.3C-0.1 2.7 -0.1 3.3 0.3 3.7L2.3 5.7C2.5 5.9 2.7 6 3 6C3.3 6 3.5 5.9 3.7 5.7L7.7 1.7C8.1 1.3 8.1 0.7 7.7 0.3Z" fill="white"/></svg></div>
                                        <span>Подключение внешних скриптов</span>
                                    </div>
                                </label>
                                <label class="radio-wrapper">
                                    <input class="input-hide" type="checkbox" name="project-servises[]" value="Создание своего API">
                                    <div class="radio-indicator">
                                        <div class="radio-indicator-cube"><svg width="8" height="6" viewBox="0 0 8 6" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M7.7 0.3C7.3 -0.1 6.7 -0.1 6.3 0.3L3 3.6L1.7 2.3C1.3 1.9 0.7 1.9 0.3 2.3C-0.1 2.7 -0.1 3.3 0.3 3.7L2.3 5.7C2.5 5.9 2.7 6 3 6C3.3 6 3.5 5.9 3.7 5.7L7.7 1.7C8.1 1.3 8.1 0.7 7.7 0.3Z" fill="white"/></svg></div>
                                        <span>Создание своего API</span>
                                    </div>
                                </label>
                                <label class="radio-wrapper">
                                    <input class="input-hide" type="checkbox" name="project-servises[]" value="Создание документации">
                                    <div class="radio-indicator">
                                        <div class="radio-indicator-cube"><svg width="8" height="6" viewBox="0 0 8 6" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M7.7 0.3C7.3 -0.1 6.7 -0.1 6.3 0.3L3 3.6L1.7 2.3C1.3 1.9 0.7 1.9 0.3 2.3C-0.1 2.7 -0.1 3.3 0.3 3.7L2.3 5.7C2.5 5.9 2.7 6 3 6C3.3 6 3.5 5.9 3.7 5.7L7.7 1.7C8.1 1.3 8.1 0.7 7.7 0.3Z" fill="white"/></svg></div>
                                        <span>Создание документации</span>
                                    </div>
                                </label>
                                <label class="radio-wrapper">
                                    <input class="input-hide" type="checkbox" name="project-servises[]" value="Необходимо обучение по эксплуатации">
                                    <div class="radio-indicator">
                                        <div class="radio-indicator-cube"><svg width="8" height="6" viewBox="0 0 8 6" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M7.7 0.3C7.3 -0.1 6.7 -0.1 6.3 0.3L3 3.6L1.7 2.3C1.3 1.9 0.7 1.9 0.3 2.3C-0.1 2.7 -0.1 3.3 0.3 3.7L2.3 5.7C2.5 5.9 2.7 6 3 6C3.3 6 3.5 5.9 3.7 5.7L7.7 1.7C8.1 1.3 8.1 0.7 7.7 0.3Z" fill="white"/></svg></div>
                                        <span>Необходимо обучение по эксплуатации</span>
                                    </div>
                                </label>
                                <label class="radio-wrapper">
                                    <input class="input-hide" type="checkbox" name="project-servises[]" value="Нужен хостинг / VPS">
                                    <div class="radio-indicator">
                                        <div class="radio-indicator-cube"><svg width="8" height="6" viewBox="0 0 8 6" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M7.7 0.3C7.3 -0.1 6.7 -0.1 6.3 0.3L3 3.6L1.7 2.3C1.3 1.9 0.7 1.9 0.3 2.3C-0.1 2.7 -0.1 3.3 0.3 3.7L2.3 5.7C2.5 5.9 2.7 6 3 6C3.3 6 3.5 5.9 3.7 5.7L7.7 1.7C8.1 1.3 8.1 0.7 7.7 0.3Z" fill="white"/></svg></div>
                                        <span>Нужен хостинг / VPS</span>
                                    </div>
                                </label>
                                <label class="radio-wrapper">
                                    <input class="input-hide" type="checkbox" name="project-servises[]" value="Сервисное обслуживание">
                                    <div class="radio-indicator">
                                        <div class="radio-indicator-cube"><svg width="8" height="6" viewBox="0 0 8 6" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M7.7 0.3C7.3 -0.1 6.7 -0.1 6.3 0.3L3 3.6L1.7 2.3C1.3 1.9 0.7 1.9 0.3 2.3C-0.1 2.7 -0.1 3.3 0.3 3.7L2.3 5.7C2.5 5.9 2.7 6 3 6C3.3 6 3.5 5.9 3.7 5.7L7.7 1.7C8.1 1.3 8.1 0.7 7.7 0.3Z" fill="white"/></svg></div>
                                        <span>Сервисное обслуживание</span>
                                    </div>
                                </label>
                                <label class="radio-wrapper">
                                    <input class="input-hide" type="checkbox" name="project-servises[]" value="Только лицензионный / собственный софт (передача прав)">
                                    <div class="radio-indicator">
                                        <div class="radio-indicator-cube"><svg width="8" height="6" viewBox="0 0 8 6" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M7.7 0.3C7.3 -0.1 6.7 -0.1 6.3 0.3L3 3.6L1.7 2.3C1.3 1.9 0.7 1.9 0.3 2.3C-0.1 2.7 -0.1 3.3 0.3 3.7L2.3 5.7C2.5 5.9 2.7 6 3 6C3.3 6 3.5 5.9 3.7 5.7L7.7 1.7C8.1 1.3 8.1 0.7 7.7 0.3Z" fill="white"/></svg></div>
                                        <span>Только лицензионный / собственный софт (передача прав)</span>
                                    </div>
                                </label>
                                <label class="radio-wrapper">
                                    <input class="input-hide" type="checkbox" name="project-servises[]" value="Ничего не планирую подключать">
                                    <div class="radio-indicator">
                                        <div class="radio-indicator-cube"><svg width="8" height="6" viewBox="0 0 8 6" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M7.7 0.3C7.3 -0.1 6.7 -0.1 6.3 0.3L3 3.6L1.7 2.3C1.3 1.9 0.7 1.9 0.3 2.3C-0.1 2.7 -0.1 3.3 0.3 3.7L2.3 5.7C2.5 5.9 2.7 6 3 6C3.3 6 3.5 5.9 3.7 5.7L7.7 1.7C8.1 1.3 8.1 0.7 7.7 0.3Z" fill="white"/></svg></div>
                                        <span>Ничего не планирую подключать</span>
                                    </div>
                                </label>
                            </div>
                            <div class="create-resume-form_main_btns">
                                <button class="btn--purple button__next btn--next" type="button">
                                    Отправить заявку
                                </button>
                            </div>
                        </div>
                    </div>
                </section>
            <?= Html::endForm(); ?>
        </div>
    </section>
</section>