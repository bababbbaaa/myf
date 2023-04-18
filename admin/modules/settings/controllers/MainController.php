<?php

namespace admin\modules\settings\controllers;

use admin\controllers\AccessController;
use admin\models\CookieValidator;
use yii\web\Controller;
use yii\web\Response;

/**
 * Default controller for the `settings` module
 */
class MainController extends AccessController
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionValidationOpen() {
        $cookies = CookieValidator::findOne(2);
        return $this->render('validation-open', ['validation' => $cookies]);
    }

    public function actionValidationChange() {
        \Yii::$app->response->format = Response::FORMAT_JSON;
        if (empty($_POST['change']))
            return ['status' => 'error', 'message' => 'Ошибка запроса'];
        $cookie = CookieValidator::findOne(2);
        $cookie->hash = ((int)$cookie->hash) === 1 ? '0' : '1';
        $cookie->update();
        return ['status' => 'success'];
    }
}
