<?php

namespace common\behaviors;

use yii\base\Behavior;
use yii\base\Event;
use yii\db\ActiveRecord;
use yii\helpers\Json;

/**
 * Поведение для автоматической конвертации свойств объектов ActiveRecord в формат JSON
 * @property string $property Свойство содержащее объект или массив до конвертации в формат JSON
 * @property string $jsonField Поле таблицы для хранения данных в формате JSON
 */
class JsonBehavior extends Behavior
{
    public $property;
    public $jsonField;

    /**
     * Список событий на которые зарегистрировано выполнение указанных методов
     * @return array
     */
    public function events(): array
    {
        return [
            ActiveRecord::EVENT_AFTER_FIND => 'onAfterFind',
            ActiveRecord::EVENT_BEFORE_VALIDATE => 'onBeforeSave',
           #ActiveRecord::EVENT_BEFORE_UPDATE => 'onBeforeSave',
        ];
    }

    public function onAfterFind(Event $event): void
    {
        /** @var ActiveRecord $model */
        $model = $event->sender;
        $jsonField = $this->getJsonField($model);
        $model->{$this->property} = Json::decode($model->getAttribute($jsonField));
    }

    public function onBeforeSave(Event $event): void
    {
        /** @var ActiveRecord $model */
        $model = $event->sender;
        $jsonField = $this->getJsonField($model);
        $val = $model->getAttribute($jsonField);
        if ($val !== null){
            if (!is_array($val)){
                $buf = json_decode($model->{$this->property});
                if (!empty($buf)){
                    $model->setAttribute($jsonField, Json::encode($model->{$this->property}));
                } else{
                    $model->setAttribute($jsonField, $model->{$this->property});
                }
            } else {
                $model->setAttribute($jsonField, Json::encode($model->{$this->property}));
            }
        }
        else
            $model->setAttribute($jsonField, null);
    }

    protected function getJsonField(ActiveRecord $model): string
    {
        $jsonField = $this->jsonField ?? $this->property;

        if (!$model->hasAttribute($jsonField)){
            throw new \DomainException("Field $jsonField with type JSON does not exist in the table " . $model::tableName());
        }
        return $jsonField;
    }
}