<?php

namespace admin\modules\contact_center\controllers;

use admin\controllers\AccessController;
use admin\models\Admin;
use admin\models\BasesUtm;
use common\models\CcFields;
use common\models\CcLeads;
use common\models\helpers\TelegramBot;
use common\models\Leads;
use common\models\LeadsCategory;
use common\models\LeadsParams;
use common\models\UserModel;
use Yii;
use yii\data\Pagination;
use yii\web\Response;

/**
 * Default controller for the `contact_center` module
 */
class MainController extends AccessController
{

    /**
     *
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionLeads($type = null) {
        if (empty($type)) {
            $leads = null;
            $pages = null;
            $leadParams = null;
            $ccFields = null;
        } else {
            $where = ['category' => $type];
            if (!\Yii::$app->getUser()->can('ccSupervisor'))
                $where['assigned_to'] = \Yii::$app->getUser()->getId();
            if (!empty($_GET['filter'])) {
                $f = $_GET['filter'];
                $filter = ['AND'];
                if (!empty($f['id']))
                    $filter[] = ['id' => $f['id']];
                if (!empty($f['source']))
                    $filter[] = ['like', 'source', "%{$f['source']}%", false];
                if (!empty($f['utm_source']))
                    $filter[] = ['like', 'utm_source', "%{$f['utm_source']}%", false];
                if (!empty($f['region']))
                    $filter[] = ['like', 'region', "%{$f['region']}%", false];
                if (!empty($f['phone']))
                    $filter[] = ['like', 'phone', "%{$f['phone']}%", false];
                if (!empty($f['status_temp']))
                    $filter[] = ['AND', ['status_temp' => $f['status_temp']], ['OR', ['is', 'status', NULL], ['status' => '']]];
                if (!empty($f['status']))
                    $filter[] = ['status' => $f['status']];
                if (!empty($f['date_type']) && (!empty($f['date_start']) || !empty($f['date_stop']))) {
                    if ($f['date_type'] === 'income') {
                        if (!empty($f['date_start']))
                            $filter[] = ['>=', 'date_income', date("Y-m-d 00:00:00", strtotime($f['date_start']))];
                        if (!empty($f['date_stop']))
                            $filter[] = ['<=', 'date_income', date("Y-m-d 23:59:59", strtotime($f['date_stop']))];
                    } else {
                        if (!empty($f['date_start']))
                            $filter[] = ['>=', 'date_outcome', date("Y-m-d 00:00:00", strtotime($f['date_start']))];
                        if (!empty($f['date_stop']))
                            $filter[] = ['<=', 'date_outcome', date("Y-m-d 23:59:59", strtotime($f['date_stop']))];
                    }
                }
            }
            $query = CcLeads::find()->where($where);
            if (!empty($filter))
                $query->andWhere($filter);
            $countQuery = clone $query;
            $pages = new Pagination(['totalCount' => $countQuery->count(), 'pageSize' => 25]);
            $leads = $query->offset($pages->offset)
                ->limit($pages->limit)
                ->orderBy('date_income desc')
                ->all();
            $ccFields = CcFields::find()->where(['lead_type' => $type])->asArray()->all();
            $leadParams = LeadsParams::find()->where(['category' => $type, 'required' => 1])->asArray()->all();
        }
        $categories = LeadsCategory::find()->select(['link_name', 'name'])->asArray()->all();
        return $this->render('leads', [
            'leads' => $leads,
            'pages' => $pages,
            'categories' => $categories,
            'leadParams' => $leadParams,
            'ccFields' => $ccFields,
            'totalCount' => $countQuery->count()
        ]);
    }

    public function actionSaveCcLead() {
        \Yii::$app->response->format = Response::FORMAT_JSON;
        if (!empty($_POST['serialize']) && !empty($_POST['serialize']['id'])) {
            $data = $_POST['serialize'];
            $id = $data['id'];
            $ccLead = CcLeads::findOne($id);
            if (empty($ccLead))
                return ['status' => 'error', 'message' => 'Модель не найдена. Вероятно, указанный лид был удален'];
            else {
                $ccLead->region = $data['region'] ?? $ccLead->region;
                $ccLead->city = $data['city'] ?? $ccLead->city;
                if (!empty($data['leadParams']))
                    $ccLead->params = array_merge([], $data['leadParams']);
                else
                    $ccLead->params = [];
                if (!empty($ccLead->params))
                    $ccLead->params = array_merge($ccLead->params, $data['params']);
                else
                    $ccLead->params = $data['params'];
                $ccLead->params = json_encode($ccLead->params, JSON_UNESCAPED_UNICODE);
                $ccLead->name = $data['name'] ?? null;
                $ccLead->special_source = $data['special_source'] ?? null;
                $ccLead->status = $data['status'] ?? null;
                if ((!empty($data['status_temp']) && empty($ccLead->status_temp)) || (!empty($data['status_temp']) && !empty($ccLead->status_temp) && $data['status_temp'] !== $ccLead->status_temp)) {
                    $ccLead->date_last_tmp = date("Y-m-d H:i:s");
                }
                $ccLead->status_temp = $data['status_temp'] ?? null;
            }
            if (!empty($data['status']) && empty($ccLead->date_outcome)) {
                if (in_array($data['status'], CcLeads::$succeedStatuses)) {
                    if (in_array($ccLead->category, LeadsCategory::$special_categories)) {
                        if ($ccLead->category === 'audit') {
                            $color = '#feffd9';
                            $ccLead->sms_sent = 1;
                            $ccLead->sendSms($ccLead->phone, $data['params']['Email'] ?? null);
                        } elseif ($ccLead->category === 'rekruting') {
                            $color = '#fbfff7';
                            $html = "<p><b>Рекрутинг &ndash; целевой лид с КЦ</b></p>";
                            $html .= "<p><b>Телефон:</b> {$ccLead->phone}</p>";
                            $html .= "<p><b>Имя:</b> {$ccLead->name}</p>";
                            $pars = json_decode($ccLead->params, true);
                            if (!empty($pars['Доп.информация']))
                                $html .= "<p><b>Комментарий:</b> {$pars['Доп.информация']}</p>";
                            $html .= "<p><b>Метка:</b> {$ccLead->utm_source}</p>";
                            /*Yii::$app->mailer->compose()
                                ->setFrom('info@myforce.ru')
                                ->setTo("amaliya.abdulazizova@gmail.com")
                                ->setSubject("Целевые лиды с КЦ | Рекрутинг")
                                ->setHtmlBody($html)
                                ->send();*/
                            $tgData = [
                                'phone' => $ccLead->phone,
                                'name' => $ccLead->name,
                                'params' => $ccLead->params,
                                'utm_source' => $ccLead->utm_source,
                            ];
                            $tg = new TelegramBot();
                            $tg->new__message($tg::hr__message($tgData), $tg::PEER_HR, $tg::HR_BOT);
                        } elseif ($ccLead->category === 'kreditnye-karty') {
                            $color = '#fbfff7';
                            $params = json_decode($ccLead->params, true);
                            if (!empty($params['Тип карты'])) {
                                switch ($params['Тип карты']) {
                                    default:
                                    case 'Кредитная':
                                        $text = "Ссылка на регистрацию кредитной карты Tinkoff Platinum https://dp.tinkoff.ru/click?sspotct=TMnjFpV4RAkmZFg2%2FciX7ElOHOenLOI4Rs%2BKB4VyWHIUyhhtrCaqdZsRRz6zowRm&sub10=ISM&sub11=&sub12=";
                                        break;
                                    case 'Дебетовая':
                                        $text = "Ссылка на регистрацию дебетовой карты Tinkoff Black https://dp.tinkoff.ru/click?sspotct=LQFRpPuQSuPDSEZ8VY8muDWH6Dl%2F43HoLAEv4ttNNGy8UVgidLQhQHjgI%2FSFVrrG&sub10=ISM&sub11=&sub12=";
                                        break;
                                    case 'Кредитная+Дебетовая':
                                        $text = "Ссылка на регистрацию кредитной карты Tinkoff Platinum https://dp.tinkoff.ru/click?sspotct=TMnjFpV4RAkmZFg2%2FciX7ElOHOenLOI4Rs%2BKB4VyWHIUyhhtrCaqdZsRRz6zowRm&sub10=ISM&sub11=&sub12= Ссылка на регистрацию дебетовой карты https://dp.tinkoff.ru/click?sspotct=LQFRpPuQSuPDSEZ8VY8muDWH6Dl%2F43HoLAEv4ttNNGy8UVgidLQhQHjgI%2FSFVrrG&sub10=ISM&sub11=&sub12=";
                                        break;
                                }
                                $client = new \SoapClient('https://smsc.ru/sys/soap.php?wsdl');
                                $ret = $client->send_sms(array('login'=>'FemidaForce', 'psw'=>'1q2w3e2w1q', 'phones'=>$ccLead->phone, 'mes'=>$text, 'sender'=>'MYFORCE'));
                            }
                        }
                        $ccLead->date_outcome = date("Y-m-d H:i:s");
                        $ccLead->update();
                    } else {
                        $lead = new Leads();
                        $lead->generateFromCC($ccLead)->save();
                        if ($ccLead->category === 'dolgi') {
                            $paramsUtm = json_decode($ccLead->params, 1);
                            if (!empty($paramsUtm['sum']))
                                $summ = (int)$paramsUtm['sum'];
                        }
                        BasesUtm::refresh__statistics($lead->phone, $lead->utm_source, $summ ?? null, $lead->region ?? null);
                        $ccLead->date_outcome = date("Y-m-d H:i:s");
                        $ccLead->update();
                        $color = '#fbfff7';
                    }
                    return ['status' => 'success', 'block' => true, 'color' => $color, 'class' => 'success-lead-cc'];
                } else {
                    $ccLead->date_outcome = date("Y-m-d H:i:s");
                    $ccLead->update();
                    return ['status' => 'success', 'block' => true, 'color' => '#fff7f7', 'class' => 'waste-lead-cc'];
                }
            }
            $ccLead->update();
            return ['status' => 'success', 'message' => $_POST['serialize']];
        } else
            return ['status' => 'error', 'message' => 'Пустой запрос'];
    }

    public function actionChangeCcStatus() {
        \Yii::$app->response->format = Response::FORMAT_JSON;
        if (empty($_POST['hash']) || empty($_POST['id']))
            return ['status' => 'error', 'msg' => 'Пустой запрос'];
        else {
            $hash = md5("{$_POST['id']}::change_token_suppress");
            $user = UserModel::findOne($_POST['id']);
            if (!empty($user) && $hash === $_POST['hash']) {
                $user->cc_status = (int)!$user->cc_status;
                $user->update();
                return ['status' => 'success'];
            } else
                return ['status' => 'error', 'msg' => 'Ошибка контрольной суммы'];
        }
    }

    public function actionCcPropChange() {
        \Yii::$app->response->format = Response::FORMAT_JSON;
        if (!empty($_POST['pageSize'])) {
            $_SESSION['pageSizeCC'] = (int)$_POST['pageSize'];
            return ['status' => 'success'];
        } else
            return ['status' => 'error'];
    }


}
