<?php

use yii\helpers\Url;
use yii\helpers\HTML;
use common\models\helpers\UrlHelper;

$this->title = "Вакансия {$job['position']} от компании {$job['company_name']}";
$id = $job['id'];
$js = <<< JS
$('.vacancy-reply').on('click', function() {
  var id = '$id';
  $.ajax({
    url: '/skill/student/respond',
    data: {id:id},
    type: 'POST',
    dataType: 'JSON',
  }).done(function(rsp) {
    console.log(rsp);
    if (rsp.status === 'success'){
        setTimeout(function() {
            location.reload();
        }, 500);
    } if (rsp.status === 'error'){
        location.reload()
    }
  })
});
JS;
$this->registerJs($js);

?>

<section class="rightInfo">
    <div class="bcr">
        <ul class="bcr__list">
            <a href="<?= Url::to(['careercenter']) ?>" class="bcr__item">
                <span class="bcr__link">
                Центр карьеры
                </span>
            </a>

            <li class="bcr__item">
                <a href="<?= Url::to(['careercenter', '#' => 'page2']) ?>" class="bcr__link">
                    Вакансии
                </a>
            </li>

            <li class="bcr__item">
                <span class="bcr__span">
                    <?= $job['position'] ?>
                </span>
            </li>
        </ul>
    </div>

    <div class="title_row">
        <h1 class="Bal-ttl title-main"><?= $job['position'] ?></h1>
    </div>

    <section class="vebinar_notif-pop-back">
        <div class="vebinar_notif-pop-wrap">
            <div class="vebinar_notif-pop">
                <button class="pop-close"></button>

                <img src="<?= Url::to('/img/skillclient/nice-done.svg') ?>" alt="angle">
                <h3 class="vebinar_notif-pop-title">Отклик отправлен</h3>
                <p class="vebinar_notif-pop-text">Ваше резюме отправлено на почту компании. Менеджер свяжется с вами по
                    указанным вами контактным данным</p>
                <button class="vebinar_notif-pop-btn btn--purple">Спасибо</button>
            </div>
        </div>
    </section>

    <article class="vacancy_container">
        <div class="vacancy_top">
            <div class="vacancy_top_left">
                <h2 class="vacancy_top_left-title"><?= $job['company_name'] ?></h2>
                <a class="link--purple" style="margin-bottom: 8px;"
                   href="https://<?= $job['site'] ?>"><?= $job['site'] ?></a>
                <p class="vacancy_top_left-city"><?= $job['city'] ?></p>
                <?php if (empty($rsp)): ?>
                    <button style="max-width: fit-content;"
                            class="btn--purple vacancy-reply"
                            type="button">Откликнуться
                    </button>
                <?php else: ?>
                    <p class="vacancy-reply-done">Вы откликнулись</p>
                <?php endif; ?>
            </div>
            <img src="<?= UrlHelper::admin($job['logo']) ?>" alt="<?= $job['company_name'] ?>">
        </div>

        <div class="vacancy_row">
            <p><?= $job['type_employment'] ?></p>
            <p><?= $job['work_format'] ?></p>
        </div>

        <?php if (!empty($job['duties'])): ?>
            <h3 class="vacancy-subtitle">Обязанности</h3>
            <?php $vac = json_decode($job['duties'], 1) ?>
            <ul class="vacancy-text">
                <?php foreach ($vac as $v): ?>
                    <li><?= $v ?></li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>

        <?php if (!empty($job['requirements'])): ?>
            <h3 class="vacancy-subtitle">Требования</h3>
            <?php $req = json_decode($job['requirements'], 1) ?>
            <ul class="vacancy-text">
                <?php foreach ($req as $v): ?>
                    <li><?= $v ?></li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
        <?php if (!empty($job['working_conditions'])): ?>
            <h3 class="vacancy-subtitle">Условия работы</h3>
            <?php $work = json_decode($job['working_conditions'], 1) ?>
            <ul class="vacancy-text">
                <?php foreach ($work as $v): ?>
                    <li><?= $v ?></li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>

        <?php if (empty($rsp)): ?>
            <button style="max-width: fit-content;" class="btn--purple vacancy-reply"
                    type="button">Откликнуться
            </button>
        <?php endif; ?>
    </article>
</section>