<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "users_bonuses".
 *
 * @property int $id ID
 * @property int $user_id Пользователь
 * @property string $date Дата
 * @property int $cashback Кэшбек
 * @property int $card Карта
 * @property int $bonus_points Бонусные очки
 * @property string|null $additional_materials Доп.материалы
 * @property int $additional_waste Доп.отбраковка, %
 * @property int $additional_sale Доп.скидка, %
 * @property string|null $bonus_prefs Настройки
 */
class UsersBonuses extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'users_bonuses';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id'], 'required'],
            [['user_id', 'cashback', 'card', 'bonus_points', 'additional_waste', 'additional_sale'], 'integer'],
            [['date'], 'safe'],
            [['additional_materials', 'bonus_prefs'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'Пользователь',
            'date' => 'Дата',
            'cashback' => 'Кэшбек',
            'card' => 'Карта',
            'bonus_points' => 'Бонусные очки',
            'additional_materials' => 'Доп.материалы',
            'additional_waste' => 'Доп.отбраковка, %',
            'additional_sale' => 'Доп.скидка, %',
            'bonus_prefs' => 'Настройки',
        ];
    }

    public function checkInfo()
    {
        $material = json_decode($this->additional_materials, true);
        if ($this->cashback === 3 && empty($material)) {
            $info = 'Закажите 70 лидов и получите кэшбек 3% и скрипт продаж для эффективной обработки';
        } elseif ($this->cashback === 3 && in_array('script', $material)) {
            $info = 'Закажите 90 лидов и получите кэшбек 4% и скрипт продаж для эффективной обработки';
        } elseif ($this->cashback === 4 && in_array('script', $material) && !in_array('telegram', $material)) {
            $info = 'Закажите 120 лидов и получите кэшбек 4%, скрипт продаж для эффективной обработки и автоинформирование в Telegram';
        } elseif ($this->cashback === 4 && in_array('telegram', $material)) {
            $info = 'Закажите 150 лидов и получите кэшбек 5%, скрипт продаж для эффективной обработки и автоинформирование в Telegram';
        } elseif ($this->cashback === 5 && in_array('telegram', $material) && !in_array('course', $material)) {
            $info = 'Закажите 170 лидов и получите кэшбек 5%, скрипт продаж для эффективной обработки, автоинформирование в Telegram и курс для менеджера продаж';
        } elseif ($this->cashback === 5 && in_array('course', $material)) {
            $info = 'Закажите 210 лидов и получите кэшбек 6%, скрипт продаж для эффективной обработки, автоинформирование в Telegram и курс для менеджера продаж';
        } elseif ($this->cashback === 6 && in_array('course', $material) && !in_array('personal_assistant', $material)) {
            $info = 'Закажите 250 лидов и получите кэшбек 6%, скрипт продаж для эффективной обработки, автоинформирование в Telegram, курс для менеджера продаж и персонального маркетолога для вашего проекта';
        } elseif ($this->cashback === 6 && in_array('personal_assistant', $material)) {
            $info = 'Закажите 290 лидов и получите кэшбек 7%, скрипт продаж для эффективной обработки, автоинформирование в Telegram, курс для менеджера продаж и персонального маркетолога для вашего проекта';
        } elseif ($this->cashback === 7 && in_array('personal_assistant', $material) && $this->card === 0) {
            $info = 'Получите Карту Клуба MYFORCE. Закажите 350 лидов и получите дополнительную отпраковку 5%, +2 500 баллов на баланс, кэшбек 7%, персонального маркетолога, материалы для эффективной обработки лидов, автоинформирование о новых лидах в Telegram';
        } elseif ($this->cashback === 7 && $this->card === 1) {
            $info = 'Получите Карту Клуба MYFORCE. Закажите 440 лидов и получите дополнительную отпраковку 5%, +3 500 баллов на баланс, кэшбек 8%, персонального маркетолога, материалы для эффективной обработки лидов, автоинформирование о новых лидах в Telegram';
        } elseif ($this->cashback === 8 && $this->card === 1 && $this->additional_waste !== 10) {
            $info = 'Получите Карту Клуба MYFORCE. Закажите 500 лидов и получите дополнительную отпраковку 10%, +5 000 баллов на баланс, кэшбек 8%, персонального маркетолога, материалы для эффективной обработки лидов, постоянную скидку 10% на все продукты MYFORCE, автоинформирование о новых лидах в Telegram';
        } elseif ($this->cashback === 8 && $this->card === 1 && $this->additional_waste === 10) {
            $info = 'У вас максимальный кэшбек и дополнительная отбраковка 10%';
        } else $info = 'Бонусы не найдены';
        return ['info' => $info, 'material' => $material];
    }

    public static function GetStages()
    {
        return [
            range(0, 49),
            range(50, 69),
            range(70, 89),
            range(90, 119),
            range(120, 149),
            range(150, 169),
            range(170, 209),
            range(210, 249),
            range(250, 289),
            range(290, 349),
            range(350, 439),
            range(440, 500)
        ];
    }

    public static function CheckStages($count)
    {
        $stages = static::GetStages();
        $params = static::getStageParams();
        foreach ($stages as $key => $item) {
            if (in_array($count, $item)) {
                return $params[$key];
            }
        }
        return null;
    }

    public static function getStageParams()
    {
        return [
            0 => ['cashback' => 0, 'additional_materials' => null, 'card' => 0, 'bonus_points' => 0, 'additional_waste' => 0, 'additional_sale' => 0, 'bonus_prefs' => null],
            1 => ['cashback' => 3, 'additional_materials' => null, 'card' => 0, 'bonus_points' => 0, 'additional_waste' => 0, 'additional_sale' => 0, 'bonus_prefs' => null],
            2 => ['cashback' => 4, 'additional_materials' => ['script'], 'card' => 0, 'bonus_points' => 0, 'additional_waste' => 0, 'additional_sale' => 0, 'bonus_prefs' => null],
            3 => ['cashback' => 4, 'additional_materials' => ['script', 'telegram'], 'card' => 0, 'bonus_points' => 0, 'additional_waste' => 0, 'additional_sale' => 0, 'bonus_prefs' => null],
            4 => ['cashback' => 5, 'additional_materials' => ['script', 'telegram'], 'card' => 0, 'bonus_points' => 0, 'additional_waste' => 0, 'additional_sale' => 0, 'bonus_prefs' => null],
            5 => ['cashback' => 5, 'additional_materials' => ['script', 'telegram', 'course'], 'card' => 0, 'bonus_points' => 0, 'additional_waste' => 0, 'additional_sale' => 0, 'bonus_prefs' => null],
            6 => ['cashback' => 6, 'additional_materials' => ['script', 'telegram', 'course'], 'card' => 0, 'bonus_points' => 0, 'additional_waste' => 0, 'additional_sale' => 0, 'bonus_prefs' => null],
            7 => ['cashback' => 6, 'additional_materials' => ['script', 'telegram', 'course', 'personal_assistant'], 'card' => 0, 'bonus_points' => 0, 'additional_waste' => 0, 'additional_sale' => 0, 'bonus_prefs' => null],
            8 => ['cashback' => 7, 'additional_materials' => ['script', 'telegram', 'course', 'personal_assistant'], 'card' => 1, 'bonus_points' => 2500, 'additional_waste' => 5, 'additional_sale' => 0, 'bonus_prefs' => null],
            9 => ['cashback' => 8, 'additional_materials' => ['script', 'telegram', 'course', 'personal_assistant'], 'card' => 1, 'bonus_points' => 3500, 'additional_waste' => 5, 'additional_sale' => 0, 'bonus_prefs' => null],
            10 => ['cashback' => 8, 'additional_materials' => ['script', 'telegram', 'course', 'personal_assistant'], 'card' => 1, 'bonus_points' => 5000, 'additional_waste' => 10, 'additional_sale' => 10, 'bonus_prefs' => null],
        ];
    }

    /**
     * @param Orders $orders
     */
    public static function createBonuses($orders)
    {
        if ($orders->leads_count >= 50) {
            $info = static::CheckStages($orders->leads_count);
            $client = Clients::find()->where(['id' => $orders->client])->asArray()->select('user_id')->one();
            if (!empty($client['user_id'])) {
                $bonuses = UsersBonuses::findOne(['user_id' => $client['user_id']]);
                if (empty($bonuses)) {
                    $bonuses = new UsersBonuses();
                }
                $bonuses->cashback = $info['cashback'];
                $bonuses->user_id = $client['user_id'];
                $bonuses->additional_materials = !empty($info['additional_materials']) ? json_encode($info['additional_materials'], JSON_UNESCAPED_UNICODE) : null;
                if ($bonuses->card == 1){
                    $bonuses->card = 1;
                } else {
                    $bonuses->card = $info['card'];
                }
                if (!empty($bonuses->bonus_points)){
                    $bonuses->bonus_points += $info['bonus_points'];
                } else
                    $bonuses->bonus_points = $info['bonus_points'];
                $bonuses->additional_waste = $info['additional_waste'];
                $bonuses->additional_sale = $info['additional_sale'];
                $bonuses->bonus_prefs = null;
                if (!empty($bonuses->id)){
                    $bonuses->validate();
                    $bonuses->update();
                } else{
                    $bonuses->validate();
                    $bonuses->save();
                }
            }
        }
    }

    public function createDefault($id)
    {
        $this->user_id = $id;
        $this->cashback = 0;
        $this->card = 0;
        $this->bonus_points = 0;
        $this->additional_sale = 0;
        $this->additional_waste = 0;
    }

}
