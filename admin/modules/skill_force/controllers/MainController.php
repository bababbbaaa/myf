<?php

namespace admin\modules\skill_force\controllers;

use admin\controllers\AccessController;
use yii\web\Controller;

/**
 * Default controller for the `skill_force` module
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

    public function actionConstructor()
    {
        return $this->render('constructor');
    }
    public function actionVacancies()
    {
        return $this->render('vacancies');
    }
}
