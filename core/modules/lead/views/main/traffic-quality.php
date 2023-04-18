<?php

use yii\helpers\Url;
use yii\helpers\Html;

$js = <<<JS
const trafficClose = document.querySelectorAll('.traffic-acc__close');
const trafficContent = document.querySelectorAll('.traffic-acc__content');
const trafficHead = document.querySelectorAll('.traffic-acc__header p');
const trafficRotate = document.querySelectorAll('.traffic-acc__rotate');

          
trafficClose.forEach((item, i) => {
    item.addEventListener('click', (e) => {

          
    
            
       trafficContent[i].classList.toggle('traffic-acc__content__active');
       trafficHead[i].classList.toggle('traffic-acc__header__active');
       trafficRotate[i].classList.toggle('traffic-acc__rotate__active');
       
    });
});
  
JS;


$this->title = 'Качество трафика';
$this->registerJsFile(Url::to(['/js/leads-range.js']), ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJs($js);
$this->registerCssFile('@web/css/lead.css');
?>


<section class="promo promo-traffic">
    <div class="container">
        <h2 class="traffic-promo">Качество трафика </h2>
        <p class="traffic-text">Качественные лиды для любой отрасли бизнеса</p>
        <button class="lead__btn showsCard">Получить лиды</и>
    </div>
</section>

<section class="traffic-applications">
    <div class="container">
        <h2 class="traffic-applications__title">Какое качество заявок мы предоставляем?</h2>
        <p class="traffic-applications__text">На рынке лидогенерации мы работаем с 2015 года и за это время успели
            преуспеть в маркетинге и наработать свой собственный опыт!</p>

        <div class="traffic-applications__wrapp">
            <div class="traffic-applications__item">
                <div class="traffic-applications__item-mobile">
                    <div class="traffic-applications__img">
                        <img src="<?= Url::to('../img/mainimg/applications-1.svg') ?>"
                            alt="В одни руки» — уникальные заявки">
                    </div>

                    <div class="traffic-applications__descr-mobile">
                        <p>«В одни руки» — уникальные заявки </p>
                    </div>
                </div>


                <div class="traffic-applications__descr">
                    <p><span>«В одни руки» — уникальные заявки</span></p>
                    <p>Наших возможностей рекламы хватит на всех - под каждого партнера мы настраиваем с нуля новую
                        рекламную кампанию, что позволяет находить новый трафик клиентов. У каждого клиента выясняется
                        работает ли он с другой компанией. Таким образом вы получаете уникального клиента, который
                        только выбирает с кем сотрудничать! </p>
                </div>
            </div>
            <div class="traffic-applications__item">
                <div class="traffic-applications__item-mobile">
                    <div class="traffic-applications__img">
                        <img src="<?= Url::to('../img/mainimg/applications-2.svg') ?>"
                            alt="Только реальные проблемы и реальные клиенты">
                    </div>

                    <div class="traffic-applications__descr-mobile">
                        <p>Только реальные проблемы и реальные клиенты </p>
                    </div>
                </div>


                <div class="traffic-applications__descr">
                    <p><span>Только реальные проблемы и реальные клиенты </span></p>
                    <p>Каждая заявка отправляется с действующим номером и актуальной проблемой, что будет указано
                        в карточке лида. </p>
                </div>
            </div>
            <div class="traffic-applications__item">
                <div class="traffic-applications__item-mobile">
                    <div class="traffic-applications__img">
                        <img src="<?= Url::to('../img/mainimg/applications-3.svg') ?>"
                            alt="Максимальная верификация и максимальный дозвон">
                    </div>

                    <div class="traffic-applications__descr-mobile">
                        <p>Максимальная верификация и максимальный дозвон</p>
                    </div>
                </div>

                <div class="traffic-applications__descr">
                    <p><span>Максимальная верификация и максимальный дозвон</span></p>
                    <p>С мая 2022 мы установили рекорд 90% дозвона по всем нашим лидам. Это происходит благодаря тому,
                        что наш call-центр дозванивается до клиентов и предупреждает, что вскоре после верификации им
                        позвонит юрист.</p>
                </div>

            </div>
        </div>
    </div>


    </div>
</section>


<section class="traffic-cooperation">
    <div class="container">
        <h2 class="traffic-cooperation__title">Почему с нами выгодно сотрудничать?</h2>
        <p class="traffic-cooperation__text">Давайте зарабатывать вместе.</p>

        <div class="traffic-cooperation__wrapp">
            <div class="traffic-cooperation__item">
                <p class="traffic-cooperation__number">01</p>
                <p class="traffic-cooperation__subtitle traffic-cooperation__subtitle_bl">Высокая конверсия в сделку</p>
                <p class="traffic-cooperation__subtitle">Максимально обработанные клиенты, которые готовы сотрудничать с
                    вами.</p>

            </div>
            <div class="traffic-cooperation__item">
                <p class="traffic-cooperation__number">02</p>
                <p class="traffic-cooperation__subtitle traffic-cooperation__subtitle_bl">Низкий процент отказов</p>
                <p class="traffic-cooperation__subtitle">Вы не тратите много времени на отказников, это сделаем мы и
                    отсеем нецелевых клиентов.</p>

            </div>
            <div class="traffic-cooperation__item">
                <p class="traffic-cooperation__number">03</p>
                <p class="traffic-cooperation__subtitle traffic-cooperation__subtitle_bl">Все так, как вы хотите</p>
                <p class="traffic-cooperation__subtitle">Учитываем ваши пожелания к каждому заказу, даже наш стандартный
                    заказ уже рассчитан под основные потребности наших партнеров.</p>

            </div>
            <div class="traffic-cooperation__item">
                <p class="traffic-cooperation__number">04</p>
                <p class="traffic-cooperation__subtitle traffic-cooperation__subtitle_bl">Точно в цель</p>
                <p class="traffic-cooperation__subtitle">Вы не рискуете с нами в потере бюджета, так как наши опытные
                    маркетологи делают трафик с 2015 года и точно знают как привлечь целевого клиента без потери бюджета
                    в отличи от новичков.</p>

            </div>
        </div>
    </div>
</section>

<section class="traffic-lead">
    <div class="container">
        <h2 class="traffic-lead__title">Инструменты лидогенерации</h2>
        <p class="traffic-lead__text">Для привлечения покупателей мы используем полный набор актуальных маркетинговых
            инструментов. Основные из них:</p>

        <div class="traffic-lead__wrapp">
            <div>
                <div class="traffic-lead__item">
                    <p>Контекстная и таргетированная реклама</p>
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M5.5 10V14C5.5 16 6.5 17 8.5 17H9.93C10.3 17 10.67 17.11 10.99 17.3L13.91 19.13C16.43 20.71 18.5 19.56 18.5 16.59V7.41003C18.5 4.43003 16.43 3.29003 13.91 4.87003L10.99 6.70003C10.67 6.89003 10.3 7.00003 9.93 7.00003H8.5C6.5 7.00003 5.5 8.00003 5.5 10Z"
                            stroke="#DF2C56" stroke-width="1.5" />
                    </svg>

                </div>
                <div class="traffic-lead__item">
                    <p>E-mail маркетинг
                    </p>
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M17 20.5H7C4 20.5 2 19 2 15.5V8.5C2 5 4 3.5 7 3.5H17C20 3.5 22 5 22 8.5V15.5C22 19 20 20.5 17 20.5Z"
                            stroke="#DF2C56" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round"
                            stroke-linejoin="round" />
                        <path d="M17 9L13.87 11.5C12.84 12.32 11.15 12.32 10.12 11.5L7 9" stroke="#DF2C56"
                            stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>


                </div>
                <div class="traffic-lead__item">
                    <p>Тизерные сети</p>
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M18.0001 7.16C17.9401 7.15 17.8701 7.15 17.8101 7.16C16.4301 7.11 15.3301 5.98 15.3301 4.58C15.3301 3.15 16.4801 2 17.9101 2C19.3401 2 20.4901 3.16 20.4901 4.58C20.4801 5.98 19.3801 7.11 18.0001 7.16Z"
                            stroke="#DF2C56" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                        <path
                            d="M16.9704 14.4402C18.3404 14.6702 19.8504 14.4302 20.9104 13.7202C22.3204 12.7802 22.3204 11.2402 20.9104 10.3002C19.8404 9.59016 18.3104 9.35016 16.9404 9.59016"
                            stroke="#DF2C56" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                        <path
                            d="M5.97047 7.16C6.03047 7.15 6.10047 7.15 6.16047 7.16C7.54047 7.11 8.64047 5.98 8.64047 4.58C8.64047 3.15 7.49047 2 6.06047 2C4.63047 2 3.48047 3.16 3.48047 4.58C3.49047 5.98 4.59047 7.11 5.97047 7.16Z"
                            stroke="#DF2C56" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                        <path
                            d="M7.00043 14.44C5.63043 14.67 4.12043 14.43 3.06043 13.72C1.65043 12.78 1.65043 11.24 3.06043 10.3C4.13043 9.59004 5.66043 9.35003 7.03043 9.59003"
                            stroke="#DF2C56" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                        <path
                            d="M12.0001 14.6297C11.9401 14.6197 11.8701 14.6197 11.8101 14.6297C10.4301 14.5797 9.33008 13.4497 9.33008 12.0497C9.33008 10.6197 10.4801 9.46973 11.9101 9.46973C13.3401 9.46973 14.4901 10.6297 14.4901 12.0497C14.4801 13.4497 13.3801 14.5897 12.0001 14.6297Z"
                            stroke="#DF2C56" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                        <path
                            d="M9.08973 17.7797C7.67973 18.7197 7.67973 20.2597 9.08973 21.1997C10.6897 22.2697 13.3097 22.2697 14.9097 21.1997C16.3197 20.2597 16.3197 18.7197 14.9097 17.7797C13.3197 16.7197 10.6897 16.7197 9.08973 17.7797Z"
                            stroke="#DF2C56" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>

                </div>
            </div>
            <div class="traffic-lead__item-two">
                <div>
                    <p>
                        Собственная бета-нейросеть генерации рекламных объявлений по потребностям
                    </p>
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M15.39 5.21L16.7999 8.02999C16.9899 8.41999 17.4999 8.78999 17.9299 8.86999L20.48 9.28999C22.11 9.55999 22.49 10.74 21.32 11.92L19.3299 13.91C18.9999 14.24 18.81 14.89 18.92 15.36L19.4899 17.82C19.9399 19.76 18.9 20.52 17.19 19.5L14.7999 18.08C14.3699 17.82 13.65 17.82 13.22 18.08L10.8299 19.5C9.11994 20.51 8.07995 19.76 8.52995 17.82L9.09996 15.36C9.20996 14.9 9.01995 14.25 8.68995 13.91L6.69996 11.92C5.52996 10.75 5.90996 9.56999 7.53996 9.28999L10.0899 8.86999C10.5199 8.79999 11.03 8.41999 11.22 8.02999L12.63 5.21C13.38 3.68 14.62 3.68 15.39 5.21Z"
                            stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                        <path d="M8 5H2" stroke="white" stroke-width="1.5" stroke-linecap="round"
                            stroke-linejoin="round" />
                        <path d="M5 19H2" stroke="white" stroke-width="1.5" stroke-linecap="round"
                            stroke-linejoin="round" />
                        <path d="M3 12H2" stroke="white" stroke-width="1.5" stroke-linecap="round"
                            stroke-linejoin="round" />
                    </svg>
                </div>

            </div>
            <div>
                <div class="traffic-lead__item">
                    <p>SEO продвижение;</p>
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M14 5H20" stroke="#DF2C56" stroke-width="1.5" stroke-linecap="round"
                            stroke-linejoin="round" />
                        <path d="M14 8H17" stroke="#DF2C56" stroke-width="1.5" stroke-linecap="round"
                            stroke-linejoin="round" />
                        <path d="M21 11.5C21 16.75 16.75 21 11.5 21C6.25 21 2 16.75 2 11.5C2 6.25 6.25 2 11.5 2"
                            stroke="#DF2C56" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                        <path d="M22 22L20 20" stroke="#DF2C56" stroke-width="1.5" stroke-linecap="round"
                            stroke-linejoin="round" />
                    </svg>


                </div>
                <div class="traffic-lead__item">
                    <p>Programmatic
                    </p>
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M8.99953 13C8.33953 13.33 7.78953 13.82 7.37953 14.43C7.14953 14.78 7.14953 15.22 7.37953 15.57C7.78953 16.18 8.33953 16.67 8.99953 17"
                            stroke="#DF2C56" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                        <path
                            d="M15.21 13C15.87 13.33 16.42 13.82 16.83 14.43C17.06 14.78 17.06 15.22 16.83 15.57C16.42 16.18 15.87 16.67 15.21 17"
                            stroke="#DF2C56" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                        <path d="M9 22H15C20 22 22 20 22 15V9C22 4 20 2 15 2H9C4 2 2 4 2 9V15C2 20 4 22 9 22Z"
                            stroke="#DF2C56" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                        <path d="M2.23047 8.01L21.4505 8" stroke="#DF2C56" stroke-width="1.5" stroke-linecap="round"
                            stroke-linejoin="round" />
                    </svg>



                </div>
                <div class="traffic-lead__item">
                    <p>Чат-боты</p>
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M9 22H15C20 22 22 20 22 15V9C22 4 20 2 15 2H9C4 2 2 4 2 9V15C2 20 4 22 9 22Z"
                            stroke="#DF2C56" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                        <path
                            d="M15.5 9.75C16.3284 9.75 17 9.07843 17 8.25C17 7.42157 16.3284 6.75 15.5 6.75C14.6716 6.75 14 7.42157 14 8.25C14 9.07843 14.6716 9.75 15.5 9.75Z"
                            stroke="#DF2C56" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round"
                            stroke-linejoin="round" />
                        <path
                            d="M8.5 9.75C9.32843 9.75 10 9.07843 10 8.25C10 7.42157 9.32843 6.75 8.5 6.75C7.67157 6.75 7 7.42157 7 8.25C7 9.07843 7.67157 9.75 8.5 9.75Z"
                            stroke="#DF2C56" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round"
                            stroke-linejoin="round" />
                        <path
                            d="M8.4 13.3H15.6C16.1 13.3 16.5 13.7 16.5 14.2C16.5 16.69 14.49 18.7 12 18.7C9.51 18.7 7.5 16.69 7.5 14.2C7.5 13.7 7.9 13.3 8.4 13.3Z"
                            stroke="#DF2C56" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round"
                            stroke-linejoin="round" />
                    </svg>


                </div>
            </div>
        </div>
    </div>
</section>

<section class="traffic-acc__baner">
    <div class="container">

        <div class="traffic-acc__baner_wrapp">
            <div class="TQ__tool-form">
                <?= Html::beginForm('', 'post', ['id' => 'tool-form']) ?>
                <input type="hidden" name="URL" value="<?= $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] ?>">
                <input type="hidden" name="formType" value="Форма обратной связи">
                <input type="hidden" name="pipeline" value="104">
                <input type="hidden" name="utm_source" value="<?= $_SESSION['utm_source'] ?>">
                <input type="hidden" name="utm_campaign" value="<?= $_SESSION['utm_campaign'] ?>">
                <input type="hidden" name="section" value="Инструменты лидогенерации">
                <input type="hidden" name="ip" value="<?= $_SERVER['REMOTE_ADDR'] ?>">
                <input type="hidden" name="service" value="">
                <div class="Sec5-step1">
                    <p class="BLS5CDText-1 BLS5CDText-1--black">Хотите узнать подробнее?</p>
                    <p class="BLS5CDText-2 BLS5CDText-2--black">
                        Оставьте заявку на бесплатную консультацию с экспертом арбитража-трафика
                    </p>
                    <div class="Sec5-inputs">
                        <input class="Sec5-input fcstlt" type="text" name="name" placeholder="Имя" required>
                        <input class="Sec5-input fcstlt" type="tel" name="phone" placeholder="Телефон" required>

                        <button type="sabmit" class="btn-1">Купить лиды</button>
                    </div>
                </div>
                <div class="Sec5-step2">
                    <p class="BLS5CDText-1 BLS5CDText-1--black">Благодарим за заявку!</p>
                    <p class="BLS5CDText-2 BLS5CDText-2--black">
                        Наш менеждер проконсультирует вас в ближайшее время
                    </p>
                </div>
                <?= Html::endForm(); ?>
            </div>

            <img class="traffic-acc__baner_img" src="<?= Url::to('../img/mainimg/traffic-baner.png') ?>" alt="">
        </div>

    </div>
</section>

<section class="traffic-acc">
    <div class="container">
        <h2 class="traffic-acc__title">Самое важное</h2>
        <p class="traffic-acc__text">Мы ответили на самые популярные вопросы о лидогенерации, чтобы вы смогли более
            осознанно принять решение. </p>

        <div class="traffic-acc__wrapp">
            <div class="traffic-acc__item">
                <div class="traffic-acc__header">
                    <p>Какие данные присутствуют в лидах?</p>
                    <svg class="traffic-acc__close" width="36" height="36" viewBox="0 0 36 36" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path d="M12 18H24" stroke="url(#paint0_linear_263_12751)" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round" />
                        <path d="M18 24V12" stroke="url(#paint1_linear_263_12751)" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round" />
                        <path class="traffic-acc__rotate"
                            d="M13.5 33H22.5C30 33 33 30 33 22.5V13.5C33 6 30 3 22.5 3H13.5C6 3 3 6 3 13.5V22.5C3 30 6 33 13.5 33Z"
                            stroke="url(#paint2_linear_263_12751)" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" />
                        <defs>
                            <linearGradient id="paint0_linear_263_12751" x1="18" y1="18" x2="18" y2="19"
                                gradientUnits="userSpaceOnUse">
                                <stop stop-color="#DF2C56" />
                                <stop offset="1" stop-color="#C81F47" />
                            </linearGradient>
                            <linearGradient id="paint1_linear_263_12751" x1="18.5" y1="12" x2="18.5" y2="24"
                                gradientUnits="userSpaceOnUse">
                                <stop stop-color="#DF2C56" />
                                <stop offset="1" stop-color="#C81F47" />
                            </linearGradient>
                            <linearGradient id="paint2_linear_263_12751" x1="18" y1="3" x2="18" y2="33"
                                gradientUnits="userSpaceOnUse">
                                <stop stop-color="#DF2C56" />
                                <stop offset="1" stop-color="#C81F47" />
                            </linearGradient>
                        </defs>
                    </svg>
                </div>
                <div class="traffic-acc__content">
                    ФИО,
                    Регион, город,
                    контактные данные потенциального покупателя,
                    подробное описание того, что хочет приобрести потенциальный клиент.
                </div>
            </div>
            <div class="traffic-acc__item">
                <div class="traffic-acc__header">
                    <p>Когда начнут приходить первые лиды</p>
                    <svg class="traffic-acc__close" width="36" height="36" viewBox="0 0 36 36" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path d="M12 18H24" stroke="url(#paint0_linear_263_12751)" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round" />
                        <path d="M18 24V12" stroke="url(#paint1_linear_263_12751)" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round" />
                        <path class="traffic-acc__rotate"
                            d="M13.5 33H22.5C30 33 33 30 33 22.5V13.5C33 6 30 3 22.5 3H13.5C6 3 3 6 3 13.5V22.5C3 30 6 33 13.5 33Z"
                            stroke="url(#paint2_linear_263_12751)" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" />
                        <defs>
                            <linearGradient id="paint0_linear_263_12751" x1="18" y1="18" x2="18" y2="19"
                                gradientUnits="userSpaceOnUse">
                                <stop stop-color="#DF2C56" />
                                <stop offset="1" stop-color="#C81F47" />
                            </linearGradient>
                            <linearGradient id="paint1_linear_263_12751" x1="18.5" y1="12" x2="18.5" y2="24"
                                gradientUnits="userSpaceOnUse">
                                <stop stop-color="#DF2C56" />
                                <stop offset="1" stop-color="#C81F47" />
                            </linearGradient>
                            <linearGradient id="paint2_linear_263_12751" x1="18" y1="3" x2="18" y2="33"
                                gradientUnits="userSpaceOnUse">
                                <stop stop-color="#DF2C56" />
                                <stop offset="1" stop-color="#C81F47" />
                            </linearGradient>
                        </defs>
                    </svg>
                </div>
                <div class="traffic-acc__content">
                    Первые лиды начнут появляется примерно в течении 3–5 дней после создания размещения и оплаты заказа.
                    Но при необходимости мы можем более оперативно запустить ваш заказ в работу.
                </div>
            </div>
            <div class="traffic-acc__item">
                <div class="traffic-acc__header">
                    <p>Сколько стоит лид?</p>
                    <svg class="traffic-acc__close" width="36" height="36" viewBox="0 0 36 36" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path d="M12 18H24" stroke="url(#paint0_linear_263_12751)" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round" />
                        <path d="M18 24V12" stroke="url(#paint1_linear_263_12751)" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round" />
                        <path class="traffic-acc__rotate"
                            d="M13.5 33H22.5C30 33 33 30 33 22.5V13.5C33 6 30 3 22.5 3H13.5C6 3 3 6 3 13.5V22.5C3 30 6 33 13.5 33Z"
                            stroke="url(#paint2_linear_263_12751)" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" />
                        <defs>
                            <linearGradient id="paint0_linear_263_12751" x1="18" y1="18" x2="18" y2="19"
                                gradientUnits="userSpaceOnUse">
                                <stop stop-color="#DF2C56" />
                                <stop offset="1" stop-color="#C81F47" />
                            </linearGradient>
                            <linearGradient id="paint1_linear_263_12751" x1="18.5" y1="12" x2="18.5" y2="24"
                                gradientUnits="userSpaceOnUse">
                                <stop stop-color="#DF2C56" />
                                <stop offset="1" stop-color="#C81F47" />
                            </linearGradient>
                            <linearGradient id="paint2_linear_263_12751" x1="18" y1="3" x2="18" y2="33"
                                gradientUnits="userSpaceOnUse">
                                <stop stop-color="#DF2C56" />
                                <stop offset="1" stop-color="#C81F47" />
                            </linearGradient>
                        </defs>
                    </svg>
                </div>
                <div class="traffic-acc__content">
                    Стоимость лидов согласовывается индивидуально с нашим менеджером, цена зависит от ваших требований к
                    лидам и источникам получения лидов. Например лиды, полученные с форм заявок сайтов стоят дороже чем
                    лиды получение с рассылок.
                </div>
            </div>
            <div class="traffic-acc__item">
                <div class="traffic-acc__header">
                    <p>Как проходит работа?</p>
                    <svg class="traffic-acc__close" width="36" height="36" viewBox="0 0 36 36" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path d="M12 18H24" stroke="url(#paint0_linear_263_12751)" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round" />
                        <path d="M18 24V12" stroke="url(#paint1_linear_263_12751)" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round" />
                        <path class="traffic-acc__rotate"
                            d="M13.5 33H22.5C30 33 33 30 33 22.5V13.5C33 6 30 3 22.5 3H13.5C6 3 3 6 3 13.5V22.5C3 30 6 33 13.5 33Z"
                            stroke="url(#paint2_linear_263_12751)" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" />
                        <defs>
                            <linearGradient id="paint0_linear_263_12751" x1="18" y1="18" x2="18" y2="19"
                                gradientUnits="userSpaceOnUse">
                                <stop stop-color="#DF2C56" />
                                <stop offset="1" stop-color="#C81F47" />
                            </linearGradient>
                            <linearGradient id="paint1_linear_263_12751" x1="18.5" y1="12" x2="18.5" y2="24"
                                gradientUnits="userSpaceOnUse">
                                <stop stop-color="#DF2C56" />
                                <stop offset="1" stop-color="#C81F47" />
                            </linearGradient>
                            <linearGradient id="paint2_linear_263_12751" x1="18" y1="3" x2="18" y2="33"
                                gradientUnits="userSpaceOnUse">
                                <stop stop-color="#DF2C56" />
                                <stop offset="1" stop-color="#C81F47" />
                            </linearGradient>
                        </defs>
                    </svg>
                </div>
                <div class="traffic-acc__content">
                    Пройдите регистрацию в личном кабинете,
                    Оформляете заявку через интерфейс (или через нашего менеджера), подробно описав вашу услугу (для
                    составления нашими специалистами рекламного объявления);
                    Пополните баланс,
                    Мы начинаем собирать лиды и выкладывать их в личный кабинет,
                    Вы обрабатываете лиды и зарабатываете на них!
                </div>
            </div>
        </div>
    </div>
</section>

<section class="By__Leads__Sec9">
    <div class="container">
        <div class="By__Leads__Sec9__content">
            <h3 class="TL_h8v">Рассчитайте свою прибыль и закажите лиды прямо сейчас!</h3>
            <div class="TL_inp8">
                <div class="TL_inp8-content">
                    <div class="TL_inputtext flex aic fww">
                        <p class="TL_p8">Количество лидов</p>
                        <input class="TL_input_text tac number1" type="number" min="100" max="1000" step="100"
                            value="500" id="text">
                    </div>
                    <div class="Tl__wrapp">
                        <input class="TL_input_range" type="range" min="0" max="1000" value="500" step="100"
                            id="slider">
                        <span></span>
                    </div>

                    <div class="TL_p88 flex aic fww">
                        <div class="lite__fix">
                            <p class="TL_p8">Средний процент конверсии</p>
                            <h4 class="TL_h8 TL_h8w number1">9,5%</h4>
                        </div>

                        <div class="lite__fix">
                            <p class="TL_p8">Средняя стоимость лида</p>
                            <h4 class="TL_h8 TL_h8w">500 рублей</h4>
                        </div>
                    </div>
                    <div class="TL_inp9 flex fww">
                        <h4 class="TL_h8 TL_h8 total">Ваша прибыль</h4>
                        <input class="TL_inp9inp tac" type="text" id="result" disabled>
                    </div>
                </div>
                <div class="Tl9__wrapp">
                    <div class="TL_inp8-form">
                        <p class="TL_inp8-form-title">
                            Закажите лиды прямой сейчас!
                        </p>
                        <div class="TL_inp8-form-inner">
                            <?= Html::beginForm(Url::to(['/site/form']), 'post', ['id' => 'form-TL_inp8']) ?>
                            <input type="hidden" name="URL"
                                value="<?= $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] ?>">
                            <input type="hidden" name="formType" value="Форма для получения 10 бесплатных лидов">
                            <input type="hidden" name="pipeline" value="104">
                            <input type="hidden" name="service" value="">
                            <input type="hidden" name="section"
                                value="Рассчитайте свою прибыль и закажите лиды прямо сейчас!">
                            <input type="hidden" name="utm_source" value="<?= $_SESSION['utm_source'] ?>">
                            <input type="hidden" name="utm_campaign" value="<?= $_SESSION['utm_campaign'] ?>">

                            <input class="TL_inp8-input" required placeholder="Сфера бизнеса" type="text"
                                name="comments[sphere]" id="sphere2">
                            <input type="text" required="required" class="TL_inp8-input region" placeholder="Ваш регион"
                                name="region" id="region2">
                            <input class="TL_inp8-input" required pattern="[0-9]*" placeholder="Количество лидов в день"
                                type="text" name="comments[lead_day]" id="lids2">
                            <?php if (Yii::$app->user->isGuest):?>
                            <a href="<?= Url::to(["/registr?site=lead"])?>" class="btnsbmtfc">Получить</a>
                            <?php else:?>
                            <button class="btnsbmtfc" type="submit">Получить</button>
                            <?php endif?>
                            <?= Html::endForm(); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>