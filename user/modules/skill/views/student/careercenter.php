<?php

use user\modules\skill\controllers\StudentController;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\Pjax;

$this->title = 'Центр карьеры';

$resume = json_decode($myResume['info'], 1);
if (!empty($resume['projects'])) {
    $project = count($resume['projects']);
} else {
    $project = 1;
}
if (!empty($resume['experiences'])) {
    $experiences = count($resume['experiences']);
} else {
    $experiences = 1;
}
if (!empty($resume['education'])) {
    $education = count($resume['education']);
} else {
    $education = 1;
}
$js = <<< JS
$('.vacancy-reply').on('click', function() {
  var id = $(this).attr('data-id');
  $.ajax({
    url: '/skill/student/respond',
    data: {id:id},
    type: 'POST',
    dataType: 'JSON',
  }).done(function(rsp) {
    console.log(rsp);
    if (rsp === true){
        setTimeout(function() {
            location.reload();
        }, 500);
    } if (rsp === false){
        location.reload()
    }
  })
});

$('.MyOrders_filter-reset').on('click', function() {
    location.reload();
});

var project = '$project';
$('.add__project').on('click', function() {
  var htmls = '<h4 class="create-resume-form_main-second-title">Название проекта</h4><input placeholder="Название" type="text" name="projects['+ project +'][project-name]"class="input-t create-resume-form-input-t"><h4 class="create-resume-form_main-second-title">Ссылка на проект</h4><input placeholder="Название" type="text" name="projects['+ project +'][project-link]"class="input-t create-resume-form-input-t"><h4 class="create-resume-form_main-second-title">Описание проекта</h4><textarea placeholder="Расскажите о проекте более подробно"class="input-t create-resume-form-input-t" name="projects['+ project +'][project-discribe]" rows="10"style="resize: none;"></textarea>';
  $('.portfolio__block').append(htmls);
  project++;
});

var exp = '$experiences';
$('.add__exp-work').on('click', function() {
  var htmls = '<h4 class="create-resume-form_main-second-title">Период работы</h4><div class="create-resume-form_main_row"><select class="MyOrders_filter-selects" name="experiences['+exp+'][start-month]"><option selected disabled>Месяц начала работы</option><option class="sendActive" value="01">Январь</option><option class="sendActive" value="02">Февраль</option><option class="sendActive" value="03">Март</option><option class="sendActive" value="04">Апрель</option><option class="sendActive" value="05">Май</option><option class="sendActive" value="06">Июнь</option><option class="sendActive" value="07">Июль</option><option class="sendActive" value="08">Август</option><option class="sendActive" value="09">Сентябрь</option><option class="sendActive" value="10">Октябрь</option><option class="sendActive" value="11">Ноябрь</option><option class="sendActive" value="12">Декабрь</option></select><input placeholder="Год" type="text" name="experiences['+exp+'][year-start]" class="input-t"style="max-width: 120px; margin: 0px;"><p class="create-resume-form_main_row-text">В месяц</p><select class="MyOrders_filter-selects" name="experiences['+exp+'][end-month]"><option selected disabled>Месяц окончания работы</option><option class="sendActive" value="01">Январь</option><option class="sendActive" value="02">Февраль</option><option class="sendActive" value="03">Март</option><option class="sendActive" value="04">Апрель</option><option class="sendActive" value="05">Май</option><option class="sendActive" value="06">Июнь</option><option class="sendActive" value="07">Июль</option><option class="sendActive" value="08">Август</option><option class="sendActive" value="09">Сентябрь</option><option class="sendActive" value="10">Октябрь</option><option class="sendActive" value="11">Ноябрь</option><option class="sendActive" value="12">Декабрь</option></select><input placeholder="Год" type="text" name="experiences['+exp+'][year-end]" class="input-t"style="max-width: 120px; margin: 0px;"><label class="create-resume-form_main-input-group-item-label"><input type="checkbox" name="experiences['+exp+'][exp]" value="По настоящее время"class="rad viewcours_test-radio"><p class="create-resume-form_main-input-group-item-label-text">По настоящеевремя</p></label></div><h4 class="create-resume-form_main-second-title">Название организации</h4><input placeholder="Название" type="text" name="experiences['+exp+'][organization-name]"class="input-t create-resume-form-input-t"><h4 class="create-resume-form_main-second-title">Должность</h4><input placeholder="Название" type="text" name="experiences['+exp+'][position]" class="input-t create-resume-form-input-t"><h4 class="create-resume-form_main-second-title">Обязанности, достижения</h4><textarea placeholder="Расскажите о работе более подробно"class="input-t create-resume-form-input-t" name="experiences['+exp+'][work-discribe]" rows="10"style="resize: none;"></textarea>';
   $('.exp__work--block').append(htmls);  
   exp++;
});
var education = '$education';
$('.add_education').on('click', function() {
  var htmls = '<h4 class="create-resume-form_main-second-title">Период обучения</h4><div class="create-resume-form_main_row"><select class="MyOrders_filter-selects" name="education['+education+'][education-month-start]"><option selected disabled>Месяц начала</option><option class="sendActive" value="01">Январь</option><option class="sendActive" value="02">Февраль</option><option class="sendActive" value="03">Март</option><option class="sendActive" value="04">Апрель</option><option class="sendActive" value="05">Май</option><option class="sendActive" value="06">Июнь</option><option class="sendActive" value="07">Июль</option><option class="sendActive" value="08">Август</option><option class="sendActive" value="09">Сентябрь</option><option class="sendActive" value="10">Октябрь</option><option class="sendActive" value="11">Ноябрь</option><option class="sendActive" value="12">Декабрь</option></select><input placeholder="Год" type="text" name="education['+education+'][education-year-start]" class="input-t"style="max-width: 120px; margin: 0px;"><p class="create-resume-form_main_row-text">В месяц</p><select class="MyOrders_filter-selects" name="education['+education+'][education-month-end]"><option selected disabled>Месяц окончания</option><option class="sendActive" value="01">Январь</option><option class="sendActive" value="02">Февраль</option><option class="sendActive" value="03">Март</option><option class="sendActive" value="04">Апрель</option><option class="sendActive" value="05">Май</option><option class="sendActive" value="06">Июнь</option><option class="sendActive" value="07">Июль</option><option class="sendActive" value="08">Август</option><option class="sendActive" value="09">Сентябрь</option><option class="sendActive" value="10">Октябрь</option><option class="sendActive" value="11">Ноябрь</option><option class="sendActive" value="12">Декабрь</option></select><input placeholder="Год" type="text" name="education['+education+'][education-year-end]" class="input-t"style="max-width: 120px; margin: 0px;"><label class="create-resume-form_main-input-group-item-label"><input type="checkbox" name="education['+education+'][education-exp]" value="По настоящее время"class="rad viewcours_test-radio"><p class="create-resume-form_main-input-group-item-label-text">По настоящеевремя</p></label></div><h4 class="create-resume-form_main-second-title">Название учебного заведения</h4><input placeholder="Название" type="text" name="education['+education+'][education-name]"class="input-t create-resume-form-input-t"><h4 class="create-resume-form_main-second-title">Факультет, специализация</h4><input placeholder="Название" type="text" name="education['+education+'][education-faculty]"class="input-t create-resume-form-input-t">';
   $('.education__block').append(htmls);  
   education++
});

$('.resume-form').on('submit', function (e) {
  $.ajax({
      url: "/skill/student/create-resume",
      method: "POST",
      data: $(this).serialize(),
      dataType: 'JSON',
  }).done(function(rsp) {
      if (rsp.status === 'success'){
          $('.vebinar_notif-pop-back').fadeIn(300);
          $('.create-resume-form').removeClass('active');
          $('.created-resume').fadeIn(300);
      }
  })
  e.preventDefault();
});
$('.update-form').on('submit', function (e) {
  $.ajax({
      url: "/skill/student/update-resume",
      method: "POST",
      data: $(this).serialize(),
      dataType: 'JSON',
  }).done(function(rsp) {
      if (rsp.status === 'success'){
          $('.vebinar_notif-pop-back').fadeIn(300);
          $('.create-resume-form').removeClass('active');
          $('.created-resume').fadeIn(300);
      }
  })
  e.preventDefault();
});
$('.vebinar_notif-pop-btn').on('click', function() {
  location.reload();
});
$('.reload__resume').on('click', function() {
  $('.created-resume').fadeOut(300, function() {
    $('.create-resume-form').fadeIn(300);
  });
});

$('.get_resume').on('click', function(e) {
    e.preventDefault();
  $.ajax({
    url: '/skill/student/get-resume',
    type: 'POST',
    dataType: 'JSON',
    beforeSend: function(){
        $('.get_resume').prop('disabled', true).html('Ожидайте');
    },
  }).done(function(rsp) {
    if (rsp.status === 'success'){
          var file = rsp.message;
          location.href = '/'+rsp.message;
        setTimeout(function() {
          $.ajax({
              url: '/skill/student/del-resume',
              type: 'POST',
              dataType: 'JSON',
              data: {url:file},
              beforeSend: function() {
                $('.get_resume').prop('disabled', false).html('Скачать резюме');
              }
          })
        }, 5000)
    }
  });
});
$('.MyOrders_filter-selects').on('input', function() {
    setTimeout(function() {
        $('.vacancies-filter').submit();
    }, 100)
});
$('.vacancies-filter').on('submit', function(e) {
    var hash = window.location.hash;
  e.preventDefault();
  $.pjax.reload({
    container: '#JobCont',
    type: 'POST',
    data: $(this).serialize(),
    url: 'careercenter' + hash,
  })
})
JS;
$this->registerJs($js);
?>

<section class="rightInfo">
    <div class="bcr">
        <ul class="bcr__list">
            <li class="bcr__item">
                <span class="bcr__link">
                Центр карьеры
                </span>
            </li>

            <li class="bcr__item">
                <span class="bcr__span">
                Мое резюме
                </span>
            </li>
        </ul>
    </div>

    <div class="title_row">
        <h1 class="Bal-ttl title-main">Центр карьеры</h1>
    </div>
    <?php if (!StudentController::fullInfo($client)) : ?>
        <section class="card-notif card-notif-1">
            <button type="button" class="close card-notif-close">×</button>
            <h2 class="card-notif-text">
                Пожалуйста, заполните данные профиля, чтобы получить доступ к центру карьеры
            </h2>
            <a href="<?= Url::to(['profile']) ?>" class="card-notif-link btn--purple">Перейти в профиль</a>
        </section>
    <?php else: ?>
        <nav class="career_nav">
            <ul class="career_nav_list">
                <li class="career_nav_list-item career1 active">
                    <a href="#page1" class="career_nav_list-item-link">Мое резюме</a>
                    <div class="career_nav_list-item-line"></div>
                </li>
                <?php if (!empty($myResume)): ?>
                    <li class="career_nav_list-item career2">
                        <a href="#page2" class="career_nav_list-item-link">Вакансии</a>
                        <div class="career_nav_list-item-line"></div>
                    </li>
                    <li class="career_nav_list-item career3">
                        <a href="#page3" class="career_nav_list-item-link">Отклики</a>
                        <div class="career_nav_list-item-line"></div>
                    </li>
                <?php endif; ?>
            </ul>
        </nav>
        <article class="career-pages resume">
            <?php if (empty($myResume)): ?>
                <section class="create-resume">
                    <ul class="create-resume_list">
                        <li class="create-resume_list-item">
                            <p class="create-resume_list-item-stap">Шаг 1</p>
                            <img src="<?= Url::to('/img/skillclient/create-resume_list-1.png') ?>" alt="image">
                            <h2 class="create-resume_list-item-title">Составьте резюме</h2>
                        </li>
                        <li class="create-resume_list-item">
                            <p class="create-resume_list-item-stap">Шаг 2</p>
                            <img src="<?= Url::to('/img/skillclient/create-resume_list-2.png') ?>" alt="image">
                            <h2 class="create-resume_list-item-title">Откликнитесь на вакансию</h2>
                        </li>
                        <li class="create-resume_list-item">
                            <p class="create-resume_list-item-stap">Шаг 3</p>
                            <img src="<?= Url::to('/img/skillclient/create-resume_list-3.png') ?>" alt="image">
                            <h2 class="create-resume_list-item-title">Сотрудничаете с нашими партнерами</h2>
                        </li>
                    </ul>
                    <button type="button" class="btn--purple create-resume-open-btn">Составить резюме</button>
                </section>
                <section class="create-resume-form">
                    <?= Html::beginForm('', 'post', ['class' => 'resume-form']) ?>
                    <div class="create-resume-form_container">
                        <div class="create-resume-form_left">
                            <div class="create-resume-form_left-line"></div>

                            <ul class="create-resume-form_left-list">
                                <li class="create-resume-form_left-list-item active">
                                    <div class="create-resume-form_left-list-item-indicator active">1</div>
                                    <p class="create-resume-form_left-list-item-text">Пожелания к работе</p>
                                </li>
                                <li class="create-resume-form_left-list-item">
                                    <div class="create-resume-form_left-list-item-indicator">2</div>
                                    <p class="create-resume-form_left-list-item-text">Портфолио</p>
                                </li>
                                <li class="create-resume-form_left-list-item">
                                    <div class="create-resume-form_left-list-item-indicator">3</div>
                                    <p class="create-resume-form_left-list-item-text">Опыт работы</p>
                                </li>
                                <li class="create-resume-form_left-list-item">
                                    <div class="create-resume-form_left-list-item-indicator">4</div>
                                    <p class="create-resume-form_left-list-item-text">Образование</p>
                                </li>
                                <li class="create-resume-form_left-list-item">
                                    <div class="create-resume-form_left-list-item-indicator">5</div>
                                    <p class="create-resume-form_left-list-item-text">О себе</p>
                                </li>
                            </ul>
                        </div>

                        <section class="create-resume-form_main">
                            <div class="create-resume-form_main_staps Stap1">
                                <div class="create-resume-form_main_container">
                                    <h2 class="create-resume-form_main-title">1. Пожелания к работе</h2>
                                    <h3 class="create-resume-form_main-subtitle">
                                        Выберите удобный тип занятости
                                    </h3>
                                    <ul class="create-resume-form_main-input-group">
                                        <li class="create-resume-form_main-input-group-item">
                                            <label class="create-resume-form_main-input-group-item-label">
                                                <input type="radio" name="employment-type" value="Полная занятость"
                                                       class="rad viewcours_test-radio">
                                                <p class="create-resume-form_main-input-group-item-label-text">Полная
                                                    занятость</p>
                                            </label>
                                        </li>
                                        <li class="create-resume-form_main-input-group-item">
                                            <label class="create-resume-form_main-input-group-item-label">
                                                <input type="radio" name="employment-type" value="Частичная занятость"
                                                       class="rad viewcours_test-radio">
                                                <p class="create-resume-form_main-input-group-item-label-text">Частичная
                                                    занятость</p>
                                            </label>
                                        </li>
                                        <li class="create-resume-form_main-input-group-item">
                                            <label class="create-resume-form_main-input-group-item-label">
                                                <input type="radio" name="employment-type" value="Проектная занятость"
                                                       class="rad viewcours_test-radio">
                                                <p class="create-resume-form_main-input-group-item-label-text">Проектная
                                                    занятость</p>
                                            </label>
                                        </li>
                                        <li class="create-resume-form_main-input-group-item">
                                            <label class="create-resume-form_main-input-group-item-label">
                                                <input type="radio" name="employment-type" value="Любая занятость"
                                                       class="rad viewcours_test-radio">
                                                <p class="create-resume-form_main-input-group-item-label-text">Любая
                                                    занятость</p>
                                            </label>
                                        </li>
                                    </ul>
                                    <h4 class="create-resume-form_main-second-title">
                                        Укажите ваш город
                                    </h4>
                                    <input placeholder="Москва" type="text" name="city"
                                           class="input-t create-resume-form-input-t">
                                    <h3 class="create-resume-form_main-subtitle">
                                        Выберите удобный формат работы
                                    </h3>
                                    <ul class="create-resume-form_main-input-group">
                                        <li class="create-resume-form_main-input-group-item">
                                            <label class="create-resume-form_main-input-group-item-label">
                                                <input type="radio" name="work-format" value="В офисе"
                                                       class="rad viewcours_test-radio">
                                                <p class="create-resume-form_main-input-group-item-label-text">В
                                                    офисе</p>
                                            </label>
                                        </li>
                                        <li class="create-resume-form_main-input-group-item">
                                            <label class="create-resume-form_main-input-group-item-label">
                                                <input type="radio" name="work-format" value="Удаленно"
                                                       class="rad viewcours_test-radio">
                                                <p class="create-resume-form_main-input-group-item-label-text">
                                                    Удаленно</p>
                                            </label>
                                        </li>
                                    </ul>
                                    <h4 class="create-resume-form_main-second-title">
                                        Уточните ваши зарплатные ожидания
                                    </h4>
                                    <div class="create-resume-form_main_row">
                                        <input placeholder="От" type="number" name="money-from"
                                               class="input-t create-resume-form_main_row-item">
                                        <input placeholder="До" type="number" name="money-to"
                                               class="input-t create-resume-form_main_row-item">
                                        <p class="create-resume-form_main_row-text">В месяц</p>
                                    </div>
                                    <div class="create-resume-form_main_btns">
                                        <button class="btn--purple btn--next" type="button">
                                            Далее ➜
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div class="create-resume-form_main_staps Stap2">
                                <div class="create-resume-form_main_container">
                                    <h2 class="create-resume-form_main-title">2. Портфолио</h2>
                                    <div class="portfolio__block">
                                        <h4 class="create-resume-form_main-second-title">
                                            Название проекта
                                        </h4>
                                        <input placeholder="Название" type="text" name="projects[0][project-name]"
                                               class="input-t create-resume-form-input-t">
                                        <h4 class="create-resume-form_main-second-title">
                                            Ссылка на проект
                                        </h4>
                                        <input placeholder="Ссылка на проект" type="text"
                                               name="projects[0][project-link]"
                                               class="input-t create-resume-form-input-t">
                                        <h4 class="create-resume-form_main-second-title">
                                            Описание проекта
                                        </h4>
                                        <textarea placeholder="Расскажите о проекте более подробно"
                                                  class="input-t create-resume-form-input-t"
                                                  name="projects[0][project-discribe]" rows="10"
                                                  style="resize: none;"></textarea>
                                    </div>
                                    <div class="create-resume-form_main_btns">
                                        <button class="btn--purple btn--next" type="button">
                                            Далее ➜
                                        </button>
                                        <button class="btn--purple add__project" type="button">
                                            Добавить проект +
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div class="create-resume-form_main_staps Stap3">
                                <div class="create-resume-form_main_container">
                                    <h2 class="create-resume-form_main-title">3. Опыт работы</h2>
                                    <div class="exp__work--block">
                                        <h4 class="create-resume-form_main-second-title">
                                            Период работы
                                        </h4>
                                        <div class="create-resume-form_main_row">
                                            <select class="MyOrders_filter-selects" name="experiences[0][start-month]">
                                                <option selected disabled>Месяц начала работы</option>
                                                <option class="sendActive" value="01">Январь</option>
                                                <option class="sendActive" value="02">Февраль</option>
                                                <option class="sendActive" value="03">Март</option>
                                                <option class="sendActive" value="04">Апрель</option>
                                                <option class="sendActive" value="05">Май</option>
                                                <option class="sendActive" value="06">Июнь</option>
                                                <option class="sendActive" value="07">Июль</option>
                                                <option class="sendActive" value="08">Август</option>
                                                <option class="sendActive" value="09">Сентябрь</option>
                                                <option class="sendActive" value="10">Октябрь</option>
                                                <option class="sendActive" value="11">Ноябрь</option>
                                                <option class="sendActive" value="12">Декабрь</option>
                                            </select>
                                            <input placeholder="Год" type="text" name="experiences[0][year-start]"
                                                   class="input-t"
                                                   style="max-width: 120px; margin: 0px;">
                                            <p class="create-resume-form_main_row-text">В месяц</p>
                                            <select class="MyOrders_filter-selects" name="experiences[0][end-month]">
                                                <option selected disabled>Месяц окончания</option>
                                                <option class="sendActive" value="01">Январь</option>
                                                <option class="sendActive" value="02">Февраль</option>
                                                <option class="sendActive" value="03">Март</option>
                                                <option class="sendActive" value="04">Апрель</option>
                                                <option class="sendActive" value="05">Май</option>
                                                <option class="sendActive" value="06">Июнь</option>
                                                <option class="sendActive" value="07">Июль</option>
                                                <option class="sendActive" value="08">Август</option>
                                                <option class="sendActive" value="09">Сентябрь</option>
                                                <option class="sendActive" value="10">Октябрь</option>
                                                <option class="sendActive" value="11">Ноябрь</option>
                                                <option class="sendActive" value="12">Декабрь</option>
                                            </select>
                                            <input placeholder="Год" type="text" name="experiences[0][year-end]"
                                                   class="input-t"
                                                   style="max-width: 120px; margin: 0px;">
                                            <label class="create-resume-form_main-input-group-item-label">
                                                <input type="checkbox" name="experiences[0][exp]"
                                                       value="По настоящее время"
                                                       class="rad viewcours_test-radio">
                                                <p class="create-resume-form_main-input-group-item-label-text">По
                                                    настоящее
                                                    время</p>
                                            </label>
                                        </div>
                                        <h4 class="create-resume-form_main-second-title">
                                            Название организации
                                        </h4>
                                        <input placeholder="Название" type="text"
                                               name="experiences[0][organization-name]"
                                               class="input-t create-resume-form-input-t">
                                        <h4 class="create-resume-form_main-second-title">
                                            Должность
                                        </h4>
                                        <input placeholder="Название" type="text" name="experiences[0][position]"
                                               class="input-t create-resume-form-input-t">
                                        <h4 class="create-resume-form_main-second-title">
                                            Обязанности, достижения
                                        </h4>
                                        <textarea placeholder="Расскажите о работе более подробно"
                                                  class="input-t create-resume-form-input-t"
                                                  name="experiences[0][work-discribe]" rows="10"
                                                  style="resize: none;"></textarea>
                                    </div>

                                    <div class="create-resume-form_main_btns">
                                        <button class="btn--purple btn--next" type="button">
                                            Далее ➜
                                        </button>
                                        <button class="btn--purple add__exp-work" type="button">
                                            Добавить +
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div class="create-resume-form_main_staps Stap4">
                                <div class="create-resume-form_main_container">
                                    <h2 class="create-resume-form_main-title">4. Образование</h2>
                                    <div class="education__block">
                                        <h4 class="create-resume-form_main-second-title">
                                            Период обучения
                                        </h4>
                                        <div class="create-resume-form_main_row">
                                            <select class="MyOrders_filter-selects"
                                                    name="education[0][education-month-start]">
                                                <option selected disabled>Месяц начала обучения</option>
                                                <option class="sendActive" value="01">Январь</option>
                                                <option class="sendActive" value="02">Февраль</option>
                                                <option class="sendActive" value="03">Март</option>
                                                <option class="sendActive" value="04">Апрель</option>
                                                <option class="sendActive" value="05">Май</option>
                                                <option class="sendActive" value="06">Июнь</option>
                                                <option class="sendActive" value="07">Июль</option>
                                                <option class="sendActive" value="08">Август</option>
                                                <option class="sendActive" value="09">Сентябрь</option>
                                                <option class="sendActive" value="10">Октябрь</option>
                                                <option class="sendActive" value="11">Ноябрь</option>
                                                <option class="sendActive" value="12">Декабрь</option>
                                            </select>
                                            <input placeholder="Год" type="text"
                                                   name="education[0][education-year-start]"
                                                   class="input-t"
                                                   style="max-width: 120px; margin: 0px;">
                                            <p class="create-resume-form_main_row-text">В месяц</p>
                                            <select class="MyOrders_filter-selects"
                                                    name="education[0][education-month-end]">
                                                <option selected disabled>Месяц окончания</option>
                                                <option class="sendActive" value="01">Январь</option>
                                                <option class="sendActive" value="02">Февраль</option>
                                                <option class="sendActive" value="03">Март</option>
                                                <option class="sendActive" value="04">Апрель</option>
                                                <option class="sendActive" value="05">Май</option>
                                                <option class="sendActive" value="06">Июнь</option>
                                                <option class="sendActive" value="07">Июль</option>
                                                <option class="sendActive" value="08">Август</option>
                                                <option class="sendActive" value="09">Сентябрь</option>
                                                <option class="sendActive" value="10">Октябрь</option>
                                                <option class="sendActive" value="11">Ноябрь</option>
                                                <option class="sendActive" value="12">Декабрь</option>
                                            </select>
                                            <input placeholder="Год" type="text" name="education[0][education-year-end]"
                                                   class="input-t"
                                                   style="max-width: 120px; margin: 0px;">
                                            <label class="create-resume-form_main-input-group-item-label">
                                                <input type="checkbox" name="education[0][education-exp]"
                                                       value="По настоящее время"
                                                       class="rad viewcours_test-radio">
                                                <p class="create-resume-form_main-input-group-item-label-text">По
                                                    настоящее
                                                    время</p>
                                            </label>
                                        </div>
                                        <h4 class="create-resume-form_main-second-title">
                                            Название учебного заведения
                                        </h4>
                                        <input placeholder="Название" type="text" name="education[0][education-name]"
                                               class="input-t create-resume-form-input-t">
                                        <h4 class="create-resume-form_main-second-title">
                                            Факультет, специализация
                                        </h4>
                                        <input placeholder="Название" type="text" name="education[0][education-faculty]"
                                               class="input-t create-resume-form-input-t">
                                    </div>

                                    <div class="create-resume-form_main_btns">
                                        <button class="btn--purple btn--next" type="button">
                                            Далее ➜
                                        </button>
                                        <button class="btn--purple add_education" type="button">
                                            Добавить +
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div class="create-resume-form_main_staps Stap5">
                                <div class="create-resume-form_main_container">
                                    <h2 class="create-resume-form_main-title">5. О себе</h2>
                                    <h4 class="create-resume-form_main-second-title">
                                        Укажите ваш возраст
                                    </h4>
                                    <input type="number" name="old" class="input-t create-resume-form-input-t">
                                    <h4 class="create-resume-form_main-second-title">
                                        Расскажите о своих интересах
                                    </h4>
                                    <textarea placeholder="Напишите более подробно"
                                              class="input-t create-resume-form-input-t" name="discribe" rows="10"
                                              style="resize: none;"></textarea>

                                    <div class="create-resume-form_main_btns">
                                        <button class="btn--purple" type="submit">
                                            Создать резюме
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>
                    <?= Html::endForm(); ?>
                </section>
                <section class="vebinar_notif-pop-back">
                    <div class="vebinar_notif-pop-wrap">
                        <div class="vebinar_notif-pop">
                            <button class="pop-close"></button>

                            <img src="<?= Url::to('/img/skillclient/nice-done.svg') ?>" alt="angle">
                            <h3 class="vebinar_notif-pop-title">Резюме создано</h3>
                            <p class="vebinar_notif-pop-text">Ваше резюме успешно создано. Откликайтесь на вакансии и
                                сотрудничаете с нашими партнерами</p>
                            <button class="vebinar_notif-pop-btn btn--purple">Продолжить</button>
                        </div>
                    </div>
                </section>
            <?php else: ?>
                <section class="create-resume-form">
                    <?= Html::beginForm('', 'post', ['class' => 'update-form']) ?>
                    <div class="create-resume-form_container">
                        <div class="create-resume-form_left">
                            <div class="create-resume-form_left-line"></div>

                            <ul class="create-resume-form_left-list">
                                <li class="create-resume-form_left-list-item active">
                                    <div class="create-resume-form_left-list-item-indicator active">1</div>
                                    <p class="create-resume-form_left-list-item-text">Пожелания к работе</p>
                                </li>
                                <li class="create-resume-form_left-list-item">
                                    <div class="create-resume-form_left-list-item-indicator">2</div>
                                    <p class="create-resume-form_left-list-item-text">Портфолио</p>
                                </li>
                                <li class="create-resume-form_left-list-item">
                                    <div class="create-resume-form_left-list-item-indicator">3</div>
                                    <p class="create-resume-form_left-list-item-text">Опыт работы</p>
                                </li>
                                <li class="create-resume-form_left-list-item">
                                    <div class="create-resume-form_left-list-item-indicator">4</div>
                                    <p class="create-resume-form_left-list-item-text">Образование</p>
                                </li>
                                <li class="create-resume-form_left-list-item">
                                    <div class="create-resume-form_left-list-item-indicator">5</div>
                                    <p class="create-resume-form_left-list-item-text">О себе</p>
                                </li>
                            </ul>
                        </div>
                        <section class="create-resume-form_main">
                            <div style="display: block" class="create-resume-form_main_staps Stap1">
                                <div class="create-resume-form_main_container">
                                    <h2 class="create-resume-form_main-title">1. Пожелания к работе</h2>
                                    <h3 class="create-resume-form_main-subtitle">
                                        Выберите удобный тип занятости
                                    </h3>
                                    <ul class="create-resume-form_main-input-group">
                                        <li class="create-resume-form_main-input-group-item">
                                            <label class="create-resume-form_main-input-group-item-label">
                                                <input type="radio" <?= $resume['employment-type'] === 'Полная занятость' ? 'checked' : '' ?>
                                                       name="employment-type" value="Полная занятость"
                                                       class="rad viewcours_test-radio">
                                                <p class="create-resume-form_main-input-group-item-label-text">Полная
                                                    занятость</p>
                                            </label>
                                        </li>
                                        <li class="create-resume-form_main-input-group-item">
                                            <label class="create-resume-form_main-input-group-item-label">
                                                <input type="radio"
                                                       name="employment-type" <?= $resume['employment-type'] === 'Частичная занятость' ? 'checked' : '' ?>
                                                       value="Частичная занятость"
                                                       class="rad viewcours_test-radio">
                                                <p class="create-resume-form_main-input-group-item-label-text">Частичная
                                                    занятость</p>
                                            </label>
                                        </li>
                                        <li class="create-resume-form_main-input-group-item">
                                            <label class="create-resume-form_main-input-group-item-label">
                                                <input type="radio"
                                                       name="employment-type" <?= $resume['employment-type'] === 'Проектная занятость' ? 'checked' : '' ?>
                                                       value="Проектная занятость"
                                                       class="rad viewcours_test-radio">
                                                <p class="create-resume-form_main-input-group-item-label-text">Проектная
                                                    занятость</p>
                                            </label>
                                        </li>
                                        <li class="create-resume-form_main-input-group-item">
                                            <label class="create-resume-form_main-input-group-item-label">
                                                <input type="radio"
                                                       name="employment-type" <?= $resume['employment-type'] === 'Любая занятость' ? 'checked' : '' ?>
                                                       value="Любая занятость"
                                                       class="rad viewcours_test-radio">
                                                <p class="create-resume-form_main-input-group-item-label-text">Любая
                                                    занятость</p>
                                            </label>
                                        </li>
                                    </ul>
                                    <h4 class="create-resume-form_main-second-title">
                                        Укажите ваш город
                                    </h4>
                                    <input placeholder="Москва" value="<?= $resume['city'] ?>" type="text" name="city"
                                           class="input-t create-resume-form-input-t">
                                    <h3 class="create-resume-form_main-subtitle">
                                        Выберите удобный формат работы
                                    </h3>
                                    <ul class="create-resume-form_main-input-group">
                                        <li class="create-resume-form_main-input-group-item">
                                            <label class="create-resume-form_main-input-group-item-label">
                                                <input type="radio" <?= $resume['work-format'] === 'В офисе' ? 'checked' : '' ?>
                                                       name="work-format" value="В офисе"
                                                       class="rad viewcours_test-radio">
                                                <p class="create-resume-form_main-input-group-item-label-text">В
                                                    офисе</p>
                                            </label>
                                        </li>
                                        <li class="create-resume-form_main-input-group-item">
                                            <label class="create-resume-form_main-input-group-item-label">
                                                <input type="radio" <?= $resume['work-format'] === 'Удаленно' ? 'checked' : '' ?>
                                                       name="work-format" value="Удаленно"
                                                       class="rad viewcours_test-radio">
                                                <p class="create-resume-form_main-input-group-item-label-text">
                                                    Удаленно</p>
                                            </label>
                                        </li>
                                    </ul>
                                    <h4 class="create-resume-form_main-second-title">
                                        Уточните ваши зарплатные ожидания
                                    </h4>
                                    <div class="create-resume-form_main_row">
                                        <input value="<?= $resume['money-from'] ?>" placeholder="От" type="number"
                                               name="money-from"
                                               class="input-t create-resume-form_main_row-item">
                                        <input value="<?= $resume['money-to'] ?>" placeholder="До" type="number"
                                               name="money-to"
                                               class="input-t create-resume-form_main_row-item">
                                        <p class="create-resume-form_main_row-text">В месяц</p>
                                    </div>
                                    <div class="create-resume-form_main_btns">
                                        <button class="btn--purple btn--next" type="button">
                                            Далее ➜
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div class="create-resume-form_main_staps Stap2">
                                <div class="create-resume-form_main_container">
                                    <h2 class="create-resume-form_main-title">2. Портфолио</h2>
                                    <div class="portfolio__block">
                                        <?php if (!empty($resume['projects'])): ?>
                                            <?php foreach ($resume['projects'] as $k => $v): ?>
                                                <h4 class="create-resume-form_main-second-title">
                                                    Название проекта
                                                </h4>
                                                <input value="<?= $v['project-name'] ?>" placeholder="Название"
                                                       type="text" name="projects[<?= $k ?>][project-name]"
                                                       class="input-t create-resume-form-input-t">
                                                <h4 class="create-resume-form_main-second-title">
                                                    Ссылка на проект
                                                </h4>
                                                <input value="<?= $v['project-link'] ?>" placeholder="Ссылка на проект"
                                                       type="text"
                                                       name="projects[<?= $k ?>][project-link]"
                                                       class="input-t create-resume-form-input-t">
                                                <h4 class="create-resume-form_main-second-title">
                                                    Описание проекта
                                                </h4>
                                                <textarea placeholder="Расскажите о проекте более подробно"
                                                          class="input-t create-resume-form-input-t"
                                                          name="projects[<?= $k ?>][project-discribe]" rows="10"
                                                          style="resize: none;"><?= $v['project-discribe'] ?></textarea>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <h4 class="create-resume-form_main-second-title">
                                                Название проекта
                                            </h4>
                                            <input placeholder="Название" type="text" name="projects[0][project-name]"
                                                   class="input-t create-resume-form-input-t">
                                            <h4 class="create-resume-form_main-second-title">
                                                Ссылка на проект
                                            </h4>
                                            <input placeholder="Ссылка на проект" type="text"
                                                   name="projects[0][project-link]"
                                                   class="input-t create-resume-form-input-t">
                                            <h4 class="create-resume-form_main-second-title">
                                                Описание проекта
                                            </h4>
                                            <textarea placeholder="Расскажите о проекте более подробно"
                                                      class="input-t create-resume-form-input-t"
                                                      name="projects[0][project-discribe]" rows="10"
                                                      style="resize: none;"></textarea>
                                        <?php endif; ?>
                                    </div>
                                    <div class="create-resume-form_main_btns">
                                        <button class="btn--purple btn--next" type="button">
                                            Далее ➜
                                        </button>
                                        <button class="btn--purple add__project" type="button">
                                            Добавить проект +
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div class="create-resume-form_main_staps Stap3">
                                <div class="create-resume-form_main_container">
                                    <h2 class="create-resume-form_main-title">3. Опыт работы</h2>
                                    <div class="exp__work--block">
                                        <?php if (!empty($resume['experiences'])): ?>
                                            <?php foreach ($resume['experiences'] as $k => $v): ?>
                                                <h4 class="create-resume-form_main-second-title">
                                                    Период работы
                                                </h4>

                                                <div class="create-resume-form_main_row">
                                                    <select class="MyOrders_filter-selects"
                                                            name="experiences[<?= $k ?>][start-month]">
                                                        <option value="">Месяц начала работы</option>
                                                        <option <?= $v['start-month'] == '01' ? 'selected' : '' ?>
                                                                class="sendActive" value="01">Январь
                                                        </option>
                                                        <option <?= $v['start-month'] == '02' ? 'selected' : '' ?>
                                                                class="sendActive" value="02">Февраль
                                                        </option>
                                                        <option <?= $v['start-month'] == '03' ? 'selected' : '' ?>
                                                                class="sendActive" value="03">Март
                                                        </option>
                                                        <option <?= $v['start-month'] == '04' ? 'selected' : '' ?>
                                                                class="sendActive" value="04">Апрель
                                                        </option>
                                                        <option <?= $v['start-month'] == '05' ? 'selected' : '' ?>
                                                                class="sendActive" value="05">Май
                                                        </option>
                                                        <option <?= $v['start-month'] == '06' ? 'selected' : '' ?>
                                                                class="sendActive" value="06">Июнь
                                                        </option>
                                                        <option <?= $v['start-month'] == '07' ? 'selected' : '' ?>
                                                                class="sendActive" value="07">Июль
                                                        </option>
                                                        <option <?= $v['start-month'] == '08' ? 'selected' : '' ?>
                                                                class="sendActive" value="08">Август
                                                        </option>
                                                        <option <?= $v['start-month'] == '09' ? 'selected' : '' ?>
                                                                class="sendActive" value="09">Сентябрь
                                                        </option>
                                                        <option <?= $v['start-month'] == '10' ? 'selected' : '' ?>
                                                                class="sendActive" value="10">Октябрь
                                                        </option>
                                                        <option <?= $v['start-month'] == '11' ? 'selected' : '' ?>
                                                                class="sendActive" value="11">Ноябрь
                                                        </option>
                                                        <option <?= $v['start-month'] == '12' ? 'selected' : '' ?>
                                                                class="sendActive" value="12">Декабрь
                                                        </option>
                                                    </select>
                                                    <input value="<?= $v['year-start'] ?>" placeholder="Год" type="text"
                                                           name="experiences[<?= $k ?>][year-start]"
                                                           class="input-t"
                                                           style="max-width: 120px; margin: 0px;">
                                                    <p class="create-resume-form_main_row-text">В месяц</p>
                                                    <select class="MyOrders_filter-selects"
                                                            name="experiences[<?= $k ?>][end-month]">
                                                        <option value="" <?= empty($v['end-month']) ? 'selected' : '' ?>>
                                                            Месяц окончания
                                                        </option>
                                                        <option <?= $v['end-month'] == '01' ? 'selected' : '' ?>
                                                                class="sendActive" value="01">Январь
                                                        </option>
                                                        <option <?= $v['end-month'] == '02' ? 'selected' : '' ?>
                                                                class="sendActive" value="02">Февраль
                                                        </option>
                                                        <option <?= $v['end-month'] == '03' ? 'selected' : '' ?>
                                                                class="sendActive" value="03">Март
                                                        </option>
                                                        <option <?= $v['end-month'] == '04' ? 'selected' : '' ?>
                                                                class="sendActive" value="04">Апрель
                                                        </option>
                                                        <option <?= $v['end-month'] == '05' ? 'selected' : '' ?>
                                                                class="sendActive" value="05">Май
                                                        </option>
                                                        <option <?= $v['end-month'] == '06' ? 'selected' : '' ?>
                                                                class="sendActive" value="06">Июнь
                                                        </option>
                                                        <option <?= $v['end-month'] == '07' ? 'selected' : '' ?>
                                                                class="sendActive" value="07">Июль
                                                        </option>
                                                        <option <?= $v['end-month'] == '08' ? 'selected' : '' ?>
                                                                class="sendActive" value="08">Август
                                                        </option>
                                                        <option <?= $v['end-month'] == '09' ? 'selected' : '' ?>
                                                                class="sendActive" value="09">Сентябрь
                                                        </option>
                                                        <option <?= $v['end-month'] == '10' ? 'selected' : '' ?>
                                                                class="sendActive" value="10">Октябрь
                                                        </option>
                                                        <option <?= $v['end-month'] == '11' ? 'selected' : '' ?>
                                                                class="sendActive" value="11">Ноябрь
                                                        </option>
                                                        <option <?= $v['end-month'] == '12' ? 'selected' : '' ?>
                                                                class="sendActive" value="12">Декабрь
                                                        </option>
                                                    </select>
                                                    <input value="<?= $v['year-end'] ?>" placeholder="Год" type="text"
                                                           name="experiences[<?= $k ?>][year-end]"
                                                           class="input-t"
                                                           style="max-width: 120px; margin: 0px;">
                                                    <label class="create-resume-form_main-input-group-item-label">
                                                        <input <?= $v['exp'] == 'По настоящее время' ? 'checked' : '' ?>
                                                                type="checkbox" name="experiences[<?= $k ?>][exp]"
                                                                value="По настоящее время"
                                                                class="rad viewcours_test-radio">
                                                        <p class="create-resume-form_main-input-group-item-label-text">
                                                            По
                                                            настоящее
                                                            время</p>
                                                    </label>
                                                </div>
                                                <h4 class="create-resume-form_main-second-title">
                                                    Название организации
                                                </h4>
                                                <input value="<?= $v['organization-name'] ?>" placeholder="Название"
                                                       type="text" name="experiences[<?= $k ?>][organization-name]"
                                                       class="input-t create-resume-form-input-t">
                                                <h4 class="create-resume-form_main-second-title">
                                                    Должность
                                                </h4>
                                                <input value="<?= $v['position'] ?>" placeholder="Название" type="text"
                                                       name="experiences[<?= $k ?>][position]"
                                                       class="input-t create-resume-form-input-t">
                                                <h4 class="create-resume-form_main-second-title">
                                                    Обязанности, достижения
                                                </h4>
                                                <textarea placeholder="Расскажите о работе более подробно"
                                                          class="input-t create-resume-form-input-t"
                                                          name="experiences[<?= $k ?>][work-discribe]" rows="10"
                                                          style="resize: none;"><?= $v['work-discribe'] ?></textarea>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <h4 class="create-resume-form_main-second-title">
                                                Период работы
                                            </h4>
                                            <div class="create-resume-form_main_row">
                                                <select class="MyOrders_filter-selects"
                                                        name="experiences[0][start-month]">
                                                    <option selected disabled>Месяц начала работы</option>
                                                    <option class="sendActive" value="01">Январь</option>
                                                    <option class="sendActive" value="02">Февраль</option>
                                                    <option class="sendActive" value="03">Март</option>
                                                    <option class="sendActive" value="04">Апрель</option>
                                                    <option class="sendActive" value="05">Май</option>
                                                    <option class="sendActive" value="06">Июнь</option>
                                                    <option class="sendActive" value="07">Июль</option>
                                                    <option class="sendActive" value="08">Август</option>
                                                    <option class="sendActive" value="09">Сентябрь</option>
                                                    <option class="sendActive" value="10">Октябрь</option>
                                                    <option class="sendActive" value="11">Ноябрь</option>
                                                    <option class="sendActive" value="12">Декабрь</option>
                                                </select>
                                                <input placeholder="Год" type="text" name="experiences[0][year-start]"
                                                       class="input-t"
                                                       style="max-width: 120px; margin: 0px;">
                                                <p class="create-resume-form_main_row-text">В месяц</p>
                                                <select class="MyOrders_filter-selects"
                                                        name="experiences[0][end-month]">
                                                    <option selected disabled>Месяц окончания</option>
                                                    <option class="sendActive" value="01">Январь</option>
                                                    <option class="sendActive" value="02">Февраль</option>
                                                    <option class="sendActive" value="03">Март</option>
                                                    <option class="sendActive" value="04">Апрель</option>
                                                    <option class="sendActive" value="05">Май</option>
                                                    <option class="sendActive" value="06">Июнь</option>
                                                    <option class="sendActive" value="07">Июль</option>
                                                    <option class="sendActive" value="08">Август</option>
                                                    <option class="sendActive" value="09">Сентябрь</option>
                                                    <option class="sendActive" value="10">Октябрь</option>
                                                    <option class="sendActive" value="11">Ноябрь</option>
                                                    <option class="sendActive" value="12">Декабрь</option>
                                                </select>
                                                <input placeholder="Год" type="text" name="experiences[0][year-end]"
                                                       class="input-t"
                                                       style="max-width: 120px; margin: 0px;">
                                                <label class="create-resume-form_main-input-group-item-label">
                                                    <input type="checkbox" name="experiences[0][exp]"
                                                           value="По настоящее время"
                                                           class="rad viewcours_test-radio">
                                                    <p class="create-resume-form_main-input-group-item-label-text">По
                                                        настоящее
                                                        время</p>
                                                </label>
                                            </div>
                                            <h4 class="create-resume-form_main-second-title">
                                                Название организации
                                            </h4>
                                            <input placeholder="Название" type="text"
                                                   name="experiences[0][organization-name]"
                                                   class="input-t create-resume-form-input-t">
                                            <h4 class="create-resume-form_main-second-title">
                                                Должность
                                            </h4>
                                            <input placeholder="Название" type="text" name="experiences[0][position]"
                                                   class="input-t create-resume-form-input-t">
                                            <h4 class="create-resume-form_main-second-title">
                                                Обязанности, достижения
                                            </h4>
                                            <textarea placeholder="Расскажите о работе более подробно"
                                                      class="input-t create-resume-form-input-t"
                                                      name="experiences[0][work-discribe]" rows="10"
                                                      style="resize: none;"></textarea>
                                        <?php endif; ?>
                                    </div>

                                    <div class="create-resume-form_main_btns">
                                        <button class="btn--purple btn--next" type="button">
                                            Далее ➜
                                        </button>
                                        <button class="btn--purple add__exp-work" type="button">
                                            Добавить +
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div class="create-resume-form_main_staps Stap4">
                                <div class="create-resume-form_main_container">
                                    <h2 class="create-resume-form_main-title">4. Образование</h2>
                                    <div class="education__block">
                                        <?php if (!empty($resume['education'])): ?>
                                            <?php foreach ($resume['education'] as $k => $v): ?>
                                                <h4 class="create-resume-form_main-second-title">
                                                    Период обучения
                                                </h4>
                                                <div class="create-resume-form_main_row">
                                                    <select class="MyOrders_filter-selects"
                                                            name="education[<?= $k ?>][education-month-start]">
                                                        <option value="">Месяц начала обучения</option>
                                                        <option <?= $v['education-month-start'] == '01' ? 'selected' : '' ?>
                                                                class="sendActive" value="01">Январь
                                                        </option>
                                                        <option <?= $v['education-month-start'] == '02' ? 'selected' : '' ?>
                                                                class="sendActive" value="02">Февраль
                                                        </option>
                                                        <option <?= $v['education-month-start'] == '03' ? 'selected' : '' ?>
                                                                class="sendActive" value="03">Март
                                                        </option>
                                                        <option <?= $v['education-month-start'] == '04' ? 'selected' : '' ?>
                                                                class="sendActive" value="04">Апрель
                                                        </option>
                                                        <option <?= $v['education-month-start'] == '05' ? 'selected' : '' ?>
                                                                class="sendActive" value="05">Май
                                                        </option>
                                                        <option <?= $v['education-month-start'] == '06' ? 'selected' : '' ?>
                                                                class="sendActive" value="06">Июнь
                                                        </option>
                                                        <option <?= $v['education-month-start'] == '07' ? 'selected' : '' ?>
                                                                class="sendActive" value="07">Июль
                                                        </option>
                                                        <option <?= $v['education-month-start'] == '08' ? 'selected' : '' ?>
                                                                class="sendActive" value="08">Август
                                                        </option>
                                                        <option <?= $v['education-month-start'] == '09' ? 'selected' : '' ?>
                                                                class="sendActive" value="09">Сентябрь
                                                        </option>
                                                        <option <?= $v['education-month-start'] == '10' ? 'selected' : '' ?>
                                                                class="sendActive" value="10">Октябрь
                                                        </option>
                                                        <option <?= $v['education-month-start'] == '11' ? 'selected' : '' ?>
                                                                class="sendActive" value="11">Ноябрь
                                                        </option>
                                                        <option <?= $v['education-month-start'] == '12' ? 'selected' : '' ?>
                                                                class="sendActive" value="12">Декабрь
                                                        </option>
                                                    </select>
                                                    <input value="<?= $v['education-year-start'] ?>" placeholder="Год"
                                                           type="text" name="education[<?= $k ?>][education-year-start]"
                                                           class="input-t"
                                                           style="max-width: 120px; margin: 0px;">
                                                    <p class="create-resume-form_main_row-text">В месяц</p>
                                                    <select class="MyOrders_filter-selects"
                                                            name="education[<?= $k ?>][education-month-end]">
                                                        <option <?= empty($v['education-month-end']) ? 'selected' : '' ?>
                                                                value="">Месяц окончания
                                                        </option>
                                                        <option <?= $v['education-month-end'] == '01' ? 'selected' : '' ?>
                                                                class="sendActive" value="01">Январь
                                                        </option>
                                                        <option <?= $v['education-month-end'] == '02' ? 'selected' : '' ?>
                                                                class="sendActive" value="02">Февраль
                                                        </option>
                                                        <option <?= $v['education-month-end'] == '03' ? 'selected' : '' ?>
                                                                class="sendActive" value="03">Март
                                                        </option>
                                                        <option <?= $v['education-month-end'] == '04' ? 'selected' : '' ?>
                                                                class="sendActive" value="04">Апрель
                                                        </option>
                                                        <option <?= $v['education-month-end'] == '05' ? 'selected' : '' ?>
                                                                class="sendActive" value="05">Май
                                                        </option>
                                                        <option <?= $v['education-month-end'] == '06' ? 'selected' : '' ?>
                                                                class="sendActive" value="06">Июнь
                                                        </option>
                                                        <option <?= $v['education-month-end'] == '07' ? 'selected' : '' ?>
                                                                class="sendActive" value="07">Июль
                                                        </option>
                                                        <option <?= $v['education-month-end'] == '08' ? 'selected' : '' ?>
                                                                class="sendActive" value="08">Август
                                                        </option>
                                                        <option <?= $v['education-month-end'] == '09' ? 'selected' : '' ?>
                                                                class="sendActive" value="09">Сентябрь
                                                        </option>
                                                        <option <?= $v['education-month-end'] == '10' ? 'selected' : '' ?>
                                                                class="sendActive" value="10">Октябрь
                                                        </option>
                                                        <option <?= $v['education-month-end'] == '11' ? 'selected' : '' ?>
                                                                class="sendActive" value="11">Ноябрь
                                                        </option>
                                                        <option <?= $v['education-month-end'] == '12' ? 'selected' : '' ?>
                                                                class="sendActive" value="12">Декабрь
                                                        </option>
                                                    </select>
                                                    <input value="<?= $v['education-year-end'] ?>" placeholder="Год"
                                                           type="text" name="education[<?= $k ?>][education-year-end]"
                                                           class="input-t"
                                                           style="max-width: 120px; margin: 0px;">
                                                    <label class="create-resume-form_main-input-group-item-label">
                                                        <input <?= $v['education-exp'] == 'По настоящее время' ? 'checked' : '' ?>
                                                                type="checkbox"
                                                                name="education[<?= $k ?>][education-exp]"
                                                                value="По настоящее время"
                                                                class="rad viewcours_test-radio">
                                                        <p class="create-resume-form_main-input-group-item-label-text">
                                                            По
                                                            настоящее
                                                            время</p>
                                                    </label>
                                                </div>
                                                <h4 class="create-resume-form_main-second-title">
                                                    Название учебного заведения
                                                </h4>
                                                <input value="<?= $v['education-name'] ?>" placeholder="Название"
                                                       type="text" name="education[<?= $k ?>][education-name]"
                                                       class="input-t create-resume-form-input-t">
                                                <h4 class="create-resume-form_main-second-title">
                                                    Факультет, специализация
                                                </h4>
                                                <input value="<?= $v['education-faculty'] ?>" placeholder="Название"
                                                       type="text" name="education[<?= $k ?>][education-faculty]"
                                                       class="input-t create-resume-form-input-t">
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <h4 class="create-resume-form_main-second-title">
                                                Период обучения
                                            </h4>
                                            <div class="create-resume-form_main_row">
                                                <select class="MyOrders_filter-selects"
                                                        name="education[0][education-month-start]">
                                                    <option selected disabled>Месяц начала обучения</option>
                                                    <option class="sendActive" value="01">Январь</option>
                                                    <option class="sendActive" value="02">Февраль</option>
                                                    <option class="sendActive" value="03">Март</option>
                                                    <option class="sendActive" value="04">Апрель</option>
                                                    <option class="sendActive" value="05">Май</option>
                                                    <option class="sendActive" value="06">Июнь</option>
                                                    <option class="sendActive" value="07">Июль</option>
                                                    <option class="sendActive" value="08">Август</option>
                                                    <option class="sendActive" value="09">Сентябрь</option>
                                                    <option class="sendActive" value="10">Октябрь</option>
                                                    <option class="sendActive" value="11">Ноябрь</option>
                                                    <option class="sendActive" value="12">Декабрь</option>
                                                </select>
                                                <input placeholder="Год" type="text"
                                                       name="education[0][education-year-start]"
                                                       class="input-t"
                                                       style="max-width: 120px; margin: 0px;">
                                                <p class="create-resume-form_main_row-text">В месяц</p>
                                                <select class="MyOrders_filter-selects"
                                                        name="education[0][education-month-end]">
                                                    <option selected disabled>Месяц окончания</option>
                                                    <option class="sendActive" value="01">Январь</option>
                                                    <option class="sendActive" value="02">Февраль</option>
                                                    <option class="sendActive" value="03">Март</option>
                                                    <option class="sendActive" value="04">Апрель</option>
                                                    <option class="sendActive" value="05">Май</option>
                                                    <option class="sendActive" value="06">Июнь</option>
                                                    <option class="sendActive" value="07">Июль</option>
                                                    <option class="sendActive" value="08">Август</option>
                                                    <option class="sendActive" value="09">Сентябрь</option>
                                                    <option class="sendActive" value="10">Октябрь</option>
                                                    <option class="sendActive" value="11">Ноябрь</option>
                                                    <option class="sendActive" value="12">Декабрь</option>
                                                </select>
                                                <input placeholder="Год" type="text"
                                                       name="education[0][education-year-end]"
                                                       class="input-t"
                                                       style="max-width: 120px; margin: 0px;">
                                                <label class="create-resume-form_main-input-group-item-label">
                                                    <input type="checkbox" name="education[0][education-exp]"
                                                           value="По настоящее время"
                                                           class="rad viewcours_test-radio">
                                                    <p class="create-resume-form_main-input-group-item-label-text">По
                                                        настоящее
                                                        время</p>
                                                </label>
                                            </div>
                                            <h4 class="create-resume-form_main-second-title">
                                                Название учебного заведения
                                            </h4>
                                            <input placeholder="Название" type="text"
                                                   name="education[0][education-name]"
                                                   class="input-t create-resume-form-input-t">
                                            <h4 class="create-resume-form_main-second-title">
                                                Факультет, специализация
                                            </h4>
                                            <input placeholder="Название" type="text"
                                                   name="education[0][education-faculty]"
                                                   class="input-t create-resume-form-input-t">
                                        <?php endif; ?>
                                    </div>

                                    <div class="create-resume-form_main_btns">
                                        <button class="btn--purple btn--next" type="button">
                                            Далее ➜
                                        </button>
                                        <button class="btn--purple add_education" type="button">
                                            Добавить +
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div class="create-resume-form_main_staps Stap5">
                                <div class="create-resume-form_main_container">
                                    <h2 class="create-resume-form_main-title">5. О себе</h2>
                                    <h4 class="create-resume-form_main-second-title">
                                        Укажите ваш возраст
                                    </h4>
                                    <input value="<?= $resume['old'] ?>" type="number" name="old"
                                           class="input-t create-resume-form-input-t">
                                    <h4 class="create-resume-form_main-second-title">
                                        Расскажите о своих интересах
                                    </h4>
                                    <textarea placeholder="Напишите более подробно"
                                              class="input-t create-resume-form-input-t" name="discribe" rows="10"
                                              style="resize: none;"><?= $resume['discribe'] ?></textarea>

                                    <div class="create-resume-form_main_btns">
                                        <button class="btn--purple" type="submit">
                                            Обновить резюме
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>
                    <?= Html::endForm(); ?>
                </section>
                <section class="vebinar_notif-pop-back">
                    <div class="vebinar_notif-pop-wrap">
                        <div class="vebinar_notif-pop">
                            <button class="pop-close"></button>

                            <img src="<?= Url::to('/img/skillclient/nice-done.svg') ?>" alt="angle">
                            <h3 class="vebinar_notif-pop-title">Резюме обновлено</h3>
                            <p class="vebinar_notif-pop-text">Ваше резюме успешно обновлено. Откликайтесь на вакансии и
                                сотрудничаете с нашими партнерами</p>
                            <button class="vebinar_notif-pop-btn btn--purple">Продолжить</button>
                        </div>
                    </div>
                </section>
                <section class="created-resume">
                    <div class="created-resume_container">
                        <div class="created-resume_top">
                            <div class="created-resume_top_left">
                                <h2 class="created-resume_top_left-name"><?= $client['i'] ?> <?= $client['f'] ?></h2>
                            </div>
                            <div class="created-resume_top_right">
                                <div class="created-resume_top_right_top">
                                    <?php if (!empty($client['email'])): ?>
                                        <p class="created-resume_top_right-text"><?= $client['email'] ?></p>
                                    <?php endif; ?>
                                    <p class="created-resume_top_right-text"><?= $user_phone['username'] ?></p>
                                </div>
                                <p class="created-resume_top_right-text"><?= $resume['city'] ?></p>
                            </div>
                        </div>
                        <div class="created-resume-group">
                            <h3 class="created-resume-subtitle">
                                Пожелания к работе
                            </h3>
                            <div class="created-resume-row">
                                <?php if (!empty($resume['employment-type'])): ?>
                                    <p class="created-resume-row-text"><?= $resume['employment-type'] ?></p>
                                <?php endif; ?>
                                <?php if (!empty($resume['work-format'])): ?>
                                    <p class="created-resume-row-text"><?= $resume['work-format'] ?></p>
                                <?php endif; ?>
                            </div>
                            <?php if (!empty($resume['money-from']) && !empty($resume['money-to'])): ?>
                                <h4 class="created-resume-sub-subtitle">Зарплатные ожидания</h4>
                                <div class="created-resume-row">
                                    <p class="created-resume-row-text"><?= number_format($resume['money-from'], 0, '', ' ') ?>
                                        - <?= number_format($resume['money-to'], 0, '', ' ') ?> в месяц</p>
                                </div>
                            <?php endif; ?>
                        </div>
                        <?php if (!empty($resume['experiences'])): ?>
                            <div class="created-resume-group">
                                <h3 class="created-resume-subtitle">
                                    Опыт работы
                                </h3>
                                <?php foreach ($resume['experiences'] as $k => $v): ?>
                                    <div class="created-resume-group-row">
                                        <h4 class="created-resume-group-row-title"><?= $v['organization-name'] ?></h4>
                                    </div>
                                    <div class="created-resume-row">
                                        <p class="created-resume-row-text">с <?= $v['start-month'] ?>
                                            .<?= $v['year-start'] ?></p>
                                        <p class="created-resume-row-text">
                                            по <?= !empty($v['exp']) ? $v['exp'] : "{$v['end-month']}.{$v['year-end']}" ?></p>
                                    </div>
                                    <h5 class="created-resume-subtitle-2"><?= $v['position'] ?></h5>
                                    <p class="created-resume-text"><?= $v['work-discribe'] ?></p>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                        <?php if (!empty($resume['projects'])): ?>
                            <div class="created-resume-group">
                                <h3 class="created-resume-subtitle">
                                    Портфолио
                                </h3>
                                <?php foreach ($resume['projects'] as $k => $v): ?>
                                    <div class="created-resume-group-row">
                                        <h4 class="created-resume-group-row-title"><?= $v['project-name'] ?></h4>
                                        <p class="created-resume-group-row-link"><?= $v['project-link'] ?></p>
                                    </div>
                                    <p class="created-resume-text"><?= $v['project-discribe'] ?></p>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                        <?php if (!empty($resume['education'])): ?>
                            <div class="created-resume-group">
                                <h3 class="created-resume-subtitle">
                                    Образование
                                </h3>
                                <?php foreach ($resume['education'] as $k => $v): ?>
                                    <div class="created-resume-group-row">
                                        <h4 class="created-resume-group-row-title"><?= $v['education-name'] ?></h4>
                                    </div>
                                    <div class="created-resume-row">
                                        <p class="created-resume-row-text">с <?= $v['education-month-start'] ?>
                                            .<?= $v['education-year-start'] ?></p>
                                        <p class="created-resume-row-text">
                                            по <?= !empty($v['education-exp']) ? $v['education-exp'] : "{$v['education-month-end']}.{$v['education-year-end']}" ?></p>
                                    </div>
                                    <h5 class="created-resume-subtitle-2"><?= $v['education-faculty'] ?></h5>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                        <div class="created-resume-group">
                            <h3 class="created-resume-subtitle">
                                О себе
                            </h3>
                            <div class="created-resume-row">
                                <p class="created-resume-row-text"><?= $resume['old'] ?> лет</p>
                            </div>
                            <h5 class="created-resume-subtitle-2"><?= $resume['discribe'] ?></h5>
                        </div>
                        <div class="create-resume-form_main_btns">
                            <button class="btn--purple get_resume">
                                Скачать резюме
                            </button>
                            <button style="text-decoration: none;" class="link--purple reload__resume" type="button">
                                Редактировать
                            </button>
                            <a href="" download="" class="my_resume"></a>
                        </div>
                    </div>
                </section>
            <?php endif; ?>
        </article>
        <?php if (!empty($myResume)): ?>
            <article class="career-pages vacancies">
                <div class="career-pages_container">
                    <nav class="vacancies_filter">
                        <?= Html::beginForm('', '', ['class' => 'vacancies-filter']) ?>
                        <div class="vacancies_filter_container">
                            <a class="MyOrders_filter-reset"
                               type="reset"></a>
                            <!--                            <select style="max-width: 150px" class="MyOrders_filter-selects" name="sphere">-->
                            <!--                                <option selected disabled>Сфера</option>-->
                            <!--                                <option class="sendActive" value="1">1</option>-->
                            <!--                            </select>-->
                            <?php if (!empty($city)): ?>
                                <select style="max-width: 150px" class="MyOrders_filter-selects" name="city">
                                    <option selected disabled>Город</option>
                                    <?php foreach ($city as $k => $v): ?>
                                        <option class="sendActive" value="<?= $v['city'] ?>"><?= $v['city'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            <?php endif; ?>
                            <?php if (!empty($type)): ?>
                                <select style="max-width: 150px" class="MyOrders_filter-selects" name="type">
                                    <option selected disabled>Тип занятости</option>
                                    <?php foreach ($type as $k => $v): ?>
                                        <option class="sendActive"
                                                value="<?= $v['type_employment'] ?>"><?= $v['type_employment'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            <?php endif; ?>
                            <?php if (!empty($format)): ?>
                                <select style="max-width: 150px" class="MyOrders_filter-selects" name="format">
                                    <option selected disabled>Формат работы</option>
                                    <?php foreach ($format as $k => $v): ?>
                                        <option class="sendActive"
                                                value="<?= $v['work_format'] ?>"><?= $v['work_format'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            <?php endif; ?>
                        </div>
                        <?= Html::endForm(); ?>
                    </nav>

                    <?php Pjax::begin(['id' => 'JobCont']) ?>
                        <?php if (!empty($job)): ?>
                            <ul class="vacancies_list">
                                <?php foreach ($job as $k => $v): ?>
                                    <li class="vacancies_list-item">
                                        <div class="vacancies_list-item_left">
                                            <h2 class="vacancies_list-item-title"><?= $v['position'] ?></h2>
                                            <p class="vacancies_list-item_left-text"><?= $v['company_name'] ?></p>
                                            <div class="create-resume-form_main_btns">
                                                <button class="btn--purple vacancy-reply"
                                                   data-id="<?= $v['id'] ?>">Откликнуться</button>
                                                <a href="<?= Url::to(['vacancypage', 'id' => $v['id']]) ?>"
                                                   style="text-decoration: none;" class="link--purple">Подробнее о
                                                    вакансии</a>
                                            </div>
                                        </div>
                                        <div class="vacancies_list-item_right">
                                            <h3 class="vacancies_list-item_right-title"><?= $v['payment'] ?>₽</h3>
                                            <p class="vacancies_list-item_right-city"><?= $v['city'] ?></p>
                                            <p class="vacancies_list-item_right-date"><?= date('d.m.Y', strtotime($v['date'])) ?></p>
                                        </div>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        <?php endif; ?>
                    <?php Pjax::end() ?>
                </div>
            </article>
            <?php if (!empty($responses)): ?>
                <article class="career-pages reviews">
                    <ul class="vacancies_list">
                        <?php foreach ($responses as $k => $v): ?>
                            <li class="vacancies_list-item">
                                <div class="vacancies_list-item_left">
                                    <h2 class="vacancies_list-item-title"><?= $v['position'] ?></h2>
                                    <p class="vacancies_list-item_left-text"><?= $v['company_name'] ?></p>
                                    <div class="create-resume-form_main_btns">
                                        <a href="<?= Url::to(['vacancypage', 'id' => $v['id']]) ?>"
                                           style="text-decoration: none;"
                                           class="link--purple"
                                           type="button">Подробнее о вакансии</a>
                                    </div>
                                </div>
                                <div class="vacancies_list-item_right">
                                    <h3 class="vacancies_list-item_right-title"><?= $v['payment'] ?>₽</h3>
                                    <p class="vacancies_list-item_right-city"><?= $v['city'] ?></p>
                                    <p class="vacancies_list-item_right-date"><?= date('d.m.Y', strtotime($v['date'])) ?></p>
                                </div>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </article>
            <?php endif; ?>
        <?php endif; ?>
    <?php endif; ?>
</section>