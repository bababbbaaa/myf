<?php

namespace common\models\helpers;

use common\models\JobsQueue;
use Yii;

/**
 * @property string $to
 * @property string $title
 * @property string $message
 * @property string $html
 * @property string $filepath
 */
class Mailer
{
    private $to, $title, $message, $html, $filepath;

    const TITLES = [
        '1_signup' => "Ура! Регистрация пройдена, дарим Вам 2000 бонусов на ваш счет",
        '2_profile' => "У вас не заполнены данные в профиле личного кабинета! Уделите 1 минуту",
        '3_orders' => "У вас еще нет действующих заказов на MYFORCE - пора начать прокачивать свою компанию!",
        '4_orders' => "У вас нет активного заказа на лиды - сформируйте новый заказ и получите 5% кэшбека",
        '5_orders_match' => "Важно! Ваш заказ на лиды скоро будет завершен, отгружено более 80% заказа!",
        '6_orders_match' => "Внимание! По вашему заказу на лиды выгружено более 50% лидов!",
        '7_orders_match' => "Поздравляем! Вы получили 25% лидов от общего объема заказа!",
        '8_orders_match' => "Ура! Вы получили первые 10% лидов по вашему заказу!",
        '9_balance' => "Ваш баланс менее 2000 рублей, лиды скоро остановятся",
        '10_balance' => "Ваш баланс пуст и вы не получаете лиды - пополните баланс и начните получать лиды в свой бизнес!",
        '11_orders' => "У вас есть скидка на курсы до 50%! Воспользуйтесь ей.",
        '12_signup' => "CRM, Лендинги, Сайты, Блоги, Приложения - скидка 25% для участников экосистемы",
        '13_orders' => "Поможем устранить браки по лидам и повысить эффективность бизнеса!",
        '14_orders' => "Арбитражное управление банкротов за 50 000 рублей под ключ!",
        '15_signup' => "Подборка полезных сервисов для вашего бизнеса №1 от MYFORCE",
        '16_signup' => "Новая подборка полезных сервисов для вашего бизнеса №2 от MYFORCE",
        '17_signup' => "Сервисы для вашего бизнеса №3 - Лучшая подборка месяца от MYFORCE",
        '18_orders' => "Пожалуйста, напишите отзыв, помогите нам стать лучше",
        '19_signup' => "Бесплатный СЕО аудит вашего сайта за 1 день! Дарим подарок участнику экосистемы!",
        '20_signup' => "Бесплатный аудит CRM (Bitrix24 или AmoCRM) и план оптимизации в подарок!",
        '21_orders' => "Технологии продаж банкротства и юридические модули - как оптимизировать бизнес по банкротству!",
    ];

    public function process(): bool
    {
        $rsp = Yii::$app->mailer;
        if (!empty($this->html))
            $rsp = $rsp->compose(['html' => "mailer/{$this->html}.php"]);
        else
            $rsp = $rsp
                ->compose()
                ->setTextBody($this->message);
        if (!empty($this->filepath))
            $rsp = $rsp->attach($this->filepath);
        try {
            $rx = $rsp
                ->setTo($this->to)
                ->setFrom(["info@myforce.ru" => "Клиентский сервис MYFORCE"])
                ->setReplyTo(["general@myforce.ru" => "Администрация проекта"])
                ->setSubject($this->title)
                ->send();
            return $rx;
        } catch (\Exception $exception) {
            return false;
        }
    }

    public function setTo($to): Mailer
    {
        $this->to = $to;
        return $this;
    }

    public function setTitle($title): Mailer
    {
        $this->title = $title;
        return $this;
    }

    public function setMessage($message): Mailer
    {
        $this->message = $message;
        return $this;
    }

    public function setHtml($html): Mailer
    {
        $this->html = $html;
        return $this;
    }

    public function setAttachment($filepath)
    {
        $this->filepath = $filepath;
        return $this;
    }

    public static function create__signup__queue($email, $uid) {
        $dates = [];
        for ($i = 0; $i < 15; $i++) {
            if (empty($dates))
                $dates[$i] = date("Y-m-d 12:00:00", time() + 3600 * 24 * 7);
            else {
                if ($i < 4) {
                    $dates[$i] = date("Y-m-d 12:00:00", strtotime($dates[$i - 1]) + 3600 * 24 * 7);
                } else {
                    $dates[$i] = date("Y-m-d 12:00:00", strtotime($dates[$i - 1]) + 3600 * 24 * 30);
                }
            }
        }
        if (!empty($dates)) {
            foreach ($dates as $date) {
                $queue = new JobsQueue();
                $queue->method = "execute__mailer";
                $queue->params = json_encode(["to" => $email, 'html' => '2_profile', 'title' => self::TITLES['2_profile']], JSON_UNESCAPED_UNICODE);
                $queue->date_start = $date;
                $queue->status = 'wait';
                $queue->user_id = $uid;
                $queue->closed = 0;
                $queue->save();
            }
        }
    }

    public static function create__orders__queue($email, $uid) {
        /*$dates = [];
        for ($i = 0; $i < 8; $i++) {
            if (empty($dates))
                $dates[$i] = date("Y-m-d 12:00:00", time() + 3600 * 24 * 5);
            else {
                $dates[$i] = date("Y-m-d 12:00:00", strtotime($dates[$i - 1]) + 3600 * 24 * 7);
            }
        }
        if (!empty($dates)) {
            foreach ($dates as $date) {
                $queue = new JobsQueue();
                $queue->method = "execute__mailer";
                $queue->params = json_encode(["to" => $email, 'html' => '3_orders', 'title' => self::TITLES['3_orders']], JSON_UNESCAPED_UNICODE);
                $queue->date_start = $date;
                $queue->status = 'wait';
                $queue->user_id = $uid;
                $queue->closed = 0;
                $queue->save();
            }
        }*/
    }

    public static function create__orders__queue__11($email, $uid) {
        /*$dates = [];
        for ($i = 0; $i < 12; $i++) {
            if (empty($dates))
                $dates[$i] = date("Y-m-d 12:00:00", time() + 3600 * 24 * 15);
            else {
                $dates[$i] = date("Y-m-d 12:00:00", strtotime($dates[$i - 1]) + 3600 * 24 * 15);
            }
        }
        if (!empty($dates)) {
            foreach ($dates as $date) {
                $queue = new JobsQueue();
                $queue->method = "execute__mailer";
                $queue->params = json_encode(["to" => $email, 'html' => '11_orders', 'title' => self::TITLES['11_orders']], JSON_UNESCAPED_UNICODE);
                $queue->date_start = $date;
                $queue->status = 'wait';
                $queue->user_id = $uid;
                $queue->closed = 0;
                $queue->save();
            }
        }*/
    }

    public static function create__signup__queue__12($email, $uid) {
        /*$dates = [];
        for ($i = 0; $i < 12; $i++) {
            if (empty($dates))
                $dates[$i] = date("Y-m-d 12:00:00", time() + 3600 * 24 * 15);
            else {
                $dates[$i] = date("Y-m-d 12:00:00", strtotime($dates[$i - 1]) + 3600 * 24 * 15);
            }
        }
        if (!empty($dates)) {
            foreach ($dates as $date) {
                $queue = new JobsQueue();
                $queue->method = "execute__mailer";
                $queue->params = json_encode(["to" => $email, 'html' => '12_signup', 'title' => self::TITLES['12_signup']], JSON_UNESCAPED_UNICODE);
                $queue->date_start = $date;
                $queue->status = 'wait';
                $queue->user_id = $uid;
                $queue->closed = 0;
                $queue->save();
            }
        }*/
    }


    public static function create__signup__queue__15($email, $uid) {
        /*$dates = [];
        for ($i = 0; $i < 12; $i++) {
            if (empty($dates))
                $dates[$i] = date("Y-m-d 12:00:00", time() + 3600 * 24 * 10);
            else {
                $dates[$i] = date("Y-m-d 12:00:00", strtotime($dates[$i - 1]) + 3600 * 24 * 40);
            }
        }
        if (!empty($dates)) {
            foreach ($dates as $date) {
                $queue = new JobsQueue();
                $queue->method = "execute__mailer";
                $queue->params = json_encode(["to" => $email, 'html' => '15_signup', 'title' => self::TITLES['15_signup']], JSON_UNESCAPED_UNICODE);
                $queue->date_start = $date;
                $queue->status = 'wait';
                $queue->user_id = $uid;
                $queue->closed = 0;
                $queue->save();
            }
        }*/
    }

    public static function create__signup__queue__16($email, $uid) {
        /*$dates = [];
        for ($i = 0; $i < 12; $i++) {
            if (empty($dates))
                $dates[$i] = date("Y-m-d 12:00:00", time() + 3600 * 24 * 20);
            else {
                $dates[$i] = date("Y-m-d 12:00:00", strtotime($dates[$i - 1]) + 3600 * 24 * 40);
            }
        }
        if (!empty($dates)) {
            foreach ($dates as $date) {
                $queue = new JobsQueue();
                $queue->method = "execute__mailer";
                $queue->params = json_encode(["to" => $email, 'html' => '16_signup', 'title' => self::TITLES['16_signup']], JSON_UNESCAPED_UNICODE);
                $queue->date_start = $date;
                $queue->status = 'wait';
                $queue->user_id = $uid;
                $queue->closed = 0;
                $queue->save();
            }
        }*/
    }

    public static function create__signup__queue__17($email, $uid) {
        /*$dates = [];
        for ($i = 0; $i < 12; $i++) {
            if (empty($dates))
                $dates[$i] = date("Y-m-d 12:00:00", time() + 3600 * 24 * 30);
            else {
                $dates[$i] = date("Y-m-d 12:00:00", strtotime($dates[$i - 1]) + 3600 * 24 * 40);
            }
        }
        if (!empty($dates)) {
            foreach ($dates as $date) {
                $queue = new JobsQueue();
                $queue->method = "execute__mailer";
                $queue->params = json_encode(["to" => $email, 'html' => '17_signup', 'title' => self::TITLES['17_signup']], JSON_UNESCAPED_UNICODE);
                $queue->date_start = $date;
                $queue->status = 'wait';
                $queue->user_id = $uid;
                $queue->closed = 0;
                $queue->save();
            }
        }*/
    }

    public static function create__orders__queue_14($email, $uid) {
        /*$dates = [];
        for ($i = 0; $i < 6; $i++) {
            if (empty($dates))
                $dates[$i] = date("Y-m-d 12:00:00", time() + 3600 * 24 * 90);
            else {
                $dates[$i] = date("Y-m-d 12:00:00", strtotime($dates[$i - 1]) + 3600 * 24 * 90);
            }
        }
        if (!empty($dates)) {
            foreach ($dates as $date) {
                $queue = new JobsQueue();
                $queue->method = "execute__mailer";
                $queue->params = json_encode(["to" => $email, 'html' => '14_orders', 'title' => self::TITLES['14_orders']], JSON_UNESCAPED_UNICODE);
                $queue->date_start = $date;
                $queue->status = 'wait';
                $queue->user_id = $uid;
                $queue->closed = 0;
                $queue->save();
            }
        }*/
    }

    public static function create__start__queue($email, $uid) {
        $queue = new JobsQueue();
        $queue->method = "execute__mailer";
        $queue->params = json_encode(["to" => $email, 'html' => '1_signup', 'title' => Mailer::TITLES['1_signup']], JSON_UNESCAPED_UNICODE);
        $queue->date_start = date("Y-m-d H:i:s");
        $queue->status = 'wait';
        $queue->user_id = $uid;
        $queue->closed = 0;
        $queue->save();
        /*$queue = new JobsQueue();
        $queue->method = "execute__mailer";
        $queue->params = json_encode(["to" => $email, 'html' => '19_signup', 'title' => Mailer::TITLES['19_signup']], JSON_UNESCAPED_UNICODE);
        $queue->date_start = date("Y-m-d H:i:s", time() + 3600 * 24 * 12);
        $queue->status = 'wait';
        $queue->user_id = $uid;
        $queue->closed = 0;
        $queue->save();
        $queue = new JobsQueue();
        $queue->method = "execute__mailer";
        $queue->params = json_encode(["to" => $email, 'html' => '20_signup', 'title' => Mailer::TITLES['20_signup']], JSON_UNESCAPED_UNICODE);
        $queue->date_start = date("Y-m-d H:i:s", time() + 3600 * 24 * 3);
        $queue->status = 'wait';
        $queue->user_id = $uid;
        $queue->closed = 0;
        $queue->save();*/
    }

}