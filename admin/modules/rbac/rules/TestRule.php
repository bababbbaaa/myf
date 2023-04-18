<?php

namespace admin\modules\rbac\rules;

use yii\rbac\Rule;


class TestRule extends Rule
{

    public $name = "test";

    public function execute($user, $item, $params)
    {
        return isset($params['user']) ? $params['user'] === $user : false;
    }

}