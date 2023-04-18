<?php
/* @var $this yii\web\View */

use yii\helpers\Url;

$guest = Yii::$app->user->isGuest;
$this->title = 'SKILL.FORCE — образовательный портал';

$js = <<<JS

JS;
$this->registerJs($js);
?>
<section class="S S1">
    <div class="S1C SC df jcsb">
        <div class="S1C__L df fdc">
            <a href="<?= Url::to(['index']) ?>" class="S1C__L-brc df uscp">
                <div class="Back__Cut__Arrow"></div>
                <p class="S1C__L-brc-text">Вернуться к каталогу</p>
            </a>
            <h1 class="S1C__L-ttl">SKILL.FORCE — образовательный портал</h1>
            <p class="S1C__L-text">Мы помогаем осваивать проффесии с нуля. Проводим онлайн-интенсивы и бесплатные
                вебинары, тестирования, чтобы каждый мог выбрать дело своей жизни</p>
        </div>
        <div class="S1C__R">
            <img src="<?= Url::to(['/img/S1C.svg']) ?>" class="S1C__R-img">
        </div>
    </div>
</section>

<section class="S S2">
  <div class="S2C SC df fdc">
    <div class="S2C__B1">
      <h2 class="S2C__B1-ttl">Больше новых профессий</h2>
      <div class="S2C__B1__Cards Flex__wraps-block df">
        <?php foreach ($category as $k => $v) : ?>
<?php if (!empty($v->skillTrainingsCourseCount) || !empty($v->skillTrainingsIntensiveCount) || !empty($v->skillTrainingsWebCount)): ?>
              <a href="<?= Url::to(['profession', 'Search' => '', 'direction' => ++$k ]) ?>" class="uscp S2C__B1__C-C CardF-1">
                <p class="S2C__B1__C-C-t"><?= $v->name ?></p>
                <div class="S2C__B1__C-C-undt df aic">
                  <?php switch ($v->skillTrainingsCourseCount) {
                    case $v->skillTrainingsCourseCount == 1:
                      $word = 'курс';
                      break;
                    case $v->skillTrainingsCourseCount < 5:
                      $word = 'курсa';
                      break;
                    case $v->skillTrainingsCourseCount >= 5:
                      $word = 'курсов';
                      break;
                  } ?>
                  <p class="S2C__B1__C-C-undt-t"><?= $v->skillTrainingsCourseCount ?> <?= $word ?></p>
                  <?php if (!empty($v->skillTrainingsIntensiveCount)) : ?>
                    <div class="S2C__B1__C-C-undt-dot"></div>
                    <?php switch ($v->skillTrainingsIntensiveCount) {
                      case $v->skillTrainingsIntensiveCount == 1:
                        $word = 'интенсив';
                        break;
                      case $v->skillTrainingsIntensiveCount < 5:
                        $word = 'интенсива';
                        break;
                      case $v->skillTrainingsIntensiveCount >= 5:
                        $word = 'интенсивов';
                        break;
                    } ?>
                    <p class="S2C__B1__C-C-undt-t"><?= $v->skillTrainingsIntensiveCount ?> <?= $word ?></p>
                  <?php endif; ?>
                  <?php if (!empty($v->skillTrainingsWebCount)) : ?>
                    <div class="S2C__B1__C-C-undt-dot"></div>

                    <?php switch ($v->skillTrainingsWebCount) {
                      case $v->skillTrainingsWebCount == 1:
                        $word = 'вебинар';
                        break;
                      case $v->skillTrainingsWebCount < 5:
                        $word = 'вебинара';
                        break;
                      case $v->skillTrainingsWebCount >= 5:
                        $word = 'вебинаров';
                        break;
                    } ?>
                    <p class="S2C__B1__C-C-undt-t"><?= $v->skillTrainingsWebCount ?> вебинара</p>
                  <?php endif; ?>
                </div>
                  </a>
<?php endif; ?>
        <?php endforeach; ?>
      </div>
    </div>
    <div class="S2C__B2 df jcsb aic">
      <div class="S2C__B2-L">
        <img src="<?= Url::to(['/img/Mfoto.svg']) ?>" class="S2C__B2-L-img">
      </div>
      <div class="S2C__B2-R df fdc ais jcc">
        <img src="<?= Url::to(['/img/zi.svg']) ?>" class="S2C__B2-R-ttimg">
        <p class="S2C__B2-R-t1">Мы вдохновлены тем, что нам удаётся менять жизнь сотен тысяч людей и повышать
          уровень образования в стране. И уверены, что сможем добиться большего, так как у онлайн‑образования
          огромный потенциал</p>
        <p class="S2C__B2-R-t2">Мирослав Масальский, основатель MYFORCE</p>
      </div>
    </div>
    <div class="S2C__B3 df jcsb aic">
      <div class="S2C__B3__L df fdc ais jcsb">
        <h2 class="S2C__B3__L-ttl">Лучшее место для профессионального роста</h2>
        <p class="S2C__B3__L-t">Для своих преподавателей мы проводим мастер-классы, развиваем сообщество,
          помогаем начать. Вы вместе с нами будете осваивать новые методики для поднятия эффективности
          обучения.</p>
        <?php if ($guest): ?>
            <a href="<?= Url::to(['/registr']) ?>" class="uscp df jcc aic S2C__B3__L-BTN">Присоедениться к команде</a>
        <?php else: ?>
            <a href="<?= Url::to('https://user.myforce.ru/') ?>" class="uscp df jcc aic S2C__B3__L-BTN">Присоедениться к команде</a>
        <?php endif; ?>
      </div>
      <div class="S2C__B3__R df fdc aic jcc">
        <div class="S2C__B3__R-top">
          <img src="<?= Url::to(['/img/001.jpg']) ?>" class="S2C__B3__R-top-img" alt="фото работников">
        </div>
        <div class="S2C__B3__R-under df jcsb aic">
          <div class="S2C__B3__R-under-bimg-1">
            <img src="<?= Url::to(['/img/002.png']) ?>" class="S2C__B3__R-under-img-1" alt="image">
          </div>
          <div class="S2C__B3__R-under-bimg-2">
            <img src="<?= Url::to(['/img/003.png']) ?>" class="S2C__B3__R-under-img-2" alt="image">
          </div>
        </div>
      </div>
    </div>
    <div class="S2C__B4 df fdc">
      <div class="S2C__B4__top df aic">
        <iframe class="topVid-1" width="555" height="322" src="https://www.youtube.com/embed/LEbBBUqs0kY" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
        <iframe class="topVid-2" width="555" height="322" src="https://www.youtube.com/embed/06vQUbftz2s" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
        <div class="S2C__B4__top_info df fdc">
          <h2 class="S2C__B4__top_info-t1">
            Начните строить карьеру вместе с нами
          </h2>
          <p class="S2C__B4__top_info-t2">
            У нас прикладные курсы и программы от главных экспертов рынка, актуальные подходы к обучению,
            работа над реальными проектами, стажировки.
          </p>
        </div>
      </div>
      <div class="S2C__B4__bott df aic">
        <div class="S2C__B4__bott_info df fdc">
          <h2 class="S2C__B4__bott_info-t1">
            Ты добьешься успеха!
          </h2>
          <p class="S2C__B4__bott_info-t2">
            Всех наших студентов объеденяет одно — добиться большего, чем они имеют сейчас. Не важно с каким
            уровнем вы придете к нам, мы выведем вас на тот, который позволит комфортно чувствовать себя
            в новой профессии и добиваться каждый день чего-то большего!
          </p>
        </div>
        <iframe class="topVid-1" width="555" height="322" src="https://www.youtube.com/embed/uJ_fkNmhrVQ" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
        <iframe class="topVid-2" width="555" height="322" src="https://www.youtube.com/embed/WvfBNsMajr0" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
      </div>
    </div>
    <div class="S2C__B5 df aic jcsb">
      <div class="S2C__B5__L">
        <h2 class="S2C__B5__L-ttl">Помогаем студентам найти работу мечты</h2>
        <p class="S2C__B5__L-t">После окончания курсов с трудойстройством вы получаете работу в ведущих
          компаниях страны</p>
        <a href="<?= Url::to(['profession']) ?>" class="he-s6__link link">
          Выбрать курс
          <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd" clip-rule="evenodd" d="M10.6264 3.95891C11.0169 3.56838 11.6501 3.56838 12.0406 3.95891L17.3739 9.29224C17.7645 9.68277 17.7645 10.3159 17.3739 10.7065L12.0406 16.0398C11.6501 16.4303 11.0169 16.4303 10.6264 16.0398C10.2359 15.6493 10.2359 15.0161 10.6264 14.6256L14.2526 10.9993H3.3335C2.78121 10.9993 2.3335 10.5516 2.3335 9.99935C2.3335 9.44706 2.78121 8.99935 3.3335 8.99935H14.2526L10.6264 5.37312C10.2359 4.9826 10.2359 4.34943 10.6264 3.95891Z" fill="#4135F1"></path>
          </svg>
        </a>
      </div>
      <div class="S2C__B5__R df">
        <div class="S2C__B5__R-C1 df fdc aic jcsb">
          <img src="<?= Url::to(['/img/i1.svg']) ?>">
          <img class="S2C__B5__R-C1-img_center" src="<?= Url::to(['/img/i2.svg']) ?>">
          <img src="<?= Url::to(['/img/i3.svg']) ?>">
        </div>
        <div class="S2C__B5__R-C2 df fdc aic jcsb">
          <img src="<?= Url::to(['/img/i4.svg']) ?>">
          <img class="S2C__B5__R-C1-img_center" src="<?= Url::to(['/img/i5.svg']) ?>">
          <img src="<?= Url::to(['/img/i6.svg']) ?>">
        </div>
        <div class="S2C__B5__R-C3 df fdc aic jcsb">
          <img src="<?= Url::to(['/img/i7.svg']) ?>">
          <img class="S2C__B5__R-C1-img_center" src="<?= Url::to(['/img/i8.svg']) ?>">
          <img src="<?= Url::to(['/img/i9.svg']) ?>">
        </div>
      </div>
    </div>
  </div>
</section>
<section class="S S3">
  <div class="S3C SC df aic jcc">
    <p class="S3C-t1">Больше о новых курсах и акциях на нашем канале</p>
    <div class="df jcsb aic">
      <img src="<?= Url::to(['/img/tg-circle.svg']) ?>">
      <a href="<?= Url::to('https://t.me/myforce_business') ?>" class="S3C-telegramm uscp df aic jcsb">
        <p>Подписаться</p>
        <img src="<?= Url::to(['/img/Arrow Rightteleg.svg']) ?>">
      </a>
    </div>
  </div>
</section>