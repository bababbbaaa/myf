<?php
/* @var $this yii\web\View */

use yii\helpers\Url;

$guest = Yii::$app->user->isGuest;

$this->title = 'Как COVID-19 повлиял на расклад сил на страховом рынке';
?>

<div class="container">
  <div class="pow articles">
    <div class="rol-3 NavsMenu">
      <div class="NavsNews">
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
      </div>
      <div class="NavsStat d-None">
        <h6>Популярные статьи</h6>
        <div class="NavsStat__inner">
          <a href="<?= Url::to('vidu-franchizy') ?>" class="popularАrticlesCard">
            <img src="<?= Url::to(['/img/Rectangle 46-1.webp']) ?>" alt="picture of article">
            <p class="cardTextP1">Виды франшиз: классификация по характеру взаимоотношений</p>
            <p class="cardTextP2">Статья по франчайзингу</p>
          </a>
          <a href="<?= Url::to('chto-takoe-franchaizing') ?>" class="popularАrticlesCard">
            <img src="<?= Url::to(['/img/Rectangle 46-2.webp']) ?>" alt="picture of article">
            <p class="cardTextP1">Что такое франчайзинг: нормы и законы</p>
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
      <div style="background-image: url('<?= Url::to(['/img/Rectangle 178-2.webp']) ?>')" class="photoArticles">
        <h1 class="BodyTexted__title">Как COVID-19 повлиял на расклад сил на страховом рынке</h1>
        <h2 class="BodyTexted__title">Расскажем о том, как пандемия изменила привычный образ жизни в различных сферах бизнеса, а именно
          на страховом рынке</h2>
        <p class="photoArticlesp2">Прокопенко Ольга, 24.12.2020</p>
      </div>
      <div class="textArticles">
        <br>
        <p>Пандемия коронавируса изменила привычный образ жизни во многих сегментах бизнеса. Даже для самых ярых
          консерваторов очевидно, что мир вступил в новую эру в начале 2020 года. COVID-19 в считанные недели
          разрушил привычный порядок вещей и буквально переписал реальность, перевернув баланс сил
          в большинстве сегментов мирового рынка с ног на голову. В том числе и в сфере страхования.<br><br>
          Проблемы классических страховых компаний: 3 «рычага», «зажатые» коронавирусом.<br><br>
          До начала пандемии страховой рынок имел естественный баланс между спросом и предложением.
          Потребности клиентов удовлетворяло определенное количество страховых компаний, брокеров и агентов,
          и на протяжении десятилетий сохранялось четкое разделение клиентской базы и сфер влияния.<br><br>
          В период ограничений многие бизнес-секторы были вынуждены приостановить свою деятельность. Пандемия
          нанесла особенно сильный удар по турагентствам, экспедиторам и другим корпоративным клиентам, доходы
          которых от работы с ними составляют значительную часть общего оборота крупных страховых компаний.
          Это первый «рычаг»: исчезновение китов, на который действовали традиционные страховщики.<br><br>
          Компании, которые продолжали работать, были вынуждены серьезно менять привычные бизнес-процессы:
          например, переводить сотрудников на удаленную работу, создавать для этого необходимую инфраструктуру
          и т. д. Любые изменения, особенно в активной фазе кризиса, когда приходится внедрять новые решения
          буквально на ходу, — это дополнительные затраты и снижение эффективности бизнеса. В то же время, чем
          крупнее компания, тем больше убытки. Это второй «рычаг».<br><br>
          Картину дополняет простое наблюдение: для традиционных страховых компаний кризисные расходы
          становятся катастрофой. Предприятие, построенное по классической модели, всегда вкладывает серьезные
          средства в свою деятельность и берет на себя постоянные финансовые обязательства. Поэтому во времена
          кризиса такие компании страдают от невозможности покрыть собственные расходы, а это прямой путь
          к банкротству. Это третий «рычаг».<br><br>
          Совокупное влияние вышеперечисленных факторов создало однозначную ситуацию: у традиционных страховых
          компаний с началом COVID-19 возникли большие проблемы. Падение спроса на услуги, масштабное
          сокращение клиентской базы и неясные перспективы существования-ситуация катастрофическая. Конечно,
          многие организации не смогли выжить в таких условиях, а те, что еще держатся, теряют долю рынка.
          В чью пользу?</p>
        <h3>Агенты: гибкость — залог успеха в новой реальности </h3>
        <p>Чтобы продолжить успешное осуществление страховой деятельности в связи с кризисом, спровоцированным
          пандемией коронавируса, необходимо следовать трем простым тенденциям:<br><br>
          • Сократите затраты до минимума, избавьтесь от значительных рисков;<br><br>
          • Хватит валяться на китах — важен каждый клиент;<br><br>
          • Гибко реагируйте на любые изменения на рынке.<br><br>
          Для традиционных страховых компаний эти тенденции выглядят практически нереализуемыми, но для других
          участников рынка-агентов — все это естественная норма жизни.<br><br>
          У агента практически нет расходов: он не инвестирует в себя, не нанимает сотрудников-не берет
          кредиты-практически нет финансовых рисков, которые могли бы уничтожить такого игрока. Подавляющее
          большинство агентов никогда не имели доступа к китам, их хлеб с маслом работает с мелкими клиентами
          и работает индивидуально с индивидуальным подходом. Агент не скован бюрократией или корпоративными
          ограничениями: он может попасть в офис клиента, встретиться в выходные, рассмотреть возможность
          расторжения контракта или изменения его условий.<br><br>
          Итак, с наступлением пандемии агенты оказались в выигрышном положении: повседневная специфика
          их деятельности вдруг превратилась в ключевое преимущество. И там, где традиционные страховые
          компании теряют огромные деньги и долю рынка, агенты продолжают работать.<br><br>
          Особенно это заметно в сфере ОСАГО: даже в период строгой изоляции сотни тысяч людей продолжали
          передвигаться по городу на автомобилях. Это и работники компаний, поставляющих или продающих
          предметы первой необходимости, и те, кто изолировал себя в стране и регулярно ходил в магазины,
          и многие граждане, потерявшие работу и вынужденные искать новую. Самый безопасный способ
          путешествовать в условиях пандемии — это личный автомобиль, который защищает от ненужных контактов,
          а значит, спрос на автострахование остался. И этот спрос был удовлетворен агентами, так как
          сотрудничество с традиционными компаниями стало неудобным для клиентов.</p>
        <h3>Агрегаторы — будущее агентов?</h3>
        <p>Агентам, работающим со страховой компанией, мешают ограничения компании, они теряют свободу действий,
          а значит, и свои преимущества. Если говорить о поиске клиентов без поддержки организаций, то это
          сложная задача, и частному трейдеру будет сложно конкурировать с фирмами. Что касается самих
          клиентов, то, с их точки зрения, ключевым недостатком агентского рынка является его фрагментация:
          люди предпочитают единую платформу, на которой они могут купить все необходимые им услуги.<br><br>
          Агрегаторные платформы решают все эти проблемы. Они предлагают агентам единое пространство поиска
          клиентов и структурированный формат работы, не лишающий его гибкости. У клиента есть возможность
          заключить договор из дома, а также более честная и подробная консультация: если агент страховой
          компании всегда в первую очередь заинтересован в выгоде для компании, то агент-агрегатор может
          позволить себе подчеркнуть выгоду для клиента.<br><br>
          В то же время агрегатор создает условия для развития рынка. Многие люди, потерявшие работу, решают
          попробовать свои силы в качестве страхового агента, и работа через платформу становится для них
          лучшим вариантом: вам просто нужно зарегистрироваться, начать продвигать свой бренд, и вы получите
          клиентов. Это хорошо и для населения, и для рынка: усиление конкуренции автоматически означает
          повышение качества услуг.<br><br>
          Глядя на динамику агентского сегмента, можно с уверенностью констатировать: пандемия не разрушила
          страховой рынок, но серьезно изменила расстановку сил на нем. Будущее принадлежит агентам
          и агрегаторам, поскольку они способны быстро адаптироваться к условиям, в которых гибнут
          традиционные общества.</p>
      </div>
    </div>
  </div>
</div>