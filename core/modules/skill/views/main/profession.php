<?php
/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;


$this->title = 'Курсы SKILL.FORCE';

$js = <<<JS
    $('.searchWord').on('submit', function(e) {
        e.preventDefault();
        $.pjax.reload({
          container: '#webinarContainer',
          url: "profession",
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
    $('.containerCource').on('click', '.moreBtn' ,function() {
        $('.searchWord').submit();
    });
    $('.FiltrReset').on('click', function() {
      $.pjax.reload({
          container: '#webinarContainer',
          url: "profession",
        });
    });
JS;
$this->registerJs($js);
?>
<section class="S PROFS">
  <div class="SC PROFSC df aic">
    <div class="PROFSC_L df fdc ais">
      <div class="PROFSC_L-upt df aic">
        <img src="<?= Url::to(['/img/Gift.svg']) ?>" alt="icon">
        <p class="PROFSC_L-t2">Смотри первый урок бесплатно</p>
      </div>
      <h1 class="PROFSC_L-title">Как стать <br class="brontitlepro"> SMM-специалистом?</h1>
      <p class="PROFSC_L-t1">И начать зарабатывать от 50 000 ₽ за проект</p>
      <a href="<?= Url::to(['blog', 'Search' => 'smm']) ?>" class="PROFSC_L-BTN df jcc aic uscp">Узнать больше</a>
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
        Количество курсов: <span class="NumHowMany"><?= $courceCount ?></span>
      </p>
    </div>
    <div class="BurgerMenufilterBACK"></div>
    <div class="BurgerMenufilter df uscp">
      <div class="BurgerMenufilterIMG"></div>
      <p>Фильтр</p>
    </div>
    <div class="CS2C__BB__R-I_Part">
      <div class="text__wrappers">
        <h2 class="CS2C__BB__R-I_Part-ttl">Получите работу в командах наших партнеров уже
          <span>через 30 дней</span>
        </h2>
        <p class="CS2C__BB__R-I_Part-t">После окончания курсов трудоустройством вы получаете работу
          в ведущих компаниях страны</p>
      </div>
      <div class="CS2C__BB__R-I_Part-BLOCK df aic">
        <div class="CS2C__BB__R-I_Part-BLOCK-RC df aic jcsb">
          <div class="CS2C__BB__R-I_Part-BLOCK-C1 df fdc aic">
            <img class="CS2C__BB__R-I_Part-BCI-1" src="<?= Url::to(['/img/i1.webp']) ?>">
            <img src="<?= Url::to(['/img/i2.svg']) ?>">
          </div>
          <div class="CS2C__BB__R-I_Part-BLOCK-C2 df fdc aic">
            <img class="CS2C__BB__R-I_Part-BCI-1" src="<?= Url::to(['/img/i3.svg']) ?>">
            <img src="<?= Url::to(['/img/i4.svg']) ?>">
          </div>
        </div>
        <div class="CS2C__BB__R-I_Part-BLOCK-RC2 df aic jcsb">
          <div class="CS2C__BB__R-I_Part-BLOCK-C1 df fdc aic">
            <img class="CS2C__BB__R-I_Part-BCI-1" src="<?= Url::to(['/img/i5.svg']) ?>">
            <img src="<?= Url::to(['/img/i6.svg']) ?>">
          </div>
          <div class="CS2C__BB__R-I_Part-BLOCK-C2 df fdc aic">
            <img class="CS2C__BB__R-I_Part-BCI-1" src="<?= Url::to(['/img/i7.svg']) ?>">
            <img src="<?= Url::to(['/img/i8.svg']) ?>">
          </div>
        </div>
      </div>
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
          <!--                    <div class="inputWorkOB df aic uscp">-->
          <!--                        <input class="inputWork" type="checkbox" value="" name="work" id="work">-->
          <!--                        <label class="inputWork uscp" for="work">С трудоустройством</label>-->
          <!--                    </div>-->
          <p class="CS2C__BB__L-F-C_BTN CS2C__BB__L-F-C_BTN-5 uscp">Трудоустройство</p>
          <div class="CS2C__BB__L-F-C_List
                                    CS2C__BB__L-F-C_List-5 df fdc ais">
            <?php foreach ($partners as $k => $v) : ?>
              <div class="inpradCheckOB df aic uscp">
                <input class="inpradCheck__input" form="searchWord" type="checkbox" value="<?= $v['link'] ?>" name="partner" id="Part<?= $k ?>">
                <label class="inpradCheck uscp" for="Part<?= $k ?>"><?= $v['name'] ?> (<?= $v->courseCount ?>)</label>
              </div>
            <?php endforeach; ?>
          </div>
          <button class="FiltrReset uscp" type="reset">Сбросить фильтр</button>
        </div>
      </div>
      <div class="CS2C__BB__R-I df fdc jcsb">
        <div class="CS2C__BB__R-I_Curs df fdc jcsb ais">
          <div class="CS2C_BB_R-I_C-ttl_wrap df jcsb">
            <h2 class="CS2C_BB_R-I_C-ttl">
              Курсы
            </h2>
            <div class="HLELPicon">
              <img src="<?= Url::to(['/img/help.svg']) ?>" alt="icon">
              <div class="HLELPicon__block">
                Большие образовательные программы, чтобы освоить новую специальность с самого нуля
              </div>
            </div>
          </div>
          <div class="containerCource">
            <?php Pjax::begin(['id' => 'webinarContainer']) ?>
            <?php if (!empty($cource)) : ?>
              <?php foreach ($cource as $k => $v) : ?>
                <a href="<?= Url::to(['coursepage', 'link' => $v->link, 'back' => $_SERVER['REQUEST_URI']]) ?>" class="CS2C_BB_R-I_C-Card CS2C_BB_R-I_C-Card1 df jcsb">
                  <div class="CS2CBBRICC_L df fdc">
                    <div class="CS2CBBRICC_L__img">
                      <img src="<?= Url::to($v->author->photo) ?>" alt="фото автора">
                    </div>
                    <p class="CS2CBBRICC_L-t1">
                      <?= $v->author->name ?>
                    </p>
                    <p class="CS2CBBRICC_L-t2">
                      <?= $v->author->small_description ?>
                    </p>
                  </div>
                  <div class="CS2CBBRICC_R df fdc">
                    <div class="CS2CBBRICC_R-C1 df">
                      <?php $tags = explode(';', $v->tags); ?>
                      <?php foreach ($tags as $key => $val) : ?>
                        <?php if (strlen($val) > 0) : ?>
                          <p class="CS2CBBRICC_R-C1-t<?= $key < 2 ? $key + 1 : '3' ?>"><?= $val ?></p>
                        <?php endif; ?>
                      <?php endforeach; ?>
                    </div>
                    <p class="CS2CBBRICC_R-t1"><?= $v->name ?></p>
                    <p class="CS2CBBRICC_R-t2"><?= $v->content_subtitle ?></p>
                    <div class="CS2CBBRICC_R-C2 df">
                      <div class="CS2CBBRICC_R-C2-wrt">
                        <img src="<?= Url::to(['/img/Paper-2.svg']) ?>" alt="icon">
                        <p class="CS2CBBRICC_R-C2-t">
                          <?php if ($v->lessons_count == 1) : ?>
                            <?= $v->lessons_count ?> урок
                          <?php elseif ($v->lessons_count < 5) : ?>
                            <?= $v->lessons_count ?> урока
                          <?php else : ?>
                            <?= $v->lessons_count ?> уроков
                          <?php endif; ?></p>
                      </div>
                      <?php if ($v->exist_videos) : ?>
                        <div class="CS2CBBRICC_R-C2-wrt">
                          <img src="<?= Url::to(['/img/Camera-2.svg']) ?>" alt="icon">
                          <p class="CS2CBBRICC_R-C2-t">Видео-лекции</p>
                        </div>
                      <?php endif; ?>
                      <?php if ($v->exist_bonuses) : ?>
                        <div class="CS2CBBRICC_R-C2-wrt">
                          <img src="<?= Url::to(['/img/Trophy.svg']) ?>" alt="icon">
                          <p class="CS2CBBRICC_R-C2-t">Бонусы лучшим</p>
                        </div>
                      <?php endif; ?>
                    </div>
                  </div>
                </a>
              <?php endforeach; ?>
              <?php if ($courceCount > 1 && $courceCount > $_GET['count']) : ?>
                <input form="searchWord" type="hidden" name="count" value="<?= !empty($_GET['count']) ? $_GET['count'] + 2 : 4 ?>">
                <button class="moreBtn">Еще 2 профессии из <?= $courceCount ?></button>
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
  <div class="JoinCur JoinCur2 df aic SC">
    <div class="JoinCur_Text df fdc ais">
      <h2 class="JoinCur_Text-ttl">Не пропустите новые курсы!</h2>
      <p class="JoinCur_Text-t1">Подписывайтесь на бесплатную рассылку с самыми свежими курсами</p>
      <button type="button" class="JoinCur_Text-BTN uscp df jcc aic popup-link">Подписаться</button>
    </div>
  </div>
</section>