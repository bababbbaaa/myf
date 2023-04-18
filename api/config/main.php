<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-api',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'api\controllers',
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-api',
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-api', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the api
            'name' => 'advanced-api',
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
            'rules' => [
                '' => 'site/index',
                'lead.add' => 'lead/add',
                'lead.add.old' => 'lead/add-old',
                'lead.get.from.call' => 'lead/get-from-call',
                'lead.get.voice' => 'lead/get-voice',
                'bitrix.lead.add' => 'bitrix/lead-add',
                'bitrix.telegram.notification' => 'bitrix/telegram-notification',
                'bitrix.telegram.counter' => 'bitrix/tg-counter',
                'bitrix.call.tracker' => 'bitrix/call-tracker',
                'payments.result.save' => 'payments-result/save',
                'm3.hook' => 'm3/hook',
                'lawyer.bot' => 'site/lawyer-bot',
                'bavaria.bot' => 'site/bavaria-bot',
                'statistics.push/<token:>/<id:>' => 'statistics/push',
                'rest/<UUID:>/crm.lead.list' => 'rest/crm-lead-list',
                '<action:\w+>/' => '<controller>/<action>', //<controller:\w+>/
            ],
        ],
    ],
    'params' => $params,
];
