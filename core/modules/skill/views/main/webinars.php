<?php
/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;
use core\models\TransformDate;

$date = new TransformDate();
$this->title = 'Вебинары SKILL.FORCE';

$js = <<<JS

    $('.searchWord').on('submit', function(e) {
        e.preventDefault();
        $.pjax.reload({
          container: '#webinarContainer',
          url: "webinars",
          type: "GET",
          data: $('.searchWord').serialize(),
        });
    });
    $('.inpradBTN').on('click', function() {
        setTimeout(function() {
            $('.searchWord').submit();
        }, 300)
    });
    $('.inpradCheck, .inpradCheck__input').on('click', function() {
        setTimeout(function() {
            $('.searchWord').submit();
        }, 300)
    });
    $('.CS2C__BB__R-I_Veb').on('click', '.moreBtn' ,function() {
        $('.searchWord').submit();
    });
    $('.FiltrReset').on('click', function() {
      $.pjax.reload({
          container: '#webinarContainer',
          url: "webinars",
        });
    });
JS;
$this->registerJs($js);
?>
<section class="CS1 S">
  <div class="CS1C df fdc ais jcc SC">
    <p class="CS1C-t1">только до 30 апреля</p>
    <h2 class="CS1C-t2">до — 50% на все профессии и курсы</h2>
    <div class="CS1C-ttl-ob df aic jcc">
      <h1 class="CS1C-ttl">Весеннее предложение</h1>
    </div>
  </div>
</section>
<section class="CS2 S">
  <div class="CS2C SC">
    <div class="CS2C__BTop df jcsb">
      <?= Html::beginForm('', 'get', ['class' => 'searchWord', 'id' => 'searchWord']) ?>
      <label class="df InpSearch">
        <input minlength="1" placeholder="продажи" type="text" name="Search" id="qwe">
        <img class="SearchBackIcon1" src="<?= Url::to(['/img/Search.svg']) ?>" alt="icon">
        <img class="SearchBackIcon2" src="<?= Url::to(['/img/SearchFOCUS.svg']) ?>" alt="icon">
      </label>
      <?= Html::endForm(); ?>
      <p class="CS2C__BTop-t">
        Количество вебинаров: <span class="NumHowMany"><?= $webinarsColl ?></span>
      </p>
    </div>
    <div class="BurgerMenufilterBACK"></div>
    <div class="BurgerMenufilter df uscp">
      <div class="BurgerMenufilterIMG"></div>
      <p>Фильтр</p>
    </div>
    <div class="CS2C__BBotton df jcsb">
      <div class="CS2C__BB__L-F">
        <img src="<?= Url::to(['/img/close.svg']) ?>" class="FiltCloseB">
        <div class="CS2C__BB__L-F-C">
          <p class="CS2C__BB__L-F-C_BTN CS2C__BB__L-F-C_BTN-1 uscp">Направление</p>
          <div class="CS2C__BB__L-F-C_List
                                     CS2C__BB__L-F-C_List-1 df fdc ais">
            <input form="searchWord" class="inpraddisnon" type="radio" value="all" name="direction" id="Dall">
            <label class="inpradBTN uscp" for="Dall">Все направления</label>
            <?php foreach ($directions as $k => $v) : ?>
              <input form="searchWord" class="inpraddisnon" type="radio" value="<?= $v['id'] ?>" name="direction" id="<?= $v['id'] ?>">
              <label class="inpradBTN uscp" for="<?= $v['id'] ?>"><?= $v['name'] ?></label>
            <?php endforeach; ?>
          </div>
          <p class="CS2C__BB__L-F-C_BTN CS2C__BB__L-F-C_BTN-3 uscp">Уровень</p>
          <div class="CS2C__BB__L-F-C_List
                                     CS2C__BB__L-F-C_List-3 df fdc ais">
            <?php foreach ($level as $k => $v) : ?>
              <div class="inpradCheckOB df aic uscp">
                <input class="inpradCheck__input" form="searchWord" type="checkbox" value="<?= $v['student_level'] ?>" name="level" id="LVL<?= $k ?>">
                <label class="inpradCheck uscp" for="LVL<?= $k ?>"><?= $v['student_level'] ?></label>
              </div>
            <?php endforeach; ?>
          </div>
          <p class="CS2C__BB__L-F-C_BTN CS2C__BB__L-F-C_BTN-4 uscp">Стоимость</p>
          <div class="CS2C__BB__L-F-C_List
                                     CS2C__BB__L-F-C_List-4 df fdc ais">
            <div class="inpradCheckOB df aic uscp">
              <input class="inpradCheck__input" form="searchWord" type="checkbox" value="free" name="price" id="P1">
              <label class="inpradCheck uscp" for="P1">Бесплатно (<?= $free ?>)</label>
            </div>
            <div class="inpradCheckOB df aic uscp">
              <input class="inpradCheck__input"  form="searchWord" type="checkbox" value="paid" name="price" id="P2">
              <label class="inpradCheck uscp" for="P2">Платно (<?= $paid ?>)</label>
            </div>
          </div>
          <button class="FiltrReset uscp" type="reset">Сбросить фильтр</button>
        </div>
      </div>
      <div class="CS2C__BB__R-I df fdc jcsb">
        <!--  ВЕБИНАРЫ  -->
        <div class="CS2C__BB__R-I_Veb df fdc jcsb ais">
          <div class="CS2C_BB_R-I_C-ttl_wrap df jcsb">
            <h2 class="CS2C_BB_R-I_C-ttl">
              Вебинары
            </h2>
            <div class="HLELPicon">
              <img src="<?= Url::to(['/img/help.svg']) ?>" alt="icon">
              <div class="HLELPicon__block2">
                Онлайн мероприятие в режиме реального времени
              </div>
            </div>
          </div>
          <?php Pjax::begin(['id' => 'webinarContainer']) ?>
          <?php if (!empty($webinars)) : ?>
            <div class="CS2C__BB__R-I_Veb_vebinars df jcsb">
              <?php foreach ($webinars as $k => $v) : ?>
                <div class="CS2C__BB__R-I_Veb_V df fdc ais">
                  <a href="<?= Url::to(['coursepage', 'link' => $v['link'], 'back' => $_SERVER['REQUEST_URI']]) ?>" class="he-s6__link link">
                    Подробнее
                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                      <path fill-rule="evenodd" clip-rule="evenodd" d="M10.6264 3.95891C11.0169 3.56838 11.6501 3.56838 12.0406 3.95891L17.3739 9.29224C17.7645 9.68277 17.7645 10.3159 17.3739 10.7065L12.0406 16.0398C11.6501 16.4303 11.0169 16.4303 10.6264 16.0398C10.2359 15.6493 10.2359 15.0161 10.6264 14.6256L14.2526 10.9993H3.3335C2.78121 10.9993 2.3335 10.5516 2.3335 9.99935C2.3335 9.44706 2.78121 8.99935 3.3335 8.99935H14.2526L10.6264 5.37312C10.2359 4.9826 10.2359 4.34943 10.6264 3.95891Z" fill="#4135F1"></path>
                    </svg>
                  </a>
                  <img class="CS2C__BB__R-I_Veb_V-IMG" src="<?= Url::to([$v['preview_logo']]) ?>">
                  <p class="CS2C__BB__R-I_Veb_V-t">
                    <?= $v['name'] ?>
                  </p>
                  <?php if (!empty($v['date_meetup'])) : ?>
                    <div class="CS2C__BB__R-I_Veb_V-date df">
                      <img src="<?= Url::to(['/img/empty calendar.svg']) ?>">
                      <p class="CS2C__BB__R-I_Veb_V-date-t">
                        <?= $date->transformDate($v['date_meetup']) ?>
                      </p>
                    </div>
                  <?php endif; ?>
                  <a href="<?= Url::to(['/registr']) ?>" class="CS2C__BB__R-I_Veb_V_BTN uscp df jcc aic">Записаться</a>
                </div>
              <?php endforeach; ?>
              <?php if ($webinarsColl > 1 && $webinarsColl > $_GET['count']) : ?>
                <input form="searchWord" type="hidden" name="count" value="<?= !empty($_GET['count']) ? $_GET['count'] + 2 : 4 ?>">
                <button class="moreBtn">Еще 2 профессии из <?= $webinarsColl ?></button>
              <?php endif; ?>
            </div>
          <?php else : ?>
            <div class="CS2C__BB__R-ERROR_OB">
              <div class="CS2C__BB__R-ERROR df fdc">
                <p class="CS2C__BB__R-ERROR-t1">По вашему запросу ничего не нашлось</p>
                <p class="CS2C__BB__R-ERROR-t2">Попробуйте ввести запрос по-другому</p>
                <img src="<?= Url::to(['/img/CatError.svg']) ?>">
              </div>
            </div>
          <?php endif; ?>
          <?php Pjax::end() ?>
        </div>
        <!--  ВЕБИНАРЫ  -->
      </div>
    </div>
  </div>
</section>