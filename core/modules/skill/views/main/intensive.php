<?php
/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;


$this->title = 'Интенсивы SKILL.FORCE';

$js = <<<JS
    $('.searchWord').on('submit', function(e) {
            e.preventDefault();
            $.pjax.reload({
              container: '#webinarContainer',
              url: "intensive",
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
        $('.containerIntensive').on('click', '.moreBtn' ,function() {
            $('.searchWord').submit();
        });
        $('.FiltrReset').on('click', function() {
          $.pjax.reload({
              container: '#webinarContainer',
              url: "intensive",
            });
        });
JS;
$this->registerJs($js);
?>
<section class="S IS">
  <div class="SC ISC df aic">
    <div class="ISC_L">
      <h1 class="ISC_L-title">Новая жизнь — новая профессия</h1>
      <p class="ISC_L-t1">Скидки до 50% на все профессии и курсы</p>
      <a href="<?= Url::to(['profession']) ?>" class="ISC_L-BTN df jcc aic uscp">Выбрать курс</a>
    </div>
  </div>
</section>
<section class="CS2 S">
  <div class="CS2C CS2C2 SC">
    <div class="CS2C__BTop df jcsb">
      <?= Html::beginForm('', 'get', ['class' => 'searchWord', 'id' => 'searchWord']) ?>
      <label class="df InpSearch">
        <input minlength="1" placeholder="продажи" type="text" name="Search" id="qwe">
        <img class="SearchBackIcon1" src="<?= Url::to(['/img/Search.svg']) ?>" alt="icon">
        <img class="SearchBackIcon2" src="<?= Url::to(['/img/SearchFOCUS.svg']) ?>" alt="icon">
      </label>
      <?= Html::endForm(); ?>
      <p class="CS2C__BTop-t">
        Количество интенсивов: <span class="NumHowMany"><?= $intensiveCount ?></span>
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
          <?php print_r($intensive->studentsLevel) ?>
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
          <button class="FiltrReset uscp" type="reset">Сбросить фильтр</button>
        </div>
      </div>
      <div class="CS2C__BB__R-I df fdc jcsb">
        <div class="CS2C__BB__R-I_Int CS2C__BB__R-I_Int2 df fdc jcsb ais">
          <div class="CS2C_BB_R-I_C-ttl_wrap df jcsb">
            <h2 class="CS2C_BB_R-I_C-ttl">
              Интенсивы
            </h2>
            <div class="HLELPicon">
              <img src="<?= Url::to(['/img/help.svg']) ?>" alt="иконка помощи">
              <div class="HLELPicon__block2">
                Короткие программы, чтобы изучить один конкретный навык
              </div>
            </div>
          </div>
          <div class="containerIntensive" style="width: 100%">
            <?php Pjax::begin(['id' => 'webinarContainer']) ?>
            <?php if (!empty($intensive)) : ?>
              <?php foreach ($intensive as $k => $v) : ?>
                <a href="<?= Url::to(['coursepage', 'link' => $v->link, 'back' => $_SERVER['REQUEST_URI']]) ?>" class="CS2C__BB__R-I_Int_C CS2C__BB__R-I_Int_C1 uscp df">
                  <div class="CS2C__BB__R-I_Int_C_L df fdc">
                    <p class="CS2C__BB__R-I_Int_C_L-t1"><?= $v->author->name ?></p>
                    <p class="CS2C__BB__R-I_Int_C_L-t2"><?= $v->author->small_description ?></p>
                  </div>
                  <div class="CS2C__BB__R-I_Int_C_R df fdc">
                    <div class="CS2C__BB__R-I_Int_C_R_C1 df jcsb">
                      <p class="CS2C__BB__R-I_Int_C_R_C1-t1">интенсив</p>
                      <?php if ($v->price == 0) : ?>
                        <p class="CS2C__BB__R-I_Int_C_R_C1-t2">Бесплатно</p>
                      <?php endif; ?>
                    </div>
                    <p class="CS2C__BB__R-I_Int_C_R-t">«<?= $v->name ?>»</p>
                    <div class="CS2C__BB__R-I_Int_C_R_C2 df">
                      <?php if ($v->exist_videos) : ?>
                        <div class="CS2CBBRICC_R-C2-wrt">
                          <img src="<?= Url::to(['/img/Camera-2.svg']) ?>" alt="icon">
                          <p class="CS2CBBRICC_R-C2-t">Видео-лекции</p>
                        </div>
                      <?php endif; ?>
                      <?php if ($v->exist_bonuses) : ?>
                        <div class="CS2CBBRICC_R-C2-wrt CS2CBBRICI_R-C2-wrt">
                          <img src="<?= Url::to(['/img/Trophy.svg']) ?>" alt="icon">
                          <p class="CS2CBBRICC_R-C2-t">Бонусы лучшим</p>
                        </div>
                      <?php endif; ?>
                    </div>
                  </div>
                </a>
              <?php endforeach; ?>
              <?php if ($intensiveCount > 1 && $intensiveCount > $_GET['count']) : ?>
                <input form="searchWord" type="hidden" name="count" value="<?= !empty($_GET['count']) ? $_GET['count'] + 2 : 4 ?>">
                <button class="moreBtn">Еще 2 профессии из <?= $intensiveCount ?></button>
              <?php endif; ?>
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
        </div>
      </div>
    </div>
  </div>
</section>
<section class="S JoinCurOB">
  <div class="JoinCur df aic SC">
    <div class="JoinCur_Text df fdc ais">
      <h2 class="JoinCur_Text-ttl">Не пропустите новые курсы!</h2>
      <p class="JoinCur_Text-t1">Подписывайтесь на бесплатную рассылку с самыми свежими курсами</p>
      <button type="button" class="JoinCur_Text-BTN uscp df jcc aic popup-link">Подписаться</button>
    </div>
  </div>
</section>