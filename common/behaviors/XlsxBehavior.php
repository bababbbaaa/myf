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
class XlsxBehavior extends Behavior
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
        ];
    }

    public function recursiveArrayParse($tree) {
        $markup = '';
        foreach ($tree as $branch => $twig) {
            if (!is_numeric($branch))
                $markup .= ((is_array($twig)) ? "{$branch}: " . $this->recursiveArrayParse($twig) : "{$branch}: {$twig}") . PHP_EOL;
            else
                $markup .= ((is_array($twig)) ? $this->recursiveArrayParse($twig) : "{$branch}: {$twig}") . PHP_EOL;
        }
        return '' . $markup . '';
    }

    public function onAfterFind(Event $event): void
    {
        /** @var ActiveRecord $model */
        $model = $event->sender;
        $jsonField = $this->getJsonField($model);
        if (empty($model->getAttribute($jsonField)) && $jsonField === 'system_data') {
            $model->system_data = '[]';
            $model->update();
        }
        $prop = Json::decode($model->getAttribute($jsonField));
        $text = !empty($prop) ? $this->recursiveArrayParse($prop) : '';
        $model->{$this->property} = $text;
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