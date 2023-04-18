<?php

namespace common\models;

use admin\models\Bases;
use admin\models\BasesConversion;
use admin\models\BasesFunds;
use admin\models\BasesUtm;
use api\models\Bitrix24;
use common\models\helpers\Mailer;
use common\models\helpers\TelegramBot;
use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "systemd_jobs".
 *
 * @property int $id
 * @property string $method
 * @property string $params
 * @property string $date_start
 * @property string $date_end
 * @property string|null $status
 * @property int $user_id
 * @property int $closed
 */
class JobsQueue extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'systemd_jobs';
    }

    public static $abort = ['status' => 'error', 'message' => 'Abort. Unknown method.'];

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['method', 'params', 'user_id'], 'required'],
            [['params'], 'string'],
            [['date_start', 'date_end'], 'safe'],
            [['user_id', 'closed'], 'integer'],
            [['method', 'status'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'method' => "Метод",
            'params' => 'Параметры',
            'date_start' => 'Дата начала',
            'date_end' => 'Дата окончания',
            'status' => 'Статус',
            'user_id' => 'Пользователь',
            'closed' => 'Закрыт',
        ];
    }

    public function use__method()
    {
        $params = json_decode($this->params, 1);
        return
            method_exists($this, $this->method) ?
            $this->{$this->method}($params) :
            $this::$abort;
    }

    private function test($params)
    {
        return json_encode($params, JSON_UNESCAPED_UNICODE);
    }

    private function import__csv($params)
    {
        $count = count($params['contacts']);
        $current = 0;
        $inner = 0;
        while ($current < $count) {
            $command["contact_{$current}"] = "crm.contact.add?" . http_build_query([
                'fields' => [
                    'ASSIGNED_BY_ID' => $params['data']['ASSIGNED_BY_ID'],
                    'SOURCE_ID' => $params['data']['SOURCE_ID'],
                    'TITLE' => $params['data']['TITLE'],
                    'UTM_SOURCE' => $params['data']['UTM_SOURCE'],
                    'COMMENTS' => $params['data']['COMMENTS'],
                    'NAME' => $params['contacts'][$current]['name'],
                    "PHONE" => [["VALUE" => $params['contacts'][$current]['phone'], "VALUE_TYPE" => "WORK"]]
                ],
                'params' => ['REGISTER_SONET_EVENT' => 'Y']
            ]);
            $command["deal_{$current}"] = "crm.deal.add?" . http_build_query([
                'fields' => [
                    'CATEGORY_ID' => $params['data']['CATEGORY_ID'],
                    'ASSIGNED_BY_ID' => $params['data']['ASSIGNED_BY_ID'],
                    'SOURCE_ID' => $params['data']['SOURCE_ID'],
                    'TITLE' => "{$params['contacts'][$current]['name']} ({$params['data']['TITLE']})",
                    'UTM_SOURCE' => $params['data']['UTM_SOURCE'],
                    'COMMENTS' => $params['data']['COMMENTS'],
                    'CONTACT_IDS' => ['$result[contact_' . $current . ']']
                ],
                'params' => ['REGISTER_SONET_EVENT' => 'Y']
            ]);
            $current++;
            if (++$inner === 25) {
                $cmds[] = $command;
                unset($command);
                $inner = 0;
            }
        }
        if ($inner < 25 && $inner !== 0)
            $cmds[] = $command;
        if (!empty($cmds)) {
            foreach ($cmds as $item) {
                $batch = [
                    'halt' => 0,
                    'cmd' => $item
                ];
                $bx = Bitrix24::useApi('batch', $batch);
                usleep(300000);
            }
        }
        return ['status' => 'success'];
    }

    private function registration__passed__bitrix($params)
    {
        $code = "5yrwp";
        $phone = $params['phone'];
        $bitrix = Bitrix24::useApi('crm.duplicate.findbycomm', ['type' => 'PHONE', 'values' => [$phone], 'entity_type' => "CONTACT"]);
        if (!empty($bitrix['result']['CONTACT'])) {
            $id = $bitrix['result']['CONTACT'][0];
            usleep(300000);
            $bitrix = Bitrix24::useApi('crm.deal.list', ['filter' => ['CATEGORY_ID' => "92", "CONTACT_ID" => $id]]);
            if (!empty($bitrix['result'])) {
                foreach ($bitrix['result'] as $item) {
                    $cmd["deal_{$item['ID']}"] = "crm.automation.trigger?target=DEAL_{$item['ID']}&code={$code}";
                }
                $command = [
                    'halt' => 0,
                    'cmd' => $cmd
                ];
                usleep(300000);
                $bitrix = Bitrix24::useApi('batch', $command);
                if (!empty($bitrix['result']['result_error']))
                    return ['status' => 'error'];
            }
        }
        return ['status' => 'success'];
    }

    public function send__bitrix__info($params)
    {
        $order = Orders::findOne($params['id']);
        if ($order->status == $order::STATUS_PROCESSING) {
            if ($order->leads_get >= 0) {
                $percent = (int)(($order->leads_get * 100) / $order->leads_count);
                $flags = json_decode($order->bitrix_config, 1);
                if ($percent == 100) {
                    $batch = [
                        'halt' => 0,
                        'cmd' => [
                            'item' => "crm.item.list?entityTypeId=172&filter[ufCrm1612930706779]={$order->id}",
                            'items' => "crm.item.list?entityTypeId=130&filter[ufCrm12_1666617070048]={$order->id}",
                            'item_s' => "crm.item.list?entityTypeId=136&filter[ufCrm1612930706779]={$order->id}",
                            'update' => 'crm.item.update?entityTypeId=172&id=$result[item][items][0][id]&' . http_build_query([
                                'fields' => [
                                    'STAGE_ID' => 'DT172_8:5',
                                    'ufCrm6_1666610637436' => date("Y-m-d H:i:sP")
                                ]
                            ]),
                            'updates' => 'crm.item.update?entityTypeId=130&id=$result[items][items][0][id]&' . http_build_query([
                                'fields' => [
                                    'STAGE_ID' => 'DT130_14:CLIENT'
                                ]
                            ]),
                            'update_s' => 'crm.item.update?entityTypeId=136&id=$result[item_s][items][0][id]&' . http_build_query([
                                'fields' => [
                                    'ufCrm8_1666617197128' => date("Y-m-d H:i:sP"),
                                ]
                            ]),
                        ],
                    ];
                    Bitrix24::useApi('batch', $batch);
                } elseif ($percent >= 75) {
                    if ($flags['75'] == 0) {
                        $flags['75'] = 1;
                        $order->bitrix_config = json_encode($flags, JSON_UNESCAPED_UNICODE);
                        $order->update();
                        $batch = [
                            'halt' => 0,
                            'cmd' => [
                                'item' => "crm.item.list?entityTypeId=172&filter[ufCrm1612930706779]={$order->id}",
                                'items' => "crm.item.list?entityTypeId=130&filter[ufCrm12_1666617070048]={$order->id}",
                                'item_s' => "crm.item.list?entityTypeId=136&filter[ufCrm1612930706779]={$order->id}",
                                'update' => 'crm.item.update?entityTypeId=172&id=$result[item][items][0][id]&' . http_build_query([
                                    'fields' => [
                                        'STAGE_ID' => 'DT172_8:4',
                                        'ufCrm6_1666610631836' => date("Y-m-d H:i:sP"),
                                    ]
                                ]),
                                'updates' => 'crm.item.update?entityTypeId=130&id=$result[items][items][0][id]&' . http_build_query([
                                    'fields' => [
                                        'STAGE_ID' => 'DT130_14:PREPARATION'
                                    ]
                                ]),
                                'update_s' => 'crm.item.update?entityTypeId=136&id=$result[item_s][items][0][id]&' . http_build_query([
                                    'fields' => [
                                        'ufCrm8_1666617191888' => date("Y-m-d H:i:sP"),
                                    ]
                                ]),

                            ],
                        ];
                        Bitrix24::useApi('batch', $batch);
                    }
                } elseif ($percent >= 50) {
                    if ($flags['50'] == 0) {
                        $flags['50'] = 1;
                        $order->bitrix_config = json_encode($flags, JSON_UNESCAPED_UNICODE);
                        $order->update();
                        $batch = [
                            'halt' => 0,
                            'cmd' => [
                                'item' => "crm.item.list?entityTypeId=172&filter[ufCrm1612930706779]={$order->id}",
                                'item_s' => "crm.item.list?entityTypeId=136&filter[ufCrm1612930706779]={$order->id}",
                                'update' => 'crm.item.update?entityTypeId=172&id=$result[item][items][0][id]&' . http_build_query([
                                    'fields' => [
                                        'STAGE_ID' => 'DT172_8:3',
                                        'ufCrm6_1666610623986' => date("Y-m-d H:i:sP"),
                                    ]
                                ]),
                                'updates' => 'crm.item.update?entityTypeId=136&id=$result[item_s][items][0][id]&' . http_build_query([
                                    'fields' => [
                                        'ufCrm8_1666617187575' => date("Y-m-d H:i:sP"),
                                    ]
                                ]),
                            ],
                        ];
                        Bitrix24::useApi('batch', $batch);
                    }
                } elseif ($percent >= 25) {
                    if ($flags['25'] == 0) {
                        $flags['25'] = 1;
                        $order->bitrix_config = json_encode($flags, JSON_UNESCAPED_UNICODE);
                        $order->update();
                        $batch = [
                            'halt' => 0,
                            'cmd' => [
                                'item' => "crm.item.list?entityTypeId=172&filter[ufCrm1612930706779]={$order->id}",
                                'item_s' => "crm.item.list?entityTypeId=136&filter[ufCrm1612930706779]={$order->id}",
                                'update' => 'crm.item.update?entityTypeId=172&id=$result[item][items][0][id]&' . http_build_query([
                                    'fields' => [
                                        'STAGE_ID' => 'DT172_8:2',
                                        'ufCrm6_1666610616306' => date("Y-m-d H:i:sP"),
                                    ]
                                ]),
                                'updates' => 'crm.item.update?entityTypeId=136&id=$result[item_s][items][0][id]&' . http_build_query([
                                    'fields' => [
                                        'ufCrm8_1666617180583' => date("Y-m-d H:i:sP"),
                                    ]
                                ]),
                            ],
                        ];
                        Bitrix24::useApi('batch', $batch);
                    }
                } else {
                    $batch = [
                        'halt' => 0,
                        'cmd' => [
                            'item' => "crm.item.list?entityTypeId=172&filter[ufCrm1612930706779]={$order->id}",
                            'update' => 'crm.item.update?entityTypeId=172&id=$result[item][items][0][id]&' . http_build_query(
                                    [
                                        'fields' => [
                                            'STAGE_ID' => 'DT172_8:CLIENT',
                                        ]
                                    ]
                                ),
                        ],
                    ];
                    Bitrix24::useApi('batch', $batch);
                }
            }
        } elseif ($order->status == $order::STATUS_PAUSE) {
            $batch = [
                'halt' => 0,
                'cmd' => [
                    'item' => "crm.item.list?entityTypeId=172&filter[ufCrm1612930706779]={$order->id}",
                    'update' => 'crm.item.update?entityTypeId=172&id=$result[item][items][0][id]&' . http_build_query([
                        'fields' => [
                            'STAGE_ID' => 'DT172_8:1'
                        ]
                    ]),
                ],
            ];
            Bitrix24::useApi('batch', $batch);
        } elseif ($order->status == $order::STATUS_FINISHED) {
            $batch = [
                'halt' => 0,
                'cmd' => [
                    'item' => "crm.item.list?entityTypeId=172&filter[ufCrm1612930706779]={$order->id}",
                    'item_s' => "crm.item.list?entityTypeId=136&filter[ufCrm1612930706779]={$order->id}",
                    'update' => 'crm.item.update?entityTypeId=172&id=$result[item][items][0][id]&' . http_build_query([
                        'fields' => [
                            'STAGE_ID' => 'DT172_8:SUCCESS',
                            'ufCrm6_1666610653610' => date("Y-m-d H:i:sP")
                        ]
                    ]),
                    'update_s' => 'crm.item.update?entityTypeId=136&id=$result[item_s][items][0][id]&' . http_build_query([
                        'fields' => [
                            'ufCrm8_1666617244536' => date("Y-m-d H:i:sP"),
                        ]
                    ]),
                ],
            ];
            Bitrix24::useApi('batch', $batch);
        }
    } #todo: add response statuses error or success depends on result

    public function execute__mailer($params)
    {
        $mailer = new Mailer();
        $response = $mailer
            ->setTo(trim($params['to']))
            ->setTitle($params['title'])
            ->setHtml($params['html'])
            ->process();
        return ['status' => $response ? 'success' : 'error'];
    }

    public function tg__worker00($params)
    {
        $tg = new TelegramBot();
        $rsp = $tg->new__message($params['message'], $tg::PEER_SALE);
        if ($rsp !== false)
            return ['status' => 'success'];
        else
            return ['status' => 'error'];
    }

    public function act__mailer($params)
    {
        $act = UsersCertificates::findOne($params['id']);
        if (!empty($act)) {
            $user = User::findOne($act->user_id);
            if (!empty($user) && !empty($user->email)) {
                $mailer = new Mailer();
                $response = $mailer
                    ->setTo(trim($user->email))
                    ->setTitle($act->name)
                    ->setMessage("Прикреплен акт выполненных работ")
                    ->setAttachment("/home/master/web/myforce.ru/public_html/admin/web{$act->link}")
                    ->process();
                return ['status' => $response ? 'success' : 'error'];
            }
        }
        return ['status' =>  'error'];
    }

    private function make__table($params) {
        $dateStart = $params['dateStart'];
        $dateStop = $params['dateStop'];
        $cenaKC = $params['cenaKC'];
        $msk = $params['msk'];
        $reg = $params['reg'];
        if (empty($dateStart))
            $dateStart = date("Y-m-01 00:00:00");
        else
            $dateStart = date("Y-m-01 00:00:00", strtotime($dateStart));
        if (empty($dateStop))
            $dateStop = date("Y-m-t 23:59:59");
        else
            $dateStop = date("Y-m-d 23:59:59", strtotime($dateStop));
        $alias = [
            "г Москва" => "Московская обл",
            "г Санкт-Петербург" => "Ленинградская обл"
        ];
        $REGIONS_GLOB = DbRegion::find()->select('name_with_type')->where(['not in', 'name_with_type', ['г Москва', 'г Санкт-Петербург']])->asArray()->all();
        $REGIONS_GLOB = ArrayHelper::getColumn($REGIONS_GLOB, 'name_with_type');
        sort($REGIONS_GLOB);
        function f($param, $vs, $ve) {
            return ['AND', ['>=', $param, $vs], ['<=', $param, $ve]];
        }
        function sumRash($data, $alias) {
            $rash = [];
            foreach ($data as $item) {
                $k = $alias[$item['region']] ?? $item['region'];
                if (!empty($rash[$k]))
                    $rash[$k] += $item['value'];
                else
                    $rash[$k] = $item['value'];
            }
            return $rash;
        }
        /*расходы*/
        $baseFunds = BasesFunds::find()->where(f('date', $dateStart, $dateStop))->andWhere(['type' => 'база'])->asArray()->all();
        $obzvonFunds = BasesFunds::find()->where(f('date', $dateStart, $dateStop))->andWhere(['type' => 'обзвон'])->asArray()->all();
        $potrachenoNaProzvon = sumRash($obzvonFunds, $alias); // B
        $symmarnoNaProzvon = array_sum($potrachenoNaProzvon);
        $potrachenoNaBazu = sumRash($baseFunds, $alias); // C
        $symmarnoNaBazu = array_sum($potrachenoNaBazu);
        /*расходы*/

        $conv = BasesConversion::find()->where(f('date', $dateStart, $dateStop))
            ->select('name')
            ->asArray()->groupBy('name')->all();
        $conv = ArrayHelper::getColumn($conv, 'name');

        $basesUtm = BasesUtm::find()->select("base_id, COUNT(*)")
            ->where(['in', 'name', $conv])
            ->asArray()
            ->groupBy('base_id')
            ->all();

        $otpravlenoSBazuNaProzvon = []; // D
        if (!empty($basesUtm)) {
            $basesId = ArrayHelper::getColumn($basesUtm, 'base_id');
            $basesUtm = ArrayHelper::map($basesUtm, 'base_id', "COUNT(*)");
            $basesRegions = Bases::find()->where(['in', 'id', $basesId])->select(['geo', 'id'])->asArray()->all();
            $regions = ArrayHelper::map($basesRegions, 'id', 'geo');
            foreach ($basesUtm as $key => $val) {
                $k = $alias[$regions[$key]] ?? $regions[$key];
                if (empty($otpravlenoSBazuNaProzvon[$k]))
                    $otpravlenoSBazuNaProzvon[$k] = $val;
                else
                    $otpravlenoSBazuNaProzvon[$k] += $val;
            }
        }
        if (isset($otpravlenoSBazuNaProzvon['Любой']))
            unset($otpravlenoSBazuNaProzvon['Любой']);

        $otpravlenoSBDnaProzvonTotal = CcLeads::find()
            ->where(f('date_income', $dateStart, $dateStop))
            ->select('region, COUNT(*)')
            ->andWhere(['utm_source' => 'backdoor'])
            ->andWhere(['category' => 'dolgi'])
            ->groupBy('region')
            ->asArray()->all();

        if (!empty($otpravlenoSBDnaProzvonTotal)) { //E
            $otpravlenoSBDnaProzvonTotal = ArrayHelper::map($otpravlenoSBDnaProzvonTotal, 'region', 'COUNT(*)');
            foreach ($alias as $k => $v) {
                if (isset($otpravlenoSBDnaProzvonTotal[$k])) {
                    if (empty($otpravlenoSBDnaProzvonTotal[$v]))
                        $otpravlenoSBDnaProzvonTotal[$v] = $otpravlenoSBDnaProzvonTotal[$k];
                    else
                        $otpravlenoSBDnaProzvonTotal[$v] += $otpravlenoSBDnaProzvonTotal[$k];
                    unset($otpravlenoSBDnaProzvonTotal[$k]);
                }
            }
        } else
            $otpravlenoSBDnaProzvonTotal = []; //E

        $edinichekPriwlo = CcLeads::find()
            ->where(f('date_income', $dateStart, $dateStop))
            ->select('region, COUNT(*)')
            ->andWhere(['like', 'source', "%обз%", false])
            ->andWhere(['!=', 'utm_source', 'backdoor'])
            ->andWhere(['category' => 'dolgi'])
            ->groupBy('region')
            ->asArray()->all();

        if (!empty($edinichekPriwlo)) { //G
            $edinichekPriwlo = ArrayHelper::map($edinichekPriwlo, 'region', 'COUNT(*)');
            foreach ($alias as $k => $v) {
                if (isset($edinichekPriwlo[$k])) {
                    if (empty($edinichekPriwlo[$v]))
                        $edinichekPriwlo[$v] = $edinichekPriwlo[$k];
                    else
                        $edinichekPriwlo[$v] += $edinichekPriwlo[$k];
                    unset($edinichekPriwlo[$k]);
                }
            }
        } else
            $edinichekPriwlo = []; //G

        $cenaZaEdinichky = []; //H
        foreach ($edinichekPriwlo as $key => $item) {
            if (isset($potrachenoNaProzvon[$key]))
                $cenaZaEdinichky[$key] = $potrachenoNaProzvon[$key] / $item;
            else
                $cenaZaEdinichky[$key] = 0;
        }

        $leads = Leads::find()->where(f('date_income', $dateStart, $dateStop))
            ->andWhere(['OR', ['cc_check' => 1], ['source' => 'Ручной']])
            ->andWhere(['type' => 'dolgi'])
            ->asArray()->select(['region', 'params', 'utm_source', 'source'])->all();

        $lidovMenee250BD = [];
        $lidovMenee250 = [];
        $lidovBolee250BD = [];
        $lidovBolee250 = [];
        $lidovTotal = [];
        $lidovTotalBD = [];
        $leadsInTotal = [];
        $ruchnoi = [];
        if (!empty($leads)) {
            foreach ($leads as $item) {
                $k = $alias[$item['region']] ?? $item['region'];
                if (!isset($lidovMenee250BD[$k]))
                    $lidovMenee250BD[$k] = 0;
                if (!isset($lidovBolee250BD[$k]))
                    $lidovBolee250BD[$k] = 0;
                if (!isset($lidovTotalBD[$k]))
                    $lidovTotalBD[$k] = 0;
                if (!isset($lidovMenee250[$k]))
                    $lidovMenee250[$k] = 0;
                if (!isset($lidovBolee250[$k]))
                    $lidovBolee250[$k] = 0;
                if (!isset($lidovTotal[$k]))
                    $lidovTotal[$k] = 0;
                if (!isset($leadsInTotal[$k]))
                    $leadsInTotal[$k] = 0;
                if (!isset($ruchnoi[$k]))
                    $ruchnoi[$k] = 0;
                $params = json_decode($item['params'], true);
                if ($item['source'] === 'ручной' || $item['source'] === 'Ручной' ) {
                    $ruchnoi[$k]++;
                } else {
                    if ($item['utm_source'] === 'backdoor') {
                        if (empty($params['sum']) || (float)$params['sum'] < 250000) {
                            $lidovMenee250BD[$k]++;
                        } else
                            $lidovBolee250BD[$k]++;
                        $lidovTotalBD[$k]++;
                        $leadsInTotal[$k]++;
                    } elseif ($item['utm_source'] !== 'backdoor' && $item['source'] !== 'ручной' && $item['source'] !== 'Ручной') {
                        if (empty($params['sum']) || (float)$params['sum'] < 250000) {
                            $lidovMenee250[$k]++;
                        } else
                            $lidovBolee250[$k]++;
                        $lidovTotal[$k]++;
                        $leadsInTotal[$k]++;
                    }
                }
            }
        }

        ksort($lidovMenee250BD); //I
        ksort($lidovMenee250); //J
        ksort($lidovBolee250BD); //R
        ksort($lidovBolee250); //Q
        ksort($lidovTotal); //K
        ksort($lidovTotalBD); //L
        ksort($leadsInTotal); //M
        ksort($ruchnoi); //S

        $rashodKcProzvonPlusBD = []; //F

        foreach ($lidovTotalBD as $key => $item) {
            if (!empty($edinichekPriwlo[$key])) {
                $rashodKcProzvonPlusBD[$key] = ($item + $edinichekPriwlo[$key]) * $cenaKC;
            }
            else
                $rashodKcProzvonPlusBD[$key] = $item * $cenaKC;
        }

        $cenaLidaSProzvona = []; //N
        $cenaCelevogoSprozvona = []; //U
        foreach ($cenaZaEdinichky as $key => $item) {
            $p = $potrachenoNaProzvon[$key] ?? 0;
            if (isset($lidovTotal[$key]) && $lidovTotal[$key] > 0)
                $cenaLidaSProzvona[$key] = ($p + ($item + $cenaKC)*$edinichekPriwlo[$key])/$lidovTotal[$key];
            else
                $cenaLidaSProzvona[$key] = 0;
            if (isset($lidovBolee250[$key]) && $lidovBolee250[$key] > 0)
                $cenaCelevogoSprozvona[$key] = ($p + ($item + $cenaKC)*$edinichekPriwlo[$key])/$lidovBolee250[$key];
            else
                $cenaCelevogoSprozvona[$key] = 0;
        }

        $potrachenoNaObrabotkyBD = []; //O
        foreach ($lidovTotalBD as $key => $item) {
            $potrachenoNaObrabotkyBD[$key] = $item * $cenaKC;
        }
        $obshayaCenaLida = []; //P
        foreach ($leadsInTotal as $key => $item) {
            if ($item > 0) {
                $b = $potrachenoNaProzvon[$key] ?? 0;
                $c = $potrachenoNaBazu[$key] ?? 0;
                $f = $rashodKcProzvonPlusBD[$key] ?? 0;
                $obshayaCenaLida[$key] = ($b + $c + $f)/$item;
            } else
                $obshayaCenaLida[$key] = 0;
        }

        $vsegoCelevuh = []; //T
        foreach ($lidovBolee250 as $key => $item) {
            $vsegoCelevuh[$key] = $item + $lidovBolee250BD[$key] + $ruchnoi[$key];
        }

        $cenaCelevogoSBD = []; //V
        foreach ($lidovBolee250BD as $key => $item){
            if ($item > 0) {
                $cenaCelevogoSBD[$key] = $potrachenoNaObrabotkyBD[$key]/$item;
            } else
                $cenaCelevogoSBD[$key] = 0;
        }

        $obshayaCenaPLATNUI = []; //W
        $obshayaCenaCELEVUH = []; //X
        $vugodaSRuchnumi = []; //Y
        $pribulS1Lida = []; //Z
        $pribulSoVsehLidov = []; //AA
        $pribulSoVsehCELEVUH = []; //AB
        $lidovKyplenoNa = []; //AC
        $kontaktovNaEdinicy = []; //AD
        $prognozKonversiiVLID = []; //AE
        $prognozKonversiiVCELEVOI = []; //AF
        $bdConversiaVLID = []; //AG
        $bdConversiaVCELEVOI = []; //AH
        foreach ($REGIONS_GLOB as $key) {
            $b = $potrachenoNaProzvon[$key] ?? 0;
            $c = $potrachenoNaBazu[$key] ?? 0;
            $f = $rashodKcProzvonPlusBD[$key] ?? 0;
            $q = $lidovBolee250[$key] ?? 0;
            $r = $lidovBolee250BD[$key] ?? 0;
            $t = $vsegoCelevuh[$key] ?? 0;
            $d = $otpravlenoSBazuNaProzvon[$key] ?? 0;
            $g = $edinichekPriwlo[$key] ?? 0;
            $K = $lidovTotal[$key] ?? 0;
            $l = $lidovTotalBD[$key] ?? 0;
            $e = $otpravlenoSBDnaProzvonTotal[$key] ?? 0;
            if ($q + $r > 0) {
                $obshayaCenaPLATNUI[$key] = ($b + $c + $f)/($q + $r);
            } else
                $obshayaCenaPLATNUI[$key] = 0;
            if ($t > 0) {
                $obshayaCenaCELEVUH[$key] = ($b + $c + $f)/($t);
            } else {
                $obshayaCenaCELEVUH[$key] = 0;
            }
            $vugodaSRuchnumi[$key] = $obshayaCenaPLATNUI[$key] - $obshayaCenaCELEVUH[$key];
            if ($key === 'Московская обл' || $key === 'Ленинградская обл') {
                $pribulS1Lida[$key] = $msk - $obshayaCenaCELEVUH[$key];
                $lidovKyplenoNa[$key] = $msk * ($leadsInTotal[$key] ?? 0);
            }
            else{
                $pribulS1Lida[$key] = $reg - $obshayaCenaCELEVUH[$key];
                $lidovKyplenoNa[$key] = $reg * ($leadsInTotal[$key] ?? 0);
            }
            $pribulSoVsehLidov[$key] = $pribulS1Lida[$key] * ($leadsInTotal[$key] ?? 0);
            $pribulSoVsehCELEVUH[$key] = $pribulS1Lida[$key] * $t;
            if ($g > 0) {
                $kontaktovNaEdinicy[$key] = $d/$g;
                $prognozKonversiiVLID[$key] = (100*$K)/$g;
                $prognozKonversiiVCELEVOI[$key] = (100*$q)/$g;
            }
            else {
                $kontaktovNaEdinicy[$key] = 0;
                $prognozKonversiiVLID[$key] = 0;
                $prognozKonversiiVCELEVOI[$key] = 0;
            }
            if ($e > 0) {
                $bdConversiaVLID[$key] = (100*$l)/$e;
                $bdConversiaVCELEVOI[$key] = (100*$r)/$e;
            } else {
                $bdConversiaVLID[$key] = 0;
                $bdConversiaVCELEVOI[$key] = 0;
            }
        }

        //$symmarnoNaProzvon //B SUMM
        //$symmarnoNaBazu //C SUMM
        $otpravlenoSBazuNaProzvonSUMM = array_sum($otpravlenoSBazuNaProzvon); //D SUMM
        $otpravlenoSBDnaProzvonTotalSUMM = array_sum($otpravlenoSBDnaProzvonTotal); //E SUMM
        $rashodKcProzvonPlusBDSUMM = array_sum($rashodKcProzvonPlusBD); //F SUMM
        $edinichekPriwloSUMM = array_sum($edinichekPriwlo); //G SUMM
        $cenaZaEdinichkySRZNACH = array_sum($cenaZaEdinichky)/count($cenaZaEdinichky); //H SUMM
        $lidovMenee250BDSUMM = array_sum($lidovMenee250BD); //I SUMM
        $lidovMenee250SUMM = array_sum($lidovMenee250); //J SUMM
        $lidovTotalSUMM = array_sum($lidovTotal); //K SUMM
        $lidovTotalBDSUMM = array_sum($lidovTotalBD); //L SUMM
        $leadsInTotalSUMM = array_sum($leadsInTotal); //M SUMM
        $cenaLidaSProzvonaSRZNACH = array_sum($cenaLidaSProzvona)/count($cenaLidaSProzvona); //N SUMM
        $obshayaCenaLidaSRZNACH = array_sum($obshayaCenaLida)/count($obshayaCenaLida); //P SUMM
        $vsegoCelevuhSUMM = array_sum($vsegoCelevuh); //T SUMM
        $cenaCelevogoSprozvonaSRZNACH = array_sum($cenaCelevogoSprozvona)/count($cenaCelevogoSprozvona); //U SUMM
        $cenaCelevogoSBDSRZNACH = array_sum($cenaCelevogoSBD)/count($cenaCelevogoSBD); //V SUMM
        $obshayaCenaCELEVUHSRZNACH = array_sum($obshayaCenaCELEVUH)/count($obshayaCenaCELEVUH); //X SUMM
        $pribulSoVsehLidovSUMM = array_sum($pribulSoVsehLidov); //AA SUMM
        $pribulSoVsehCELEVUHSUMM = array_sum($pribulSoVsehCELEVUH); //AB SUMM
        $lidovKyplenoNaSUMM = array_sum($lidovKyplenoNa); //AC SUMM
        $kontaktovNaEdinicySRZNACH = array_sum($kontaktovNaEdinicy)/count($kontaktovNaEdinicy); //AD SUMM
        $prognozKonversiiVLIDSRZNACH = array_sum($prognozKonversiiVLID)/count($prognozKonversiiVLID); //AE SUMM
        $prognozKonversiiVCELEVOISRZNACH = array_sum($prognozKonversiiVCELEVOI)/count($prognozKonversiiVCELEVOI); //AF SUMM
        $bdConversiaVLIDSRZNACH = array_sum($bdConversiaVLID)/count($bdConversiaVLID); //AG SUMM
        $bdConversiaVCELEVOISRZNACH = array_sum($bdConversiaVCELEVOI)/count($bdConversiaVCELEVOI); //AH SUMM

        $fp = fopen('/home/master/web/myforce.ru/public_html/admin/web/leads_2_1.csv', 'w');
        $dataset['000'] = [
            "Регион", "Расход на прозвон", "Расход на базы", "Отправлено с базы на прозвон",
            "Отправлено с БД на прозвон", "Расход Прозвон + БД", "Единичек пришло",
            "Цена за единичку", "Лидов менее 250 БД", "Лидов менее 250", "Всего лидов с прозвона", "Всего лидов с прозвона БД", "Всего лидов",
            "Цена лида с прозвона", "Потрачено на обработку БД", "Общая цена лида", "Лидов более 250", "Лидов более 250 БД",
            "Ручных лидов", "Всего целевых", "Цена целевого с прозвона", "Цена целевого с БД", "Общая цена платных", "Общая цена целевых",
            "Выгода с ручными", "Прибыль с 1 лида", "Прибыль со всех лидов", "Прибыль со всех целевых", "Лидов куплено на", "Контактов на единичку",
            "Прогноз конверсии в лид, %", "Прогноз конверсии в целевой, %", "БД конверсия в лид, %", "БД конверсия в целевой, %"
        ];
        foreach ($REGIONS_GLOB as $key) {
            $dataset[$key] = [
                $key, $potrachenoNaProzvon[$key] ?? 0, $potrachenoNaBazu[$key] ?? 0, $otpravlenoSBazuNaProzvon[$key] ?? 0,
                $otpravlenoSBDnaProzvonTotal[$key] ?? 0, $rashodKcProzvonPlusBD[$key] ?? 0, $edinichekPriwlo[$key] ?? 0,
                $cenaZaEdinichky[$key] ?? 0, $lidovMenee250BD[$key] ?? 0, $lidovMenee250[$key] ?? 0, $lidovTotal[$key] ?? 0, $lidovTotalBD[$key] ?? 0, $leadsInTotal[$key] ?? 0,
                $cenaLidaSProzvona[$key] ?? 0, $potrachenoNaObrabotkyBD[$key] ?? 0, $obshayaCenaLida[$key] ?? 0, $lidovBolee250[$key] ?? 0, $lidovBolee250BD[$key] ?? 0,
                $ruchnoi[$key] ?? 0, $vsegoCelevuh[$key] ?? 0, $cenaCelevogoSprozvona[$key] ?? 0, $cenaCelevogoSBD[$key] ?? 0, $obshayaCenaPLATNUI[$key] ?? 0, $obshayaCenaCELEVUH[$key] ?? 0,
                $vugodaSRuchnumi[$key] ?? 0, $pribulS1Lida[$key] ?? 0, $pribulSoVsehLidov[$key] ?? 0, $pribulSoVsehCELEVUH[$key] ?? 0, $lidovKyplenoNa[$key] ?? 0, $kontaktovNaEdinicy[$key] ?? 0,
                $prognozKonversiiVLID[$key]  ?? 0, $prognozKonversiiVCELEVOI[$key] ?? 0, $bdConversiaVLID[$key] ?? 0, $bdConversiaVCELEVOI[$key] ?? 0
            ];
            foreach ($dataset[$key] as $l => $j) {
                if (is_numeric($j) && is_float($j))
                    $dataset[$key][$l] = round($j, 2);
            }
        }
        $dataset['zzz'] = [
            'ИТОГО:', $symmarnoNaProzvon, $symmarnoNaBazu, $otpravlenoSBazuNaProzvonSUMM,
            $otpravlenoSBDnaProzvonTotalSUMM, $rashodKcProzvonPlusBDSUMM, $edinichekPriwloSUMM,
            $cenaZaEdinichkySRZNACH, $lidovMenee250BDSUMM, $lidovMenee250SUMM, $lidovTotalSUMM, $lidovTotalBDSUMM,$leadsInTotalSUMM,
            $cenaLidaSProzvonaSRZNACH, '', $obshayaCenaLidaSRZNACH, '', '',
            '', $vsegoCelevuhSUMM, $cenaCelevogoSprozvonaSRZNACH, $cenaCelevogoSBDSRZNACH, '', $obshayaCenaCELEVUHSRZNACH,
            '', '', $pribulSoVsehLidovSUMM, $pribulSoVsehCELEVUHSUMM, $lidovKyplenoNaSUMM, $kontaktovNaEdinicySRZNACH,
            $prognozKonversiiVLIDSRZNACH, $prognozKonversiiVCELEVOISRZNACH, $bdConversiaVLIDSRZNACH, $bdConversiaVCELEVOISRZNACH
        ];
        foreach ($dataset as $fields) {
            fputcsv($fp, $fields);
        }

        fclose($fp);
    }


}
