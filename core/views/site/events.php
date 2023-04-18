<?php


/* @var $this yii\web\View */

use yii\helpers\Url;
use yii\widgets\LinkPager;
use yii\helpers\Html;
use yii\widgets\Pjax;

$this->title = 'Все мероприятия';
$js = <<<JS
        $($filter).prop('checked',true).trigger("refresh");
JS;

$this->registerJs($js);

?>

<section class="article-1 article-1--ceys">
  <div class="article_content">
    <nav class="breadcrumbs">
      <a href="<?= Url::to(['/']) ?>">Главная</a>
      <img src="<?= Url::to(['img/mainimg/angle right.svg']) ?>" alt="arrow">
      <a>Мероприятия</a>
    </nav>
  </div>
</section>
<?php Pjax::begin(['enablePushState' => true]);?>
<div class="miting">
  <div class="container">
    <section class="news-ttl-filtr news-ttl-filtr--mit">
      <h1 class="ttl"> Все мероприятия</h1>
      <h2 class="t1"> Акции, скидки, события — все в одном месте</h2>
      <div class="news-ttl-filtr_G">
        <?= Html::beginForm(['site/events'], 'get', ['enctype' => 'multipart/form-data','class' => 'FormFiltr','data-pjax'=>1]) ?>
        <div class="news-ttl-filtr_G-F">
<!--          <input checked class="FiltrRadio" type="radio" value="all" name="filters[type]" id="all">-->
<!--          <label class="FiltrBTN" for="all">Все</label>-->
          <input checked class="FiltrRadio" type="radio" value="miting" name="filters[type]" id="miting">
          <label class="FiltrBTN" for="miting">Мероприятия</label>
          <input class="FiltrRadio" type="radio" value="sale" name="filters[type]" id="sale">
          <label class="FiltrBTN" for="sale">Акции</label>
          <input class="FiltrRadio" type="radio" value="events" name="filters[type]" id="events">
          <label class="FiltrBTN" for="events">События</label>
        </div>
        <?= Html::endForm(); ?>
        <p class="number">Количество: <span class="num"><?= $num ?></span></p>
      </div>
    </section>

      <div class="activity__wrap">
          <div class="activity__column">
              <?php foreach ($events as $event):?>
                    <?php if ($filter === "miting" || empty($filter)):?>
                        <article class="activity__item">
                          <a href="<?= Url::to(['site/event-page','link' => $event['link']]) ?>" class="activity__item-links"></a>
                          <div class="activity__item-img">
                              <img src="<?= Url::to([$event["img"]])?>" alt="изображение мероприятия" />
                          </div>
                          <p class="activity__item-groop">
                              <?= $event["category"]?>
                          </p>

                          <div class="activity__item-content">
                              <h3 class="activity__item-title">
                                  <?= $event["name"]?>
                              </h3>
                              <p class="activity__item-text">
                                  <?= $event["preview_text"]?>
                              </p>
                          </div>

                          <div class="activity__item-add">
                              <div class="activity__item-box">
                                  <span class="activity__item-span">
                                      <?php
                                        $startDate = $event["event_date"];
                                        $finishDate = $event["event_finish_date"];
                                        if (date("m",strtotime($startDate)) === date("m",strtotime($finishDate))){
                                            echo rdate("d",strtotime($startDate),1);
                                        } else {
                                            echo rdate("d f",strtotime($startDate),1);
                                        }
                                          echo " - ";
                                          echo rdate("d f",strtotime($finishDate),1);
                                      ?>
                                  </span>
                                  <span class="activity__item-span activity__item-span--city">г. <?= $event["event_city"]?></span>
                              </div>
                              <a href="<?= Url::to(['site/event-page','link' => $event['link']]) ?>" class="activity__item-link">
                                  <span>Подробнее</span>
                                  <svg width="20" height="21" viewBox="0 0 20 21" fill="none" xmlns="http://www.w3.org/2000/svg">
                                      <path fill-rule="evenodd" clip-rule="evenodd" d="M10.803 4.63666C11.0959 4.34377 11.5708 4.34377 11.8637 4.63666L17.197 9.97C17.4899 10.2629 17.4899 10.7378 17.197 11.0307L11.8637 16.364C11.5708 16.6569 11.0959 16.6569 10.803 16.364C10.5102 16.0711 10.5102 15.5962 10.803 15.3033L14.856 11.2503H3.33337C2.91916 11.2503 2.58337 10.9145 2.58337 10.5003C2.58337 10.0861 2.91916 9.75033 3.33337 9.75033H14.856L10.803 5.69732C10.5102 5.40443 10.5102 4.92956 10.803 4.63666Z" fill="#E44E2B" />
                                  </svg>
                              </a>
                          </div>
                      </article>
                    <?php elseif ($filter === "sale"):?>
                        <article class="s2__item" style="background-image: url(<?= $event["img"]?>)">
                          <a href="<?= Url::to(['site/sale-page',"link"=>$event["link"]]) ?>" class="s2__item-link"></a>
                          <div class="s2__item-content">
                              <div class="s2__item-inner">
                                  <span class="s2__item-stock">
                                    до окончания
                                      <span class="s2__item-day">
                                          <?php $days = date_diff(new DateTime($event["event_finish_date"]), new DateTime())->days?>
                                          <?= $days?>
                                      </span>
                                            <?php
                                                switch ($days){
                                                    case 1:
                                                        echo "день";
                                                        break;
                                                    case 2; case 3;case 4:
                                                        echo "дня";
                                                        break;
                                                    default:
                                                        echo "дней";
                                                        break;
                                                }
                                            ?>
                                      <span class="s2__item-hour">
                                           <?php $hours = date_diff(new DateTime($event["event_finish_date"]), new DateTime())->h?>
                                          <?= date_diff(new DateTime($event["event_finish_date"]), new DateTime())->h?>
                                      </span>
                                           <?php
                                           switch ($hours){
                                               case 1:
                                                   echo "час";
                                                   break;
                                               case 2; case 3;case 4:
                                                   echo "часа";
                                                   break;
                                               default:
                                                   echo "часов";
                                                   break;
                                           }
                                           ?>
                                  </span>
                              </div>
                              <div class="s2__item-box">
                                  <?php $text_color = json_decode($event["text_color"])?>
                                  <h3 class="s2__item-title" style="color: <?=$text_color->header?>">
                                      <?= $event["name"]?>
                                  </h3>
                                  <p class="s2__item-subtitle"  style="color: <?=$text_color->body?>">
                                      <?= $event["preview_text"] ?>
                                  </p>
                              </div>
                              <div class="s2__item-btn">
                                  <a href="<?= Url::to(['site/sale-page',"link"=>$event["link"]]) ?>">Подробнее</a>
                              </div>
                          </div>
                       </article>
                    <?php elseif ($filter === "events"):?>
                        <article class="events__item" style="background-image: url(<?= $event["img"]?>);">
                          <a href="<?= Url::to(['site/occasion-page','link'=>$event["link"]]) ?>" class="events__item-links"></a>
                          <h3 class="events__item-title">
                              <?= $event["name"]?>
                          </h3>
                          <p class="events__item-text">
                              <?= $event["preview_text"]?>
                          </p>
                          <a href="<?= Url::to(['site/occasion-page','link'=>$event["link"]]) ?>" class="events__item-link">
                              <span>Подробнее</span>
                              <svg width="20" height="21" viewBox="0 0 20 21" fill="none" xmlns="http://www.w3.org/2000/svg">
                                  <path fill-rule="evenodd" clip-rule="evenodd" d="M10.803 4.63666C11.0959 4.34377 11.5708 4.34377 11.8637 4.63666L17.197 9.97C17.4899 10.2629 17.4899 10.7378 17.197 11.0307L11.8637 16.364C11.5708 16.6569 11.0959 16.6569 10.803 16.364C10.5102 16.0711 10.5102 15.5962 10.803 15.3033L14.856 11.2503H3.33337C2.91916 11.2503 2.58337 10.9145 2.58337 10.5003C2.58337 10.0861 2.91916 9.75033 3.33337 9.75033H14.856L10.803 5.69732C10.5102 5.40443 10.5102 4.92956 10.803 4.63666Z" fill="#E44E2B" />
                              </svg>
                          </a>
                      </article>
                    <?php endif;?>
              <?php endforeach;?>
          </div>
          <?= LinkPager::widget([
                  'pagination' => $pages
          ])?>
      </div>
  </div>
</div>
<script>
    $(<?=$filter?>).get(0).checked = true;
</script>
<?php Pjax::end();?>

