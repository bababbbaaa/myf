<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-admin',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'admin\controllers',
    'bootstrap' => ['log'],
    'name' => 'ОБЩЕЕ',
    'modules' => [
        'rbac' => [
            'class' => 'admin\modules\rbac\Module',
            'defaultRoute' => 'main'
        ],
        'cms' => [
            'class' => 'admin\modules\cms\Module',
            'defaultRoute' => 'main'
        ],
        'lead-force' => [
            'class' => 'admin\modules\lead_force\Module',
            'defaultRoute' => 'main'
        ],
        'logs' => [
            'class' => 'admin\modules\logs\Module',
            'defaultRoute' => 'main'
        ],
        'contact-center' => [
            'class' => 'admin\modules\contact_center\Module',
            'defaultRoute' => 'main'
        ],
        'support' => [
            'class' => 'admin\modules\support\Module',
            'defaultRoute' => 'main'
        ],
        'api-docs' => [
            'class' => 'admin\modules\api_docs\Module',
            'defaultRoute' => 'main'
        ],
        'skill-force' => [
            'class' => 'admin\modules\skill_force\Module',
            'defaultRoute' => 'main'
        ],
        'dev-force' => [
            'class' => 'admin\modules\dev_force\Module',
            'defaultRoute' => 'main'
        ],
        'settings' => [
            'class' => 'admin\modules\settings\Module',
            'defaultRoute' => 'main'
        ],
        'reports' => [
            'class' => 'admin\modules\reports\Module',
            'defaultRoute' => 'main'
        ],
    ],
    'controllerMap' => [
        'elfinder' => [
            'class' => 'mihaildev\elfinder\Controller',
            'access' => ['@'], //глобальный доступ к фаил менеджеру @ - для авторизорованных , ? - для гостей , чтоб открыть всем ['@', '?']
            'disabledCommands' => ['netmount'], //отключение ненужных команд https://github.com/Studio-42/elFinder/wiki/Client-configuration-options#commands
            'roots' => [
                [
                    'baseUrl' => '@web',
                    'basePath' => '@webroot',
                    'path' => 'uploads',
                    'name' => 'Загрузки'
                ],
            ],
            /*'watermark' => [
                'source'         => __DIR__.'/logo.png', // Path to Water mark image
                'marginRight'    => 5,          // Margin right pixel
                'marginBottom'   => 5,          // Margin bottom pixel
                'quality'        => 95,         // JPEG image save quality
                'transparency'   => 70,         // Water mark image transparency ( other than PNG )
                'targetType'     => IMG_GIF|IMG_JPG|IMG_PNG|IMG_WBMP, // Target image formats ( bit-field )
                'targetMinPixel' => 200         // Target image minimum pixel size
            ]*/
        ]
    ],
    'layout' => 'admin',
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-admin',
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-admin', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the admin
            'name' => 'advanced-admin',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
                /*[
                    'class' => 'yii\log\FileTarget',
                    'categories' => ['yii\swiftmailer\Logger::add'],
                ],*/
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                '' => 'site/index',
                /*'<action:\w+>' => '<controller>/<action>', //<controller:\w+>/
                '<action:\w+>' => '<controller>/<action>', //<controller:\w+>/*/
                #'<action:[\w\-]*>' => '<module>/<controller>/<action>',
            ],
        ],
    ],
    'params' => $params,
];
