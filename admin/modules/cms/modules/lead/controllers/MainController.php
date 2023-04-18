<?php

namespace admin\modules\cms\modules\lead\controllers;

use admin\controllers\AccessController;
use yii\web\Controller;


class MainController extends AccessController
{
    /**
     *
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }
}
