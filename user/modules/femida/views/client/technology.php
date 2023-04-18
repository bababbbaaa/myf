<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\Pjax;

$this->title = 'Технологии';

$js = <<< JS
    
    var hash = location.hash.substring(1);
    if (hash == 1){
         $('.my-techno').fadeOut(1, function(){
             $('.all-techno').fadeIn(1);
             $('.techno-top-tab').removeClass('active');
             $('.techno-top-tab1').addClass('active');
         });
    } else if (hash == 2){
         $('.all-techno').fadeOut(1, function(){
             $('.my-techno').fadeIn(1);
             $('.techno-top-tab').removeClass('active');
             $('.techno-top-tab2').addClass('active');
         });
    }
    $('.my-techno-search-form').on('submit', function(e) {
         var page = location.hash.substring(1);
      e.preventDefault();
      $.pjax.reload({
        url: 'technology',
        container: '#technology',
        data: $(this).serialize(),
        type: 'GET',
      }).done(function() {
        location.hash = page;
      })
    });

    $('.techno-top-tab').on('click', function() {
        var id = $(this).attr('data-hash');
        location.hash = id;
    });
JS;
$this->registerJs($js);
?>

<section class="rightInfo">
    <div class="bcr">
        <ul class="bcr__list">
            <li class="bcr__item">
                <a href="<?= Url::to(['']) ?>" class="bcr__link">
                    Технологии
                </a>
            </li>
            <li class="bcr__item">
        <span class="bcr__span">
        Все технологии
        </span>
            </li>
        </ul>
    </div>
    <h1 class="techno_title title-main">Технологии</h1>

    <div class="techno-top">
        <div class="techno-top-tabs">
            <button data-hash="1" type="button" class="techno-top-tab1 techno-top-tab active">
                Все технологии

                <div class="techno-top-fill"></div>
            </button>
            <button data-hash="2" type="button" class="techno-top-tab2 techno-top-tab">
                Мои технологии

                <div class="techno-top-fill"></div>
            </button>
        </div>
        <div class="techno-top-fillbar"></div>
    </div>

    <section data-id="1" class="all-techno">
        <section class="all-techno_container">
            <?php if (!empty($technology)): ?>
                <?php foreach ($technology as $k => $v): ?>
                    <div class="all-techno-item">
                        <div class="techno-link">
                            <a href="<?= Url::to(['technology-page', 'id' => $v['id']]) ?>"
                               class="techno-link_top-link">
                                <div class="techno-link_top-icon"></div>
                                <h2 class="techno-link-title"><?= $v['name'] ?></h2>
                            </a>
                            <p class="techno-link_text"><?= $v['preview'] ?></p>
                            <div class="techno-link_bottom">
                                <?php if (in_array($v['id'], $buy)): ?>
                                    <p class="already-have">Уже у вас</p>
                                <?php endif; ?>
                                <a href="<?= Url::to(['technology-page', 'id' => $v['id']]) ?>"
                                   class="techno-link_bottom-link">подробнее</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </section>

        <section class="benefits">
            <div class="benefits_container">
                <h2 class="benefits-title">Преимущества наших технологий:</h2>
                <ul class="benefits-list">
                    <li class="benefits-list-item">улучшат качество вашей работы</li>
                    <li class="benefits-list-item">увеличат ваш каптал</li>
                    <li class="benefits-list-item">помогут достигнуть высоких целей</li>
                </ul>
                <p class="benefits-text">Наши технологии работы отличаются современным подходом, позволяют решать
                    большинство бизнес проблем, особенно в юридической сфере.
                    <br>
                    <br>
                    Мы делимся накопленным опытом, позволяющим зарабатывать и расти!</p>
            </div>
        </section>
    </section>

    <section data-id="2" class="my-techno">
                <?php Pjax::begin(['id' => 'technology']) ?>
        <div class="my-techno_container">
            <?php if (empty($my_technology)): ?>
                <?= Html::beginForm('', 'get', ['class' => 'my-techno-search-form']) ?>
                <div class="search">
                    <input placeholder="Название или ключевое слово" class="my-techno-search" type="text" name="search">
                    <div class="search-icon"></div>
                </div>
                <?= Html::endForm(); ?>
                <section class="my-techno-dont-have">
                    <div class="my-techno-dont-have_container">
                        <h2 class="my-techno-dont-have-title">
                            У вас еще нет доступных технологий
                        </h2>
                        <p class="my-techno-dont-have-text">
                            Перейдите в раздел <a href="<?= Url::to(['']) ?>">все технологии</a> где вы можете
                            приобрести все необходимые вам технологии
                        </p>
                    </div>
                </section>
            <?php else: ?>
                <?= Html::beginForm('', 'get', ['class' => 'my-techno-search-form']) ?>
                <div class="search">
                    <input placeholder="Название или ключевое слово" class="my-techno-search" type="text" name="search">
                    <div class="search-icon"></div>
                </div>
                <?= Html::endForm(); ?>
                <?php foreach ($my_technology as $k => $v): ?>
                    <div class="my-techno-item">
                        <div class="techno-link">
                            <a href="<?= Url::to(['technology-page', 'id' => $v['id']]) ?>"
                               class="techno-link_top-link">
                                <div class="techno-link_top-icon"></div>
                                <h2 class="techno-link-title"><?= $v['name'] ?></h2>
                            </a>
                            <p class="techno-link_text"><?= $v['preview'] ?></p>
                            <div class="techno-link_bottom">
                                <a href="<?= Url::to(['technology-page', 'id' => $v['id']]) ?>"
                                   class="techno-link_bottom-link">Читать</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
                <?php Pjax::end() ?>
    </section>
</section>