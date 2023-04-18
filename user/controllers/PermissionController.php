<?php


namespace user\controllers;


use common\models\UserModel;
use http\Url;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;

class PermissionController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'except' => ['user-login'],
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                        'controllers' => ['lead-force/*'],
                        'matchCallback' => function ($rule, $action) {
                            $user = \Yii::$app->getUser();
                            $cnt = \Yii::$app->controller->id;
                            $model = UserModel::findOne($user->id);
                            if ($model->is_client === 1) {
                                return $cnt === 'client' ? true : \Yii::$app->response->redirect(\yii\helpers\Url::to(['client/index']));
                            } else {
                                if($model->is_client === -1)
                                    return $cnt === 'provider' ? true : \Yii::$app->response->redirect(\yii\helpers\Url::to(['provider/index']));
                                else
                                    return false;
                            }
                        }
                    ],
                    [
                        'allow' => true,
                        'roles' => ['@'],
                        'controllers' => ['femida/*'],
                    ],
                    [
                        'allow' => true,
                        'roles' => ['@'],
                        'controllers' => ['skill/*'],
                    ],

                ],
            ],
        ];
    }
}