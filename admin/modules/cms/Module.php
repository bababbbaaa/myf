<?php

namespace admin\modules\cms;

/**
 * cms module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'admin\modules\cms\controllers';
    public $name = "CMS";

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();

        $this->modules = [
            'femida' => [
                // здесь имеет смысл использовать более лаконичное пространство имен
                'class' => 'admin\modules\cms\modules\femida\Module',
                'defaultRoute' => 'main'
            ],
            'lead' => [
                // здесь имеет смысл использовать более лаконичное пространство имен
                'class' => 'admin\modules\cms\modules\lead\Module',
                'defaultRoute' => 'main'
            ],
            'general' => [
                // здесь имеет смысл использовать более лаконичное пространство имен
                'class' => 'admin\modules\cms\modules\general\Module',
                'defaultRoute' => 'main'
            ],
            'knowledgebase' => [
                // здесь имеет смысл использовать более лаконичное пространство имен
                'class' => 'admin\modules\cms\modules\knowledgebase\Module',
                'defaultRoute' => 'main'
            ],
            'skill' => [
                'class' => 'admin\modules\cms\modules\skill\Module',
                'defaultRoute' => 'main'
            ],
        ];
        // custom initialization code goes here
    }
}
