<?php
/* @var $this yii\web\View */

use yii\helpers\Url;

$guest = Yii::$app->user->isGuest;

$this->title = 'Что такое франчайзинг: нормы и законы';
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
          <a href="<?= Url::to(['kak-covid-povliyal-na-rasklad-sil']) ?>" class="popularАrticlesCard">
            <img src="<?= Url::to(['/img/Rectangle 46.webp']) ?>" alt="">
            <p class="cardTextP1">Как COVID-19 повлиял на расклад сил на страховом рынке</p>
            <p class="cardTextP2">Статья по франчайзингу</p>
          </a>
          <a href="<?= Url::to('vidu-franchizy') ?>" class="popularАrticlesCard">
            <img src="<?= Url::to(['/img/Rectangle 46-1.webp']) ?>" alt="">
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
      <div style="background-image: url('<?= Url::to(['/img/Rectangle 178-4.webp']) ?>')" class="photoArticles">
        <h1>Что такое франчайзинг: нормы и законы</h1>
        <h2>Расскажем о том, что такое франчайзинг, чем она отличается от других форм бизнеса, кем являются
          франчайзер и франчайзи, какие они имеют права и др.</h2>
        <p class="photoArticlesp2">Прокопенко Ольга, 24.12.2020</p>
      </div>
      <div class="textArticles">
        <br>
        <h3>Что такое франчайзинг?</h3>
        <p>Франчайзинг в России обычно называют покупкой права предпринимателя работать по заимствованной
          бизнес-модели под уже известным брендом. Вы можете сравнить концепцию франчайзинга с менторством.
          Франчайзи выбирает куратора в качестве партнера, передает право использования его имени, проверенных
          технологий и алгоритмов ведения бизнеса и контроля на каждом этапе. А франчайзи рубля отвечает
          за принятые обязательства.</p>
        <h3>Чем франшиза отличается от других форм бизнеса?</h3>
        <p>В России франчайзинг основан на передаче лицензии на использование наименования, дизайна, технологии,
          патентов и других нематериальных активов на определенных условиях от владельца-франчайзи
          к пользователю-франчайзи. Франчайзинг регулируется договором коммерческой концессии, в котором
          учитываются размер передаваемых прав, размер и форма вознаграждения, а также условия самой
          передачи.</p>
        <h4>Кто такие франчайзер и франчайзи?</h4>
        <p>Франчайзер в этом товариществе является правообладателем переданного имущества,
          франчайзи-покупателем. Она управляется первой, платит единовременную фиксированную плату (аванс
          за заключение договора) и регулярно производит фиксированные регулярные платежи (роялти) за «аренду»
          имени, имиджа и достижений. Взамен он получает необходимый контроль, поддержку и возможности,
          указанные в договоре. Суть франчайзинга — это взаимовыгодные усилия, направленные на развитие
          и прибыльность бизнеса.</p>
        <h4>Какие права и обязанности у франчайзера и франчайзи?</h4>
        <p>Франчайзи обязан предоставить партнеру все необходимые нематериальные активы (от передачи дизайна
          до обучения персонала), франчайзи должен полностью выполнить условия, указанные в договоре,
          и произвести платежи.</p>
        <h4>Существуют ли стандарты франчайзинга?</h4>
        <p>Развитие франчайзинга напрямую связано с существующими в нем нормами. Недопустимо покупать
          франчайзинговое название и вести бизнес по своим правилам. Это автоматически портит имидж не только
          одного предпринимателя, но и всей франчайзинговой сети. Условия франшизы всегда
          стандартизированы.</p>
        <h4>Каковы организационно-правовые формы франчайзинга?</h4>
        <p>В мире существует множество видов франчайзинга, большинство из которых успешно работают на российском
          рынке.</p>
        <div>
          <div class="line1 pow">
            <div class="blueFone rol-4">Товарная франшиза</div>
            <div class="blueFone1 rol-8">Франчайзи реализует продукцию, которую производит франчайзер</div>
          </div>
          <div class="line1 pow">
            <div class="blueFone rol-4">Деловая франшиза</div>
            <div class="blueFone1 rol-8">Франчайзи приобретает не только имя, но и способ ведения бизнеса
            </div>
          </div>
          <div class="line1 pow">
            <div class="blueFone rol-4">Производственная франшиза</div>
            <div class="blueFone1 rol-8">Франчайзи получает оборудование, рецепты, ноу-хау под жестким
              контролем франчайзера
            </div>
          </div>
          <div class="line1 pow">
            <div class="blueFone rol-4">Конверсионная франшиза</div>
            <div class="blueFone1 rol-8">Сеть расширяется за счет компаний аналогичного профиля, например,
              чайных или парикмахерских
            </div>
          </div>
          <div class="line1 pow">
            <div class="blueFone rol-4">Районная франшиза</div>
            <div class="blueFone1 rol-8">Франчайзинговая сеть развивается только в определенном регионе
            </div>
          </div>
          <div class="line1 pow">
            <div class="blueFone rol-4">Суб-франшиза</div>
            <div class="blueFone1 rol-8">Франчайзи может сам продавать франшизу</div>
          </div>
        </div>
        <h4>Какие законы регулируют франшизу?</h4>
        <p>Мир давно оценил преимущества франчайзинга, в разных странах этому посвящены отдельные документы
          и законы. Например, в США документ о раскрытии информации о франшизе отвечает за специфику бизнеса
          в рамках франшизы. Британские стандарты учтены в Кодексе этики Британской ассоциации франчайзинга.
          Есть такой европейский документ — Европейский кодекс этики франчайзинга. А в Австралии это кодекс
          франчайзинга. Франчайзинг — это очень привлекательная система, которая позволяет развивать это
          направление везде.</p>
        <h4>Есть ли в России закон о франшизе?</h4>
        <p>Российское законодательство активно работает в этом направлении, но специальный закон пока не принят.
          Хотя само слово «Франчайзинг» еще не появилось в официальных документах, рынок использует
          существующие аналогичные юридические термины.</p>
        <h4>Какие законы движут российской франшизой?</h4>
        <p>Российские франшизы регулируются главой 54 Гражданского кодекса Российской Федерации и чаще всего
          оформляются договором коммерческой концессии. Сторонам могут доверять коммерческие организации
          и индивидуальные предприниматели, зарегистрированные в Федеральной налоговой службе. В договоре
          оговариваются обязательные условия франчайзинга:<br><br>
          • Передача права пользования наименованием (торговой маркой, товарным знаком) и нематериальными
          активами;<br><br>
          • Особенности сотрудничества;<br><br>
          • Размеры и способы выплаты единовременной выплаты и роялти;<br><br>
          • Условия и категории, необходимые для расторжения договора.</p>
      </div>
    </div>
  </div>
</div>