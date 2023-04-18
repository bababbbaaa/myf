<?php

namespace common\models\helpers;

use admin\models\CookieValidator;
use common\models\disk\Cloud;
use common\models\LbMessages;
use common\models\LbPeers;
use common\models\M3Auth;
use common\models\M3Costs;
use common\models\M3Messages;
use common\models\M3Peers;
use common\models\M3Projects;
use function Symfony\Component\String\b;


class LawyerBot
{

    const TOKEN = "5386999369:AAFngBT2J4qXvY2GcXc77WMxqM0MLY1gRUo";

    private $task;
    private $message;
    private $auth;

    /**
     * @param mixed $task
     */
    public function setTask($task): self
    {
        $this->task = $task;
        return $this;
    }

    public function setResponse($uid = null) {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, "https://api.telegram.org/bot". self::TOKEN ."/sendMessage");
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 3);
        curl_setopt($curl, CURLOPT_TIMEOUT, 10);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HEADER, 0);
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query([
            'chat_id' => $uid ?? $this->auth->uid,
            'text' => $this->message,
            'parse_mode' => 'HTML',
        ]));
        $result2 = curl_exec($curl);
        curl_close($curl);
        return $result2;
    }

    private function parseParams($params, $newParamKey, $newParamValue) {
        $p = json_decode($params, 1);
        $p[$newParamKey] = $newParamValue;
        return json_encode($p, JSON_UNESCAPED_UNICODE);
    }

    public function taskChecker(LbMessages $message) {
        $this->auth = $message;
        switch ($this->task) {
            case 'start':
                $this->message = "<b>Приветствую, {$message->username}.</b> Выбери тип формируемого счета (указать число 1 или 2): \n\n";
                $this->message .= "1. ИСМ\n";
                $this->message .= "2. ИП Дьярова\n";
                $this->setResponse($message->uid);
                $peer = LbPeers::findOne(['uid' => $message->uid]);
                if (!empty($peer)) {
                    $peer->peer_stage = 'type';
                    $peer->update();
                }
                break;

            case 'type':
                $rsp = (int)$message->message;
                if ($rsp === 1 || $rsp === 2) {
                    $this->message = "Хорошо, укажи размер платежа в рублях (только число), например - 40000";
                    $this->setResponse($message->uid);
                    $peer = LbPeers::findOne(['uid' => $message->uid]);
                    if (!empty($peer)) {
                        $peer->peer_stage = 'price';
                        $peer->params = json_encode(['type' => $rsp === 1 ? 'ism.docx' : 'diarova.docx']);
                        $peer->update();
                    }
                } else {
                    $this->message = "<b>Ошибка, необходимо указать правильное число!</b> Выбери тип формируемого счета (указать число 1 или 2): \n\n";
                    $this->message .= "1. ИСМ\n";
                    $this->message .= "2. ИП Дьярова\n";
                    $this->setResponse($message->uid);
                    $peer = LbPeers::findOne(['uid' => $message->uid]);
                    if (!empty($peer)) {
                        $peer->peer_stage = 'type';
                        $peer->update();
                    }
                }
                break;

            case 'price':
                $rsp = (float)$message->message;
                if ($rsp > 0) {
                    $this->message = "Ок, теперь укажи дату счета в формате дд.мм.гггг, например - " . date("d.m.Y");
                    $this->setResponse($message->uid);
                    $peer = LbPeers::findOne(['uid' => $message->uid]);
                    if (!empty($peer)) {
                        $peer->peer_stage = 'date';
                        $peer->params = $this->parseParams($peer->params, 'price', $rsp);
                        $peer->update();
                    }
                } else {
                    $this->message = "<b>Ошибка, необходимо указать правильное число, отличное от нуля!</b> Например, 40000 \n\n";
                    $this->setResponse($message->uid);
                    $peer = LbPeers::findOne(['uid' => $message->uid]);
                    if (!empty($peer)) {
                        $peer->peer_stage = 'price';
                        $peer->update();
                    }
                }
                break;

            case 'date':
                $rsp = $message->message;
                $dateArr = explode('.', $rsp);
                if (count($dateArr) === 3) {
                    $this->message = "Ок, теперь укажи номер договора, например - A213500";
                    $this->setResponse($message->uid);
                    $peer = LbPeers::findOne(['uid' => $message->uid]);
                    if (!empty($peer)) {
                        $peer->peer_stage = 'id';
                        $peer->params = $this->parseParams($peer->params, 'day', $dateArr[0]);
                        $peer->params = $this->parseParams($peer->params, 'month', $dateArr[1]);
                        $peer->params = $this->parseParams($peer->params, 'year', $dateArr[2]);
                        $peer->update();
                    }
                } else {
                    $this->message = "<b>Ошибка, необходимо указать дату в правильном формате!</b> Например, ". date("d.m.Y") ." \n\n";
                    $this->setResponse($message->uid);
                    $peer = LbPeers::findOne(['uid' => $message->uid]);
                    if (!empty($peer)) {
                        $peer->peer_stage = 'date';
                        $peer->update();
                    }
                }
                break;

            case 'id':
                $rsp = $message->message;
                if (strlen($rsp) > 0) {
                    $this->message = "Ок, теперь укажи ИНН покупателя";
                    $this->setResponse($message->uid);
                    $peer = LbPeers::findOne(['uid' => $message->uid]);
                    if (!empty($peer)) {
                        $peer->peer_stage = 'inn';
                        $peer->params = $this->parseParams($peer->params, 'id', $rsp);
                        $peer->update();
                    }
                } else {
                    $this->message = "<b>Ошибка, длина строки должна быть больше нуля!</b>";
                    $this->setResponse($message->uid);
                    $peer = LbPeers::findOne(['uid' => $message->uid]);
                    if (!empty($peer)) {
                        $peer->peer_stage = 'id';
                        $peer->update();
                    }
                }
                break;

            case 'inn':
                $rsp = $message->message;
                if (is_numeric($rsp)) {
                    $this->message = "Ок, теперь укажи КПП покупателя";
                    $this->setResponse($message->uid);
                    $peer = LbPeers::findOne(['uid' => $message->uid]);
                    if (!empty($peer)) {
                        $peer->peer_stage = 'kpp';
                        $peer->params = $this->parseParams($peer->params, 'inn', $rsp);
                        $peer->update();
                    }
                } else {
                    $this->message = "<b>Ошибка, ИНН должно содержать только цифры!</b>";
                    $this->setResponse($message->uid);
                    $peer = LbPeers::findOne(['uid' => $message->uid]);
                    if (!empty($peer)) {
                        $peer->peer_stage = 'inn';
                        $peer->update();
                    }
                }
                break;

            case 'kpp':
                $rsp = $message->message;
                if (is_numeric($rsp)) {
                    $this->message = "Ок, теперь укажи название организации покупателя";
                    $this->setResponse($message->uid);
                    $peer = LbPeers::findOne(['uid' => $message->uid]);
                    if (!empty($peer)) {
                        $peer->peer_stage = 'org_name';
                        $peer->params = $this->parseParams($peer->params, 'kpp', $rsp);
                        $peer->update();
                    }
                } else {
                    $this->message = "<b>Ошибка, КПП должно содержать только цифры!</b>";
                    $this->setResponse($message->uid);
                    $peer = LbPeers::findOne(['uid' => $message->uid]);
                    if (!empty($peer)) {
                        $peer->peer_stage = 'kpp';
                        $peer->update();
                    }
                }
                break;

            case 'org_name':
                $rsp = $message->message;
                if (strlen($rsp) > 0) {
                    $this->message = "Ок, теперь укажи адрес организации покупателя";
                    $this->setResponse($message->uid);
                    $peer = LbPeers::findOne(['uid' => $message->uid]);
                    if (!empty($peer)) {
                        $peer->peer_stage = 'address';
                        $peer->params = $this->parseParams($peer->params, 'org_name', $rsp);
                        $peer->update();
                    }
                } else {
                    $this->message = "<b>Ошибка, название организации не может быть пустым!</b>";
                    $this->setResponse($message->uid);
                    $peer = LbPeers::findOne(['uid' => $message->uid]);
                    if (!empty($peer)) {
                        $peer->peer_stage = 'org_name';
                        $peer->update();
                    }
                }
                break;


            case 'address':
                $rsp = $message->message;
                if (strlen($rsp) > 0) {
                    $this->message = "Заключительный этап, теперь укажи текст описания для пункта \"Товары, услуги\"";
                    $this->setResponse($message->uid);
                    $peer = LbPeers::findOne(['uid' => $message->uid]);
                    if (!empty($peer)) {
                        $peer->peer_stage = 'text_desc';
                        $peer->params = $this->parseParams($peer->params, 'address', $rsp);
                        $peer->update();
                    }
                } else {
                    $this->message = "<b>Ошибка, адрес организации не может быть пустым!</b>";
                    $this->setResponse($message->uid);
                    $peer = LbPeers::findOne(['uid' => $message->uid]);
                    if (!empty($peer)) {
                        $peer->peer_stage = 'address';
                        $peer->update();
                    }
                }
                break;


            case 'text_desc':
                $rsp = $message->message;
                if (strlen($rsp) > 0) {
                    $peer = LbPeers::findOne(['uid' => $message->uid]);
                    if (!empty($peer)) {
                        $peer->peer_stage = 'type';
                        $peer->params = $this->parseParams($peer->params, 'text_desc', $rsp);
                        $cloud = new Cloud(1);
                        $r = $cloud->create__bill__bot($p = json_decode($peer->params, 1), $p['price']);
                        if (isset($r['download'])) {
                            $peer->update();
                            $this->message = "Хорошо, счет готов. Вот ссылка для скачивания: \n\n";
                            $this->message .= "<a href='https://admin.myforce.ru". $r['download'] ."'>тык сюда</a>\n\n";
                            $this->message .= "Если нужен новый счет - выбери тип формируемого счета (указать число 1 или 2): \n\n";
                            $this->message .= "1. ИСМ\n";
                            $this->message .= "2. ИП Дьярова\n";
                            $this->setResponse($message->uid);
                        } else {
                            $this->message = "<b>Ошибка создания счета, попробуйте позднее или обратитесь к администратору</b>";
                            $this->setResponse($message->uid);
                            $peer = LbPeers::findOne(['uid' => $message->uid]);
                            if (!empty($peer)) {
                                $peer->peer_stage = 'text_desc';
                                $peer->update();
                            }
                        }
                    }
                } else {
                    $this->message = "<b>Ошибка, текст описания не может быть пустым!</b>";
                    $this->setResponse($message->uid);
                    $peer = LbPeers::findOne(['uid' => $message->uid]);
                    if (!empty($peer)) {
                        $peer->peer_stage = 'text_desc';
                        $peer->update();
                    }
                }
                break;
        }
    }




}