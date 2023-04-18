<?php

namespace admin\modules\cms\modules\lead;

/**
 * cms module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'admin\modules\cms\modules\lead\controllers';
    public $name = "LEAD";

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
