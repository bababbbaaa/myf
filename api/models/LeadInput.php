<?php


namespace api\models;

use admin\models\ProvidersUtms;
use common\models\helpers\PhoneRegionHelper;
use common\models\Leads;
use common\models\LeadsCategory;
use common\models\LeadsRead;
use common\models\LeadsSources;
use common\models\LeadTypes;
use common\models\LogInput;
use common\models\Offers;
use common\models\OffersAlias;
use common\models\Providers;
use yii\helpers\Url;
use yii\web\HttpException;

/**
 * Class Api
 * @package api\models
 * @property Leads $entity
 * @property array $data
 * @property array $response
 * @property array $providerProperties
 */

class LeadInput extends Common
{
    const MYFORCE_INNER_API_KEYS = [
        'ab634113-b024-45c1-a878-229c66a5cae2',
        '1fec986d-c2bd-4f15-b548-3335432bd8ea',
        '1fec131a-c2b6-ff12-b598-3225432bd8c1', #derunov
    ];

    const STATUS_SUCCESS = 200;

    public $entity;
    public $data;
    public $providerProperties;
    public $response;

    public static $blockList = [
        '89037521568',
        '79037521568',
        '89648771940',
        '79648771940',
    ];


    public function set__data($data) {
        $this->data = $data;
    }


    private function validate__type($type) {
        $search = LeadsCategory::find()->where(['link_name' => $type])->select('link_name')->asArray()->one();
        return !empty($search);
    }

    public function validate__entity($old = false) {
        #fields
        // required
        // access_token - если лид с наших сайтов
        // provider_token - токен поставщика, если лид от поставщика
        // offer_token - токен оффера, если лид от поставщика
        // props - опционально
        // source - для наших сайтов
        #fields
        $required = [
            'type',
            'phone',
        ];
        foreach ($required as $item) {
            if (empty($this->data[$item])) {
                return $this->response = $this->create__response(400, 'error', 'Не указаны обязательные параметры');
            }
        }
        do {
            $phone = preg_replace("/[^0-9]/", '', (string)$this->data['phone']);
            $doppler = LeadsRead::find()
                ->where(['phone' => $phone])
                ->andWhere('date_income >= DATE_SUB(CURRENT_DATE, INTERVAL 5 DAY)')
                ->count();
            if (!empty($this->data['utm_source']) && !empty($this->data['utm_campaign'])) {
                $findProvUtm = ProvidersUtms::find()->where(['name' => $this->data['utm_source']])->select(['provider_id'])->one();
                $findOffer = Offers::find()->where(['offer_token' => $this->data['utm_campaign']])->select(['offer_token'])->one();
                if (!empty($findProvUtm) && !empty($findOffer)) {
                    $provider = Providers::findOne($findProvUtm->provider_id);
                    if (!empty($provider)) {
                        unset($this->data['access_token']);
                        $this->data['offer_token'] = $findOffer->offer_token;
                        $this->data['provider_token'] = $provider->provider_token;
                    }
                }
            }
            if (!empty($this->data['access_token']) && !empty($this->data['source'])) {
                if (!$old)
                    $verifiedSource = LeadsSources::find()->asArray()->select('name')->where(['name' => $this->data['source']])->one();
                else
                    $verifiedSource = 1;
                if (!in_array($this->data['access_token'], self::MYFORCE_INNER_API_KEYS)) {
                    $this->response = $this->create__response(403, 'error', 'Неизвестный ключ доступа');
                    break;
                } elseif(empty($verifiedSource)) {
                    $this->response = $this->create__response(403, 'error', 'Неизвестный источник');
                    break;
                } else
                    $isOk = true;
            } elseif(!empty($this->data['provider_token']) && !empty($this->data['offer_token'])) {
                $provider = Providers::find()
                    ->where(['provider_token' => $this->data['provider_token']])
                    ->select('provider_token, id, user_id')
                    ->one();
                if (empty($provider)) {
                    $this->response = $this->create__response(403, 'error', 'Неизвестный ключ поставщика');
                    break;
                }
                $offer = Offers::find()
                    ->where(['offer_token' => $this->data['offer_token']])
                    ->one();
                if (empty($offer)) {
                    $this->response = $this->create__response(403, 'error', 'Неизвестный ключ оффера');
                    break;
                }
                $isOk = true;
                $this->providerProperties = [
                    'provider' => $provider,
                    'offer' => $offer,
                ];
            } else {
                $this->response = $this->create__response(405, 'error', 'Неизвестный способ доступа к методу');
                break;
            }
            if ($isOk) {
                if ($doppler > 0) {
                    $this->response = $this->create__response(-1, 'error', ['MSG' => 'Дубль', 'LEAD' => $phone]);
                    break;
                }
                if (empty($this->data['ip']) && empty($this->data['region']) && !$old) {
                    $this->response = $this->create__response(400, 'error', 'Отсутствуют геоданные лида');
                    break;
                } else {
                    if (!$this->validate__type($this->data['type'])) {
                        $this->response = $this->create__response(400, 'error', 'Неизвестный тип поставляемых лидов');
                        break;
                    }
                    $props = [
                        'utm_source' ,
                        'utm_campaign' ,
                        'utm_medium' ,
                        'utm_content',
                        'utm_term' ,
                        'utm_title' ,
                        'utm_device_type',
                        'utm_age' ,
                        'utm_inst' ,
                        'utm_special',
                        'name',
                        'email',
                        'comments',
                        'params'
                    ];
                    $this->entity = new LeadsRead();
                    $this->entity->ip = empty($this->data['ip']) ? '127.0.0.1' : $this->data['ip'];
                    if (!$old)
                        $this->entity->region = empty($this->data['region']) ? null : $this->data['region'];
                    else {
                        $rg = PhoneRegionHelper::getValidRegion($phone);
                        $this->entity->region = empty($rg) ? null : $rg->name_with_type;
                    }
                    foreach ($props as $item) {
                        if (!empty($this->data[$item])) {
                            $this->entity->$item = $this->data[$item];
                        }
                    }
                    $this->entity->date_income = date("Y-m-d H:i:s");
                    $this->entity->status = Leads::STATUS_NEW;
                    $this->entity->phone = $phone;
                    $this->entity->type = $this->data['type'];
                    if ($old) {
                        if (mb_strpos($this->data['source'], '(КЦ)') !== false)
                            $this->entity->cc_check = 1;
                    }
                    if (!empty($this->data['access_token']))
                        $this->entity->source = $this->data['source'];
                    else {
                        if (empty($this->data['source']))
                            $this->entity->source = "Поставщик #{$provider->id} | Оффер #{$offer->id}";
                        else
                            $this->entity->source = "Поставщик #{$provider->id} | Оффер #{$offer->id} | {$this->data['source']}";
                    }
                    if (!$this->entity->validate()) {
                        $this->response = $this->create__response(400, 'error', $this->entity->errors);
                        break;
                    } else {
                        $this->response = $this->create__response(self::STATUS_SUCCESS, 'success', 'Валидация пройдена');
                    }
                }
            }
        } while (false);
        return $this->response;
    }

    public function save__entity() {
        if(in_array($this->entity->phone, static::$blockList))
            $this->response = $this->create__response(-10, 'error', 'Номер лида в чёрном списке');
        else {
            if ($this->entity->save())
                $this->response = $this->create__response(self::STATUS_SUCCESS, 'success', ['MSG' => 'Успешно. Лид сохранен', 'LEAD' => $this->entity->id]);
            else {
                $this->response = $this->create__response(400, 'error', 'Ошибка сохранения лида');
            }
        }
        return $this->response;
    }

    public function save__offer__alias() {
        if (!empty($this->providerProperties)) {
            $alias = new OffersAlias();
            $alias->user_id = $this->providerProperties['provider']->user_id;
            $alias->offer_id = $this->providerProperties['offer']->id;
            $alias->provider_id = $this->providerProperties['provider']->id;
            $alias->lead_id = $this->entity->id;
            $this->providerProperties['offer']->leads_total++;
            if ($alias->save() && $this->providerProperties['offer']->save())
                return "saved";
            else
                return "error";
        } else
            return false;
    }

    public function save__log() {
        $log = new LogInput();
        if (!empty($this->providerProperties))
            $log->source = "<b>Поставщик #{$this->providerProperties['provider']->id}</b><br><a href='". Url::to(['lead-force/offers/view', 'id' => $this->providerProperties['offer']->id]) ."'>Оффер #{$this->providerProperties['offer']->id}</a>";
        else
            $log->source = $this->data['source'];
        $log->info = json_encode($this->response, JSON_UNESCAPED_UNICODE);
        return $log->save();
    }


}