<?php

use yii\helpers\Url;
use common\models\helpers\UrlHelper;

$this->title = 'Отдел клиентского сервиса БФЛ';

$js = <<< JS
$('.buy-techno').on('click', function() {
    var id = $(this).attr('data-id');
  $.ajax({
    url: '../buy-technology',
    data: {id: id},
    dataType: 'JSON',
    type: 'POST',
  }).done(function(rsp) {
    if (rsp.status === 'success'){
        Swal.fire({
          icon: 'success',
          title: 'Технология успешно куплена',
          text: 'Поздравляем вас с преобритением этой технологии',
        }).then(function() {
          location.reload();
        })
    } else if (rsp.status === 'error' && rsp.message === 'Недостаточно средств на балансе'){
        Swal.fire({
          icon: 'error',
          title: rsp.message,
          text: 'Перейти к пополнению баланса?',
        }).then(function(result) {
          if (result.value === true){
              location.href = "../balance";
          }
        })
    } else  {
        Swal.fire({
          icon: 'error',
          title: 'Произошла ошибка',
          text: rsp.message,
        })
    }
  })
});
JS;
$this->registerJsFile(Yii::$app->request->baseUrl . '/js/alert.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJs($js);
?>

<section class="rightInfo">
    <div class="bcr">
        <ul class="bcr__list">
            <li class="bcr__item">
                <a href="<?= Url::to(['technology']) ?>" class="bcr__link">
                    Технологии
                </a>
            </li>
            <li class="bcr__item">
                <a href="<?= Url::to(['technology']) ?>" class="bcr__link">
                    Все технологии
                </a>
            </li>
            <li class="bcr__item">
        <span class="bcr__span">
            <?= $item['name'] ?>
        </span>
            </li>
        </ul>
    </div>

    <article class="techology">
        <section class="techology_top">
            <div class="techology_top-column">
                <h1 class="techology_top-title">
                    <?= $item['name'] ?>
                </h1>
                <p class="techology_top-under-title">
                    <?= $item['subtitle'] ?>
                </p>
                <p class="techology_top-text"><?= $item['preview'] ?></p>
                <?php if (empty($buy) && !empty($item['price'])): ?>
                    <a class="catalog__cards-btn" href="#buy">Купить технологию</a>
                <?php endif; ?>
            </div>
            <div style="background-image: url(<?= UrlHelper::admin($item['first_image']) ?>);" class="judge-bro"></div>
        </section>

        <?php if (!empty($item['essence'])): ?>
            <section class="techology-essence">
                <div style="background-image: url(<?= UrlHelper::admin($item['second_image']) ?>);"
                     class="interview-bro"></div>

                <div class="techology-essence-info">
                    <h2 class="techology-essence-title">Суть технологии:</h2>
                    <p class="techology-essence-text"><?= $item['essence'] ?></p>
                </div>
            </section>
        <?php endif; ?>

        <?php if (!empty($item['first_section_advantage'])): ?>
            <?php $first = json_decode($item['first_section_advantage'], 1) ?>
            <section class="technology-allow">
                <h2 class="technology-allow-title">
                    <?= $first['title'] ?>
                </h2>

                <div class="technology-allow-list">
                    <?php if ($first['advantage']): ?>
                        <?php foreach ($first['advantage'] as $k => $v): ?>
                            <div class="technology-allow-list-item-info">
                                <?= $v ?>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </section>
        <?php endif; ?>

        <?php if (!empty($item['second_section_advantage'])): ?>
            <section class="technology-included">
                <?php $second = json_decode($item['second_section_advantage'], 1) ?>
                <h2 class="technology-included-title">
                    <?= $second['title'] ?>
                </h2>
                <div class="technology-included-list">
                    <?php if ($second['advantage']): ?>
                        <?php foreach ($second['advantage'] as $k => $v): ?>
                            <div class="technology-included-list-item-info">
                                <?= $v ?>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </section>
        <?php endif; ?>

        <section class="implemented-technology">
            <h2 class="implemented-technology-title">Кто уже внедрил клиентский сервис:</h2>
            <div class="implemented-technology-box">
                <div class="implemented-technology-box-item"></div>
                <div class="implemented-technology-box-item"></div>
                <div class="implemented-technology-box-item"></div>
                <div class="implemented-technology-box-item"></div>
                <div class="implemented-technology-box-item"></div>
                <div class="implemented-technology-box-item"></div>
                <div class="implemented-technology-box-item"></div>
                <div class="implemented-technology-box-item"></div>
            </div>
        </section>

        <?php if (!empty($item['important'])): ?>
            <section class="technology-important">
                <div class="technology-important_container">
                    <div class="technology-important_info">
                        <h2 class="technology-important_info-title">
                            Важно:
                        </h2>
                        <p class="technology-important_info-text">
                            <?= $item['important'] ?>
                        </p>
                    </div>
                </div>
            </section>
        <?php endif; ?>

        <?php if (empty($buy) && !empty($item['price'])): ?>
            <section class="technology-buy">
                <div class="technology-buy_left">
                    <h2 class="technology-buy_left-title">
                        Мы предоставляем лучшую технологию работы с Отделом клиентского сервиса БФЛ!
                    </h2>
                    <!--                <h3 class="technology-buy_left-subtitle">-->
                    <!--                    Купите выгодное решение проблем со скидкой до 50%.-->
                    <!--                </h3>-->
                </div>
                <a id="buy"></a>
                <div class="technology-buy_right">
                    <p class="technology-buy_right-prise">
                        Стоимость: <span><?= number_format($item['price'], 0, ' ', ' ') ?> руб.</span>
                    </p>
                    <a data-id="<?= $item['id'] ?>" class="buy-techno catalog__cards-btn">Купить технологию</a>
                    <!--                <a class="technology-buy_right-link" href="-->
                    <? //= Url::to(['']) ?><!--">Купить со скидкой</a>-->
                </div>
            </section>
        <?php endif; ?>

    </article>
</section>