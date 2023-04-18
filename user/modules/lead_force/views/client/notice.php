<?php

use yii\widgets\LinkPager;

$this->title = "Баланс";

?>
<style>
    .pagination{
        margin-left: 0 !important;
    }
</style>

<section class="rightInfo">
    <div class="balance">
        <div class="bcr">
            <ul class="bcr__list">
                <li class="bcr__item">
          <span class="bcr__link">
            Уведомления
          </span>
                </li>

                <li class="bcr__item">
          <span class="bcr__span">
            История уведомлений
          </span>
                </li>
            </ul>
        </div>

        <div class="title_row">
            <h1 class="Bal-ttl title-main">История уведомлений</h1>
        </div>

        <?php foreach ($notice as $k => $v): ?>
            <div style="padding: 15px" class="mass mass--cab">
                <div class="mass__content mass__content--cab">
                    <div style="display: flex; flex-wrap: wrap-reverse; margin-bottom: 5px; justify-content: space-between">
                        <p style="margin-bottom: 5px; padding-right: 5px; font-weight: 600" class="mass__text">
                            <?= $v['type'] ?>
                        </p>
                        <p style="margin-bottom: 5px; text-align: right" class="mass__text">
                            <?= date('d.m.Y', strtotime($v['date'])) ?>
                        </p>
                    </div>
                    <p style="margin-bottom: 5px;" class="mass__text">
                        <?= $v['text'] ?>
                    </p>

                </div>
            </div>
        <?php endforeach; ?>

        <?= LinkPager::widget([
            'pagination' => $pages,
        ]); ?>
    </div>
</section>
