<?php
/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;


$this->title = 'Определите вашу профессию';

$js = <<<JS
    $('.test__form').on('submit', function(e) {
        e.preventDefault();
        $.pjax.reload({
          container: '#webinarContainer',
          url: "test",
          type: "POST",
          data: $('.test__form').serialize(),
        });
    });
JS;
$this->registerJs($js);
?>
<main class="main">
  <div class="test-ask">
    <div class="container">
      <?= Html::beginForm('', 'post', ['class' => 'test__form']) ?>
      <div class="test__wrapp">
        <div class="test__step1">
          <div class="test__linear1 test__linear--1">
          </div>
          <p class="test__title">
            Выберите несколько интересных для вас тем:
          </p>
          <div class="test__inner">
            <div class="test__item">
              <label class="test__label">
                <input id="test1" type="checkbox" name="theme[]" value="Продажи" data-test="cat1" class="test__inp" />
                <p class="test__inp-text">Продажи</p>
              </label>
            </div>

            <div class="test__item">
              <label class="test__label">
                <input id="test2" type="checkbox" name="theme[]" value="Разработка" data-test="cat2" class="test__inp" />
                <p class="test__inp-text">Разработка</p>
              </label>
            </div>

            <div class="test__item">
              <label class="test__label">
                <input id="test3" type="checkbox" name="theme[]" value="Финансы" data-test="cat3" class="test__inp" />
                <p class="test__inp-text">финансы</p>
              </label>
            </div>

            <div class="test__item">
              <label class="test__label">
                <input id="test4" type="checkbox" name="theme[]" value="Маркетинг" data-test="cat4" class="test__inp" />
                <p class="test__inp-text">маркетинг</p>
              </label>
            </div>

            <div class="test__item">
              <label class="test__label">
                <input id="test5" type="checkbox" name="theme[]" value="Управление" data-test="cat5" class="test__inp" />
                <p class="test__inp-text">управление</p>
              </label>
            </div>

            <div class="test__item">
              <label class="test__label">
                <input id="test6" type="checkbox" name="theme[]" value="Бизнес" data-test="cat6" class="test__inp" />
                <p class="test__inp-text">бизнес</p>
              </label>
            </div>

            <div class="test__item">
              <label class="test__label">
                <input id="test7" type="checkbox" name="theme[]" value="Дизайн" data-test="cat7" class="test__inp" />
                <p class="test__inp-text">Дизайн</p>
              </label>
            </div>

            <div class="test__item">
              <label class="test__label">
                <input id="test8" type="checkbox" name="theme[]" value="IT" data-test="cat8" class="test__inp" />
                <p class="test__inp-text">IT</p>
              </label>
            </div>

            <div class="test__item">
              <label class="test__label">
                <input id="test9" type="checkbox" name="theme[]" value="Юриспруденция" data-test="cat9" class="test__inp" />
                <p class="test__inp-text">юриспруденция</p>
              </label>
            </div>

            <div class="test__item">
              <label class="test__label">
                <input id="test10" type="checkbox" name="theme[]" value="Образование" data-test="cat10" class="test__inp" />
                <p class="test__inp-text">образование</p>
              </label>
            </div>

            <div class="test__item">
              <label class="test__label">
                <input id="test11" type="checkbox" name="theme[]" value="Творчество" data-test="cat11" class="test__inp" />
                <p class="test__inp-text">творчество</p>
              </label>
            </div>

            <div class="test__item">
              <label class="test__label">
                <input id="test12" type="checkbox" name="theme[]" value="Софт-скиллы" data-test="cat12" class="test__inp" />
                <p class="test__inp-text">софт-скиллы</p>
              </label>
            </div>
          </div>
          <button type="button" class="test__btn btn btn--arrow-blue">Далее</button>
        </div>
        <div class="test__step2">
          <div class="test__linear2 test__linear--2">
          </div>
          <p class="test__title">
            Выберите виды деятельности, которые вас привлекают
          </p>
          <div class="test__inner">
            <div class="test__item test__item--1">
              <label class="test__label">
                <input type="checkbox" name="view[]" value="управление" class="test__inp" />
                <p class="test__inp-text test__inp-text--1"><span>управление</span></p>
              </label>
            </div>

            <div class="test__item test__item--1">
              <label class="test__label">
                <input type="checkbox" name="view[]" value="образование" class="test__inp" />
                <p class="test__inp-text test__inp-text--2"><span>образование</span></p>
              </label>
            </div>

            <div class="test__item test__item--1">
              <label class="test__label">
                <input type="checkbox" name="view[]" value="творчество" class="test__inp" />
                <p class="test__inp-text test__inp-text--3"><span>творчество</span></p>
              </label>
            </div>

            <div class="test__item test__item--1">
              <label class="test__label">
                <input type="checkbox" name="view[]" value="исследование" class="test__inp" />
                <p class="test__inp-text test__inp-text--4"><span>исследование</span></p>
              </label>
            </div>

            <div class="test__item test__item--1">
              <label class="test__label">
                <input type="checkbox" name="view[]" value="контроль" class="test__inp" />
                <p class="test__inp-text test__inp-text--5"><span>контроль</span></p>
              </label>
            </div>

            <div class="test__item test__item--1">
              <label class="test__label">
                <input type="checkbox" name="view[]" value="защита" class="test__inp" />
                <p class="test__inp-text test__inp-text--6"><span>защита</span></p>
              </label>
            </div>
          </div>
          <button type="button" class="test__btn btn btn--arrow-blue">Далее</button>
        </div>
        <div class="test__step3">
          <div class="test__linear3 test__linear--3">
          </div>
          <p class="test__title">
            Для вас важнее всего:
          </p>
          <div class="test__inner">
            <div class="test__item test__item--2">
              <label class="test__label">
                <input type="checkbox" name="importance[]" value="оформление рабочего места" class="test__inp" />
                <p class="test__inp-text test__inp-text--7"><span>оформление рабочего места</span>
                </p>
              </label>
            </div>

            <div class="test__item test__item--2">
              <label class="test__label">
                <input type="checkbox" name="importance[]" value="отношения в коллективе" class="test__inp" />
                <p class="test__inp-text test__inp-text--8"><span>отношения в коллективе</span></p>
              </label>
            </div>

            <div class="test__item test__item--2">
              <label class="test__label">
                <input type="checkbox" name="importance[]" value="Введение новых технологий и методов" class="test__inp" />
                <p class="test__inp-text test__inp-text--9 test__inp-text--pad"><span>Введение новых технологий и
                    методов</span></p>
              </label>
            </div>

            <div class="test__item test__item--2">
              <label class="test__label">
                <input type="checkbox" name="importance[]" value="Нахождение компромисса в вопросах работы" class="test__inp" />
                <p class="test__inp-text test__inp-text--10 test__inp-text--pad"><span>Нахождение компромисса
                    в вопросах работы</span>
                </p>
              </label>
            </div>
          </div>
          <button class="test__btn-result btn btn--arrow-blue">Получить результат</button>
        </div>
      </div>
      <?= Html::endForm(); ?>
    </div>
  </div>

  <div class="test__resul">
    <section class="test-s1">
      <div class="container">
        <div class="test-s1__inner">
          <a href="#" class="cp-s1__nav">
            Вернуться к каталогу
            <svg width="16" height="13" viewBox="0 0 16 13" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path fill-rule="evenodd" clip-rule="evenodd" d="M7.37361 12.5401C6.98309 12.9306 6.34992 12.9306 5.9594 12.5401L0.626065 7.20678C0.235541 6.81626 0.235541 6.18309 0.626065 5.79257L5.9594 0.459234C6.34992 0.0687095 6.98309 0.0687096 7.37361 0.459234C7.76414 0.849758 7.76414 1.48292 7.37361 1.87345L3.74739 5.49967L14.6665 5.49967C15.2188 5.49967 15.6665 5.94739 15.6665 6.49967C15.6665 7.05196 15.2188 7.49967 14.6665 7.49967L3.74739 7.49967L7.37361 11.1259C7.76414 11.5164 7.76414 12.1496 7.37361 12.5401Z" fill="#5C687E" />
            </svg>

          </a>
          <h1 class="test-s1__title">
            Поздравляем с новой профессией!
          </h1>
          <p class="test-s1__text">
            Мы подобрали курсы, вебинары и интенсивы, которые идеально вам подходят
          </p>
        </div>
      </div>
    </section>

    <section class="test-s2">
      <div class="container">
        <div class="test-s2__inner">
          <div class="test-s2__content">
            <h3 class="test-s2__title">
              Ваш результат
            </h3>
            <p class="test-s2__text">
              Тест выявил у вас склонность к <span id="test-result"></span>. Мы подобрали для вас курсы,
              которые
              помогут развить
              ваши навыки и освоить подходящую профессию.
            </p>
          </div>
        </div>
      </div>
    </section>

    <section class="he-s6 test-s3">
      <div class="container">
        <h2 class="test-s3__title he-s6__title title">
          Курсы для вас
          <span class="tooltip">
            <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M7.9998 15.1998C4.0318 15.1998 0.799805 11.9678 0.799805 7.9998C0.799805 4.0318 4.0318 0.799805 7.9998 0.799805C11.9678 0.799805 15.1998 4.0318 15.1998 7.9998C15.1998 11.9678 11.9678 15.1998 7.9998 15.1998ZM7.9998 2.3998C4.9118 2.3998 2.3998 4.9118 2.3998 7.9998C2.3998 11.0878 4.9118 13.5998 7.9998 13.5998C11.0878 13.5998 13.5998 11.0878 13.5998 7.9998C13.5998 4.9118 11.0878 2.3998 7.9998 2.3998ZM7.9998 12.1598C8.5278 12.1598 8.9598 11.7278 8.9598 11.1998C8.9598 10.6718 8.5278 10.2398 7.9998 10.2398C7.4718 10.2398 7.03981 10.6718 7.03981 11.1998C7.03981 11.7278 7.4718 12.1598 7.9998 12.1598ZM8.7998 8.7998V8.66381C9.7598 8.32781 10.3998 7.4158 10.3998 6.3998C10.3998 5.0798 9.31981 3.9998 7.9998 3.9998C7.0878 3.9998 6.2638 4.5038 5.8558 5.3278C5.6558 5.7198 5.8158 6.1998 6.2158 6.3998C6.6078 6.5998 7.08781 6.4398 7.28781 6.0398C7.42381 5.7678 7.6958 5.5998 7.9998 5.5998C8.43981 5.5998 8.7998 5.9598 8.7998 6.3998C8.7998 6.7358 8.58381 7.0398 8.26381 7.1518C7.62381 7.3758 7.1998 7.98381 7.1998 8.66381V8.7998C7.1998 9.2398 7.5598 9.5998 7.9998 9.5998C8.43981 9.5998 8.7998 9.2398 8.7998 8.7998Z" fill="#000" />
            </svg>
            <span class="tooltiptext">
              Большие образовательные программы, чтобы освоить новую специальность с самого нуля
            </span>
          </span>
        </h2>
        <?php Pjax::begin(['id' => 'webinarContainer']) ?>
        <?php if (!empty($course)) : ?>
          <?php foreach ($course as $key => $value) : ?>
            <?php foreach ($value as $k => $v) : ?>
              <div class="he-s6__inner">
                <div class="he-s6__item test-s3__item" data-category="teg1">
                  <a href="<?= Url::to(['coursepage', 'link' => $v['link']]) ?>" class="he-s6__link link">
                    Подробнее о курсе
                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                      <path fill-rule="evenodd" clip-rule="evenodd" d="M10.6264 3.95891C11.0169 3.56838 11.6501 3.56838 12.0406 3.95891L17.3739 9.29224C17.7645 9.68277 17.7645 10.3159 17.3739 10.7065L12.0406 16.0398C11.6501 16.4303 11.0169 16.4303 10.6264 16.0398C10.2359 15.6493 10.2359 15.0161 10.6264 14.6256L14.2526 10.9993H3.3335C2.78121 10.9993 2.3335 10.5516 2.3335 9.99935C2.3335 9.44706 2.78121 8.99935 3.3335 8.99935H14.2526L10.6264 5.37312C10.2359 4.9826 10.2359 4.34943 10.6264 3.95891Z" fill="#4135F1" />
                    </svg>
                  </a>
                  <div class="he-s6__img">
                    <img src="<?= \common\models\helpers\UrlHelper::admin($v['preview_logo']) ?>" alt="фото" />
                  </div>
                  <div class="he-s6__info">
                    <span class="he-s6__teg teg-b">БФЛ</span>
                    <span class="he-s6__teg teg-i">Интенсив</span>
                    <span class="he-s6__teg teg-s">Продажи</span>
                  </div>
                  <h3 class="he-s6__item-title">
                    <?= $v['name'] ?>
                  </h3>
                  <p class="he-s6__time">
                    Старт 12 марта
                  </p>
                  <a href="<?= Url::to(['/registr']) ?>" class="he-s6__btn btn btn--blue">
                    Записаться
                  </a>
                </div>
              </div>
            <?php endforeach; ?>
          <?php endforeach; ?>
        <?php else :  ?>
          <h3 style="color: grey; margin-bottom: 30px;">Нам не удалось найти подходящие для вас курсы...</h3>
        <?php endif; ?>
        <?php Pjax::end() ?>
      </div>
    </section>

    <section class="test-s4">
      <div class="container">
        <div class="test-s4__inner">
          <div class="test-s4__content">
            <h2 class="test-s4__title title">
              Не пропустите новые курсы!
            </h2>
            <p class="test-s4__text">
              Подписывайтесь на бесплатную рассылку с самыми свежими курсами
            </p>
            <button type="button" class="test-s4__btn btn btn--blue popup-link">
              Подписаться
            </button>
          </div>
        </div>
      </div>
    </section>
  </div>

  <div class="S3">
    <div class="S3C">
      <p class="S3C-t1">Больше о новых курсах и акциях на нашем канале</p>
      <div class="S3C__inner">
        <img src="<?= Url::to(['/img/tg-circle.svg']) ?>">
        <a href="<?= Url::to('https://t.me/myforce_business') ?>" class="uscp S3C-telegramm">
          <p>Подписаться</p>
          <img src="<?= Url::to(['/img/ArrowRightteleg.svg']) ?>">
        </a>
      </div>
    </div>
  </div>

</main> 