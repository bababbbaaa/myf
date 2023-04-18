<?php

use yii\helpers\Html;
use yii\helpers\Url;
use common\models\helpers\UrlHelper;

$this->title = "Просмотр оффера";
$js = <<<JS
    $('.chosen-select').chosen();
    $('.multi-reg-add').on('input', function() {
        if ($(this).val().length > 0) {
            $(".add--2").prop("disabled", false);
        } else
            $(".add--2").prop("disabled", true);
    });

    $('.hot__offer-confirm').on('click', function() {
        var id = $(this).attr('data-id');
        $.ajax({
          url: 'confirm-offers',
          dataType: 'JSON',
          type: 'POST',
          data: {confirm: true, id:id},
        }).done(function(rsp){
            if (rsp.status === 'error'){
                Swal.fire({
                  icon: 'error',
                  title: 'Ошибка',
                  text: rsp.message,
                });
            } else {
                location.href = 'my-offers#2';
            }
        });
    });
    
    $('.offer__btn-confirm').on('click', function() {
        $.ajax({
          url: 'confirm-offers',
          dataType: 'JSON',
          type: 'POST',
          data: $('.confirm__form-offer').serialize(),
        }).done(function(rsp){
            if (rsp.status === 'error'){
                Swal.fire({
                  icon: 'error',
                  title: 'Ошибка',
                  text: rsp.message,
                });
            } else {
                location.href = 'my-offers#2';
            }
        });
    });
JS;
$this->registerCssFile(Url::to(['/css/chosen.min.css']));
$this->registerJsFile(Url::to(['/js/chosen.jquery.min.js']), ['depends' => \yii\web\JqueryAsset::class]);
$this->registerJs($js);
$css = <<< CSS
.chosen-container-multi .chosen-choices{
  background: #FFFFFF;
  border: 1px solid #CBD0E8;
  box-sizing: border-box;
  border-radius: 8px;
  padding: 10px 12px;
  font-weight: 600;
  font-size: 14px;
  line-height: 20px;
  color: #333333;
  outline: none;
  max-width: 600px;
}
.chosen-container-multi .chosen-choices::placeholder{
  color: #9BA0B7;
  font-weight: normal;
}
.chosen-container-multi .chosen-choices li.search-choice{
  position: relative;
  margin: 3px 5px 3px 0;
  font-weight: 600;
  font-size: 14px;
  line-height: 20px;
  color: #333333;
  background: none;
  background-color: inherit;
}
.chosen-container-multi .chosen-choices li.search-choice .search-choice-close{
  top: 7px;
}
.chosen-container-multi .chosen-choices li.search-field input[type=text]{
  font-size: 14px;
  line-height: 20px;
  color: #9BA0B7;
  font-weight: normal;
}
.chosen-container .chosen-drop{
  max-width: 600px;
}
CSS;
$this->registerCss($css);
?>

<section class="rightInfo">

    <div class="balance">
        <div class="bcr">
            <ul class="bcr__list">
                <li class="bcr__item">
          <span class="bcr__link">
            Добавить оффер
          </span>
                </li>

                <li class="bcr__item">
          <span class="bcr__span">
              <?= $leads['name'] ?>
          </span>
                </li>
            </ul>
        </div>

        <div class="title_row">
            <h1 class="Bal-ttl title-main"><?= $leads['name'] ?></h1>
            <a href="<?= Url::to(['usermanualmyoffers']) ?>">Как принять оффер в работу?</a>
        </div>

        <article class="MainInfo">
            <?php if ($leads['hot'] == 0): ?>
                <div class="header__offer">
                    <div class="header__offer-info">

                        <p class="header__offer-title">Тип лидов</p>
                        <div class="header__offer-subtitle"><?= $leads['description'] ?></div>
                        <div class="header__offer-lineblock">
                            <div>
                                <p class="header__offer-title">процент принятия лидов</p>
                                <p class="header__offer-value">от 65%</p>
                            </div>
                            <div>
                                <p class="header__offer-title">Вознаграждение за принятый лид</p>
                                <p class="header__offer-value"><?= $leads['price'] ?>₽/лид</p>
                            </div>
                        </div>
                    </div>
                    <img style="margin-bottom: 15px;" src="<?= UrlHelper::admin($leads['image']) ?>" alt="">
                </div>
                <div class="body__offer">
                    <?= Html::beginForm('', 'post', ['class' => 'confirm__form-offer']) ?>
                    <input type="hidden" name="id" value="<?= $leads['id'] ?>">
                    <div class="body__offer-block">
                        <p class="body__offer-title">Укажите количество</p>
                        <p class="body__offer-subtitle">Сколько лидов в день вы можете поставлять</p>
                        <input name="daily_leads_min" class="offer__input" type="number" min="0" step="5" placeholder="Например, 10">
                    </div>
                    <?php if ($leads['category_link'] !== 'chardjbek'): ?>
                    <div class="body__offer-block">
                        <p class="body__offer-title">Регион</p>
                        <p class="body__offer-subtitle">Выберите один или несколько регионов, в которых вы можете
                            поставлять лиды</p>
                        <select multiple name="reg[]" class="form-control chosen-select multi-reg-add"
                                data-placeholder="Выбрать регионы" style="font-family: 'Poppins', sans-serif">
                            <option value="Вся Россия" selected>Вся Россия</option>
                            <?php if (!empty($regions)): ?>
                                <?php foreach ($regions as $item): ?>
                                    <option value="<?= $item['name_with_type'] ?>"><?= $item['name_with_type'] ?></option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                    </div>
                    <?php endif; ?>
                    <button type="button" class="offer__btn-confirm">Принять оффер в работу</button>
                    <?= Html::endForm(); ?>
                </div>
            <?php else: ?>
                <div style="border-bottom: none" class="header__offer">
                    <div class="header__offer-info">
                        <div class="Hot__line">
                            <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <rect width="20" height="20" rx="4" fill="url(#paint0_linear)"/>
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M11.7571 3.26714C11.9892 3.361 12.1217 3.60666 12.0726 3.85212L11.1555 8.43747H13.1244C13.3149 8.43747 13.4902 8.5415 13.5815 8.70873C13.6728 8.87595 13.6655 9.07968 13.5625 9.23995L8.87496 16.5316C8.7396 16.7422 8.4736 16.8267 8.24155 16.7328C8.0095 16.6389 7.87704 16.3933 7.92613 16.1478L8.8432 11.5625H6.87435C6.68382 11.5625 6.5085 11.4584 6.41721 11.2912C6.32591 11.124 6.33321 10.9203 6.43624 10.76L11.1237 3.46833C11.2591 3.25777 11.5251 3.17328 11.7571 3.26714ZM7.82834 10.5208H9.47852C9.63455 10.5208 9.78237 10.5908 9.8813 10.7114C9.98023 10.8321 10.0198 10.9908 9.98924 11.1438L9.4875 13.6525L12.1704 9.47914H10.5202C10.3641 9.47914 10.2163 9.40918 10.1174 9.28851C10.0185 9.16784 9.97886 9.00917 10.0095 8.85616L10.5112 6.34747L7.82834 10.5208Z" fill="white"/>
                                <defs>
                                    <linearGradient id="paint0_linear" x1="0.000414508" y1="9.98691" x2="19.9924" y2="9.98691" gradientUnits="userSpaceOnUse">
                                        <stop stop-color="#2CCD65"/>
                                        <stop offset="1" stop-color="#2096EC"/>
                                    </linearGradient>
                                </defs>
                            </svg>
                            <p class="Hot__line-p">Горячий оффер</p>
                        </div>
                        <p class="header__offer-title">Тип лидов</p>
                        <div class="header__offer-subtitle"><?= $leads['description'] ?></div>
                        <div style="margin-bottom: 28px;" class="header__offer-lineblock">
                            <div class="offer__info-block">
                                <p class="header__offer-title">процент принятия лидов</p>
                                <p class="header__offer-value">от 65%</p>
                            </div>
                            <div class="offer__info-block">
                                <p class="header__offer-title">Вознаграждение за принятый лид</p>
                                <p class="header__offer-value"><?= $leads['price'] ?>₽/лид</p>
                            </div>
                        </div>
                        <div style="margin-bottom: 40px;" class="header__offer-lineblock">
                            <div class="offer__info-block">
                                <p class="header__offer-title">Регион</p>
                                <?php $region = json_decode($leads['regions'], true) ?>
                                <?php foreach ($region as $k => $v): ?>
                                    <p class="header__offer-value"><?= $v ?></p>
                                <?php endforeach; ?>
                            </div>
                            <div class="offer__info-block">
                                <p class="header__offer-title">процент принятия лидов</p>
                                <p class="header__offer-value">от 65%</p>
                            </div>
                        </div>
                        <button class="hot__offer-confirm" data-id="<?= $leads['id'] ?>">Принять оффер в работу</button>
                    </div>
                    <img style="margin-bottom: 15px;" src="<?= UrlHelper::admin($leads['image']) ?>" alt="">
                </div>
            <?php endif; ?>
        </article>
    </div>
</section>