<?php

namespace admin\modules\cms\controllers;

use admin\controllers\AccessController;
use yii\web\Controller;

/**
 * Default controller for the `cms` module
 */
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
