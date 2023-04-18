<?php

namespace admin\modules\cms\modules\general;

/**
 * cms module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'admin\modules\cms\modules\general\controllers';
    public $name = "GENERAL";

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();
        /*$this->modules = [
            'franchise' => [
                // здесь имеет смысл использовать более лаконичное пространство имен
                'class' => 'admin\modules\cms\modules\lead\modules\franchise\Module',
                'defaultRoute' => 'main'
            ],
        ];*/
        // custom initialization code goes here
    }
}
