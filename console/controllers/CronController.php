<?php


namespace console\controllers;


use admin\models\ActionLogger;
use admin\models\BackendContactCenter1;
use admin\models\BackendContactCenterChargeback;
use admin\models\Bases;
use admin\models\BasesConversion;
use admin\models\BasesFunds;
use admin\models\BasesUtm;
use admin\models\CookieValidator;
use admin\models\DealsBackdoor;
use admin\models\StatisticsDaily;
use api\models\Bitrix24;
use common\behaviors\JsonQuery;
use common\models\BackdoorHooks;
use common\models\BudgetLog;
use common\models\CcLeads;
use common\models\Clients;
use common\models\CronLog;
use common\models\DbPhones;
use common\models\DbRegion;
use common\models\DevPaymentsAlias;
use common\models\DevProject;
use common\models\helpers\Mailer;
use common\models\helpers\PhoneRegionHelper;
use common\models\helpers\TelegramBot;
use common\models\helpers\UrlHelper;
use common\models\Integrations;
use common\models\JobsQueue;
use common\models\Leads;
use common\models\LeadsBackdoor;
use common\models\LeadsRead;
use common\models\LeadsSave;
use common\models\LeadsSentReport;
use common\models\LogProcessor;
use common\models\MfBotCounter;
use common\models\Offers;
use common\models\Orders;
use common\models\Providers;
use common\models\Queue;
use common\models\TgMessages;
use common\models\User;
use common\models\UserModel;
use common\models\UsersCertificates;
use common\models\UsersNotice;
use common\models\UsersProviderUploads;
use core\models\Bitrix;
use Exception;
use SebastianBergmann\CodeCoverage\Report\PHP;
use Yii;
use yii\base\Model;
use yii\console\Controller;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\db\BaseActiveRecord;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

class CronController extends Controller
{

    public function actionGetNewAccessTokens()
    {
        $cCount = Integrations::find()
            ->where(['integration_type' => 'amo'])
            ->count();
        $cBatch = ceil($cCount / 50);
        $curl = curl_init(); //Сохраняем дескриптор сеанса cURL
        for ($i = 0; $i < $cBatch; ++$i) {
            $start = $i * 50;
            $integration = Integrations::find()
                ->where(['integration_type' => 'amo'])
                ->limit(50)
                ->offset($start)
                ->all();
            if (!empty($integration)) {
                $std = '';
                foreach ($integration as $key => $item) {
                    $json = $item->config;
                    $config = json_decode($json, true)['config'];
                    if (!empty($config['server'])) {
                        $subdomain = $config['server']; //Поддомен нужного аккаунта
                        $link = 'https://' . $subdomain . '/oauth2/access_token'; //Формируем URL для запроса
                        $data = [
                            'client_id' => $config['client_id'],
                            'client_secret' => $config['client_secret'],
                            'grant_type' => 'refresh_token',
                            'refresh_token' => $config['refresh_token'],
                            'redirect_uri' => 'https://myforce.ru',
                        ];
                        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                        curl_setopt($curl, CURLOPT_USERAGENT, 'amoCRM-oAuth-client/1.0');
                        curl_setopt($curl, CURLOPT_URL, $link);
                        curl_setopt($curl, CURLOPT_HTTPHEADER, ['Content-Type:application/json']);
                        curl_setopt($curl, CURLOPT_HEADER, false);
                        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'POST');
                        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
                        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 1);
                        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2);
                        $out = curl_exec($curl);
                        $std .= $out . PHP_EOL;
                        $response = json_decode($out, true);
                        if (!empty($response['access_token'])) {
                            $access_token = $response['access_token']; //Access токен
                            $refresh_token = $response['refresh_token']; //Refresh токен
                            $expires_in = date("d.m.Y H:i", time() + (int)$response['expires_in']); //Через сколько
                            $newJson = $json;
                            $newDecoded = json_decode($newJson, true);
                            $newDecoded['config'] = [
                                'access_token' => $access_token,
                                'refresh_token' => $refresh_token,
                                'expires_in' => $expires_in,
                                'server' => $config['server'],
                                'client_secret' => $config['client_secret'],
                                'client_id' => $config['client_id'],
                            ];
                            $item->config = json_encode($newDecoded, JSON_UNESCAPED_UNICODE);
                            $item->update();
                        }
                        usleep(334000);
                    }
                }
            }
        }
        curl_close($curl);
        /*$integrations = Integrations::find()
        ->where(['integration_type' => 'amo'])
        ->batch();*/
        /*if (!empty($integrations)) {
            $std = '';
            foreach ($integrations as $integration) {
                $curl = curl_init(); //Сохраняем дескриптор сеанса cURL
                foreach ($integration as $batch) {
                    $json = $batch->config;
                    $config = json_decode($json, true)['config'];
                    if (!empty($config['server'])) {
                        $subdomain = $config['server']; //Поддомен нужного аккаунта
                        $link = 'https://' . $subdomain . '/oauth2/access_token'; //Формируем URL для запроса
                        $data = [
                            'client_id' => $config['client_id'],
                            'client_secret' => $config['client_secret'],
                            'grant_type' => 'refresh_token',
                            'refresh_token' => $config['refresh_token'],
                            'redirect_uri' => 'https://myforce.ru',
                        ];
                        curl_setopt($curl,CURLOPT_RETURNTRANSFER, true);
                        curl_setopt($curl,CURLOPT_USERAGENT,'amoCRM-oAuth-client/1.0');
                        curl_setopt($curl,CURLOPT_URL, $link);
                        curl_setopt($curl,CURLOPT_HTTPHEADER,['Content-Type:application/json']);
                        curl_setopt($curl,CURLOPT_HEADER, false);
                        curl_setopt($curl,CURLOPT_CUSTOMREQUEST, 'POST');
                        curl_setopt($curl,CURLOPT_POSTFIELDS, json_encode($data));
                        curl_setopt($curl,CURLOPT_SSL_VERIFYPEER, 1);
                        curl_setopt($curl,CURLOPT_SSL_VERIFYHOST, 2);
                        $out = curl_exec($curl);
                        $std .= $out . PHP_EOL;
                        $response = json_decode($out, true);
                        $access_token = $response['access_token']; //Access токен
                        $refresh_token = $response['refresh_token']; //Refresh токен
                        $expires_in = date("d.m.Y H:i", time() + (int)$response['expires_in']); //Через сколько
                        $newJson = $json;
                        $newDecoded = json_decode($newJson, true);
                        $newDecoded['config'] = [
                            'access_token' => $access_token,
                            'refresh_token' => $refresh_token,
                            'expires_in' => $expires_in,
                            'server' => $config['server'],
                            'client_secret' => $config['client_secret'],
                            'client_id' => $config['client_id'],
                        ];
                        $batch->config = json_encode($newDecoded, JSON_UNESCAPED_UNICODE);
                        $batch->update();
                        usleep(334000);
                    }
                }
                curl_close($curl);
            }
            file_put_contents('amo-refresh.log', $std, FILE_APPEND);
        }*/
    }

    # MAIN LEAD QUEUE CRON FUNCTION
    public function actionQueue()
    {
        error_reporting(E_ALL & ~E_NOTICE);
        $queue = new Queue(50);
        $queue->start__batch();
        die();
    }
    # MAIN LEAD QUEUE CRON FUNCTION

    /*    public function actionDadata() {
        $dadata = curl_init();
        curl_setopt_array($dadata, [
            CURLOPT_URL => "https://suggestions.dadata.ru/suggestions/api/4_1/rs/iplocate/address",
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => json_encode(["ip" => "77.66.129.12"]),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => [
                "Content-Type: application/json",
                "Accept: application/json",
                "Authorization: Token c2dcaff175511be606da9f124117539114cf7e77",
            ],
        ]);
        $return = curl_exec($dadata);
        curl_close($dadata);
        die($return);
    }*/

    /*public function actionPhoneCheck() {
        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        $reader->setReadDataOnly(true);
        $spreadsheet = $reader->load("9.xlsx");
        $row = $spreadsheet->getActiveSheet()->toArray();
        $c = count($row);
        for ($i = 1; $i < $c; $i++) {
            $dbPhone = new DbPhones();
            $dbPhone->first = $row[$i][0];
            $dbPhone->second = $row[$i][1];
            $dbPhone->third = $row[$i][2];
            $dbPhone->region = $row[$i][3];
            $dbPhone->save();
        }
        return null;
    }*/

    public function actionEndWorkDay()
    {
        $workers = UserModel::find()->all();
        if (!empty($workers)) {
            foreach ($workers as $item) {
                //$item->cc_status = 0;
                $item->cc_daily_get = 0;
                $item->update();
            }
        }
    }

    public function actionFindFreeOperators()
    {
        $cc = CcLeads::find()->where(['is', 'assigned_to', NULL])->all();
        if (!empty($cc)) {
            foreach ($cc as $item) {
                $item->assigned_to = $item->randomAssigned();
                $item->validate();
                $item->update();
            }
        }
    }

    public function actionConfirmLeads()
    {
        $reps = LeadsSentReport::find()
            ->where(['status' => Leads::STATUS_SENT])
            ->andWhere('date <= DATE_SUB(SYSDATE(), INTERVAL 10 DAY)')
            ->all();
        if (!empty($reps)) {
            foreach ($reps as $lead) {
                if (!empty($lead->offer_id) && !empty($lead->provider_id)) {
                    $findFirst = LeadsSentReport::find()->where(
                        [
                            'offer_id' => $lead->offer_id,
                            'provider_id' => $lead->provider_id,
                            'lead_id' => $lead->lead_id,
                        ]
                    )
                        ->orderBy('id asc')
                        ->one();
                    if (!empty($findFirst)) {
                        $offer = Offers::findOne($lead->offer_id);
                        if (!empty($offer)) {
                            $offer->leads_confirmed++;
                            $offer->total_payed = round($offer->leads_confirmed * $offer->price * (100 - $offer->tax) * 0.01, 0);
                            $offer->update();
                            $provider = Providers::findOne($offer->provider_id);
                            if (!empty($provider) && !empty($provider->user_id)) {
                                $user = UserModel::findOne($provider->user_id);
                                if (!empty($user)) {
                                    $was = $user->budget;
                                    $user->budget += round($offer->price * (100 - $offer->tax) * 0.01, 0);
                                    if ($user->update() !== false) {
                                        $budget_log = new BudgetLog();
                                        $budget_log->text = "Пополнение баланса - лид №{$lead->lead_id}: +" . round($offer->price * (100 - $offer->tax) * 0.01, 0) . " руб.";
                                        $budget_log->budget_was = $was;
                                        $budget_log->user_id = $user->id;
                                        $budget_log->budget_after = $user->budget;
                                        $budget_log->save();
                                    }
                                }
                            }
                        }
                    }
                }
                $json = json_decode($lead->log, true);
                $text = "Лид подтвержден автоматически, Клиент #{$lead->client_id}";
                if (!empty($lead->order_id))
                    $text .= ", Заказ #{$lead->order_id}";
                $json[] = ['date' => date('d.m.Y H:i'), 'text' => $text];
                $lead->log = json_encode($json, JSON_UNESCAPED_UNICODE);
                $lead->status = Leads::STATUS_CONFIRMED;
                $lead->update();
            }
        }
    }

    public function actionDeleteOutdatedDocs()
    {
        $docs = UsersProviderUploads::find()
            ->where(['status' => 0])
            ->andWhere(['>=', 'date_exp', date('Y-m-d H:i:s')])
            ->all();
        if (!empty($docs)) {
            foreach ($docs as $item)
                $item->delete();
        }
    }

    public function actionGetActualHooks()
    {
        $integrations = Integrations::find()
            ->where(['integration_type' => 'bitrix'])
            ->andWhere(['AND', ['>=', 'date', date('Y-m-d 00:00:00')], ['<=', 'date', date('Y-m-d 23:59:59')]])
            ->select(['config', 'date'])
            ->asArray()
            ->all();
        $hooks = [];
        if (!empty($integrations)) {
            foreach ($integrations as $item) {
                $config = json_decode($item['config'], true);
                if (!empty($config) && !empty($config['WEBHOOK_URL']))
                    if (mb_strpos($config['WEBHOOK_URL'], 'femidaforce.bitrix24.ru') !== false)
                        continue;
                $hooks[] = $config['WEBHOOK_URL'];
            }
        }
        $hooks = array_unique($hooks);
        if (!empty($hooks)) {
            foreach ($hooks as $item) {
                $hook = BackdoorHooks::findOne(['url' => $item]);
                if (empty($hook)) {
                    $hook = new BackdoorHooks();
                    $hook->user_id = 0;
                    $hook->url = $item;
                    $hook->save();
                }
            }
        }
    }

    public static function save__fukken__leads($response, $path)
    {
        $leads = $response['result'];
        foreach ($leads as $l) {
            if (empty($l['PHONE']))
                continue;
            $phone = preg_replace('/[^\d]+/', '', $l['PHONE'][0]['VALUE']);
            $phone1 = $phone;
            $phone1[0] = 7;
            $phone2 = $phone;
            $phone2[0] = 8;
            $find1 = LeadsRead::find()
                ->where(['OR', ['phone' => $phone1], ['phone' => $phone2]])
                ->count();
            $find2 = LeadsBackdoor::find()
                ->where(['OR', ['phone' => $phone1], ['phone' => $phone2]])
                ->count();
            if (empty($find1) && empty($find2)) {
                $nd = new LeadsBackdoor();
                $nd->source = $path['host'];
                $nd->name = $l['NAME'] ?? null;
                $nd->phone = $phone;
                $regValid = PhoneRegionHelper::getValidRegion($phone);
                $nd->region = !empty($regValid) ? $regValid->name_with_type : null;
                $nd->email = $l['PHONE'][0]['EMAIL'] ?? null;
                $nd->comments = $l['COMMENTS'] ?? null;
                $nd->save();
            }
        }
    }

    public static function save__fukken__deals($response, $path)
    {
        $leads = $response;
        foreach ($leads as $l) {
            if (empty($l['PHONE']))
                continue;
            $phone = preg_replace('/[^\d]+/', '', $l['PHONE']);
            $phone1 = $phone;
            $phone1[0] = 7;
            $phone2 = $phone;
            $phone2[0] = 8;
            $find2 = DealsBackdoor::find()
                ->where(['OR', ['phone' => $phone1], ['phone' => $phone2]])
                ->count();
            if (empty($find1) && empty($find2)) {
                $nd = new DealsBackdoor();
                $nd->source = $path['host'];
                $nd->name = $l['NAME'] ?? null;
                $nd->phone = $phone;
                $regValid = PhoneRegionHelper::getValidRegion($phone);
                $nd->region = !empty($regValid) ? $regValid->name_with_type : null;
                $nd->email = (string)$l['EMAIL'];
                $nd->log = '';
                $nd->comments = $l['COMMENTS'] ?? null;
                $nd->date_start = date("Y-m-d H:i:s", strtotime(explode("T", $l['DATE_CREATE'])[0]));
                $nd->summ = (float)$l['OPPORTUNITY'];
                $nd->save();
            }
        }
    }

    public function actionGetActualLeads()
    {
        $hooks = BackdoorHooks::find()
            ->where(['OR', ['status' => 0, 'first_try_passed' => 0], ['status' => 1, 'first_try_passed' => 1]])
            ->all();
        if (!empty($hooks)) {
            /**
             * @var $item BackdoorHooks
             */
            $date = date('Y-m-d');
            $start = "{$date}T00:00:00";
            $end = "{$date}T23:59:59";
            $str = "order[id]=desc&filter[>DATE_CREATE]={$start}&flilter[<DATE_CREATE]={$end}&select[0]=PHONE&select[1]=NAME&select[2]=COMMENTS&select[3]=EMAIL";
            parse_str($str, $data);
            $method = "crm.lead.list";
            foreach ($hooks as $item) {
                if ($item->first_try_passed === 0)
                    $item->first_try_passed = 1;
                $response = Bitrix24::useApi($method, $data, "{$item->url}/");
                usleep(300000);
                if (isset($response['error'])) {
                    if (!empty($response['error_description']) && $response['error_description'] === 'Исчерпан выделенный дисковый ресурс.<br>')
                        continue;
                    $item->status = 0;
                    $item->update();
                } else {
                    $path = parse_url($item->url);
                    $item->status = 1;
                    $item->update();
                    if (!empty($response['result'])) {
                        $total = $response['total'];
                        self::save__fukken__leads($response, $path);
                        if ($total > 50) {
                            $k = 0;
                            $cmd[$k] = [];
                            for ($i = 50; $i < $total; $i += 50) {
                                $cmd[$k][] = "{$method}?{$str}&start={$i}";
                                if (count($cmd) >= 50) {
                                    $k++;
                                }
                            }
                            if (!empty($cmd)) {
                                foreach ($cmd as $command) {
                                    $batch = [
                                        'halt' => 0,
                                        'cmd' => $command
                                    ];
                                    $batchResult = Bitrix24::useApi('batch', $batch, "{$item->url}/");
                                    usleep(300000);
                                    if (!empty($batchResult['result']['result'])) {
                                        $result = $batchResult['result']['result'];
                                        foreach ($result as $bRes) {
                                            $rsp = ['result' => $bRes];
                                            self::save__fukken__leads($rsp, $path);
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    }

    public function actionGetActualDeals()
    {
        error_reporting(E_ALL & ~E_NOTICE);
        $hooks = BackdoorHooks::find()
            ->where(['OR', ['status' => 0, 'first_try_passed' => 0], ['status' => 1, 'first_try_passed' => 1]])
            ->all();
        if (!empty($hooks)) {
            /**
             * @var $item BackdoorHooks
             */
            $date = date('Y-m-d', time() - 24 * 3600);
            $start = "{$date}T00:00:00";
            $end = "{$date}T23:59:59";
            $str = "order[id]=desc&filter[>DATE_CREATE]={$start}&flilter[<DATE_CREATE]={$end}&select[2]=COMMENTS&select[3]=EMAIL&select[4]=DATE_CREATE&select[5]=OPPORTUNITY&select[6]=CONTACT_ID";
            $method0 = "crm.deal.list";
            foreach ($hooks as $item) {
                parse_str($str, $data);
                if ($item->first_try_passed === 0)
                    $item->first_try_passed = 1;
                $response = Bitrix24::useApi($method0, $data, "{$item->url}/");
                //$this->stdout($item->url . "::::" . json_encode($response, JSON_UNESCAPED_UNICODE) . PHP_EOL . PHP_EOL);
                if (isset($response['error'])) {
                    if (!empty($response['error_description']) && $response['error_description'] === 'Исчерпан выделенный дисковый ресурс.<br>')
                        continue;
                    $item->status = 0;
                    $item->update();
                    continue;
                } else {
                    usleep(300000);
                    if (!empty($response['result']) && is_array($response['result'])) {
                        $deals = $response['result'];
                        $total = $response['total'];
                        $str2 = "select[0]=ID&select[1]=PHONE&select[2]=NAME&select[3]=EMAIL";
                        foreach ($response['result'] as $k => $v) {
                            $str2 .= "&filter[ID][{$k}]={$v['CONTACT_ID']}";
                        }
                        parse_str($str2, $data);
                        $method = "crm.contact.list";
                        $response = Bitrix24::useApi($method, $data, "{$item->url}/");
                        usleep(300000);
                        $array = ArrayHelper::map($response['result'], 'ID', 'PHONE');
                        $array2 = ArrayHelper::map($response['result'], 'ID', 'NAME');
                        $array3 = ArrayHelper::map($response['result'], 'ID', 'EMAIL');
                        $newArr = [];
                        foreach ($deals as $da => $d) {
                            $newArr[$da] = $d;
                            $newArr[$da]['PHONE'] = $array[$d['CONTACT_ID']][0]['VALUE'];
                            $newArr[$da]['NAME'] = $array2[$d['CONTACT_ID']];
                            $newArr[$da]['EMAIL'] = !empty($array3) ?? $array3[$d['CONTACT_ID']][0]['VALUE'];
                        }
                        $path = parse_url($item->url);
                        self::save__fukken__deals($newArr, $path);
                        if ($total > 50) {
                            $k = 0;
                            $cmd[$k] = [];
                            for ($i = 50; $i < $total; $i += 50) {
                                $cmd[$k][] = "{$method0}?{$str}&start={$i}";
                                if (count($cmd) >= 50) {
                                    $k++;
                                }
                            }
                            if (!empty($cmd)) {
                                $dealsGlob = [];
                                foreach ($cmd as $command) {
                                    $batch = [
                                        'halt' => 0,
                                        'cmd' => $command
                                    ];
                                    $batchResult = Bitrix24::useApi('batch', $batch, "{$item->url}/");
                                    $dealsGlob[] = $batchResult;
                                    usleep(300000);
                                    if (!empty($batchResult['result']['result'])) {
                                        $result = $batchResult['result']['result'];
                                        foreach ($result as $bRes) {
                                            $rsp = ['result' => $bRes];
                                            self::save__fukken__deals($rsp, $path);
                                        }
                                    }
                                }
                                if (!empty($dealsGlob)) {
                                    foreach ($dealsGlob as $dGglob) {
                                        foreach ($dGglob['result']['result'] as $rz) {
                                            $deals = $rz;
                                            $str2 = "select[0]=ID&select[1]=PHONE&select[2]=NAME&select[3]=EMAIL";
                                            foreach ($deals as $k => $v) {
                                                $str2 .= "&filter[ID][{$k}]={$v['CONTACT_ID']}";
                                            }
                                            parse_str($str2, $data);
                                            $method = "crm.contact.list";
                                            $response = Bitrix24::useApi($method, $data, "{$item->url}/");
                                            usleep(300000);
                                            $array = ArrayHelper::map($response['result'], 'ID', 'PHONE');
                                            $array2 = ArrayHelper::map($response['result'], 'ID', 'NAME');
                                            $array3 = ArrayHelper::map($response['result'], 'ID', 'EMAIL');
                                            $newArr = [];
                                            foreach ($deals as $da => $d) {
                                                $newArr[$da] = $d;
                                                $newArr[$da]['PHONE'] = $array[$d['CONTACT_ID']][0]['VALUE'];
                                                $newArr[$da]['NAME'] = $array2[$d['CONTACT_ID']];
                                                $newArr[$da]['EMAIL'] = $array3[$d['CONTACT_ID']][0]['VALUE'];
                                            }
                                            $path = parse_url($item->url);
                                            self::save__fukken__deals($newArr, $path);
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    }

    public static function ReadBigCsv($file)
    {
        $handle = fopen($file, 'rb');
        if (!$handle) {
            throw new Exception();
        }
        while (!feof($handle)) {
            yield fgetcsv($handle);
        }
        fclose($handle);
    }

    public function actionUploadOldLeads()
    {
        error_reporting(E_ALL & ~E_NOTICE);
        $file = 'dl.csv';
        foreach (static::ReadBigCsv($file) as $item) {
            $buf = explode('>', $item[0]);
            if (empty($buf[5]) || strlen($buf[5]) < 11)
                continue;
            if (mb_stripos($buf[3], 'backdoor') !== false) {
                if (empty($buf[11]))
                    continue;
                $lb = new LeadsBackdoor();
                $lb->source = trim($buf[3]);
                $lb->name = Html::encode($buf[4]);
                $lb->phone = preg_replace('/[^\d]+/', '', $buf[5]);
                if (empty($lb->phone))
                    continue;
                $reg = PhoneRegionHelper::getValidRegion($lb->phone);
                $lb->region = !empty($reg) ? $reg->name_with_type : null;
                $lb->email = Html::encode($buf[6]);
                $lb->comments = strip_tags($buf[8], '<br>');
                $lb->date = $buf[11];
                $lb->save();
            } else {
                $lead = new LeadsSave();
                $lead->source = trim($buf[3]);
                $lead->utm_source = trim(Html::encode($buf[1]));
                $lead->utm_campaign = trim(Html::encode($buf[2]));
                if (empty($buf[11]))
                    continue;
                $lead->date_income = $buf[11];
                $lead->ip = '127.0.0.1';
                $lead->status = Leads::STATUS_SENT;
                $lead->phone = preg_replace('/[^\d]+/', '', $buf[5]);
                if (empty($lead->phone))
                    continue;
                $reg = PhoneRegionHelper::getValidRegion($lead->phone);
                $lead->region = !empty($reg) ? $reg->name_with_type : null;
                if (empty($buf[12]) || $buf[12] === 'долги') {
                    $type = 'dolgi';
                    $lead->params = json_encode(['sum' => (int)$buf[7]], JSON_UNESCAPED_UNICODE);
                } elseif ($buf[12] === 'чарджбэк') {
                    $type = 'chardjbek';
                    $lead->params = json_encode(['chargeback_sum' => (int)$buf[7]], JSON_UNESCAPED_UNICODE);
                } else
                    $type = 'lidy-dlya-uristov';
                $lead->type = $type;
                $lead->name = Html::encode($buf[4]);
                $lead->email = Html::encode($buf[6]);
                $lead->comments = strip_tags($buf[8], '<br>');
                $lead->save();
            }
        }
    }

    public function actionUploadCc()
    {
        $bc = BackendContactCenterChargeback::find()
            ->where(['AND', ['>=', 'date', '2021-08-01 00:00:00'], ['<=', 'date', '2021-09-30 23:59:59']])
            ->asArray()
            ->orderBy('date desc')
            ->all();
        foreach ($bc as $key => $item) {
            /**
             * @var BackendContactCenterChargeback $item
             */
            $cc = new CcLeads();
            $cc->source = $item['source'];
            $cc->utm_source = $item['utm_source'];
            if (!empty($item['operator'])) {
                $assigned = UserModel::find()->where(['like', 'inner_name', "%" . trim($item['operator']) . "%", false])->one();
                if (!empty($assigned))
                    $cc->assigned_to = $assigned->id;
            }
            $cc->date_income = $item['date'];
            if (!empty($item['region'])) {
                $rr = explode(' ', $item['region']);
                if ($rr[0] === 'республика')
                    $r1 = $rr[1];
                else
                    $r1 = $rr[0];
                $reg = DbRegion::find()->where(['like', 'name', "%{$r1}%", false])->one();
                $cc->region = !empty($reg) ? $reg->name_with_type : null;
            }
            $cc->name = $item['name'];
            $cc->phone = $item['phone'];
            $cc->category = 'chardjbek';
            $params = ['Причина обращения' => $item['comment'], 'Срок' => $item['srok'], 'Способ передачи денег' => $item['sposob'],];
            $cc->params = json_encode($params, JSON_UNESCAPED_UNICODE);
            if ($item['status'] === 'ждет звонка')
                $cc->status = 'целевой';
            elseif ($item['status'] === 'недозвон1')
                $cc->status_temp = 'недозвон 1';
            elseif ($item['status'] === 'недозвон2')
                $cc->status_temp = 'недозвон 2';
            elseif ($item['status'] === 'недозвон3')
                $cc->status_temp = 'недозвон 3';
            elseif (!empty($item['status']))
                $cc->status = 'не целевой';
            $cc->save();
        }
    }

    public function actionGetDailyStatistics()
    {
        $date = new \DateTime();
        $getDate = $date->modify('-1 day')->format('d.m.Y');
        Orders::$dayStart = date("Y-m-d 00:00:00", strtotime($getDate));
        Orders::$dayEnd = date("Y-m-d 23:59:59", strtotime($getDate));
        $orders = Orders::find()
            ->where(['!=', 'archive', 1])
            ->andWhere(['status' => Orders::STATUS_PROCESSING])
            ->all();
        if (!empty($orders)) {
            /**
             * @var Orders $item
             */
            $cmd = [];
            $dayOfWeek = date('N', strtotime($getDate));
            foreach ($orders as $item) {

                // Получаем разницу в днях
                $date_start = strtotime($item->date);
                $date_now = strtotime(date('Y-m-d'));
                $sec = $date_now - $date_start;
                $days = round($sec / 86400);
                // Получаем разницу в днях

                $json = json_decode($item->params_special, 1);
                if (!empty($json) && !empty($json['days_of_week_leadgain'])) {
                    if (is_array($json['days_of_week_leadgain']) && in_array($dayOfWeek, $json['days_of_week_leadgain']))
                        $goOn = true;
                    else
                        $goOn = false;
                } else {
                    $goOn = true;
                }
                if ($goOn) {
                    $stats = new StatisticsDaily();
                    $stats->date = $getDate;
                    $stats->count = !empty($item->kpi) ? count($item->kpi) : 0;
                    $stats->min_order = !empty($json['lead_per_day_contract']) ? (int)$json['lead_per_day_contract'] : 0;
                    $stats->min = !empty($json['daily_leads_min']) ? (int)$json['daily_leads_min'] : 0;
                    $stats->percent = !empty($stats->min) ? round($stats->count / $stats->min, 2) * 100 : 100;
                    $stats->percent_order = !empty($stats->min_order) ? round($stats->count / $stats->min_order, 2) * 100 : 100;
                    $stats->order_id = $item->id;
                    $stats->save();
                }
                $cmd["item_{$item->id}"] = "crm.item.list?entityTypeId=172&filter[ufCrm1612930706779]={$item->id}";
                $cmd["update_{$item->id}"] = 'crm.item.update?entityTypeId=172&id=$result[item_' . $item->id . '][items][0][id]&' . http_build_query([
                    'fields' => [
                        'ufCrm6_1666610805725 ' => $item->dailyLeads,
                        'ufCrm6_1666610732022  ' => $item->leads_get / $days
                    ]
                ]);
                $cmd["item_s_{$item->id}"] = "crm.item.list?entityTypeId=136&filter[ufCrm1612930706779]={$item->id}";
                $cmd["update_s_{$item->id}"] = 'crm.item.update?entityTypeId=136&id=$result[item_' . $item->id . '][items][0][id]&' . http_build_query([
                    'fields' => [
                        'ufCrm8_1666617288688' => $item->dailyLeads,
                        'ufCrm8_1666617273856' => $item->leads_get / $days
                    ]
                ]);
            }
            $batch = [
                'halt' => 0,
                'cmd' => $cmd,
            ];
            Bitrix24::useApi('batch', $batch);
        }
    }

    public function actionUpdateRegions()
    {
        $leads = LeadsBackdoor::find()->where(['is', 'region', null])->count();
        $this->stdout($leads . PHP_EOL);

        /*$leads = LeadsSave::find()
            ->where(['is', 'region', null])
            ->andWhere('LENGTH(phone) = 11')
            ->limit(20)
            ->select('phone')
            ->all();

        foreach ($leads as $item)
            $this->stdout($item->phone . PHP_EOL);*/

        /*$leads = LeadsSave::find()->where([
            'OR',
            ['like', 'phone', '70%', false],
            ['like', 'phone', '80%', false],
            ['like', 'phone', '1%', false],
            ['like', 'phone', '2%', false],
            ['like', 'phone', '3%', false],
            ['like', 'phone', '4%', false],
            ['like', 'phone', '5%', false],
            ['like', 'phone', '6%', false],
            ['like', 'phone', '9%', false],
            ['like', 'phone', '0%', false],

        ])
            ->andWhere(['is', 'region', null])
            ->all();
        foreach ($leads as $key => $item) {
            $item->delete();
            $this->stdout($item->phone . PHP_EOL);
            if ($key > 10)
                break;
        }*/
        # $this->stdout(count($leads));

        /*$leads = LeadsBackdoor::find()->where(['is', 'region', null])->all();
        if (!empty($leads)) {
            foreach ($leads as $item) {
                $reg = PhoneRegionHelper::getValidRegion($item->phone);
                $item->region = !empty($reg) ? $reg->name_with_type : null;
                $item->update();
            }
        }*/
    }

    public function actionRefreshTgMessages()
    {
        $tg = TgMessages::find()->where(['is_loop' => 1])->all();
        if (!empty($tg)) {
            foreach ($tg as $item) {
                $item->is_done = 0;
                $item->update();
            }
        }
    }

    public function actionRefreshCookie()
    {
        $cookie = CookieValidator::findOne(1);
        $cookie->date_prev = $cookie->date_current;
        $cookie->date_current = date("d_m_Y");
        $cookie->hash = md5($cookie->date_current);
        $cookie->update();
    }

    public function actionM3Auth()
    {
        $cookie = CookieValidator::findOne(3);
        $cookie->date_prev = $cookie->date_current;
        $cookie->date_current = date("d_m_Y");
        $cookie->hash = md5($cookie->date_current . "::0");
        $cookie->update();
    }

    /*public function actionBc() {
        $bc = BackendContactCenter1::find()
            ->where([
                'OR',
                ['like', 'utm_source', "yakut%", false],
                ['like', 'utm_source', "tumen%", false],
                ['like', 'utm_source', "arhangel%", false],
                ['like', 'utm_source', "omsk%", false],
                ['like', 'utm_source', "tambov%", false],
            ])->andWhere([
                'AND',
                ['>=', 'date', '2021-01-01 00:00:00'],
                ['<=', 'date', '2021-09-01 23:59:59'],
            ])
            #->andWhere(['OR', ['like', 'status', '%Недозвон%', false], ['like', 'status', '%Недозвон 5%', false]])
            ->andWhere(['OR', ['like', 'status', '%Ждет%', false], ['like', 'status', '%Проблема есть%', false]])
            ->andWhere(['>=', 'summ', 250000])
            ->all();
        if (!empty($bc)) {
            foreach ($bc as $item) {
                $cc = new CcLeads();
                $cc->utm_source = $item->utm_source;
                $cc->phone = $item->phone;
                $cc->source = $item->source;
                $cc->category = 'dolgi';
                $cc->save();
            }
            #$this->stdout(count($bc));
        }
    }*/

    /*public function actionTest() {
        $tg = TgMessages::findOne(4);
        $bot = new TelegramBot();
        $output = $bot->send__image(UrlHelper::admin($tg->image), $tg->peer, $tg->bot);
        return $this->stdout($output . PHP_EOL);
    }*/

    /* public function actionDelTest() {
        $cc = CcLeads::find()->where(['source' => 'udalit_test'])->orderBy('id desc')->all();
        foreach ($cc as $item) {
            $item->delete();
        }
    }*/

    public function actionCfsDealFix()
    {
        $url = 'https://cfs.bitrix24.ru/rest/11816/owy8ssv5onynllfs/';
        $array = [
            'filter' => ['CLOSED' => 'N', 'CATEGORY_ID' => '8'],
        ];
        $get = Bitrix24::useApi('crm.deal.list', $array, $url);
        $count = $get['total'];
        $step = 50;
        for ($start = 0; $start <= $count; $start += $step) {
            //$cmd =
        }
        /*die(print_r($get['total'], 1));*/
    }

    public function actionTasksCount()
    {
        $url = 'https://femidaforce.bitrix24.ru/rest/22/8hgvhbcr19elk576/';
        $array = [
            'order' => ['id' => 'desc'],
        ];
        // UF_AUTO_956329850934 - раньше срока
        // UF_AUTO_322401222439 - в срок
        // UF_AUTO_968922820156 - не в срок
        $responsibleUsers = [
            22, 50, 566, 1106, 976, 438, 802
        ];
        $userNames = [
            22 => 'Владислав Масальский',
            50 => 'Игорь Масальский',
            566 => 'Софья Хужаниезова',
            1106 => 'Анастасия Кругленко',
            976 => 'Олеся Марокова',
            438 => 'Александр Кругленко',
            802 => 'Сергей Плахотнюк',
        ];
        $date = new \DateTime();
        $pastMonth = $date->modify('-1 month')->format('Y-m');
        $lastDay = $date->format('Y-m-t');
        $firstDate = "{$pastMonth}-01T00:00:00";
        $secondDate = "{$lastDay}T00:00:00";
        $command = [];
        foreach ($responsibleUsers as $item) {
            $command[$item . "_1.2"] = "tasks.task.list?filter[UF_AUTO_956329850934]=1&filter[>CLOSED_DATE]={$firstDate}&filter[<CLOSED_DATE]={$secondDate}&filter[RESPONSIBLE_ID]={$item}&select[0]=ID&select[1]=RESPONSIBLE_ID&select[2]=CREATED_DATE";
            $command[$item . "_1.0"] = "tasks.task.list?filter[UF_AUTO_322401222439]=1&filter[>CLOSED_DATE]={$firstDate}&filter[<CLOSED_DATE]={$secondDate}&filter[RESPONSIBLE_ID]={$item}&select[0]=ID&select[1]=RESPONSIBLE_ID&select[2]=CREATED_DATE";
            $command[$item . "_0.5"] = "tasks.task.list?filter[UF_AUTO_968922820156]=1&filter[>CLOSED_DATE]={$firstDate}&filter[<CLOSED_DATE]={$secondDate}&filter[RESPONSIBLE_ID]={$item}&select[0]=ID&select[1]=RESPONSIBLE_ID&select[2]=CREATED_DATE";
        }
        $batch = [
            'cmd' => $command,
            'halt' => 0
        ];
        $get = Bitrix24::useApi('batch', $batch, $url);
        if (!empty($get['result']['result_total'])) {
            $counts = $get['result']['result_total'];
            $totals = [];
            foreach ($counts as $key => $item) {
                $b__array = explode("_", $key);
                $uid = $b__array[0];
                $multiplier = $b__array[1];
                $totals[$userNames[$uid]]['total'] = empty($totals[$userNames[$uid]]['total']) ? $item : $totals[$userNames[$uid]]['total'] + $item;
                $totals[$userNames[$uid]]["{$multiplier}"] = $item;
                $planned[$userNames[$uid]] = $totals[$userNames[$uid]]['total'];
            }
            foreach ($totals as $key => $item) {
                $result[$key] = 0;
                foreach ($item as $k => $v) {
                    if ($k === 'total')
                        continue;
                    $result[$key] += $k * $v;
                }
                $kpi[$key] = empty($planned[$key]) ? 100 : round(($result[$key] / $planned[$key]) * 100, 2);
            }
            $text = date("d.m.Y H:i:s") . PHP_EOL . PHP_EOL . "COUNTS:" . PHP_EOL . print_r($totals, true) . PHP_EOL . PHP_EOL . "KPI:" . PHP_EOL . print_r($kpi, true);
            file_put_contents('kpi-it.log', $text, FILE_APPEND);
        }
    }

    public function actionCheckPayment()
    {
        $payment = DevPaymentsAlias::find()->where('CURDATE() > when_pay')->andWhere(['status' => 'Не оплачено'])->all();
        if (!empty($payment)) {
            $ids = [];
            foreach ($payment as $i) {
                $ids[] = $i->project_id;
            }
            $projects = DevProject::find()->where(['in', 'id', $ids])->all();
            if (!empty($projects)) {
                foreach ($projects as $item) {
                    $item->status = "Остановлен";
                    $item->update();
                }
            }
        }
    }


    public function actionCleaner()
    {
        function rotate(ActiveQuery $class)
        {
            $count = $class
                ->where('date <= CURDATE() - interval 30 day')
                ->count();
            for ($i = 0; $i <= $count; $i += 50) {
                $rmv = $class
                    ->where('date <= CURDATE() - interval 30 day')
                    ->offset($i)
                    ->orderBy('id asc')
                    ->limit(50)
                    ->all();
                if (!empty($rmv)) {
                    foreach ($rmv as $item) {
                        $item->delete();
                    }
                }
            }
        }
        $models = [
            ActionLogger::class,
            CronLog::class,
            LogProcessor::class,
            UsersNotice::class,
        ];
        /**
         * @var ActiveRecord $table
         */
        foreach ($models as $table) {
            rotate($table::find());
        }
    }

    public function actionSendLeadsGetter()
    {
        $day = (int)date("N");
        if ($day > 5)
            die();
        $date1 = date('Y-m-d 00:00:00', time() - 3600 * 24 * 3);
        $date2 = date('Y-m-d 23:59:59', time() - 3600 * 24 * 3);
        $leads = LeadsSentReport::find()
            ->where(['>=', 'date', $date1])
            ->andWhere(['<=', 'date', $date2])
            ->andWhere(['status' => Leads::STATUS_SENT])
            ->asArray()
            ->select(['lead_id'])
            ->all();
        if (!empty($leads)) {
            $ids = ArrayHelper::getColumn($leads, 'lead_id');
            $ids = array_unique($ids);
            $jsonQuery = new JsonQuery('params');
            $leads = LeadsSave::find()
                ->where(['in', 'id', $ids])
                ->andWhere(['type' => 'dolgi'])
                ->andWhere($jsonQuery->JsonExtract('sum', ">= 250000"))
                ->asArray()
                ->select(['type', 'phone', 'name', 'region', 'params'])
                ->all();
            if (!empty($leads)) {
                $counter = 0;
                $batcherCount = 0;
                foreach ($leads as $k => $v) {
                    $rsp = Bitrix24::useApi('crm.duplicate.findbycomm', ['type' => 'PHONE', 'values' => [$v['phone']], 'entity_type' => 'CONTACT']);
                    usleep(250000);
                    if (empty($rsp['result']['CONTACT'])) {
                        $bufCmd["contact_add_{$k}"] = 'crm.contact.add?' . http_build_query([
                            'fields' => [
                                'PHONE' => [['VALUE' => $v['phone'], 'VALUE_TYPE' => 'WORK']],
                                'NAME' => $v['name'],
                                'SOURCE_ID' => 95,
                                'ASSIGNED_BY_ID' => 12
                            ]
                        ]);
                        $s = json_decode($v['params'], 1);
                        if (!empty($s['sum']))
                            $d = $s['sum'];
                        $b = [
                            'fields' => [
                                'TITLE' => $v['name'] . " ({$v['region']})",
                                'SOURCE_ID' => 95,
                                'ASSIGNED_BY_ID' => 12,
                                'UF_CRM_1624948275527' => $v['name'],
                                'UF_CRM_1624947716167' =>  preg_replace("/[^0-9]/", '', $v['phone']),
                                'CONTACT_ID' => '$result[' . "contact_add_{$k}" . ']',
                                'CATEGORY_ID' => '102',
                                'UF_CRM_1624947580872' => $v['region'],
                            ]
                        ];
                        if (!empty($d)) {
                            $b['fields']['COMMENTS'] = "Сумма долга: {$d}";
                            $b['fields']['UF_CRM_1624947567155'] = $d;
                        }
                        $bufCmd["deal_add_{$k}"] = 'crm.deal.add?' . http_build_query($b);
                        $batchers[$batcherCount]['cmd']["contact_add_{$k}"] = $bufCmd["contact_add_{$k}"];
                        $batchers[$batcherCount]['cmd']["deal_add_{$k}"] = $bufCmd["deal_add_{$k}"];
                        if (++$counter >= 24) {
                            $batchers[$batcherCount]['halt'] = 0;
                            $counter = 0;
                            $batcherCount++;
                        }
                    }
                }
                if (!empty($batchers)) {
                    foreach ($batchers as $item) {
                        $log = Bitrix24::useApi('batch', $item);
                        usleep(250000);
                    }
                }
            }
        }
    }

    public function actionDailyBx()
    {
        $day = (int)date("N");
        if ($day > 5)
            die();
        $jsonQuery = new JsonQuery('params');
        $leads = LeadsSave::find()
            ->where(['AND', ['>=', 'date_income', '2022-03-01 00:00:00'], ['<=', 'date_income', '2022-05-16 23:59:59']])
            ->andWhere(['type' => 'dolgi'])
            ->andWhere(['bx_sent' => 0])
            ->andWhere($jsonQuery->JsonExtract('sum', ">= 250000"))
            ->limit(50)
            ->all();
        if (!empty($leads)) {
            $counter = 0;
            $batcherCount = 0;
            foreach ($leads as $k => $v) {
                $rsp = Bitrix24::useApi('crm.duplicate.findbycomm', ['type' => 'PHONE', 'values' => [$v->phone], 'entity_type' => 'CONTACT']);
                usleep(250000);
                if (empty($rsp['result']['CONTACT'])) {
                    $bufCmd["contact_add_{$k}"] = 'crm.contact.add?' . http_build_query([
                        'fields' => [
                            'PHONE' => [['VALUE' => $v->phone, 'VALUE_TYPE' => 'WORK']],
                            'NAME' => $v->name,
                            'SOURCE_ID' => 95,
                            'ASSIGNED_BY_ID' => 12
                        ]
                    ]);
                    $s = json_decode($v->params, 1);
                    if (!empty($s['sum']))
                        $d = $s['sum'];
                    $b = [
                        'fields' => [
                            'TITLE' => $v->name . " ({$v->region})",
                            'SOURCE_ID' => 95,
                            'ASSIGNED_BY_ID' => 12,
                            'UF_CRM_1624948275527' => $v->name,
                            'UF_CRM_1624947716167' =>  preg_replace("/[^0-9]/", '', $v->phone),
                            'CONTACT_ID' => '$result[' . "contact_add_{$k}" . ']',
                            'CATEGORY_ID' => '102',
                            'UF_CRM_1624947580872' => $v->region,
                        ]
                    ];
                    if (!empty($d)) {
                        $b['fields']['COMMENTS'] = "Сумма долга: {$d}";
                        $b['fields']['UF_CRM_1624947567155'] = $d;
                    }
                    $bufCmd["deal_add_{$k}"] = 'crm.deal.add?' . http_build_query($b);
                    $batchers[$batcherCount]['cmd']["contact_add_{$k}"] = $bufCmd["contact_add_{$k}"];
                    $batchers[$batcherCount]['cmd']["deal_add_{$k}"] = $bufCmd["deal_add_{$k}"];
                    if (++$counter >= 24) {
                        $batchers[$batcherCount]['halt'] = 0;
                        $counter = 0;
                        $batcherCount++;
                    }
                }
                $v->bx_sent = 1;
                $v->update();
            }
            if (!empty($batchers)) {
                foreach ($batchers as $item) {
                    Bitrix24::useApi('batch', $item);
                    usleep(250000);
                }
            }
        }
    }

    public function actionBflBotMessage()
    {
        $ops = [1018, 1020, 476];
        $params = [
            'filter' => [
                'ASSIGNED_BY_ID' => $ops,
                'CATEGORY_ID' => '102',
                '>DATE_CREATE' => date('Y-m-d') . "T00:00:00",
                '<DATE_CREATE' => date('Y-m-d') . "T23:59:59",
            ],
        ];
        $bxResult = Bitrix24::useApi('crm.deal.list', $params);
        $daily = $bxResult['total'];
        $counter = MfBotCounter::find()
            ->where(['AND', ['>=', 'date', date('Y-m-d 00:00:00')], ['<=', 'date', date('Y-m-d 23:59:59')]])
            ->one();
        $anketa = !empty($counter) ? $counter->count_anketa : 0;
        $won = !empty($counter) ? $counter->count_won : 0;
        $bot = new TelegramBot();
        $bot->new__message(TelegramBot::daily__bx__report($daily, $anketa, $won), '-1001743159969');
    }

    public function actionTestMailer()
    {
        /*function filtered($config, $high_priority = false) {
           $filter = [
               'AND',
               ['status' => Orders::STATUS_PROCESSING],
               ['category_link' => $config['type']],
               [
                   'OR',
                   (new JsonQuery('regions'))
                       ->JsonContains(["Любой"]),
                   (new JsonQuery('regions'))
                       ->JsonContains([$config['region']]),
                   (new JsonQuery('regions'))
                       ->JsonContains([$config['city']]),
               ],
               (new JsonQuery('params_special'))
                   ->JsonContains([$config['source']], Queue::OPTION_ASSIGNED_SOURCES_FILTER)
           ];
           if($config['cc'] === 1) {
               $log['lead'][$config['lead_id']][] = "Т.к. лид # {$config['lead_id']} был проверен КЦ - делаем выборку по заказам, получающим лидов с КЦ...";
               $filter[] = (new JsonQuery('params_special'))
                   ->JsonContains([Queue::OPTION_CC_LEADGAIN_QUEUE => Queue::VALUE_TRUE]);
           } elseif ($config['autocalls'] === 1) {
               $log['lead'][$config['lead_id']][] = "Т.к. лид # {$config['lead_id']} пришел с прозвона - делаем выборку по заказам, получающим лидов с прозвона...";
               $filter[] = (new JsonQuery('params_special'))
                   ->JsonContains([Queue::OPTION_AUTOCALLS => Queue::VALUE_TRUE]);
           }
           if ($high_priority) {
               $log['lead'][$config['lead_id']][] = "Поиск первоочередных заказов (заказов с высоким приоритетом)...";
               $orders = Orders::find()
                   ->where($filter)
                   ->andWhere(['archive' => 0])
                   ->andWhere(['high_priority_order' => 1])
                   ->orderBy(['last_lead_get' => SORT_ASC])
                   ->asArray()
                   ->all();
               if (empty($orders)) {
                   $log['lead'][$config['lead_id']][] = "Заказы с высоким приоритетом не найдены в первичной выборке. Поиск по приоритетным заказам в порядке очереди...";
               }
           } else {
               $log['lead'][$config['lead_id']][] = "Поиск заказов обычного приоритета...";
               $orders = Orders::find()
                   ->where($filter)
                   ->andWhere(['archive' => 0])
                   ->orderBy(['last_lead_get' => SORT_ASC])
                   ->asArray()
                   ->all();
           }
           if (empty($orders) && !$high_priority) {
               $log['lead'][$config['lead_id']][] = "Заказы с учетом выбранных параметров не были обнаружены. Запускаем поиск по клиентам...";
               $clients = Clients::find()
                   ->select(['id'])
                   ->where((new JsonQuery('custom_params'))
                       ->JsonContains([$config['source']], Queue::OPTION_ASSIGNED_SOURCES_FILTER))
                   ->andWhere(['archive' => 0])
                   ->asArray()
                   ->all();
               if (!empty($clients)) {
                   $clArr = [];
                   foreach ($clients as $cl) {
                       $clArr[] = $cl['id'];
                   }
                   $log['lead'][$config['lead_id']][] = "Найдены клиенты: " . json_encode($clArr) . ". Получаем последний релевантный заказ...";
                   $filter = [
                       'AND',
                       ['status' => Orders::STATUS_PROCESSING],
                       ['category_link' => $config['type']],
                       [
                           'OR',
                           (new JsonQuery('regions'))
                               ->JsonContains(["Любой"]),
                           (new JsonQuery('regions'))
                               ->JsonContains([$config['region']]),
                           (new JsonQuery('regions'))
                               ->JsonContains([$config['city']]),
                       ],
                       ['in', 'client', $clArr],
                   ];
                   if($config['cc'] === 1) {
                       $log['lead'][$config['lead_id']][] = "Добавляем условие поиска по КЦ...";
                       $filter[] = (new JsonQuery('params_special'))
                           ->JsonContains([Queue::OPTION_CC_LEADGAIN_QUEUE => Queue::VALUE_TRUE]);
                   } elseif ($config['autocalls'] === 1) {
                       $log['lead'][$config['lead_id']][] = "Добавляем условие поиска по прозвону...";
                       $filter[] = (new JsonQuery('params_special'))
                           ->JsonContains([Queue::OPTION_AUTOCALLS => Queue::VALUE_TRUE]);
                   }
                   $orders = Orders::find()
                       ->where($filter)
                       ->andWhere(['archive' => 0])
                       ->orderBy('last_lead_get asc')
                       ->asArray()
                       ->all();
                   if (empty($orders)) {
                       $log['lead'][$config['lead_id']][] = "Заказы по указанным параметрам не найдены. Запускаем поиск по заказам, находящимся в очереди на общих правилах...";
                   }
               } else {
                   $log['lead'][$config['lead_id']][] = "Клиенты не найдены. Запускаем поиск по заказам, находящимся в очереди на общих правилах...";
               }
           }
           return ['orders' => $orders, '$log' => $log];
       }
       $lead = Leads::findOne(129067);
       $config = [
           'type' => $lead->type,
           'region' => $lead->region,
           'city' => $lead->city,
           'source' => $lead->source,
           'cc' => $lead->cc_check,
           'autocalls' => $lead->autocall_check,
           'lead_id' => $lead->id
       ];
       print_r(filtered($config));
       die();*/
        /*$leads = LeadsSave::find()->where(['AND', ['not like', 'system_data', '%[{%', false], ['!=', 'system_data', '[]']])
           ->all();
       if (!empty($leads)) {
           $c = count($leads);
           for ($i = 0; $i < $c; $i++) {
               #todo: params part
               //die((PHP_EOL.$leads[$i]->params.PHP_EOL.$leads[$i]->system_data));
               $cutter = str_replace(PHP_EOL, '|||', $leads[$i]->params);
               $cutterArray = explode("|||", $cutter);
               $cutterArray = array_filter($cutterArray, function ($elem) {
                   return !empty($elem);
               });
               $arr = [];
               foreach ($cutterArray as $item) {
                   $exps = explode(": ", $item);
                   if (!empty($exps[1]))
                       $arr[$exps[0]] = is_numeric($exps[1]) ? (float)$exps[1] : $exps[1];
               }
               $leads[$i]->params = json_encode($arr, JSON_UNESCAPED_UNICODE);
               $leads[$i]->update();
               $cutter = str_replace(PHP_EOL, '|||', $leads[$i]->system_data);
               $cutterArray = explode("|||", $cutter);
               $cutterArray = array_filter($cutterArray, function ($elem) {
                   return !empty($elem);
               });
               $cutterArray = array_values($cutterArray);
               $arr = [];
               $sup = 0;
               foreach ($cutterArray as $item) {
                   if ($sup === 0)
                       $buf = [];
                   $exps = explode(": ", $item);
                   $buf[$exps[0]] = $exps[1];
                   if (++$sup === 2) {
                       $sup = 0;
                       $arr[] = $buf;
                   }
               }
               $leads[$i]->system_data = json_encode($arr, JSON_UNESCAPED_UNICODE);
               $leads[$i]->update();
           }
       }*/
        /*$leads = LeadsSave::find()->where(['AND', ['is', 'params', NULL], ['like', 'region', '%Чуваш%', false]])
           ->all();
       foreach ($leads as $lead) {
           $lead->params = '{}';
           $lead->update();
       }*/
        /*$step = 61;
       $lr = LeadsRead::find()->where(['like', 'region', "%Чуваш%", false])->orderBy('id desc')
           ->limit($step)->offset(0)->all();
       foreach ($lr as $item)
           echo $item->id . PHP_EOL;*/
        /*$lead = LeadsSave::find()->where(['like', 'params', '%""%', false])->andWhere(['not like', 'params', '%:""%', false])->all();
       foreach ($lead as $item) {
           $item->params = str_replace('""', '","', $item->params);
           $this->stdout($item->params . PHP_EOL);
           $item->update();
       }*/
    }

    public function actionTest00() {
        $orders = Orders::find()
            ->where(['archive' => 0, 'status' => Orders::STATUS_PROCESSING])
            ->select(['client', 'order_name', 'leads_count'])
            ->asArray()
            ->all();
        $orders = ArrayHelper::map($orders, 'order_name', 'leads_count', 'client');
        $cids = array_keys($orders);
        $clients = Clients::find()->where(['id' => $cids])->asArray()->select(['f', 'i', 'o', 'id', 'user_id'])->all();
        $uids = ArrayHelper::getColumn($clients, 'user_id');
        if (!empty($uids)) {
            $users = UserModel::find()->where(['id' => $uids])->select(['id', 'username', 'email'])->asArray()->all();
            $users = ArrayHelper::map($users, 'username', 'email', 'id');
        } else
            $users = [];
        $text = '';
        foreach ($clients as $item) {
            if (isset($users[$item['user_id']]))
                $phone = " - " . array_key_first($users[$item['user_id']]) . " - " . $users[$item['user_id']][array_key_first($users[$item['user_id']])];
            else
                $phone = '';
            $text .= "{$item['f']} {$item['i']} {$item['o']}{$phone}" . PHP_EOL;
            if (isset($orders[$item['id']])) {
                foreach ($orders[$item['id']] as $or => $count) {
                    $text .= " -- " . "{$or} - {$count} шт." . PHP_EOL;
                }
            }
            $text .= PHP_EOL;
        }
        file_put_contents("archive_orders.txt", $text);
    }

    public function actionLeadChange() {
        $leads = CcLeads::find()->where(['like', 'category', "%arbit%", false])
            ->all();
        foreach ($leads as $item) {
            //$item->status = "ждет звонка";
            $item->date_outcome = "2022-12-21 11:00:00";
            $item->update();
        }
    }

}
