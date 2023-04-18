<?php
/* @var $this yii\web\View
 * @var $article \common\models\News
 */

use yii\helpers\Url;

$this->title = $article['title'];
?>

<div class="container">
  <div class="pow articles">
    <div class="rol-3 NavsMenu">
      <aside class="NavsNews">
        <h6>Новости франчайзинга</h6>
        <div class="NavsNews__inner">
          <?php foreach ($news as $key => $item) : ?>
            <div class="newsNav">
              <a target="_blank" class="linkTelega" href="<?= Url::to(['/news-page/' . $item->link]) ?>">
                <p><?= $item->title ?></p>
              </a>
              <hr>
            </div>
          <?php endforeach; ?>
        </div>
      </aside>

      <div class="NavsStat d-None">
        <h6>Популярные статьи</h6>
        <div class="NavsStat__inner">
          <a href="<?= Url::to(['kak-covid-povliyal-na-rasklad-sil']) ?>" class="popularАrticlesCard">
            <img src="<?= Url::to(['/img/Rectangle 46.webp']) ?>" alt="picture of article">
            <p class="cardTextP1">Как COVID-19 повлиял на расклад сил на страховом рынке</p>
            <p class="cardTextP2">Статья по франчайзингу</p>
          </a>
          <a href="<?= Url::to('vidu-franchizy') ?>" class="popularАrticlesCard">
            <img src="<?= Url::to(['/img/Rectangle 46-1.webp']) ?>" alt="picture of article">
            <p class="cardTextP1">Виды франшиз: классификация по характеру взаимоотношений</p>
            <p class="cardTextP2">Статья по франчайзингу</p>
          </a>
        </div>
        <div style="background-image: url('<?= Url::to(['/img/foneing.webp']) ?>')" class="yourCabinet">
          <p class="yourCabinetp1">Ваш личный кабинет MYFORCE</p>
          <p class="yourCabinetp2">Управление сделками. Системный контроль качества заявок и работы
            менеджеров</p>
          <div style="padding: 13px 0">
            <?php if (!$guest) : ?>
              <a href="https://user.myforce.ru/" class="orangeLink">
                <span>Кабинет</span>
                <img src="<?= Url::to(['/img/whiteShape.svg']) ?>" alt="arrow">
              </a>
            <?php else : ?>
              <a class="orangeLink BLS6CBORID-BTN">
                <span>Регистрация</span>
                <img src="<?= Url::to(['/img/whiteShape.svg']) ?>" alt="arrow">
              </a>
            <?php endif; ?>
          </div>
        </div>
      </div>
    </div>
    <div class="rol-9 BodyTexted">
      <div style="background-image: url('<?= Url::to(['/img/Rectangle 178-1.webp']) ?>')" class="photoArticles">
        <h1><?= $article->title ?></h1>
        <h2 class="photoArticlesp2"><?= $article->author ?></h2>

      </div>
      <div class="textArticles">
        <?= $article->content ?>
      </div>
    </div>
  </div>
</div>