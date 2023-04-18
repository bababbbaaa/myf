<?php


namespace common\models\helpers;


class TelegramBot
{

    const DEFAULT_BOT = "bot2069550101:AAHGKA21mmZ_B0hashddG7IX17r16CaxX6M";
    const HR_BOT = "bot5093309067:AAFFF7oiTjsx7uK_jFSM1j_UJDo7A5FQuw8";

    const PEER_MARKETING = "-1001427943313";
    const PEER_SUPPORT = "-1001403778441";
    const PEER_OPERATIONS = "-1001453735295";
    const PEER_HR = "-1001750652865";
    const PEER_SALE = "-1001395429688";
    const PEER_DOUBLES = "-849548226";


    public function new__message($message, $peer, $bot = self::DEFAULT_BOT, $parseMode = 'HTML') {
        usleep(125000);
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, "https://api.telegram.org/{$bot}/sendMessage");
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 3);
        curl_setopt($curl, CURLOPT_TIMEOUT, 10);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HEADER, 0);
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query([
            'chat_id' => $peer,
            'text' => $message,
            'parse_mode' => $parseMode,
        ]));
        $result2 = curl_exec($curl);
        curl_close($curl);
        return $result2;
    }

    public function send__image($img, $peer, $bot = self::DEFAULT_BOT) {
        $url = "https://api.telegram.org/{$bot}/" . "sendPhoto?chat_id=" . $peer ;
        $post_fields = array(
            'chat_id'   => $peer,
            'photo' => new \CURLFile($img),
        );
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "Content-Type:multipart/form-data"
        ));
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_fields);
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 2);
        $output = curl_exec($ch);
        curl_close($ch);
        return $output;
    }

    public static function hr__message($data) {
        $message = "<b>Рекрутинг</b> - целевой лид с КЦ ". hex2bin("F09F988C") ." \n";
        $message .= "<b>Телефон:</b> {$data['phone']}\n";
        $message .= "<b>Имя:</b> {$data['name']}\n";
        $pars = json_decode($data['params'], true);
        if (!empty($pars['Доп.информация']))
            $message .= "<b>Комментарий:</b> {$pars['Доп.информация']}\n";
        $message .= "<b>Метка:</b> {$data['utm_source']}\n";
        return $message;
    }

    public static function signup__message($username) {
        return $text = "<b>Новая регистрация в ЛК</b> - $username";
    }

    public static function ticket__message($ticket) {
        return $text = "<b>Пользователь оставил новое сообщение для тех. поддержки</b> - <a href='https://admin.myforce.ru/support/dialogues/chat?id={$ticket}'>диалог №{$ticket}</a>";
    }

    public static function kassa__message($user, $summ) {
        return $text = "<b><a href='https://admin.myforce.ru/users/view?id={$user->id}'>Пользователь #{$user->id} ($user->username)</a></b> - пополнил баланс личного кабинета MYFORCE на сумму <b>" . number_format($summ, 0, '', ' ') . " рублей</b> через ROBOKASSA.";
    }

    public static function order__message($order, $user) {
        return $text = "<b><a href='https://admin.myforce.ru/users/view?id={$user}'>У пользователя ЛК №{$user}</a> добавлен <a href='https://admin.myforce.ru/lead-force/orders/view?id={$order}'>новый заказ (#{$order})</a></b>";
    }

    public static function prize__message($prize, $user) {
        return $text = "<b><a href='https://admin.myforce.ru/users/view?id={$user}'>Пользователь ЛК №{$user}</a> выиграл на колесе приз - {$prize}. Необходимо связаться с клиентом</b>";
    }

    public static function buyFranchise__message($user, $franchise, $package){
        return $text = "<b><a href='https://admin.myforce.ru/users/view?id={$user}'>Пользователь ЛК №{$user}</a> купил франшизу - {$franchise} по пакету: {$package}</b>";
    }

    public static function new__project($user, $project_id, $project_name){
        return $text = "<b>Пользователь ЛК №{$user} создал проект:</b> - <a href='https://admin.myforce.ru/dev-force/dev-project/view?id={$project_id}'>{$project_name}</a>";
    }

    public static function daily__bx__report($daily, $anketa, $won){
        $date = date('d.m.Y');
        return $text = "<b>{$date}:</b>\nПолучено лидов операторами: {$daily} \nПереходов на статус <b>Анкета получена</b>: {$anketa}\nКонверсий сегодня: {$won}";
    }

    public static function makeArrayText($param) {
        $t = "<b>Новый лид - </b>" . date("d.m.Y H:i:s") . "\n";
        foreach ($param as $key => $item) {
            if (!empty($item))
                $t .= "{$key}: {$item}\n";
        }
        return $t;
    }

}