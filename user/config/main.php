<?php
$params = array_merge(
  require __DIR__ . '/../../common/config/params.php',
  require __DIR__ . '/../../common/config/params-local.php',
  require __DIR__ . '/params.php',
  require __DIR__ . '/params-local.php'
);

return [
  'id' => 'app-user',
  'basePath' => dirname(__DIR__),
  'controllerNamespace' => 'user\controllers',
  'bootstrap' => ['log'],
  'modules' => [
    'lead-force' => [
      'class' => 'user\modules\lead_force\Module',
      'defaultRoute' => 'client',
      'layout' => '@user/modules/lead_force/views/layouts/main'
    ],
    'femida' => [
      'class' => 'user\modules\femida\Module',
      'defaultRoute' => 'client',
      'layout' => '@user/modules/femida/views/layouts/main'
    ],
    /*'skill' => [
      'class' => 'user\modules\skill\Module',
      'defaultRoute' => 'student',
      'layout' => '@user/modules/skill/views/layouts/main'
    ],*/
    'dev' => [
      'class' => 'user\modules\dev\Module',
      'defaultRoute' => 'student',
      'layout' => '@user/modules/dev/views/layouts/main'
    ],
    'ads' => [
      'class' => 'user\modules\ads\Module',
      'defaultRoute' => 'client',
      'layout' => '@user/modules/ads/views/layouts/main'
    ],
  ],
  'components' => [
    'request' => [
      'csrfParam' => '_csrf-user',
    ],
    'user' => [
      'identityClass' => 'common\models\User',
      'enableAutoLogin' => true,
      'identityCookie' => ['name' => '_identity-user', 'httpOnly' => true],
    ],
    'session' => [
      // this is the name of the session cookie used for login on the user
      'name' => 'advanced-user',
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
        /* main */
        '' => 'site/index',
        'profile' => 'site/prof',
        'fortune' => 'site/fortune',
        'balance' => 'site/balance',
        'knowledge' => 'site/knowledge',
        'knowledgecat' => 'site/knowledgecat',
        'knowledgearticle' => 'site/knowledgearticle',
        'knowledgepage' => 'site/knowledgepage',
        'article-search' => 'site/article-search',
        '/logout' => 'site/logout',
        '/user-login' => 'site/user-login',
        /* main */

        /* FEMIDA CLIENT */
        'femida' => 'client/index',
        'femida/client/catalogpage/<link:>' => 'femida/client/catalogpage',
        'femida/client/technology/<id:>' => 'femida/client/technology-page',
        /* FEMIDA CLIENT */

        'lead-force/client/get-locale-file/<id:>-<type:>' => 'lead-force/client/get-locale-file',
        'lead-force/provider/offer' => 'lead-force/provider/order',
        'lead-force/provider/my-offers' => 'lead-force/provider/myorders',
        'lead-force/provider/offer-lead' => 'lead-force/provider/order-lid',
        'lead-force/provider/offer-lead-add' => 'lead-force/provider/order-lid-add',
        'lead-force/provider/offer-page' => 'lead-force/provider/orderpage',

        /* SKILL CLIENT */
        /*'/student/client' => 'skill/student/index',
        '/student/balance' => 'skill/student/balance',
        '/student/profile' => 'skill/student/profile',
        '/student/bonuses' => 'skill/student/bonuses',
        '/student/education' => 'skill/student/education',
        '/student/create-balance-link' => 'skill/student/create-balance-link',
        '/student/programs' => 'skill/student/programs',
        '/student/mycours' => 'skill/student/mycours',
        '/student/viewcours' => 'skill/student/viewcours',
        '/student/myvebinar' => 'skill/student/myvebinar',
        '/student/myintensiv' => 'skill/student/myintensiv',
        '/student/coursepage' => 'skill/student/coursepage',
        '/student/vebinarpage' => 'skill/student/vebinarpage',
        '/student/intensivpage' => 'skill/student/intensivpage',
        '/student/careercenter' => 'skill/student/careercenter',
        '/student/vacancypage/<id:>' => 'skill/student/vacancypage',
        '/student/manual' => 'skill/student/manual',
        '/student/manualmain' => 'skill/student/manualmain',
        '/student/manualprofile' => 'skill/student/manualprofile',
        '/student/manualbalance' => 'skill/student/manualbalance',
        '/student/manualbonuses' => 'skill/student/manualbonuses',
        '/student/manualeducation' => 'skill/student/manualeducation',
        '/student/manualprograms' => 'skill/student/manualprograms',
        '/student/manualcareer' => 'skill/student/manualcareer',*/
        /* TEACHER */
        /*'/teacher/client/' => 'skill/teacher/index',
        '/teacher/balance/' => 'skill/teacher/balance',
        '/teacher/profile/' => 'skill/teacher/profile',
        '/teacher/statis/' => 'skill/teacher/statis',
        '/teacher/myprograms/' => 'skill/teacher/myprograms',
        '/teacher/mytasks/' => 'skill/teacher/mytasks',
        '/teacher/taskpage/' => 'skill/teacher/taskpage',
        '/teacher/taskpage-assistent/' => 'skill/teacher/taskpage-assistent',
        '/teacher/addprogram/' => 'skill/teacher/addprogram',
        '/teacher/help/' => 'skill/teacher/help',
        '/teacher/help-tasks/' => 'skill/teacher/help-tasks',
        '/teacher/programmpage/' => 'skill/teacher/programmpage',
        '/teacher/vebinarpage/' => 'skill/teacher/vebinarpage',
        '/teacher/webinarpage/' => 'skill/teacher/webinarpage',
        '/teacher/manual/' => 'skill/teacher/manual',
        '/teacher/manualbalance/' => 'skill/teacher/manualbalance',
        '/teacher/manualhelp/' => 'skill/teacher/manualhelp',
        '/teacher/manualmain/' => 'skill/teacher/manualmain',
        '/teacher/manualprofile/' => 'skill/teacher/manualprofile',
        '/teacher/manualprogram/' => 'skill/teacher/manualprogram',
        '/teacher/manualstat/' => 'skill/teacher/manualstat',
        '/teacher/manualtasks/' => 'skill/teacher/manualtasks',
        '/teacher/manualaddprogram/' => 'skill/teacher/manualaddprogram',
        '/teacher/addintensiv/' => 'skill/teacher/addintensiv',
        '/teacher/addwebinar/' => 'skill/teacher/addwebinar',
        '/teacher/addautowebinar/' => 'skill/teacher/addautowebinar',*/
        /* TEACHER */
        /* SKILL CLIENT */

        /* DEV CLIENT */
          '/dev' => 'dev/main/index',
          '/dev/profile' => 'dev/main/profile',
          '/dev/balance' => 'dev/main/balance',
          '/dev/my-projects' => 'dev/main/myprojects',
          '/dev/start-project' => 'dev/main/startproject',
          '/dev/my-projects/<link:>' => 'dev/main/projectpage',
          '/dev/manual' => 'dev/main/manual',
          '/dev/manualmain' => 'dev/main/manualmain',
          '/dev/manualprofile' => 'dev/main/manualprofile',
          '/dev/manualbalance' => 'dev/main/manualbalance',
          '/dev/manualproject' => 'dev/main/manualproject',
          '/dev/manualstart' => 'dev/main/manualstart',
        /* DEV CLIENT */

        /* ADS */
         /* ADS CLIENT */
          '/ads/client' => 'ads/main/index',
          '/ads/client/profile' => 'ads/main/profile',
          '/ads/client/balance' => 'ads/main/balance',
          '/ads/client/myorders' => 'ads/main/myorders',
          '/ads/client/choose' => 'ads/main/choose',
          '/ads/client/createorder' => 'ads/main/createorder',
          '/ads/client/ratingspecialist' => 'ads/main/ratingspecialist',
          '/ads/client/base' => 'ads/main/base',
          '/ads/client/myrating' => 'ads/main/myrating',
          '/ads/client/specialist' => 'ads/main/specialist',
          '/ads/client/specialistorder' => 'ads/main/specialistorder',
          '/ads/client/orderpage' => 'ads/main/orderpage',
          '/ads/client/baseset' => 'ads/main/baseset',
          '/ads/client/article' => 'ads/main/article',
          '/ads/client/messages' => 'ads/main/messages',
          '/ads/client/manual' => 'ads/main/manual',
          '/ads/client/manualmain' => 'ads/main/manualmain',
          '/ads/client/manualprofile' => 'ads/main/manualprofile',
          '/ads/client/manualbalance' => 'ads/main/manualbalance',
          '/ads/client/manualorder' => 'ads/main/manualorder',
          '/ads/client/manualchoose' => 'ads/main/manualchoose',
          '/ads/client/manualstart' => 'ads/main/manualstart',
          '/ads/client/manualrating' => 'ads/main/manualrating',
          '/ads/client/manualmessage' => 'ads/main/manualmessage',
          '/ads/client/manualbase' => 'ads/main/manualbase',
          '/ads/client/manualmyrating' => 'ads/main/manualmyrating',
          /* ADS CLIENT */

          /* ADS SPEC */
          '/ads/specialist' => 'ads/spec/index',
          '/ads/specialist/profile' => 'ads/spec/profile',
          '/ads/specialist/balance' => 'ads/spec/balance',
          '/ads/specialist/myorders' => 'ads/spec/myorders',
          '/ads/specialist/choose' => 'ads/spec/choose',
          '/ads/specialist/createorder' => 'ads/spec/createorder',
          '/ads/specialist/ratingspecialist' => 'ads/spec/ratingspecialist',
          '/ads/specialist/base' => 'ads/spec/base',
          '/ads/specialist/myrating' => 'ads/spec/myrating',
          '/ads/specialist/specialist' => 'ads/spec/specialist',
          '/ads/specialist/specialistorder' => 'ads/spec/specialistorder',
          '/ads/specialist/orderpage' => 'ads/spec/orderpage',
          '/ads/specialist/baseset' => 'ads/spec/baseset',
          '/ads/specialist/article' => 'ads/spec/article',
          '/ads/specialist/messages' => 'ads/spec/messages',
          '/ads/specialist/manual' => 'ads/spec/manual',
          '/ads/specialist/manualmain' => 'ads/spec/manualmain',
          '/ads/specialist/manualprofile' => 'ads/spec/manualprofile',
          '/ads/specialist/manualbalance' => 'ads/spec/manualbalance',
          '/ads/specialist/manualorder' => 'ads/spec/manualorder',
          '/ads/specialist/manualchoose' => 'ads/spec/manualchoose',
          '/ads/specialist/manualstart' => 'ads/spec/manualstart',
          '/ads/specialist/manualrating' => 'ads/spec/manualrating',
          '/ads/specialist/manualmessage' => 'ads/spec/manualmessage',
          '/ads/specialist/manualbase' => 'ads/spec/manualbase',
          '/ads/specialist/manualmyrating' => 'ads/spec/manualmyrating',
          /* ADS SPEC */
        /* ADS */



                '<action:\w+>/' => '<controller>/<action>', //<controller:\w+>/
            ],
        ],
    ],
    'params' => $params,
];
