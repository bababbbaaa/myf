<?php

use yii\helpers\Html;
use yii\helpers\Url;


$this->title = $article->title;
$js = <<< JS
$('.know__popular-link--close').click(function(e){
  e.preventDefault();
});
$('.know__popular-link--close').click(function(e){
  e.preventDefault();
});
$(".know-exclusive_list-item-link").on("click", function (){
  $(".know__popup").show();
});
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
          <a href="<?= Url::to(['knowledgearticle', 'link' => $subcategory['link']]) ?>" class="bcr__link">
                <?= $subcategory['name'] ?>
          </a>
        </li>
        <li class="bcr__item">
          <span class="bcr__span">
                <?= $article->title ?>
          </span>
        </li>
      </ul>
    </div>

    <div style="margin-bottom: 8px;" class="title_row title_row--know">
      <h1 class="title-main"> <?= $article->title ?></h1>
    </div>

    <p class="know__subtitle know__subtitle--page">
        <?= $article->description ?>
    </p>

    <span class="know__eye eye"><?= $article->views ?></span>

    <div class="know_container">
    <div class="know__catalog know__catalog--page">
          <div class="know__page">
            <div class="know__page-top">
              <span class="know__page-item know__page-item--word">
                Ключевые слова:
              </span>
              <span class="know__page-item"><?= $article->tags ?></span>
            </div>
            <div class="know__page-text">
                <?= $article->text ?>
            </div>
          </div>
        </div>
        <a href="<?= Url::to(['knowledgearticle', 'link' => $subcategory['link']]) ?>" class="know__page-link">
          <span>Вернуться ко всем статьям</span>
        </a>

        <h2 style="margin-bottom: -16px;" class="know__title">
          Вместе с этим читают
        </h2>

           <div class="know__article-aside-articlepage">
              <?php foreach ($moreArticle as $k => $v): ?>
                  <article class="know__article">
                      <h3 class="know__article-title">
                          <a href="<?= Url::to(['knowledgepage', 'link' => $v['link']]) ?>" class="know__article-link">
                              <?= $v['title'] ?>
                          </a>
                      </h3>
                      <span class="know__article-eye eye"><?= $v['views'] ?></span>
                  </article>
              <?php endforeach; ?>
           </div>


            <section class="know__popular">
                <h3 class="know__popular-title">
                    Популярные статьи
                </h3>

                <ul class="know__popular-list">
                    <?php foreach ($popularArticle as $k => $v): ?>
                        <li class="know__popular-item">
                            <a href="<?= Url::to(['knowledgepage', 'link' => $v['link']]) ?>" class="know__popular-link"></a>

                            <p class="know__popular-item-title"><?= $v['title'] ?></p>

                            <div class="know__popular-item-bottom">
                                <div class="know__popular-add">
                                    <span class="know__popular-eye eye">
                                        <?= $v['views'] ?>
                                    </span>
                                </div>
                                <div class="know__popular-item-bottom-btn">
                                    <svg width="7" height="12" viewBox="0 0 7 12" fill="none" xmlns="http://www.w3.org/2000/svg"><path opacity="0.949" fill-rule="evenodd" clip-rule="evenodd" d="M0.841797 0.744101C1.01654 0.733996 1.18579 0.759386 1.34961 0.820273C3.18434 2.40099 5.00398 4.0006 6.80859 5.6191C6.91016 5.8561 6.91016 6.09304 6.80859 6.33004C5.03973 7.89578 3.27082 9.46157 1.50195 11.0273C0.895168 11.361 0.505879 11.1917 0.333984 10.5195C0.356023 10.3857 0.398324 10.2588 0.460938 10.1386C2.02043 8.73971 3.58622 7.35171 5.1582 5.97457C3.58622 4.59743 2.02043 3.20943 0.460938 1.81051C0.250754 1.33215 0.377707 0.976679 0.841797 0.744101Z" fill="#43419E"/></svg>
                                </div>
                            </div>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </section>
            <section class="know-exclusive">
                <h2 class="know-exclusive-titlle">Эксклюзивная документация</h2>
                <ul class="know-exclusive_list">
                    <li class="know-exclusive_list-item">
                        <p class="know-exclusive_list-item-title">Договор займа с процентами</p>
                        <p class="know-exclusive_list-item-text">Данный документ является образцом договора займа с процентами</p>
                        <p class="know-exclusive_list-item-link">Получить доступ <svg width="21" height="16" viewBox="0 0 21 16" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M20.7071 8.7071C21.0976 8.31658 21.0976 7.68342 20.7071 7.29289L14.3431 0.928931C13.9526 0.538407 13.3195 0.538407 12.9289 0.928931C12.5384 1.31946 12.5384 1.95262 12.9289 2.34314L18.5858 8L12.9289 13.6569C12.5384 14.0474 12.5384 14.6805 12.9289 15.0711C13.3195 15.4616 13.9526 15.4616 14.3431 15.0711L20.7071 8.7071ZM8.74228e-08 9L20 9L20 7L-8.74228e-08 7L8.74228e-08 9Z" fill="#43419E"/></svg></p>
                        <div class="know__popular-add">
                            <span class="know__popular-eye eye">
                                3560
                            </span>
                        </div>
                    </li>
                    <li class="know-exclusive_list-item">
                        <p class="know-exclusive_list-item-title">Мировое соглашение</p>
                        <p class="know-exclusive_list-item-text">Данный документ является образцом договора займа с процентами</p>
                        <p class="know-exclusive_list-item-link">Получить доступ <svg width="21" height="16" viewBox="0 0 21 16" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M20.7071 8.7071C21.0976 8.31658 21.0976 7.68342 20.7071 7.29289L14.3431 0.928931C13.9526 0.538407 13.3195 0.538407 12.9289 0.928931C12.5384 1.31946 12.5384 1.95262 12.9289 2.34314L18.5858 8L12.9289 13.6569C12.5384 14.0474 12.5384 14.6805 12.9289 15.0711C13.3195 15.4616 13.9526 15.4616 14.3431 15.0711L20.7071 8.7071ZM8.74228e-08 9L20 9L20 7L-8.74228e-08 7L8.74228e-08 9Z" fill="#43419E"/></svg></p>
                        <div class="know__popular-add">
                            <span class="know__popular-eye eye">
                                3560
                            </span>
                        </div>
                    </li>
                    <li class="know-exclusive_list-item">
                        <p class="know-exclusive_list-item-title">Договор об отступном</p>
                        <p class="know-exclusive_list-item-text">Данный документ является образцом договора займа с процентами</p>
                        <p class="know-exclusive_list-item-link">Получить доступ <svg width="21" height="16" viewBox="0 0 21 16" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M20.7071 8.7071C21.0976 8.31658 21.0976 7.68342 20.7071 7.29289L14.3431 0.928931C13.9526 0.538407 13.3195 0.538407 12.9289 0.928931C12.5384 1.31946 12.5384 1.95262 12.9289 2.34314L18.5858 8L12.9289 13.6569C12.5384 14.0474 12.5384 14.6805 12.9289 15.0711C13.3195 15.4616 13.9526 15.4616 14.3431 15.0711L20.7071 8.7071ZM8.74228e-08 9L20 9L20 7L-8.74228e-08 7L8.74228e-08 9Z" fill="#43419E"/></svg></p>
                        <div class="know__popular-add">
                            <span class="know__popular-eye eye">
                                3560
                            </span>
                        </div>
                    </li>
                    <li class="know-exclusive_list-item">
                        <p class="know-exclusive_list-item-title">Заявление об утверждении мирового соглашения</p>
                        <p class="know-exclusive_list-item-text">Данный документ является образцом договора займа с процентами</p>
                        <p class="know-exclusive_list-item-link">Получить доступ <svg width="21" height="16" viewBox="0 0 21 16" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M20.7071 8.7071C21.0976 8.31658 21.0976 7.68342 20.7071 7.29289L14.3431 0.928931C13.9526 0.538407 13.3195 0.538407 12.9289 0.928931C12.5384 1.31946 12.5384 1.95262 12.9289 2.34314L18.5858 8L12.9289 13.6569C12.5384 14.0474 12.5384 14.6805 12.9289 15.0711C13.3195 15.4616 13.9526 15.4616 14.3431 15.0711L20.7071 8.7071ZM8.74228e-08 9L20 9L20 7L-8.74228e-08 7L8.74228e-08 9Z" fill="#43419E"/></svg></p>
                        <div class="know__popular-add">
                            <span class="know__popular-eye eye">
                                3560
                            </span>
                        </div>
                    </li>
                    <li class="know-exclusive_list-item">
                        <p class="know-exclusive_list-item-title">Договор об отступном</p>
                        <p class="know-exclusive_list-item-text">Данный документ является образцом договора займа с процентами</p>
                        <p class="know-exclusive_list-item-link">Получить доступ <svg width="21" height="16" viewBox="0 0 21 16" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M20.7071 8.7071C21.0976 8.31658 21.0976 7.68342 20.7071 7.29289L14.3431 0.928931C13.9526 0.538407 13.3195 0.538407 12.9289 0.928931C12.5384 1.31946 12.5384 1.95262 12.9289 2.34314L18.5858 8L12.9289 13.6569C12.5384 14.0474 12.5384 14.6805 12.9289 15.0711C13.3195 15.4616 13.9526 15.4616 14.3431 15.0711L20.7071 8.7071ZM8.74228e-08 9L20 9L20 7L-8.74228e-08 7L8.74228e-08 9Z" fill="#43419E"/></svg></p>
                        <div class="know__popular-add">
                            <span class="know__popular-eye eye">
                                3560
                            </span>
                        </div>
                    </li>
                    <li class="know-exclusive_list-item">
                        <p class="know-exclusive_list-item-title">Договор об отступном</p>
                        <p class="know-exclusive_list-item-text">Данный документ является образцом договора займа с процентами</p>
                        <p class="know-exclusive_list-item-link">Получить доступ <svg width="21" height="16" viewBox="0 0 21 16" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M20.7071 8.7071C21.0976 8.31658 21.0976 7.68342 20.7071 7.29289L14.3431 0.928931C13.9526 0.538407 13.3195 0.538407 12.9289 0.928931C12.5384 1.31946 12.5384 1.95262 12.9289 2.34314L18.5858 8L12.9289 13.6569C12.5384 14.0474 12.5384 14.6805 12.9289 15.0711C13.3195 15.4616 13.9526 15.4616 14.3431 15.0711L20.7071 8.7071ZM8.74228e-08 9L20 9L20 7L-8.74228e-08 7L8.74228e-08 9Z" fill="#43419E"/></svg></p>
                        <div class="know__popular-add">
                            <span class="know__popular-eye eye">
                                3560
                            </span>
                        </div>
                    </li>
                    <li class="know-exclusive_list-item">
                        <p class="know-exclusive_list-item-title">Заявление об утверждении мирового соглашения</p>
                        <p class="know-exclusive_list-item-text">Данный документ является образцом договора займа с процентами</p>
                        <p class="know-exclusive_list-item-link">Получить доступ <svg width="21" height="16" viewBox="0 0 21 16" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M20.7071 8.7071C21.0976 8.31658 21.0976 7.68342 20.7071 7.29289L14.3431 0.928931C13.9526 0.538407 13.3195 0.538407 12.9289 0.928931C12.5384 1.31946 12.5384 1.95262 12.9289 2.34314L18.5858 8L12.9289 13.6569C12.5384 14.0474 12.5384 14.6805 12.9289 15.0711C13.3195 15.4616 13.9526 15.4616 14.3431 15.0711L20.7071 8.7071ZM8.74228e-08 9L20 9L20 7L-8.74228e-08 7L8.74228e-08 9Z" fill="#43419E"/></svg></p>
                        <div class="know__popular-add">
                            <span class="know__popular-eye eye">
                                3560
                            </span>
                        </div>
                    </li>
                    <li class="know-exclusive_list-item">
                        <p class="know-exclusive_list-item-title">Договор об отступном</p>
                        <p class="know-exclusive_list-item-text">Данный документ является образцом договора займа с процентами</p>
                        <p class="know-exclusive_list-item-link">Получить доступ <svg width="21" height="16" viewBox="0 0 21 16" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M20.7071 8.7071C21.0976 8.31658 21.0976 7.68342 20.7071 7.29289L14.3431 0.928931C13.9526 0.538407 13.3195 0.538407 12.9289 0.928931C12.5384 1.31946 12.5384 1.95262 12.9289 2.34314L18.5858 8L12.9289 13.6569C12.5384 14.0474 12.5384 14.6805 12.9289 15.0711C13.3195 15.4616 13.9526 15.4616 14.3431 15.0711L20.7071 8.7071ZM8.74228e-08 9L20 9L20 7L-8.74228e-08 7L8.74228e-08 9Z" fill="#43419E"/></svg></p>
                        <div class="know__popular-add">
                            <span class="know__popular-eye eye">
                                3560
                            </span>
                        </div>
                    </li>
                </ul>
            </section>
        </div>
      </div>




      <div class="popup popup--ok know__popup">
        <div class="popup__ov">
            <div class="popup__body popup__body--ok know__popup-bb">
                <div class="popup__content popup__content--ok">
                    <p class="popup__text" 
                    style="
                        font-weight: 400;
                        font-size: 24px;
                        line-height: 140%;
                        color: #2B3048;
                    " >Купите технологию «Сохранение имущества» и получите доступ к эксклюзивным документам</p>
                    <a href="<?= Url::to(['technology']) ?>" class="popup__btn-ok btn" style="
                        font-weight: 400;
                        font-size: 16px;
                        line-height: 20px;
                        color: #FFFFFF;
                        background: #4B49A2;
                        border-radius: 8px;
                        padding: 10px 20px;
                    ">Перейти к технологии</a>
                    <button class="popup__btn-close btn">Отмена</button>
                </div>
                <div class="popup__close">
                    <img src="<?= Url::to(['/img/close.png']) ?>" alt="close">
                </div>
            </div>
        </div>
    </div>
</section>