<?php

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Разместить заказ';

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

var step = 1;
function nextStep() {
  $('.Stap' + step++).fadeOut(300, function() {
      $('.Stap' + step).fadeIn(300);

      if($('.Stap5').is(':visible')){
            $('.create-resume-form_left-list-item:nth-child(5)').addClass('active');
            $('.create-resume-form_left-list-item:nth-child(5) .create-resume-form_left-list-item-indicator').addClass('active');
            $('.create-resume-form_left-list-item:nth-child(4) .create-resume-form_left-list-item-indicator').addClass('done');
            $('.create-resume-form_left-list-item:nth-child(4) .create-resume-form_left-list-item-indicator').text('✓');
        }else if($('.Stap4').is(':visible')){
            $('.create-resume-form_left-list-item:nth-child(4)').addClass('active');
            $('.create-resume-form_left-list-item:nth-child(4) .create-resume-form_left-list-item-indicator').addClass('active');
            $('.create-resume-form_left-list-item:nth-child(3) .create-resume-form_left-list-item-indicator').addClass('done');
            $('.create-resume-form_left-list-item:nth-child(3) .create-resume-form_left-list-item-indicator').text('✓');
            $('.create-course_modules-group').addClass('hide');
        }else if($('.Stap3').is(':visible')){
            $('.create-resume-form_left-list-item:nth-child(3)').addClass('active');
            $('.create-resume-form_left-list-item:nth-child(3) .create-resume-form_left-list-item-indicator').addClass('active');
            $('.create-resume-form_left-list-item:nth-child(2) .create-resume-form_left-list-item-indicator').addClass('done');
            $('.create-resume-form_left-list-item:nth-child(2) .create-resume-form_left-list-item-indicator').text('✓');
        }else if($('.Stap2').is(':visible')){
            $('.create-resume-form_left-list-item:nth-child(2)').addClass('active');
            $('.create-resume-form_left-list-item:nth-child(2) .create-resume-form_left-list-item-indicator').addClass('active');
            $('.create-resume-form_left-list-item:nth-child(1) .create-resume-form_left-list-item-indicator').addClass('done');
            $('.create-resume-form_left-list-item:nth-child(1) .create-resume-form_left-list-item-indicator').text('✓');
            $('.addprogram_anket-save').attr('disabled', false);
        }
  });
}
$('.button__next').on('click', function() {
    if (step === 1 && $('input[name="order-name"]').val() !== '' && $('input[name="order-tag[]"]').is(':checked')) nextStep();
    else if (step === 2 && $('input[name="order-founds[]"]').is(':checked') ) nextStep();
    else if (step === 3 && $('.input-textarea').val() !== '') nextStep();
    if (step === 4){
        if($('input[name="order-date"]').val() !== '' && $('input[name="order-summ"]').val() !== '' || $('input[name="order-date"]').val() !== '' && $('input[name="order-summ[]"]').is(':checked') || $('input[name="order-summ"]').val() !== '' && $('input[name="order-date[]"]').is(':checked') || $('input[name="order-summ[]"]').is(':checked') && $('input[name="order-date[]"]').is(':checked')){
            nextStep();

            var name = $('input[name="order-name"]').val();
            $('.order-name').text(name);
            $('.order-tags').children().remove();
            $('input[name="order-tag[]"]').each(function(){
                if($(this).is(':checked')){
                    var tag = $(this).val();
                    $('.order-tags').append('<li>#'+tag+'</li>');
                }
            });
            var text = $('textarea[name="order-description"]').val();
            $('.car-order-description').text(text);
            if($('input[name="order-summ[]"]').is(':checked')){
                var summ = $('input[name="order-summ[]"]').val();
            }else{
                var summ = $('input[name="order-summ"]').val() + " рублей";
            }
            if($('input[name="order-date[]"]').is(':checked')){
                var date = $('input[name="order-date[]"]').val();
            }else{
                var date = $('input[name="order-date"]').val();
            }

            $('.cr-order-summ').text(summ);
            $('.cr-order-date').text(date);
        }
    }
});

$('.createorder-form').on('submit', function (e) {
    $.ajax({
        url: "",
        method: "POST",
        data: $(this).serialize(),
        beforeSend: function (){
            $('.popups-back, .popup-done').fadeIn(300);
        },
    });
    e.preventDefault();
});

$('.popups-back, .popup-close, .popup-cancel').on('click', function(){
    $('.popups-back').fadeOut(300);
    $('.popup').fadeOut(300);
});
JS;
$this->registerJs($js);

?>

<section class="rightInfo">
    <div class="bcr">
        <ul class="bcr__list">
            <li class="bcr__item">
                <span class="bcr__span">
                    Разместить заказ
                </span>
            </li>
        </ul>
    </div>

    <div class="title_row">
        <h1 class="Bal-ttl title-main">Разместить заказ</h1>
    </div>

    <section class="startproject">
        <div class="create-resume-form_container">
            <div class="create-resume-form_left">
                <div class="create-resume-form_left">
                    <div class="create-resume-form_left-line"></div>
                    <ul class="create-resume-form_left-list">
                        <li class="create-resume-form_left-list-item active">
                            <div class="create-resume-form_left-list-item-indicator active">1</div>
                            <p class="create-resume-form_left-list-item-text">Специализация</p>
                        </li>
                        <li class="create-resume-form_left-list-item">
                            <div class="create-resume-form_left-list-item-indicator ">2</div>
                            <p class="create-resume-form_left-list-item-text">Площадки</p>
                        </li>
                        <li class="create-resume-form_left-list-item">
                            <div class="create-resume-form_left-list-item-indicator ">3</div>
                            <p class="create-resume-form_left-list-item-text">Описание задачи</p>
                        </li>
                        <li class="create-resume-form_left-list-item">
                            <div class="create-resume-form_left-list-item-indicator ">4</div>
                            <p class="create-resume-form_left-list-item-text">Бюджет и срок</p>
                        </li>
                        <li class="create-resume-form_left-list-item">
                            <div class="create-resume-form_left-list-item-indicator ">5</div>
                            <p class="create-resume-form_left-list-item-text">Проверка заказа</p>
                        </li>
                    </ul>
                </div>
            </div>
            <?= Html::beginForm('', '', ['class' => 'createorder-form']) ?>
                <section class="create-resume-form_main">
                    <div class="create-resume-form_main_staps Stap1">
                        <div class="create-resume-form_main_container">
                            <h2 class="create-resume-form_main-title">1. Специализация</h2>
                            <h4 class="create-resume-form_main-subtitle">
                                Укажите название
                            </h4>
                            <input name="order-name" placeholder="Введите текст" type="text" class="input-t">
                            <h4 class="create-resume-form_main-subtitle">
                                Выберите специализации
                            </h4>
                            <div class="checkbox-group">
                                <label class="input-checkbox-label input-checkbox-label-order-page">
                                    <input checked type="checkbox" name="order-tag[]" value="e-mail маркетинг" class="input-hide">
                                    <div class="input-checkbox-label-indicator">
                                        <p class="input-checkbox-label-point"></p>
                                        <p class="input-checkbox-label-text">e-mail маркетинг</p>
                                    </div>
                                </label>
                                <label class="input-checkbox-label input-checkbox-label-order-page">
                                    <input type="checkbox" name="order-tag[]" value="Лидогенерация" class="input-hide">
                                    <div class="input-checkbox-label-indicator">
                                        <p class="input-checkbox-label-point"></p>
                                        <p class="input-checkbox-label-text">Лидогенерация</p>
                                    </div>
                                </label>
                                <label class="input-checkbox-label input-checkbox-label-order-page">
                                    <input type="checkbox" name="order-tag[]" value="Таргет" class="input-hide">
                                    <div class="input-checkbox-label-indicator">
                                        <p class="input-checkbox-label-point"></p>
                                        <p class="input-checkbox-label-text">Таргет</p>
                                    </div>
                                </label>
                                <label class="input-checkbox-label input-checkbox-label-order-page">
                                    <input type="checkbox" name="order-tag[]" value="Телефонный маркетинг" class="input-hide">
                                    <div class="input-checkbox-label-indicator">
                                        <p class="input-checkbox-label-point"></p>
                                        <p class="input-checkbox-label-text">Телефонный маркетинг</p>
                                    </div>
                                </label>
                                <label class="input-checkbox-label input-checkbox-label-order-page">
                                    <input type="checkbox" name="order-tag[]" value="SMM маркетинг" class="input-hide">
                                    <div class="input-checkbox-label-indicator">
                                        <p class="input-checkbox-label-point"></p>
                                        <p class="input-checkbox-label-text">SMM маркетинг</p>
                                    </div>
                                </label>
                                <label class="input-checkbox-label input-checkbox-label-order-page">
                                    <input type="checkbox" name="order-tag[]" value="Маркетинговая стратегия" class="input-hide">
                                    <div class="input-checkbox-label-indicator">
                                        <p class="input-checkbox-label-point"></p>
                                        <p class="input-checkbox-label-text">Маркетинговая стратегия</p>
                                    </div>
                                </label>
                                <label class="input-checkbox-label input-checkbox-label-order-page">
                                    <input type="checkbox" name="order-tag[]" value="SEO продвижение" class="input-hide">
                                    <div class="input-checkbox-label-indicator">
                                        <p class="input-checkbox-label-point"></p>
                                        <p class="input-checkbox-label-text">SEO продвижение</p>
                                    </div>
                                </label>
                                <label class="input-checkbox-label input-checkbox-label-order-page">
                                    <input type="checkbox" name="order-tag[]" value="Реклама у блогеров" class="input-hide">
                                    <div class="input-checkbox-label-indicator">
                                        <p class="input-checkbox-label-point"></p>
                                        <p class="input-checkbox-label-text">Реклама у блогеров</p>
                                    </div>
                                </label>
                                <label class="input-checkbox-label input-checkbox-label-order-page">
                                    <input type="checkbox" name="order-tag[]" value="Телемаркетинг" class="input-hide">
                                    <div class="input-checkbox-label-indicator">
                                        <p class="input-checkbox-label-point"></p>
                                        <p class="input-checkbox-label-text">Телемаркетинг</p>
                                    </div>
                                </label>
                                <label class="input-checkbox-label input-checkbox-label-order-page">
                                    <input type="checkbox" name="order-tag[]" value="Ремаркетинг" class="input-hide">
                                    <div class="input-checkbox-label-indicator">
                                        <p class="input-checkbox-label-point"></p>
                                        <p class="input-checkbox-label-text">Ремаркетинг</p>
                                    </div>
                                </label>
                                <label class="input-checkbox-label input-checkbox-label-order-page">
                                    <input type="checkbox" name="order-tag[]" value="Исследование рынка" class="input-hide">
                                    <div class="input-checkbox-label-indicator">
                                        <p class="input-checkbox-label-point"></p>
                                        <p class="input-checkbox-label-text">Исследование рынка</p>
                                    </div>
                                </label>
                                <label class="input-checkbox-label input-checkbox-label-order-page">
                                    <input type="checkbox" name="order-tag[]" value="Контент стратегия" class="input-hide">
                                    <div class="input-checkbox-label-indicator">
                                        <p class="input-checkbox-label-point"></p>
                                        <p class="input-checkbox-label-text">Контент стратегия</p>
                                    </div>
                                </label>
                                <label class="input-checkbox-label input-checkbox-label-order-page">
                                    <input type="checkbox" name="order-tag[]" value="SEO продвижение" class="input-hide">
                                    <div class="input-checkbox-label-indicator">
                                        <p class="input-checkbox-label-point"></p>
                                        <p class="input-checkbox-label-text">SEO продвижение</p>
                                    </div>
                                </label>
                                <label class="input-checkbox-label input-checkbox-label-order-page">
                                    <input type="checkbox" name="order-tag[]" value="Контекстная реклама" class="input-hide">
                                    <div class="input-checkbox-label-indicator">
                                        <p class="input-checkbox-label-point"></p>
                                        <p class="input-checkbox-label-text">Контекстная реклама</p>
                                    </div>
                                </label>
                                <label class="input-checkbox-label input-checkbox-label-order-page">
                                    <input type="checkbox" name="order-tag[]" value="Составление семантического ядра" class="input-hide">
                                    <div class="input-checkbox-label-indicator">
                                        <p class="input-checkbox-label-point"></p>
                                        <p class="input-checkbox-label-text">Составление семантического ядра</p>
                                    </div>
                                </label>
                            </div>
                            <div class="create-resume-form_main_btns">
                                <button class="btn--purple  button__next" type="button">
                                    Далее  ➜
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="create-resume-form_main_staps Stap2">
                        <div class="create-resume-form_main_container">
                            <h2 class="create-resume-form_main-title">2. Площадки</h2>
                            <h4 class="create-resume-form_main-subtitle">
                                Выберите площадки
                            </h4>
                            <div class="checkbox-group">
                                <label class="input-checkbox-label input-checkbox-label-order-page">
                                    <input checked type="checkbox" name="order-founds[]" value="Facebook" class="input-hide">
                                    <div class="input-checkbox-label-indicator">
                                        <p class="input-checkbox-label-point"></p>
                                        <p class="input-checkbox-label-text">Facebook</p>
                                    </div>
                                </label>
                                <label class="input-checkbox-label input-checkbox-label-order-page">
                                    <input type="checkbox" name="order-founds[]" value="Одноклассники" class="input-hide">
                                    <div class="input-checkbox-label-indicator">
                                        <p class="input-checkbox-label-point"></p>
                                        <p class="input-checkbox-label-text">Одноклассники</p>
                                    </div>
                                </label>
                                <label class="input-checkbox-label input-checkbox-label-order-page">
                                    <input type="checkbox" name="order-founds[]" value="VKontakte" class="input-hide">
                                    <div class="input-checkbox-label-indicator">
                                        <p class="input-checkbox-label-point"></p>
                                        <p class="input-checkbox-label-text">VKontakte</p>
                                    </div>
                                </label>
                                <label class="input-checkbox-label input-checkbox-label-order-page">
                                    <input type="checkbox" name="order-founds[]" value="VKontakte" class="input-hide">
                                    <div class="input-checkbox-label-indicator">
                                        <p class="input-checkbox-label-point"></p>
                                        <p class="input-checkbox-label-text">VKontakte</p>
                                    </div>
                                </label>
                                <label class="input-checkbox-label input-checkbox-label-order-page">
                                    <input type="checkbox" name="order-founds[]" value="Яндекс.Директ" class="input-hide">
                                    <div class="input-checkbox-label-indicator">
                                        <p class="input-checkbox-label-point"></p>
                                        <p class="input-checkbox-label-text">Яндекс.Директ</p>
                                    </div>
                                </label>
                                <label class="input-checkbox-label input-checkbox-label-order-page">
                                    <input type="checkbox" name="order-founds[]" value="Яндекс.Директ" class="input-hide">
                                    <div class="input-checkbox-label-indicator">
                                        <p class="input-checkbox-label-point"></p>
                                        <p class="input-checkbox-label-text">Яндекс.Директ</p>
                                    </div>
                                </label>
                                <label class="input-checkbox-label input-checkbox-label-order-page">
                                    <input type="checkbox" name="order-founds[]" value="Instagram" class="input-hide">
                                    <div class="input-checkbox-label-indicator">
                                        <p class="input-checkbox-label-point"></p>
                                        <p class="input-checkbox-label-text">Instagram</p>
                                    </div>
                                </label>
                                <label class="input-checkbox-label input-checkbox-label-order-page">
                                    <input type="checkbox" name="order-founds[]" value="Instagram" class="input-hide">
                                    <div class="input-checkbox-label-indicator">
                                        <p class="input-checkbox-label-point"></p>
                                        <p class="input-checkbox-label-text">Instagram</p>
                                    </div>
                                </label>
                                <label class="input-checkbox-label input-checkbox-label-order-page">
                                    <input type="checkbox" name="order-founds[]" value="Telegram" class="input-hide">
                                    <div class="input-checkbox-label-indicator">
                                        <p class="input-checkbox-label-point"></p>
                                        <p class="input-checkbox-label-text">Telegram</p>
                                    </div>
                                </label>
                                <label class="input-checkbox-label input-checkbox-label-order-page">
                                    <input type="checkbox" name="order-founds[]" value="Telegram" class="input-hide">
                                    <div class="input-checkbox-label-indicator">
                                        <p class="input-checkbox-label-point"></p>
                                        <p class="input-checkbox-label-text">Telegram</p>
                                    </div>
                                </label>
                            </div>
                            <div class="create-resume-form_main_btns">
                                <button class="btn--purple  button__next" type="button">
                                    Далее  ➜
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="create-resume-form_main_staps Stap3">
                        <div class="create-resume-form_main_container">
                            <h2 class="create-resume-form_main-title">3. Описание задачи</h2>
                            <h4 class="create-resume-form_main-subtitle">
                                Подробно опишите задачу. Можете прикрепить файл с описанием или дополнительной информацией
                            </h4>
                            <textarea class="input-t input-textarea" name="order-description" placeholder="Введите текст"></textarea>
                            <div style="margin-bottom: 36px; float: right;" class="input__wrapper specialistorder_input-file">
                                <input name="file" type="file" id="input__file" class="input input__file">
                                <label style="display: flex; align-items:center;" for="input__file" class="input__file-button">
                                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M7.65967 2.69628C8.06007 2.52901 8.4897 2.44287 8.92364 2.44287C9.35758 2.44287 9.7872 2.52901 10.1876 2.69628C10.588 2.86356 10.9512 3.10865 11.2562 3.41735C11.5612 3.72605 11.8018 4.09221 11.9642 4.49461C12.1262 4.89585 12.2071 5.32516 12.2023 5.75779L12.1973 13.1244L12.1972 13.1291C12.1881 13.704 11.9534 14.2523 11.5436 14.6557C11.1338 15.059 10.5818 15.2851 10.0068 15.2851C9.43184 15.2851 8.8799 15.059 8.47012 14.6557C8.06033 14.2523 7.82557 13.704 7.81649 13.1291L7.81641 13.1241V7.50007C7.81641 7.15489 8.09623 6.87507 8.44141 6.87507C8.78659 6.87507 9.06641 7.15489 9.06641 7.50007V13.1137C9.07141 13.3589 9.17206 13.5926 9.34699 13.7648C9.52295 13.938 9.75994 14.0351 10.0068 14.0351C10.2537 14.0351 10.4907 13.938 10.6667 13.7648C10.8417 13.5926 10.9423 13.3588 10.9473 13.1135L10.9524 5.74997L10.9524 5.74639C10.9557 5.4779 10.9056 5.21143 10.8051 4.96244C10.7046 4.71344 10.5557 4.48687 10.367 4.29585C10.1783 4.10484 9.95351 3.95318 9.70575 3.84968C9.45799 3.74617 9.19215 3.69287 8.92364 3.69287C8.65513 3.69287 8.38928 3.74617 8.14153 3.84968C7.89377 3.95318 7.66902 4.10484 7.48031 4.29585C7.29159 4.48687 7.14268 4.71344 7.04218 4.96244C6.94169 5.21143 6.89162 5.4779 6.89488 5.74639L6.89492 5.75018V13.1733L6.89486 13.1779C6.8889 13.5895 6.96483 13.9982 7.11822 14.3802C7.27162 14.7622 7.49942 15.1099 7.78839 15.403C8.07735 15.6962 8.42172 15.929 8.80146 16.0879C9.1812 16.2468 9.58875 16.3287 10.0004 16.3287C10.412 16.3287 10.8196 16.2468 11.1993 16.0879C11.5791 15.929 11.9234 15.6962 12.2124 15.403C12.5014 15.1099 12.7292 14.7622 12.8826 14.3802C13.036 13.9982 13.1119 13.5895 13.1059 13.1779L13.1059 13.1733V6.23991C13.1059 5.89473 13.3857 5.61491 13.7309 5.61491C14.076 5.61491 14.3559 5.89473 14.3559 6.23991V13.1645C14.3636 13.7402 14.2571 14.3117 14.0425 14.8459C13.8274 15.3817 13.5079 15.8693 13.1027 16.2805C12.6974 16.6917 12.2144 17.0182 11.6819 17.241C11.1493 17.4639 10.5777 17.5787 10.0004 17.5787C9.42307 17.5787 8.85151 17.4639 8.31893 17.241C7.78636 17.0182 7.3034 16.6917 6.89813 16.2805C6.49286 15.8693 6.17338 15.3817 5.95825 14.8459C5.7437 14.3117 5.63721 13.7401 5.64492 13.1645V5.75757C5.6402 5.32501 5.72112 4.89578 5.88303 4.49461C6.04543 4.09221 6.2861 3.72604 6.59108 3.41735C6.89605 3.10865 7.25927 2.86356 7.65967 2.69628Z" fill="#EB38D2"/></svg>
                                    <span class="input__file-button-text">Прикрепить файл</span>
                                </label>
                            </div>
                            <div class="create-resume-form_main_btns">
                                <button class="btn--purple  button__next" type="button">
                                    Далее  ➜
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="create-resume-form_main_staps Stap4">
                        <div class="create-resume-form_main_container">
                            <h2 style="margin-bottom: 36px;" class="create-resume-form_main-title">4. Бюджет и срок</h2>
                            <h4 class="create-resume-form_main-subtitle" style="margin-bottom: 12px;">
                                Укажите дату готовности заказа
                            </h4>
                            <input  style="margin-bottom: 12px; max-width: 280px;" type="date" placeholder="Введите дату" name="order-date" class="input-t input-date">
                            <label class="input-checkbox-label input-checkbox-label-order-page">
                                <input type="checkbox" name="order-date[]" value="Открытая дата. Жду предложений от исполнителя" class="input-hide">
                                <div style="margin-bottom: 36px;" class="input-checkbox-label-indicator">
                                    <p class="input-checkbox-label-point"></p>
                                    <p class="input-checkbox-label-text">Открытая дата. Жду предложений от исполнителя</p>
                                </div>
                            </label>
                            <h4 class="create-resume-form_main-subtitle" style="margin-bottom: 12px;">
                                Укажите бюджет
                            </h4>
                            <div class="specialistorder-group" style="margin-bottom: 16px;">
                                <input style="margin-bottom: 0px;"  type="number" name="order-summ" placeholder="Введите сумму" class="input-t input-summ">
                                <p class="specialistorder-group-text">рублей</p>
                            </div>
                            <label class="input-checkbox-label input-checkbox-label-order-page">
                                <input type="checkbox" name="order-summ[]" value="Открытая дата. Жду предложений от исполнителя" class="input-hide">
                                <div style="margin-bottom: 36px;" class="input-checkbox-label-indicator">
                                    <p class="input-checkbox-label-point"></p>
                                    <p class="input-checkbox-label-text">Не могу оценить бюджет. Открыт к предложениям исполнителя</p>
                                </div>
                            </label>
                            <div class="create-resume-form_main_btns">
                                <button class="btn--purple  button__next" type="button">
                                    Далее  ➜
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="create-resume-form_main_staps Stap5">
                        <div class="create-resume-form_main_container">
                            <h2 style="margin-bottom: 36px;" class="create-resume-form_main-title">5. Проверка заказа</h2>
                            <h3 class="order-name"></h3>
                            <h4 class="order--ttl">специализации</h4>
                            <ul class="order-tags"></ul>
                            <div class="specialistorder-line"></div>
                            <h4 class="order--ttl">описание задачи</h4>
                            <p class="order-description car-order-description"></p>
                            <div class="specialistorder-line"></div>
                            <div class="check-order-last">
                                <div class="check-order-last-g">
                                    <h4 class="order--ttl">бюджет</h4>
                                    <p class="order-description cr-order-summ"></p>
                                </div>
                                <div class="check-order-last-g">
                                    <h4 class="order--ttl">Дата сдачи проекта</h4>
                                    <p class="order-description cr-order-date"></p>
                                </div>
                            </div>
                            <div class="create-resume-form_main_btns">
                                <button class="btn--purple" type="submit">
                                    Разместить заказ  ➜
                                </button>
                                <p class="create-resume-form_main_btns-oferta"><svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg"><rect width="16" height="16" rx="4" fill="#EB38D2"/><path fill-rule="evenodd" clip-rule="evenodd" d="M11.7 5.3C11.3 4.9 10.7 4.9 10.3 5.3L7 8.6L5.7 7.3C5.3 6.9 4.7 6.9 4.3 7.3C3.9 7.7 3.9 8.3 4.3 8.7L6.3 10.7C6.5 10.9 6.7 11 7 11C7.3 11 7.5 10.9 7.7 10.7L11.7 6.7C12.1 6.3 12.1 5.7 11.7 5.3Z" fill="white"/></svg>Согласен с условиями <a href="">договора оферты</a></p>
                            </div>
                        </div>
                    </div>
                </section>
            <?= Html::endForm(); ?>
        </div>
    </section>

    <footer class="footer">
        <div class="">
            <a href="<?= Url::to(['manual']) ?>" class="footer__link">
                Руководство пользователя
            </a>
            <a href="<?= Url::to(['support']) ?>" class="footer__link">
                Тех.поддержка
            </a>
        </div>
    </footer>
</section>

<div class="popups-back"></div>
<section class="popup popup-done popup-2">
    <div class="popup-wrapper">
        <button class="popup-close"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M12.2855 11.2249L16.2907 7.21967C16.5836 6.92678 17.0585 6.92678 17.3514 7.21967C17.6443 7.51256 17.6443 7.98744 17.3514 8.28033L13.3462 12.2855L17.3514 16.2907C17.6443 16.5836 17.6443 17.0585 17.3514 17.3514C17.0585 17.6443 16.5836 17.6443 16.2907 17.3514L12.2855 13.3462L8.28033 17.3514C7.98744 17.6443 7.51256 17.6443 7.21967 17.3514C6.92678 17.0585 6.92678 16.5836 7.21967 16.2907L11.2249 12.2855L7.21967 8.28033C6.92678 7.98744 6.92678 7.51256 7.21967 7.21967C7.51256 6.92678 7.98744 6.92678 8.28033 7.21967L12.2855 11.2249Z" fill="#9BA0B7"/></svg></button>

        <svg style="margin-bottom: 20px; width: 120px; height: 120px;" width="120" height="120" viewBox="0 0 120 120" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="60" cy="60" r="43" fill="#92E3A9"/><circle cx="60" cy="60" r="36" fill="white"/><path d="M44.2578 59.0245C43.1667 57.7776 41.2714 57.6512 40.0245 58.7423C38.7776 59.8333 38.6513 61.7286 39.7423 62.9755L50.2423 74.9755C51.4075 76.3071 53.4661 76.3463 54.6811 75.0599L80.181 48.0599C81.3187 46.8553 81.2644 44.9566 80.0599 43.819C78.8553 42.6813 76.9566 42.7356 75.819 43.9401L52.5848 68.5411L44.2578 59.0245Z" fill="#92E3A9"/></svg>

        <p style="margin-bottom: 12px;" class="popup-case-name">Заказ размещен!</p>
        <p style="margin-bottom: 44px;" class="popup-order-name-text">Ваш заказ успешно размещен в каталоге. Отклики исполнителей буду размещены на странице проекта</p>

        <button style="max-width: fit-content;" class="popup-cancel btn--purple" type="button">Понятно</button>
    </div>
</section>