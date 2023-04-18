<?php

namespace common\models;

use common\models\helpers\PhoneRegionHelper;
use Yii;

/**
 * This is the model class for table "voice_leads".
 *
 * @property int $id
 * @property string $date
 * @property string|null $name
 * @property string $phone
 * @property string|null $region
 * @property int|null $sum
 * @property string|null $ipoteka_zalog
 * @property string|null $comments
 * @property int $status
 */
class VoiceLeads extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'voice_leads';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['date'], 'safe'],
            [['phone'], 'required'],
            [['sum', 'status'], 'integer'],
            [['comments'], 'string'],
            [['name', 'phone', 'region', 'ipoteka_zalog'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'date' => 'Дата',
            'name' => 'Имя',
            'phone' => 'Телефон',
            'region' => 'Регион',
            'sum' => 'Сумма',
            'ipoteka_zalog' => 'Ипотека/Залог',
            'comments' => 'Комментарии',
            'status' => 'Статус',
        ];
    }

    static function getLead($phone) {
        $lead = self::find()
            ->where(['phone' => $phone])
            ->orderBy('id desc')
            ->one();
        if (empty($lead)) {
            $lead = new self();
            $lead->phone = (string)$phone;
            $lead->name = null;
            $lead->region = self::parse__region($phone);
            $lead->sum = null;
            $lead->ipoteka_zalog = null;
            $lead->comments = '';
            $lead->status = 0;
            $lead->save(false);
        }
        return $lead;
    }

    private function descriptions() {
        return [
            'name' => 'Имя',
            'region' => 'Регион',
            'sum' => 'Сумма долга',
            'ipoteka_zalog' => 'Ипотека/Залог',
        ];
    }

    private function saveIncomeData($property, $val, $raw) {
        $this->{$property} = $val;
        $this->comments .= "{$this->descriptions()[$property]}: {$raw}<br>";
        $this->save();
    }

    static function isLead($response) {
        foreach (self::yesKeys() as $item) {
            if (mb_strpos($response, $item) !== false) {
                return true;
            }
        }
        return false;
    }

    static function yesKeys() {
        return [
            'да',
            'актуально',
            'по сути да',
            'ну так то да',
            'условия',
            'ну да',
            'наверно',
            'естественно',
            'давайте',
            'хорошо',
            'конечно',
            'может быть',
            'хочу',
            'подробнее',
        ];
    }

    static function noKeys() {
        return [
            'нет',
            'не хочу',
            'не надо',
            'не нужно',
            'я занят',
            'до свиданья',
            'не интересно',
            'не звоните',
            'не могу',
            'неактуально',
            'неа',
            'уже не надо',
            'мне не надо',
            'пошли в жопу',
            'не звоните больше',
            'уже занимаюсь',
            'уже занимаются',
            'это ошибка',
            'с чего вы взяли',
            'откуда у вас мой номер',
            'ничего подобного',
            'и не подумаю',
            'дураков тут нет',
            'всю жизнь мечтал',
            'вовсе нет',
            'и в помине не было',
            'и в помине нет',
            'забудьте мой номер',
            'хватит звонить',
            'не интересно',
            'кто вам дал мой номер',
            'мне ничего не надо',
            'я не подхожу вам',
            'мне это не подходит',
            'заебали',
            'идите лесом',
            'не интересовался',
        ];
    }

    private function checkSumBigger($val) {
        $keys = [
            "да", "примерно", "вроде", "где-то так", "ну да", "допустим", "больше", "конечно", "наверное",
            "скорее всего"
        ];
        foreach ($keys as $item) {
            if (mb_strpos($val, $item) !== false)
                return true;
        }
        return false;
    }

    private function checkZalog($val) {
        $keys = [
            "да", "вроде", "кажется да", "ну да", "допустим", "конечно", "наверное",
            "скорее всего", 'имущество', 'квартира', 'гараж', 'дом', 'земельный участок', 'земля',
        ];
        foreach ($keys as $item) {
            if (mb_strpos($val, $item) !== false)
                return 'да';
        }
        return 'нет';
    }

    private function parseData($property, $raw) {
        switch ($property) {
            case "name":
                return mb_convert_case($raw, MB_CASE_TITLE);
            case "ipoteka_zalog":
                return $this->checkZalog($raw);
            case "sum":
                return $this->checkSumBigger($raw) ? 300000 : 100000;
        }
    }

    static function parse__region($phone)
    {
        $dbReg = PhoneRegionHelper::getValidRegion($phone);
        if (!empty($dbReg)) {
            return $dbReg->name_with_type;
        } else
            return null;
    }

    static function fork($property, $response, $phone) {
        switch ($property) {
            case "init":
                if (self::isLead($response))
                    $lead = self::getLead($phone);
                break;
            case "abort":
            case "region":
                break;
            default:
                $lead = self::getLead($phone);
                $lead->saveIncomeData($property, $lead->parseData($property, $response), $response);
                break;
        }
    }


}
