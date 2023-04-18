<?php
/* @var $this yii\web\View */

use yii\helpers\Url;

$guest = Yii::$app->user->isGuest;
$this->title = 'Мир ждет ваших знаний!';

$js = <<<JS

JS;
$this->registerJs($js);
?>
<section class="PS1 S">
  <div class="PS1C SC df jcsb aic">
    <div class="PS1C_L df fdc ais">
      <h1 class="PS1C_L-t1">Мир ждет ваших знаний!</h1>
      <p class="PS1C_L-t2">Станьте спикером курсов и зарабатывайте, обучая людей по всему миру</p>
      <?php if ($guest) : ?>
        <a href="<?= Url::to(['/registr']) ?>" class="PS1C_L-BTN df aic jcc uscp">Стать преподавателем</a>
      <?php else : ?>
        <a href="<?= Url::to('https://user.myforce.ru/') ?>" class="PS1C_L-BTN df aic jcc uscp">Стать
          преподавателем</a>
      <?php endif; ?>
    </div>
    <div class="PS1C_L-img">
      <img src="<?= Url::to(['/img/PS1.webp']) ?>">
    </div>
  </div>
</section>
<section class="PS2 S">
  <div class="PS2C SC df fdc aic">
    <div class="PS2CB1 df fdc aic">
      <h2 class="PS2CB1-up">Раскройте себя</h2>
      <div class="PS2CB1__down df jcsb">
        <div class="PS2CB1__down_Card">
          <img src="<?= Url::to(['/img/c1.webp']) ?>" class="PS2CB1__down_Card-img">
          <p class="PS2CB1__down_Card-t1">Присоединяйтесь к проекту</p>
          <p class="PS2CB1__down_Card-t2">Мы поможем вам продвигать свой личный бренд.
            <?php if ($guest) : ?>
              <a href="<?= Url::to(['/registr']) ?>">Регистрируйтесь</a>
            <?php else : ?>
              <a href="<?= Url::to('https://user.myforce.ru/') ?>">Регистрируйтесь</a>
            <?php endif; ?>
            в личном кабинете и загружайте свой курс на платформу, а продвижением займемся мы!
          </p>
        </div>
        <div class="PS2CB1__down_Card PS2CB1__down_Card-center">
          <img src="<?= Url::to(['/img/c2.webp']) ?>" class="PS2CB1__down_Card-img">
          <p class="PS2CB1__down_Card-t1">Вдохновляйте студентов</p>
          <p class="PS2CB1__down_Card-t2">Каждый день вы сможете помогать людям начать новую жизнь!</p>
        </div>
        <div class="PS2CB1__down_Card">
          <img src="<?= Url::to(['/img/c3.webp']) ?>" class="PS2CB1__down_Card-img">
          <p class="PS2CB1__down_Card-t1">Зарабатывайте</p>
          <p class="PS2CB1__down_Card-t2">Получайте деньги сразу при каждой покупке вашего курса студентами,
            либо получайте оплату раз в месяц</p>
        </div>
      </div>
    </div>
    <div class="PS2CB2 df fdc aic">
      <h2 class="PS2CB2-up">Ваш успех — в ваших руках</h2>
      <div class="PS2CB2_down df fdc aic">
        <div class="PS2CB2_down-tf df aic">
          <p class="PS2CB2_down-tf_B1">Создайте курс</p>
          <p class="PS2CB2_down-tf_B2">Запишите видео</p>
          <p class="PS2CB2_down-tf_B3">Добавьте курс в проект</p>
        </div>
        <div class="PS2CB2_down-F1">
          <div class="PS2CB2_down-F1-B">
            <div class="PS2CB2_down-F-L">
              <p class="PS2CB2_down-F-t1">Главное — чтобы у вас были знания и желание ими поделиться.</p>
              <p class="PS2CB2_down-F-t2">Создать курс вы можете в рамках нашего
                <?php if ($guest) : ?>
                  <a href="<?= Url::to(['/registr']) ?>">личного
                    кабинета</a>
                <?php else : ?>
                  <a href="<?= Url::to('https://user.myforce.ru/') ?>">личного
                    кабинета</a>
                <?php endif; ?>
                . Там вы соберете всю нужную информацию в одном месте: запись или
                трансляцию урока, задания к нему, домашние задания. А также будете отслеживать
                успеваемость и прогресс студентов.
              </p>
              <?php if ($guest) : ?>
                <a class="PS2CB2_down-F-BTN df aic jcc uscp" href="<?= Url::to(['/registr']) ?>">Создать
                  курс</a>
              <?php else : ?>
                <a class="PS2CB2_down-F-BTN df aic jcc uscp" href="<?= Url::to('https://user.myforce.ru/') ?>">Создать
                  курс</a>
              <?php endif; ?>
            </div>
            <div class="PS2CB2_down-F-R">
              <img src="<?= Url::to(['/img/F1.webp']) ?>">
            </div>
          </div>
        </div>
        <div class="PS2CB2_down-F2">
          <div class="PS2CB2_down-F1-B">
            <div class="PS2CB2_down-F-L">
              <p class="PS2CB2_down-F-t1">Добавляйте в курс уроки и лекции в видео-формате. Такие уроки
                лучше воспринимаются и запоминаются студентами.</p>
              <p class="PS2CB2_down-F-t2">Если у вас нет опыта в записи вебинаров, вы можете просмотреть
                <?php if ($guest) : ?>
                  <a href="<?= Url::to(['/registr']) ?>">курс для профессиональных спикеров</a>.
                <?php else : ?>
                  <a href="<?= Url::to('https://user.myforce.ru/') ?>">курс для профессиональных
                    спикеров</a>.
                <?php endif; ?>
              </p>
              <?php if ($guest) : ?>
                <a class="PS2CB2_down-F-BTN df aic jcc uscp" href="<?= Url::to(['/registr']) ?>">Создать
                  курс</a>
              <?php else : ?>
                <a class="PS2CB2_down-F-BTN df aic jcc uscp" href="<?= Url::to('https://user.myforce.ru/') ?>">Создать
                  курс</a>
              <?php endif; ?>
            </div>
            <div class="PS2CB2_down-F-R">
              <img src="<?= Url::to(['/img/F2.webp']) ?>">
            </div>
          </div>
        </div>
        <div class="PS2CB2_down-F3">
          <div class="PS2CB2_down-F1-B">
            <div class="PS2CB2_down-F-L">
              <p class="PS2CB2_down-F-t2">Загрузите свой курс в
                <?php if ($guest) : ?>
                  <a href="<?= Url::to(['/registr']) ?>">личный
                    кабинет</a>
                <?php else : ?>
                  <a href="<?= Url::to('https://user.myforce.ru/') ?>">личный
                    кабинет</a>
                <?php endif; ?>
                и ожидайте
                своих первых студентов!
              </p>
              <?php if ($guest) : ?>
                <a class="PS2CB2_down-F-BTN df aic jcc uscp" href="<?= Url::to(['/registr']) ?>">Создать
                  курс</a>
              <?php else : ?>
                <a class="PS2CB2_down-F-BTN df aic jcc uscp" href="<?= Url::to('https://user.myforce.ru/') ?>">Создать
                  курс</a>
              <?php endif; ?>
            </div>
            <div class="PS2CB2_down-F-R">
              <img src="<?= Url::to(['/img/F3.webp']) ?>">
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<section class="PS3 S">
  <div class="PS3C SC df fdc aic">
    <h2 class="PS3C-t1">Мы всегда поможем начать</h2>
    <p class="PS3C-t2">Наша команда поддержки преподавателей работает круглосуточно и готова прийти на помощь с
      созданием курса. Нет опыта? Не переживайте! Мы создали <span>специальный курс для спикеров</span> и
      преподавателей, в котором учим вас не только ораторскому мастерству, но и работе с нашим личным кабинетом
    </p>
    <a href="<?= Url::to(['profession']) ?>" class="PS3C-BTN df jcsb aic">
      <p>Перейти к курсу</p>
      <img src="<?= Url::to(['/img/ARB.svg']) ?>">
    </a>
  </div>
</section>
<section class="PS4 S">
  <div class="PS4C SC df fdc aic">
    <?php if (!empty($videoReviews)) : ?>
      <div class="PS4C_B1">
        <div class="PS4C_B1_slider">
          <?php foreach ($videoReviews as $k => $v) : ?>
            <div class="slide-1">
              <div class="B1SS df jcc aic">
                <div class="B1SS_L df jcc aic">
                  <?php parse_str($newLink = parse_url($v['video'], PHP_URL_QUERY), $link); ?>
                  <iframe class="VidInslider" width="560" height="315" src="https://www.youtube.com/embed/<?= $link['v'] ?>" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                </div>
                <div class="B1SS_R">
                  <h2 class="B1SS_R-t1"><?= $v['title'] ?></h2>
                  <p class="B1SS_R-t2"><?= $v['small_description'] ?></p>
                </div>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      </div>
    <?php endif; ?>
    <?php if (!empty($speacker)) : ?>
      <div class="PS4C_B2 df fdc ais">
        <h2 class="PS4C_B2-top-t">Полезное для спикеров</h2>
        <div class="PS4C_B2__FC df aic">
          <?php foreach ($speacker as $k => $v) : ?>
            <div class="PS4C_B2__FC-1">
              <img style="max-width: 225px" src="<?= \common\models\helpers\UrlHelper::admin($v['preview_logo']) ?>" class="PS4C_B2__FC-img">
              <p class="PS4C_B2__FC_t"><?= $v['name'] ?></p>
              <a href="<?= Url::to(['coursepage', 'link' => $v['link']]) ?>" class="PS4C_B2__FC_link uscp df aic jcsb">
                <p>Подробнее о курсе</p>
                <div class="iiiim1"></div>
              </a>
            </div>
          <?php endforeach; ?>
        </div>
      </div>
    <?php endif; ?>
  </div>
</section>