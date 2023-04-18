<?php


/* @var $this yii\web\View */

use yii\helpers\Url;
use common\models\helpers\UrlHelper;
use yii\widgets\Pjax;

$this->title = $cases['og_title'];

$this->registerCssFile('https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.css');
$this->registerJsFile('https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.js');
$this->registerJsFile("@web/js/mainjs/swiper.js");
$this->registerJsFile("@web/js/mainjs/swiper-control.js");
$this->registerJsFile("@web/js/mainjs/swiper-control.js");
$this->registerJsFile("@web/js/mainjs/accordion.js");
$this->registerCssFile("@web/css/maincss/swiper.css");

$css =<<< CSS
    .header {
        background: #000E1A;
        border-bottom: none;
    }

    .header__active {
        animation-name: none;
    }

    a,
    a:hover,
    a:active,
    a:focus{
        opacity: 1;
        color: #DF2C56;
    }
CSS;

$js = <<<JS
let checkItem = document.querySelector('.ceys__item-text');
let checkItemP = checkItem.querySelectorAll('.ceys__item-text p');
let checkUl = checkItem.querySelector('ul, ol');
let checkTitle = checkItem.querySelectorAll('h4');

let checkCloseOne = document.querySelector('.check-close-one');
let checkCloseTwo = document.querySelector('.check-close-two');

let newText = checkItemP[0].innerHTML.slice(0, 348);
let remainingText = checkItemP[0].innerHTML.slice(348);

let removeShowLess  = function (item) {
       checkItemP.forEach((key, i) => {
       key.style.display = 'none';
    });
    if(checkUl) {
        checkUl.style.display = 'none';
    }
    if (checkTitle) {
        checkTitle.forEach(i => {
            i.style.display = 'none';
        })
    }
    item.style.display = 'block';
    checkCloseOne.style.display = 'none';
    checkCloseTwo.style.display = 'block';
    item.innerHTML = newText  + '...';
}


removeShowLess(checkItemP[0]);
let addShowMore = function (item) {
        checkItemP.forEach((key, i) => {
        key.style.display = 'block'; 
    });
        if(checkUl) {
        checkUl.style.display = 'block';
        }
       if (checkTitle) {
        checkTitle.forEach(i => {
            i.style.display = 'block';
        })
    }
        checkCloseOne.style.display = 'block';
        checkCloseTwo.style.display = 'none';
        item.innerHTML = newText + remainingText;

}

checkCloseOne.addEventListener('click', (e)  => {
    e.preventDefault();
 removeShowLess(checkItemP[0])
    
});

checkCloseTwo.addEventListener('click', (e)  => {
    e.preventDefault();
 addShowMore(checkItemP[0]);
    
});


    var swiper = new Swiper(".swiperCases", {
      slidesPerView: 1,
      spaceBetween: 20,
      centeredSlides: true,
      loop: true,
      pagination: {
        el: ".swiper-pagination",
        clickable: true,
      },
      breakpoints: {
        768: {
          slidesPerView: 2,
          spaceBetween: 40,
          centeredSlides: true,
        },
        1024: {
          slidesPerView: 3,
          spaceBetween: 50,
          centeredSlides: false,
        },
      },
    });
    
    let cramb = document.querySelectorAll('.breadcrumbs a')[1];
    
    
    if(window.innerWidth < 576) {
        cramb.textContent = cramb.textContent.substring(0, 36) + '...';
    }
JS;


$this->registerCss($css);
$this->registerJs($js);
?>
<?php //foreach ($cases as $key => $item): ?>
<div class="ceys">
    <div class="container">
        <nav class="breadcrumbs">
            <a href="<?= Url::to(['/']) ?>">Главная</a>
            <img src="<?= Url::to(['img/mainimg/breadcrumbs.svg']) ?>" alt="разделитель">
            <a><?= $cases['name'] ?></a>
        </nav>

        <h1 class="ceys__title">
            <?= $cases['name'] ?>
        </h1>
        <h2 class="ceys__subtitle">
            <?= $cases['type'] ?>
        </h2>

        <article class="ceys__item ceys__item--pad">
            <div class="ceys__item-inner">
                <div class="ceys__item-img">
                    <img src="<?= UrlHelper::admin($cases['logo']) ?>" alt="<?= $cases['name'] ?>" />
                </div>

                <div class="ceys__item-content">
                    <h3 class="ceys__item-title title-ceys">
                        О компании
                    </h3>

                    <div class="ceys__item-text">
                        <?= $cases['big_description'] ?>
                        <button class="check-close-one">Скрыть все</button>
                        <button class="check-close-two">Читать далее</button>
                    </div>

                </div>
            </div>
        </article>


        <article class="ceys__item">


        <div class="ceys_div_wrap">
     <div class="ceys_max-width">
         <h4 class="ceys__item-title title-ceys">
             Исходные данные
         </h4>

         <ul class="ceys__item-list">
             <?php $input = json_decode($cases['input']) ?>
             <?php if(!empty($input)): ?>
                 <?php foreach ($input as $k => $i): ?>
                     <li class="ceys__item-ten"><?= $i ?></li>
                 <?php endforeach; ?>
             <?php endif; ?>
         </ul>
     </div>

            <?php $from_to = json_decode($cases['from_to'], true) ?>
            <div class="cays__flex-wrap">
                <div class="text__case-title">
                    <p class="boxs__title title-ceys">Было</p>
                </div>
                <?php if(!empty($from_to)): ?>
                    <?php foreach ($from_to as $key => $items): ?>
                        <div class="case_flex-wrap">
                            <div class="boxs__item boxs__item--arrow">
                                <p><?= $items['Было'] ?></p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>

        <div class="ceys_div_wrap">
   <div class="ceys_max-width">
       <h4 class="ceys__item-title title-ceys">
           Результаты
       </h4>

       <ul class="ceys__item-list">
           <?php $result = json_decode($cases['result']) ?>
           <?php if(!empty($result)): ?>
               <?php foreach ($result as $k => $i): ?>
                   <?php if ($k < 3): ?>
                       <li class="ceys__item-ten ceys__item-ten--ok ceys__item-ten--mb-27"><?= $i ?></li>
                   <?php else: ?>
                    <?php break; ?>
               <?php endif;?>
               <?php endforeach; ?>
           <?php endif; ?>
       </ul>
   </div>

    <?php $from_to = json_decode($cases['from_to'], true) ?>
    <div class="cays__flex-wrap">
        <div class="text__case-title">
            <p class="boxs__title title-ceys">Стало</p>
        </div>
        <?php if(!empty($from_to)): ?>
            <?php foreach ($from_to as $key => $items): ?>
                <div class="case_flex-wrap">
                    <div class="boxs__item boxs__item--arrow ceys__item-ten--mb">
                        <p><?= $items['Стало'] ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>



<!--       <div>-->
<!--           --><?php //$from_to = json_decode($cases['from_to'], true) ?>
<!--           <div class="cays__flex-wrap">-->
<!--               <div class="text__case-title">-->
<!--                   <p class="boxs__title title-ceys">Стало</p>-->
<!--               </div>-->
<!--               --><?php //if(!empty($from_to)): ?>
<!--                   --><?php //foreach ($from_to as $key => $items): ?>
<!--                       <div class="case_flex-wrap">-->
<!--                           <div class="boxs__item boxs__item--arrow">-->
<!--                               <p>--><?php //= $items['Стало'] ?><!--</p>-->
<!--                           </div>-->
<!--                       </div>-->
<!--                   --><?php //endforeach; ?>
<!--               --><?php //endif; ?>
<!--           </div>-->
<!--           <div class="ceys__item-wrap">-->
<!--               <div class="ceys__item-box ceys__item-box--arrow boxs">-->
<!--                   <p class="boxs__title title-ceys">Было</p>-->
<!--                   --><?php //if(!empty($from_to)): ?>
<!--                       --><?php //foreach ($from_to as $key => $items): ?>
<!--                           <div class="boxs__item boxs__item--arrow">-->
<!--                               <p>--><?php //= $items['Было'] ?><!--</p>-->
<!--                           </div>-->
<!--                       --><?php //endforeach; ?>
<!--                   --><?php //endif; ?>
<!--               </div>-->
<!---->
<!--               <div class="ceys__item-boxs boxs">-->
<!--                   <p class="boxs__title title-ceys">Стало</p>-->
<!--                   --><?php //if(!empty($from_to)): ?>
<!--                       --><?php //foreach ($from_to as $key => $items): ?>
<!--                           <div class="boxs__item boxs__item--green">-->
<!--                               <p>--><?php //= $items['Стало'] ?><!--</p>-->
<!--                           </div>-->
<!--                       --><?php //endforeach; ?>
<!--                   --><?php //endif; ?>
<!--               </div>-->
<!--           </div>-->
<!--       </div>-->

        </article>

        <article class="ceys__item">
            <div class="ceys__item-comment">
                <div class="ceys__item-comment-img">
                    <div class="ceys__item-comment-block"></div>
                    <img src="<?= UrlHelper::admin($cases['boss_img']) ?>" alt="<?= $cases['type'] ?>">
                </div>

                <div class="ceys__item-comment-content">
                    <h5 class="ceys__item-comment-title title-ceys">
                        Комментарий заказчика
                    </h5>

                    <p class="ceys__item-comment-text">
                        « <?= $cases['comment'] ?> »
                    </p>
                    <p class="ceys__item-comment-name">
                        © <?= $cases['boss_name'] . ', ' . $cases['boss_op'] ?>
                    </p>
                </div>
            </div>
        </article>
    </div>
</div>

<?php if (!empty($cases_one)) : ?>
    <a id="partners"></a>
    <div class="s3 s3-cases">
        <div class="container">
            <h3 class="s3__title title">
                Другие кейсы
            </h3>

            <div class="swiper swiperCases">
                <div class="swiper-wrapper">
                    <?php foreach ($cases_one as $item): ?>
                        <?php if($cases['id'] != $item['id']):?>
                            <div class="swiper-slide">
                                <article class="case__article">
                                    <a href="<?= Url::to(['case', 'link' => $item['link']]) ?>" class="case__links"></a>
                                    <div class="case__inner">
                                        <div class="case__img">

                                            <img src="<?= UrlHelper::admin($item['logo']) ?>" alt="лого" />
                                        </div>
                                        <div class="case__content">

                                            <h2 class="case__heading">
                                                <?= $item['type']  ?>
                                            </h2>
                                            <p class="case__comment">
                                                <?= mb_substr(strip_tags($item['comment']), 0, 200) ?>...
                                            </p>
                                            <p class="case__author">© <?= $item['boss_name'] ?>,
                                                <?= $item['boss_op'] ?> </p>
                                        </div>
                                    </div>

                                </article>
                            </div>
                            <?php endif;?>
                    <?php endforeach; ?>
                </div>
                <div class="swiper-pagination"></div>
            </div>


            <?php if ($casesColl > 7 && $casesColl >= $_GET['count']) : ?>
                <?= Html::beginForm(Url::to(['index']), 'GET', ['class' => 'sendAdd']) ?>
                <input type="hidden" name="count" value="<?= !empty($_GET['count']) ? $_GET['count'] + 3 : 10 ?>">
                <button type="submit" class="s3__btn btn-add">Ещё</button>
                <?= Html::endForm(); ?>
            <?php endif; ?>

        </div>
    </div>
<?php endif; ?>
<?php //endforeach; ?>