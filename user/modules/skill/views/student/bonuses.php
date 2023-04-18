<?php

use yii\helpers\Url;
$this->title = 'Мои бонусы';
$js = <<< JS
    var yac = location.hash.substring(1),
        line = location.hash.substring(5);
    if(yac.length == 0){
        $('.ChangePage-Item-t[href="#page1"').addClass('CIT-active')
        $('section[id="page1"').addClass('active')
        $('.ChangePage-Item-line1').addClass('CIL-active')
    } else {
        $('.ChangePage-Item-t').removeClass('CIT-active');
        $('.ChangePage-Item-t[href="#'+yac+'"').addClass('active');
        $('.ChangePage-Item-line').removeClass('CIL-active')
        $('.ChangePage-Item-line'+line).addClass('CIL-active')
        $('.Page-Balance').removeClass('active');
        $('section[id="'+yac+'"').addClass('active');
    }
    
    $('.ChangePage-Item-t').on('click', function() {
        $('.ChangePage-Item-t').removeClass('CIT-active');
        $(this).addClass('CIT-active');
        var targets = $(this).attr('href').substring(1);
        var tar = $(this).attr('href').substring(5);
        $('.ChangePage-Item-line').removeClass('CIL-active');
        $('.ChangePage-Item-line'+tar).addClass('CIL-active');
        $('.Page-Bonuses').removeClass('active');
        $('section[id="'+targets+'"').addClass('active');
    });
JS;
$this->registerJs($js);
?>

<section class="rightInfo">
    <div class="bcr">
        <ul class="bcr__list">
            <li class="bcr__item">
                <span class="bcr__link">
                Мои бонусы
                </span>
            </li>

            <li class="bcr__item">
                <span class="bcr__span">
                Бонусные материалы
                </span>
            </li>
        </ul>
    </div>

    <div class="title_row">
        <h1 class="Bal-ttl title-main">Мои бонусы</h1>
        <a href="<?= Url::to(['usermanual']) ?>">Что такое бонусная программа</a>
    </div>

    <article class="MainInfo">
      <nav class="ChangePageBalance df">
        <div class="ChangePage-Item df jcsb aic">
          <a href="#page2" class="HText ChangePage-Item-t ChangePage-Item-t2 uscp CIT-active">Бонусные материалы</a>
          <div class="ChangePage-Item-line ChangePage-Item-line2 CIL-active"></div>
        </div>
        <div class="ChangePage-Item df jcsb aic">
          <a href="#page3" class="HText ChangePage-Item-t ChangePage-Item-t3 uscp">Карта клуба</a>
          <div class="ChangePage-Item-line ChangePage-Item-line3"></div>
        </div>
      </nav>
      <section id="page2" class="materials Page-Bonuses Page2-Bonuses change__section active">
        <div class="materials__body">
          <div class="materials__block">
            <h2 class="materials__block-title">Бонусные материалы</h2>
            <p class="cashback__block-subtitle">Купите курс “Основы маркетинга” и получите вебинар “Аналитика” в подарок</p>
                  <div class="materials__block-content">
                    <svg class="materials__content-image" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                      <path fill-rule="evenodd" clip-rule="evenodd" d="M20 10C20 15.5228 15.5228 20 10 20C4.47715 20 0 15.5228 0 10C0 4.47715 4.47715 0 10 0C15.5228 0 20 4.47715 20 10ZM1.53863 10.0003C1.53863 14.6735 5.32699 18.4619 10.0002 18.4619C14.6733 18.4619 18.4617 14.6735 18.4617 10.0003C18.4617 5.32717 14.6733 1.53881 10.0002 1.53881C5.32699 1.53881 1.53863 5.32717 1.53863 10.0003Z" fill="#278940" />
                      <path d="M5.83536 9.87105C5.54673 9.53518 5.04533 9.50115 4.71546 9.79503C4.38558 10.0889 4.35216 10.5994 4.6408 10.9353L7.41857 14.1676C7.72682 14.5263 8.27144 14.5368 8.59285 14.1903L15.3389 6.91762C15.6398 6.59316 15.6255 6.08172 15.3068 5.77528C14.9882 5.46885 14.4859 5.48346 14.1849 5.80792L8.03827 12.4344L5.83536 9.87105Z" fill="#278940" />
                    </svg>
                    <div>
                      <p class="materials__content-title">Курс для менеджера продаж</p>
                      <p class="materials__content-date">Доступен до 22.09.2021</p>
                      <a class="btn--purple materials__content-btn" href="">Начать обучение</a>
                    </div>
                  </div>
                  <div class="materials__block-content">
                    <svg class="materials__content-image" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                      <path fill-rule="evenodd" clip-rule="evenodd" d="M20 10C20 15.5228 15.5228 20 10 20C4.47715 20 0 15.5228 0 10C0 4.47715 4.47715 0 10 0C15.5228 0 20 4.47715 20 10ZM1.53863 10.0003C1.53863 14.6735 5.32699 18.4619 10.0002 18.4619C14.6733 18.4619 18.4617 14.6735 18.4617 10.0003C18.4617 5.32717 14.6733 1.53881 10.0002 1.53881C5.32699 1.53881 1.53863 5.32717 1.53863 10.0003Z" fill="#278940" />
                      <path d="M5.83536 9.87105C5.54673 9.53518 5.04533 9.50115 4.71546 9.79503C4.38558 10.0889 4.35216 10.5994 4.6408 10.9353L7.41857 14.1676C7.72682 14.5263 8.27144 14.5368 8.59285 14.1903L15.3389 6.91762C15.6398 6.59316 15.6255 6.08172 15.3068 5.77528C14.9882 5.46885 14.4859 5.48346 14.1849 5.80792L8.03827 12.4344L5.83536 9.87105Z" fill="#278940" />
                    </svg>
                    <div>
                    <p class="materials__content-title">Курся для руководителя отдела продаж</p>
                      <p class="materials__content-date">Доступен до 22.09.2021</p>
                      <a class="btn--purple materials__content-btn" href="">Начать обучение</a>
                    </div>
                  </div>

                  <div class="materials__block-content">
                    <svg class="materials__content-image" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                      <path fill-rule="evenodd" clip-rule="evenodd" d="M20 10C20 15.5228 15.5228 20 10 20C4.47715 20 0 15.5228 0 10C0 4.47715 4.47715 0 10 0C15.5228 0 20 4.47715 20 10ZM1.53863 10.0003C1.53863 14.6735 5.32699 18.4619 10.0002 18.4619C14.6733 18.4619 18.4617 14.6735 18.4617 10.0003C18.4617 5.32717 14.6733 1.53881 10.0002 1.53881C5.32699 1.53881 1.53863 5.32717 1.53863 10.0003Z" fill="#278940" />
                      <path d="M5.83536 9.87105C5.54673 9.53518 5.04533 9.50115 4.71546 9.79503C4.38558 10.0889 4.35216 10.5994 4.6408 10.9353L7.41857 14.1676C7.72682 14.5263 8.27144 14.5368 8.59285 14.1903L15.3389 6.91762C15.6398 6.59316 15.6255 6.08172 15.3068 5.77528C14.9882 5.46885 14.4859 5.48346 14.1849 5.80792L8.03827 12.4344L5.83536 9.87105Z" fill="#278940" />
                    </svg>
                    <div>
                    <p class="materials__content-title">Вебинар “Аналитика”</p>
                      <p class="materials__content-date">Запись доступна до 22.09.2021</p>
                      <a class="btn--purple materials__content-btn" href="">Смотреть вебинар</a>
                    </div>
                  </div>

          </div>
          <div class="materials__image">
            <img src="<?= Url::to(['/img/femidaclient/materials-image.png']) ?>" alt="иллюстрация открытых окон в браузере">
          </div>
        </div>
      </section>
      <section id="page3" class="clubCart Page-Bonuses Page3-Bonuses change__section">
        <div class="clubCart__body">
            <div class="clubCart__nocartBlock">
              <div class="nocartBlock__info">
                <div class="nocartBlock__head">
                  <h2>Карта клуба</h2>
                  <p>Получайте баллы за покупки и тратьте в любом сервисе экосистемы MYFORCE</p>
                </div>
                <div class="nocartBlock__info">
                  <h3>Как получить карту</h3>
                  <p>Получить карту Клуба можно следующими способами:</p>
                  <ul>
                    <li>При единовременной покупке от 350 лидов</li>
                    <li>Купить за 9 900 рублей</li>
                  </ul>
                </div>
                <div class="nocartBlock__btngroup">
                  <button class="red__button--card">Заказать 350 лидов</button>
                  <a href="" class="red__link--card">Оформить карту</a>
                </div>
              </div>
              <div class="nocart__image">
                <img src="<?= Url::to(['/img/skillclient/cardMyForce.png']) ?>" alt="">
              </div>
            </div>
            <div class="green__blockCard">
              <h4>Преимущества Клуба <b>MYFORCE</b></h4>
              <div class="flex__li--blok">
                <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path fill-rule="evenodd" clip-rule="evenodd" d="M18 9C18 13.9706 13.9706 18 9 18C4.02944 18 0 13.9706 0 9C0 4.02944 4.02944 0 9 0C13.9706 0 18 4.02944 18 9ZM1.38477 9.00033C1.38477 13.2062 4.79429 16.6157 9.00015 16.6157C13.206 16.6157 16.6155 13.2062 16.6155 9.00033C16.6155 4.79447 13.206 1.38495 9.00015 1.38495C4.79429 1.38495 1.38477 4.79447 1.38477 9.00033Z" fill="white" />
                  <path d="M5.25184 8.88472C4.99206 8.58244 4.54081 8.55181 4.24392 8.81631C3.94704 9.0808 3.91695 9.54027 4.17673 9.84255L6.67673 12.7516C6.95415 13.0745 7.44431 13.0839 7.73358 12.7721L13.805 6.22664C14.0759 5.93462 14.063 5.47433 13.7762 5.19854C13.4894 4.92275 13.0373 4.9359 12.7664 5.22791L7.23446 11.1918L5.25184 8.88472Z" fill="white" />
                </svg>
                <p>Получайте баллы с каждой покупки</p>
              </div>
              <div class="flex__li--blok">
                <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path fill-rule="evenodd" clip-rule="evenodd" d="M18 9C18 13.9706 13.9706 18 9 18C4.02944 18 0 13.9706 0 9C0 4.02944 4.02944 0 9 0C13.9706 0 18 4.02944 18 9ZM1.38477 9.00033C1.38477 13.2062 4.79429 16.6157 9.00015 16.6157C13.206 16.6157 16.6155 13.2062 16.6155 9.00033C16.6155 4.79447 13.206 1.38495 9.00015 1.38495C4.79429 1.38495 1.38477 4.79447 1.38477 9.00033Z" fill="white" />
                  <path d="M5.25184 8.88472C4.99206 8.58244 4.54081 8.55181 4.24392 8.81631C3.94704 9.0808 3.91695 9.54027 4.17673 9.84255L6.67673 12.7516C6.95415 13.0745 7.44431 13.0839 7.73358 12.7721L13.805 6.22664C14.0759 5.93462 14.063 5.47433 13.7762 5.19854C13.4894 4.92275 13.0373 4.9359 12.7664 5.22791L7.23446 11.1918L5.25184 8.88472Z" fill="white" />
                </svg>
                <p>Оплачивайте баллами до 50% услуг компании</p>
              </div>
              <div class="flex__li--blok">
                <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path fill-rule="evenodd" clip-rule="evenodd" d="M18 9C18 13.9706 13.9706 18 9 18C4.02944 18 0 13.9706 0 9C0 4.02944 4.02944 0 9 0C13.9706 0 18 4.02944 18 9ZM1.38477 9.00033C1.38477 13.2062 4.79429 16.6157 9.00015 16.6157C13.206 16.6157 16.6155 13.2062 16.6155 9.00033C16.6155 4.79447 13.206 1.38495 9.00015 1.38495C4.79429 1.38495 1.38477 4.79447 1.38477 9.00033Z" fill="white" />
                  <path d="M5.25184 8.88472C4.99206 8.58244 4.54081 8.55181 4.24392 8.81631C3.94704 9.0808 3.91695 9.54027 4.17673 9.84255L6.67673 12.7516C6.95415 13.0745 7.44431 13.0839 7.73358 12.7721L13.805 6.22664C14.0759 5.93462 14.063 5.47433 13.7762 5.19854C13.4894 4.92275 13.0373 4.9359 12.7664 5.22791L7.23446 11.1918L5.25184 8.88472Z" fill="white" />
                </svg>
                <p>Дополнительный процент отбраковки ваших лидов</p>
              </div>
              <div class="flex__li--blok">
                <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path fill-rule="evenodd" clip-rule="evenodd" d="M18 9C18 13.9706 13.9706 18 9 18C4.02944 18 0 13.9706 0 9C0 4.02944 4.02944 0 9 0C13.9706 0 18 4.02944 18 9ZM1.38477 9.00033C1.38477 13.2062 4.79429 16.6157 9.00015 16.6157C13.206 16.6157 16.6155 13.2062 16.6155 9.00033C16.6155 4.79447 13.206 1.38495 9.00015 1.38495C4.79429 1.38495 1.38477 4.79447 1.38477 9.00033Z" fill="white" />
                  <path d="M5.25184 8.88472C4.99206 8.58244 4.54081 8.55181 4.24392 8.81631C3.94704 9.0808 3.91695 9.54027 4.17673 9.84255L6.67673 12.7516C6.95415 13.0745 7.44431 13.0839 7.73358 12.7721L13.805 6.22664C14.0759 5.93462 14.063 5.47433 13.7762 5.19854C13.4894 4.92275 13.0373 4.9359 12.7664 5.22791L7.23446 11.1918L5.25184 8.88472Z" fill="white" />
                </svg>
                <p>Персональная вечная скидка 10% на все услуги компании</p>
              </div>
            </div>
              <div class="clubCart__cartBlock">
                <div class="cartBlock__info">
                  <div class="cartBlock__head">
                    <h2>Карта клуба</h2>
                    <div class="cartBlock__score">
                      <p>4444 <span>баллов </span></p>
                    </div>
                  </div>
                </div>
                <div class="cart__image">
                  <img src="<?= Url::to(['/img/skillclient/cardMyForce.png']) ?>" alt="">
                </div>
              </div>
        </div>
        <div class="spendBalls">
          <h5 class="spendBalls__title">Где потратить баллы</h5>
          <p class="spendBalls__subtitle">Оплачивайте до 50% от услуг MYFORCE</p>
          <div class="spend__flex">
            <div class="spend__flex-skill">
              <p class="skill__title">SKILL.Force</p>
              <p class="skill__subtitle">Онлайн-обучение востребованным навыкам</p>
              <a class="spend__link" href="<?= Url::to(['']) ?>">Выбрать курс</a>
            </div>
            <div class="spend__flex-femida">
              <p class="femida__title">FEMIDA.Force</p>
              <p class="femida__subtitle">Запустите готовый бизнес с нуля</p>
              <a target="_blank" class="spend__link" href="https://myforce.ru/femida/franchizes">Выбрать
                франшизу</a>
            </div>
            <div class="spend__flex-ads">
              <p class="ads__title">ADS.Force</p>
              <p class="ads__subtitle">Технологии эффективного маркетинга</p>
              <a class="spend__link" href="<?= Url::to(['']) ?>">Выбрать технологию</a>
            </div>
          </div>
        </div>
      </section>
    </article>
</section>