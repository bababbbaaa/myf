<?php

namespace admin\models;

use Yii;

/**
 * This is the model class for table "bases_utm".
 *
 * @property int $id
 * @property string $name
 * @property int $base_id
 * @property int $contact_id
 * @property int $is_1
 * @property int $is_cc
 * @property string $date
 * @property Bases[] $bases
 */
class BasesUtm extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'bases_utm';
    }

    public $total;
    public $is1Total;
    public $isCcTotal;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'base_id', 'contact_id'], 'required'],
            [['base_id', 'contact_id', 'is_1', 'is_cc'], 'integer'],
            [['date'], 'safe'],
            [['name'], 'string', 'max' => 255],
        ];
    }


    public static function generate_utm_main_part(
        int $length = 5,
        string $keyspace = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'
    ): string {
        if ($length < 1) {
            throw new \RangeException("Length must be a positive integer");
        }
        $pieces = [];
        $max = mb_strlen($keyspace, '8bit') - 1;
        for ($i = 0; $i < $length; ++$i) {
            $pieces []= $keyspace[random_int(0, $max)];
        }
        return implode('', $pieces);
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Название',
            'base_id' => 'База',
            'contact_id' => 'Контакт',
            'is_1' => 'Единичка?',
            'is_cc' => 'После КЦ',
            'date' => 'Дата',
        ];
    }

    public function getBases() {
        $bases = self::find()->groupBy('base_id')->where(['name' => $this->name])->asArray()->select(['base_id'])->all();
        $response = null;
        if (!empty($bases)) {
            $fArr = [];
            foreach ($bases as $item)
                $fArr[] = $item['base_id'];
            $response = Bases::find()->where(['in', 'id', $fArr])->all();
        }
        return $response;
    }

    public static function refresh__statistics($phone, $name, $summ = null, $region = null) {
        $utm = self::find()
            ->join('JOIN', 'bases_contacts', 'bases_utm.contact_id = bases_contacts.id')
            ->where(['bases_contacts.phone' => $phone, 'bases_utm.name' => $name])
            ->all();
        if (!empty($utm)) {
            foreach ($utm as $item) {
                $item->is_cc = 1;
                $item->update();
            }
            $conversion = new BasesConversion();
            $conversion->name = $name;
            $conversion->type = !empty($summ) && $summ >= 250000 ? "is_250" : "is_cc";
            $conversion->save();
        } elseif (mb_stripos($name, 'backdoor') !== false) {
            $bdc = new BasesBackdoor();
            $bdc->region = empty($region) ? 'Любой' : $region;
            $bdc->type = !empty($summ) && $summ >= 250000 ? "is_250" : "is_cc";
            $bdc->save();
        }
        return true;
    }

}
