<?php

namespace admin\modules\dev_force\controllers;

use yii\web\Controller;

/**
 * Default controller for the `dev_force` module
 */
class MainController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }
}
