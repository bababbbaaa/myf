<?php


namespace api\controllers;


use api\models\LeadCall;
use api\models\LeadInput;
use common\models\Clients;
use common\models\disk\Cloud;
use common\models\UsersCertificates;
use common\models\VoiceLeads;
use yii\web\Controller;
use yii\web\Response;

class LeadController extends Controller
{

    public function beforeAction($action)
    {
        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }

    public function actionAdd() {
        $api = new LeadInput();
        if (\Yii::$app->request->isPost) {
            $post = \Yii::$app->request->post();
            $api->set__data($post);
            $validator = $api->validate__entity();
            if ($validator['code'] === LeadInput::STATUS_SUCCESS) {
                $save = $api->save__entity();
                if ($save['code'] === LeadInput::STATUS_SUCCESS) {
                    $offer = $api->save__offer__alias();
                }
                $api->save__log();
                return $this->asJson(['offer' => $offer ?? NULL, 'save' => $save]);
            } else {
                $api->save__log();
                return $this->asJson($validator);
            }
        } else
            return $this->asJson($api->create__response(405, 'error', 'Некорректный HTTP-метод'));
    }

    public function actionAddOld() {
        $api = new LeadInput();
        if (\Yii::$app->request->isPost) {
            $post = \Yii::$app->request->post();
            $api->set__data($post);
            $validator = $api->validate__entity(true);
            if ($validator['code'] === LeadInput::STATUS_SUCCESS) {
                $save = $api->save__entity();
                if ($save['code'] === LeadInput::STATUS_SUCCESS) {
                    $offer = $api->save__offer__alias();
                }
                $api->save__log();
                return $this->asJson(['offer' => $offer ?? NULL, 'save' => $save]);
            } else {
                $api->save__log();
                return $this->asJson($validator);
            }
        } else
            return $this->asJson($api->create__response(405, 'error', 'Некорректный HTTP-метод'));
    }

    public function actionGetFromCall($type, $order = null, $utm = null, $cc = null) {
        \Yii::$app->response->format = Response::FORMAT_JSON;
        $ivr = $_GET['ivr'];
        $autocalls = new LeadCall($type, $order, $ivr, $utm);
        if (\Yii::$app->request->isPost) {
            $autocalls->get__data();
            file_put_contents("api-response.log", json_encode($autocalls->data, JSON_UNESCAPED_UNICODE) . PHP_EOL, FILE_APPEND);
            if ($autocalls->check__ivr()) {
                if ($autocalls->set__order()) {
                    if (!$autocalls->check__type())
                        return $autocalls->create__response(400, 'error', 'Неизвестная категория лидов');
                    $leadResponse = $autocalls->set__lead();
                    if ($leadResponse === true) {
                        if ($autocalls->sent__lead())
                            return $autocalls->create__response(200, 'success', 'Лид добавлен');
                        else
                            return $autocalls->create__response(500, 'error', 'Ошибка обработки лида');
                    } else
                        return $leadResponse;
                } elseif ($type === 'bitrix') {
                    $doubles = $autocalls->find__doubles();
                    $checkStatus = $autocalls->check__status__batch($doubles);
                    return $autocalls->do__bitrix__work($checkStatus, $doubles);
                } elseif (!empty($cc)) {
                    if (!$autocalls->check__type())
                        return $autocalls->create__response(400, 'error', 'Неизвестная категория лидов');
                    $autocalls->cc = true;
                    if($autocalls->save__cc__lead()) {
                        return $autocalls->create__response(200, 'success', 'Лид добавлен в КЦ');
                    } else
                        return $autocalls->create__response(400, 'error', 'Ошибка сохранения лида в КЦ');
                } else {
                    if (!$autocalls->check__type())
                        return $autocalls->create__response(400, 'error', 'Неизвестная категория лидов');
                    if($leadResponse = $autocalls->set__lead() === true)
                        return $autocalls->create__response(200, 'success', 'Лид добавлен');
                    else
                        return $leadResponse;
                }
            }
        } else
            return $this->asJson($autocalls->create__response(405, 'error', 'Некорректный HTTP-метод'));
    }

    public function actionGetVoice($type) {
        $json = file_get_contents('php://input');
        $data = json_decode($json, 1);
        file_put_contents("api-response-voice.log", json_encode($data, JSON_UNESCAPED_UNICODE) . PHP_EOL, FILE_APPEND);
        $phone = $data['call']['phone'];
        $response = $data['call']['answer'];
        VoiceLeads::fork($type, $response, $phone);
    }


}