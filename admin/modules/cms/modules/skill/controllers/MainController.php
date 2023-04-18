<?php

namespace admin\modules\cms\modules\skill\controllers;

use admin\controllers\AccessController;
use yii\web\Controller;

/**
 * Default controller for the `skill` module
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
    public function actionReviews()
    {
        return $this->render('reviews');
    }
}
