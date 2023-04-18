<?php
$params = array_merge(
  require __DIR__ . '/../../common/config/params.php',
  require __DIR__ . '/../../common/config/params-local.php',
  require __DIR__ . '/params.php',
  require __DIR__ . '/params-local.php'
);

return [
  'id' => 'app-core',
  'basePath' => dirname(__DIR__),
  'bootstrap' => ['log'],
  'controllerNamespace' => 'core\controllers',
  'components' => [
    'request' => [
      'csrfParam' => '_csrf-core',
    ],
    'user' => [
      'identityClass' => 'common\models\User',
      'enableAutoLogin' => true,
      'identityCookie' => ['name' => '_identity-core', 'httpOnly' => true],
    ],
    'session' => [
      // this is the name of the session cookie used for login on the core
      'name' => 'advanced-core',
    ],
    'log' => [
      'traceLevel' => YII_DEBUG ? 3 : 0,
      'targets' => [
        [
          'class' => 'yii\log\FileTarget',
          'levels' => ['error', 'warning'],
        ],
      ],
    ],
    'errorHandler' => [
      'errorAction' => 'site/error',
    ],
    'urlManager' => [
      'enablePrettyUrl' => true,
      'showScriptName' => false,
      'normalizer' => [
        'class' => 'yii\web\UrlNormalizer',
        'normalizeTrailingSlash' => true,
        'collapseSlashes' => true,
      ],
      'rules' => [
        #main page
        '' => 'site/index',
        'about' => 'site/about',
        'events' => 'site/events',
        'login' => 'site/login',
        'signup' => 'site/signup',
        'news' => 'site/news',
          'lidy-na-bankrotstvo' => 'site/lidy-na-bankrotstvo',
        'club' => 'site/club',
        'bfl-quiz' => 'site/bfl-quiz',
        'thanks' => 'site/thanks',
        'thx' => 'site/thanks-b',
        'bussiness-quiz' => 'site/bussiness-quiz',
        'success-payment' => 'site/success-payment',
        'failure-payment' => 'site/failure-payment',
        'news-page/<link:>' => 'site/news-page',
        'case/<link:>' => 'site/case',
        'registr' => 'site/registr',
        'registr-provider' => 'site/registr-provider',
        'sale-page/<link:>' => 'site/sale-page',
        'event-page/<link:>' => 'site/event-page',
        'occasion-page/<link:>' => 'site/occasion-page',
        'event-form' => 'site/event-form',
        'arbitraj' => 'site/arbitraj',
        'arbitraj-tnx' => 'site/arbitraj-tnx',
        #main page

        #lead.force
        #main
        '/lead' => 'lead/main/index',
        '/lead/about-leads' => 'lead/main/about-leads',
        '/lead/buy-leads' => 'lead/main/buy-leads',
        '/lead/lead-auction' => 'lead/main/lead-auction',
        '/lead/lead-plan/<link:>' => 'lead/main/lead-plan',
        '/lead/news/<link:>' => 'lead/main/news',
        '/lead/traffic-quality' => 'lead/main/traffic-quality',
        '/lead/types-of-leads' => 'lead/main/types-of-leads',
        #main
        #seller
        '/lead/seller' => 'lead/seller/index',
        '/lead/seller/lead-offer/<link:>' => 'lead/seller/lead-offer',
        '/lead/seller/news/<link:>' => 'lead/seller/news',
        #seller
        #lead.force

        #femida
        '/femida' => 'femida/main/index',
        '/femida/about' => 'femida/main/about',
        '/femida/partnership' => 'femida/main/partnership',
        '/femida/technologies' => 'femida/main/technologies',
        '/femida/franchizes' => 'femida/main/franchizes',
        '/femida/franchize/<link:>' => 'femida/main/franchize',
        '/femida/news/<link:>' => 'femida/main/news',
        '/femida/kak-kupit-franchizy' => 'femida/main/kak-kupit-franchizy',
        '/femida/kak-polychit-vozvrat-deneg' => 'femida/main/kak-polychit-vozvrat-deneg',
        '/femida/kak-vubrat-horoshyu-franchizy' => 'femida/main/kak-vubrat-horoshyu-franchizy',
        '/femida/kak-covid-19-povliyal-na-rasklad-sil' => 'femida/main/kak-covid-povliyal-na-rasklad-sil',
        '/femida/vidu-franchizy' => 'femida/main/vidu-franchizy',
        '/femida/chto-takoe-franchaizing' => 'femida/main/chto-takoe-franchaizing',
        #femida

        #skill
        /*'/skill' => '/skill/main/index',
        '/skill/webinars' => '/skill/main/webinars',
        '/skill/intensive' => '/skill/main/intensive',
        '/skill/profession' => '/skill/main/profession',
        '/skill/career' => '/skill/main/career',
        '/skill/teaching' => '/skill/main/prepodavanie',
        '/skill/about' => '/skill/main/about',
        '/skill/coursepage/<link:>' => '/skill/main/coursepage',
        '/skill/test' => '/skill/main/test',
        '/skill/teacher<link:>' => '/skill/main/teacher',
        '/skill/blog' => '/skill/main/blog',
        '/skill/article' => '/skill/main/article',*/
        #skill

        #au
        '/au' => '/au/main/index',
        #au

        #aspb
        '/aspb-main' => '/aspb/main/index',
        '/aspb-main/client/<id:>' => '/aspb/main/client',
        #aspb

        #sitemap
        'sitemap.xml' => 'sitemap/index',
        #sitemap

        '<action:\w+>/' => '<controller>/<action>', //<controller:\w+>/
      ],
    ],
  ],
  'modules' => [
    'femida' => [
      'class' => 'app\modules\femida\Module',
      'defaultRoute' => 'main',
      'layout' => '@core/views/layouts/main.php'

    ],
    'lead' => [
      'class' => 'app\modules\lead\Module',
      'defaultRoute' => 'main',
      'layout' => '@core/views/layouts/main.php'
    ],
    /*'skill' => [
      'class' => 'app\modules\skill\Module',
      'defaultRoute' => 'main',
      'layout' => '@core/modules/skill/views/layouts/skill'
    ],*/
    'au' => [
      'class' => 'app\modules\au\Module',
      'defaultRoute' => 'main',
      'layout' => '@core/modules/au/views/layouts/au'
    ],
    'aspb' => [
      'class' => 'app\modules\aspb\Module',
      'defaultRoute' => 'main',
      'layout' => '@core/modules/aspb/views/layouts/aspb'
    ]
  ],
  /*'controllerMap' => [
        'elfinder' => [
            'class' => 'mihaildev\elfinder\Controller',
            'access' => ['@'], //глобальный доступ к фаил менеджеру @ - для авторизорованных , ? - для гостей , чтоб открыть всем ['@', '?']
            'disabledCommands' => ['netmount'], //отключение ненужных команд https://github.com/Studio-42/elFinder/wiki/Client-configuration-options#commands
            'roots' => [
                [
                    'baseUrl'=>'@web',
                    'basePath'=>'@webroot',
                    'path' => 'uploads',
                    'name' => 'Global'
                ],
            ],
            'watermark' => [
                'source'         => __DIR__.'/logo.png', // Path to Water mark image
                'marginRight'    => 5,          // Margin right pixel
                'marginBottom'   => 5,          // Margin bottom pixel
                'quality'        => 95,         // JPEG image save quality
                'transparency'   => 70,         // Water mark image transparency ( other than PNG )
                'targetType'     => IMG_GIF|IMG_JPG|IMG_PNG|IMG_WBMP, // Target image formats ( bit-field )
                'targetMinPixel' => 200         // Target image minimum pixel size
            ]
        ]
    ],*/
  'params' => $params,
];