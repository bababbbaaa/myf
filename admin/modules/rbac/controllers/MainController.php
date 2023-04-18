<?php

namespace admin\modules\rbac\controllers;

use admin\controllers\AccessController;
use common\models\AuthItem;
use common\models\User;
use yii\helpers\Url;
use yii\web\Controller;

/**
 * Default controller for the `rbac` module
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

    public function actionChangePassword($id, $pwd) {
        if (!empty($id) && !empty($pwd)) {
            $user = User::findOne($id);
            if (!empty($user)) {
                $user->setPassword($pwd);
                $user->generateAuthKey();
                $user->update();
                return \Yii::$app->response->redirect(Url::to(['index']));
            }
        } else
            return $this->goHome();
    }

}
