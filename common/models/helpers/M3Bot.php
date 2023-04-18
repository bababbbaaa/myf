<?php

namespace common\models\helpers;

use admin\models\CookieValidator;
use common\models\M3Auth;
use common\models\M3Costs;
use common\models\M3Messages;
use common\models\M3Peers;
use common\models\M3Projects;
use function Symfony\Component\String\b;

/**
 * @property M3Auth $auth
 */
class M3Bot
{

    const TOKEN = "5535891630:AAElTbYsdCwl1QSB4OyywVw8lKc7EMe5HS0";

    private $auth;
    private $newHash;
    private $task;
    private $message;
    private $currentHash;

    /**
     * @param mixed $task
     */
    public function setTask($task): self
    {
        $this->task = $task;
        return $this;
    }

    /**
     * @param mixed $currentHash
     */
    public function setCurrentHash($currentHash): M3Bot
    {
        $this->currentHash = $currentHash;
        return $this;
    }

    /**
     * @param mixed $auth
     */
    private function setAuth(M3Auth $auth): M3Bot
    {
        $this->auth = $auth;
        return $this;
    }

    public function findAuth($username, $uid, $hash = null) {
        $auth = M3Auth::find()
            ->where(['OR', ['username' => $username], ['uid' => $uid]])
            ->one();
        if (!empty($auth))
            $this->setAuth($auth);
        else {
            $auth = new M3Auth();
            $auth->username = $username;
            $auth->uid = $uid;
            $auth->hash = $hash;
            $auth->save();
            $this->setAuth($auth);
        }
        return $this;
    }

    public function newAuth($username, $uid, $hash, $currentHash) {
        $this->newHash = $hash;
        return $currentHash === $this->newHash ? $this->findAuth($username, $uid, $hash) : false;
    }

    public function validateHash(string $currentHash): bool
    {
        return $currentHash === $this->auth->hash;
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

    public function validateMessage(M3Messages $message) {
        return $this
            ->findAuth($message->username, $message->uid)
            ->validateHash($this->currentHash);
    }

    public function updateToken($token, M3Messages $ms) {
        $c = CookieValidator::findOne(3)->hash;
        if ($c === $token) {
            $auth = M3Auth::find()
                ->where(['OR', ['username' => $ms->username], ['uid' => $ms->uid]])
                ->one();
            if (!empty($auth)) {
                $auth->hash = $token;
                $auth->update();
            }
            $this->setAuth($auth);
            return $this->validateMessage($ms);
        }
        return false;
    }

    public function refreshToken (M3Messages $message) {
        $this->message = "С возвращением, {$message->username}. Понимаю, мы уже знакомы, но <b>я бы хотел увидеть актуальный пароль</b>.";
        $this->setResponse($message->uid);
        $peer = M3Peers::findOne(['uid' => $message->uid]);
        if (!empty($peer)) {
            $peer->peer_stage = 'refresh_token';
            $peer->update();
        }
    }

    public function taskChecker(M3Messages $message) {
        switch ($this->task) {
            case 'start':
                $this->message = "<b>Приветствую, {$message->username}.</b> Надеюсь, ты знаешь куда ты попал? \n\n Впрочем, неважно. <b>Говори пароль.</b>";
                $this->setResponse($message->uid);
                $peer = M3Peers::findOne(['uid' => $message->uid]);
                if (!empty($peer)) {
                    $peer->peer_stage = 'hash';
                    $peer->update();
                }
                break;
            case 'refresh_token':
                if (!$this->updateToken($message->message, $message)) {
                    $this->message = "Мммм, не, попробуй еще раз.";
                    $this->setResponse($message->uid);
                    $peer = M3Peers::findOne(['uid' => $message->uid]);
                    if (!empty($peer)) {
                        $peer->peer_stage = 'refresh_token';
                        $peer->update();
                    }
                } else {
                    $this->message = "<b>Рад снова видеть, {$this->auth->username}!</b>\n\n";
                    $m3 = M3Projects::find()->asArray()->all();
                    if (!empty($m3)) {
                        $this->message .= "Вот список актуальных проектов М3: \n\n";
                        foreach ($m3 as $index => $item) {
                            $this->message .= "[ <b>{$item['id']}</b> ] - {$item['name']}\n";
                        }
                        $this->message .= "\nЧтобы добавить расходы для нужного заказа - просто <b>укажи его ID (номер)</b> в чате, а дальше - я объясню, что делать. Понятно?";
                    } else {
                        $this->message .= "Актуальных проектов нет. Но есть чипсы.";
                    }
                    $this->setResponse($message->uid);
                    $peer = M3Peers::findOne(['uid' => $message->uid]);
                    if (!empty($peer)) {
                        $peer->peer_stage = 'wait_id';
                        $peer->update();
                    }
                }
                break;

            case 'hash':
                $rsp = $this->newAuth($message->username, $message->uid, $message->message, $this->currentHash);
                if (!$rsp) {
                    $this->message = "Код неправильный, ты как сюда попал?";
                    $this->setResponse($message->uid);
                    $peer = M3Peers::findOne(['uid' => $message->uid]);
                    if (!empty($peer)) {
                        $peer->peer_stage = 'hash';
                        $peer->update();
                    }
                } else {
                    $this->message = "<b>Добро пожаловать, {$this->auth->username}!</b>\n\n";
                    $m3 = M3Projects::find()->asArray()->all();
                    if (!empty($m3)) {
                        $this->message .= "Вот список актуальных проектов М3: \n\n";
                        foreach ($m3 as $index => $item) {
                            $this->message .= "[ <b>{$item['id']}</b> ] - {$item['name']}\n";
                        }
                        $this->message .= "\nЧтобы добавить расходы для нужного заказа - просто <b>укажи его ID (номер)</b> в чате, а дальше - я объясню, что делать. Понятно?";
                    } else {
                        $this->message .= "Актуальных проектов нет. Но есть чипсы.";
                    }
                    $this->setResponse($message->uid);
                    $peer = M3Peers::findOne(['uid' => $message->uid]);
                    if (!empty($peer)) {
                        $peer->peer_stage = 'wait_id';
                        $peer->update();
                    }
                }
                break;
            case 'wait_id':
                if ($this->validateMessage($message)) {
                    $project = M3Projects::findOne($message->message);
                    if (!empty($project)) {
                        $this->message = "Вот все данные по проекту: \n\n";
                        foreach ($project->attributeLabels() as $key => $item) {
                            if ($key === 'money_got') {
                                $txt = (bool)$project->{$key} ? 'да' : 'нет';
                                $this->message .= "<b>{$item}</b>: {$txt}\n";
                            } elseif($key === 'specs_link') {
                                $this->message .= "<b>{$item}</b>: <a href='{$project->{$key}}'>{$project->{$key}}</a>\n";
                            } elseif($key === 'date_start' || $key === 'date_end') {
                                $txt = date("d.m.Y", strtotime($project->{$key}));
                                $this->message .= "<b>{$item}</b>: {$txt}\n";
                            } elseif ($key === 'price' || $key === 'costs') {
                                $this->message .= "<b>{$item}</b>: {$project->{$key}} руб.\n";
                            } else
                                $this->message .= "<b>{$item}</b>: {$project->{$key}}\n";
                        }
                        $id = (int)$message->message;
                        $costs = M3Costs::find()
                            ->where(['project_id' => $id])
                            ->andWhere(['OR', ['is', 'value', null], ['is', 'description', null]])
                            ->orderBy('id desc')
                            ->one();
                        if (!empty($costs)) {
                            if (empty($costs->value)) {
                                $this->message .= "\n\nВ прошлый раз ты не до конца заполнил один из расходов, но не переживай, дружок, я нашел его. Сейчас заполним.";
                                $this->message .= "\n\nА теперь укажи затраты в рублях, только число, например - 10000.";
                                $this->setResponse($message->uid);
                                $peer = M3Peers::findOne(['uid' => $message->uid]);
                                if (!empty($peer)) {
                                    $peer->peer_stage = 'wait_costs';
                                    $peer->params = json_encode(['pid' => (int)$message->message, 'cid' => $costs->id]);
                                    $peer->update();
                                }
                            } elseif (empty($costs->description)) {
                                $this->message .= "\n\nВ прошлый раз ты забыл указать описание расхода, дружок. Описывай, на что бабки ушли?";
                                $this->setResponse($message->uid);
                                $peer = M3Peers::findOne(['uid' => $message->uid]);
                                if (!empty($peer)) {
                                    $peer->peer_stage = 'wait_description';
                                    $peer->params = json_encode(['pid' => (int)$message->message, 'cid' => $costs->id]);
                                    $peer->update();
                                }
                            }
                        } else {
                            $this->message .= "\nА теперь укажи затраты в рублях, только число, например - 10000.";
                            $this->setResponse($message->uid);
                            $peer = M3Peers::findOne(['uid' => $message->uid]);
                            if (!empty($peer)) {
                                $peer->peer_stage = 'wait_costs';
                                $peer->params = json_encode(['pid' => (int)$message->message]);
                                $peer->update();
                                $costs = new M3Costs();
                                $costs->project_id = (int)$message->message;
                                $costs->save();
                            }
                        }
                    } else {
                        $this->message = "Что за бред? Я не нашел проект с таким НОМЕРОМ. Номер указан в квадратных скобках. Нужно указать только число.\n\n";
                        $m3 = M3Projects::find()->asArray()->all();
                        if (!empty($m3)) {
                            $this->message .= "Вот список актуальных проектов М3: \n\n";
                            foreach ($m3 as $index => $item) {
                                $this->message .= "[ <b>{$item['id']}</b> ] - {$item['name']}\n";
                            }
                        } else {
                            $this->message .= "Актуальных проектов нет. Но есть чипсы.";
                        }
                        $this->setResponse($message->uid);
                        $peer = M3Peers::findOne(['uid' => $message->uid]);
                        if (!empty($peer)) {
                            $peer->peer_stage = 'wait_id';
                            $peer->update();
                        }
                    }
                } else {
                    $this->refreshToken($message);
                }
                break;

            case 'wait_costs':
                if ($this->validateMessage($message)) {
                    $peer = M3Peers::findOne(['uid' => $message->uid]);
                    $params = json_decode($peer->params, 1);
                    if (!empty($params)) {
                        if (!empty($params['cid'])) {
                            $costs = M3Costs::find()
                                ->where(['id' => $params['cid']])
                                ->orderBy('id desc')
                                ->one();
                        } else {
                            $costs = M3Costs::find()
                                ->where(['project_id' => $params['pid']])
                                ->orderBy('id desc')
                                ->one();
                        }
                        if (is_numeric($message->message)) {
                            $costs->value = (float)$message->message;
                            if ($costs->update() !== false) {
                                $project = M3Projects::findOne($costs->project_id);
                                $project->costs += $costs->value;
                                $project->update();
                                $this->message = "Ага. Записал. Теперь распиши подробнее, <i>в одном сообщении</i> - на что ушли бабки? А я пока открою чипсы.";
                                $this->setResponse($message->uid);
                                $peer->peer_stage = 'wait_description';
                                $peer->params = json_encode(['cid' => (int)$costs->id]);
                                $peer->update();
                            }
                        } else {
                            $this->message = "Ну и что это? Мне нужно конкретное число.";
                            $this->setResponse($message->uid);
                            $peer->peer_stage = 'wait_costs';
                            $peer->params = json_encode(['cid' => (int)$costs->id]);
                            $peer->update();
                        }
                    }
                } else {
                    $this->refreshToken($message);
                }
                break;

            case 'wait_description':
                if ($this->validateMessage($message)) {
                    $peer = M3Peers::findOne(['uid' => $message->uid]);
                    $params = json_decode($peer->params, 1);
                    if (!empty($params)) {
                        if (!empty($params['cid'])) {
                            $costs = M3Costs::find()
                                ->where(['id' => $params['cid']])
                                ->orderBy('id desc')
                                ->one();
                            $costs->description = $message->message;
                            if ($costs->update() !== false) {
                                $this->message = "И на это ты потратил {$costs->value} рублей? Мда. Лучше бы на пиво потратил.\n\n";
                                $m3 = M3Projects::find()->asArray()->all();
                                if (!empty($m3)) {
                                    $this->message .= "Ладно, я записал. Вернемся к списку: \n\n";
                                    foreach ($m3 as $index => $item) {
                                        $this->message .= "[ <b>{$item['id']}</b> ] - {$item['name']}\n";
                                    }
                                    $this->message .= "\nЧтобы добавить расходы для нужного заказа - просто <b>укажи его ID (номер)</b> в чате, а дальше - я объясню, что делать. Понятно?";
                                }
                                $this->setResponse($message->uid);
                                $peer->peer_stage = 'wait_id';
                                $peer->params = json_encode(['cid' => (int)$costs->id]);
                                $peer->update();
                            }
                        }
                    }
                } else {
                    $this->refreshToken($message);
                }
                break;
        }
    }




}