<?php

namespace api\controllers;

use common\models\Integrations;
use GuzzleHttp\Client;
use yii\web\Controller;

class RestController extends Controller
{

    public function actionCrmLeadList($UUID = null) {
        if (empty($UUID))
            return $this->asJson(['error' => 'Empty UUID', 'code' => 0]);
        else {
            $integration = Integrations::findOne(['uuid' => $UUID]);
            if (empty($integration))
                return $this->asJson(['error' => 'UUID not found', 'code' => 1]);
            if ($integration->integration_type !== 'bitrix')
                return $this->asJson(['error' => 'Not supported integration', 'code' => 2]);
            $guz = new Client();
            $intData = json_decode($integration->config, true);
            $source = $intData["SOURCE_ID"] ?? null;
            $url = $intData["WEBHOOK_URL"];
            if (empty($source))
                $source = "LeadForce";
            $data = json_decode($guz->post("{$url}/crm.lead.list", ['form_params' => ['filter' => ["SOURCE_ID" => $source]]])->getBody()->getContents(), true);
            return $this->asJson($data);
        }
    }

}