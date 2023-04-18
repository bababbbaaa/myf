<?php

use yii\helpers\Url;
use yii\helpers\Html;

$js = <<< JS
function inputFile(){
    let inputs = document.querySelectorAll('.input__file');
    Array.prototype.forEach.call(inputs, function (input) {
      let label = input.nextElementSibling,
        labelVal = label.querySelector('.input__file-button-text').innerText;
  
      input.addEventListener('change', function (e) {
        let countFiles = '';
        if (this.files && this.files.length >= 1)
          countFiles = this.files.length;
  
        if (countFiles > 1)
          label.querySelector('.input__file-button-text').innerText = 'Загружено ' + countFiles;
        else if (countFiles = 1)
          label.querySelector('.input__file-button-text').innerText = 'Загружено';
        else
          label.querySelector('.input__file-button-text').innerText = labelVal;
      });
    });
}

inputFile();
JS;
$this->registerJs($js);

$this->title = 'Сообщения';
?>

<section class="rightInfo sp">
    <div class="bcr">
        <ul class="bcr__list">
            <li class="bcr__item">
                <span class="bcr__span">
                    Сообщения
                </span>
            </li>
        </ul>
    </div>

    <div class="title_row">
        <h1 class="Bal-ttl title-main">Сообщения</h1>
    </div>

    <article class="choose">
        <section class="message-main">
            <div class="message-main_top">
                <div class="rating-tab-item_top_left">
                    <div class="message-main_top-image">
                        <img src="<?= Url::to(['/img/afo/best1.svg']) ?>" alt="Константин Александров">
                    </div>
                    <p class="message-main_top-image-name">Константин Александров</p>
                </div>
            </div>

            <div class="message-main-main">
                <p class="message-main-main-date">12.02.2022</p>

                <div class="message-main-left">
                    <div class="message-main-mm-image">
                        <img src="<?= Url::to(['/img/afo/best1.svg']) ?>" alt="Константин Александров">
                    </div>
                    <div class="message-main-mm-group">
                        <p class="message-main-mm-group-text">Добрый день. Занимаюсь продвижением в Instagram. Хотел бы с вами посотрудничать</p>
                        <p class="message-main-mm-group-date">12.01.2022</p>
                    </div>
                </div>

                <div class="message-main-right">
                    <div class="message-main-mm-image">
                        <img src="<?= Url::to(['/img/afo/best1.svg']) ?>" alt="Константин Александров">
                    </div>
                    <div class="message-main-mm-group">
                        <p class="message-main-mm-group-text">Добрый день. Нужно составить план прогрева и сделать визуал для аккаунта</p>
                        <p class="message-main-mm-group-date">12.01.2022</p>
                    </div>
                </div>

                <p class="message-main-main-date">12.02.2022</p>

                <div class="message-main-left">
                    <div class="message-main-mm-image">
                        <img src="<?= Url::to(['/img/afo/best1.svg']) ?>" alt="Константин Александров">
                    </div>
                    <div class="message-main-mm-group">
                        <p class="message-main-mm-group-text">Добрый день. Занимаюсь продвижением в Instagram. Хотел бы с вами посотрудничать</p>
                        <p class="message-main-mm-group-date">12.01.2022</p>
                    </div>
                </div>

                <div class="message-main-right">
                    <div class="message-main-mm-image">
                        <img src="<?= Url::to(['/img/afo/best1.svg']) ?>" alt="Константин Александров">
                    </div>
                    <div class="message-main-mm-group">
                        <p class="message-main-mm-group-text">Добрый день. Нужно составить план прогрева и сделать визуал для аккаунта</p>
                        <p class="message-main-mm-group-date">12.01.2022</p>
                    </div>
                </div>
            </div>

            <?= Html::beginForm('', '', ['class' => 'message-send', 'id' => 'message-send']) ?>
                <div class="message-main_bottom">
                    <textarea style="min-height: 118px;" class="input-t input-textarea" name="text" required minlength="1" placeholder="Введите текст"></textarea>
                    <div style="align-self: flex-start;" class="input__wrapper specialistorder_input-file">
                        <input name="file" type="file" id="input__file" class="input input__file">
                        <label for="input__file" class="input__file-button">
                            <span class="input__file-button-text">Прикрепить файл</span>
                        </label>
                    </div>
                    <button style="max-width: fit-content; margin-top: 12px; align-self: flex-end;" class="btn--pink-white">Отправить сообщение</button>
                </div>
            <?= Html::endForm(); ?>
        </section>
        <div class="message-right">
            <?= Html::beginForm('', '', ['class' => 'message-filter', 'id' => 'message-filter']) ?>
            <section style="margin-bottom: 20px;" class="choose_main-search">
                <input form="choose-filter" type="text" inputmode="search" name="search" class="input-t input-search">
                <button class="choose-filter-submit" type="submit">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M13.5 3C17.6421 3 21 6.35786 21 10.5C21 14.6421 17.6421 18 13.5 18C11.699 18 10.0464 17.3652 8.75345 16.3072L4.28033 20.7803C3.98744 21.0732 3.51256 21.0732 3.21967 20.7803C2.92678 20.4874 2.92678 20.0126 3.21967 19.7197L7.69279 15.2465C6.63477 13.9536 6 12.301 6 10.5C6 6.35786 9.35786 3 13.5 3ZM19.5 10.5C19.5 7.18629 16.8137 4.5 13.5 4.5C10.1863 4.5 7.5 7.18629 7.5 10.5C7.5 13.8137 10.1863 16.5 13.5 16.5C16.8137 16.5 19.5 13.8137 19.5 10.5Z" fill="#5B617C"/></svg>
                </button>
            </section>

            <ul class="message-right_list">
                <li class="message-right_list-item">
                    <label class="message-right_list-item-label">
                        <input checked class="input-hide" type="radio" name="addressee" value="">
                        <div class="message-right_list-item-label-box">
                            <div class="rating-tab-item_top_left">
                                <div class="rating-tab-item_top_left-image">
                                    <img src="<?= Url::to(['/img/afo/best1.svg']) ?>" alt="Константин Александров">
                                </div>
                                <p class="rating-tab-item_top_left-name">Константин Александров</p>
                            </div>
                            <p class="message-right_list-item-label-box-text">Можете предложить мне fhg fh dfgh dh</p>

                            <div class="message-right_list-item-label-box-mess">4</div>
                        </div>
                    </label>
                </li>
                <li class="message-right_list-item">
                    <label class="message-right_list-item-label">
                        <input  class="input-hide" type="radio" name="addressee" value="">
                        <div class="message-right_list-item-label-box">
                            <div class="rating-tab-item_top_left">
                                <div class="rating-tab-item_top_left-image">
                                    <img src="<?= Url::to(['/img/afo/best1.svg']) ?>" alt="Константин Александров">
                                </div>
                                <p class="rating-tab-item_top_left-name">Константин Александров</p>
                            </div>
                            <p class="message-right_list-item-label-box-text">Можете предложить мне fhg fh dfgh dh</p>
                        </div>
                    </label>
                </li>
                <li class="message-right_list-item">
                    <label class="message-right_list-item-label">
                        <input  class="input-hide" type="radio" name="addressee" value="">
                        <div class="message-right_list-item-label-box">
                            <div class="rating-tab-item_top_left">
                                <div class="rating-tab-item_top_left-image">
                                    <img src="<?= Url::to(['/img/afo/best1.svg']) ?>" alt="Константин Александров">
                                </div>
                                <p class="rating-tab-item_top_left-name">Константин Александров</p>
                            </div>
                            <p class="message-right_list-item-label-box-text">Можете предложить мне fhg fh dfgh dh</p>
                        </div>
                    </label>
                </li>
                <li class="message-right_list-item">
                    <label class="message-right_list-item-label">
                        <input  class="input-hide" type="radio" name="addressee" value="">
                        <div class="message-right_list-item-label-box">
                            <div class="rating-tab-item_top_left">
                                <div class="rating-tab-item_top_left-image">
                                    <img src="<?= Url::to(['/img/afo/best1.svg']) ?>" alt="Константин Александров">
                                </div>
                                <p class="rating-tab-item_top_left-name">Константин Александров</p>
                            </div>
                            <p class="message-right_list-item-label-box-text">Можете предложить мне fhg fh dfgh dh</p>
                        </div>
                    </label>
                </li>
                <li class="message-right_list-item">
                    <label class="message-right_list-item-label">
                        <input  class="input-hide" type="radio" name="addressee" value="">
                        <div class="message-right_list-item-label-box">
                            <div class="rating-tab-item_top_left">
                                <div class="rating-tab-item_top_left-image">
                                    <img src="<?= Url::to(['/img/afo/best1.svg']) ?>" alt="Константин Александров">
                                </div>
                                <p class="rating-tab-item_top_left-name">Константин Александров</p>
                            </div>
                            <p class="message-right_list-item-label-box-text">Можете предложить мне fhg fh dfgh dh</p>
                        </div>
                    </label>
                </li>
                <li class="message-right_list-item">
                    <label class="message-right_list-item-label">
                        <input  class="input-hide" type="radio" name="addressee" value="">
                        <div class="message-right_list-item-label-box">
                            <div class="rating-tab-item_top_left">
                                <div class="rating-tab-item_top_left-image">
                                    <img src="<?= Url::to(['/img/afo/best1.svg']) ?>" alt="Константин Александров">
                                </div>
                                <p class="rating-tab-item_top_left-name">Константин Александров</p>
                            </div>
                            <p class="message-right_list-item-label-box-text">Можете предложить мне fhg fh dfgh dh</p>
                        </div>
                    </label>
                </li>
                <li class="message-right_list-item">
                    <label class="message-right_list-item-label">
                        <input  class="input-hide" type="radio" name="addressee" value="">
                        <div class="message-right_list-item-label-box">
                            <div class="rating-tab-item_top_left">
                                <div class="rating-tab-item_top_left-image">
                                    <img src="<?= Url::to(['/img/afo/best1.svg']) ?>" alt="Константин Александров">
                                </div>
                                <p class="rating-tab-item_top_left-name">Константин Александров</p>
                            </div>
                            <p class="message-right_list-item-label-box-text">Можете предложить мне fhg fh dfgh dh</p>
                        </div>
                    </label>
                </li>
                <li class="message-right_list-item">
                    <label class="message-right_list-item-label">
                        <input  class="input-hide" type="radio" name="addressee" value="">
                        <div class="message-right_list-item-label-box">
                            <div class="rating-tab-item_top_left">
                                <div class="rating-tab-item_top_left-image">
                                    <img src="<?= Url::to(['/img/afo/best1.svg']) ?>" alt="Константин Александров">
                                </div>
                                <p class="rating-tab-item_top_left-name">Константин Александров</p>
                            </div>
                            <p class="message-right_list-item-label-box-text">Можете предложить мне fhg fh dfgh dh</p>
                        </div>
                    </label>
                </li>
                <li class="message-right_list-item">
                    <label class="message-right_list-item-label">
                        <input  class="input-hide" type="radio" name="addressee" value="">
                        <div class="message-right_list-item-label-box">
                            <div class="rating-tab-item_top_left">
                                <div class="rating-tab-item_top_left-image">
                                    <img src="<?= Url::to(['/img/afo/best1.svg']) ?>" alt="Константин Александров">
                                </div>
                                <p class="rating-tab-item_top_left-name">Константин Александров</p>
                            </div>
                            <p class="message-right_list-item-label-box-text">Можете предложить мне fhg fh dfgh dh</p>
                        </div>
                    </label>
                </li>
                <li class="message-right_list-item">
                    <label class="message-right_list-item-label">
                        <input  class="input-hide" type="radio" name="addressee" value="">
                        <div class="message-right_list-item-label-box">
                            <div class="rating-tab-item_top_left">
                                <div class="rating-tab-item_top_left-image">
                                    <img src="<?= Url::to(['/img/afo/best1.svg']) ?>" alt="Константин Александров">
                                </div>
                                <p class="rating-tab-item_top_left-name">Константин Александров</p>
                            </div>
                            <p class="message-right_list-item-label-box-text">Можете предложить мне fhg fh dfgh dh</p>
                        </div>
                    </label>
                </li>
                <li class="message-right_list-item">
                    <label class="message-right_list-item-label">
                        <input  class="input-hide" type="radio" name="addressee" value="">
                        <div class="message-right_list-item-label-box">
                            <div class="rating-tab-item_top_left">
                                <div class="rating-tab-item_top_left-image">
                                    <img src="<?= Url::to(['/img/afo/best1.svg']) ?>" alt="Константин Александров">
                                </div>
                                <p class="rating-tab-item_top_left-name">Константин Александров</p>
                            </div>
                            <p class="message-right_list-item-label-box-text">Можете предложить мне fhg fh dfgh dh</p>
                        </div>
                    </label>
                </li>
            </ul>

            <?= Html::endForm(); ?>
        </div>
    </article>

    <footer class="footer">
        <div class="container container--body">
            <a href="<?= Url::to(['manual']) ?>" class="footer__link">
                Руководство пользователя
            </a>
            <a href="<?= Url::to(['support']) ?>" class="footer__link">
                Тех.поддержка
            </a>
        </div>
    </footer>
</section>