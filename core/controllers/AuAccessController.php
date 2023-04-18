<?php


namespace core\controllers;


use common\models\UserModel;
use yii\filters\AccessControl;
use yii\web\Controller;

class AuAccessController extends Controller
{

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['au', 'admin'],
                        'controllers' => ['au/*'],
                    ],
                ],
            ],
        ];
    }

}