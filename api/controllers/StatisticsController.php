<?php


namespace api\controllers;


use common\models\BackdoorWebhooks;
use common\models\DbPhones;
use common\models\DbRegion;
use common\models\helpers\PhoneRegionHelper;
use common\models\Leads;
use common\models\LeadsRead;
use yii\helpers\Html;
use yii\web\Controller;
use yii\web\Response;

class StatisticsController extends Controller
{

    public function beforeAction($action)
    {
        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }

    public function actionPush($token, $id) {
        \Yii::$app->response->format = Response::FORMAT_JSON;
        if (!empty($token) && !empty($id)) {
            $hook = BackdoorWebhooks::findOne(['hash' => $token]);
            if (!empty($hook)) {
                $ch = curl_init();
                curl_setopt_array($ch, [
                    CURLOPT_URL => "{$hook->url}crm.lead.get?id=$id",
                    CURLOPT_SSL_VERIFYPEER => 0,
                    CURLOPT_SSL_VERIFYHOST => 0,
                    CURLOPT_HEADER => 0,
                    CURLOPT_RETURNTRANSFER => 1,
                ]);
                $data = curl_exec($ch);
                $result = json_decode($data, 1);
                if(!empty($result['result'])){
                    $snatched = $result['result'];
                    if (empty($snatched['PHONE'][0]['VALUE']))
                        return ['status' => 'error', 'message' => 'Не найдены данные для записи статистики'];
                    $lead = new LeadsRead();
                    $lead->phone = preg_replace("/[^0-9]/", '', $snatched['PHONE'][0]['VALUE']);
                    $lead->email = Html::encode($snatched['EMAIL'][0]['VALUE']);
                    $lead->name = !empty($snatched['NAME']) ? Html::encode($snatched['NAME']) :'Без имени';
                    $lead->comments = !empty($snatched['COMMENTS']) ? strip_tags($snatched['COMMENTS'], "<br>") : null;
                    $lead->region = null;
                    $lead->city = null;
                    $lead->type = $hook->lead_type;
                    $lead->status = Leads::STATUS_MODERATE;
                    $url = parse_url($hook->url);
                    $lead->source = is_array($url) ? "backdoor {$url['host']}" : "backdoor unknown";
                    $lead->ip = "127.0.0.1";
                    $dbReg = PhoneRegionHelper::getValidRegion($lead->phone);
                    if (!empty($dbReg)) {
                        $lead->region = $dbReg->name_with_type;
                    }
                    if ($lead->validate() && $lead->save()) {
                        return ['status' => 'success', 'message' => 'Статистические данные успешно записаны'];
                    } else
                        return ['status' => 'error', 'message' => 'Ошибка записи статистики'];
                } else
                    return ['status' => 'error', 'message' => 'Не найдена сущность для сбора статистики MyForce'];
            }
            else return ['status' => 'error', 'message' => 'Кампания для записи статистики не найдена'];
        }
        else return ['status' => 'error', 'message' => 'Некорректный запрос'];
    }

    public function actionTelegramTest($chat, $id, $size) {
        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_TIMEOUT => 3,
            CURLOPT_CONNECTTIMEOUT => 3,
            CURLOPT_URL => "https://api.telegram.org/bot5336677272:AAGAUcyP_hFDbPB7m125ZChsQVlZMxTwdQw/sendInvoice",
            //CURLOPT_URL => "https://api.telegram.org/bot5336677272:AAGAUcyP_hFDbPB7m125ZChsQVlZMxTwdQw/setChatMenuButton",
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => http_build_query([
                'chat_id' => $chat,
                //'menu_button' => json_encode(['type' => 'web_app', 'text' => 'Покупки', 'web_app' => ['url' => 'https://api.myforce.ru/site/telega-test', 'text' => 'Покупки',]]),
                'title' => "Футболка {$id}",
                'description' => "Мерч от популярного блогера, размер - {$size}",
                'photo_url' => "https://api.myforce.ru/images/tg_merch_{$id}.jpg",
                'photo_width' => "341",
                'photo_height' => "266",
                'payload' => "723421",
                'provider_token' => "401643678:TEST:30a8de7f-5a36-4b23-b8c4-a4514bbd3bb3",
                'currency' => "RUB",
                'need_shipping_address' => true,
                'prices' => json_encode([
                    ['label' => 'Test', 'amount' => 1999 * 100]
                ]),
            ]),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HEADER => false
        ]);
        $rsp = curl_exec($ch);
        var_dump($rsp);
    }

    public function actionTelegramTest2($chat, $id, $name) {
        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_TIMEOUT => 3,
            CURLOPT_CONNECTTIMEOUT => 3,
            CURLOPT_URL => "https://api.telegram.org/bot5285653070:AAEo7dBLACQgufJakt2zQ65owa0do39HtX8/sendInvoice",
            //CURLOPT_URL => "https://api.telegram.org/bot5336677272:AAGAUcyP_hFDbPB7m125ZChsQVlZMxTwdQw/setChatMenuButton",
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => http_build_query([
                'chat_id' => $chat,
                //'menu_button' => json_encode(['type' => 'web_app', 'text' => 'Покупки', 'web_app' => ['url' => 'https://api.myforce.ru/site/telega-test', 'text' => 'Покупки',]]),
                'title' => "{$name}",
                'description' => "Доступ - {$name}",
                'photo_url' => "https://api.myforce.ru/images/tg_info_{$id}.jpg",
                'photo_width' => "341",
                'photo_height' => "266",
                'payload' => "723421",
                'provider_token' => "401643678:TEST:cbafa692-5a67-4139-b7a6-260135671fce",
                'currency' => "RUB",
                'prices' => json_encode([
                    ['label' => 'Test', 'amount' => 19999 * 100]
                ]),
            ]),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HEADER => false
        ]);
        $rsp = curl_exec($ch);
        var_dump($rsp);
    }

    public function actionTestBot() {
        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_TIMEOUT => 3,
            CURLOPT_CONNECTTIMEOUT => 3,
            CURLOPT_URL => "https://api.telegram.org/bot5285653070:AAEo7dBLACQgufJakt2zQ65owa0do39HtX8/setChatMenuButton",
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => http_build_query([
                'menu_button' => json_encode(['type' => 'web_app', 'text' => 'Курсы', 'web_app' => ['url' => 'https://api.myforce.ru/site/telega-test2',]]),
            ]),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HEADER => false
        ]);
        $rsp = curl_exec($ch);
        var_dump($rsp);
    }



}