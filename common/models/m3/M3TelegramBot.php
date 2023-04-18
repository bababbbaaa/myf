<?php

namespace common\models\m3;

use admin\models\ActionLogger;
use common\models\BavariaBotMessages;
use common\models\BavariaBotPlaces;
use common\models\BavariaBotPlacesAlias;
use common\models\BavariaContacts;
use yii\db\Expression;
use yii\helpers\ArrayHelper;
use function Symfony\Component\String\b;

class M3TelegramBot
{

    const TOKEN = "5604816911:AAEYXlJuTNhCZqvSjrmwsePsnfmbEKMIgzc";

    public $storage;
    public $data;
    public $contact;
    public static $stages = [
        null => 'start',
        'start' => 'getContact',

        'main' => [
            'Забронировать столик' => 'accept_0',
            'Отменить бронь' => 'cancel_0',
            'Связаться с администратором' => 'manager_0',
            'Как добраться' => 'route',
        ],
        'getContact' => [
            'Забронировать столик' => 'accept_0',
            'Отменить бронь' => 'cancel_0',
            'Связаться с администратором' => 'manager_0',
            'Как добраться' => 'route',
        ],


        'accept_0' => 'accept_1',
        'accept_1' => 'accept_2',
        'accept_2' => 'accept_3',
        'accept_3' => [
            'Выбрать самому' => 'accept_0',
            'Показать варианты' => 'accept_4',
        ],
        'accept_4' => 'accept_5',
        'accept_5' => 'main',

        'cancel_0' => [
            'Да' => 'cancel_1',
            'Нет' => 'main'
        ],

        'manager_0' => [
            'Да' => 'manager_1',
            'Нет' => 'main'
        ],

        'route' => 'main'

    ];

    public function __construct($data, $contact = null)
    {
        $this->data = $data;
        if (!empty($contact))
            $this->contact = $contact;
        $this->storage = new BavariaBotMessages();
    }

    public function fillProperties()
    {
        $this->storage->tg_user_id = (string)$this->data['from']['id'];
        $this->storage->username = $this->data['from']['first_name'];
        $this->storage->created_at = time();
        $this->storage->text = $this->data['text'];
        $this->storage->status = 'wait';
        $this->defineStage();
        $this->storage->validate();
        $this->storage->save();
        return $this;
    }

    private function defineStage()
    {
        if ($this->storage->text === '/start')
            $this->storage->stage = 'start';
        else {
            $getOldMessages = BavariaBotMessages::find()
                ->where(['tg_user_id' => $this->storage->tg_user_id])
                ->orderBy(['id' => SORT_DESC])
                ->select('stage')
                ->asArray()
                ->one();
            if (!empty($getOldMessages)) {
                $stage = static::$stages[$getOldMessages['stage']];
                if (!empty($stage)) {
                    if (!is_array($stage)) {
                        if ($stage === 'getContact') {
                            $contact = BavariaContacts::findOne(['tg_user' => $this->storage->tg_user_id]);
                            if (empty($contact))
                                $this->storage->stage = 'start';
                            else
                                $this->storage->stage = $stage;
                        } else
                            $this->storage->stage = $stage;
                    } else {
                        $t = trim(preg_replace('/[^а-яА-ЯЁё\s]/u', '', $this->storage->text));
                        if (!empty($stage[$t]))
                            $this->storage->stage = $stage[$t];
                        else
                            $this->storage->stage = $getOldMessages['stage'];
                    }
                } else
                    $this->storage->stage = 'start';
            } else
                $this->storage->stage = 'start';
        }
    }

    private static function setResponse(BavariaBotMessages $object, string $message, $markup)
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, "https://api.telegram.org/bot" . self::TOKEN . "/sendMessage");
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 3);
        curl_setopt($curl, CURLOPT_TIMEOUT, 10);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HEADER, 0);
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query([
            'chat_id' => $object->tg_user_id,
            'text' => $message,
            'parse_mode' => 'HTML',
            'reply_markup' => $markup
        ]));
        $result2 = curl_exec($curl);
        curl_close($curl);
        return $result2;
    }

    private static function sendLocation(BavariaBotMessages $object, $markup)
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, "https://api.telegram.org/bot" . self::TOKEN . "/sendLocation");
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 3);
        curl_setopt($curl, CURLOPT_TIMEOUT, 10);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HEADER, 0);
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query([
            'chat_id' => $object->tg_user_id,
            'latitude' => 47.235173,
            'longitude' => 39.714397,
            'reply_markup' => $markup
        ]));
        $result2 = curl_exec($curl);
        curl_close($curl);
        return $result2;
    }

    static function setStatus($response)
    {
        $data = json_decode($response, 1);
        if ($data['ok'])
            return 'success';
        else
            return "fail";
    }

    public static function respond(BavariaBotMessages $object)
    {
        switch ($object->stage) {
            case 'start':
                $message = "Приветствуем вас в нашем кафе " . hex2bin("F09F988A") . "\nНам необходим ваш телефон для бронирования. Нажмите, пожалуйста, на кнопку \"Отправить контакт\", чтобы наш сервис смог с вами взаимодействовать " . hex2bin("F09F998C");
                $btn[] = ["text" => "Отправить контакт " . hex2bin("E29C8C"), 'request_contact' => true];
                $markup = json_encode(["keyboard" => [$btn], "resize_keyboard" => true]);
                break;

            case 'getContact':
            case 'main':
                $message = "Выберите пожалуйста - что бы вы хотели сделать:";
                $btn[0][0] = ["text" => "Забронировать столик " . hex2bin("E28FB0")];
                $btn[1][0] = ["text" => "Отменить бронь " . hex2bin("E29B94")];
                $btn[2][0] = ["text" => "Связаться с администратором " . hex2bin("F09F9281")];
                $btn[3][0] = ["text" => "Как добраться " . hex2bin("F09F9AA9")];
                $markup = json_encode(["keyboard" => $btn, "resize_keyboard" => true]);
                break;

            case 'accept_0':
                $botPlaces = BavariaBotPlacesAlias::find()
                    ->where(['tg_user_id' => $object->tg_user_id])
                    ->andWhere(['OR', ['status' => 'processing'], ['status' => 'confirmed']])
                    ->count();
                if ($botPlaces > 0) {
                    $object->stage = 'main';
                    $message = "У вас уже есть назначенная бронь. Вы можете отменить ее или связаться с администратором";
                    $btn[0][0] = ["text" => "Забронировать столик " . hex2bin("E28FB0")];
                    $btn[1][0] = ["text" => "Отменить бронь " . hex2bin("E29B94")];
                    $btn[2][0] = ["text" => "Связаться с администратором " . hex2bin("F09F9281")];
                    $btn[3][0] = ["text" => "Как добраться " . hex2bin("F09F9AA9")];
                    $markup = json_encode(["keyboard" => $btn, "resize_keyboard" => true]);
                } else {
                    $botPlaces = BavariaBotPlacesAlias::find()->where(['status' => 'wait', 'tg_user_id' => $object->tg_user_id])->all();
                    if (!empty($botPlaces)) {
                        foreach ($botPlaces as $item)
                            $item->delete();
                    }
                    $currtime = (int)date("H");
                    for ($i = $currtime >= 21 ? 1 : 0; $i <= 7; $i++)
                        $dates[] = date("d.m.Y", strtotime("+$i days"));
                    $row = 0;
                    foreach ($dates as $key => $item) {
                        if ($key % 2 === 0 && $key !== 0)
                            $row++;
                        $btn[$row][] = ["text" => $item];
                    }
                    $message = "Выберите желаемую дату бронирования " . hex2bin("F09F988A");
                    $markup = json_encode(["keyboard" => $btn, "resize_keyboard" => true]);
                }
                break;

            case "accept_1":
                $alias = BavariaBotPlacesAlias::find()->where(['tg_user_id' => $object->tg_user_id, 'status' => 'wait'])->one();
                $minTime = strtotime(date("d.m.Y"));
                $date = strtotime($object->text);
                if (empty($alias)) {
                    if ($date < $minTime || $date >= time() + 24 * 3600 * 7) {
                        $object->stage = "accept_0";
                        $message = "Пожалуйста, выберите дату из перечня";
                        for ($i = 0; $i <= 7; $i++)
                            $dates[] = date("d.m.Y", strtotime("+$i days"));
                        foreach ($dates as $key => $item) {
                            if ($key < 4)
                                $btn[] = ["text" => $item];
                            else
                                $btn1[] = ["text" => $item];
                        }
                        $markup = json_encode(["keyboard" => [$btn, $btn1], "resize_keyboard" => true]);
                    } else {
                        $alias = new BavariaBotPlacesAlias();
                        $alias->place_id = 0;
                        $alias->tg_user_id = $object->tg_user_id;
                        $alias->time_start = $date;
                        $alias->time_end_approx = 0;
                        $alias->status = 'wait';
                        $alias->save();
                        $currtime = (int)date("H");
                        $message = "Отлично " . hex2bin("F09F988A") . " Теперь укажите желаемое время";
                        if ($minTime === $date) {
                            $startHourApprox = $currtime >= 11 ? date("H", strtotime("+90 minutes")) : "12";
                        } else
                            $startHourApprox = "12";
                        $endHour = "22";
                        for ($i = $startHourApprox; $i <= $endHour; $i++) {
                            $times[] = "$i:00";
                            if ($i !== 22)
                                $times[] = "$i:30";
                        }
                        $startRow = 0;
                        foreach ($times as $key => $item) {
                            if ($key % 5 === 0 && $key !== 0)
                                $startRow++;
                            $btn[$startRow][] = ["text" => $item];
                        }
                        $alias->params = json_encode(['allowed_times' => $times]);
                        $alias->update();
                        $markup = json_encode(["keyboard" => $btn, "resize_keyboard" => true]);
                    }
                } else {
                    $currtime = (int)date("H");
                    $message = "Отлично " . hex2bin("F09F988A") . " Теперь укажите желаемое время";
                    if ($minTime === $date) {
                        $startHourApprox = $currtime >= 11 ? date("H", strtotime("+90 minutes")) : "12";
                    } else
                        $startHourApprox = "12";
                    $endHour = "22";
                    for ($i = $startHourApprox; $i <= $endHour; $i++) {
                        $times[] = "$i:00";
                        if ($i !== 22)
                            $times[] = "$i:30";
                    }
                    $startRow = 0;
                    foreach ($times as $key => $item) {
                        if ($key % 5 === 0 && $key !== 0)
                            $startRow++;
                        $btn[$startRow][] = ["text" => $item];
                    }
                    $alias->params = json_encode(['allowed_times' => $times]);
                    $alias->update();
                    $markup = json_encode(["keyboard" => $btn, "resize_keyboard" => true]);
                }


                break;

            case "accept_2":
                $alias = BavariaBotPlacesAlias::find()->where(['tg_user_id' => $object->tg_user_id, 'status' => 'wait'])->one();
                if (empty($alias)) {
                    $message = "Ой, произошла какая-то ошибка. Пожалуйста выберите желаемое действие:";
                    $object->stage = 'main';
                    $btn[0][0] = ["text" => "Забронировать столик " . hex2bin("E28FB0")];
                    $btn[1][0] = ["text" => "Отменить бронь " . hex2bin("E29B94")];
                    $btn[2][0] = ["text" => "Связаться с администратором " . hex2bin("F09F9281")];
                    $btn[3][0] = ["text" => "Как добраться " . hex2bin("F09F9AA9")];
                    $markup = json_encode(["keyboard" => $btn, "resize_keyboard" => true]);
                } else {
                    $allowedTimes = json_decode($alias->params, 1)['allowed_times'];
                    if (!in_array($object->text, $allowedTimes)) {
                        $message = "Пожалуйста, используйте только то время, которое предложено в вариантах выбора:";
                        $startRow = 0;
                        $k = 0;
                        foreach ($allowedTimes as $item) {
                            if ($startRow === 5) {
                                $k++;
                                $startRow = 0;
                            }
                            $startRow++;
                            $btn[$k][] = ["text" => $item];
                        }
                        $object->stage = 'accept_1';
                        $markup = json_encode(["keyboard" => $btn, "resize_keyboard" => true]);
                    } else {
                        $date = date("d.m.Y", $alias->time_start);
                        $updatedTimestamp = "{$date} {$object->text}";
                        $alias->time_start = strtotime($updatedTimestamp);
                        $alias->time_end_approx = $alias->time_start + 3600 * 4;
                        $alias->update();
                        $message = "Выбранное время {$updatedTimestamp} " . hex2bin("F09F9385") . "\nТеперь укажите, пожалуйста, желаемый столик: ";
                        $options = BavariaBotPlaces::find()->all();
                        if (!empty($options)) {
                            $startRow = 0;
                            foreach ($options as $key => $item) {
                                if ($key % 2 === 0 && $key !== 0)
                                    $startRow++;
                                $btn[$startRow][] = ["text" => $item['name']];
                            }
                            $markup = json_encode(["keyboard" => $btn, "resize_keyboard" => true]);
                        } else {
                            $message = "Ой, произошла какая-то ошибка. Пожалуйста выберите желаемое действие:";
                            $object->stage = 'main';
                            $btn[0][0] = ["text" => "Забронировать столик " . hex2bin("E28FB0")];
                            $btn[1][0] = ["text" => "Отменить бронь " . hex2bin("E29B94")];
                            $btn[2][0] = ["text" => "Связаться с администратором " . hex2bin("F09F9281")];
                            $btn[3][0] = ["text" => "Как добраться " . hex2bin("F09F9AA9")];
                            $markup = json_encode(["keyboard" => $btn, "resize_keyboard" => true]);
                        }
                    }
                }
                break;

            case 'accept_3':
                $placement = BavariaBotPlaces::findOne(['name' => $object->text]);
                if (empty($placement)) {
                    $object->stage = "accept_2";
                    $message = "Необходимо выбрать вариант из предложенных:";
                    $options = BavariaBotPlaces::find()->all();
                    if (!empty($options)) {
                        $startRow = 0;
                        foreach ($options as $key => $item) {
                            if ($key % 2 === 0 && $key !== 0)
                                $startRow++;
                            $btn[$startRow][] = ["text" => $item['name']];
                        }
                        $markup = json_encode(["keyboard" => $btn, "resize_keyboard" => true]);
                    } else {
                        $message = "Ой, произошла какая-то ошибка. Пожалуйста выберите желаемое действие:";
                        $object->stage = 'main';
                        $btn[0][0] = ["text" => "Забронировать столик " . hex2bin("E28FB0")];
                        $btn[1][0] = ["text" => "Отменить бронь " . hex2bin("E29B94")];
                        $btn[2][0] = ["text" => "Связаться с администратором " . hex2bin("F09F9281")];
                        $btn[3][0] = ["text" => "Как добраться " . hex2bin("F09F9AA9")];
                        $markup = json_encode(["keyboard" => $btn, "resize_keyboard" => true]);
                    }
                } else {
                    $alias = BavariaBotPlacesAlias::find()->where(['tg_user_id' => $object->tg_user_id, 'status' => 'wait'])->one();
                    $counts = $placement->available_count;
                    $approxedStart = $alias->time_start + 3600 * 2;
                    $bannedPlaces = BavariaBotPlacesAlias::find()
                        ->where(['!=', 'id', $alias->id])
                        ->andWhere(['place_id' => $placement->id])
                        ->andWhere(['OR', ['status' => 'confirmed'], ['status' => 'processing']])
                        ->andWhere([
                            'OR',
                            new Expression("{$alias->time_start} BETWEEN `time_start` AND `time_end_approx`"),
                            new Expression("{$approxedStart} BETWEEN `time_start` AND `time_end_approx`"),
                            new Expression("{$alias->time_end_approx} BETWEEN `time_start` AND `time_end_approx`"),
                        ])
                        ->count();
                    if ($bannedPlaces >= $counts) {
                        $message = "Похоже, что на указанное время нет нужного свободного столика " . hex2bin("F09F9893") . "\nВы можете указать другое время самостоятельно, либо же посмотреть доступные варианты у нашего бота " . hex2bin("E29C85");
                        $btn[] = ["text" => "Выбрать самому"];
                        $btn[] = ["text" => "Показать варианты"];
                        $markup = json_encode(["keyboard" => [$btn], "resize_keyboard" => true]);
                    } else {
                        $alias->place_id = $placement->id;
                        $alias->status = 'processing';
                        $alias->update();
                        $message = "Отлично! Бронь создана. В течение 5 минут наш менеджер перезвонит на ваш номер, чтобы подтвердить бронь " . hex2bin("F09F988A");
                        $object->stage = 'main';
                        $btn[0][0] = ["text" => "Забронировать столик " . hex2bin("E28FB0")];
                        $btn[1][0] = ["text" => "Отменить бронь " . hex2bin("E29B94")];
                        $btn[2][0] = ["text" => "Связаться с администратором " . hex2bin("F09F9281")];
                        $btn[3][0] = ["text" => "Как добраться " . hex2bin("F09F9AA9")];
                        $markup = json_encode(["keyboard" => $btn, "resize_keyboard" => true]);
                    }
                }
                break;

            case "accept_4":
                $alias = BavariaBotPlacesAlias::find()->where(['tg_user_id' => $object->tg_user_id, 'status' => 'wait'])->one();
                if (!empty($alias)) {
                    $availablePlaces = BavariaBotPlaces::find()->asArray()->all();
                    $availablePlaces = ArrayHelper::map($availablePlaces, 'id', 'name');
                    $upperTime = date("d.m.Y 23:59:59", $alias->time_start);
                    $upperSetTime = date("d.m.Y 22:00:00", $alias->time_start);
                    $upperSetTime = strtotime($upperSetTime);
                    $upperTime = strtotime($upperTime);
                    $allTimes = BavariaBotPlacesAlias::find()
                        ->where(['!=', 'id', $alias->id])
                        ->andWhere(['OR', ['>=', 'time_start', $alias->time_start], ['<=', 'time_end_approx', $upperTime]])
                        ->asArray()
                        ->orderBy('time_end_approx desc')
                        ->groupBy('place_id')
                        ->all();
                    $promisedTimes = [];
                    $watchedId = [];
                    foreach ($allTimes as $item) {
                        $watchedId[] = $item['place_id'];
                        if ($item['time_end_approx'] >= $upperSetTime)
                            continue;
                        else {
                            $date = date("d.m.Y H:i", $item['time_end_approx']);
                            $promisedTimes[] = "{$availablePlaces[$item['place_id']]}, {$date}";
                        }
                    }
                    $getNewPromises = BavariaBotPlaces::find()->where(['not in', 'id', $watchedId])->asArray()->all();
                    $newPromises = [];
                    if (!empty($getNewPromises))
                        $newPromises = ArrayHelper::map($getNewPromises, 'id', 'name');
                    foreach ($newPromises as $key => $item) {
                        $date = date("d.m.Y H:i", $alias->time_start);
                        $promisedTimes[] = "{$item}, {$date}";
                    }
                    if (empty($promisedTimes)) {
                        $message = "Очень жаль, наш бот не смог найти доступное место " . hex2bin("F09F98A2") . "\nВыберите другое время или свяжитесь с администратором:";
                        $object->stage = 'main';
                        $btn[0][0] = ["text" => "Забронировать столик " . hex2bin("E28FB0")];
                        $btn[1][0] = ["text" => "Отменить бронь " . hex2bin("E29B94")];
                        $btn[2][0] = ["text" => "Связаться с администратором " . hex2bin("F09F9281")];
                        $btn[3][0] = ["text" => "Как добраться " . hex2bin("F09F9AA9")];
                        $markup = json_encode(["keyboard" => $btn, "resize_keyboard" => true]);
                    } else {
                        $message = "Оценили доступные варианты " . hex2bin("E29CA8") . "\nВыберите один из доступных вариантов:";
                        $startRow = 0;
                        foreach ($promisedTimes as $key => $item) {
                            if ($key % 2 === 0 && $key !== 0)
                                $startRow++;
                            $btn[$startRow][] = ["text" => $item];
                        }
                        $markup = json_encode(["keyboard" => $btn, "resize_keyboard" => true]);
                        $alias->params = json_encode($promisedTimes, JSON_UNESCAPED_UNICODE);
                        $alias->update();
                    }
                } else {
                    $message = "Ой, произошла какая-то ошибка. Пожалуйста выберите желаемое действие:";
                    $object->stage = 'main';
                    $btn[0][0] = ["text" => "Забронировать столик " . hex2bin("E28FB0")];
                    $btn[1][0] = ["text" => "Отменить бронь " . hex2bin("E29B94")];
                    $btn[2][0] = ["text" => "Связаться с администратором " . hex2bin("F09F9281")];
                    $btn[3][0] = ["text" => "Как добраться " . hex2bin("F09F9AA9")];
                    $markup = json_encode(["keyboard" => $btn, "resize_keyboard" => true]);
                }
                break;


            case "accept_5":
                $alias = BavariaBotPlacesAlias::find()->where(['tg_user_id' => $object->tg_user_id, 'status' => 'wait'])->one();
                if (empty($alias)) {
                    $message = "Ой, произошла какая-то ошибка. Пожалуйста выберите желаемое действие:";
                    $object->stage = 'main';
                    $btn[0][0] = ["text" => "Забронировать столик " . hex2bin("E28FB0")];
                    $btn[1][0] = ["text" => "Отменить бронь " . hex2bin("E29B94")];
                    $btn[2][0] = ["text" => "Связаться с администратором " . hex2bin("F09F9281")];
                    $btn[3][0] = ["text" => "Как добраться " . hex2bin("F09F9AA9")];
                    $markup = json_encode(["keyboard" => $btn, "resize_keyboard" => true]);
                } else {
                    $availablePlaces = json_decode($alias->params, 1);
                    if (in_array($object->text, $availablePlaces)) {
                        $arrString = explode(',', $object->text);
                        $dateStart = strtotime($arrString[2]);
                        $dateEnd = $dateStart + 3600 * 4;
                        unset($arrString[2]);
                        $name = implode(',', $arrString);
                        $place = BavariaBotPlaces::findOne(['name' => $name]);
                        if (!empty($place)) {
                            $alias->place_id = $place->id;
                            $alias->time_start = $dateStart;
                            $alias->time_end_approx = $dateEnd;
                            $alias->status = 'processing';
                            $alias->update();
                            $message = "Отлично! Столик забронирован, наш менеджер свяжется с вами в течение 5 минут.";
                            $object->stage = 'main';
                            $btn[0][0] = ["text" => "Забронировать столик " . hex2bin("E28FB0")];
                            $btn[1][0] = ["text" => "Отменить бронь " . hex2bin("E29B94")];
                            $btn[2][0] = ["text" => "Связаться с администратором " . hex2bin("F09F9281")];
                            $btn[3][0] = ["text" => "Как добраться " . hex2bin("F09F9AA9")];
                            $markup = json_encode(["keyboard" => $btn, "resize_keyboard" => true]);
                        } else {
                            $message = "Ой, произошла какая-то ошибка. Пожалуйста выберите желаемое действие:";
                            $object->stage = 'main';
                            $btn[0][0] = ["text" => "Забронировать столик " . hex2bin("E28FB0")];
                            $btn[1][0] = ["text" => "Отменить бронь " . hex2bin("E29B94")];
                            $btn[2][0] = ["text" => "Связаться с администратором " . hex2bin("F09F9281")];
                            $btn[3][0] = ["text" => "Как добраться " . hex2bin("F09F9AA9")];
                            $markup = json_encode(["keyboard" => $btn, "resize_keyboard" => true]);
                        }
                    } else {
                        $availablePlaces = BavariaBotPlaces::find()->asArray()->all();
                        $availablePlaces = ArrayHelper::map($availablePlaces, 'id', 'name');
                        $upperTime = date("d.m.Y 23:59:59", $alias->time_start);
                        $upperSetTime = date("d.m.Y 22:00:00", $alias->time_start);
                        $upperSetTime = strtotime($upperSetTime);
                        $upperTime = strtotime($upperTime);
                        $allTimes = BavariaBotPlacesAlias::find()
                            ->where(['!=', 'id', $alias->id])
                            ->andWhere(['OR', ['>=', 'time_start', $alias->time_start], ['<=', 'time_end_approx', $upperTime]])
                            ->asArray()
                            ->orderBy('time_end_approx desc')
                            ->groupBy('place_id')
                            ->all();
                        $promisedTimes = [];
                        $watchedId = [];
                        foreach ($allTimes as $item) {
                            $watchedId[] = $item['place_id'];
                            if ($item['time_end_approx'] >= $upperSetTime)
                                continue;
                            else {
                                $date = date("d.m.Y H:i", $item['time_end_approx']);
                                $promisedTimes[] = "{$availablePlaces[$item['place_id']]}, {$date}";
                            }
                        }
                        $getNewPromises = BavariaBotPlaces::find()->where(['not in', 'id', $watchedId])->asArray()->all();
                        $newPromises = [];
                        if (!empty($getNewPromises))
                            $newPromises = ArrayHelper::map($getNewPromises, 'id', 'name');
                        foreach ($newPromises as $key => $item) {
                            $date = date("d.m.Y H:i", $alias->time_start);
                            $promisedTimes[] = "{$item}, {$date}";
                        }
                        if (empty($promisedTimes)) {
                            $message = "Очень жаль, наш бот не смог найти доступное место, либо доступное место только что было занято " . hex2bin("F09F98A2") . "\nВыберите другое время или свяжитесь с администратором:";
                            $object->stage = 'main';
                            $btn[0][0] = ["text" => "Забронировать столик " . hex2bin("E28FB0")];
                            $btn[1][0] = ["text" => "Отменить бронь " . hex2bin("E29B94")];
                            $btn[2][0] = ["text" => "Связаться с администратором " . hex2bin("F09F9281")];
                            $btn[3][0] = ["text" => "Как добраться " . hex2bin("F09F9AA9")];
                            $markup = json_encode(["keyboard" => $btn, "resize_keyboard" => true]);
                        } else {
                            $message = "Пожалуйста выберите один из указанных вариантов: ";
                            $startRow = 0;
                            foreach ($promisedTimes as $key => $item) {
                                if ($key % 2 === 0 && $key !== 0)
                                    $startRow++;
                                $btn[$startRow][] = ["text" => $item];
                            }
                            $markup = json_encode(["keyboard" => $btn, "resize_keyboard" => true]);
                            $alias->params = json_encode($promisedTimes, JSON_UNESCAPED_UNICODE);
                            $alias->update();
                        }
                    }
                }
                break;

            case "cancel_0":
                $alias = BavariaBotPlacesAlias::find()->where(['AND', ['tg_user_id' => $object->tg_user_id], ['OR', ['status' => 'processing'], ['status' => 'confirmed']]])->one();
                if (!empty($alias)) {
                    $message = "Вы действительно хотите удалить бронь?";
                    $btn[] = ["text" => "Да " . hex2bin("E29C85")];
                    $btn[] = ["text" => "Нет " . hex2bin("E29D8E")];
                    $markup = json_encode(["keyboard" => [$btn], "resize_keyboard" => true]);
                } else {
                    $message = "Активные бронирования не найдены " . hex2bin("F09F98B3") . "\nВыберите действие: ";
                    $object->stage = 'main';
                    $btn[0][0] = ["text" => "Забронировать столик " . hex2bin("E28FB0")];
                    $btn[1][0] = ["text" => "Отменить бронь " . hex2bin("E29B94")];
                    $btn[2][0] = ["text" => "Связаться с администратором " . hex2bin("F09F9281")];
                    $btn[3][0] = ["text" => "Как добраться " . hex2bin("F09F9AA9")];
                    $markup = json_encode(["keyboard" => $btn, "resize_keyboard" => true]);
                }
                break;

            case "cancel_1":
                $alias = BavariaBotPlacesAlias::find()->where(['AND', ['tg_user_id' => $object->tg_user_id], ['OR', ['status' => 'processing'], ['status' => 'confirmed']]])->one();
                if (!empty($alias)) {
                    $alias->delete();
                    $object->stage = 'main';
                    $message = "Бронь удалена!\nВыберите действие: ";
                    $btn[0][0] = ["text" => "Забронировать столик " . hex2bin("E28FB0")];
                    $btn[1][0] = ["text" => "Отменить бронь " . hex2bin("E29B94")];
                    $btn[2][0] = ["text" => "Связаться с администратором " . hex2bin("F09F9281")];
                    $btn[3][0] = ["text" => "Как добраться " . hex2bin("F09F9AA9")];
                    $markup = json_encode(["keyboard" => $btn, "resize_keyboard" => true]);
                } else {
                    $message = "Активные бронирования не найдены " . hex2bin("F09F98B3") . "\nВыберите действие: ";
                    $object->stage = 'main';
                    $btn[0][0] = ["text" => "Забронировать столик " . hex2bin("E28FB0")];
                    $btn[1][0] = ["text" => "Отменить бронь " . hex2bin("E29B94")];
                    $btn[2][0] = ["text" => "Связаться с администратором " . hex2bin("F09F9281")];
                    $btn[3][0] = ["text" => "Как добраться " . hex2bin("F09F9AA9")];
                    $markup = json_encode(["keyboard" => $btn, "resize_keyboard" => true]);
                }
                break;

            case "manager_0":
                $message = "Заказать звонок у администратора?";
                $btn[] = ["text" => "Да " . hex2bin("E29C85")];
                $btn[] = ["text" => "Нет " . hex2bin("E29D8E")];
                $markup = json_encode(["keyboard" => [$btn], "resize_keyboard" => true]);
                break;

            case "manager_1":
                $object->stage = 'main';
                $message = "Звонок заказан! Ожидайте звонка в течение 5 минут " . hex2bin("F09F9A80");
                $btn[0][0] = ["text" => "Забронировать столик " . hex2bin("E28FB0")];
                $btn[1][0] = ["text" => "Отменить бронь " . hex2bin("E29B94")];
                $btn[2][0] = ["text" => "Связаться с администратором " . hex2bin("F09F9281")];
                $btn[3][0] = ["text" => "Как добраться " . hex2bin("F09F9AA9")];
                $markup = json_encode(["keyboard" => $btn, "resize_keyboard" => true]);
                break;

            case "route":
                $object->stage = 'main';
                $message = null;
                $btn[0][0] = ["text" => "Забронировать столик " . hex2bin("E28FB0")];
                $btn[1][0] = ["text" => "Отменить бронь " . hex2bin("E29B94")];
                $btn[2][0] = ["text" => "Связаться с администратором " . hex2bin("F09F9281")];
                $btn[3][0] = ["text" => "Как добраться " . hex2bin("F09F9AA9")];
                $markup = json_encode(["keyboard" => $btn, "resize_keyboard" => true]);
                break;

        }
        if (!empty($message))
            $rsp = static::setResponse($object, $message, $markup);
        else
            $rsp = static::sendLocation($object, $markup);
        $object->status = static::setStatus($rsp);
        $ac = new ActionLogger();
        $ac->user = 1;
        $ac->controller = 'bavaria';
        $ac->action = 'bavaria';
        $ac->params = $rsp;
        $ac->date = date("Y-m-d H:i:s");
        $ac->save();
        $object->save();
    }
}