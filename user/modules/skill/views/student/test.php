<?php

use common\models\helpers\UrlHelper;
use common\models\SkillTrainingsTasksAlias;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;

$this->title = $test->name;
$id = $_GET['id'];
$js = <<< JS

const tasksListElement = document.querySelector('.tasks__list');
// const taskElements = tasksListElement.querySelectorAll('.tasks__item');
if (tasksListElement !== null){
    tasksListElement.addEventListener(`dragstart`, (evt) => {
    evt.target.classList.add(`selected`);
});
tasksListElement.addEventListener(`dragend`, (evt) => {
    evt.target.classList.remove(`selected`);
    evt.target.classList.add(`active`);
});
tasksListElement.addEventListener(`dragover`, (evt) => {
    evt.preventDefault();
    const activeElement = tasksListElement.querySelector(`.selected`);
    const currentElement = evt.target;
    const isMoveable = activeElement !== currentElement &&
        currentElement.classList.contains(`tasks__item`);
    if (!isMoveable) {
        return;
    }
    const nextElement = (currentElement === activeElement.nextElementSibling) ?
        currentElement.nextElementSibling :
        currentElement;
    tasksListElement.insertBefore(activeElement, nextElement);
});
const getNextElement = (cursorPosition, currentElement) => {
    const currentElementCoord = currentElement.getBoundingClientRect();
    const currentElementCenter = currentElementCoord.y + currentElementCoord.height / 2;
    const nextElement = (cursorPosition < currentElementCenter) ?
        currentElement :
        currentElement.nextElementSibling;
    return nextElement;
};
tasksListElement.addEventListener(`dragover`, (evt) => {
    evt.preventDefault();
    const activeElement = tasksListElement.querySelector(`.selected`);
    const currentElement = evt.target;
    const isMoveable = activeElement !== currentElement &&
        currentElement.classList.contains(`tasks__item`);
    if (!isMoveable) {
        return;
    }
    const nextElement = getNextElement(evt.clientY, currentElement);
    if (
        nextElement &&
        activeElement === nextElement.previousElementSibling ||
        activeElement === nextElement
    ) {
        return;
    }
    tasksListElement.insertBefore(activeElement, nextElement);
});
}


//$('.home-work').on('submit', function(e) {
//  e.preventDefault();
//  $.ajax({
//    url: '123',
//    type: 'POST',
//    data: $(this).serialize(),
//  })
//});

var arr = [],
    inputs = $('.assembly__class');
$('.viewcours_test-submit').on('click', function() {
      inputs.each(function(e) {
      var obj = {};
        if ($(this).attr('data-type') === 'text'){
          obj.quess = $(this).attr('data-quess');
          obj.type = $(this).attr('data-type');
          obj.answer = $(this).val();
          arr.push(obj);
        } else if ($(this).attr('data-type') === 'select__list'){
            var arrs = [],
                items = $(this).children('.viewcours_test_group-item').children('.viewcours_test_group-item-label').children('.assembly__class--item');
            obj.quess = $(this).attr('data-quess');
            obj.type = $(this).attr('data-type');
            items.each(function(e) {
                var objs = {};
                objs.type = $(this).attr('data-type');
                objs.answerText = $(this).attr('data-answerText');
                if ($(this).prop('checked') === true){
                    objs.correct = 'true';
                } else {
                    objs.correct = 'false';
                }
                arrs.push(objs);
            });
            obj.answer = arrs;
            arr.push(obj);
        } else if ($(this).attr('data-type') === 'sort__answers'){
            var arrs = [],
                items = $(this).children('.assembly__class--item');
            obj.quess = $(this).attr('data-quess');
            obj.type = $(this).attr('data-type');
            items.each(function(e) {
                var objs = {};
                objs.type = $(this).attr('data-type');
                objs.answerText = $(this).attr('data-answerText');
                arrs.push(objs);
            });
            obj.answer = arrs;
            arr.push(obj);
        } else if ($(this).attr('data-type') === 'correlate'){
           var arrs = [],
               items = $(this).children('.viewcours_test_rows-item').children('.viewcours_test_rows-item-rigth-wrapper-s').children('.assembly__class--item'); 
           obj.quess = $(this).attr('data-quess');
           obj.type = $(this).attr('data-type');
           items.each(function(e) {
             var objs = {};
                objs.quess = $(this).attr('data-quess');
                objs.category = $(this).attr('data-category');
                objs.type = $(this).attr('data-type');
             arrs.push(objs);
           });
           obj.answer = arrs;
           arr.push(obj);
        } else if ($(this).attr('data-type') === 'correlate__image'){
             var arrs = [],
                 items = $(this).children('.viewcours_test_columns-item').children('.viewcours_test_columns-item-img-dropzone').children('.assembly__class--item'); 
             obj.quess = $(this).attr('data-quess');
             obj.type = $(this).attr('data-type');
             items.each(function(e) {
             var objs = {};
                objs.quess = $(this).attr('data-quess');
                objs.category = $(this).attr('data-category');
                objs.type = $(this).attr('data-type');
             arrs.push(objs);
           });
             obj.answer = arrs;
             arr.push(obj);
        }
      });
      arr = JSON.stringify(arr);
      var id = '$id';
      $.ajax({
        url: '/skill/student/check-test',
        data: {json:arr, id:id},
        dataType: 'JSON',
        type: 'POST',
      }).done(function(rsp) {
            location.reload();
      });
});

$('.viewcours_test-again').on('click', function() {
    $('.info__test--count').fadeOut(300, function() {
        $('.viewcours_test').fadeIn(300);
    })
});
JS;
$this->registerJs($js);
$css = <<< CSS
.viewcours_test-radios{
    position: absolute;
    width: 0;
    height: 0;
}
.viewcours_test_group-item-label-text{
    margin-left: 30px;
}
.viewcours_test-radios:before{
    content: '';
    display: block;
    position: absolute;
    width: 16px;
    top: -10px;
    height: 16px;
    border: 1px solid #4135F1;
    border-radius: 4px;
}
.viewcours_test-radios:checked:after{
    content: '';
    display: block;
    position: absolute;
    width: 12px;
    top: -8px;
    height: 12px;
    left: 2px;
    background: #4135F1;
    border: 1px solid #4135F1;
    border-radius: 2px;
}
CSS;
$this->registerCss($css);
?>

<section class="rightInfo education">
    <div class="bcr">
        <ul class="bcr__list">
            <li class="bcr__item">
                <a href="<?= Url::to(['education']) ?>" class="bcr__link">
                    Моё обучение
                </a>
            </li>

            <?php if ($test->training->type === 'Курс'): ?>
                <li class="bcr__item">
                    <a href="<?= Url::to(['mycours', 'link' => $test->training->link]) ?>" class="bcr__link">
                        <?= $test->training->name ?>
                    </a>
                </li>
            <?php elseif ($test->training->type === 'Интенсив'): ?>
                <li class="bcr__item">
                    <a href="<?= Url::to(['myintensiv', 'link' => $test->training->link]) ?>" class="bcr__link">
                        <?= $test->training->name ?>
                    </a>
                </li>
            <?php else: ?>
                <li class="bcr__item">
                    <a href="<?= Url::to(['myvebinar', 'link' => $test->training->link]) ?>" class="bcr__link">
                        <?= $test->training->name ?>
                    </a>
                </li>
            <?php endif; ?>

            <li class="bcr__item">
                <span class="bcr__span nowpagebrc"><?= $test->name ?></span>
            </li>
        </ul>
    </div>
    <p class="type-cours"><?= $test->training->type ?></p>
    <div class="title_row">
        <h1 class="Bal-ttl title-main"><?= $test->training->name ?></h1>
    </div>

    <h2 class="viewcours-title">
        <?= $test->block->sort_order ?>.1 <?= $test->name ?>
    </h2>

    <section class="viewcours_main">
        <article class="viewcours_main_info">
            <?php if (empty($allias)): ?>
                <section class="viewcours_test viewcours-card">
                    <?php $content = json_decode($test->content, 1) ?>
                    <div class="viewcours_home-work_container">
                        <?php if (!empty($content)): ?>
                            <?php foreach ($content as $k => $v): ?>
                                <?php if ($v['type'] === 'text'): ?>
                                    <h3 class="viewcours_test-title"><?= $k + 1 ?>. <?= $v['quess'] ?></h3>
                                    <?php if (!empty($v['image'])): ?>
                                        <div class="viewcours_test-img">
                                            <img src="<?= Url::to('/img/skillclient/ico.svg') ?>" alt="image">
                                        </div>
                                    <?php endif; ?>
                                    <input data-quess="<?= $v['quess'] ?>" data-type="<?= $v['type'] ?>"
                                           class="input-t viewcours_test-input-text assembly__class"
                                           placeholder="Введите текст" type="text"
                                           name="text[<?= $k ?>][]">
                                <?php elseif ($v['type'] === 'select__list'): ?>
                                    <h3 class="viewcours_test-title"><?= $k + 1 ?>. <?= $v['quess'] ?></h3>
                                    <?php if (!empty($v['image'])): ?>
                                        <div class="viewcours_test-img">
                                            <img src="<?= Url::to('/img/skillclient/ico.svg') ?>" alt="image">
                                        </div>
                                    <?php endif; ?>
                                    <ul data-quess="<?= $v['quess'] ?>" data-type="<?= $v['type'] ?>"
                                        class="viewcours_test_group assembly__class">
                                        <?php if (!empty($v['answer'])): ?>
                                            <?php foreach ($v['answer'] as $key => $val): ?>
                                                <?php if ($val['type'] === 'text'): ?>
                                                    <li class="viewcours_test_group-item">
                                                        <label class="viewcours_test_group-item-label">
                                                            <input data-type="<?= $val['type'] ?>"
                                                                   data-answerText="<?= $val['answerText'] ?>"
                                                                   class="viewcours_test-radios assembly__class--item"
                                                                   type="radio" name="select__list[<?= $k ?>][]"
                                                                   value="<?= $val['answerText'] ?>">
                                                            <p class="viewcours_test_group-item-label-text"><?= $val['answerText'] ?></p>
                                                        </label>
                                                    </li>
                                                <?php else: ?>
                                                    <li class="viewcours_test_group-wrap-item">
                                                        <label class="viewcours_test_group-wrap-item-label">
                                                            <input data-type="<?= $val['type'] ?>"
                                                                   data-answerText="<?= $val['answerText'] ?>"
                                                                   class="viewcours_test-radios assembly__class--item"
                                                                   type="radio" name="select__list[<?= $k ?>][]"
                                                                   value="">
                                                            <div class="viewcours_test_group-item-label-img">
                                                                <img src="<?= UrlHelper::admin($val['answerText']) ?>"
                                                                     alt="image">
                                                            </div>
                                                        </label>
                                                    </li>
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </ul>
                                <?php elseif ($v['type'] === 'sort__answers'): ?>
                                    <h3 class="viewcours_test-title"><?= $k + 1 ?>. <?= $v['quess'] ?></h3>
                                    <div class="viewcours_test_rows">
                                        <div class="viewcours_test_rows_laft-wrap">
                                            <?php if (!empty($v['answer'])): ?>
                                                <?php foreach ($v['answer'] as $key => $val): ?>
                                                    <div class="viewcours_test_rows-item-left">
                                                        <?= $key + 1 ?>
                                                    </div>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                        </div>
                                        <div data-quess="<?= $v['quess'] ?>" data-type="<?= $v['type'] ?>"
                                             class="tasks__list assembly__class">
                                            <?php if (!empty($v['answer'])): ?>
                                                <?php shuffle($v['answer']) ?>
                                                <?php foreach ($v['answer'] as $key => $val): ?>
                                                    <div data-type="<?= $val['type'] ?>"
                                                         data-answerText="<?= $val['answerText'] ?>" draggable="true"
                                                         class="tasks__item viewcours_test_rows-item-rigth assembly__class--item">
                                                        <?= $val['answerText'] ?>
                                                    </div>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                <?php elseif ($v['type'] === 'correlate'): ?>

                                    <h3 class="viewcours_test-title"><?= $k + 1 ?>. <?= $v['quess'] ?></h3>
                                    <?php
                                    $category = [];
                                    foreach ($v['answer'] as $key => $val) {
                                        $category[$val['quess']] = $val['category'];
                                    }
                                    ?>
                                    <ul data-type="<?= $v['type'] ?>" data-quess="<?= $v['quess'] ?>"
                                        class="viewcours_test_rows second assembly__class">
                                        <?php if (!empty($category)): ?>
                                            <?php $i = 1 ?>
                                            <?php $cats = array_unique($category); ?>
                                            <?php $vals = array_keys($category); ?>
                                            <?php $arr = []; ?>
                                            <?php foreach ($cats as $val): ?>
                                                <li class="viewcours_test_rows-item second">
                                                    <div class="viewcours_test_rows-item-left category second">
                                                        <?= $val ?>
                                                        <input type="hidden" value="<?= $val ?>"
                                                               name="correlate__category[<?= $k ?>][]">
                                                    </div>
                                                    <div data-category="<?= $val ?>"
                                                         class="viewcours_test_rows-item-rigth-wrapper-s"
                                                         ondragover="onDragOver2(event);"
                                                         ondrop="onDrop2(event);" ondragend="dragEnd2(event);">
                                                    </div>
                                                </li>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </ul>
                                    <div style="display: flex; gap: 10px; flex-wrap: wrap; margin-bottom: 20px;">
                                        <?php foreach ($vals as $keys => $val): ?>
                                            <div data-quess="<?= $val ?>" data-type="text" id="draggable2-<?= $i ?>"
                                                 draggable="true"
                                                 ondragstart="onDragStart2(event);"
                                                 class="viewcours_test_rows-item-rigth second assembly__class--item">
                                                <?= $val ?>
                                            </div>
                                            <?php $i++; ?>
                                        <?php endforeach; ?>
                                    </div>
                                <?php else: ?>
                                    <h3 class="viewcours_test-title"><?= $k + 1 ?>. <?= $v['quess'] ?></h3>
                                    <ul data-type="<?= $v['type'] ?>" data-quess="<?= $v['quess'] ?>"
                                        class="viewcours_test_columns assembly__class">
                                        <?php
                                        $category = [];
                                        $answer = [];
                                        foreach ($v['answer'] as $key => $val) {
                                            $category[] = $val['category'];
                                            $answer[] = $val['quess'];
                                        }
                                        $category = array_unique($category);
                                        ?>
                                        <?php foreach ($category as $keys => $vals): ?>
                                            <li class="viewcours_test_columns-item">
                                                <p class="viewcours_test_columns-item-text">
                                                    <?= $vals ?>
                                                </p>
                                                <div data-category="<?= $vals ?>"
                                                     class="viewcours_test_columns-item-img-dropzone"
                                                     ondragover="onDragOver(event);"
                                                     ondrop="onDrop(event);" ondragend="dragEnd(event);">
                                                </div>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                    <div style="width: 100%; display: flex; gap: 10px; flex-wrap: wrap; margin-bottom: 30px;"
                                         ondragover="onDragOver(event);"
                                         ondrop="onDrop(event);" ondragend="dragEnd(event);">
                                        <?php foreach ($answer as $keys => $vals): ?>
                                            <div data-quess="<?= $vals ?>" data-type="photo"
                                                 style="max-width: 100px; max-height: 100px" id="draggable-<?= $keys ?>"
                                                 draggable="true" ondragstart="onDragStart(event);"
                                                 class="viewcours_test_columns-item-img assembly__class--item">
                                                <img style="width: 100%; height: 100%; object-fit: contain"
                                                     src="<?= UrlHelper::admin($vals) ?>" alt="image">
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        <?php endif; ?>
                        <button class="btn--purple viewcours_test-submit" type="button">Завершить тестирование</button>
                    </div>
                </section>
            <?php else: ?>
                <section style="display: none" class="viewcours_test viewcours-card">
                    <?php $content = json_decode($test->content, 1) ?>
                    <div class="viewcours_home-work_container">
                        <?php if (!empty($content)): ?>
                            <?php foreach ($content as $k => $v): ?>
                                <?php if ($v['type'] === 'text'): ?>
                                    <h3 class="viewcours_test-title"><?= $k + 1 ?>. <?= $v['quess'] ?></h3>
                                    <?php if (!empty($v['image'])): ?>
                                        <div class="viewcours_test-img">
                                            <img src="<?= Url::to('/img/skillclient/ico.svg') ?>" alt="image">
                                        </div>
                                    <?php endif; ?>
                                    <input data-quess="<?= $v['quess'] ?>" data-type="<?= $v['type'] ?>"
                                           class="input-t viewcours_test-input-text assembly__class"
                                           placeholder="Введите текст" type="text"
                                           name="text[<?= $k ?>][]">
                                <?php elseif ($v['type'] === 'select__list'): ?>
                                    <h3 class="viewcours_test-title"><?= $k + 1 ?>. <?= $v['quess'] ?></h3>
                                    <?php if (!empty($v['image'])): ?>
                                        <div class="viewcours_test-img">
                                            <img src="<?= Url::to('/img/skillclient/ico.svg') ?>" alt="image">
                                        </div>
                                    <?php endif; ?>
                                    <ul data-quess="<?= $v['quess'] ?>" data-type="<?= $v['type'] ?>"
                                        class="viewcours_test_group assembly__class">
                                        <?php if (!empty($v['answer'])): ?>
                                            <?php foreach ($v['answer'] as $key => $val): ?>
                                                <?php if ($val['type'] === 'text'): ?>
                                                    <li class="viewcours_test_group-item">
                                                        <label class="viewcours_test_group-item-label">
                                                            <input data-type="<?= $val['type'] ?>"
                                                                   data-answerText="<?= $val['answerText'] ?>"
                                                                   class="viewcours_test-radios assembly__class--item"
                                                                   type="radio" name="select__list[<?= $k ?>][]"
                                                                   value="<?= $val['answerText'] ?>">
                                                            <p class="viewcours_test_group-item-label-text"><?= $val['answerText'] ?></p>
                                                        </label>
                                                    </li>
                                                <?php else: ?>
                                                    <li class="viewcours_test_group-wrap-item">
                                                        <label class="viewcours_test_group-wrap-item-label">
                                                            <input data-type="<?= $val['type'] ?>"
                                                                   data-answerText="<?= $val['answerText'] ?>"
                                                                   class="viewcours_test-radios assembly__class--item"
                                                                   type="radio" name="select__list[<?= $k ?>][]"
                                                                   value="">
                                                            <div class="viewcours_test_group-item-label-img">
                                                                <img src="<?= UrlHelper::admin($val['answerText']) ?>"
                                                                     alt="image">
                                                            </div>
                                                        </label>
                                                    </li>
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </ul>
                                <?php elseif ($v['type'] === 'sort__answers'): ?>
                                    <h3 class="viewcours_test-title"><?= $k + 1 ?>. <?= $v['quess'] ?></h3>
                                    <div class="viewcours_test_rows">
                                        <div class="viewcours_test_rows_laft-wrap">
                                            <?php if (!empty($v['answer'])): ?>
                                                <?php foreach ($v['answer'] as $key => $val): ?>
                                                    <div class="viewcours_test_rows-item-left">
                                                        <?= $key + 1 ?>
                                                    </div>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                        </div>
                                        <div data-quess="<?= $v['quess'] ?>" data-type="<?= $v['type'] ?>"
                                             class="tasks__list assembly__class">
                                            <?php if (!empty($v['answer'])): ?>
                                                <?php shuffle($v['answer']) ?>
                                                <?php foreach ($v['answer'] as $key => $val): ?>
                                                    <div data-type="<?= $val['type'] ?>"
                                                         data-answerText="<?= $val['answerText'] ?>" draggable="true"
                                                         class="tasks__item viewcours_test_rows-item-rigth assembly__class--item">
                                                        <?= $val['answerText'] ?>
                                                    </div>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                <?php elseif ($v['type'] === 'correlate'): ?>

                                    <h3 class="viewcours_test-title"><?= $k + 1 ?>. <?= $v['quess'] ?></h3>
                                    <?php
                                    $category = [];
                                    foreach ($v['answer'] as $key => $val) {
                                        $category[$val['quess']] = $val['category'];
                                    }
                                    ?>
                                    <ul data-type="<?= $v['type'] ?>" data-quess="<?= $v['quess'] ?>"
                                        class="viewcours_test_rows second assembly__class">
                                        <?php if (!empty($category)): ?>
                                            <?php $i = 1 ?>
                                            <?php $cats = array_unique($category); ?>
                                            <?php $vals = array_keys($category); ?>
                                            <?php $arr = []; ?>
                                            <?php foreach ($cats as $val): ?>
                                                <li class="viewcours_test_rows-item second">
                                                    <div class="viewcours_test_rows-item-left category second">
                                                        <?= $val ?>
                                                        <input type="hidden" value="<?= $val ?>"
                                                               name="correlate__category[<?= $k ?>][]">
                                                    </div>
                                                    <div data-category="<?= $val ?>"
                                                         class="viewcours_test_rows-item-rigth-wrapper-s"
                                                         ondragover="onDragOver2(event);"
                                                         ondrop="onDrop2(event);" ondragend="dragEnd2(event);">
                                                    </div>
                                                </li>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </ul>
                                    <div style="display: flex; gap: 10px; flex-wrap: wrap; margin-bottom: 20px;">
                                        <?php foreach ($vals as $keys => $val): ?>
                                            <div data-quess="<?= $val ?>" data-type="text" id="draggable2-<?= $i ?>"
                                                 draggable="true"
                                                 ondragstart="onDragStart2(event);"
                                                 class="viewcours_test_rows-item-rigth second assembly__class--item">
                                                <?= $val ?>
                                            </div>
                                            <?php $i++; ?>
                                        <?php endforeach; ?>
                                    </div>
                                <?php else: ?>
                                    <h3 class="viewcours_test-title"><?= $k + 1 ?>. <?= $v['quess'] ?></h3>
                                    <ul data-type="<?= $v['type'] ?>" data-quess="<?= $v['quess'] ?>"
                                        class="viewcours_test_columns assembly__class">
                                        <?php
                                        $category = [];
                                        $answer = [];
                                        foreach ($v['answer'] as $key => $val) {
                                            $category[] = $val['category'];
                                            $answer[] = $val['quess'];
                                        }
                                        $category = array_unique($category);
                                        ?>
                                        <?php foreach ($category as $keys => $vals): ?>
                                            <li class="viewcours_test_columns-item">
                                                <p class="viewcours_test_columns-item-text">
                                                    <?= $vals ?>
                                                </p>
                                                <div data-category="<?= $vals ?>"
                                                     class="viewcours_test_columns-item-img-dropzone"
                                                     ondragover="onDragOver(event);"
                                                     ondrop="onDrop(event);" ondragend="dragEnd(event);">
                                                </div>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                    <div style="width: 100%; display: flex; gap: 10px; flex-wrap: wrap; margin-bottom: 30px;"
                                         ondragover="onDragOver(event);"
                                         ondrop="onDrop(event);" ondragend="dragEnd(event);">
                                        <?php foreach ($answer as $keys => $vals): ?>
                                            <div data-quess="<?= $vals ?>" data-type="photo"
                                                 style="max-width: 100px; max-height: 100px" id="draggable-<?= $keys ?>"
                                                 draggable="true" ondragstart="onDragStart(event);"
                                                 class="viewcours_test_columns-item-img assembly__class--item">
                                                <img style="width: 100%; height: 100%; object-fit: contain"
                                                     src="<?= UrlHelper::admin($vals) ?>" alt="image">
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        <?php endif; ?>
                        <button class="btn--purple viewcours_test-submit" type="button">Завершить тестирование</button>
                    </div>
                </section>
                <div class="info__test--count">
                    <h3 class="viewcours_test-title">Ваш результат</h3>
                    <p class="viewcours_test-result">
                        <?= $allias['result'] ?>
                    </p>
                    <button class="btn--purple viewcours_test-again" type="button">Пройти снова</button>
                </div>

            <?php endif; ?>
        </article>

        <aside class="viewcours-structure">
            <div class="viewcours-structure_main">
                <div class="viewcours-structure_container">
                    <h3 class="viewcours-structure-titel">Структура</h3>
                    <ul class="viewcours-structure-list">
                        <?php if (!empty($blocksLessons)): ?>
                            <?php foreach ($blocksLessons as $k => $v): ?>
                                <li class="viewcours-structure-list-item">
                                    <a class="" href="<?= Url::to(['lesson', 'id' => $v['id']]) ?>">
                                        <h4 class="viewcours-structure-list-item-title"><?= $test->block->sort_order . '.' . $v['sort_order'] . ' ' . $v['name'] ?></h4>
                                        <div class="viewcours-structure-list-item-indicator"></div>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        <?php endif; ?>
                        <?php if (!empty($blocksTasks)): ?>
                            <?php foreach ($blocksTasks as $k => $v): ?>
                                <li class="viewcours-structure-list-item">
                                    <a href="<?= Url::to(['task', 'id' => $v['id']]) ?>">
                                        <h4 class="viewcours-structure-list-item-title"><?= $test->block->sort_order ?>
                                            .<?= count($blocksLessons) + $k + 2 ?> Задание</h4>
                                        <?php
                                        $status = SkillTrainingsTasksAlias::find()->select('status')
                                            ->where(['task_id' => $v['id']])
                                            ->andWhere(['user_id' => Yii::$app->getUser()->getId()])
                                            ->asArray()
                                            ->one();
                                        switch ($status['status']) {
                                            case 'Отправленно' || 'Доработка':
                                                $color = 'orange';
                                                break;
                                            case 'Не зачет':
                                                $color = 'red';
                                                break;
                                        }
                                        ?>
                                        <div class="viewcours-structure-list-item-indicator text <?= $color ?>"><?= $status['status'] ?></div>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        <?php endif; ?>
                        <?php if (!empty($blocksTests)): ?>
                            <?php foreach ($blocksTests as $k => $v): ?>
                                <li class="viewcours-structure-list-item">
                                    <a class="" href="<?= Url::to(['test', 'id' => $v['id']]) ?>">
                                        <h4 class="viewcours-structure-list-item-title"><?= $test->block->sort_order ?>
                                            .<?= count($blocksLessons) + count($blocksTasks) + $k + 2 ?> <?= $v['name'] ?></h4>
                                        <div class="viewcours-structure-list-item-indicator"></div>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </aside>
        </aside>
    </section>
</section>

<script>
    function onDragStart2(event) {
        event
            .dataTransfer
            .setData('text/plain', event.target.id);

        setTimeout(function () {
            document.querySelector('.viewcours_test_columns');
        }, 0);
    }

    function onDragOver2(event) {

        $('.viewcours_test_rows-item-rigth-wrapper-s').removeClass('active');
        event.target.classList.add('active');
        event.preventDefault();
    }

    function dragEnd2(event) {
        event.target.classList.add('active');
        $('.viewcours_test_columns-item-img-dropzone').removeClass('active');
        document.querySelector('.viewcours_test_columns');
    }

    function onDrop2(event) {
        $('.viewcours_test_columns-item-img-dropzone').removeClass('active');
        const id = event
            .dataTransfer
            .getData('text');
        const draggableElement = document.getElementById(id);
        const dropzone = event.target;
        console.log('2');
        if (dropzone.classList.contains('viewcours_test_rows-item-rigth-wrapper-s')) {
            dropzone.appendChild(draggableElement);
            event
                .dataTransfer
                .clearData();
            var data = dropzone.getAttribute('data-category');
            draggableElement.setAttribute('data-category', data);

        } else {
            dropzone.parentElement.appendChild(draggableElement);
            event
                .dataTransfer
                .clearData();
        }
    }
</script>

<script>
    function onDragStart(event) {
        event
            .dataTransfer
            .setData('text/plain', event.target.id);

        setTimeout(function () {
            event.target.classList.add('hide');
            document.querySelector('.viewcours_test_rows.second').classList.add('disabled');
        }, 0);
    }

    function onDragOver(event) {
        $('.viewcours_test_columns-item-img-dropzone').removeClass('active');
        event.target.classList.add('active');
        event.preventDefault();
    }

    function dragEnd(event) {
        $('.viewcours_test_rows-item-rigth-wrapper-s').removeClass('active');
        event.target.classList.remove('hide');
        document.querySelector('.viewcours_test_rows.second').classList.remove('disabled');
    }

    function onDrop(event) {
        $('.viewcours_test_columns-item-img-dropzone').removeClass('active');
        const id = event
            .dataTransfer
            .getData('text');
        const draggableElement = document.getElementById(id);
        draggableElement.classList.remove('hide');
        const dropzone = event.target;
        console.log('1');
        if (dropzone.classList.contains('viewcours_test_columns-item-img-dropzone')) {
            dropzone.appendChild(draggableElement);
            event
                .dataTransfer
                .clearData();
            var data = dropzone.getAttribute('data-category');
            draggableElement.setAttribute('data-category', data);
        } else {
            dropzone.parentElement.appendChild(draggableElement);
            event
                .dataTransfer
                .clearData();
        }
    }
</script>