<?php

/**
 * @var \yii\web\View $this
 */

use yii\helpers\Url;

$this->title = 'Личный кабинет MYFORCE';
$id = Yii::$app->getUser()->getId();
$user = \common\models\User::findOne($id);

if (empty($user->is_client)) {
    $js = <<<JS
function proceed(val) {
    var response;
    $.ajax({
        data: {data: val},
        type: "POST",
        dataType: "JSON",
        url: '/site/proceed'
    }).done(function(rsp) {
        response = rsp;
        if (rsp.status === 'success') {
          location.href = rsp.url;
        }
    });
    return response;
}
$('.choose-destination').on('click', function(e) {
    e.preventDefault();
    const swalWithBootstrapButtons = Swal.mixin({
      customClass: {
        confirmButton: 'btn special-btn-provider',
        cancelButton: 'btn special-btn-client',
        title: 'special-title'
      },
      buttonsStyling: false
    });
    
    swalWithBootstrapButtons.fire({
      title: 'Вы желаете покупать или поставлять лиды?',
      html: "<b>Внимание</b>: ваша учетная запись будет привязана к вашему выбору. Данный выбор изменить нельзя",
      icon: 'info',
      showCancelButton: true,
      confirmButtonText: 'Я - поставщик',
      cancelButtonText: 'Я - покупатель',
      reverseButtons: true,
      allowOutsideClick: false
    }).then((result) => {
        console.log(result);
        var rsp;
        if (result.value === true) {
          rsp = proceed(-1);
        } else {
          rsp = proceed(1);
        }
    });
});
JS;
    $this->registerJs($js);
}
$this->registerJsFile(Url::to(['/js/tween.js']), ['depends' => [\yii\web\JqueryAsset::className()]]);
$userBonus = \common\models\UsersBonuses::findOne(['user_id' => Yii::$app->getUser()->getId()]);
if (!empty($userBonus) && $userBonus->bonus_points > 0)
    $points = $userBonus->bonus_points;
else
    $points = 0;
?>
    <style>
        .d1 {
            font-size: 16px;
            line-height: 24px;
            font-weight: 400;
            margin-top: 20px;
            max-width: 610px;
        }

        .d2 {
            max-width: 800px
        }

        .d3 {
            margin-bottom: 10px;
        }

        .flex-gap {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
        }

        .hov1block {
            max-width: 610px;
            border-radius: 8px;
            padding: 28px 28px 30px;
            background: #FFFFFF;
            width: 100%;
            position: relative;
            overflow: hidden;
        }

        .hov2block, .hov3block, .hov4block, .hov5block {
            max-width: 295px;
            border-radius: 8px;
            padding: 28px 28px 30px;
            background: #FFFFFF;
            width: 100%;
            position: relative;
            overflow: hidden;
        }

        .hov1block:hover {
            color: white;
            background: linear-gradient(#1983ff, #002587);
        }

        .hov2block:hover {
            color: white;
            background: linear-gradient(#2CCD65, #2096EC);
        }

        .hov3block:hover {
            color: white;
            background: linear-gradient(#00D6EC, #EB38D2);
        }

        .hov4block:hover {
            color: white;
            background: #4135F1;
        }

        .hov5block:hover {
            color: white;
            background: linear-gradient(#7A6BDE, #4135F1);
        }

        .hov1block:hover > .imghovblock1 {
            background-image: url('/img/z0001_2.png');
        }

        .hov1block:hover > .sm-img1 {
            background-image: url('/img/z0005.png');
        }

        .hov2block:hover > .sm-img2 {
            background-image: url('/img/z_001lf_1.png');
        }

        .hov3block:hover > .sm-img3 {
            background-image: url('/img/z_ads02.png');
        }

        .hov4block:hover > .sm-img4 {
            background-image: url('/img/z_skill02.png');
        }

        .hov5block:hover > .sm-img5 {
            background-image: url('/img/z_femida02.png');
        }

        .imghovblock1 {
            position: absolute;
            right: 0;
            bottom: 0;
            background-position: bottom right;
            background-image: url('/img/z0001.png');
            background-repeat: no-repeat;
            width: 456px;
            height: 300px;
        }

        .sm-img1 {
            width: 182px;
            height: 24px;
            background-image: url("/img/z0003.png");
        }

        .sm-img2 {
            width: 212px;
            background-repeat: no-repeat;
            height: 24px;
            background-image: url("/img/z_001lf_0.png");
        }

        .sm-img3 {
            width: 193px;
            background-repeat: no-repeat;
            height: 24px;
            background-image: url("/img/z_ads01.png");
        }

        .sm-img4 {
            background-repeat: no-repeat;
            width: 222px;
            height: 24px;
            background-image: url("/img/z_skill01.png");
        }

        .sm-img5 {
            background-repeat: no-repeat;
            width: 238px;
            height: 24px;
            background-image: url("/img/z_femida01.png");
        }

        .a-block-link {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
        }

        .white-block {
            padding: 24px 40px;
            margin-top: 40px;
            background: white;
            max-width: 925px;
        }

        @media screen and (max-width: 1400px) {
            .balance {
                padding-top: 20px;
            }
        }

        @media screen and (max-width: 1321px) {
            .hov2block {
                max-width: 610px;
            }
        }

        @media screen and (max-width: 650px) {
            .hov2block, .hov3block, .hov4block, .hov5block {
                max-width: none;
            }

            .imghovblock1 {
                display: none;
            }
        }
    </style>
    <section class="rightInfo">
    <div class="balance">
        <h1 class="Bal-ttl title-main d2">Добро пожаловать в экосистему <b>MYFORCE</b></h1>
        <div class="d1">
            <p class="d3">В этом личном кабинете представлены все сервисы экосистемы.</p>
            <p>В помощью навигации ниже и в боковом меню, вы можете перейти в интересующий вас сервис</p>
        </div>
        <div style="font-size: 24px; line-height: 28px; margin-top: 40px; margin-bottom: 28px; font-weight: 400;">
            Выберите сервис
        </div>
        <div class="flex-gap">
            <div class="hov1block">
                <div class="sm-img1"></div>
                <div style="font-size: 16px; line-height: 24px; margin-top: 20px; margin-bottom: 54px; max-width: 289px">
                    Создание и продвижение сайтов для вашего бизнеса
                </div>
                <div style="font-size: 16px; line-height: 20px">Перейти →</div>
                <div class="imghovblock1"></div>
                <a class="a-block-link" href="<?= Url::to(['/dev/']) ?>"></a>
            </div>
            <div class="hov2block">
                <div class="sm-img2"></div>
                <div style="font-size: 16px; line-height: 24px; margin-top: 20px; margin-bottom: 54px; max-width: 289px">
                    Сервис лидогенерации для вашего бизнеса
                </div>
                <div style="font-size: 16px; line-height: 20px">Перейти →</div>
                <a class="a-block-link" href="<?= Url::to(['/lead-force/']) ?>"></a>
            </div>
        </div>
        <div class="flex-gap" style="margin-top: 20px">
            <!--<div class="hov3block">
                <div class="sm-img3"></div>
                <div style="font-size: 16px; line-height: 24px; margin-top: 20px; margin-bottom: 54px; max-width: 289px">
                    Крупная биржа для поиска специалистов по рекламе, дизайну и разработке
                </div>
                <div style="font-size: 16px; line-height: 20px">Перейти →</div>
                <a class="a-block-link" target="_blank" href="https://adsforce.eu"></a>
            </div>
            <div class="hov4block">
                <div class="sm-img4"></div>
                <div style="font-size: 16px; line-height: 24px; margin-top: 20px; margin-bottom: 54px; max-width: 289px">
                    Обучение востребованным профессиям
                </div>
                <div style="font-size: 16px; line-height: 20px">Перейти →</div>
                <a class="a-block-link" href="<?/*= Url::to(['/skill/student/']) */?>"></a>
            </div>-->
            <div class="hov5block">
                <div class="sm-img5"></div>
                <div style="font-size: 16px; line-height: 24px; margin-top: 20px; margin-bottom: 54px; max-width: 289px">
                    Успешные франшизы со стабильным доходом
                </div>
                <div style="font-size: 16px; line-height: 20px">Перейти →</div>
                <a class="a-block-link" href="<?= Url::to(['/femida/client']) ?>"></a>
            </div>
        </div>
        <div class="white-block">
            <div style="font-size: 12px; line-height: 20px; margin-bottom: 24px">ПРОФИЛЬ</div>
            <div style="margin-bottom: 24px; font-size: 16px; line-height: 24px;">Данные, указанные вами при
                регистрации, сохранены во вкладке <a href="/profile/" style="text-decoration: underline;">Профиль</a>.
                При необходимости вы можете их изменить. Заполнение профиля важно для пополнения баланса и оплаты услуг,
                а также для получения средств за выполненные вами услуги.
            </div>
            <div style="font-size: 18px; line-height: 24px; color: #FF6359; margin-bottom: 12px">Важно!</div>
            <div style=" font-size: 16px; line-height: 24px;">В разных сервисах данные для заполнения профиля могут
                отличаться, поэтому для полноценного функционирования кабинета вам необходимо заполнить Профиль в каждом
                используемом сервисе
            </div>
        </div>
        <div class="white-block" style="margin-bottom: 40px">
            <div style="font-size: 12px; line-height: 20px; margin-bottom: 24px">БАЛАНС</div>
            <div style="margin-bottom: 24px; font-size: 16px; line-height: 24px;">Во вкладке <a href="/balance/"
                                                                                                style="text-decoration: underline;">Баланс</a>
                отображены ваши средства для покупки и оплаты услуг экосистемы.
            </div>
            <div style="font-size: 18px; line-height: 24px; color: #FF6359; margin-bottom: 12px">Важно!</div>
            <div style=" font-size: 16px; line-height: 24px;">В разных сервисах баланс отображен в соответствии со
                статусом пользователя. Например, если вы являетесь поставщиком лидов на платформе LEADFORCE, то баланс
                отражает средства, полученные вами от заказчиков и которые вы можете вывести удобным вам способом.
            </div>
        </div>
    </div>
</section>


<?php if (!empty($_GET['flash']) && $_GET['flash'] === 'success'): ?>
    <div id="popBacClose" style="background-color: rgba(0,0,0,0.8); position: fixed; width: 100%; height: 100%; top: 0; left: 0; z-index: 10000">
        <div style="position: absolute; width: 300px; height: 300px; border-radius: 10px; background-color: white; padding: 20px; left: 50%; top: 50%; transform: translate(-50%, -50%)" class="popBody">
            <svg width="70px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><g fill="#1cb30c"><path d="M22,5.18L10.59,16.6l-4.24-4.24l1.41-1.41l2.83,2.83l10-10L22,5.18z M12,20c-4.41,0-8-3.59-8-8s3.59-8,8-8 c1.57,0,3.04,0.46,4.28,1.25l1.45-1.45C16.1,2.67,14.13,2,12,2C6.48,2,2,6.48,2,12s4.48,10,10,10c1.73,0,3.36-0.44,4.78-1.22 l-1.5-1.5C14.28,19.74,13.17,20,12,20z M19,15h-3v2h3v3h2v-3h3v-2h-3v-3h-2V15z"/></g></svg>
            <div style="font-size: 22px; padding-top: 20px" class="popTitle">Кредит оформлен успешно! Средства зачислены на баланс</div>
            <button onclick="document.querySelector('#popBacClose').style.display = 'none'" style="position: absolute; right: 20px; top: 20px; background: none; font-size: 30px; cursor: pointer; outline: none; border: none" class="popClose">&times;</button>
        </div>
    </div>
<?php endif; ?>
<?php if (!empty($_GET['flash']) && $_GET['flash'] === 'error'): ?>
    <div id="popBacClose" style="background-color: rgba(0,0,0,0.8); position: fixed; width: 100%; height: 100%; top: 0; left: 0; z-index: 10000">
        <div style="position: absolute; width: 300px; height: 300px; border-radius: 10px; background-color: white; padding: 20px; left: 50%; top: 50%; transform: translate(-50%, -50%)" class="popBody">
            <svg width="70px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><g fill="#EF0E0E"><path d="M12 2C6.5 2 2 6.5 2 12s4.5 10 10 10 10-4.5 10-10S17.5 2 12 2zM4 12c0-4.4 3.6-8 8-8 1.8 0 3.5.6 4.9 1.7L5.7 16.9C4.6 15.5 4 13.8 4 12zm8 8c-1.8 0-3.5-.6-4.9-1.7L18.3 7.1C19.4 8.5 20 10.2 20 12c0 4.4-3.6 8-8 8z"/></g></svg>
            <div style="font-size: 22px; padding-top: 20px" class="popTitle">Возникла ошибка при оформлении кредита. Пожалуйста обратитесь в
                <a style="color: red" href="<?= Url::to(['/lead-force/client/support']) ?>">тех.поддержку</a></div>
            <button onclick="document.querySelector('#popBacClose').style.display = 'none'" style="position: absolute; right: 20px; top: 20px; background: none; font-size: 30px; cursor: pointer; outline: none; border: none" class="popClose">&times;</button>
        </div>
    </div>
<?php endif; ?>