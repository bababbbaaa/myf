<?php

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Аукцион лидов';
$this->registerJsFile(Url::to(['/js/leads-range.js']), ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerCssFile('@web/css/lead.css');
?>
<body>
  <section class="LA__top top">
    <div class="container">
      <div class="LA__top-inner">
        <div class="LA__top-img">
          <img src="<?= Url::to(['/img/LA-top.webp']) ?>" alt="lid" />
        </div>

        <div class="LA__top-content">
          <h1 class="LA__top-title top-title">
            Аукцион лидов
          </h1>

          <p class="LA__top-subtitle top-subtitle">
            Платите за эксклюзивного и качественного <br> клиента сколько считаете нужным
          </p>

          <a href="<?= Url::to(['/registr?site=lead']) ?>" class="LA__top-btn btn">Попробовать</a>
        </div>
      </div>
    </div>
  </section>

  <section class="LA__work">
    <div class="container">
      <div class="LA__work-inner">
        <div class="LA__work-content">
          <h2 class="LA__work-title title">
            Как работает аукцион лидов?
          </h2>

          <p class="LA__work-text">
            На аукционе лидов Вы можете <span>приобрести</span> свежие горячие лиды, на которые в данный момент у нас
            нет покупателей или наши
            действующие клиенты по какой-то причине не смогу у нас их выкупить. Вы можете покупать лиды, пополнив любую
            сумму
            на баланс личного кабинета.
          </p>

          <p class="LA__work-text">
            Либо вы можете <span>продать</span> свои лиды, которые вам оказались не нужны или вы не хотите их
            обрабатывать.
          </p>
        </div>

        <div class="LA__work-img">
          <img src="<?= Url::to(['/img/LA-work.webp']) ?>" alt="card" />
        </div>
      </div>

      <div class="LA__work-row">
        <div class="LA__work-item">
          <p class="LA__work-info">
            Пройдите регистрацию в личном кабинете
          </p>

          <span class="LA__work-num">1</span>
        </div>

        <div class="LA__work-item">
          <p class="LA__work-info">
            Пополняете баланс личного кабинет
          </p>

          <span class="LA__work-num">2</span>
        </div>

        <div class="LA__work-item">
          <p class="LA__work-info">
            Выберите лид, подходящий вашему запросу
          </p>

          <span class="LA__work-num">3</span>
        </div>

        <div class="LA__work-item">
          <p class="LA__work-info">
            Купите лид и заработайте на нем!
          </p>

          <span class="LA__work-num">4</span>
        </div>
      </div>

      <div class="LA__work-inner">
        <div class="LA__work-content">
          <h3 class="LA__title">
            Пример лида
          </h3>

          <p class="LA__work-info">
            Перед покупкой лидов вы будете видеть: источник, регион, сферу, какие типы контактных данных оставил
            потенциальный
            клиент и стоимость лида
          </p>
        </div>

        <div class="LA__work-img">
          <img src="<?= Url::to(['/img/LA-exem.webp']) ?>" alt="card" />
        </div>
      </div>
    </div>
  </section>

  <section class="LA__price">
    <div class="container">
      <h2 class="LA__price-title title">
        Хотите купить горячий лид по самой привлекательной цене сегодня?
      </h2>

      <p class="LA__price-subtitle subtitle">
        Регистрируйтесь в личном кабинете <br> и покупайте готового клиента!
      </p>

      <a href="<?= Url::to(['/registr?site=lead']) ?>" class="LA__price-btn btn">
        Зарегистрироваться
      </a>
    </div>
  </section>

  <section class="LA__sale">
    <div class="container">
      <div class="LA__sale-inner">
        <div class="LA__sale-img">
          <img src="<?= Url::to(['/img/la-sale.webp']) ?>" alt="lid" />
        </div>

        <div class="LA__sale-content">
          <h3 class="LA__sale-title title">
            Есть лишние лиды?
          </h3>

          <p class="LA__sale-subtitle subtitle">
            Не теряйте деньги, если не успеваете обработать лид или не можете помочь клиенту
          </p>

          <p class="LA__sale-text">
            Вы можете продать свои лишние лиды на общем аукционе LEAD.FORCE без потери стоимости
          </p>

          <button class="LA__sale-btn btn showsCons">Узнать больше</button>
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

                      <input class="fcstlt TL_inp8-input" required placeholder="Сфера бизнеса" type="text" name="comments[sphere]" id="sphere2">
                      <input type="text" required="required" class="TL_inp8-input region fcstlt" placeholder="Ваш регион" name="region" id="region2">
                      <input class="fcstlt TL_inp8-input" required pattern="[0-9]*" placeholder="Количество лидов в день" type="text" name="comments[lead_day]" id="lids2">
                      <?php if (Yii::$app->user->isGuest):?>
                          <a href="<?= Url::to(["/registr?site=lead"])?>" class="btnsbmtfc">Получить</a>
                      <?php else:?>
                          <button class="btnsbmtfc" type="submit">Получить</button>
                      <?php endif?>
                      <?= Html::endForm(); ?>
                  </div>
              </div>
          </div>

          <p class="BLS6C__description">
              * - бонус начисляется только при первом пополнение личного кабинета в размере 1000 баллов от 5000 рублей
              пополнения
          </p>
      </div>
  </section>