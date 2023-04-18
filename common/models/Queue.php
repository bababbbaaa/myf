<?php


namespace common\models;

use common\behaviors\JsonQuery;
use yii\db\ActiveQuery;
use yii\helpers\ArrayHelper;

/**
 * Class Queue
 * @package common\models
 */

class Queue
{

    const OPTION_RESTRICTED_REGIONS = 'restricted_regions';
    const OPTION_RESTRICTED_SOURCES = 'restricted_sources';
    const OPTION_START_TIME_LEADGAIN = 'start_time_leadgain';
    const OPTION_END_TIME_LEADGAIN = 'end_time_leadgain';
    const OPTION_ASSIGNED_SOURCES_FILTER = 'assigned_sources_filter';
    const OPTION_ASSIGNED_SOURCES = 'assigned_sources';
    const OPTION_DAILY_LEADS_MIN = 'daily_leads_min';
    const OPTION_DAILY_LEADS_MAX = 'daily_leads_max';
    const OPTION_ONLY_SMS_VERIFIED = 'only_sms_verified';
    const OPTION_ONLY_CC_VERIFIED = 'only_cc_verified';
    const OPTION_CC_LEADGAIN_QUEUE = 'cc_leadgain_queue';
    const OPTION_CC_LEADGAIN_REGION = 'cc_leadgain_region';
    const OPTION_DUPLICATE_LEAD_CONTROL = 'duplicate_lead_control';
    const OPTION_AUTOCALLS = 'autocalls';
    const OPTION_QUEUE = 'queue';
    const OPTION_DAYS_LEADGAIN = 'days_of_week_leadgain';
    const OPTION_RANDOM_QUEUE = 'random_queue';

    const COMPARISON_INTERVAL = 'interval';
    const COMPARISON_EQUALS = 'equals';
    const COMPARISON_NOT_NULL = 'notNull';

    const TYPE_STRING = 'string';
    const TYPE_NUMBER = 'number';

    const STATUS_SKIP = 0;
    const STATUS_CONFIRM = 1;
    const STATUS_STOP = -1;

    const VALUE_TRUE = "да";

    public $count;
    public $restrictedIds;
    public $limit;
    public $batch;
    public $log = [];

    public function __construct($limit = 100)
    {
        $this->limit = $limit;
    }

    public function start__batch()
    {
        $this->count = Leads::find()
            ->where(['status' => Leads::STATUS_NEW])
            ->count();
        $this->batch = ceil($this->count / $this->limit);
        $this->log['system'][] = date("d.m.Y H:i:s") . ": Начало выборки... Размер пачки - {$this->count} шт.";
        return $this->go__query();
    }

    private function filtered($config, $high_priority = false) {
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
                ->JsonContains([$config['source']], self::OPTION_ASSIGNED_SOURCES_FILTER)
        ];
        if($config['cc'] === 1) {
            $this->log['lead'][$config['lead_id']][] = "Т.к. лид # {$config['lead_id']} был проверен КЦ - делаем выборку по заказам, получающим лидов с КЦ...";
            $filter[] = (new JsonQuery('params_special'))
                ->JsonContains([self::OPTION_CC_LEADGAIN_QUEUE => self::VALUE_TRUE]);
        } elseif ($config['autocalls'] === 1) {
            $this->log['lead'][$config['lead_id']][] = "Т.к. лид # {$config['lead_id']} пришел с прозвона - делаем выборку по заказам, получающим лидов с прозвона...";
            $filter[] = (new JsonQuery('params_special'))
                ->JsonContains([self::OPTION_AUTOCALLS => self::VALUE_TRUE]);
        }
        if ($high_priority) {
            $this->log['lead'][$config['lead_id']][] = "Поиск первоочередных заказов (заказов с высоким приоритетом)...";
            $orders = Orders::find()
                ->where($filter)
                ->andWhere(['archive' => 0])
                ->andWhere(['high_priority_order' => 1])
                ->orderBy(['last_lead_get' => SORT_ASC])
                ->asArray();
            if (!empty($this->restrictedIds)) {
                $orders = $orders->andWhere(['not in', 'id', $this->restrictedIds]);
            }
            $orders = $orders->all();
            if (empty($orders)) {
                $this->log['lead'][$config['lead_id']][] = "Заказы с высоким приоритетом не найдены в первичной выборке. Поиск по приоритетным заказам в порядке очереди...";
                $orders = $this->get__queue_orders($config, $high_priority);
            }
        } else {
            $this->log['lead'][$config['lead_id']][] = "Поиск заказов обычного приоритета...";
            $orders = Orders::find()
                ->where($filter)
                ->andWhere(['archive' => 0])
                ->orderBy(['last_lead_get' => SORT_ASC])
                ->asArray();
            if (!empty($this->restrictedIds)) {
                $orders = $orders->andWhere(['not in', 'id', $this->restrictedIds]);
            }
            $orders = $orders->all();
        }
        if (empty($orders) && !$high_priority) {
            $this->log['lead'][$config['lead_id']][] = "Заказы с учетом выбранных параметров не были обнаружены. Запускаем поиск по клиентам...";
            $clients = Clients::find()
                ->select(['id'])
                ->where((new JsonQuery('custom_params'))
                    ->JsonContains([$config['source']], self::OPTION_ASSIGNED_SOURCES_FILTER))
                ->andWhere(['archive' => 0])
                ->asArray()
                ->all();
            if (!empty($clients)) {
                $clArr = [];
                foreach ($clients as $cl) {
                    $clArr[] = $cl['id'];
                }
                $this->log['lead'][$config['lead_id']][] = "Найдены клиенты: " . json_encode($clArr) . ". Получаем последний релевантный заказ...";
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
                    $this->log['lead'][$config['lead_id']][] = "Добавляем условие поиска по КЦ...";
                    $filter[] = (new JsonQuery('params_special'))
                        ->JsonContains([self::OPTION_CC_LEADGAIN_QUEUE => self::VALUE_TRUE]);
                } elseif ($config['autocalls'] === 1) {
                    $this->log['lead'][$config['lead_id']][] = "Добавляем условие поиска по прозвону...";
                    $filter[] = (new JsonQuery('params_special'))
                        ->JsonContains([self::OPTION_AUTOCALLS => self::VALUE_TRUE]);
                }
                $orders = Orders::find()
                    ->where($filter)
                    ->andWhere(['archive' => 0])
                    ->orderBy('last_lead_get asc')
                    ->asArray();
                if (!empty($this->restrictedIds)) {
                    $orders = $orders->andWhere(['not in', 'id', $this->restrictedIds]);
                }
                $orders = $orders->all();
                if (empty($orders)) {
                    $this->log['lead'][$config['lead_id']][] = "Заказы по указанным параметрам не найдены. Запускаем поиск по заказам, находящимся в очереди на общих правилах...";
                    $orders = $this->get__queue_orders($config);
                }
            } else {
                $this->log['lead'][$config['lead_id']][] = "Клиенты не найдены. Запускаем поиск по заказам, находящимся в очереди на общих правилах...";
                $orders = $this->get__queue_orders($config);
            }
        }
        return $orders;
    }

    private function get__queue_orders($config, $high_prio = false) {
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
        ];
        if($config['cc'] === 1) {
            $this->log['lead'][$config['lead_id']][] = "Добавляем условие поиска по КЦ...";
            $filter[] = (new JsonQuery('params_special'))->JsonContains([self::OPTION_CC_LEADGAIN_QUEUE => self::VALUE_TRUE]);
        } elseif ($config['autocalls'] === 1) {
            $this->log['lead'][$config['lead_id']][] = "Добавляем условие поиска по прозвону...";
            $filter[] = (new JsonQuery('params_special'))->JsonContains([self::OPTION_AUTOCALLS => self::VALUE_TRUE]);
        } else {
            $filter[] = (new JsonQuery('params_special'))->JsonContains([self::OPTION_QUEUE => self::VALUE_TRUE]);
        }
        $orders = Orders::find()
            ->where($filter)
            ->andWhere(['archive' => 0]);
        if ($high_prio)
            $orders = $orders->andWhere(['high_priority_order' => 1]);
        if (!empty($this->restrictedIds)) {
            $orders = $orders->andWhere(['not in', 'id', $this->restrictedIds]);
        }
        $orders = $orders
            ->orderBy(['last_lead_get' => SORT_ASC])
            ->asArray()
            ->all();
        return $orders;
    }

    private function get__options($active){
        if (is_array($active)) {
            $options['paramsCategory'] = json_decode($active['params_category'], true);
            $options['paramsSpecial'] = json_decode($active['params_special'], true);
            $client = Clients::find()
                ->where(['id' => $active['client']])
                ->andWhere(['archive' => 0])
                ->asArray()
                ->one();
            $cParams = json_decode($client['custom_params'], 1);
            if (!empty($cParams))
                $options['paramsSpecial'] = array_merge($cParams, $options['paramsSpecial']);
        } else
            $options = null;
        return $options;
    }

    /**
     * @param $options array
     * @param $lead Leads
     * @param $orderId integer
     * @return integer
     */
    private function special__params__validation($options, $lead, $orderId) {
        foreach ($options['paramsSpecial'] as $key => $option) {
            switch ($key) {

                case self::OPTION_RESTRICTED_REGIONS:
                    if (in_array($lead->city, $option) || in_array($lead->region, $option))  {
                        $this->log['lead'][$lead->id][] = "<span style='color: #d9534f'>Заказ #{$orderId} не подходит, т.к. лид пришел с исключенного региона или города. Переход на следующую итерацию...</span>";
                        return self::STATUS_SKIP;
                    }
                    break;

                case self::OPTION_RESTRICTED_SOURCES:
                    if (in_array($lead->source, $option)) {
                        $this->log['lead'][$lead->id][] = "<span style='color: #d9534f'>Заказ #{$orderId} не подходит, т.к. лид пришел с исключенного источника. Переход на следующую итерацию...</span>";
                        return self::STATUS_SKIP;
                    }
                    break;

                case self::OPTION_START_TIME_LEADGAIN:
                    if ((int)date("G") < (int)$option) {
                        $this->log['lead'][$lead->id][] = "<span style='color: #d9534f'>Заказ #{$orderId} не подходит, т.к. текущий час отправки меньше, чем минимальный указанный час. Переход на следующую итерацию...</span>";
                        return self::STATUS_SKIP;
                    }
                    break;

                case self::OPTION_END_TIME_LEADGAIN:
                    if ((int)date("G") >= (int)$option) {
                        $this->log['lead'][$lead->id][] = "<span style='color: #d9534f'>Заказ #{$orderId} не подходит, т.к. текущий час отправки больше либо уже равен максимальному указанному часу. Переход на следующую итерацию...</span>";
                        return self::STATUS_SKIP;
                    }
                    break;

                case self::OPTION_DAYS_LEADGAIN:
                    if (is_array($option) && !in_array(date("N"), $option)) {
                        $this->log['lead'][$lead->id][] = "<span style='color: #d9534f'>Заказ #{$orderId} не подходит, т.к. сегодняшний день недели не попадает в перечень допустимых дней отгрузки...</span>";
                        return self::STATUS_SKIP;
                    }
                    break;

                case self::OPTION_DAILY_LEADS_MAX:
                    $aliases = LeadsSentReport::find()
                        ->where([
                            'AND',
                            [
                                'order_id' => $orderId
                            ],
                            [
                                'AND',
                                [
                                    '>=',
                                    'date',
                                    date("Y-m-d 00:00:00")
                                ],
                                [
                                    '<=',
                                    'date',
                                    date("Y-m-d 23:59:59")
                                ],
                            ]
                        ])
                        ->count();
                    if ($aliases >= $option)  {
                        $this->log['lead'][$lead->id][] = "<span style='color: #d9534f'>Заказ #{$orderId} не подходит, т.к. по данному заказу за сегодня уже получено {$aliases} из {$option} лидов. Переход на следующую итерацию...</span>";
                        return self::STATUS_SKIP;
                    }
                    break;

                case self::OPTION_ONLY_SMS_VERIFIED:
                    if ($lead->sms_check !== 1)  {
                        $this->log['lead'][$lead->id][] = "<span style='color: #d9534f'>Заказ #{$orderId} не подходит, т.к. данный заказ принимает ТОЛЬКО верифицированных по SMS лидов. Переход на следующую итерацию...</span>";
                        return self::STATUS_SKIP;
                    }
                    break;

                case self::OPTION_ONLY_CC_VERIFIED:
                    if ($lead->cc_check !== 1) {
                        $this->log['lead'][$lead->id][] = "<span style='color: #d9534f'>Заказ #{$orderId} не подходит, т.к. данный заказ принимает ТОЛЬКО проверенных КЦ лидов. Переход на следующую итерацию...</span>";
                        return self::STATUS_SKIP;
                    }
                    break;

                case self::OPTION_DUPLICATE_LEAD_CONTROL:
                    $duplicates = Leads::find()
                        ->select('id')
                        ->where(['AND', ['phone' => $lead->phone], ['OR', ['status' => Leads::STATUS_SENT], ['status' => Leads::STATUS_WASTE], ['status' => Leads::STATUS_CONFIRMED], ['status' => Leads::STATUS_INTERVAL]]])
                        ->asArray()
                        ->all();
                    if (!empty($duplicates)) {
                        $orderProps = Orders::findOne($orderId);
                        $client = !empty($orderProps) && !empty($orderProps->client) ? $orderProps->client : null;
                        $dupArray = [];
                        foreach ($duplicates as $item)
                            $dupArray[] = $item['id'];
                        if (empty($client))
                            $alias = LeadsSentReport::find()
                            ->where(['AND', ['order_id' => $orderId], ['in', 'lead_id', $dupArray]])
                            ->count();
                        else
                            $alias = LeadsSentReport::find()
                                ->where(['AND', ['client_id' => $client], ['in', 'lead_id', $dupArray]])
                                ->count();
                        if ((int)$alias > 0)  {
                            $this->log['lead'][$lead->id][] = "<span style='color: #d9534f'>Заказ #{$orderId} не подходит, т.к. лид с указанным номером телефона уже когда-то отправлялся в данный заказ. Переход на следующую итерацию...</span>";
                            return self::STATUS_SKIP;
                        }
                    }
                    break;

                case self::OPTION_RANDOM_QUEUE:
                    if ($lead->type === 'dolgi') {
                        $rnd = RandomQueue::findOne(['order_id' => $orderId]);
                        if (!empty($rnd)) {
                            if ($rnd->get250down >= $rnd->count250down && $rnd->get250up >= $rnd->count250up) {
                                $rnd->generateRandom($orderId);
                                $rnd->update();
                            }
                            if (!empty($lead->params['sum']) && $lead->params['sum'] >= 250000) {
                                if ($rnd->get250up >= $rnd->count250up) {
                                    $this->log['lead'][$lead->id][] = "<span style='color: #d9534f'>Заказ #{$orderId} не подходит, т.к. в данном заказе установлена опция случайного распределения по сумме долга от 250к и до 250к. В данный момент получено {$rnd->get250up} / {$rnd->count250up} лидов от 250 тыс. долга в текущем цикле. Переход на следующую итерацию...</span>";
                                    return self::STATUS_SKIP;
                                } else {
                                    $rnd->get250up++;
                                    $rnd->update();
                                }
                            } else {
                                if ($rnd->get250down >= $rnd->count250down) {
                                    $this->log['lead'][$lead->id][] = "<span style='color: #d9534f'>Заказ #{$orderId} не подходит, т.к. в данном заказе установлена опция случайного распределения по сумме долга от 250к и до 250к. В данный момент получено {$rnd->get250down} / {$rnd->count250down} лидов до 250 тыс. долга в текущем цикле. Переход на следующую итерацию...</span>";
                                    return self::STATUS_SKIP;
                                } else {
                                    $rnd->get250down++;
                                    $rnd->update();
                                }
                            }
                        }
                    }
                    break;

            }
        }
        $this->log['lead'][$lead->id][] = "<span style='color: #3c75ff'>Заказ #{$orderId} прошел проверку по всем СПЕЦИАЛЬНЫМ ПАРАМЕТРАМ.</span>";
        return self::STATUS_CONFIRM;
    }


    /**
     * @param $lead Leads
     * @return array|Orders|\yii\db\ActiveRecord|null
     */
    private function get__preprocessed($lead) {
        if ($lead->cc_check === 1) {
            $this->log['lead'][$lead->id][] = "Обнаружено, что лид #{$lead->id} был проверен КЦ. Подбираем заказы, которые получают 100% лидов с КЦ по указанному региону.";
            $order = Orders::find()
                ->where([
                    'OR',
                    (new JsonQuery('params_special'))
                        ->JsonContains([$lead->region], self::OPTION_CC_LEADGAIN_REGION),
                    (new JsonQuery('params_special'))
                        ->JsonContains([$lead->city], self::OPTION_CC_LEADGAIN_REGION)
                ])
                ->andWhere(['status' => Orders::STATUS_PROCESSING])
                ->andWhere(['archive' => 0])
                ->orderBy('last_lead_get asc');
            if (!empty($this->restrictedIds)) {
                $order = $order->andWhere(['not in', 'id', $this->restrictedIds]);
            }
            $order = $order->one();
            if (!empty($order))
                return $order;
            else {
                $this->log['lead'][$lead->id][] = "Заказ, получающий 100% по региону с КЦ, не найден. Переходим к поиску по источнику...";
            }
        }
        $this->log['lead'][$lead->id][] = "Подбираем заказы, привязанные к источнику лида ({$lead->source}) ...";
        $order = Orders::find()
            ->where((new JsonQuery('params_special'))
                ->JsonContains([$lead->source], self::OPTION_ASSIGNED_SOURCES))
            ->andWhere(['status' => Orders::STATUS_PROCESSING])
            ->andWhere(['archive' => 0])
            ->orderBy('last_lead_get asc');
        if (!empty($this->restrictedIds)) {
            $order = $order->andWhere(['not in', 'id', $this->restrictedIds]);
        }
        $order = $order->one();
        if (empty($order)) {
            $this->log['lead'][$lead->id][] = "Заказы, связанные с источником {$lead->source}, не найдены. Запускаем поиск по клиентам ...";
            $clients = Clients::find()
                ->select(['id'])
                ->where((new JsonQuery('custom_params'))
                    ->JsonContains([$lead->source], self::OPTION_ASSIGNED_SOURCES))
                ->andWhere(['archive' => 0])
                ->asArray()
                ->all();
            if (!empty($clients)) {
                $this->log['lead'][$lead->id][] = "Обнаружены клиенты, связанные с источником {$lead->source}: ";
                $clArr = [];
                foreach ($clients as $cl) {
                    $clArr[] = $cl['id'];
                }
                $this->log['lead'][$lead->id][] = "Обнаружены клиенты, связанные с источником {$lead->source}: " . json_encode($clArr) . ". Ищем последний заказ по релевантности среди полученных клиентов ...";
                $order = Orders::find()
                    ->where(['in', 'client', $clArr])
                    ->andWhere(['status' => Orders::STATUS_PROCESSING])
                    ->andWhere(['archive' => 0])
                    ->orderBy('last_lead_get asc');
                if (!empty($this->restrictedIds)) {
                    $order = $order->andWhere(['not in', 'id', $this->restrictedIds]);
                }
                $order = $order->one();
            }
        }
        return $order;
    }

    private function query__succeed($lead, $order) {
        $worker = new Worker($order, $lead);
        return $worker->processing__new();
    }

    private function get__category__params() {
        $models = LeadsParams::find()
            ->select(['type', 'category', 'name', 'comparison_type'])
            ->asArray()
            ->all();
        $params = [];
        if (!empty($models)) {
            foreach ($models as $item) {
                $params[$item['category']][$item['name']] = [
                    'comparison_type' => $item['comparison_type'],
                    'type' => $item['type'],
                ];
            }
        }
        return $params;
    }

    /**
     * @param $currentCategoryParams array
     * @param $lead Leads
     * @param $orderParams array
     * @return int
     */
    private function category__params__validation($currentCategoryParams, $lead, $orderParams) {
        $leadParams = $lead->params;
        if (!empty($leadParams)) {
            foreach ($leadParams as $key => $param) {
                if (!empty($currentCategoryParams[$key]) && !empty($orderParams[$key])) {
                    $paramProperties = $currentCategoryParams[$key];
                    $type = $paramProperties['type'];
                    switch ($paramProperties['comparison_type']) {

                        case self::COMPARISON_EQUALS:
                            if ($type === self::TYPE_STRING) {
                                if ((string)$orderParams[$key] !== (string)$param) {
                                    $this->log['lead'][$lead->id][] = "<span style='color: #d9534f'>Параметр {$key}, равный '{$param}' не соответствует указанному в заказе значению {$orderParams[$key]}. Переход на следующую итерацию...</span>";
                                    return self::STATUS_SKIP;
                                }
                            } else {
                                if ((int)$orderParams[$key] !== (int)$param) {
                                    $this->log['lead'][$lead->id][] = "<span style='color: #d9534f'>Параметр {$key}, равный '{$param}' не соответствует указанному в заказе значению {$orderParams[$key]}. Переход на следующую итерацию...</span>";
                                    return self::STATUS_SKIP;
                                }
                            }
                            break;

                        case self::COMPARISON_INTERVAL:
                            if ($type === self::TYPE_NUMBER) {
                                $min = isset($orderParams[$key]['min']) ? $orderParams[$key]['min'] : 0;
                                $max = isset($orderParams[$key]['max']) ? $orderParams[$key]['max'] : null;
                                if (!empty($min)) {
                                    if ((int)$param < (int)$min) {
                                        $this->log['lead'][$lead->id][] = "<span style='color: #d9534f'>Параметр {$key}, равный '{$param}' меньше, чем минимальное значение данного параметра в заказе - {$min}. Переход на следующую итерацию...</span>";
                                        return self::STATUS_SKIP;
                                    }
                                }
                                if (!empty($max)) {
                                    if ((int)$param > (int)$max) {
                                        $this->log['lead'][$lead->id][] = "<span style='color: #d9534f'>Параметр {$key}, равный '{$param}' больше, чем максимальное значение данного параметра в заказе - {$max}. Переход на следующую итерацию...</span>";
                                        return self::STATUS_SKIP;
                                    }
                                }
                            }
                            break;

                        case self::COMPARISON_NOT_NULL:
                            break;

                    }
                }
            }
            $this->log['lead'][$lead->id][] = "<span style='color: #3c75ff'>Проверка по категориальным параметрам завершена успешно.</span>";
        } else
            $this->log['lead'][$lead->id][] = "<span style='color: #3c75ff'>Категориальные параметры не указаны. Пропуск...</span>";
        return self::STATUS_CONFIRM;
    }

    private function get__restricted__integrations($source) {
        $restricted = Integrations::find()
            ->where(['integration_type' => 'bitrix'])
            ->andWhere(['like', 'config', "%{$source}%", false])
            ->select(['entity_id', 'entity'])
            ->asArray()
            ->all();
        if (empty($restricted))
            return null;
        $oids = [];
        $cids = [];
        foreach ($restricted as $item) {
            if ($item['entity'] === 'order')
                $oids[] = $item['entity_id'];
            else
                $cids[] = $item['entity_id'];
        }
        $restrictedOrders = Orders::find()
            ->where(['in', 'id', $oids])
            ->asArray()
            ->select(['id'])
            ->all();
        if (!empty($cids)) {
            $additionalOrders = Orders::find()
                ->where(['in', 'client', $cids])
                ->asArray()
                ->select(['id'])
                ->all();
        }
        if (!empty($restrictedOrders) || !empty($additionalOrders)) {
            $buf = !empty($restrictedOrders) ? ArrayHelper::getColumn($restrictedOrders, 'id') : [];
            $buf2 = !empty($additionalOrders) ? ArrayHelper::getColumn($additionalOrders, 'id') : [];
            $this->restrictedIds = array_merge($buf2, $buf);
            return true;
        } else {
            $this->restrictedIds = null;
            return false;
        }
    }

    private function go__query() {
        /**
         * @var Leads $lead
         */
        $categoryParams = $this->get__category__params();
        for ($i = 0; $i < $this->batch; ++$i) {
            $start = $i * $this->limit;
            $currentQuery = Leads::find()
                ->where(['status' => Leads::STATUS_NEW])
                ->limit($this->limit)
                ->offset($start)
                ->all();
            $dadata = curl_init();
            foreach ($currentQuery as $lead) {
                if ($lead->ip !== '127.0.0.1' && (empty($lead->region) || empty($lead->city))) {
                    usleep(60000);
                    curl_setopt_array($dadata, [
                        CURLOPT_URL => "https://suggestions.dadata.ru/suggestions/api/4_1/rs/iplocate/address",
                        CURLOPT_POST => true,
                        CURLOPT_POSTFIELDS => json_encode(["ip" => $lead->ip]),
                        CURLOPT_RETURNTRANSFER => true,
                        CURLOPT_HTTPHEADER => [
                            "Content-Type: application/json",
                            "Accept: application/json",
                            "Authorization: Token c2dcaff175511be606da9f124117539114cf7e77",
                        ],
                    ]);
                    $jsonResponse = curl_exec($dadata);
                    $regionResponse = json_decode($jsonResponse, true);
                    if (empty($lead->region))
                        $lead->region = !empty($regionResponse['location']['data']['region_with_type']) ? $regionResponse['location']['data']['region_with_type'] : null;
                    if (empty($lead->city))
                        $lead->city = !empty($regionResponse['location']['data']['city']) ? $regionResponse['location']['data']['city'] : null;
                }
                if (!empty($lead->utm_campaign) && (mb_strpos($lead->utm_campaign, '.ru') !== false || mb_strpos($lead->utm_campaign, '.com') !== false)) {
                    $this->log['lead'][$lead->id][] = "Обнаружено, что utm_campaign лида содержит информацию о возможном бекдоре - {$lead->utm_campaign}";
                    if ($this->get__restricted__integrations($lead->utm_campaign)) {
                        $this->log['lead'][$lead->id][] = "Обнаружены заказы, интеграция которых связана с {$lead->utm_campaign} - " . json_encode($this->restrictedIds) . ". Исключаем указанные ID из выборки...";
                    } else {
                        $this->log['lead'][$lead->id][] = "Заказы-исключения не найдены...";
                    }
                }
                $this->log['lead'][$lead->id][] = "Получен Лид #{$lead->id}. Запуск подбора ПРИОРИТЕТНЫХ заказов...";
                $target = $this->get__preprocessed($lead);
                if (empty($target)) {
                    $this->log['lead'][$lead->id][] = "Наиболее приоритетные заказы не найдены. Запускаем подбор заказов с учетом фильтров...";
                    $config = [
                        'type' => $lead->type,
                        'region' => $lead->region,
                        'city' => $lead->city,
                        'source' => $lead->source,
                        'cc' => $lead->cc_check,
                        'autocalls' => $lead->autocall_check,
                        'lead_id' => $lead->id
                    ];
                    $priors = [true, false];
                    $chosenOrder = false;
                    foreach ($priors as $prior) {
                        $orders = $this->filtered($config, $prior);
                        if (!empty($orders)) {
                            $this->log['lead'][$lead->id][] = "Получен перечень заказов. Запускаем перебор заказов...";
                            foreach ($orders as $active) {
                                if (empty($active))
                                    continue;
                                $options = $this->get__options($active);
                                $currentCategoryParams = !empty($categoryParams[$lead->type]) ? $categoryParams[$lead->type] : null;
                                if (!empty($options)) {
                                    $this->log['lead'][$lead->id][] = "Заказ #{$active['id']} имеет конфигурацию с учетом клиентских параметров: " . json_encode($options, JSON_UNESCAPED_UNICODE);
                                    if ($this->special__params__validation($options, $lead, $active['id']) === self::STATUS_SKIP)
                                        continue;
                                    if (!empty($currentCategoryParams)) {
                                        $this->log['lead'][$lead->id][] = "Начинаем проверку по категориальным параметрам...";
                                        if ($this->category__params__validation($currentCategoryParams, $lead, json_decode($active['params_category'], true)) === self::STATUS_SKIP)
                                            continue;
                                    }
                                }
                                $objectOrder = Orders::findOne($active['id']);
                                if (!empty($objectOrder)) {
                                    $this->log['lead'][$lead->id][] = "<span style='color: #3c75ff'>Получен экземпляр объекта заказов #{$objectOrder->id}</span>";
                                    $rsp = $this->query__succeed($lead, $objectOrder);
                                    $this->log['lead'][$lead->id][] = "<span style='color: #009209'>Результат создания связи и отправки:" . json_encode($rsp, JSON_UNESCAPED_UNICODE) . ". Переходим к следующему лиду...</span>";
                                    $chosenOrder = true;
                                    break;
                                }
                            }
                            if ($chosenOrder)
                                break;
                        }
                    }
                    if (!$chosenOrder) {
                        $this->log['lead'][$lead->id][] = "<span style='color: #c5a20b'>Не найден ни один заказ, удовлетворяющий условиям поиска для данного лида. Переходим к следующему лиду...</span>";
                        $lead->system_data = empty($lead->system_data) ? [] : $lead->system_data;
                        $lead->status = Leads::STATUS_MODERATE;
                        $lead->update();
                    }
                } else {
                    $this->log['lead'][$lead->id][] = "<span style='color: #3c75ff'>Получен экземпляр объекта заказов #{$target->id}</span>";
                    $rsp = $this->query__succeed($lead, $target);
                    $this->log['lead'][$lead->id][] = "<span style='color: #009209'>Результат создания связи и отправки:" . json_encode($rsp, JSON_UNESCAPED_UNICODE) . ". Переходим к следующему лиду...</span>";
                }
            }
            curl_close($dadata);
        }
        $this->log['system'][] = date("d.m.Y H:i:s") . ": Конец выборки.";
        $this->log__processing();
        return $this->log;
    }

    private function log__processing() {
        if ($this->count > 0) {
            $log = new CronLog();
            $log->log = json_encode($this->log, JSON_UNESCAPED_UNICODE);
            $log->action = "queue";
            return $log->save();
        } else
            return true;
    }

}