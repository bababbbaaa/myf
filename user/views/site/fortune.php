<?php

use yii\helpers\Url;

$this->title = 'Колесо фортуны';
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
$this->registerJsFile(Url::to(['/js/Winwheel2.js']), ['depends' => [\yii\web\JqueryAsset::className()]]);
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
        /* #canvasContainer{
            width: 300px !important;
            height: 300px !important;
        } */
        #canvas {
            width: 280px;
            height: 280px;
        }
    }
</style>
<section class="rightInfo">
            <?php
        $js1 = <<<JS
var wheelRolling = false;
let theWheel = new Winwheel({
                'innerRadius'     : 60,         // Make wheel hollow so segments dont go all way to center.
                'outerRadius'     : 220,
                'centerX'    : 300,         // Set x and y as number.
                'centerY'    : 300,
                'drawMode'        : 'image',
                'drawText'        : true,
                'textOrientation' : 'horizontal',   // Set text properties.
                'textFontFamily' : 'Inter',
                'textFontSize'    : 12,
                'textFontWeight'    : 'bold',
                'textAlignment'     : 'inner',
                'textFillStyle'     : 'white',
                'pointerAngle' : 90,
                // 'responsive'        : true,        // If set to true the wheel will resize when the window first loads and also onResize.
                // 'scaleFactor'       : 1,            // Set by the responsive function. Used in many calculations to scale the wheel.
                'numSegments'     : 18,     // Specify number of segments.
                'segments'        :             // Define segments including colour and text.
                [                               // font size and text colour overridden on backrupt segments.
                   {'fillStyle' : '#abff95', 'text' : '1 Лид от 500 (регион) '}, 
                   {'fillStyle' : '#f7ff95', 'text' : 'Франшиза БФЛ'}, 
                   {'fillStyle' : '#abff95', 'text' : '500 контактов (вся РФ)'}, 
                   {'fillStyle' : '#f7ff95', 'text' : '500 лидов от 100 (регион)'}, 
                   {'fillStyle' : '#abff95', 'text' : '5 Лидов до 200 (регион)'}, 
                   {'fillStyle' : '#f7ff95', 'text' : '100 Лидов от 500 (регион)'}, 
                   {'fillStyle' : '#abff95', 'text' : '200 Лидов от 300 (регион)'}, 
                   {'fillStyle' : '#f7ff95', 'text' : '3 Лидов от 300 (регион)'},
                   {'fillStyle' : '#abff95', 'text' : '250 контактов (регион)'},
                   {'fillStyle' : '#f7ff95', 'text' : '10 Лидов до 150 (регион)'},
                   {'fillStyle' : '#abff95', 'text' : 'Настройка Яндекс Директ!'},
                   {'fillStyle' : '#f7ff95', 'text' : '3 Лида от 250 (регион)'},
                   {'fillStyle' : '#abff95', 'text' : 'Модуль Bitrix24'},
                   {'fillStyle' : '#f7ff95', 'text' : '50 Лидов до 100 (регион)'},
                   {'fillStyle' : '#abff95', 'text' : '100 Лидов до 50 (регион)'},
                   {'fillStyle' : '#f7ff95', 'text' : 'Курс Фин.Защита'},
                   {'fillStyle' : '#abff95', 'text' : '25 Лидов до 100 (регион)'},
                   {'fillStyle' : '#f7ff95', 'text' : 'Курс Защита имущества'},
                  
                ],
                'animation' :           // Specify the animation to use.
                {
                    'type'     : 'spinToStop',
                    'duration' : 5,
                    'spins'    : 3,
                    'callbackFinished' : alertPrize,  // Function to call whent the spinning has stopped.
                },
                // 'pins' :                // Turn pins on.
                // {
                //     'number'     : 18,
                //     'fillStyle'  : 'red',
                //     'outerRadius': 4,
                // }
            });

            let wheelImg = new Image();
 
            wheelImg.onload = function()
            {
                theWheel.wheelImage = wheelImg;
                theWheel.draw();
            }
 
            wheelImg.src = "/img/weel.png";

            // Called when the animation has finished.
            function alertPrize(indicatedSegment)
            {
                wheelRolling = false;
                $.ajax({
                    data: {prize: indicatedSegment.text},
                    dataType: "JSON",
                    type: "POST",
                    url: "/site/prize"
                }).done(function (response) {
                    if (response.success) {
                        Swal.fire({
                          icon: 'success',
                          title: 'Ура!',
                          text: "Поздравляем! Вы выиграли - " + indicatedSegment.text + ". Наш менеджер уже осведомлен и свяжется с вами в ближайшее время.",
                        });
                    } else {
                        Swal.fire({
                          icon: 'error',
                          title: 'Ошибка',
                          text: response.message,
                        });
                    }
                });
            }
            $('.toggle-wheel').on('click', function (e) {
                if (!wheelRolling) {
                    $.ajax({
                        url: '/site/wheel-rolling',
                        type: "POST",
                        dataType: "JSON",
                        data: {roll: 1}
                    }).done(function (response) {
                        if (response.success) {
                            wheelRolling = true;
                            theWheel.startAnimation();
                            $('.bonus-span').text(response.bonus ?? 0);
                            $('.HText.Hcont_R_Balance-t > .gg1').text((response.balance ?? 0).toLocaleString());
                        } else {
                            Swal.fire({
                              icon: 'error',
                              title: 'Ошибка',
                              text: response.message,
                            });
                        }
                    });
                }
            });

            // $(window).resize(function(){
            //     var canvasWidth = $('#canvasContainer').width();
            //     $('#canvas').css({
            //         'height': canvasWidth,
            //     });
            // });
JS;

        $this->registerJs($js1);
        ?>
        <style>
            #canvasContainer {
                position: relative;
                /* width: 600px; */
            }
            #canvas {
                z-index: 1;
            }
            #prizePointer {
                position: absolute;
                left: 100%;
                top: 50%;
                transform: rotateZ(90deg) translateX(-50%);
                margin-left: -28px;
                z-index: 2;
            }
        </style>
        <div style="font-size: 24px; line-height: 28px; margin-top: 40px; margin-bottom: 28px; font-weight: 400;">
            Колесо фортуны
        </div>
        <div style="position:relative; display: flex; flex-wrap: wrap; gap: 18px; margin-bottom: 50px">
            <div id="canvasContainer">
                <canvas id='canvas' width='600' height='600'>
                    Canvas not supported, use another browser.
                </canvas>
                <img id="prizePointer" src="/img/arWheel.png" height="30" alt="V" />
            </div>
            <div>
                <div class="coins__bonuses" style="max-width: 300px; width: 100%; margin-bottom: 20px">
                    <svg class="svg__coins" width="24" height="24" viewBox="0 0 24 24" fill="none"
                         xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                              d="M5.31818 2.5H18.6818L22.5 9.15L12 21.5L1.5 9.15L5.31818 2.5Z" fill="#2CCD65"
                              stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M5.31824 2.5L12.0001 21.5L18.6819 2.5"
                              fill="#2CCD65"/>
                        <path d="M5.31824 2.5L12.0001 21.5L18.6819 2.5" stroke="white" stroke-width="2"
                              stroke-linecap="round" stroke-linejoin="round"/>
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M1.5 9.15039H22.5H1.5Z" fill="#2CCD65"/>
                        <path d="M1.5 9.15039H22.5" stroke="white" stroke-width="2" stroke-linecap="round"
                              stroke-linejoin="round"/>
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M7.70459 9.15L12 2.5L16.2955 9.15"
                              fill="#2CCD65"/>
                        <path d="M7.70459 9.15L12 2.5L16.2955 9.15" stroke="white" stroke-width="2"
                              stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    <p style="margin-left: 10px;">Мои бонусы: <span class="bonus-span"><?= number_format($points, 0, 0, ' ') ?></span></p>
                </div>
                <div class="btn toggle-wheel" style="font-weight: 400; border-radius: 100px; font-size: 12px">Вращать колесо за 100 <svg class="svg__coins" width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                                                                                                         xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                              d="M5.31818 2.5H18.6818L22.5 9.15L12 21.5L1.5 9.15L5.31818 2.5Z" fill="#007fea"
                              stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M5.31824 2.5L12.0001 21.5L18.6819 2.5"
                              fill="#007fea"/>
                        <path d="M5.31824 2.5L12.0001 21.5L18.6819 2.5" stroke="white" stroke-width="2"
                              stroke-linecap="round" stroke-linejoin="round"/>
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M1.5 9.15039H22.5H1.5Z" fill="#007fea"/>
                        <path d="M1.5 9.15039H22.5" stroke="white" stroke-width="2" stroke-linecap="round"
                              stroke-linejoin="round"/>
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M7.70459 9.15L12 2.5L16.2955 9.15"
                              fill="#007fea"/>
                        <path d="M7.70459 9.15L12 2.5L16.2955 9.15" stroke="white" stroke-width="2"
                              stroke-linecap="round" stroke-linejoin="round"/>
                    </svg></div>
                <div style="font-size: 11px; margin-top: 10px; max-width: 300px">* можно вращать колесо за баланс личного кабинета, при расчете, что 1 бонус = 10 рублей</div>
            </div>
        </div>
</section>

