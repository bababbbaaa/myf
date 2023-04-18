<?php
/* @var $this yii\web\View */

use yii\helpers\Url;
use yii\widgets\Pjax;


$this->title = 'Начни карьеру вместе с SKILL.FORCE';

$js = <<<JS
    $('.avatar__item').on('click', function() {
      var id = $(this).attr('data-id');
      $.pjax.reload({
          container: '#partners',
          url: "career",
          type: "post",
          data: {id:id},
        });
    });
JS;
$this->registerJs($js);
?>
<main class="main">
  <section class="car-s1">
    <div class="container">
      <div class="car-s1__inner">
        <h1 class="car-s1__title">
          Начни карьеру вместе с SKILL.FORCE
        </h1>
        <p class="car-s1__text">
          Чтобы наши студенты применили полученные знания на практике и нашли работу мечты, мы запустили курсы
          с гарантированным
          трудоустройством
        </p>
        <a href="<?= Url::to(['profession']) ?>" class="PROFSC_L-BTN df jcc aic uscp">Подобрать курс</a>
      </div>
    </div>
  </section>

  <section class="car-s2">
    <div class="container">
      <div class="car-s2__inner">
        <h2 class="car-s2__title title">
          Как работает центр планирования карьеры SKILL.FORCE
        </h2>
        <p class="car-s2__text">
          Студентам помогаем найти работу, а компаниям — специалистов: менеджеров, маркетологов,
          программистов,
          дизайнеров,
          юристов
        </p>
      </div>

      <div class="car-s2__wrap">
        <div class="car-s2__item">
          <h3 class="car-s2__item-title">
            1. Выбираете курс
          </h3>
          <p class="car-s2__item-text">
            Выберите самостоятельно или <a href="<?= Url::to(['test']) ?>" class="car-s2__item-link">пройдите
              тест</a> для
            определения
            профессии
          </p>
        </div>

        <div class="car-s2__item">
          <h3 class="car-s2__item-title car-s2__item-title--2">
            2. Успешно проходите обучение
          </h3>
          <p class="car-s2__item-text">
            Участвуйте в лекциях, выполняйте задания от куратора в личном кабинете
          </p>
        </div>

        <div class="car-s2__item">
          <h3 class="car-s2__item-title car-s2__item-title--3">
            3. Ваше резюме получают компании-партнеры
          </h3>
          <p class="car-s2__item-text">
            Во время курса мы помогаем вам составить резюме, и отправляем его нашим партнерам
          </p>
        </div>

        <div class="car-s2__item">
          <h3 class="car-s2__item-title car-s2__item-title--4">
            4. Проходите собеседование в компании вашей мечты
          </h3>
          <p class="car-s2__item-text">
            Мы расскажем на что на самом деле смотрят рекрутеры и какие компетенции они проверяют,
            а вы получите
            работу в одной
            из ведущих компаний страны
          </p>
        </div>
      </div>

      <div class="car-s2__work">
        <div class="car-s2__work-content">
          <h2 class="car-s2__work-title title">
            Лучшие выпускники попадут на работу в <span>MY.FORCE</span>
          </h2>

          <p class="car-s2__work-text">
            <span>MY.FORCE</span> — крупнейший сервис развития бизнеса в России. Шесть лет на рынке.
            Выпускники
            получат возможность
            отработать
            полученные знания и начать строить свою карьеру
          </p>
          <a href="<?= Url::to(['profession']) ?>" class="PROFSC_L-BTN df jcc aic uscp">Выбрать курс</a>
        </div>
        <div class="car-s2__work-img">
          <img src="<?= Url::to(['/img/car-s3-photo.webp']) ?>" alt="фото выпускников" />
        </div>
      </div>

      <div class="car-s2__part">
        <h2 class="car-s2__part-title title">
          Кто наши партнеры?
        </h2>
        <div class="car-s2__part-inner">
          <div class="car-s2__part-content">
            <?php Pjax::begin(['id' => 'partners']) ?>
            <div class="car-s2__part-info active">
              <?= $this->render('_info-partner', ['partnerInfo' => $partnerInfo]) ?>
            </div>
            <?php Pjax::end() ?>
          </div>

          <div class="car-s2__part-avatar avatar">
            <?php foreach ($partner as $k => $v) : ?>
              <div data-id="<?= $v['id'] ?>" class="avatar__item avatar__item--<?= $k + 1 ?>">
                <div class="avatar__img avatar__img--<?= $k + 1 ?>">
                  <img src="<?= \common\models\helpers\UrlHelper::admin($v['photo']) ?>" alt="<?= $v['name'] ?>" />
                </div>
                <span class="avatar__info"><?= $v['name'] ?></span>
              </div>
            <?php endforeach; ?>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section class="car-s3">
    <div class="container">
      <h2 class="car-s3__title title">
        Наши выпускники стоят свою карьеру в <span>лучших компаниях</span>
      </h2>
      <div class="car-s3__inner">
        <div class="car-s3__com">
          <img src="<?= Url::to(['/img/com-1.webp']) ?>" alt="логотип компании">
        </div>
        <div class="car-s3__com">
          <img src="<?= Url::to(['/img/com-2.webp']) ?>" alt="логотип компании">
        </div>
        <div class="car-s3__com">
          <img src="<?= Url::to(['/img/com-3.webp']) ?>" alt="логотип компании">
        </div>
        <div class="car-s3__com">
          <img src="<?= Url::to(['/img/com-4.webp']) ?>" alt="логотип компании">
        </div>
        <div class="car-s3__com">
          <img src="<?= Url::to(['/img/com-5.webp']) ?>" alt="логотип компании">
        </div>
        <div class="car-s3__com">
          <img src="<?= Url::to(['/img/com-6.webp']) ?>" alt="логотип компании">
        </div>
        <div class="car-s3__com">
          <img src="<?= Url::to(['/img/com-7.webp']) ?>" alt="логотип компании">
        </div>
        <div class="car-s3__com">
          <img src="<?= Url::to(['/img/com-8.webp']) ?>" alt="логотип компании">
        </div>
        <div class="car-s3__com">
          <img src="<?= Url::to(['/img/com-9.webp']) ?>" alt="логотип компании">
        </div>
        <div class="car-s3__com">
          <img src="<?= Url::to(['/img/com-10.webp']) ?>" alt="логотип компании">
        </div>
        <div class="car-s3__com">
          <img src="<?= Url::to(['/img/com-11.webp']) ?>" alt="логотип компании">
        </div>
        <div class="car-s3__com">
          <img src="<?= Url::to(['/img/com-12.webp']) ?>" alt="логотип компании">
        </div>
      </div>

      <?php if (!empty($reviews)) : ?>
        <h2 class="car-s3__coments-title title">
          Смените профессию вместе со SKILL.FORCE
        </h2>

        <div class="car-s3__coments-slider">
          <?php foreach ($reviews as $k => $v) : ?>
            <div class="car-s3__coments coments">
              <div class="coments__inner">
                <div class="coments__avatar coments__avatar--car">
                  <img src="<?= \common\models\helpers\UrlHelper::admin($v['photo']) ?>" alt="фото" class="coments__img">
                </div>

                <p class="coments__name">
                  <?= $v['name'] ?>
                </p>

                <p class="coments__post">
                  <?= $v['whois'] ?>
                </p>

                <p class="coments__text coments__text--car">
                  <?= $v['content'] ?>
                </p>

                <time class="coments__data" datetime="2020-12-14">
                  <?= date('d.m.Y', strtotime($v['date'])) ?>
                </time>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      <?php endif; ?>
    </div>
  </section>

  <?php if (!empty($garantCources)) : ?>
    <section class="car-s4 he-s8">
      <div class="container">
        <h2 class="car-s4__title title">
          Курсы с гарантированным трудоустройством
        </h2>
        <p class="car-s4__subtitle">
          Мы поможем вам найти работу еще во время обучения
        </p>

        <div class="car-s4__inner">
          <?php foreach ($garantCources as $k => $v) : ?>
            <?php
            $lessons_count = $v['lessons_count'];
            $tags = explode(';', $v['tags']);
            ?>
            <div class="car-s4__item">
              <div class="car-s4__item-top">
                <span class="car-s4__prof">
                  Профессия
                </span>
                <span class="car-s4__time">
                  <?php if ($lessons_count == 1) : ?>
                    <?= $lessons_count ?> час
                  <?php elseif ($lessons_count < 5) : ?>
                    <?= $lessons_count ?> часа
                  <?php else : ?>
                    <?= $lessons_count ?> часов
                  <?php endif; ?>
                </span>
              </div>

              <h3 class="car-s4__item-title">
                <?= $v['name'] ?>
              </h3>
              <p class="car-s4__item-text">
                <?= $v['content_block_description'] ?>
              </p>

              <div class="car-s4__nav">
                <?php foreach ($tags as $key => $value) : ?>
                  <span class="car-s4__info <?= $key % 2 == 0 ? 'market' : '' ?>"><?= $value ?></span>
                <?php endforeach; ?>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      </div>
    </section>
  <?php endif; ?>

</main>