<?php


namespace api\controllers;


use api\models\Bitrix24;
use common\models\BudgetLog;
use common\models\Clients;
use common\models\disk\Cloud;
use common\models\helpers\Mailer;
use common\models\helpers\Robokassa;
use common\models\helpers\TelegramBot;
use common\models\JobsQueue;
use common\models\RobokassaResult;
use common\models\User;
use common\models\UserModel;
use common\models\UsersBonuses;
use common\models\UsersCertificates;
use common\models\UsersNotice;
use SebastianBergmann\CodeCoverage\Report\PHP;
use yii\web\Controller;

class PaymentsResultController extends Controller
{

    public function beforeAction($action)
    {
        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }

    public static function TriggerDeal($user_id)
    {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_POST => 0,
            CURLOPT_HEADER => 0,
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_CONNECTTIMEOUT => 2,
            CURLOPT_URL => Bitrix24::FEMIDA_BITRIX . "crm.deal.list?start=-1&filter[UF_CRM_1594804059623]={$user_id}&order[ID]=desc",
        ));
        $responseData = curl_exec($curl);
        $responseData = json_decode($responseData, 1);

        if (!empty($responseData['result'][0]))
            $deal_id = $responseData['result'][0]['ID'];
        if (!empty($deal_id)){
            usleep(250000);
            curl_setopt_array($curl, array(
                CURLOPT_SSL_VERIFYPEER => 0,
                CURLOPT_POST => 0,
                CURLOPT_HEADER => 0,
                CURLOPT_RETURNTRANSFER => 1,
                CURLOPT_CONNECTTIMEOUT => 2,
                CURLOPT_URL => Bitrix24::FEMIDA_BITRIX . "crm.automation.trigger?target=DEAL_{$deal_id}&code=mv694",
            ));
            $responseData = curl_exec($curl);
        }
        curl_close($curl);
    }

    public function actionSave() {
        if(!empty($_POST)) {
            $mrh_pass2 = !empty($_POST['IsTest']) ? Robokassa::PASSWORD_TEST_2 : Robokassa::PASSWORD_MAIN_2;
            $out_summ = $_REQUEST["OutSum"];
            $inv_id = $_REQUEST["InvId"];
            $crc = strtoupper($_REQUEST["SignatureValue"]);
            $defaultCRC = "$out_summ:$inv_id:$mrh_pass2";
            $arrGet = $_POST;
            ksort($arrGet);
            foreach ($arrGet as $key => $item) {
                if (strpos($key, 'Shp') !== false)
                    $defaultCRC .= ":{$key}={$item}";
            }
            $my_crc = strtoupper(md5($defaultCRC));
            if ($my_crc != $crc) {
                file_put_contents('logs/error-payments.log', json_encode(['data' => $_POST, 'crc' => ['my' => $my_crc, 'input' => $crc]], JSON_UNESCAPED_UNICODE) . PHP_EOL, FILE_APPEND);
            } else {
                file_put_contents('logs/payments.log', json_encode($_POST, JSON_UNESCAPED_UNICODE) . PHP_EOL, FILE_APPEND);
                $result = RobokassaResult::findOne(['crc' => $crc, 'inv' => $inv_id]);
                if(empty($result)) {
                    $result = new RobokassaResult();
                    $result->status = RobokassaResult::STATUS_GOT;
                    $result->user_id = !empty($_POST['Shp_user']) ? "{$_POST['Shp_user']}" : null;
                    $result->inv = !empty($_POST['InvId']) ? "{$_POST['InvId']}" : null;
                    $result->crc = !empty($_POST['SignatureValue']) ? "{$_POST['SignatureValue']}" : null;
                    $result->description = !empty($_POST['Shp_description']) ? "{$_POST['Shp_description']}" : null;
                    $result->summ = !empty($_POST['OutSum']) ? "{$_POST['OutSum']}" : null;
                } else {
                    if ($result->status === RobokassaResult::STATUS_CONFIRMED)
                        die();
                }
                if($result->validate() && empty($result->id))
                    $result->save();
                else
                    $result->update();
                $check = md5(Robokassa::SHOP_ID.":{$_POST['InvId']}:{$mrh_pass2}");
                $url = "https://auth.robokassa.ru/Merchant/WebService/Service.asmx/OpState?MerchantLogin=". Robokassa::SHOP_ID ."&InvoiceID={$_POST['InvId']}&Signature=$check";
                $curl = curl_init();
                curl_setopt_array($curl, array(
                    CURLOPT_SSL_VERIFYPEER => 0,
                    CURLOPT_POST => 0,
                    CURLOPT_HEADER => 0,
                    CURLOPT_RETURNTRANSFER => 1,
                    CURLOPT_CONNECTTIMEOUT => 2,
                    CURLOPT_URL => $url,
                ));
                $responseData = curl_exec($curl);
                curl_close($curl);
                $xml = simplexml_load_string($responseData);
                file_put_contents('logs/xml.log', json_encode($xml, JSON_UNESCAPED_UNICODE) . PHP_EOL, FILE_APPEND);
                if (!empty($xml->State->Code)) {
                    $code = (int)$xml->State->Code;
                    if ($code === 100) {
                        $result->status = RobokassaResult::STATUS_CONFIRMED;
                        $result->update();
                        if (!empty($_POST['Shp_user'])) {
                            $user = UserModel::findOne($_POST['Shp_user']);
                            if (!empty($user)) {
                                $tg = new TelegramBot();
                                $tg->new__message($tg::kassa__message($user, (float)$result->summ), $tg::PEER_SUPPORT);
                                $cashback = 0;
                                $bonus = UsersBonuses::findOne(['user_id' => $user->id]);
                                if (!empty($bonus) && !empty($bonus->cashback))
                                    $cashback = $bonus->cashback;
                                $was = $user->budget;
                                $user->budget += (float)$result->summ + round((float)$result->summ * $cashback * 0.01, 0);
                                $user->update();
                                $budget_log = new BudgetLog();
                                $budget_log->text = "Пополнение баланса ROBOKASSA: +". round($result->summ, 2) ." руб.";
                                $budget_log->budget_was = $was;
                                $budget_log->user_id = $user->id;
                                $budget_log->budget_after = $user->budget;
                                $budget_log->save();
                                $notice = new UsersNotice();
                                $notice->user_id = $user->id;
                                $notice->type = UsersNotice::TYPE_INCOME_BUDGET;
                                $notice->text = "Пополнение баланса ROBOKASSA: +". round($result->summ, 2) ." руб.";
                                $notice->save();
                                self::TriggerDeal($user->id);
                                try {
                                    $client = Clients::findOne(['user_id' => $user->id]);
                                    if (!empty($client) && !empty($client->requisites)) {
                                        $reqs = ['f', 'i', 'address', 'phone', 'email'];
                                        $requisites = json_decode($client->requisites, 1);
                                        if ($requisites !== null && !empty($requisites['fiz'])) {
                                            foreach ($reqs as $item) {
                                                if (empty($requisites['fiz'][$item])) {
                                                    $error = 1;
                                                    break;
                                                }
                                            }
                                            $succeed = $requisites['fiz'];
                                            if (empty($error)) {
                                                $cloud = new Cloud($user->id);
                                                $fio = "{$succeed['f']} {$succeed['i']}";
                                                if (!empty($succeed['o']))
                                                    $fio .= " {$succeed['o']}";
                                                $data__set = [
                                                    'invoice' => $_POST['InvId'],
                                                    'fio' => $fio,
                                                    'address' => $succeed['address'],
                                                    'phone' => $succeed['phone'],
                                                    'email' => $succeed['email'],
                                                    'user_id' => $user->id,
                                                    'price' => round($_POST['OutSum'], 2),
                                                ];
                                                $file = $cloud->create__fiz__act($data__set);
                                                $act = new UsersCertificates();
                                                $act->name = "Акт по счету №{$_POST['InvId']} от " . date("d.m.Y");
                                                $act->user_id = $user->id;
                                                $act->link = $file['download'];
                                                if (!in_array('error', $file)) {
                                                    if (file_exists($file['real']) && $act->save()) {
                                                        $queue = new JobsQueue();
                                                        $queue->method = "act__mailer";
                                                        $queue->params = json_encode(['id' => $act->id], JSON_UNESCAPED_UNICODE);
                                                        $queue->date_start = date("Y-m-d H:i:s");
                                                        $queue->status = 'wait';
                                                        $queue->user_id = $user->id;
                                                        $queue->closed = 0;
                                                        $queue->save();
                                                        $rsp = ['status' => 'success', '__object' => $act->id, 'url' => $file['download']];
                                                    } else
                                                        $rsp = ['status' => 'error', 'message' => 'Ошибка сохранения акта'];
                                                } else
                                                    $rsp = ['status' => 'error', 'message' => 'Ошибка сети. Повторите попытку позже'];
                                            }
                                        }
                                    }
                                } catch (\Exception $exception) {
                                    file_put_contents('logs/kassa-exceptions.log', json_encode($exception, JSON_UNESCAPED_UNICODE) . PHP_EOL, FILE_APPEND);
                                }
                            }
                        }
                    }
                }
            }
        }
        else
            die('wrong request');
    }


}