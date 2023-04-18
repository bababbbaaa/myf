<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\LinkPager;
use yii\widgets\Pjax;

$this->title = 'Поддержка';

$js = <<< JS
    $('.start__Helpdesk').on('click', function() {
        var name = $(this).attr('name');
        $.pjax.reload({
            container: '#dialogContainer',
            url: 'support',
            type: 'POST',
            data: {name:name},
        })
    });
    var sendForm = true;
    $('.support').on('submit', '.helpDesk__form', function(e) {
        e.preventDefault();
        if (sendForm){
            sendForm = false;
            $.ajax({
                url: 'send-message-help',
                dataType: 'JSON',
                type: 'POST',
                data: $('.helpDesk__form').serialize(),
            }).done(function(rsp) {
                $.pjax.reload({container: '#dialogContainer',}).done(function() {
                    sendForm = true;
                    $(".helpDesk__body").scrollTop($(".helpDesk__body")[0].scrollHeight)
                });
            });
        }
    });
    $(".helpDesk__body").scrollTop($(".helpDesk__body")[0].scrollHeight);
        $('.tilets__closed').on('click', function() {
      var id = $(this).attr('data-id');
      $('.showHideDesk').each(function() {
        if ($(this).attr('id') === id){
            $(this).fadeToggle();
        }
      });
      
    });
JS;
$this->registerJs($js);
$css = <<< CSS
.showHideDesk{
    display: none;
}
.allDialogs{
    padding-top: 20px;
}
.title__Alldialog{
    font-size: 28px;
    margin-bottom: 20px;
    font-weight: 500;
}
.tilets__closed{
    display: flex;
    border: 1px solid #00000030;
    cursor: pointer;
    padding: 15px 20px;
    max-width: 300px;
    margin-top: 20px;
}
.dateDialogs{
    padding-right: 10px;
    font-size: 16px;
}
.ticets__id{
    font-size: 16px;
}
CSS;
$this->registerCss($css);
?>
<section style="margin-bottom: 20px" class="rightInfo">
  <div class="support">
    <div class="bcr">
      <ul class="bcr__list">
        <li class="bcr__item">
          <a href="<?= Url::to(['index']) ?>" class="bcr__link">
            Главная
          </a>
        </li>
        <li class="bcr__item">
          <span class="bcr__span">
            Техническая поддержка
          </span>
        </li>
      </ul>
    </div>

    <h1 class="support__title title-main">
      Написать в тех. поддержку
    </h1>
    <p class="sup__Subtitle">
      Свяжитесь с нами, если у Вас возникли сложности<br> в пользовании личным кабинетом
    </p>
    <?php Pjax::begin(['id' => 'dialogContainer']) ?>
    <?php if (empty($dialog)) : ?>
      <input class="start__Helpdesk" name="startDesk" type="button" value="Начать диалог с тех.поддержкой">
    <?php else : ?>
      <div class="helpDesk">
        <div class="helpDesk__head">
          <div class="img__Block">
            <img class="helpDesk__head-image" src="<?= Url::to(['/img/oleg.jpg']) ?>" alt="icon support">

          </div>
          <div class="helpDesk__head-title">
            <h3 class="helpDesk__head-name">Дмитрий</h3>
            <p class="helpDesk__head-post">Специалист технической поддержки</p>
          </div>
        </div>
        <div class="helpDesk__body">
          <?php if (!empty($dialog->messages)) : ?>
            <?php foreach ($dialog->messages as $k => $v) : ?>
              <?php if ($v->isSupport === 1) : ?>
                <div class="helpDesk__body-helper">
                  <p><?= $v->message ?></p>
                  <hr>
                  <p class="info__text">Администратор, <?= date('d.m.Y H:i', strtotime($v->date)) ?></p>
                </div>
              <?php else : ?>
                <div class="helpDesk__body-user">
                  <p><?= $v->message ?></p>
                  <hr>
                  <p class="info__text">Вы, <?= date('d.m.Y H:i', strtotime($v->date)) ?></p>
                </div>
              <?php endif; ?>
            <?php endforeach; ?>
          <?php else : ?>
            <p class="NotMessage">Диалог пока пуст</p>
          <?php endif; ?>
        </div>
        <?= Html::beginForm('', 'post', ['class' => 'helpDesk__form']) ?>
        <input type="hidden" name="pearId" value="<?= $dialog->id ?>">
        <input autocomplete="off" class="helpDesk__form-input" type="text" name="message" placeholder="Введите текст сообщения">
        <button class="helpDesk__form-button"><img class="helpDesk__form-image" src="<?= Url::to(['/img/bird.png']) ?>" alt="send"></button>
        <?= Html::endForm(); ?>
      </div>
    <?php endif; ?>
    <?php Pjax::end() ?>
      <?php if (!empty($allDialog)): ?>
          <div class="allDialogs">
              <h4 class="title__Alldialog">Закрытые тикеты</h4>
              <?php foreach ($allDialog as $k => $v): ?>
                  <div data-id="<?= $v->id ?>" class="tilets__closed">
                      <p class="dateDialogs"><?= date('d.m.Y', strtotime($v->date)) ?></p>
                      <p class="ticets__id">Тикет ID #<?= $v->id ?></p>
                  </div>
                  <div id="<?= $v->id ?>" class="helpDesk showHideDesk">
                      <div class="helpDesk__body">
                          <?php if (!empty($v->messages)): ?>
                              <?php foreach ($v->messages as $key => $value): ?>
                                  <?php if ($value->isSupport === 1): ?>
                                      <div class="helpDesk__body-helper">
                                          <p><?= $value->message ?></p>
                                          <hr>
                                          <p class="info__text">
                                              Администратор, <?= date('d.m.Y H:i', strtotime($value->date)) ?></p>
                                      </div>
                                  <?php else: ?>
                                      <div class="helpDesk__body-user">
                                          <p><?= $value->message ?></p>
                                          <hr>
                                          <p class="info__text">
                                              Вы, <?= date('d.m.Y H:i', strtotime($value->date)) ?></p>
                                      </div>
                                  <?php endif; ?>
                              <?php endforeach; ?>
                          <?php else: ?>
                              <p class="NotMessage">Диалог пока пуст</p>
                          <?php endif; ?>
                      </div>
                  </div>
              <?php endforeach; ?>
          </div>
          <?= LinkPager::widget([
              'pagination' => $pages,
          ]); ?>
      <?php endif; ?>
  </div>
</section>