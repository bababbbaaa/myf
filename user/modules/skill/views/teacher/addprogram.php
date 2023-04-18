<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\jui\DatePicker;
use yii\widgets\Pjax;

$this->title = 'Добавить программу';

$js = <<< JS

JS;
$this->registerJs($js);
$this->registerJsFile(Url::to('js/skill-force/addProgram.js'), ['depends' => [\yii\web\JqueryAsset::class], 'type' => 'module']);
$css = <<< CSS
.selectCategory.danger{
    border-color: red;
}
.categoryBlock{
    position: relative;
    width: 100%;
}
.selectCategory{
    width: 100%;
    padding: 10px;
    border: 1px solid #cbd0e8;
    box-sizing: border-box;
    border-radius: 8px;
    font-size: 18px;
    font-weight: 500;
    cursor: pointer;
}
.itemsCategory{
    position: absolute;
    top: 45px;
    width: 100%;
    background-color: white;
    max-height: 200px;
    overflow-y: auto;
    left: 0;
    margin-top: 5px;
    display: flex;
    flex-direction: column;
    border: 1px solid #cbd0e8;
}
.itemCategory{
    padding: 10px;
    font-size: 16px;
    cursor: pointer;
    border-bottom: 1px solid #cbd0e8;
}
.categoryInput:checked + .itemCategory, .itemCategory:hover{
    background-color: #cbd0e8;
}
[hidden]{
    display: none;
}
.customLabel{
    display: flex;
    flex-direction: column;
    row-gap: 10px;
}
CSS;
$this->registerCss($css);
?>

<section class="rightInfo education">
  <div class="bcr">
    <ul class="bcr__list">
      <li class="bcr__item">
                <span class="bcr__span">
                Добавить программу
                </span>
      </li>
    </ul>
  </div>
  <div class="title_row">
    <h1 class="Bal-ttl title-main">Добавить программу</h1>
    <a href="<?= Url::to(['manualaddprogram']) ?>" class="link--purple">Как добавить программу?</a>
  </div>
  <section class="addprogram_first">
    <h2 class="addprogram-subtitle">Выберите тип программы, которую хотите загрузить</h2>
    <ul class="addprogram_first-type">
      <li style="max-width: 220px;" class="addprogram_first-type-item">
        <button class="courses_item_top-name addprogram_first-type-item-btn course">Добавить программу</button>
      </li>
    </ul>

    <ul class="addprogram_first_isnt-upload-list">
      <li class="addprogram_first_isnt-upload-list-item">
        <div class="addprogram_first_isnt-upload-list-item-top">
          <h3 class="addprogram_first_isnt-upload-list-item-title">Менеджер первичного контакта</h3>
          <p class="addprogram_first_isnt-upload-list-item-type">курс</p>
        </div>
        <ul class="addprogram_first_isnt-upload-list-item_list">
          <li class="addprogram_first_isnt-upload-list-item_list-item">
            <p class="addprogram_first_isnt-upload-list-item_list-item-stage">О курсе</p>
            <p class="addprogram_first_isnt-upload-list-item_list-item-stage-value">100%</p>
          </li>
          <li class="addprogram_first_isnt-upload-list-item_list-item">
            <p class="addprogram_first_isnt-upload-list-item_list-item-stage">Об авторе</p>
            <p class="addprogram_first_isnt-upload-list-item_list-item-stage-value">100%</p>
          </li>
          <li class="addprogram_first_isnt-upload-list-item_list-item">
            <p class="addprogram_first_isnt-upload-list-item_list-item-stage">Программа курса</p>
            <p class="addprogram_first_isnt-upload-list-item_list-item-stage-value orange">в работе</p>
          </li>
        </ul>
        <ul class="addprogram_first_isnt-upload-list-item_list">
          <li class="addprogram_first_isnt-upload-list-item_list-item">
            <p class="addprogram_first_isnt-upload-list-item_list-item-stage">Оценка заданий</p>
            <p class="addprogram_first_isnt-upload-list-item_list-item-stage-value none">не заполнено</p>
          </li>
          <li class="addprogram_first_isnt-upload-list-item_list-item">
            <p class="addprogram_first_isnt-upload-list-item_list-item-stage">Проверка заданий</p>
            <p class="addprogram_first_isnt-upload-list-item_list-item-stage-value none">не заполнено</p>
          </li>
          <li class="addprogram_first_isnt-upload-list-item_list-item">
            <p class="addprogram_first_isnt-upload-list-item_list-item-stage">Доступ к курсу</p>
            <p class="addprogram_first_isnt-upload-list-item_list-item-stage-value none">не заполнено</p>
          </li>
        </ul>
        <div class="addprogram_first_isnt-upload-list-item_btns">
          <button class="btn--purple addprogram_first_isnt-upload-list-item_btn-continue">
            Продолжить загрузку программы
          </button>
          <button class="addprogram_first_isnt-upload-list-item_btn-delete">Удалить проект</button>
        </div>
      </li>
    </ul>
  </section>

  <section class="addprogram_anket addprogram_anket-course">
    <div class="create-resume-form_container">
      <div class="create-resume-form_left">
        <div class="create-resume-form_left">
          <div class="create-resume-form_left-line"></div>

          <ul class="create-resume-form_left-list">
            <li class="create-resume-form_left-list-item active">
              <div class="create-resume-form_left-list-item-indicator active">1</div>
              <p class="create-resume-form_left-list-item-text">Категории</p>
            </li>
            <li class="create-resume-form_left-list-item">
              <div class="create-resume-form_left-list-item-indicator">2</div>
              <p class="create-resume-form_left-list-item-text">Авторы и препод.</p>
            </li>
            <li class="create-resume-form_left-list-item">
              <div class="create-resume-form_left-list-item-indicator">3</div>
              <p class="create-resume-form_left-list-item-text">Курсы</p>
            </li>
            <li class="create-resume-form_left-list-item create-course">
              <div class="create-resume-form_left-list-item-indicator">4</div>
              <div class="create-course_modules">
                <p class="create-resume-form_left-list-item-text">Программа курса</p>
                <ul class="create-course_modules-group">
                  <div class="addprogram_anket-course_lessons-item-main"><p
                      class="addprogram_anket-course_lessons-item-main-name-lesson">Модуль
                      1</p>
                    <div class="addprogram_anket-course_lessons-item-main-icons">
                      <svg width="18" height="18" viewBox="0 0 18 18" fill="none"
                           xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                              d="M18 9C18 13.9706 13.9706 18 9 18C4.02944 18 0 13.9706 0 9C0 4.02944 4.02944 0 9 0C13.9706 0 18 4.02944 18 9ZM1.38477 9.00033C1.38477 13.2062 4.79429 16.6157 9.00015 16.6157C13.206 16.6157 16.6155 13.2062 16.6155 9.00033C16.6155 4.79447 13.206 1.38495 9.00015 1.38495C4.79429 1.38495 1.38477 4.79447 1.38477 9.00033Z"
                              fill="#2CCD65"/>
                        <path
                          d="M5.25184 8.88472C4.99206 8.58244 4.54081 8.55181 4.24392 8.81631C3.94704 9.0808 3.91696 9.54027 4.17673 9.84255L6.67673 12.7516C6.95415 13.0745 7.44431 13.0839 7.73358 12.7721L13.805 6.22664C14.0759 5.93462 14.063 5.47433 13.7762 5.19854C13.4894 4.92275 13.0373 4.9359 12.7664 5.22791L7.23446 11.1918L5.25184 8.88472Z"
                          fill="#2CCD65"/>
                      </svg>
                      <button type="button"
                              class="addprogram_anket-course_lessons-item-main-icons-btn btn--module-teory-change">
                        <svg width="18" height="18" viewBox="0 0 18 18" fill="none"
                             xmlns="http://www.w3.org/2000/svg">
                          <path d="M2.625 15.75H16.125" stroke="#A5AABE" stroke-width="1.5"
                                stroke-linecap="round" stroke-linejoin="round"/>
                          <path d="M4.125 10.02V12.75H6.86895L14.625 4.99054L11.8857 2.25L4.125 10.02Z"
                                stroke="#A5AABE" stroke-width="1.5" stroke-linejoin="round"/>
                        </svg>
                      </button>
                      <button type="button"
                              class="addprogram_anket-course_lessons-item-main-icons-btn btn--module-teory-delete">
                        <svg width="18" height="18" viewBox="0 0 18 18" fill="none"
                             xmlns="http://www.w3.org/2000/svg">
                          <path
                            d="M13.0801 6.00026L4.92035 6.00004L4.49536 6.00003C3.89825 6.00001 3.4342 6.51989 3.50175 7.11317L4.34259 14.4975C4.40377 15.0504 4.66757 15.561 5.08308 15.9308C5.49859 16.3006 6.03636 16.5034 6.59259 16.5H11.4076C11.9638 16.5034 12.5016 16.3006 12.9171 15.9308C13.3326 15.561 13.5964 15.0504 13.6576 14.4975L14.4983 7.11331C14.5658 6.51998 14.1017 6.00009 13.5045 6.00019L13.0801 6.00026ZM12.1501 14.3325C12.1297 14.5168 12.0418 14.687 11.9033 14.8103C11.7648 14.9336 11.5855 15.0012 11.4001 15H6.59259C6.40718 15.0012 6.22793 14.9336 6.08942 14.8103C5.95092 14.687 5.86299 14.5168 5.84259 14.3325L5.08509 7.50004H12.9151L12.1501 14.3325ZM10.5001 13.5C10.699 13.5 10.8898 13.421 11.0304 13.2804C11.1711 13.1397 11.2501 12.949 11.2501 12.75V9.75004C11.2501 9.55113 11.1711 9.36036 11.0304 9.21971C10.8898 9.07906 10.699 9.00004 10.5001 9.00004C10.3012 9.00004 10.1104 9.07906 9.96977 9.21971C9.82911 9.36036 9.7501 9.55113 9.7501 9.75004V12.75C9.7501 12.949 9.82911 13.1397 9.96977 13.2804C10.1104 13.421 10.3012 13.5 10.5001 13.5ZM7.50009 13.5C7.69901 13.5 7.88977 13.421 8.03042 13.2804C8.17108 13.1397 8.25009 12.949 8.25009 12.75V9.75004C8.25009 9.55113 8.17108 9.36036 8.03042 9.21971C7.88977 9.07906 7.69901 9.00004 7.50009 9.00004C7.30118 9.00004 7.11042 9.07906 6.96976 9.21971C6.82911 9.36036 6.75009 9.55113 6.75009 9.75004V12.75C6.75009 12.949 6.82911 13.1397 6.96976 13.2804C7.11042 13.421 7.30118 13.5 7.50009 13.5Z"
                            fill="#A5AABE"/>
                          <rect x="2.625" y="4.125" width="12.75" height="0.75" rx="0.375"
                                stroke="#A5AABE" stroke-width="0.75"/>
                          <path d="M12 3.75V2.5C12 1.94772 11.5523 1.5 11 1.5H7C6.44772 1.5 6 1.94772 6 2.5V3.75"
                                stroke="#A5AABE" stroke-width="1.5"/>
                        </svg>
                      </button>
                    </div>
                  </div>
                </ul>
              </div>
            </li>
          </ul>
        </div>
        <!-- <button disabled class="addprogram_anket-save">Сохранить проект</button> -->
        <button style="margin-top: 20px;" disabled class="addprogram_anket-upload">Загрузить курс</button>
      </div>
      <section class="create-resume-form_main">
        <div class="create-resume-form_main_staps Stap1">
          <div class="create-resume-form_main_container">
            <?= Html::beginForm('', '', ['class' => 'addprogram_anket-course-form-1', 'id' => 'addprogram_anket-course-form-1']) ?>
            <h2 class="create-resume-form_main-title">1. Категории</h2>
            <h4 class="create-resume-form_main-second-title">
              Выберите категорию
            </h4>
            <div class="create-resume-form_main_row">
              <div class="categoryBlock">
                <div class="selectCategory">
                  Выберите категорию
                </div>
                <div hidden class="itemsCategory">
                  <?php if (!empty($category)): ?>
                    <?php foreach ($category as $k => $v): ?>
                      <input class="categoryInput" style="display: none" type="radio" name="category"
                             value="<?= $v['id'] ?>" id="<?= $k ?>" data-name="<?= $v['name'] ?>">
                      <label class="itemCategory" for="<?= $k ?>"><?= $v['name'] ?></label>

                    <?php endforeach; ?>
                  <?php endif; ?>
                </div>
                <button type="button" class="btn--show-own-wey">Нет подходящего</button>
              </div>
              <div id="addNewCategory" hidden>
                <p class="bown-wey-text">Введите ваше направление</p>
                <input placeholder="Кредитование" type="text" id="catToLink" name="category-name"
                       class="input-t own-wey-input textToLink">
                <input type="hidden" name="category-link" id="linkCat">
                <button style="max-width: fit-content; display:none;" class="btn--purple save-category">
                  Добавить категорию
                </button>
              </div>
            </div>
            <?= Html::endForm(); ?>
            <div class="create-resume-form_main_btns">
              <button class="btn--purple btn--next" type="button">
                Далее ➜
              </button>
            </div>
          </div>
        </div>
        <div class="create-resume-form_main_staps Stap2">
          <div class="create-resume-form_main_container">
            <?= Html::beginForm('', '', ['class' => 'addprogram_anket-course-form-2', 'id' => 'addprogram_anket-course-form-2']) ?>
            <h2 class="create-resume-form_main-title">2. Авторы и преподаватели</h2>
            <label class="create-resume-form_main-second-title customLabel">
              ФИО Автора
              <input required
                     style="margin-bottom: 12px;"
                     placeholder="Иванов Иван Иванович"
                     type="text"
                     name="author_fio"
                     class="input-t create-resume-form-input-t textToLink"
              >
              <input type="hidden" name="author_link">
            </label>

            <h4 class="create-resume-form_main-second-title">
              Добавьте ваше фото
            </h4>
            <div class="input__wrapper fileWrapper">
              <label class="input__file-button">
                <input
                  name="photo"
                  type="file"
                  class="input input__file"
                >
                <span class="input__file-button-text">Загрузить</span>
              </label>
            </div>

            <label class="create-resume-form_main-second-title customLabel">
              Краткое описание
              <input
                required
                style="margin-bottom: 12px;"
                placeholder="Генеральный директор ООО ФИРМА, руководитель образовательных программ"
                type="text"
                name="smal_desc" class="input-t create-resume-form-input-t"
              >
            </label>

            <label class="create-resume-form_main-second-title customLabel">
              Ваш опыт
              <input
                required
                style="margin-bottom: 12px;"
                placeholder="На пример: 5 лет"
                type="number"
                name="author_exp" class="input-t create-resume-form-input-t"
              >
            </label>

            <label class="create-resume-form_main-second-title customLabel">
              Расскажите о себе вашим будущим студентам
              <textarea
                required
                placeholder="Не более 1 000 символов"
                maxlength="1000"
                name="author_about"
                class="input-t addprogram_anket-textarea-input"
              ></textarea>
            </label>

            <label class="create-resume-form_main-second-title customLabel">
              Ваша специализация (через запятую)
              <input
                required
                placeholder="Банкротство, Маркетинг, Менеджмент"
                name="author_spec"
                class="input-t create-resume-form-input-t"
              >
            </label>

            <button class="btn--add-prepod" type="button">Добавить преподавателя</button>
            <div class="add-prepod-group fileWrapper"></div>

            <?= Html::endForm(); ?>
            <div class="create-resume-form_main_btns">
              <button class="btn--purple btn--next" type="submit" form="addprogram_anket-course-form-2">
                Далее ➜
              </button>
            </div>
          </div>
        </div>
        <div class="create-resume-form_main_staps Stap3">
          <div class="create-resume-form_main_container">
            <h2 class="create-resume-form_main-title">3. Курсы</h2>
            <?= Html::beginForm('', '', ['class' => 'addprogram_anket-course-form-3', 'id' => 'addprogram_anket-course-form-3']) ?>
            <h4 class="create-resume-form_main-second-title">
              Название курса
            </h4>
            <input required id="textToLink" type="text" class="input-t textToLink" name="name"
                   placeholder="Первый миллион на БФЛ">
            <input id="linkText" type="hidden" name="link">
            <select required class="MyOrders_filter-select" name="programm-type">
              <option class="sendActive" value="Курс">Курс</option>
              <option class="sendActive" value="Вебинар">Вебинар</option>
              <option class="sendActive" value="Интенсив">Интенсив</option>
            </select>
            <h4 style="margin-top: 20px;" class="create-resume-form_main-second-title">
              Описание
            </h4>
            <textarea required placeholder="Не более 1 000 символов" maxlength="1000" name="describe"
                      class="input-t addprogram_anket-textarea-input"></textarea>
            <h4 class="create-resume-form_main-second-title">
              Уточните ваши ожидания по стоимости продукта
            </h4>
            <div class="create-resume-form_main_row">
              <input required placeholder="От" type="number" name="product-summ-moneyfrom"
                     class="input-t create-resume-form_main_row-item">
              <input required placeholder="До" type="number" name="product-summ-moneyto"
                     class="input-t create-resume-form_main_row-item">
            </div>
            <button style="margin-bottom: 28px;" type="button" class="link--purple popup-make-summ-learn">
              Узнать о ценообразовании
            </button>
            <h4 class="create-resume-form_main-second-title">
              Доступ к курсу
            </h4>
            <ul class="create-resume-form_main-input-group">
              <li class="create-resume-form_main-input-group-item">
                <label class="create-resume-form_main-input-group-item-label">
                  <input type="radio" checked name="access" value="Доступно всем пользователям"
                         class="rad viewcours_test-radio">
                  <p class="create-resume-form_main-input-group-item-label-text">Доступно всем
                    пользователям</p>
                </label>
              </li>
              <li class="create-resume-form_main-input-group-item">
                <label class="create-resume-form_main-input-group-item-label">
                  <input type="radio" name="access" value="Доступно по ссылке"
                         class="rad viewcours_test-radio">
                  <p class="create-resume-form_main-input-group-item-label-text">Доступно по
                    ссылке</p>
                </label>
              </li>
            </ul>
            <h4 class="create-resume-form_main-second-title">
              Сертификат о прохождении курса
            </h4>
            <div class="input__wrapper">
              <input name="sertificat" type="file" id="input__file" class="input input__file">
              <label for="input__file" class="input__file-button">
                <span class="input__file-button-text">Загрузить документ</span>
              </label>
            </div>

            <?= Html::endForm(); ?>

            <div class="create-resume-form_main_btns">
              <button class="btn--purple btn--next" type="submit" form="addprogram_anket-course-form-3">
                Далее ➜
              </button>
            </div>
          </div>
        </div>

        <div class="create-resume-form_main_staps Stap4">
          <div class="create-resume-form_main_container">
            <h2 class="create-resume-form_main-title">4. Программа курса</h2>

            <p class="addprogram-anket-stap-text">
              Курс состоит из тематических модулей.
              <br>
              Модули включают в себя теоритические и практические занятия.
              <br>
              Создайте модуль и наполните его занятиями нужного формата.
              <br>
              <span>Внимание!</span> Курс должен содержать не менее 5 занятий
            </p>
            <button type="button" class="addprogram-anket-create-module">
              <span>Создать модуль</span>
              <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                   xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" clip-rule="evenodd"
                      d="M9.79028 19C14.8759 19 18.9985 14.8773 18.9985 9.79175C18.9985 4.70617 14.8759 0.583496 9.79028 0.583496C4.70471 0.583496 0.582031 4.70617 0.582031 9.79175C0.582031 14.8773 4.70471 19 9.79028 19ZM9.7916 17.5832C5.48842 17.5832 2 14.0948 2 9.7916C2 5.48842 5.48842 2 9.7916 2C14.0948 2 17.5832 5.48842 17.5832 9.7916C17.5832 14.0948 14.0948 17.5832 9.7916 17.5832ZM8.84594 6.95844V9.08342H6.72096C6.32976 9.08342 6.01263 9.40055 6.01263 9.79175C6.01263 10.1829 6.32976 10.5001 6.72096 10.5001H8.84594V12.6251C8.84594 13.0163 9.16307 13.3334 9.55426 13.3334C9.94546 13.3334 10.2626 13.0163 10.2626 12.6251V10.5001H12.3876C12.7788 10.5001 13.0959 10.1829 13.0959 9.79175C13.0959 9.40055 12.7788 9.08342 12.3876 9.08342H10.2626V6.95844C10.2626 6.56724 9.94546 6.25011 9.55426 6.25011C9.16307 6.25011 8.84594 6.56724 8.84594 6.95844Z"
                      fill="#4135F1"/>
              </svg>
            </button>

            <div class="addprogram-anket-create-module-block">
              <?= Html::beginForm('', '', ['class' => 'addprogram_anket-course-form-4', 'id' => 'addprogram_anket-course-form-4']) ?>
              <input id="modToLink" style="margin-bottom: 24px;" required
                     placeholder="Введите название модуля" type="text" name="module-name"
                     class="input-module-name textToLink">
              <input id="linkMod" type="hidden" name="module-link">
              <div class="addprogram_anket-course_lessons"></div>
              <h4 class="create-resume-form_main-second-title">
                Выберите тип занятия:
              </h4>
              <div class="addprogram-anket-create-module-block_list-group">
                <button type="button" class="mycours-list-item_info-item btn--type-module teory">
                  <div class="mycours-list-item_info-item-bacground green">
                    <p>Теория <span><svg width="33" height="33" viewBox="0 0 33 33" fill="none"
                                         xmlns="http://www.w3.org/2000/svg"><path
                            d="M2.75 5.5H30.25" stroke="#5C687E" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round"/><path
                            fill-rule="evenodd" clip-rule="evenodd"
                            d="M6 8C6 6.89543 6.89543 6 8 6H26C27.1046 6 28 6.89543 28 8V21.875C28 22.9796 27.1046 23.875 26 23.875H8C6.89543 23.875 6 22.9796 6 21.875V8Z"
                            stroke="#5C687E" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round"/><path
                            d="M15.125 11L18.5625 14.4375L15.125 17.875"
                            stroke="#5C687E" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round"/><path
                            d="M11 29.875L16.5 24.375L22 29.875" stroke="#5C687E"
                            stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round"/></svg></span></p>
                  </div>
                </button>
                <button type="button" class="mycours-list-item_info-item btn--type-module practice">
                  <div class="mycours-list-item_info-item-bacground yellow">
                    <p>Практика <span><svg width="33" height="33" viewBox="0 0 33 33" fill="none"
                                           xmlns="http://www.w3.org/2000/svg"><path
                            d="M6.875 30.25C6.11561 30.25 5.5 29.6344 5.5 28.875V4.125C5.5 3.36561 6.11561 2.75 6.875 2.75H26.125C26.8844 2.75 27.5 3.36561 27.5 4.125V28.875C27.5 29.6344 26.8844 30.25 26.125 30.25H6.875Z"
                            stroke="#5C687E" stroke-width="2" stroke-linejoin="round"/><path
                            fill-rule="evenodd" clip-rule="evenodd"
                            d="M14.4375 15.125V2.75H22.6875V15.125L18.5625 10.8125L14.4375 15.125Z"
                            stroke="#5C687E" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round"/><path d="M6.875 2.75H26.125"
                                                           stroke="#5C687E"
                                                           stroke-width="2"
                                                           stroke-linecap="round"
                                                           stroke-linejoin="round"/></svg></span>
                    </p>
                  </div>
                </button>
                <button type="button" class="mycours-list-item_info-item btn--type-module test">
                  <div class="mycours-list-item_info-item-bacground blue">
                    <p>Тест <span><svg width="33" height="33" viewBox="0 0 33 33" fill="none"
                                       xmlns="http://www.w3.org/2000/svg"><path
                            d="M23.375 3.4375H5.5C4.36092 3.4375 3.4375 4.36092 3.4375 5.5V23.375C3.4375 24.5141 4.36092 25.4375 5.5 25.4375H23.375C24.5141 25.4375 25.4375 24.5141 25.4375 23.375V5.5C25.4375 4.36092 24.5141 3.4375 23.375 3.4375Z"
                            stroke="#5C687E" stroke-width="2" stroke-linejoin="round"/><path
                            d="M30.2475 8.93896V28.8752C30.2475 29.6345 29.6319 30.2502 28.8725 30.2502H8.9375"
                            stroke="#5C687E" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round"/><path
                            d="M8.9375 14.0837L13.0623 17.8822L19.9375 10.8066"
                            stroke="#5C687E" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round"/></svg></span></p>
                  </div>
                </button>
              </div>
              <div class="create-module-task teory">
                <h3 class="create-module-task-stt">Обязательно</h3>
                <h4 class="create-resume-form_main-second-title">Название урока:</h4>
                <input placeholder="Кредитование" type="text" name="lesson-name"
                       class="input-t create-resume-form-input-t lesson-input-req">
                <h4 class="create-resume-form_main-second-title">Описание:</h4>
                <input placeholder="Кредитование" type="text" name="lesson-describe"
                       class="input-t create-resume-form-input-t lesson-input-req">
                <h4 class="create-resume-form_main-second-title">Видеолекция</h4>
                <p class="create-resume-form_main-second-title-do-text">прикрепите ссылку на видео</p>
                <input placeholder="Cсылка на видео" type="text" name="video-link"
                       class="input-t create-resume-form-input-t">
                <h4 class="create-resume-form_main-second-title">Материалы к лекции <span>(инструкции, лекции, чек-листы и т.п.)</span>
                </h4>
                <input style="margin-bottom: 12px;" placeholder="Название документа" type="text"
                       name="document-to-lesson-name[]"
                       class="input-t create-resume-form-input-t lesson-input-req">
                <div class="input__wrapper">
                  <input name="document-to-lesson[]" type="file" id="input__file-3-2"
                         class="input input__file lesson-input-req">
                  <label for="input__file-3-2" class="input__file-button">
                    <span class="input__file-button-text">Загрузить документ</span>
                  </label>
                </div>
                <div class="add-doc-to-create-lesson"></div>
                <button type="button"
                        class="btn--prpl-w-plus addprogram-anket-create-module-add-document">
                  <span>Добавить материал</span>
                  <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                       xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd"
                          d="M9.79028 19C14.8759 19 18.9985 14.8773 18.9985 9.79175C18.9985 4.70617 14.8759 0.583496 9.79028 0.583496C4.70471 0.583496 0.582031 4.70617 0.582031 9.79175C0.582031 14.8773 4.70471 19 9.79028 19ZM9.7916 17.5832C5.48842 17.5832 2 14.0948 2 9.7916C2 5.48842 5.48842 2 9.7916 2C14.0948 2 17.5832 5.48842 17.5832 9.7916C17.5832 14.0948 14.0948 17.5832 9.7916 17.5832ZM8.84594 6.95844V9.08342H6.72096C6.32976 9.08342 6.01263 9.40055 6.01263 9.79175C6.01263 10.1829 6.32976 10.5001 6.72096 10.5001H8.84594V12.6251C8.84594 13.0163 9.16307 13.3334 9.55426 13.3334C9.94546 13.3334 10.2626 13.0163 10.2626 12.6251V10.5001H12.3876C12.7788 10.5001 13.0959 10.1829 13.0959 9.79175C13.0959 9.40055 12.7788 9.08342 12.3876 9.08342H10.2626V6.95844C10.2626 6.56724 9.94546 6.25011 9.55426 6.25011C9.16307 6.25011 8.84594 6.56724 8.84594 6.95844Z"
                          fill="#4135F1"/>
                  </svg>
                </button>
                <h3 class="create-module-task-stt">Дополнительно</h3>
                <h4 class="create-resume-form_main-second-title">Материалы для изучения <br> <span>(для дополнительного ознакомления)</span>
                </h4>
                <textarea placeholder="Введите текст" maxlength="1000" name="describe-doc-to-lesson"
                          class="input-t addprogram_anket-textarea-input"></textarea>
                <h4 class="create-resume-form_main-second-title">Дополнительные материалы к лекции</h4>
                <input style="margin-bottom: 12px;" placeholder="Название документа" type="text"
                       name="document-to-lesson-name-dop" class="input-t create-resume-form-input-t">
                <div class="input__wrapper">
                  <input name="document-to-lesson[]" type="file" id="input__file-3-3"
                         class="input input__file">
                  <label for="input__file-3-3" class="input__file-button">
                    <span class="input__file-button-text">Загрузить документ</span>
                  </label>
                </div>
                <div class="add-doc-to-create-lesson-dop"></div>
                <button type="button"
                        class="btn--prpl-w-plus addprogram-anket-create-module-add-document-dop">
                  <span>Добавить материал</span>
                  <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                       xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd"
                          d="M9.79028 19C14.8759 19 18.9985 14.8773 18.9985 9.79175C18.9985 4.70617 14.8759 0.583496 9.79028 0.583496C4.70471 0.583496 0.582031 4.70617 0.582031 9.79175C0.582031 14.8773 4.70471 19 9.79028 19ZM9.7916 17.5832C5.48842 17.5832 2 14.0948 2 9.7916C2 5.48842 5.48842 2 9.7916 2C14.0948 2 17.5832 5.48842 17.5832 9.7916C17.5832 14.0948 14.0948 17.5832 9.7916 17.5832ZM8.84594 6.95844V9.08342H6.72096C6.32976 9.08342 6.01263 9.40055 6.01263 9.79175C6.01263 10.1829 6.32976 10.5001 6.72096 10.5001H8.84594V12.6251C8.84594 13.0163 9.16307 13.3334 9.55426 13.3334C9.94546 13.3334 10.2626 13.0163 10.2626 12.6251V10.5001H12.3876C12.7788 10.5001 13.0959 10.1829 13.0959 9.79175C13.0959 9.40055 12.7788 9.08342 12.3876 9.08342H10.2626V6.95844C10.2626 6.56724 9.94546 6.25011 9.55426 6.25011C9.16307 6.25011 8.84594 6.56724 8.84594 6.95844Z"
                          fill="#4135F1"/>
                  </svg>
                </button>
                <div class="create-resume-form_main_btns">
                  <button type="button" class="btn--purple addprogram-anket-create-lesson-save teory">
                    Сохранить занятие
                  </button>
                  <button type="button" style="text-decoration: none;"
                          class="link--purple addprogram-anket-create-module-cancel" type="button">
                    Отменить
                  </button>
                </div>
              </div>
              <div class="create-module-task practice">
                <h3 class="create-module-task-stt">Обязательно</h3>
                <h4 class="create-resume-form_main-second-title">Название задания:</h4>
                <input placeholder="Кредитование" type="text" name="lesson-name"
                       class="input-t create-resume-form-input-t lesson-input-req">
                <h4 class="create-resume-form_main-second-title">Описание:</h4>
                <input placeholder="Кредитование" type="text" name="lesson-describe"
                       class="input-t create-resume-form-input-t lesson-input-req">
                <h4 class="create-resume-form_main-second-title">Видеопояснение</h4>
                <p class="create-resume-form_main-second-title-do-text">прикрепите ссылку на видео</p>
                <input placeholder="Ссылка на видео" type="text" name="video-link"
                       class="input-t create-resume-form-input-t">
                <h4 class="create-resume-form_main-second-title">Материалы к заданию <span>(инструкции, лекции, чек-листы и т.п.)</span>
                </h4>
                <input style="margin-bottom: 12px;" placeholder="Название документа" type="text"
                       name="document-to-lesson-name[]"
                       class="input-t create-resume-form-input-t lesson-input-req">
                <div class="input__wrapper">
                  <input name="document-to-lesson[]" type="file" id="input__file-4-1"
                         class="input input__file lesson-input-req">
                  <label for="input__file-4-1" class="input__file-button">
                    <span class="input__file-button-text">Загрузить документ</span>
                  </label>
                </div>
                <div class="add-doc-to-create-lesson2"></div>
                <button type="button"
                        class="btn--prpl-w-plus addprogram-anket-create-module-add-document2">
                  <span>Добавить материал</span>
                  <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                       xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd"
                          d="M9.79028 19C14.8759 19 18.9985 14.8773 18.9985 9.79175C18.9985 4.70617 14.8759 0.583496 9.79028 0.583496C4.70471 0.583496 0.582031 4.70617 0.582031 9.79175C0.582031 14.8773 4.70471 19 9.79028 19ZM9.7916 17.5832C5.48842 17.5832 2 14.0948 2 9.7916C2 5.48842 5.48842 2 9.7916 2C14.0948 2 17.5832 5.48842 17.5832 9.7916C17.5832 14.0948 14.0948 17.5832 9.7916 17.5832ZM8.84594 6.95844V9.08342H6.72096C6.32976 9.08342 6.01263 9.40055 6.01263 9.79175C6.01263 10.1829 6.32976 10.5001 6.72096 10.5001H8.84594V12.6251C8.84594 13.0163 9.16307 13.3334 9.55426 13.3334C9.94546 13.3334 10.2626 13.0163 10.2626 12.6251V10.5001H12.3876C12.7788 10.5001 13.0959 10.1829 13.0959 9.79175C13.0959 9.40055 12.7788 9.08342 12.3876 9.08342H10.2626V6.95844C10.2626 6.56724 9.94546 6.25011 9.55426 6.25011C9.16307 6.25011 8.84594 6.56724 8.84594 6.95844Z"
                          fill="#4135F1"/>
                  </svg>
                </button>
                <ul class="create-resume-form_main-input-group">
                  <li class="create-resume-form_main-input-group-item">
                    <label class="create-resume-form_main-input-group-item-label">
                      <input type="checkbox" name="autocheck-lesson"
                             value="Для самостоятельной работы, не требует проверки"
                             class="rad viewcours_test-radio">
                      <p class="create-resume-form_main-input-group-item-label-text">Для
                        самостоятельной работы, не требует проверки <br> <span>(Если ваш курс не предусматривает проверку заданий преподавателем, на шаге оценка заданий вы можете выбрать тип проверки «Все задания для самостоятельнйо проверки»)</span>
                      </p>
                    </label>
                  </li>
                </ul>
                <div class="create-resume-form_main_btns">
                  <button type="button"
                          class="btn--purple addprogram-anket-create-lesson-save practice">Сохранить
                    занятие
                  </button>
                  <button style="text-decoration: none;"
                          class="link--purple addprogram-anket-create-module-cancel" type="button">
                    Отменить
                  </button>
                </div>
              </div>
              <div class="create-module-task test">
                <h3 class="create-module-task-stt">Обязательно</h3>
                <h4 class="create-resume-form_main-second-title">Название теста:</h4>
                <input placeholder="Кредитование" type="text" name="lesson-name"
                       class="input-t create-resume-form-input-t lesson-input-req">
                <h3 class="create-module-task-stt">Вопросы</h3>

                <div class="addpr-ank-c-test-questions-blocks"></div>

                <div class="addpr-ank-c-test-quest">
                  <h4 class="create-resume-form_main-second-title">Текст вопроса</h4>
                  <input style="margin-bottom: 12px;" placeholder="Вопрос" type="text"
                         name="question-text[]"
                         class="input-t addpr-ank-c-test-quest-questions-input create-resume-form-input-t">
                  <div class="input__wrapper">
                    <input name="question-image[]" type="file" id="input__file-5-0"
                           class="input input__file">
                    <label for="input__file-5-0" class="input__file-button">
                      <span
                        class="input__file-button-text input__file-button-text-name">Загрузить изображение к вопросу</span>
                    </label>
                  </div>
                  <h4 class="create-resume-form_main-second-title">Выберите вид ответа:</h4>
                  <div class="addprogram-anket-type-answer">
                    <label class="addprogram-anket-type-answer-radio">
                      <input class="test-type-answer-1" type="radio" name="test-type-answer"
                             value="Текст">
                      Текст
                    </label>
                    <label class="addprogram-anket-type-answer-radio">
                      <input class="test-type-answer-2" type="radio" name="test-type-answer"
                             value="Выбрать из списка">
                      Выбрать из списка
                    </label>
                    <label class="addprogram-anket-type-answer-radio">
                      <input class="test-type-answer-3" type="radio" name="test-type-answer"
                             value="Упорядочить ответы">
                      Упорядочить ответы
                    </label>
                    <label class="addprogram-anket-type-answer-radio">
                      <input class="test-type-answer-4" type="radio" name="test-type-answer"
                             value="Соотнести">
                      Соотнести
                    </label>
                  </div>
                  <div class="test-type-answer_group test-type-answer_group-1">
                    <h4 class="create-resume-form_main-second-title">Текст ответа</h4>
                    <input style="margin-bottom: 20px;" placeholder="Ответ" type="text"
                           name="answer-text[]" class="input-t create-resume-form-input-t">

                    <button style="max-width: 224px;" type="button"
                            class="btn--purple test-type-answer_group-save">Сохранить
                    </button>
                  </div>
                  <div class="test-type-answer_group test-type-answer_group-2">
                    <h4 class="create-resume-form_main-second-title">Введите или загрузите варианты
                      ответов и отметьте правильный ответ</h4>
                    <div class="test-type-answer_group-2_answer">
                      <div class="test-type-answer_group-2_answer_top">
                        <div class="test-type-answer_group-2_answer_top_left">
                          <p class="test-type-answer_group-2_answer_top_left-number">1</p>
                          <input placeholder="Введите текст" type="text"
                                 name="answer-variation[]" class="answer-variation-input">
                        </div>
                        <label class="answer-variation-rigth-label">Правильный<input
                            class="answer-variation-rigth" type="checkbox"
                            name="answer-variation-rigth[]" value="Правильный"></label>
                      </div>
                      <div class="input__wrapper" style="margin-bottom: 0px;">
                        <input name="answer-variation-image[]" type="file" id="input__file-6-0"
                               class="input input__file">
                        <label for="input__file-6-0" class="input__file-button">
                          <span class="input__file-button-text">Загрузить ответ-изображение</span>
                        </label>
                      </div>
                    </div>
                    <div class="test-type-answer_group-2_answer">
                      <div class="test-type-answer_group-2_answer_top">
                        <div class="test-type-answer_group-2_answer_top_left">
                          <p class="test-type-answer_group-2_answer_top_left-number">2</p>
                          <input placeholder="Введите текст" type="text"
                                 name="answer-variation[]" class="answer-variation-input">
                        </div>
                        <label class="answer-variation-rigth-label">Правильный<input
                            class="answer-variation-rigth" type="checkbox"
                            name="answer-variation-rigth[]" value="Правильный"></label>
                      </div>
                      <div class="input__wrapper" style="margin-bottom: 0px;">
                        <input name="answer-variation-image[]" type="file" id="input__file-6-2"
                               class="input input__file">
                        <label for="input__file-6-2" class="input__file-button">
                          <span class="input__file-button-text">Загрузить ответ-изображение</span>
                        </label>
                      </div>
                    </div>
                    <div class="test-type-answer_group-2_answer">
                      <div class="test-type-answer_group-2_answer_top">
                        <div class="test-type-answer_group-2_answer_top_left">
                          <p class="test-type-answer_group-2_answer_top_left-number">3</p>
                          <input placeholder="Введите текст" type="text"
                                 name="answer-variation[]" class="answer-variation-input">
                        </div>
                        <label class="answer-variation-rigth-label">Правильный<input
                            class="answer-variation-rigth" type="checkbox"
                            name="answer-variation-rigth[]" value="Правильный"></label>
                      </div>
                      <div class="input__wrapper" style="margin-bottom: 0px;">
                        <input name="answer-variation-image[]" type="file" id="input__file-6-3"
                               class="input input__file">
                        <label for="input__file-6-3" class="input__file-button">
                          <span class="input__file-button-text">Загрузить ответ-изображение</span>
                        </label>
                      </div>
                    </div>
                    <div class="test-type-answer_group-2_answer">
                      <div class="test-type-answer_group-2_answer_top">
                        <div class="test-type-answer_group-2_answer_top_left">
                          <p class="test-type-answer_group-2_answer_top_left-number">4</p>
                          <input placeholder="Введите текст" type="text"
                                 name="answer-variation[]" class="answer-variation-input">
                        </div>
                        <label class="answer-variation-rigth-label">Правильный<input
                            class="answer-variation-rigth" type="checkbox"
                            name="answer-variation-rigth[]" value="Правильный"></label>
                      </div>
                      <div class="input__wrapper" style="margin-bottom: 0px;">
                        <input name="answer-variation-image[]" type="file" id="input__file-6-4"
                               class="input input__file">
                        <label for="input__file-6-4" class="input__file-button">
                          <span class="input__file-button-text">Загрузить ответ-изображение</span>
                        </label>
                      </div>
                    </div>
                    <div class="test-type-answer_group-2_answer-more"></div>

                    <div class="addprogram-anket-type-answers-add"></div>

                    <button class="link--purple test-type-answer_group-2_answer-addmore"
                            type="button">Добавить вариант
                    </button>
                    <button style="max-width: 224px;" type="button"
                            class="btn--purple test-type-answer_group-save">Сохранить
                    </button>
                  </div>
                  <div class="test-type-answer_group test-type-answer_group-3">
                    <h4 class="create-resume-form_main-second-title">Введите или прикрепите варианты
                      ответов в правильной последовательности</h4>
                    <div class="test-type-answer_group-2_answer">
                      <div class="test-type-answer_group-2_answer_top">
                        <div class="test-type-answer_group-2_answer_top_left">
                          <p class="test-type-answer_group-2_answer_top_left-number">1</p>
                          <input placeholder="Введите текст" type="text"
                                 name="answer-streamline[]" class="answer-variation-input">
                        </div>
                      </div>
                      <div class="input__wrapper" style="margin-bottom: 0px;">
                        <input name="answer-streamline-image[]" type="file" id="input__file-7-0"
                               class="input input__file">
                        <label for="input__file-7-0" class="input__file-button">
                          <span class="input__file-button-text">Загрузить ответ-изображение</span>
                        </label>
                      </div>
                    </div>
                    <div class="test-type-answer_group-2_answer">
                      <div class="test-type-answer_group-2_answer_top">
                        <div class="test-type-answer_group-2_answer_top_left">
                          <p class="test-type-answer_group-2_answer_top_left-number">2</p>
                          <input placeholder="Введите текст" type="text"
                                 name="answer-streamline[]" class="answer-variation-input">
                        </div>
                      </div>
                      <div class="input__wrapper" style="margin-bottom: 0px;">
                        <input name="answer-streamline-image[]" type="file" id="input__file-7-2"
                               class="input input__file">
                        <label for="input__file-7-2" class="input__file-button">
                          <span class="input__file-button-text">Загрузить ответ-изображение</span>
                        </label>
                      </div>
                    </div>
                    <div class="test-type-answer_group-2_answer">
                      <div class="test-type-answer_group-2_answer_top">
                        <div class="test-type-answer_group-2_answer_top_left">
                          <p class="test-type-answer_group-2_answer_top_left-number">3</p>
                          <input placeholder="Введите текст" type="text"
                                 name="answer-streamline[]" class="answer-variation-input">
                        </div>
                      </div>
                      <div class="input__wrapper" style="margin-bottom: 0px;">
                        <input name="answer-streamline-image[]" type="file" id="input__file-7-3"
                               class="input input__file">
                        <label for="input__file-7-3" class="input__file-button">
                          <span class="input__file-button-text">Загрузить ответ-изображение</span>
                        </label>
                      </div>
                    </div>
                    <div class="test-type-answer_group-2_answer">
                      <div class="test-type-answer_group-2_answer_top">
                        <div class="test-type-answer_group-2_answer_top_left">
                          <p class="test-type-answer_group-2_answer_top_left-number">4</p>
                          <input placeholder="Введите текст" type="text"
                                 name="answer-streamline[]" class="answer-variation-input">
                        </div>
                      </div>
                      <div class="input__wrapper" style="margin-bottom: 0px;">
                        <input name="answer-streamline-image[]" type="file" id="input__file-7-4"
                               class="input input__file">
                        <label for="input__file-7-4" class="input__file-button">
                          <span class="input__file-button-text">Загрузить ответ-изображение</span>
                        </label>
                      </div>
                    </div>
                    <div class="test-type-answer_group-3_answer-more"></div>

                    <div class="addprogram-anket-type-answers-add2"></div>

                    <button class="link--purple test-type-answer_group-3_answer-addmore"
                            type="button">Добавить вариант
                    </button>
                    <button style="max-width: 224px;" type="button"
                            class="btn--purple test-type-answer_group-save">Сохранить
                    </button>
                  </div>
                  <div class="test-type-answer_group test-type-answer_group-4">
                    <h4 class="create-resume-form_main-second-title">Введите названия категорий, к
                      которым необходимо соотнести варианты ответов</h4>
                    <div class="test-type-answer_group-2_answer">
                      <div class="test-type-answer_group-2_answer_top">
                        <div class="test-type-answer_group-2_answer_top_left">
                          <p class="test-type-answer_group-2_answer_top_left-number">1</p>
                          <input placeholder="Введите текст" type="text"
                                 name="answer-match-from[]" class="answer-variation-input">
                        </div>
                      </div>
                    </div>
                    <div class="test-type-answer_group-2_answer">
                      <div class="test-type-answer_group-2_answer_top">
                        <div class="test-type-answer_group-2_answer_top_left">
                          <p class="test-type-answer_group-2_answer_top_left-number">2</p>
                          <input placeholder="Введите текст" type="text"
                                 name="answer-match-from[]" class="answer-variation-input">
                        </div>
                      </div>
                    </div>
                    <div class="test-type-answer_group-2_answer">
                      <div class="test-type-answer_group-2_answer_top">
                        <div class="test-type-answer_group-2_answer_top_left">
                          <p class="test-type-answer_group-2_answer_top_left-number">3</p>
                          <input placeholder="Введите текст" type="text"
                                 name="answer-match-from[]" class="answer-variation-input">
                        </div>
                      </div>
                    </div>
                    <div class="test-type-answer_group-2_answer">
                      <div class="test-type-answer_group-2_answer_top">
                        <div class="test-type-answer_group-2_answer_top_left">
                          <p class="test-type-answer_group-2_answer_top_left-number">4</p>
                          <input placeholder="Введите текст" type="text"
                                 name="answer-match-from[]" class="answer-variation-input">
                        </div>
                      </div>
                    </div>
                    <div class="test-type-answer_group-4_answer-more"></div>
                    <button class="link--purple test-type-answer_group-4_answer-addmore"
                            type="button">Добавить категорию
                    </button>

                    <h4 class="create-resume-form_main-second-title">Введите или загрузите варианты
                      ответов и укажите к каким указанным выше категориям они относятся</h4>
                    <div class="test-type-answer_group-2_answer">
                      <div class="test-type-answer_group-2_answer_top">
                        <div class="test-type-answer_group-2_answer_top_left">
                          <p class="test-type-answer_group-2_answer_top_left-number">1</p>
                          <input placeholder="Введите текст" type="text"
                                 name="answer-match-to[]" class="answer-variation-input">
                        </div>
                        <input min="1" type="number" name="answer-match-to-num[]"
                               class="answer-match-to-num-input-number">
                      </div>
                      <div class="input__wrapper" style="margin-bottom: 0px;">
                        <input name="answer-match-to-image[]" type="file" id="input__file-8-0"
                               class="input input__file">
                        <label for="input__file-8-0" class="input__file-button">
                          <span class="input__file-button-text">Загрузить ответ-изображение</span>
                        </label>
                      </div>
                    </div>
                    <div class="test-type-answer_group-2_answer">
                      <div class="test-type-answer_group-2_answer_top">
                        <div class="test-type-answer_group-2_answer_top_left">
                          <p class="test-type-answer_group-2_answer_top_left-number">2</p>
                          <input placeholder="Введите текст" type="text"
                                 name="answer-match-to[]" class="answer-variation-input">
                        </div>
                        <input min="1" type="number" name="answer-match-to-num[]"
                               class="answer-match-to-num-input-number">
                      </div>
                      <div class="input__wrapper" style="margin-bottom: 0px;">
                        <input name="answer-match-to-image[]" type="file" id="input__file-8-2"
                               class="input input__file">
                        <label for="input__file-8-2" class="input__file-button">
                          <span class="input__file-button-text">Загрузить ответ-изображение</span>
                        </label>
                      </div>
                    </div>
                    <div class="test-type-answer_group-2_answer">
                      <div class="test-type-answer_group-2_answer_top">
                        <div class="test-type-answer_group-2_answer_top_left">
                          <p class="test-type-answer_group-2_answer_top_left-number">3</p>
                          <input placeholder="Введите текст" type="text"
                                 name="answer-match-to[]" class="answer-variation-input">
                        </div>
                        <input min="1" type="number" name="answer-match-to-num[]"
                               class="answer-match-to-num-input-number">
                      </div>
                      <div class="input__wrapper" style="margin-bottom: 0px;">
                        <input name="answer-match-to-image[]" type="file" id="input__file-8-3"
                               class="input input__file">
                        <label for="input__file-8-3" class="input__file-button">
                          <span class="input__file-button-text">Загрузить ответ-изображение</span>
                        </label>
                      </div>
                    </div>
                    <div class="test-type-answer_group-2_answer">
                      <div class="test-type-answer_group-2_answer_top">
                        <div class="test-type-answer_group-2_answer_top_left">
                          <p class="test-type-answer_group-2_answer_top_left-number">4</p>
                          <input placeholder="Введите текст" type="text"
                                 name="answer-match-to[]" class="answer-variation-input">
                        </div>
                        <input min="1" type="number" name="answer-match-to-num[]"
                               class="answer-match-to-num-input-number">
                      </div>
                      <div class="input__wrapper" style="margin-bottom: 0px;">
                        <input name="answer-match-to-image[]" type="file" id="input__file-8-4"
                               class="input input__file">
                        <label for="input__file-8-4" class="input__file-button">
                          <span class="input__file-button-text">Загрузить ответ-изображение</span>
                        </label>
                      </div>
                    </div>
                    <div class="test-type-answer_group-5_answer-more"></div>
                    <button class="link--purple test-type-answer_group-5_answer-addmore"
                            type="button">Добавить категорию
                    </button>

                    <button style="max-width: 224px;" type="button"
                            class="btn--purple test-type-answer_group-save">Сохранить
                    </button>
                  </div>
                </div>

                <div class="addprogram-anket-create-module-add-question-b">
                  <button type="button"
                          class="btn--prpl-w-plus addprogram-anket-create-module-add-question">
                    <span>Добавить вопрос</span>
                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                         xmlns="http://www.w3.org/2000/svg">
                      <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M9.79028 19C14.8759 19 18.9985 14.8773 18.9985 9.79175C18.9985 4.70617 14.8759 0.583496 9.79028 0.583496C4.70471 0.583496 0.582031 4.70617 0.582031 9.79175C0.582031 14.8773 4.70471 19 9.79028 19ZM9.7916 17.5832C5.48842 17.5832 2 14.0948 2 9.7916C2 5.48842 5.48842 2 9.7916 2C14.0948 2 17.5832 5.48842 17.5832 9.7916C17.5832 14.0948 14.0948 17.5832 9.7916 17.5832ZM8.84594 6.95844V9.08342H6.72096C6.32976 9.08342 6.01263 9.40055 6.01263 9.79175C6.01263 10.1829 6.32976 10.5001 6.72096 10.5001H8.84594V12.6251C8.84594 13.0163 9.16307 13.3334 9.55426 13.3334C9.94546 13.3334 10.2626 13.0163 10.2626 12.6251V10.5001H12.3876C12.7788 10.5001 13.0959 10.1829 13.0959 9.79175C13.0959 9.40055 12.7788 9.08342 12.3876 9.08342H10.2626V6.95844C10.2626 6.56724 9.94546 6.25011 9.55426 6.25011C9.16307 6.25011 8.84594 6.56724 8.84594 6.95844Z"
                            fill="#4135F1"/>
                    </svg>
                  </button>
                </div>
                <h4 class="create-resume-form_main-second-title">Укажите, сколько раз студент может
                  проходить тест</h4>
                <div style="margin-bottom: 40px;" class="create-resume-form_main_btns">
                  <input style="max-width: 84px; margin-bottom: 0px;" min="1" placeholder="1 раз"
                         type="number" name="retest-count" class="input-t create-resume-form-input-t">
                  <label class="create-resume-form_main-input-group-item-label">
                    <input type="checkbox" name="autocheck-lesson" value="Неограниченно"
                           class="rad viewcours_test-radio">
                    <p class="create-resume-form_main-input-group-item-label-text">
                      Неограниченно</span></p>
                  </label>
                </div>
                <div class="create-resume-form_main_btns">
                  <button type="button" class="btn--purple addprogram-anket-create-lesson-save test">
                    Сохранить занятие
                  </button>
                  <button style="text-decoration: none;"
                          class="link--purple addprogram-anket-create-module-cancel test"
                          type="button">
                    Отменить
                  </button>
                </div>
              </div>
              <?= Html::endForm(); ?>
              <div class="create-resume-form_main_btns">
                <button disabled class="btn--purple addprogram-anket-create-module-save"
                        form="addprogram_anket-course-form-4">Сохранить модуль
                </button>
              </div>
            </div>

            <?= Html::beginForm('', 'post', ['class' => 'addprogram_anket-course-form-5', 'id' => 'addprogram_anket-course-form-5']) ?>
            <h2 style="margin-top: 40px;" class="create-resume-form_main-title">Доступ к курсу</h2>
            <p style="margin-bottom: 12px;" class="create-resume-form5_main-text">Уточните, как вы хотите
              предоставлять доступ к вашему курсу</p>
            <div class="lesson-access_block">
              <label class="lesson-access-radio-label">
                <input type="radio" name="lesson-access-type" class="input-hide lesson-access-radio-1">
                <div class="lesson-access-radio-label_block">
                  <svg width="18" height="18" viewBox="0 0 18 18" fill="none"
                       xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd"
                          d="M18 9C18 13.9706 13.9706 18 9 18C4.02944 18 0 13.9706 0 9C0 4.02944 4.02944 0 9 0C13.9706 0 18 4.02944 18 9ZM1.38477 9.00033C1.38477 13.2062 4.79429 16.6157 9.00015 16.6157C13.206 16.6157 16.6155 13.2062 16.6155 9.00033C16.6155 4.79447 13.206 1.38495 9.00015 1.38495C4.79429 1.38495 1.38477 4.79447 1.38477 9.00033Z"
                          fill="#2CCD65"/>
                    <path
                      d="M5.25184 8.88472C4.99206 8.58244 4.54081 8.55181 4.24392 8.81631C3.94704 9.0808 3.91695 9.54027 4.17673 9.84255L6.67673 12.7516C6.95415 13.0745 7.44431 13.0839 7.73358 12.7721L13.805 6.22664C14.0759 5.93462 14.063 5.47433 13.7762 5.19854C13.4894 4.92275 13.0373 4.9359 12.7664 5.22791L7.23446 11.1918L5.25184 8.88472Z"
                      fill="#2CCD65"/>
                  </svg>
                  <p class="lesson-access-radio-label_block-text">Все модули доступны сразу после
                    приобретения курса</p>
                </div>
              </label>
              <label class="lesson-access-radio-label">
                <input type="radio" name="lesson-access-type" class="input-hide lesson-access-radio-2">
                <div class="lesson-access-radio-label_block">
                  <svg width="21" height="20" viewBox="0 0 21 20" fill="none"
                       xmlns="http://www.w3.org/2000/svg">
                    <path
                      d="M4.57552 9.18744V10.1874L4.57742 10.1874L4.57552 9.18744ZM17.0755 9.18744L17.066 10.1874H17.0755V9.18744ZM5.65885 9.1676C5.65885 9.71989 6.10657 10.1676 6.65885 10.1676C7.21114 10.1676 7.65885 9.71989 7.65885 9.1676H5.65885ZM6.65885 5.83623H7.65886L7.65885 5.83521L6.65885 5.83623ZM10.4446 1.68892L10.5441 2.68396L10.5441 2.68396L10.4446 1.68892ZM11.8255 12.5009C11.8255 11.9487 11.3778 11.5009 10.8255 11.5009C10.2732 11.5009 9.82552 11.9487 9.82552 12.5009H11.8255ZM9.82552 15.0009C9.82552 15.5532 10.2732 16.0009 10.8255 16.0009C11.3778 16.0009 11.8255 15.5532 11.8255 15.0009H9.82552ZM17.0755 10.1874C16.9835 10.1874 16.9089 10.1128 16.9089 10.0208H18.9089C18.9089 9.00825 18.088 8.18744 17.0755 8.18744V10.1874ZM16.9089 10.0208V17.5208H18.9089V10.0208H16.9089ZM16.9089 17.5208C16.9089 17.4287 16.9835 17.3541 17.0755 17.3541V19.3541C18.088 19.3541 18.9089 18.5333 18.9089 17.5208H16.9089ZM17.0755 17.3541H4.57552V19.3541H17.0755V17.3541ZM4.57552 17.3541C4.66757 17.3541 4.74219 17.4287 4.74219 17.5208H2.74219C2.74219 18.5333 3.563 19.3541 4.57552 19.3541V17.3541ZM4.74219 17.5208V10.0208H2.74219V17.5208H4.74219ZM4.74219 10.0208C4.74219 10.1128 4.66757 10.1874 4.57552 10.1874V8.18744C3.563 8.18744 2.74219 9.00825 2.74219 10.0208H4.74219ZM7.65885 9.1676V5.83623H5.65885V9.1676H7.65885ZM7.65885 5.83521C7.65722 4.21857 8.89581 2.84869 10.5441 2.68396L10.3452 0.693878C7.69082 0.959157 5.65616 3.17515 5.65886 5.83724L7.65885 5.83521ZM10.5441 2.68396C12.2241 2.51606 13.9922 3.62109 13.9922 5.83426H15.9922C15.9922 2.21403 12.9678 0.431772 10.3452 0.693878L10.5441 2.68396ZM9.82552 12.5009V15.0009H11.8255V12.5009H9.82552ZM4.57742 10.1874L14.9941 10.1676L14.9903 8.1676L4.57362 8.18744L4.57742 10.1874ZM14.9827 10.1676L17.066 10.1874L17.085 8.18748L15.0017 8.16765L14.9827 10.1676ZM15.9922 9.1676V5.83426H13.9922V9.1676H15.9922Z"
                      fill="#2B3048"/>
                  </svg>
                  <p class="lesson-access-radio-label_block-text">Курс запускается в указанное вами
                    время.</p>
                  <p class="lesson-access-radio-label_block-text">Вы также определяете даты доступа к
                    каждому блоку курса</p>
                </div>
              </label>
            </div>
            <p class="create-resume-form5_main-text lesson-access-radio-1-text">После технической модерации
              курс появится на платформе.</p>
            <div class="lesson-access-radio-2-block">
              <div class="lesson-access-radio-2-block_container">
                <p class="create-resume-form5_main-text">Через месяц после открытия последнего модуля,
                  доступ к вашей программе будет закрыт. Вы сможете запустить курс снова, выбрав
                  удобный формат доступа.</p>
                <div class="check-lesson-grading-format-2_block_moduls">
                  <div class="check-lesson-grading-format-2_block_moduls-item">
                    <button type="button"
                            class="check-lesson-grading-format-2_block_moduls-item-btn">Модуль 1
                      «Основы продаж»
                    </button>
                    <div class="check-lesson-grading-format-2_block_moduls-item_main">
                      <div class="check-lesson-grading-format-2_block_moduls-item_main_conainer">
                        <div class="check-lesson-grading-format-2_block_moduls-item_main-item">
                          <p class="check-lesson-grading-format-2_block_moduls-item_main-item-text">
                            Название блока 1</p>
                          <?php echo DatePicker::widget([
                            'name' => 'lesson-access-date[]',
                            'options' => ['class' => 'lesson-access-date-input', 'placeholder' => 'Выберите дату'],
                            'dateFormat' => 'dd-MM-yyyy',
                          ]); ?>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <label class="check-lesson-type-3_block-group-item first-lesson-free-label">
              <input class="input-hide" type="checkbox" name="first-lesson-free"
                     value="Сделать первый урок бесплатным">
              <div class="check-lesson-type-3_block-group-item-indicator">
                <svg width="8" height="6" viewBox="0 0 8 6" fill="none"
                     xmlns="http://www.w3.org/2000/svg">
                  <path fill-rule="evenodd" clip-rule="evenodd"
                        d="M7.7 0.3C7.3 -0.1 6.7 -0.1 6.3 0.3L3 3.6L1.7 2.3C1.3 1.9 0.7 1.9 0.3 2.3C-0.1 2.7 -0.1 3.3 0.3 3.7L2.3 5.7C2.5 5.9 2.7 6 3 6C3.3 6 3.5 5.9 3.7 5.7L7.7 1.7C8.1 1.3 8.1 0.7 7.7 0.3Z"
                        fill="white"/>
                </svg>
              </div>
              <div class="check-lesson-type-3_block-group-item_text">
                <p class="check-lesson-type-3_block-group-item_text-title">Сделать первый урок
                  бесплатным <br> <span>Это повысит лояльность студентов к вашим курсам и позволит им оценить качество материала</span>
                </p>
              </div>
            </label>
            <?= Html::endForm(); ?>
          </div>
        </div>
      </section>
    </div>
  </section>
  <br>
  <br>
</section>

<div class="popup popup--w3 addprogram-popup-delete">
  <div class="popup__ov">
    <div class="popup__body popup__body--w">
      <div class="popup__content popup__content--w">
        <p class="popup__title">Обратите внимание!</p>
        <p class="popup__text">
          Вы действительно хотите безвозвратно удалить проект?</a>
        </p>
        <p class="popup__text errors__texts" style="color: red"></p>
        <button type="submit" class="popup__btn1 btn addprogram-popup-delete-confirm">Да</button>
        <button class="popup__btn-close btn">Отмена</button>
      </div>
      <div class="popup__close">
        <img src="<?= Url::to(['/img/close.png']) ?>" alt="close">
      </div>
    </div>
  </div>
</div>

<div class="popup popup--ok popup-make-summ-learn-p">
  <div class="popup__ov">
    <div class="popup__body popup__body--ok">
      <div class="popup__content popup__content--ok">
        <p class="popup__title">Узнайте подробнее о ценообразовании курсов</p>
        <p class="popup__text">
          Нажмите на кнопку ниже и получите консультацию менеджера по развитию
        </p>
        <button type="submit" class="popup__btn1 btn popup-make-summ-learn-p-confirm">Узнать о ценообразовании
        </button>
      </div>
      <div class="popup__close">
        <img src="<?= Url::to(['/img/close.png']) ?>" alt="close">
      </div>
    </div>
  </div>
</div>
<div class="popup popup--ok popup-make-summ-learn-p-done">
  <div class="popup__ov">
    <div class="popup__body popup__body--ok">
      <div class="popup__content popup__content--ok">
        <p class="popup__title">Ваша заявка отправлена</p>
        <p class="popup__text">
          Менеджер свяжется с вами в течение 5 минут</a>
        </p>
      </div>
      <div class="popup__close">
        <img src="<?= Url::to(['/img/close.png']) ?>" alt="close">
      </div>
    </div>
  </div>
</div>
<div class="popup popup--ok corse-upload-done-popup">
  <div class="popup__ov">
    <div class="popup__body popup__body--ok">
      <div class="popup__content popup__content--ok">
        <p class="popup__title">Успешно</p>
        <p class="popup__text">
          Ваш курс отправлен на техническую модерацию.
          Ожидайде звонка нашего менеджера для подтверджения размещения курса и уточнения деталей
        </p>
      </div>
      <div class="popup__close">
        <img src="<?= Url::to(['/img/close.png']) ?>" alt="close">
      </div>
    </div>
  </div>
</div>