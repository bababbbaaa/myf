<?php


namespace admin\models;

use common\models\BudgetLog;
use common\models\CcLeads;
use common\models\Clients;
use common\models\DbCity;
use common\models\DbRegion;
use common\models\helpers\Mailer;
use common\models\JobsQueue;
use common\models\Leads;
use common\models\LeadsActions;
use common\models\LeadsRead;
use common\models\LeadsSave;
use common\models\LeadsSentReport;
use common\models\Offers;
use common\models\Orders;
use common\models\UserModel;
use common\models\Worker;
use console\models\ConsoleIntervalQuery;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Font;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PHPUnit\Util\Color;
use yii\data\ActiveDataProvider;
use yii\db\Expression;
use yii\db\Query;
use yii\helpers\Url;
use yii2tech\spreadsheet\Spreadsheet;

class Admin
{

    public $operations = [];
    public $type;
    public $readModels = ['leads'];
    public $saveModels = ['leads'];

    public function __construct($type)
    {
        $this->type = $type;
        switch ($this->type) {
            case 'leads':
                $this->operations['select-all'] = 'Выделить всех';
                $this->operations['mass-export'] = 'Отправить выбранных клиенту';
                $this->operations['cc-send'] = 'Отправить выбранных в КЦ';
                $this->operations['auction-send'] = 'Отправить выбранных в аукцион';
                $this->operations['interval-query'] = 'Отправить выбранных (интервал)';
                $this->operations['excel-export'] = 'Отправить выбранных в XLSX';
                $this->operations['utm-analysis'] = 'Показать UTM-аналитику';
                $this->operations['cc-check-show'] = 'Показать лидов с КЦ';
                $this->operations['show-waste'] = 'Показать брак';
                $this->operations['show-unsent'] = 'Показать неотгруженных';
                $this->operations['excel-filter-export'] = 'XLSX-выборка по фильтрам';
                $this->operations['excel-filter-export-bd'] = 'XLSX-выборка по фильтрам Backdoor';
                //$this->operations['monthly-kpi'] = 'KPI за месяц';
                $this->operations['monthly-kpi-v2'] = 'KPI за месяц v2';
                $this->operations['delete-selected'] = 'Удалить выбранных';
                $this->operations['clear'] = 'Сбросить фильтр';
                break;
            case 'contact-center':
                $this->operations['clear'] = 'Сбросить фильтр';
                $this->operations['await'] = 'Показать необработанных';
                $this->operations['set-operator'] = 'Назначить оператора';
                $this->operations['open'] = 'Открыть выбранных';
                $this->operations['reset-leads'] = 'Очистить выбранных';
                $this->operations['excel-filter-export'] = 'Выгрузка по операторам';
                $this->operations['excel-filtration-utm'] = 'Выгрузка с удалением по метке';
                $this->operations['import-excel'] = 'Импорт форматированного XLSX';
                $this->operations['import-txt'] = 'Импорт TXT-файла';
                $this->operations['import-xlsx'] = 'Импорт XLSX-файла';
                break;
            default:
                break;
        }
    }

    public function asReadModel($class)
    {
        return in_array($class::tableName(), $this->readModels) ? "{$class}Read" : $class;
    }

    public function asSaveModel($class)
    {
        return in_array($class::tableName(), $this->saveModels) ? "{$class}Save" : $class;
    }

    public function operationsDropdown()
    {
        $arr = [];
        if (!empty($this->operations)) {
            foreach ($this->operations as $key => $item) {
                $arr[] = ['label' => $item, 'url' => $key, 'linkOptions' => ['class' => 'preventDefault actionBtn']];
            }
        }
        return $arr;
    }

    public function excelExport($data, $model, $onlyPhone = false)
    {
        if (!empty($data)) {
            $model = $this->asReadModel($model);
            $attributes = new $model;
            $attr = $attributes->attributes();
            $labels = $attributes->attributeLabels();
            $json = json_decode($data);
            $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
            if (!$onlyPhone) {
                foreach ($attr as $a => $t) {
                    $sheet->setCellValueByColumnAndRow($a + 1, 1, $labels[$t]);
                    $sheet->getStyleByColumnAndRow($a + 1, 1)
                        ->getFill()
                        ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                        ->getStartColor()
                        ->setARGB('303030');
                    $sheet->getStyleByColumnAndRow($a + 1, 1)
                        ->getFont()
                        ->getColor()
                        ->setARGB('ffffff');
                }
                $cCount = $model::find()
                    ->where(['in', 'id', $json])
                    ->count();
                $cBatch = ceil($cCount / 50);
                for ($i = 0; $i < $cBatch; ++$i) {
                    $start = $i * 50;
                    $currentQuery = $model::find()
                        ->where(['in', 'id', $json])
                        ->orderBy('id desc')
                        ->limit(50)
                        ->offset($start)
                        ->all();
                    foreach ($currentQuery as $key => $item) {
                        foreach ($attr as $a => $t) {
                            $sheet->setCellValueByColumnAndRow($a + 1, $key + 2 + $start, $item[$t]);
                            $sheet->getColumnDimensionByColumn($a + 1)->setAutoSize(true);
                            $sheet->getStyleByColumnAndRow($a + 1, $key + 2 + $start)->getAlignment()->setWrapText(true);
                        }
                    }
                }
                $sheet->freezePaneByColumnAndRow(1, 2);
            } else {
                $cCount = $model::find()
                    ->where(['in', 'id', $json])
                    ->select('phone')
                    ->count();
                $cBatch = ceil($cCount / 50);
                for ($i = 0; $i < $cBatch; ++$i) {
                    $start = $i * 50;
                    $currentQuery = $model::find()
                        ->where(['in', 'id', $json])
                        ->orderBy('id desc')
                        ->limit(50)
                        ->offset($start)
                        ->all();
                    foreach ($currentQuery as $key => $item) {
                        $phone = (string)$item['phone'];
                        $phone[0] = $phone[0] === '8' ? '7' : $phone[0];
                        $sheet->setCellValueByColumnAndRow(1, $key + 1 + $start, $phone);
                        $sheet->getColumnDimensionByColumn(1)->setAutoSize(true);
                        $sheet->getStyleByColumnAndRow(1, $key + 1 + $start)->getAlignment()->setWrapText(true);
                    }
                }
            }
            $writer = new Xlsx($spreadsheet);
            $path = "xlsx/{$this->type}.xlsx";
            $writer->save($path);
            return ['status' => 'success', 'url' => Url::to(["/{$path}"])];
        } else
            return null;
    }

    public function deleteSelected($data, $model)
    {
        if (\Yii::$app->getUser()->can('permissionToDelete')) {
            if (!empty($data)) {
                $model = $this->asSaveModel($model);
                $json = json_decode($data);
                $removal = $model::find()
                    ->where(['in', 'id', $json])
                    ->select('id')
                    ->all();
                if (!empty($removal)) {
                    foreach ($removal as $item)
                        $item->delete();
                }
                return ['status' => 'success', 'url' => 'refresh'];
            } else
                return null;
        } else
            return ['status' => 'error', 'message' => 'Недостаточно привилегий для выполнения этого действия'];
    }

    public function auctionSend($data, $price)
    {
        if (!empty($data) && !empty($price)) {
            $json = json_decode($data);
            $leads = LeadsSave::find()
                ->where(['in', 'id', $json])
                ->all();
            if (!empty($leads)) {
                /**
                 * @var Leads $item
                 */
                foreach ($leads as $item) {
                    $item->status = Leads::STATUS_AUCTION;
                    $item->auction_price = $price;
                    $arr = ['date' => date("d.m.Y H:i:s"), 'text' => 'Лид отправлен в Аукцион'];
                    if (!empty($item->system_data)) {
                        $sd = $item->system_data;
                        $sd = json_decode($sd, 1);
                        $sd[] = $arr;
                        $sd = json_encode($sd, JSON_UNESCAPED_UNICODE);
                    } else
                        $sd = json_encode([$arr], JSON_UNESCAPED_UNICODE);
                    $item->system_data = $sd;
                    $item->update();
                }
            }
            return ['status' => 'success', 'url' => 'refresh'];
        } else
            return null;
    }

    public function intervalQuery($data)
    {
        if (!empty($data)) {
            $json = $data;
            $orderID = $data['order'];
            $interval = $data['interval'];
            $keys = json_decode($json['keys'], 1);
            sort($keys);
            $start_time = $data['start_time'];
            $date = new \DateTime();
            $date->setTimestamp(strtotime($start_time));
            foreach ($keys as $key => $item) {
                $lead = LeadsSave::findOne($item);
                if (!empty($lead)) {
                    $worker = new ConsoleIntervalQuery();
                    if ($key === 0)
                        $worker->process_time = $date->format("Y-m-d H:i:00");
                    else
                        $worker->process_time = $date->modify("+{$interval} min")->format("Y-m-d H:i:00");
                    $worker->order_id = $orderID;
                    $worker->lead_id = $item;
                    if ($worker->save()) {
                        $lead->status = Leads::STATUS_INTERVAL;
                        $lead->update();
                    }
                }
            }
            return ['status' => 'success', 'url' => 'refresh'];
        } else
            return null;
    }

    public function getAjaxGeo($value)
    {
        if (!empty($value)) {
            $city = DbCity::find()
                ->where(['like', 'city', "%{$value}%", false])
                ->asArray()
                ->all();
            $regions = DbRegion::find()
                ->where(['OR', ['like', 'name', "%{$value}%", false], ['like', 'name_with_type', "%{$value}%", false]])
                ->asArray()
                ->all();
            $rsp = [];
            if (!empty($city)) {
                foreach ($city as $item) {
                    $rsp['city'][] = $item['city'];
                }
            }
            if (!empty($regions)) {
                foreach ($regions as $item) {
                    $rsp['region'][] = $item['name_with_type'];
                }
            }
            return empty($rsp) ? null : $rsp;
        } else
            return null;
    }

    public function curlAMO($link, $data)
    {
        $curl = curl_init();
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
        $code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);
        return ['out' => $out, 'code' => $code];
    }

    public function wasteLead($ids)
    {
        /*$ids = json_decode($ids, true);
        $in = join(',', $ids);
        $sql2 = "leads_sent_report.id = (SELECT sub.id FROM leads_sent_report AS sub WHERE sub.lead_id = leads_sent_report.lead_id AND leads_sent_report.status = 'брак' AND leads_sent_report.lead_id IN ({$in}) AND leads_sent_report.status_confirmed = 0 ORDER BY sub.id DESC LIMIT 1)";*/
        $leads = LeadsSentReport::find()
            ->where(['id' => $ids])
            ->all();
        if (!empty($leads)) {
            foreach ($leads as $lead) {
                if (!empty($lead->order_id)) {
                    $order = Orders::findOne($lead->order_id);
                    $order->status = Orders::STATUS_PROCESSING;
                    $order->leads_count++;
                    $order->leads_waste++;
                    $order->update();
                    if (!empty($lead->offer_id) && !empty($lead->provider_id)) {
                        $offerSentRep = LeadsSentReport::find()
                            ->where([
                                'offer_id' => $lead->offer_id,
                                'provider_id' => $lead->provider_id,
                                'lead_id' => $lead->lead_id,
                            ])->select('provider_id, order_id, offer_id, status, status_confirmed, id')
                            ->asArray()
                            ->orderBy('id asc')
                            ->one();
                        if (!empty($offerSentRep) && $offerSentRep['status'] === Leads::STATUS_WASTE) {
                            $offer = Offers::findOne(['id' => $offerSentRep['offer_id']]);
                            $offer->leads_waste++;
                            $offer->update();
                        }
                    }
                    $client = Clients::find()->where(['id' => $order->client])->asArray()->one();
                    if (!empty($client) && !empty($client['user_id'])) {
                        $user = UserModel::findOne($client['user_id']);
                        $budgetLog = new BudgetLog();
                        $budgetLog->budget_was = $user->budget;
                        $budgetLog->user_id = $user->id;
                        $budgetLog->text = "Возврат средств за брак в заказе #{$order->id}, лид #{$lead->lead_id}: +{$order->price} руб.";
                        $user->budget += $order->price;
                        $budgetLog->budget_after = $user->budget;
                        $user->update();
                        $budgetLog->save();
                        /*if (!empty($user->email)) {
                            $cfg = json_decode($order->mailer_config, 1);
                            if (!empty($cfg) && isset($cfg['13_orders']) && $cfg['13_orders'] < 2) {
                                if ($order->leads_waste === 1 && $cfg['13_orders'] < 1) {
                                    $queue = new JobsQueue();
                                    $queue->method = "execute__mailer";
                                    $queue->params = json_encode(["to" => $user->email, 'html' => '13_orders', 'title' => Mailer::TITLES['13_orders']], JSON_UNESCAPED_UNICODE);
                                    $queue->date_start = date("Y-m-d H:i:s");
                                    $queue->status = 'wait';
                                    $queue->user_id = $user->id;
                                    $queue->closed = 0;
                                    $queue->save();
                                    $cfg['13_orders'] = 1;
                                    $order->mailer_config = json_encode($cfg, JSON_UNESCAPED_UNICODE);
                                    $order->update();
                                } elseif ($order->leads_waste >= 25) {
                                    $queue = new JobsQueue();
                                    $queue->method = "execute__mailer";
                                    $queue->params = json_encode(["to" => $user->email, 'html' => '13_orders', 'title' => Mailer::TITLES['13_orders']], JSON_UNESCAPED_UNICODE);
                                    $queue->date_start = date("Y-m-d H:i:s");
                                    $queue->status = 'wait';
                                    $queue->user_id = $user->id;
                                    $queue->closed = 0;
                                    $queue->save();
                                    $cfg['13_orders'] = 2;
                                    $order->mailer_config = json_encode($cfg, JSON_UNESCAPED_UNICODE);
                                    $order->update();
                                }
                            }
                        }*/
                    }
                }
                $lead->status_confirmed = 1;
                $json = json_decode($lead->log, true);
                $json[] = ['date' => date('d.m.Y H:i'), 'text' => 'Брак подтвержден'];
                $lead->log = json_encode($json, JSON_UNESCAPED_UNICODE);
                $lead->update();
            }
            return ['status' => 'success', 'url' => 'refresh'];
        } else
            return ['status' => 'error', 'message' => 'В указанной выборке отсутствуют бракованные неподтвержденные лиды'];
    }

    public function massLead($ids, $order) {
        $ids = json_decode($ids, true);
        $leads = Leads::find()->where(['in', 'id', $ids])->batch();
        $countLeads = Leads::find()->where(['in', 'id', $ids])->count();
        $order = Orders::findOne($order);
        $client = Clients::findOne($order->client);
        $user = empty($client->user_id) ? null : UserModel::findOne($client->user_id);
        if (!empty($leads) && !empty($order) && $countLeads > 0) {
            if(empty($user) || ($user->budget >= $countLeads*$order->price)) {
                foreach ($leads as $batch) {
                    foreach ($batch as $lead) {
                        $worker = new Worker($order, $lead);
                        $worker->processing__new();
                    }
                }
                $rsp = ['status' => 'success', 'url' => 'refresh'];
            } else
                $rsp = ['status' => 'error', 'message' => 'Баланс заказчика меньше, чем суммарная стоимость отправляемых лидов.', 'systemErr' => 1];
        } else
            $rsp = ['status' => 'error', 'message' => 'Не найден заказ или пустая выборка лидов.', 'systemErr' => 1];
        return $rsp;
    }

    public function setOP($ids, $order) {
        $ids = json_decode($ids, true);
        $leads = CcLeads::find()->where(['in', 'id', $ids])->all();
        $countLeads = CcLeads::find()->where(['in', 'id', $ids])->count();
        $usr = UserModel::findOne($order);
        if (!empty($leads) && !empty($usr) && $countLeads > 0) {
            foreach ($leads as $item) {
                /**
                 * @var CcLeads $item
                 */
                $item->assigned_to = $usr->id;
                $item->update();
            }
            return ['status' => 'success', 'url' => 'refresh'];
        } else
            $rsp = ['status' => 'error', 'message' => 'Не найден заказ или пустая выборка лидов.', 'systemErr' => 1];
        return $rsp;
    }

    public function sendCC($ids) {
        $ids = json_decode($ids, true);
        $leads = Leads::find()->where(['in', 'id', $ids])->batch();
        if (!empty($leads)) {
            foreach ($leads as $batch) {
                /**
                 * @var $lead Leads
                 */
                foreach ($batch as $lead) {
                    $cc = new CcLeads();
                    $cc->source = "МЕТКА";
                    $cc->utm_source = $lead->utm_source;
                    $cc->date_income = date("Y-m-d H:i:s");
                    $cc->phone = $lead->phone;
                    $cc->region = $lead->region;
                    $cc->city = $lead->city;
                    $cc->category = $lead->type;
                    if (!empty($lead->params)) {
                        $cc->params = json_encode($lead->params, JSON_UNESCAPED_UNICODE);
                    }
                    $cc->save();
                    $act = new LeadsActions();
                    $act->lead_id = $lead->id;
                    $act->action_type = 'cc_send';
                    $act->lead_type = 'lead';
                    $act->save();
                    $rsText = ['date' => date("d.m.Y H:i:s"), 'text' => 'Лид отправлен в КЦ'];
                    if (empty($lead->system_data)) {
                        $lead->system_data = [$rsText];
                    } else {
                        $lead->system_data = array_merge($lead->system_data, [$rsText]);
                    }
                    $lead->status = Leads::STATUS_SENT;
                    $lead->update();
                }
            }
            $rsp = ['status' => 'success', 'url' => 'refresh'];
        } else
            $rsp = ['status' => 'error', 'message' => 'Пустая выборка лидов.'];
        return $rsp;
    }

    public function openSelected($data, $model) {
        if (!empty($data)) {
            $json = json_decode($data);
            $toOpen = $model::find()
                ->where(['in', 'id', $json])
                ->all();
            if (!empty($toOpen)) {
                foreach ($toOpen as $item) {
                    $item->status = null;
                    $item->date_outcome = null;
                    $item->date_income = date("Y-m-d H:i:s");
                    $item->utm_source = 'backdoor';
                    $item->source = 'backdoor';
                    $item->update();
                }
            }
            return ['status' => 'success', 'url' => 'refresh'];
        } else
            return null;
    }

    public function resetLeads($data, $model) {
        if (!empty($data)) {
            $json = json_decode($data);
            $toOpen = $model::find()
                ->where(['in', 'id', $json])
                ->all();
            if (!empty($toOpen)) {
                foreach ($toOpen as $item) {
                    $act = new LeadsActions();
                    $act->lead_id = $item->id;
                    $act->action_type = 'open';
                    $act->lead_type = 'cc';
                    $act->save();
                    $item->status = null;
                    $item->date_outcome = null;
                    $item->date_income = date("Y-m-d H:i:s");
                    $item->status_temp = null;
                    $item->name = null;
                    $item->special_source = null;
                    /*$item->region = null;
                    $item->city = null;
                    $item->params = null;*/
                    $item->assigned_to = $item->randomAssigned();
                    $item->update();
                }
            }
            return ['status' => 'success', 'url' => 'refresh'];
        } else
            return null;
    }


}