<?php

use yii\helpers\Url;
use yii\helpers\Html;
use common\models\helpers\UrlHelper;

$this->title = $article['name'];
$regions = json_decode($article['regions']);
$advantage = json_decode($article['advantages']);
$number = count($regions);
$this->registerJsFile(Url::to(['/js/seller-range.js']), ['depends' => [\yii\web\JqueryAsset::className()]]);
?>

<section style="min-height: calc(100vh - 480px)" class="section__lead">
  <div class="container">
    <div class="flexed__main">
      <div class="main__desc__popup">
        <a href="<?= Url::to(['/lead/seller/available-offers']) ?>" class="OF__cards-link OF__cards-link--2">
          Вернуться назад
        </a>
        <div class="maindesc__flex--popup">
          <img src="<?= UrlHelper::admin($article['image']) ?>" alt="icon">
          <div>
            <p class="main__desc__popup__p1"><?= $article['category'] ?></p>
            <h1 class="main__desc__popup__p2"><?= $article['name'] ?></h1>
          </div>
        </div>

        <div class="flexed__inner">
          <div class="gray__pop__desc__fone">
            <p>Цена лида</p>
            <p>От <span class="price__pop__p"><?= $article['price'] ?></span> рублей за принятый лид</p>
          </div>

          <div class="gray__pop__desc__fone">
            <?php if ($number == 1) : ?>
              <p>Регион поставки</p>
            <?php else : ?>
              <p>Регионы</p>
            <?php endif; ?>
            <?php foreach ($regions as $key => $item) : ?>
              <span class="regions__pop__p"><?= $item ?></span>
            <?php endforeach; ?>
          </div>
        </div>

        <button class="gray__pop__desc__fone-btn green__btn showsCons">Взять в работу</button>


        <div class="line__for__block">
          <?php foreach ($advantage as $k => $v) : ?>
            <div class="line__arrow__popup">
              <img src="<?= Url::to(['/img/check-lead.png']) ?>" alt="check">
              <p class="advantage__pop__p"><?= $v ?></p>
            </div>
          <?php endforeach; ?>
        </div>
        <div class="main__desc__popup__p3"><?= $article['description'] ?></div>
        <?= Html::beginForm('', 'post', ['id' => 'section__lead']) ?>
        <input type="hidden" name="URL" value="<?= $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] ?>">
        <input type="hidden" name="formType" value="Консультация по офферу">
        <input type="hidden" name="pipeline" value="104">
          <input type="hidden" name="utm_source" value="<?= $_SESSION['utm_source'] ?>">
          <input type="hidden" name="utm_campaign" value="<?= $_SESSION['utm_campaign'] ?>">
        <input type="hidden" name="service" value="">
        <input type="hidden" name="section" value="<?= $article['name'] ?>">
        <div class="Sec5-step1">
          <p class="BLS5CDText-1 BLS5CDText-1--black">Есть вопросы по офферу?</p>
          <div class="Sec5-inputs">
            <input class="Sec5-input fcstlt" type="text" name="fio" placeholder="Имя" required>
            <input class="Sec5-input fcstlt" type="tel" name="phone" placeholder="Телефон" required>

            <button style="padding: 12px 10px;" type="sabmit" class="btn-1">Консультация</button>
          </div>
        </div>
        <div class="Sec5-step2">
          <p class="BLS5CDText-1 BLS5CDText-1--black">Благодарим за заявку!</p>
          <p class="BLS5CDText-2 BLS5CDText-2--black">
            Наш менеждер проконсультирует вас в ближайшее время
          </p>
        </div>
        <?= Html::endForm(); ?>
      </div>

<?php if (!empty($leadType)): ?>
          <div class="TblockFlexSize">
            <h3 class="TblockFlexSize-h3">Ещё лиды из
              этой категории:</h3>
            <div class="card__flex--offer">
              <?php foreach ($leadType as $key => $value) : ?>
                <div class="TL_block1">
                  <a class="TL_block1--link" href="<?= Url::to(['lead-offer', 'link' => $value['link']]) ?>"></a>
                  <div class="TL_block1_1">
                    <img class="TL_img" src="<?= UrlHelper::admin($value['image']) ?>" alt="мешок с $">
                    <p class="TL_p3"><?= $value['category'] ?></p>
                  </div>
                  <div class="TL_p31">
                    <?php $count = count(json_decode($value['regions'])); ?>
                    <?php if ($count == 1) : ?>
                      <?php foreach (json_decode($value['regions']) as $k) : ?>
                        <p class="TL_p3_1"><?= $k ?></p>
                      <?php endforeach; ?>
                    <?php elseif ($count <= 4) : ?>
                      <p class="TL_p3_1"><?= $count ?> города</p>
                    <?php else : ?>
                      <p class="TL_p3_1"><?= $count ?> городов</p>
                    <?php endif; ?>
                    <p class="TL_p3_2"><?= $value['name'] ?></p>
                    <p class="TL_p3_3">от <?= $value['price'] ?> рублей/лид</p>
                  </div>
                </div>
              <?php endforeach; ?>
            </div>
          </div>
<?php endif; ?>

    </div>
</section>

<section class="OF__web">
  <div class="container">
    <div class="OF__web-inner">
      <div class="OF__web-content">
        <h4 class="OF__web-title title">
          Веб-мастеру
        </h4>

        <div class="OF__web-text">
          <p>
            Мы работаем с вебмастерами любого уровня подготовки, к каждому есть индивидуальный подход. Мы поддерживаем
            постоянный
            контакт со всеми веб-мастерами и готовы помочь в любую минуту!
          </p>
          <p>
            Нашей приоритетной задачей является постоянное улучшение CPA-сети, и мы сделаем всё, чтоб вам было
            комфортно работать
            и зарабатывать в LEAD.FORCE
          </p>
        </div>

        <button class="OF__web-btn btn BLS6CBORID-BTN link-on-popap-reg">
          Регистрация в проекте
        </button>
      </div>

      <div class="OF__web-img">
        <img src="<?= Url::to(['/img/of-web.webp']) ?>" alt="web" />
      </div>
    </div>
  </div>
</section>

<section class="OF__info">
  <div class="container">
    <h4 class="OF__info-title title title--center">
      Что вас ждет?
    </h4>
    <p class="OF__info-subtitle subtitle subtitle--center">
      Мы приглашаем вас присоединиться к прогрессивной партнерской сети LEAD.FORCE и начать зарабатывать деньги, уже
      сегодня!
    </p>
    <div class="OF__info-inner">
      <div class="OF__info-item">
        Персональный менеджер, который не оставит без ответа
      </div>

      <div class="OF__info-item">
        Глубокая система аналитики трафика с наглядной статистикой
      </div>

      <div class="OF__info-item">
        Самые быстрые и стабильные выплаты на СРА-рынке
      </div>

      <div class="OF__info-item">
        Выделенный отдел технических специалистов и постоянный саппорт
      </div>

      <div class="OF__info-item">
        Эксклюзивные офферы с премиальными условиями для всех
      </div>

      <div class="OF__info-item">
        Самые высокие отчисления по рынку
      </div>

      <div class="OF__info-item">
        100+ офферов для любого трафика
      </div>

      <div class="OF__info-item">
        Легкая установка пикселей источников трафика (включая Facebook Ads)
      </div>
    </div>
  </div>
</section>

<section class="By__Leads__Sec9">
  <div class="By__Leads__Sec9__content">
    <h3 class="TL_h8v">Рассчитайте свою прибыль<br> и закажите лиды прямо сейчас!</h3>
    <div class="TL_inp8">
      <div class="TL_inp8-content">
        <div class="TL_inputtext flex aic fww">
          <p class="TL_p8">Количество лидов</p>
          <input class="TL_input_text tac number1" type="number" min="100" max="1000" step="100" value="500" id="text">
        </div>
        <input class="TL_input_range" type="range" min="0" max="1000" value="500" step="100" id="slider">

        <div class="TL_p88 flex aic fww">
          <div class="lite__fix">
            <p class="TL_p8">Средний процент конверсии</p>
            <h4 class="TL_h8 TL_h8w number1">9,5%</h4>
          </div>

          <div class="lite__fix">
            <p class="TL_p8">Средняя стоимость лида</p>
            <h4 class="TL_h8 TL_h8w">500 рублей</h4>
          </div>
        </div>
        <div class="TL_inp9 flex fww">
          <h4 class="TL_h8 TL_h8 total">Ваша прибыль</h4>
          <input class="TL_inp9inp tac" type="text" id="result" disabled>
        </div>
      </div>
      <div class="TL_inp8-form">
        <p class="TL_inp8-form-title">
          Закажите лиды прямой сейчас!
        </p>
        <div class="TL_inp8-form-inner">
          <?= Html::beginForm(Url::to(['/site/form']), 'post', ['id' => 'form-TL_inp8']) ?>
          <input type="hidden" name="URL" value="<?= $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] ?>">
          <input type="hidden" name="formType" value="Форма для получения 10 бесплатных лидов">
          <input type="hidden" name="pipeline" value="104">
            <input type="hidden" name="utm_source" value="<?= $_SESSION['utm_source'] ?>">
            <input type="hidden" name="utm_campaign" value="<?= $_SESSION['utm_campaign'] ?>">
          <input type="hidden" name="service" value="">
          <input type="hidden" name="section" value="Рассчитайте свою прибыль и закажите лиды прямо сейчас!">

          <input class="fcstlt TL_inp8-input" required placeholder="Сфера бизнеса" type="text" name="comments[sphere]" id="sphere2">
          <input type="text" required="required" class="TL_inp8-input region fcstlt" placeholder="Ваш регион" name="region" id="region2">
          <input class="fcstlt TL_inp8-input" required pattern="[0-9]*" placeholder="Количество лидов в день" type="text" name="comments[lead_day]" id="lids2">
            <?php if (Yii::$app->user->isGuest):?>
                <a href="<?= Url::to(["/registr-provider?site=lead"])?>" class="btnsbmtfc">Получить</a>
            <?php else:?>
                <button class="btnsbmtfc" type="submit">Получить</button>
            <?php endif?>
          <?= Html::endForm(); ?>
        </div>
      </div>
    </div>
  </div>
</section>