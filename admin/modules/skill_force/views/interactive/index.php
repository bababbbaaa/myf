<?php

use kartik\datetime\DateTimePicker;
use mihaildev\ckeditor\CKEditor;
use mihaildev\elfinder\ElFinder;
use mihaildev\elfinder\InputFile;
use yii\helpers\Url;
use yii\jui\DatePicker;

$this->title = 'Интерактивный конструктор курсов';
$this->params['breadcrumbs'][] = ['label' => "Skill.Force", 'url' => 'main/index'];
$this->params['breadcrumbs'][] = ['label' => "Конструктор курсов", 'url' => 'main/constructor'];
$this->params['breadcrumbs'][] = $this->title;
$this->registerCssFile(Url::to(['/css/interactive/interactive.css']));
$this->registerJsFile(Url::to(['/js/interactive/interactive.js']), ['depends' => 'yii\web\JqueryAsset']);
$this->registerJsFile(Url::to(['/js/interactive/moreFunc.js']), ['depends' => 'yii\web\JqueryAsset']);

?>

<div class="container">
  <div class="steps_block">
    <div data-step="1" class="step step-1">1</div>
    <div data-step="2" disabled class="step step-2">2</div>
    <div data-step="3" disabled class="step step-3">3</div>
    <div data-step="4" disabled class="step step-4">4</div>
    <div data-step="5" disabled class="step step-5">5</div>
    <div data-step="6" disabled class="step step-6">6</div>
  </div>
  <div class="blocks_write">
    <form class="courseForm">
      <div class="write write-1">
        <h2>1. Категории</h2>
        <div class="choose_category">
          <div class="form-group">
            <label for="courseCategory">Выберите категорию</label>
            <select id="courseCategory" name="category" class="form-control">
              <option selected disabled>Выберите категорию</option>
              <option value="БФЛ">БФЛ</option>
              <option value="Маркетос">Маркетос</option>
              <option value="Пивовары">Пивовары</option>
              <option value="Пандарены">Пандарены</option>
            </select>
            <small hidden id="courseCategoryHelp" class="form-text text-danger"></small>
          </div>
          <div class="form-group">
            <button type="button" class="btn btn-info addCategory">Нет подходящей категории</button>
          </div>
        </div>
        <div style="display: none;" class="addCategory_block">
          <div class="form-group">
            <label for="categoryCreate">Введите название категории</label>
            <input type="text" name="category[create]" class="form-control" id="categoryCreate" placeholder="Банкотство юр.лиц">
            <small hidden id="categoryCreateHelp" class="form-text text-danger"></small>
          </div>
          <div class="form-group">
            <button type="button" class="btn btn-info chooseCategory">Выбрать категорию</button>
          </div>
        </div>
        <button data-step="1" type="button" class="btn btn-primary nextStep">Продолжить</button>
      </div>

      <div hidden class="write write-2">
        <h2>2. Автор курса</h2>
        <div class="author__select">
          <div class="form-group">
            <label for="courseAuthor">Выберите преподавателя</label>
            <select id="courseAuthor" name="author" class="form-control">
              <option selected disabled>Выберите преподавателя</option>
              <option value="1">Димас</option>
              <option value="2">Марина</option>
              <option value="3">Фантазер</option>
              <option value="4">Чикабум</option>
            </select>
            <small hidden id="courseAuthorHelp" class="form-text text-danger"></small>
          </div>
          <div class="form-group">
            <button type="button" class="btn btn-info show_author-create">Добавить автора</button>
          </div>
        </div>
        <div style="display: none;" class="author__block">
          <div class="form-group">
            <label for="authorFio">ФИО Автора</label>
            <input type="text" name="author[create][fio]" class="form-control" id="authorFio" placeholder="Дьярова Марина">
            <small hidden id="authorFioHelp" class="form-text text-danger"></small>
          </div>
          <div class="form-group">
            <label for="authorDesc">Краткое описание</label>
            <input type="text" name="author[create][desc]" class="form-control" id="authorDesc" placeholder="Генеральный директор ООО ФИРМА, руководитель образовательных программ">
            <small hidden id="authorDescHelp" class="form-text text-danger"></small>
          </div>
          <div class="form-group">
            <label for="authorExp">Ваш опыт</label>
            <input type="number" name="author[create][exp]" class="form-control" id="authorExp" placeholder="На пример: 5 лет">
            <small hidden id="authorExpHelp" class="form-text text-danger"></small>
          </div>
          <div class="form-group">
            <label for="authorAbout">Расскажите о авторе будущим студентам</label>
            <textarea type="text" name="author[create][about]" class="form-control" id="authorAbout" cols="30" rows="5" placeholder="Не более 1000 символов"></textarea>
            <small hidden id="authorAboutHelp" class="form-text text-danger"></small>
          </div>
          <div class="form-group">
            <label for="authorSpec">Специализация автора (через запятую)</label>
            <input type="text" name="author[create][spec]" class="form-control" id="authorSpec" placeholder="Банкротство, Маркетинг, Менеджмент">
            <small hidden id="authorSpecHelp" class="form-text text-danger"></small>
          </div>
          <div class="form-group">
            <label for="authorPhoto">Фото автора</label>
            <?php echo InputFile::widget([
              'language'      => 'ru',
              'controller'    => 'elfinder',
              'filter'        => 'image',
              'name'          => 'author[create][photo]',
              'value'         => '',
              'template'      => '<div class="input-group">{input}<span class="input-group-btn">{button}</span></div>',
              'options'       => ['class' => 'form-control', 'id' => 'authorPhoto'],
              'buttonOptions' => ['class' => 'btn btn-warning'],
            ]); ?>
            <small hidden id="authorPhotoHelp" class="form-text text-danger"></small>
          </div>
          <div class="form-group">
            <button type="button" class="btn btn-info show_author-add">Выбрать автора</button>
          </div>
        </div>
        <button data-step="2" type="button" class="btn btn-primary nextStep">Продолжить</button>
      </div>

      <div hidden class="write write-3">
        <h2>3. Преподаватели курса</h2>
        <div class="teacher__choose">
          <div class="form-group">
            <label for="courseTeacher">Выберите категорию</label>
            <select multiple id="courseTeacher" name="teacher[choose][]" class="form-control">
              <option selected>Выберите категорию</option>
              <option value="1">Марина Дьярова</option>
              <option value="2">Чел с улицы</option>
              <option value="3">Чел с подъезда</option>
              <option value="4">Ещё какой-то чел</option>
            </select>
            <small hidden id="courseTeacherHelp" class="form-text text-danger"></small>
          </div>
          <div class="form-group">
            <button type="button" class="btn btn-info addTeacher">Добавить преподавателя</button>
          </div>
        </div>

        <div style="display: none;" class="teacher__create">
          <div class="teacher__block">
            <div class="teacher__item">
              <p class="teacher__image">/image/teacher/ava.png</p>
              <p class="teacher__name">Марина Дьярова</p>
            </div>
          </div>
          <div class="form-group">
            <label for="teacherFio">ФИО преподавателя</label>
            <input type="text" name="teacher[create][fio]" class="form-control" id="teacherFio" placeholder="Дьярова Марина">
            <small hidden id="teacherFioHelp" class="form-text text-danger"></small>
          </div>
          <div class="form-group">
            <label for="authorPhoto">Фото автора</label>
            <?php echo InputFile::widget([
              'language'      => 'ru',
              'controller'    => 'elfinder',
              'filter'        => 'image',
              'name'          => 'teacher[create][photo]',
              'value'         => '',
              'template'      => '<div class="input-group">{input}<span class="input-group-btn">{button}</span></div>',
              'options'       => ['class' => 'form-control', 'id' => 'teacherPhoto'],
              'buttonOptions' => ['class' => 'btn btn-warning'],
            ]); ?>
            <small hidden id="teacherPhotoHelp" class="form-text text-danger"></small>
          </div>
          <div style="display: flex; align-items: center; gap: 15px" class="form-group">
            <button type="button" class="btn btn-success teacherAdd">Добавить преподавателя</button>
            <button type="button" class="btn btn-info teacherChoose">Вернуться к выбору преподавателя</button>
          </div>
        </div>
        <button data-step="3" type="button" class="btn btn-primary nextStep">Продолжить</button>
      </div>

      <div hidden class="write write-4">
        <h2>4. Информация о курсе</h2>
        <div class="form-group">
          <label for="courseName">Название курса</label>
          <input type="text" name="course[create][name]" class="form-control courseName" id="courseName" placeholder="Первый миллион на БФЛ">
          <input type="hidden" name="course[create][link]" class="courseLink">
          <small hidden id="courseNameHelp" class="form-text text-danger"></small>
        </div>
        <div class="form-group">
          <label for="courseType">Выберите тип</label>
          <select id="courseType" name="teacher[choose][type]" class="form-control">
            <option selected disabled>Выберите категорию</option>
            <option value="Курс">Курс</option>
            <option value="Вебинар">Вебинар</option>
            <option value="Интенсив">Интенсив</option>
          </select>
          <small hidden id="courseTypeHelp" class="form-text text-danger"></small>
        </div>
        <div class="form-group">
          <label for="courseTags">Теги</label>
          <input type="text" name="course[create][tags]" class="form-control" id="courseTags" placeholder="Теги через ' ;': маркетинг; гарантия трудоустройства; продажи ">
          <small hidden id="courseTagsHelp" class="form-text text-danger"></small>
        </div>
        <div class="form-group">
          <label for="courseLogo">Превью лого</label>
          <?php echo InputFile::widget([
            'language'      => 'ru',
            'controller'    => 'elfinder',
            'filter'        => 'image',
            'name'          => 'course[create][logo]',
            'value'         => '',
            'template'      => '<div class="input-group">{input}<span class="input-group-btn">{button}</span></div>',
            'options'       => ['class' => 'form-control', 'id' => 'courseLogo'],
            'buttonOptions' => ['class' => 'btn btn-warning'],
          ]); ?>
          <small hidden id="courseLogoHelp" class="form-text text-danger"></small>
        </div>
        <div class="form-group">
          <label for="courseFreeLesson">Бесплатный урок (не обязательно)</label>
          <input type="text" name="course[create][free-lesson]" class="form-control" id="courseFreeLesson" placeholder="https://www.youtube.com/watch?v=-FVu9EutRdk&t=2s&ab_channel=BurgerChannel">
          <small hidden id="courseFreeLessonHelp" class="form-text text-danger"></small>
        </div>
        <div class="form-group">
          <label for="courseSubtitle">Подзаголовок</label>
          <input type="text" name="course[create][subtitle]" class="form-control" id="courseSubtitle" placeholder="Курс по банкротству физических лиц">
          <small hidden id="courseSubtitleHelp" class="form-text text-danger"></small>
        </div>
        <div class="form-group">
          <label for="courseAbout">О курсе</label>
          <?php echo CKEditor::widget([
            'editorOptions' => [ElFinder::ckeditorOptions('elfinder'),],
            'name' => 'course[create][about]',
            'options' => ['id' => 'courseAbout'],
          ]); ?>
          <small hidden id="courseAboutHelp" class="form-text text-danger"></small>
        </div>
        <div class="form-group">
          <label for="courseIncome">Доход профессии</label>
          <input type="number" name="course[create][income]" class="form-control" id="courseIncome" placeholder="78000">
          <small hidden id="courseIncomeHelp" class="form-text text-danger"></small>
        </div>
        <div class="form-group">
          <label for="courseDescription">Описание профессии</label>
          <input type="text" name="course[create][descriprion]" class="form-control" id="courseDescription" placeholder="В среднем зарабатывает специалист по таргетированной рекламе среднего уровня">
          <small hidden id="courseDescriptionHelp" class="form-text text-danger"></small>
        </div>
        <div class="form-group">
          <label for="courseTagsSearch">Теги поиска</label>
          <input type="text" name="course[create][tags-search]" class="form-control" id="courseTagsSearch" placeholder="Поисковые теги через ';': smm; таргет">
          <small hidden id="courseTagsSearchHelp" class="form-text text-danger"></small>
        </div>
        <div class="form-group">
          <label for="courseContentTerms">Условия обучения</label>
          <input type="text" name="course[create][content-terms]" class="form-control" id="courseContentTerms" placeholder="Для поступления на курс не требуются профильные знания. За время обучения вы сможете освоить профессию с нуля">
          <small hidden id="courseContentTermsHelp" class="form-text text-danger"></small>
        </div>
        <div class="form-group">
          <label for="courseLevel">Сложность обучения</label>
          <select id="courseLevel" name="teacher[choose][level]" class="form-control">
            <option selected disabled>Выберите категорию</option>
            <option value="Новичок">Новичок</option>
            <option value="Базовый">Базовый</option>
            <option value="Продвинутый">Продвинутый</option>
          </select>
          <small hidden id="courseLevelHelp" class="form-text text-danger"></small>
        </div>
        <div class="form-group">
          <label for="courseSale">Скидка</label>
          <input type="number" name="course[create][sale]" class="form-control" id="courseSale" placeholder="20">
          <small hidden id="courseSaleHelp" class="form-text text-danger"></small>
        </div>
        <div class="form-group">
          <label for="courseCost">Цена</label>
          <input type="number" name="course[create][cost]" class="form-control" id="courseCost" placeholder="89900">
          <small hidden id="courseCostHelp" class="form-text text-danger"></small>
        </div>
        <div class="form-group">
          <label for="courseEndSale">Дата окончания скидки</label>
          <?php echo DatePicker::widget([
            'name'  => 'course[create][end-sale]',
            'value'  => '',
            'language' => 'ru',
            'dateFormat' => 'yyyy-MM-dd',
            'options' => ['id' => 'courseEndSale', 'class' => 'form-control', 'placeholder' => date('d.m.Y')]
          ]); ?>
          <small hidden id="courseEndSaleHelp" class="form-text text-danger"></small>
        </div>
        <div class="form-group">
          <label for="courseStart">Дата начала курса</label>
          <?php echo DateTimePicker::widget([
            'name' => 'course[create][start]',
            'options' => ['placeholder' => date('Y-m-d'), 'id' => 'courseStart'],
            'convertFormat' => true,
            'pluginOptions' => [
              'format' => 'yyyy-m-d H:i',
              'startDate' => date('Y-m-d H:i:s'),
              'todayHighlight' => false
            ]
          ]); ?>
          <small hidden id="courseStartHelp" class="form-text text-danger"></small>
        </div>
        <div class="form-group">
          <label for="courseEnd">Дата окончания курса</label>
          <?php echo DateTimePicker::widget([
            'name' => 'course[create][end]',
            'options' => ['placeholder' => date('Y-m-d'), 'id' => 'courseEnd'],
            'convertFormat' => true,
            'pluginOptions' => [
              'format' => 'yyyy-m-d H:i',
              'startDate' => date('Y-m-d H:i:s'),
              'todayHighlight' => false
            ]
          ]); ?>
          <small hidden id="courseEndHelp" class="form-text text-danger"></small>
        </div>
        <div class="form-group">
          <label for="courseLessonCount">Количество уроков</label>
          <input type="number" name="course[create][lesson-count]" class="form-control" id="courseLessonCount" placeholder="89900">
          <small hidden id="courseLessonCountHelp" class="form-text text-danger"></small>
        </div>
        <div class="form-group">
          <label for="courseStudyHours">Количество часов</label>
          <input type="number" name="course[create][study-hours]" class="form-control" id="courseStudyHours" placeholder="89900">
          <small hidden id="courseStudyHoursHelp" class="form-text text-danger"></small>
        </div>
        <div class="checkbox">
          <label>
            <input name="course[create][video]" type="checkbox"> Есть видео-материал
          </label>
        </div>
        <div class="checkbox">
          <label>
            <input name="course[create][bonuses]" type="checkbox"> Есть бонусы
          </label>
        </div>
        <div class="material_block">
          <div class="material_item">
            <p class="material_item-text">Название документа: <span class="material_item-name">Чек-лист</span>;</p>
            <p class="material_item-text">Файл: <span class="material_item-file">Чек-лист</span></p>
          </div>
        </div>
        <div style="margin-bottom: 15px;" class="material_inputs">
          <input type="hidden" name="course[create][materials]">
          <label>Добавить документ</label>
          <div class="row" style="margin-bottom: 15px;">
            <div class="col-md-6">
              <input class="form-control" type="text" placeholder="Введите название файла">
            </div>
            <div class="col-md-6">
              <?php echo InputFile::widget([
                'language'      => 'ru',
                'controller'    => 'elfinder',
                'name'          => 'puth_file',
                'value'         => '',
                'template'      => '<div class="input-group">{input}<span class="input-group-btn">{button}</span></div>',
                'options'       => ['class' => 'form-control', 'id' => 'courseLogo', 'placeholder' => 'Выберите файл'],
                'buttonOptions' => ['class' => 'btn btn-warning'],
              ]); ?>
            </div>
          </div>
          <button type="button" class="btn btn-admin-help">Добавить материал</button>
        </div>

        <div class="forwhom_block">
          <div class="forwhom_item">
            <p class="forwhom_item-text">Название документа: <span class="forwhom_item-name">Чек-лист</span>;</p>
            <p class="forwhom_item-text">Файл: <span class="forwhom_item-file">Чек-лист</span></p>
          </div>
        </div>
        <div style="margin-bottom: 15px;" class="forwhom_inputs">
          <label>Кому подойдет курс</label>
          <input style="margin-bottom: 10px;" type="text" class="form-control" placeholder="Без опыта">
          <textarea name="" style="margin-bottom: 10px;" cols="10" rows="3" class="form-control" placeholder="Даже если вы никогда не работали в IT, вы получите востребованную и высокооплачиваемую профессию, а мы поможем вам устроиться на крутую работу"></textarea>
          <button type="button" class="btn btn-admin-help">Добавить</button>
        </div>

        <div class="whatStudy_block">
          <div class="whatStudy_item">
            <p class="whatStudy_item-text">Название документа: <span class="whatStudy_item-name">Чек-лист</span>;</p>
            <p class="whatStudy_item-text">Файл: <span class="whatStudy_item-file">Чек-лист</span></p>
          </div>
        </div>
        <div style="margin-bottom: 15px;" class="whatStudy_inputs">
          <label>Что изучаем</label>
          <input style="margin-bottom: 10px;" type="text" class="form-control" placeholder="Работать в рекламных кабинетах">
          <textarea name="" style="margin-bottom: 10px;" cols="10" rows="3" class="form-control" placeholder="Запускать рекламные объявления в Facebook, Instagram, ВКонтакте, myTarget"></textarea>
          <button type="button" class="btn btn-admin-help">Добавить</button>
        </div>

        <div class="form-group">
          <label for="courseKeywords">META-ключи</label>
          <input type="text" name="course[create][keyword]" class="form-control" id="courseKeywords" placeholder="Маркетинг; бфл; Банкротство">
          <small hidden id="courseKeywordsHelp" class="form-text text-danger"></small>
        </div>

        <div class="form-group">
          <label for="courseDescription">МЕТА-описание</label>
          <input type="text" name="course[create][description]" class="form-control" id="courseDescription" placeholder="Практический курс по маркетингу от FemidaForce для людей, которые хотят большего">
          <small hidden id="courseDescriptionHelp" class="form-text text-danger"></small>
        </div>

        <div class="form-group">
          <label for="courseOgImage">OG-картинка</label>
          <?php echo InputFile::widget([
            'language'      => 'ru',
            'controller'    => 'elfinder',
            'filter'        => 'image',
            'name'          => 'course[create][og-image]',
            'value'         => '',
            'template'      => '<div class="input-group">{input}<span class="input-group-btn">{button}</span></div>',
            'options'       => ['class' => 'form-control', 'id' => 'courseOgImage', 'placeholder' => 'OG-картинка'],
            'buttonOptions' => ['class' => 'btn btn-warning'],
          ]); ?>
          <small hidden id="courseOgImageHelp" class="form-text text-danger"></small>
        </div>

        <div class="form-group">
          <label for="courseOgTitle">OG-заголовок</label>
          <input type="text" name="course[create][og-title]" class="form-control" id="courseOgTitle" placeholder="Курс по банкротству физических лиц">
          <small hidden id="courseOgTitleHelp" class="form-text text-danger"></small>
        </div>

        <button data-step="4" type="button" class="btn btn-primary nextStep">Продолжить</button>
      </div>

      <div hidden class="write write-5">
        <h2>5. Модули и уроки</h2>
        <div class="form-group">
          <label for="moduleTitle">Название блока</label>
          <input type="text" name="module[create][title]" class="form-control moduleTitle" id="moduleTitle" placeholder="Введение">
          <input type="hidden" name="module[create][link]" class="moduleLink">
          <small hidden id="moduleTitleHelp" class="form-text text-danger"></small>
        </div>
        <div class="form-group">
          <label for="moduleSortOrder">Порядок сортировки</label>
          <input type="number" name="module[create][sort_order]" class="form-control" id="moduleSortOrder" placeholder="Введение">
          <small hidden id="moduleSortOrderHelp" class="form-text text-danger"></small>
        </div>
        <div class="form-group">
          <label for="moduleDescription">Малое описание</label>
          <input type="text" name="module[create][description]" class="form-control" id="moduleDescription" placeholder="Вы узнаете, как создавать рекламные объявления в популярных социальных сетях для конкретной аудитории.">
          <small hidden id="moduleDescriptionHelp" class="form-text text-danger"></small>
        </div>
        <button data-step="5" type="button" class="btn btn-primary nextStep">Продолжить</button>
      </div>
    </form>
  </div>

</div>