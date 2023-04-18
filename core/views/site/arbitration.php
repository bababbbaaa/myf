<?php

use yii\helpers\Url;

$this->title = 'Арбитражное управление при банкротстве физических и юридических лиц';
$this->registerCssFile(Url::to(['/css/arbitraj/style.css']));
$css =<<< CSS
    .header {
        background: #000E1A;
        border-bottom: none;
    }

    .main {
        margin-top: 78px;
    }

    .header__active {
        animation-name: none;
    }

    @media (max-width: 890px) {
        .main {
            margin-top: 72px;
         }
    }

    @media (max-width: 600px) {
      .main {
        margin-top: 70px;
      }
    }

    @media (max-width: 400px) {
      .main {
        margin-top: 64px;
      }
    }

CSS;
$this->registerCss($css);
?>
<section class="main">
    <div class="arbitration__background">
        <div class="arbitration__content container">
            <h1>Арбитражное управление при банкротстве физических и юридических лиц</h1>
            <div>
                Более 60 арбитражных управляющих в системе! Являемся членами совета СРО!
            </div>
            <a href="<?= Url::to(['arbitraj-tnx']) ?>">
                <button class="arbitration-btn">Узнать подробнее</button>
            </a>
        </div>
    </div>
</section>

<section class="about">
    <div class="container">
        <div class="about-container">
            <div class="about-top-container">
                <div class="about__text">
                    <h2>О нас</h2>
                    <div>
                        <span>Партнерская программа MYFORCE — </span>
                        делегируйте арбитражное управление своих банкротов профессионалам
                        с гарантией на снятие прожиточных минимумов в срок
                    </div>
                </div>

                <div class="about__cards">
                    <div class="cards-container">
                        <div class="about__options">
                            <div>
                                <img src="<?= Url::to(['/img//arbitraj/arbitration-about-1.webp']) ?>" alt="">
                            </div>
                            <div>
                                Бесплатные консультации и аудит сложных банкротов
                            </div>
                        </div>
                        <div class="about__options">
                            <div>
                                <img src="<?= Url::to(['/img/arbitraj/arbitration-about-2.webp']) ?>" alt="">
                            </div>
                            <div>
                                Гарантия на арбитражное управление — 100% банкротим до конца
                            </div>
                        </div>
                    </div>

                    <div class="cards-container">
                        <div class="about__options">
                            <div>
                                <img src="<?= Url::to(['/img/arbitraj/arbitration-about-3.webp']) ?>" alt="">
                            </div>
                            <div>
                                Гарантия на цену — никогда не увеличиваем стоимость услуг
                            </div>
                        </div>
                        <div class="about__options">
                            <div>
                                <img src="<?= Url::to(['/img/arbitraj/arbitration-about-4.webp']) ?>" alt="">
                            </div>
                            <div>
                                База знаний из более чем 100 материалов по банкротству и списанию долгов
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="about-bottom-container">
                <div class="about__img">
                    <img src="<?= Url::to(['/img/arbitraj/arbitration-about.png']) ?>" alt="">
                </div>
                <div class="about__advantages">
                    <div class="advantages-item">
                        <div>6 лет успешной работы</div>
                        <div>
                            Каждый день мы помогаем нашим партнерам заключать больше договоров по банкротству.
                        </div>
                    </div>
                    <div class="advantages-item">
                        <div>95 партнеров по всей стране</div>
                        <div>
                            Мы хотим, ч тобы наши партнеры были лидерами
                            в нише банкротства в своем регионе. Для этого мы обучаем партнеров технологиям
                            эффективных продаж, продвижения, маркетинга, оптимизации бизнес-процессов и т. д.
                        </div>
                    </div>
                    <div class="advantages-item">
                        <div>Более 9 000 успешных дел по банкротству</div>
                        <div>
                            Мы работаем как с простыми проектами, так и многосложными сценариями проведения процедуры.
                            Наша команда освободила от долгов более 9000 граждан по всей стране.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</section>

<section class="packages">
    <div class="container">
        <h2>Пакеты</h2>
        <div class="packages__container">
            <div class="package__main">
                <div class="packages__package">
                    <div class="packages__name">пакет</div>
                    <div class="packages__type">Стандартный пакет</div>
                    <div class="packages__includes">
                        Что входит?
                        <div class="package__item">
                            <div>
                                <img src="<?= Url::to(['/img/arbitraj/arbitration-includes.webp']) ?>" alt="">
                            </div>
                            <div>1 анкета банкрота для бесплатного анализа проблемы;</div>
                        </div>
                        <div class="package__item">
                            <div>
                                <img src="<?= Url::to(['/img/arbitraj/arbitration-includes.webp']) ?>" alt="">
                            </div>
                            <div>Консультация в рамках анкеты банкрота;</div>
                        </div>
                        <div class="package__item">
                            <div>
                                <img src="<?= Url::to(['/img/arbitraj/arbitration-includes.webp']) ?>" alt="">
                            </div>
                            <div>Процедура банкротства физ.лица с гарантиями на работу;</div>
                        </div>
                        Арбитражное управление
                        <div class="package__item">
                            <div>
                                <img src="<?= Url::to(['/img/arbitraj/arbitration-includes.webp']) ?>" alt="">
                            </div>
                            <div>10 000 р. – оплата команды АУ</div>
                        </div>
                        <div class="package__item">
                            <div>
                                <img src="<?= Url::to(['/img/arbitraj/arbitration-includes.webp']) ?>" alt="">
                            </div>
                            <div>15 000 р. – оплата публикации</div>
                        </div>
                        <div class="package__item">
                            <div>
                                <img src="<?= Url::to(['/img/arbitraj/arbitration-includes.webp']) ?>" alt="">
                            </div>
                            <div>25 000 р. – оплата депозита</div>
                        </div>
                        Команда
                        <div class="package__item">
                            <div>
                                <img src="<?= Url::to(['/img/arbitraj/arbitration-includes.webp']) ?>" alt="">
                            </div>
                            <div>Персональный АУ – 1 чел</div>
                        </div>
                        <div class="package__item">
                            <div>
                                <img src="<?= Url::to(['/img/arbitraj/arbitration-includes.webp']) ?>" alt="">
                            </div>
                            <div>Эксперт по рискам – 1 чел.</div>
                        </div>
                        <div class="package__item">
                            <div>
                                <img src="<?= Url::to(['/img/arbitraj/arbitration-includes.webp']) ?>" alt="">
                            </div>
                            <div>ПАУ – 1 чел.</div>
                        </div>
                        <div class="package__item">
                            <div>
                                <img src="<?= Url::to(['/img/arbitraj/arbitration-includes.webp']) ?>" alt="">
                            </div>
                            <div>Специалист фин.отдела – 1 чел.</div>
                        </div>
                    </div>
                </div>

                <div class="packages__sub">
                    <div class="packages__sum-per-one">
                        <span>10 000 ₽</span>/ 1 банкрот
                    </div>
                    <div class="packages__sub-more">узнайте больше о пакете</div>
                    <a href="<?= Url::to(['arbitraj-tnx']) ?>">
                        <button class="arbitration-btn">Узнать подробнее</button>
                    </a>
                </div>
            </div>

            <div class="package__main">
                <div class="packages__package">
                    <div class="packages__name">пакет</div>
                    <div class="packages__type">Средний арбитраж</div>
                    <div class="packages__includes">
                        Что входит?
                        <div class="package__item">
                            <div>
                                <img src="<?= Url::to(['/img/arbitraj/arbitration-includes.webp']) ?>" alt="">
                            </div>
                            <div>До 30 анкет клиентов в месяц;</div>
                        </div>
                        <div class="package__item">
                            <div>
                                <img src="<?= Url::to(['/img/arbitraj/arbitration-includes.webp']) ?>" alt="">
                            </div>
                            <div>Поиск по базе данных завершенных дел;</div>
                        </div>
                        <div class="package__item">
                            <div>
                                <img src="<?= Url::to(['/img/arbitraj/arbitration-includes.webp']) ?>" alt="">
                            </div>
                            <div>Рабочие алгоритмы решения вопросов;</div>
                        </div>
                        <div class="package__item">
                            <div>
                                <img src="<?= Url::to(['/img/arbitraj/arbitration-includes.webp']) ?>" alt="">
                            </div>
                            <div>Консультация в рамках анкет банкротов;</div>
                        </div>
                        <div class="package__item">
                            <div>
                                <img src="<?= Url::to(['/img/arbitraj/arbitration-includes.webp']) ?>" alt="">
                            </div>
                            <div>Проведение процедур с гарантиями на работу</div>
                        </div>
                        Арбитражное управление
                        <div class="package__item">
                            <div>
                                <img src="<?= Url::to(['/img/arbitraj/arbitration-includes.webp']) ?>" alt="">
                            </div>
                            <div>В зависимости от объема дел – оплата команды АУ</div>
                        </div>
                        <div class="package__item">
                            <div>
                                <img src="<?= Url::to(['/img/arbitraj/arbitration-includes.webp']) ?>" alt="">
                            </div>
                            <div>15 000 р. – оплата публикации</div>
                        </div>
                        <div class="package__item">
                            <div>
                                <img src="<?= Url::to(['/img/arbitraj/arbitration-includes.webp']) ?>" alt="">
                            </div>
                            <div>25 000 р. – оплата депозита</div>
                        </div>
                        Команда
                        <div class="package__item">
                            <div>
                                <img src="<?= Url::to(['/img/arbitraj/arbitration-includes.webp']) ?>" alt="">
                            </div>
                            <div>Персональный АУ – 2 чел</div>
                        </div>
                        <div class="package__item">
                            <div>
                                <img src="<?= Url::to(['/img/arbitraj/arbitration-includes.webp']) ?>" alt="">
                            </div>
                            <div>Эксперт по рискам – 1 чел.</div>
                        </div>
                        <div class="package__item">
                            <div>
                                <img src="<?= Url::to(['/img/arbitraj/arbitration-includes.webp']) ?>" alt="">
                            </div>
                            <div>ПАУ – 4 чел.</div>
                        </div>
                        <div class="package__item">
                            <div>
                                <img src="<?= Url::to(['/img/arbitraj/arbitration-includes.webp']) ?>" alt="">
                            </div>
                            <div>Специалист фин.отдела – 3 чел.</div>
                        </div>
                    </div>
                </div>

                <div class="packages__sub">
                    <div class="packages__info">От 10 дел в месяц, при единовременной оплате 80 000;</div>
                    <div class="packages__info">От 30 дел в месяц, при единовременной оплате 185 000₽;</div>
                    <div class="packages__sub-more">узнайте больше о пакете</div>
                    <a href="<?= Url::to(['arbitraj-tnx']) ?>">
                        <button class="arbitration-btn">Узнать подробнее</button>
                    </a>
                </div>
            </div>

            <div class="package__main">
                <div class="packages__package">
                    <div class="packages__name">пакет</div>
                    <div class="packages__type">Крупный арбитраж</div>
                    <div class="packages__includes">
                        Что входит?
                        <div class="package__item">
                            <div>
                                <img src="<?= Url::to(['/img/arbitraj/arbitration-includes.webp']) ?>" alt="">
                            </div>
                            <div>Анкеты в месяц без ограничений;</div>
                        </div>
                        <div class="package__item">
                            <div>
                                <img src="<?= Url::to(['/img/arbitraj/arbitration-includes.webp']) ?>" alt="">
                            </div>
                            <div>Консультации в рамках анкет банкротов;</div>
                        </div>
                        <div class="package__item">
                            <div>
                                <img src="<?= Url::to(['/img/arbitraj/arbitration-includes.webp']) ?>" alt="">
                            </div>
                            <div>Поиск по базе данных замершенных дел;</div>
                        </div>
                        <div class="package__item">
                            <div>
                                <img src="<?= Url::to(['/img/arbitraj/arbitration-includes.webp']) ?>" alt="">
                            </div>
                            <div>Рабочие алгоритмы решения вопросов;</div>
                        </div>
                        <div class="package__item">
                            <div>
                                <img src="<?= Url::to(['/img/arbitraj/arbitration-includes.webp']) ?>" alt="">
                            </div>
                            <div>Делегирование общения с клиентами на АУ;</div>
                        </div>
                        <div class="package__item">
                            <div>
                                <img src="<?= Url::to(['/img/arbitraj/arbitration-includes.webp']) ?>" alt="">
                            </div>
                            <div>Проведение процедур с гарантиями на работу;</div>
                        </div>
                        Арбитражное управление
                        <div class="package__item">
                            <div>
                                <img src="<?= Url::to(['/img/arbitraj/arbitration-includes.webp']) ?>" alt="">
                            </div>
                            <div>4 800 р. – оплата команды АУ</div>
                        </div>
                        <div class="package__item">
                            <div>
                                <img src="<?= Url::to(['/img/arbitraj/arbitration-includes.webp']) ?>" alt="">
                            </div>
                            <div>15 000 р. – оплата публикации</div>
                        </div>
                        <div class="package__item">
                            <div>
                                <img src="<?= Url::to(['/img/arbitraj/arbitration-includes.webp']) ?>" alt="">
                            </div>
                            <div>25 000 р. – оплата депозита</div>
                        </div>
                        Команда
                        <div class="package__item">
                            <div>
                                <img src="<?= Url::to(['/img/arbitraj/arbitration-includes.webp']) ?>" alt="">
                            </div>
                            <div>Персональный АУ – 5 чел</div>
                        </div>
                        <div class="package__item">
                            <div>
                                <img src="<?= Url::to(['/img/arbitraj/arbitration-includes.webp']) ?>" alt="">
                            </div>
                            <div>Эксперт по рискам – 4 чел.</div>
                        </div>
                        <div class="package__item">
                            <div>
                                <img src="<?= Url::to(['/img/arbitraj/arbitration-includes.webp']) ?>" alt="">
                            </div>
                            <div>ПАУ – 7 чел.</div>
                        </div>
                        <div class="package__item">
                            <div>
                                <img src="<?= Url::to(['/img/arbitraj/arbitration-includes.webp']) ?>" alt="">
                            </div>
                            <div>Специалист фин.отдела – 5 чел.</div>
                        </div>
                    </div>
                </div>

                <div class="packages__sub">
                    <div class="packages__sum-per-one">
                        <span>4 800 ₽</span>/ 1 банкрот
                    </div>
                    <div class="packages__info">От 50 дел в месяц, при единовременной оплате 240 000₽:</div>
                    <div class="packages__sub-more">узнайте больше о пакете</div>
                    <a href="<?= Url::to(['arbitraj-tnx']) ?>">
                        <button class="arbitration-btn">Узнать подробнее</button>
                    </a>
                </div>
            </div>

            <div class="package__main">
                <div class="packages__package">
                    <div class="packages__name">пакет</div>
                    <div class="packages__type">ПРОБНЫЙ ТАРИФ</div>
                    <div class="packages__includes">
                        Что входит?
                        <div class="package__item">
                            <div>
                                <img src="<?= Url::to(['/img/arbitraj/arbitration-includes.webp']) ?>" alt="">
                            </div>
                            <div>1 анкета банкрота для бесплатного анализа проблемы; </div>
                        </div>
                        <div class="package__item">
                            <div>
                                <img src="<?= Url::to(['/img/arbitraj/arbitration-includes.webp']) ?>" alt="">
                            </div>
                            <div>Консультация в рамках анкеты банкрота;</div>
                        </div>
                        <div class="package__item">
                            <div>
                                <img src="<?= Url::to(['/img/arbitraj/arbitration-includes.webp']) ?>" alt="">
                            </div>
                            <div>Процедура банкротства физ.лица с гарантиями на работу; </div>
                        </div>
                        Арбитражное управление
                        <div class="package__item">
                            <div>
                                <img src="<?= Url::to(['/img/arbitraj/arbitration-includes.webp']) ?>" alt="">
                            </div>
                            <div>0 р. – оплата команды АУ</div>
                        </div>
                        <div class="package__item">
                            <div>
                                <img src="<?= Url::to(['/img/arbitraj/arbitration-includes.webp']) ?>" alt="">
                            </div>
                            <div>16 000 р. – оплата публикации</div>
                        </div>
                        <div class="package__item">
                            <div>
                                <img src="<?= Url::to(['/img/arbitraj/arbitration-includes.webp']) ?>" alt="">
                            </div>
                            <div>25 000 р. – оплата депозита</div>
                        </div>
                        Команда
                        <div class="package__item">
                            <div>
                                <img src="<?= Url::to(['/img/arbitraj/arbitration-includes.webp']) ?>" alt="">
                            </div>
                            <div>Персональный АУ – 1 чел.</div>
                        </div>
                        <div class="package__item">
                            <div>
                                <img src="<?= Url::to(['/img/arbitraj/arbitration-includes.webp']) ?>" alt="">
                            </div>
                            <div>Эксперт по рискам – 1 чел.</div>
                        </div>
                        <div class="package__item">
                            <div>
                                <img src="<?= Url::to(['/img/arbitraj/arbitration-includes.webp']) ?>" alt="">
                            </div>
                            <div>ПАУ – 1 чел.</div>
                        </div>
                        <div class="package__item">
                            <div>
                                <img src="<?= Url::to(['/img/arbitraj/arbitration-includes.webp']) ?>" alt="">
                            </div>
                            <div>Специалист фин.отдела – 1 чел.</div>
                        </div>
                    </div>
                </div>

                <div class="packages__sub">
                    <div class="packages__sum-per-one">
                        <span>0 ₽</span>/ 1 банкрот
                    </div>
                    <div class="packages__sub-more">узнайте больше о пакете</div>
                    <a href="<?= Url::to(['arbitraj-tnx']) ?>">
                        <button class="arbitration-btn">Узнать подробнее</button>
                    </a>
                </div>
            </div>

            <div class="packages__sub-info">
                * В случае не передачи количества оплаченных анкет в текущем месяце , анкеты могут передаваться
                в последующих, по договорённости с исполнителем.
            </div>
        </div>
    </div>
</section>

<section class="services">
    <div class="container">
        <h2>УСЛУГИ АРБИТРАЖНЫХ УПРАВЛЯЮЩИХ</h2>
        <div class="services__info">Вы можете выбрать отдельную услугу</div>
        <div class="services__container">
            <div class="services__main">
                <div class="services__service">
                    <div class="services__name">Анализ банкрота</div>
                    <div class="services__includes">
                        Что получаем?
                        <div class="services__item">
                            <div>
                                <img src="<?= Url::to(['/img/arbitraj/arbitration-includes.webp']) ?>" alt="">
                            </div>
                            <div>1 анкета банкрота для бесплатного анализа проблемы;</div>
                        </div>
                        <div class="services__item">
                            <div>
                                <img src="<?= Url::to(['/img/arbitraj/arbitration-includes.webp']) ?>" alt="">
                            </div>
                            <div>Консультация в рамках анкеты банкрота;</div>
                        </div>
                    </div>
                </div>

                <div class="services__sub">
                    <div class="services__sum-per-one">
                        <span>1 900 ₽</span> / 1 дело
                    </div>
                    <div class="services__sub-more">узнайте больше об услуге</div>
                    <a href="<?= Url::to(['arbitraj-tnx']) ?>">
                        <button class="arbitration-btn">Узнать подробнее</button>
                    </a>
                </div>
            </div>

            <div class="services__main">
                <div class="services__service">
                    <div class="services__name">Сбор и подача документов</div>
                    <div class="services__includes">
                        Что получаем?
                        <div class="services__item">
                            <div>
                                <img src="<?= Url::to(['/img/arbitraj/arbitration-includes.webp']) ?>" alt="">
                            </div>
                            <div>Полный комплект документов</div>
                        </div>
                        <div class="services__item">
                            <div>
                                <img src="<?= Url::to(['/img/arbitraj/arbitration-includes.webp']) ?>" alt="">
                            </div>
                            <div>Правильное обоснование и иск</div>
                        </div>
                        <div class="services__item">
                            <div>
                                <img src="<?= Url::to(['/img/arbitraj/arbitration-includes.webp']) ?>" alt="">
                            </div>
                            <div>Подача в суд через ЭЦП</div>
                        </div>
                        <div class="services__item">
                            <div>
                                <img src="<?= Url::to(['/img/arbitraj/arbitration-includes.webp']) ?>" alt="">
                            </div>
                            <div>Гарантии на качество</div>
                        </div>
                        <div class="services__item">
                            <div>
                                <img src="<?= Url::to(['/img/arbitraj/arbitration-includes.webp']) ?>" alt="">
                            </div>
                            <div>
                                <span>Заключение и стратегия в ПОДАРОК</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="services__sub">
                    <div class="services__sum-per-one">
                        <span>10 000 ₽</span> / 1 дело
                    </div>
                    <div class="services__sub-more">узнайте больше об услуге</div>
                    <a href="<?= Url::to(['arbitraj-tnx']) ?>">
                        <button class="arbitration-btn">Узнать подробнее</button>
                    </a>
                </div>
            </div>

            <div class="services__main">
                <div class="services__service">
                    <div class="services__name">Составление итоговых документов</div>
                    <div class="services__includes">
                        Что получаем?
                        <div class="services__item">
                            <div>
                                <img src="<?= Url::to(['/img/arbitraj/arbitration-includes.webp']) ?>" alt="">
                            </div>
                            <div>Заявление о признании банкротом</div>
                        </div>
                        <div class="services__item">
                            <div>
                                <img src="<?= Url::to(['/img/arbitraj/arbitration-includes.webp']) ?>" alt="">
                            </div>
                            <div>Опись кредиторов</div>
                        </div>
                        <div class="services__item">
                            <div>
                                <img src="<?= Url::to(['/img/arbitraj/arbitration-includes.webp']) ?>" alt="">
                            </div>
                            <div>Опись имущества</div>
                        </div>
                        <div class="services__item">
                            <div>
                                <img src="<?= Url::to(['/img/arbitraj/arbitration-includes.webp']) ?>" alt="">
                            </div>
                            <div>Объяснение о причинах признания несостоятельным</div>
                        </div>
                        <div class="services__item-info">
                            *при условии наличия готового пакета документов в соответсвии
                            со статьей 213.4 п.3 ФЗ #127 «О несостоятельности (банкротстве)»
                        </div>
                    </div>
                </div>
                <div class="services__sub">
                    <div class="services__sum-per-one">
                        <span>7 500 ₽</span> / 1 дело
                    </div>
                    <div class="services__sub-more">узнайте больше об услуге</div>
                    <a href="<?= Url::to(['arbitraj-tnx']) ?>">
                        <button class="arbitration-btn">Узнать подробнее</button>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="successful-cases">
    <div class="container">
        <h2>Успешные дела</h2>
        <div>Гарантрируем 100% результат</div>
        <div class="cases__container">
            <div class="case__container">
                <a class="case__link-link" target="_blank"
                    href="<?= Url::to('https://kad.arbitr.ru/Document/Pdf/6fca2fd2-c508-4965-b289-f37045798a05/10311070-ac6a-435b-a771-fc36415cf54c/A53-44457-2020_20220705_Opredelenie.pdf?isAddStamp=True') ?>"></a>
                <div class="case__text">
                    <div>
                        Регион<br>
                        <span>Ростовская область</span>
                    </div>
                    <div>
                        Номер дела<br>
                        <span>А53-44457</span>
                    </div>
                    <div>
                        Списано<br>
                        <span>2 197 602 р</span>
                    </div>
                </div>
                <div class="case__img">
                    <img src="<?= Url::to(['/img/arbitraj/arbitration-cases.png']) ?>" alt="">
                </div>
            </div>

            <div class="case__container">
                <a class="case__link-link" target="_blank"
                    href="<?= Url::to('https://kad.arbitr.ru/Document/Pdf/ea319947-c0c9-4588-9405-d1229c492a83/c47f0d3a-5f9e-47bd-b0bc-ab4da65fbf13/A19-6345-2021_20220729_Opredelenie.pdf?isAddStamp=True') ?>"></a>
                <div class="case__text">
                    <div>
                        Регион<br>
                        <span>Иркутская область</span>
                    </div>
                    <div>
                        Номер дела<br>
                        <span>А19-6345</span>
                    </div>
                    <div>
                        Списано<br>
                        <span>394 776 р</span>
                    </div>
                </div>
                <div class="case__img">
                    <img src="<?= Url::to(['/img/arbitraj/arbitration-cases.png']) ?>" alt="">
                </div>
            </div>

            <div class="case__container">
                <a class="case__link-link" target="_blank"
                    href="<?= Url::to('https://kad.arbitr.ru/Document/Pdf/f0711ae2-6169-4526-95f5-4b12989fba4a/7f6a90f4-89d4-4016-ad01-ad5828662640/A33-7829-2021_20220711_Opredelenie.pdf?isAddStamp=True') ?>"></a>
                <div class="case__text">
                    <div>
                        Регион<br>
                        <span>Красноярский край</span>
                    </div>
                    <div>
                        Номер дела<br>
                        <span>А33-7829</span>
                    </div>
                    <div>
                        Списано<br>
                        <span>366 616 р</span>
                    </div>
                </div>
                <div class="case__img">
                    <img src="<?= Url::to(['/img/arbitraj/arbitration-cases.png']) ?>" alt="">
                </div>
            </div>

            <div class="case__container">
                <a class="case__link-link" target="_blank"
                    href="<?= Url::to('https://kad.arbitr.ru/Document/Pdf/aa13eada-aa27-476e-a4bc-b2e4dd325286/f93233b4-798e-4fca-8358-aa2f0936787a/A45-12593-2021_20220708_Opredelenie.pdf?isAddStamp=True') ?>"></a>
                <div class="case__text">
                    <div>
                        Регион<br>
                        <span>Новосибирская область</span>
                    </div>
                    <div>
                        Номер дела<br>
                        <span>А45-12593</span>
                    </div>
                    <div>
                        Списано<br>
                        <span>1 796 823 р</span>
                    </div>
                </div>
                <div class="case__img">
                    <img src="<?= Url::to(['/img/arbitraj/arbitration-cases.png']) ?>" alt="">
                </div>
            </div>

            <div class="case__container">
                <a class="case__link-link" target="_blank"
                    href="<?= Url::to('https://kad.arbitr.ru/Document/Pdf/aadec1e5-6fb6-449d-8531-d762134df74a/cdece17c-e5de-4b8f-b746-cb8a4d7c94d2/A19-12071-2021_20210720_Opredelenie.pdf?isAddStamp=True') ?>"></a>
                <div class="case__text">
                    <div>
                        Регион<br>
                        <span>Иркутская область</span>
                    </div>
                    <div>
                        Номер дела<br>
                        <span>А19-12071</span>
                    </div>
                    <div>
                        Списано<br>
                        <span>1 493 681 р</span>
                    </div>
                </div>
                <div class="case__img">
                    <img src="<?= Url::to(['/img/arbitraj/arbitration-cases.png']) ?>" alt="">
                </div>
            </div>

            <div class="case__container">
                <a class="case__link-link" target="_blank"
                    href="<?= Url::to('https://kad.arbitr.ru/Document/Pdf/eb9cfa5d-96a4-4907-b2f0-241a630dd65d/3ba88c11-0ca7-460c-a612-a834628fe516/A49-5777-2021_20220720_Opredelenie.pdf?isAddStamp=True') ?>"></a>
                <div class="case__text">
                    <div>
                        Регион<br>
                        <span>Пензенская область</span>
                    </div>
                    <div>
                        Номер дела<br>
                        <span>А49-5777</span>
                    </div>
                    <div>
                        Списано<br>
                        <span>546 975 р</span>
                    </div>
                </div>
                <div class="case__img">
                    <img src="<?= Url::to(['/img/arbitraj/arbitration-cases.png']) ?>" alt="">
                </div>
            </div>

        </div>
    </div>

</section>