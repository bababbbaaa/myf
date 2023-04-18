<?php

namespace admin\modules\support\controllers;

use admin\controllers\AccessController;

/**
 * Default controller for the `support` module
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
}
