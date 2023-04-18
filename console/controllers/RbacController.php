<?php

/**
 * RBAC Main console controller for creating rules, roles, assignments etc.
 */

namespace console\controllers;

use common\models\StatusResponder;
use common\models\User;
use yii\console\Controller;
use Yii;

class RbacController extends Controller
{
    public function actionCreateItem($name, $description, $rule = null) {
        $auth = Yii::$app->authManager;
        $item = $auth->createRole($name);
        $item->description = $description;
        $item->ruleName = $rule;
        return $auth->add($item);
    }

    public function actionCreatePermission($name, $description, $rule = null) {
        $auth = Yii::$app->authManager;
        $permission = $auth->createPermission($name);
        $permission->description = $description;
        $permission->ruleName = $rule;
        return $auth->add($permission);
    }

    public function actionCreateAssignment($role, $user_id) {
        $auth = Yii::$app->authManager;
        return !empty(User::findOne($user_id)) ? StatusResponder::randomJson($auth->assign($auth->getRole($role), $user_id)) : StatusResponder::randomJson(['status' => 'error', 'message' => 'User not found']);
    }

    public function actionAddChild($role, $extend) {
        $auth = Yii::$app->authManager;
        $role = $auth->getRole($role);
        $extend = $auth->getRole($extend) ?? $auth->getPermission($extend);
        return $auth->addChild($role, $extend); // add to $role all permissions of $extend
    }

    public function actionAddRule($class) {
        $auth = Yii::$app->authManager;
        $path = "admin\\modules\\rbac\\rules\\{$class}";
        $rule = new $path;
        $auth->add($rule);
    }
}