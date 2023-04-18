<?php


namespace common\models\helpers;


use common\models\Leads;
use Yii;
use yii\helpers\Html;

class CustomIntegration
{

    public static function use__integration($id, $lead) {
        switch ($id) {
            default:
                return null;
                break;
            case 648:
            case 853:
                return static::stop__dolg($lead);
                break;
            case 130:
            case 421:
            case 500:
            case 501:
            case 502:
            case 503:
            case 504:
            case 505:
            case 506:
            case 507:
            case 508:
            case 509:
            case 510:
            case 511:
            case 512:
            case 513:
            case 514:
            case 515:
            case 516:
            case 517:
            case 518:
            case 519:
            case 520:
            case 521:
            case 522:
            case 523:
            case 524:
            case 525:
            case 526:
            case 527:
            case 528:
            case 533:
            case 571:
            case 667:
            case 699:
            case 722:
            case 769:
            case 793:
                return static::vitakon($lead);
                break;
            case 165:
                return static::mega__crm($lead);
                break;
        }
    }

    /**
     * @param $lead Leads
     */
    private static function stop__dolg($lead) {
        $queryUrl = 'https://crm.stop-dolg.ru/crm/configs/import/lead.php';
        $curl = curl_init();
        $comms = '';
        if (!empty($lead->city))
            $comms .= "Город: {$lead->city}<br>";
        if (!empty($lead->params['sum']))
            $comms .= "Сумма долга: {$lead->params['sum']}<br>";
        curl_setopt($curl, CURLOPT_URL, $queryUrl);
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 10);
        curl_setopt($curl, CURLOPT_TIMEOUT, 30);
        curl_setopt($curl, CURLOPT_POSTFIELDS,
            array (
                'LOGIN' => 'Femida',
                'PASSWORD' => 'YRMT38EqR22NC~9',
                'TITLE' => $lead->name,
                'SOURCE_ID' => 33,
                'SOURCE_DESCRIPTION' => "Заявка",
                'STATUS_ID' => 'NEW',
                'NAME' => $lead->name,
                'PHONE_WORK' => $lead->phone,
                'UF_CRM_1480496139' => $lead->name,
                'UF_CRM_1493378815' => !empty($lead->city) ? $lead->city : $lead->region,
                'EMAIL_WORK' => $lead->email,
                'COMMENTS' => $comms
            ));
        $res = curl_exec($curl);
        curl_close($curl);
        if (!$res)
            $error = curl_error($curl).'('.curl_errno($curl).')';
        return empty($error) ? $res : ['status' => 'error', 'message' => $error];
    }

    /**
     * @param $lead Leads
     */
    private static function vitakon($lead) {
        $url = 'https://api.vitakon.ru:4443/leads/';
        $data100 = [
            "title"=> !empty("{$lead->name}") ? "{$lead->name}" : "Лид без имени",
            "phone"=> "{$lead->phone}",
            "comment"=> !empty("{$lead->comments}") ? "{$lead->comments}" : "Комментарии отсутствуют",
            "sid"=> "{$lead->id}",
            "utm_campaign"=> !empty("{$lead->utm_campaign}") ? "{$lead->utm_campaign}" : "Метка отсутствует",
        ];
        $data10 = [
            "token" => "52d8ed8ce5ae777bc3a832e4920879ef",
            "title"=> "{$data100['title']}",
            "phone"=> "{$lead->phone}",
            "comment"=> "{$data100['comment']}",
            "sid"=> "{$lead->id}",
            "utm_source"=> "femidaforce",
            "utm_campaign"=> "{$data100['utm_campaign']}",
            "utm_content"=> "",
            "utm_medium"=> "",
            "utm_term"=> "",
        ];
        $data_json = json_encode($data10, JSON_UNESCAPED_UNICODE);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json','Content-Length: ' . strlen($data_json)));
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
        curl_setopt($ch, CURLOPT_POSTFIELDS,$data_json);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, 1);
        $res = curl_exec($ch);
        curl_close($ch);
        if (!$res)
            $error = curl_error($ch).'('.curl_errno($ch).')';
        return empty($error) ? ['status' => 'success', 'rsp' => $res] : ['status' => 'error', 'message' => $error];
    }

    /**
     * @param $lead Leads
     */
    private static function mega__crm($lead) {
        $ch = curl_init();
        $part = "/v1/clients";
        $key = "c6129a4b4bd277470efdb33c09417efb27e98f38";
        $id = '2736779';
        $description = [
            "Регион: {$lead->region}",
            "Телефон: {$lead->phone}",
            "ФИО: {$lead->name}",
        ];
        if (!empty($lead->params['sum']))
            $description[] = "Сумма долга: {$lead->params['sum']}";
        $data = json_encode([
            [
                "name" => "LeadForce: {$lead->name}",
                "description" => implode("\n", $description),
                "doer_id" => 1254916,
                //"category_id" => 24607,
            ]
        ], JSON_UNESCAPED_UNICODE);
        $signature = ["POST", $part, '', $data, $key];
        $signature = hash('sha256', implode(':', $signature));
        curl_setopt_array($ch, [
            CURLOPT_URL => "https://api.megacrm.ru{$part}",
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => $data,
            CURLOPT_HTTPHEADER => [
                "Content-Type: application/json",
                "Content-Length: " . strlen($data),
                "X-MegaCrm-ApiAccount: {$id}",
                "X-MegaCrm-ApiSignature: {$signature}",
            ],
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CONNECTTIMEOUT => 10,
            CURLOPT_TIMEOUT => 10,
        ]);
        $res = curl_exec($ch);
        $array = json_decode($res, true);
        if (!$res)
            $error = curl_error($ch).'('.curl_errno($ch).')';
        return empty($error) && empty($array['errors']) ? ['status' => 'success', 'rsp' => $res] : ['status' => 'error', 'message' => $res];
    }



}