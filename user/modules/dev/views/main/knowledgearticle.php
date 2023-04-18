<?php

use yii\helpers\Html;
use yii\helpers\Url;


$this->title = $subcategory['name'];

$js = <<< JS

    $('.know__search-inner').on('click', '.know__search-btn', function(e) {
        $('.know__search').submit();
    });

JS;
$this->registerJs($js);
?>
<section class="rightInfo">
  <div class="know know-cat">
    <div class="bcr">
      <ul class="bcr__list">
        <li class="bcr__item">
          <a href="<?= Url::to(['knowledge']) ?>" class="bcr__link">
            База Знаний
          </a>
        </li>
        <li class="bcr__item">
          <a href="<?= Url::to(['knowledgecat', 'link' => $category['link']]) ?>" class="bcr__link">
            <?= $category['name'] ?>
          </a>
        </li>
        <li class="bcr__item">
          <span class="bcr__span">
            <?= $subcategory['name'] ?>
          </span>
        </li>
      </ul>
    </div>
          <section style="background: linear-gradient(90.04deg, #923094 0.03%, #5B2F93 98.01%);" class="know_top-card">

            <h1 class="know_top-card-title"> <?= $subcategory['name'] ?></h1>
            <p class="know_top-card-text">
            <?= $subcategory['description'] ?>
            </p>
    
            <?= Html::beginForm(Url::to(['article-search']), 'get', ['class' => 'know__search']) ?>
            <label class="know__search-label">
                <div class="know__search-inner">
                    <input class="know__search-input" type="search" name="word" placeholder="Введите ваш запрос">
                    <button class="know__search-btn" type="submit" value="Найти">
                        <svg width="15" height="15" viewBox="0 0 15 15" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M5.4202 10.216C2.73228 10.216 0.553285 8.00362 0.553285 5.27451C0.553285 2.54539 2.73228 0.333008 5.4202 0.333008C8.10812 0.333008 10.2871 2.54539 10.2871 5.27451C10.2871 6.41766 9.9048 7.47015 9.26291 8.30735L13.8456 13.5419C14.0931 13.8246 14.0931 14.2829 13.8456 14.5656C13.5982 14.8483 13.1969 14.8483 12.9494 14.5656L8.30195 9.25705C7.49521 9.85985 6.49867 10.216 5.4202 10.216ZM5.42064 8.69559C7.28151 8.69559 8.79004 7.16394 8.79004 5.27455C8.79004 3.38517 7.28151 1.85352 5.42064 1.85352C3.55977 1.85352 2.05124 3.38517 2.05124 5.27455C2.05124 7.16394 3.55977 8.69559 5.42064 8.69559Z" fill="#0052CC"/></svg>
                    </button>
                </div>
            </label>
            <?= Html::endForm() ?>
        </section>

        <div class="know_container know_container-ar">
            <?php if (!empty($article)): ?>
                <?php foreach ($article as $k => $v): ?>
                    <article class="know__article">
                        <h2 class="know__article-title">
                            <a href="<?= Url::to(['knowledgepage', 'link' => $v['link']]) ?>" class="know__article-link">
                                <?= $v['title'] ?>
                            </a>
                        </h2>
                        <p class="know__article-text">
                            <?= $v['description'] ?>
                        </p>

                        <span class="know__article-eye eye"><?= $v['views'] ?></span>
                    </article>
                <?php endforeach; ?>
                <?php else: ?>
                <article class="know__article">
                    <p class="know__article-text">
                       В данной категории пока что нет ни одной статьи
                    </p>
                </article>
            <?php endif; ?>
      </div>
    </div>
</section>