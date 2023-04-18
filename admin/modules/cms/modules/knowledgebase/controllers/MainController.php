<?php

namespace admin\modules\cms\modules\knowledgebase\controllers;

use admin\controllers\AccessController;
use yii\web\Controller;

/**
 * Default controller for the `knowledge_base` module
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
