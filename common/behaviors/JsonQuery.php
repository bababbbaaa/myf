<?php


namespace common\behaviors;


use yii\db\Expression;

class JsonQuery
{

   public $propertyName;
   public $json;

    /**
     * JsonFinder constructor.
     * @param $propertyName
     */
    public function __construct($propertyName)
    {
        $this->propertyName = $propertyName;
        return $this;
    }

    /**
     * @param $array array for json conversion & find in $key param
     * @param null $key string key from DB
     * @param bool $not
     * @return Expression
     */
    public function JsonContains($array, $key = null, $not = false) {
        $this->json = json_encode($array, JSON_UNESCAPED_UNICODE);
        $append = empty($key) ? '' : ", '$.{$key}'";
        $prepend = $not ? 'NOT ' : '';
        return new Expression($prepend . 'JSON_CONTAINS('.$this->propertyName.', \''.$this->json.'\''.$append.')');
    }


    /**
     * @param $key string key from DB
     * @param $logic string logic MySQL expression, ex. 'IS NOT NULL' or '> 5'
     * @return Expression
     */
    public function JsonExtract($key, $logic) {
        return new Expression('JSON_EXTRACT('.$this->propertyName.', \'$.'.$key.'\') ' . $logic);
    }

    /**
     * @param $table string - table name
     * @param $key string - json property name
     * @param $value string - json new property value
     * @param string $where - where clause, ex. "id = 2"
     * @return int
     * @throws \yii\db\Exception
     */
    public function JsonUpdate($table, $key, $value, $where = '') {
        $where = $where === '' ? '' : "WHERE {$where}";
        return (new \yii\db\Query)
            ->createCommand()
            ->setSql(new Expression('UPDATE `'.$table.'` SET '.$this->propertyName.' = JSON_SET(system_data ,\'$.'.$key.'\' ,\''.$value.'\') ' . $where))
            ->execute();
    }

    /**
     * @param $table string - table name
     * @param $key string - json property name to delete
     * @param string $where - where clause, ex. "id = 2"
     * @return int
     * @throws \yii\db\Exception
     */
    public function JsonRemove($table, $key, $where = '') {
        $where = $where === '' ? '' : "WHERE {$where}";
        return (new \yii\db\Query)
            ->createCommand()
            ->setSql(new Expression('UPDATE `'.$table.'` SET '.$this->propertyName.' = JSON_REMOVE(system_data ,\'$.'.$key.'\') ' . $where))
            ->execute();
    }


}