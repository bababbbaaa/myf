<?php

namespace api\controllers;

use common\models\M3Messages;
use common\models\M3Peers;
use yii\web\Controller;

class M3Controller extends Controller
{

    public function beforeAction($action)
    {
        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }

    public function actionHook() {
        $json = file_get_contents('php://input');
        $data = json_decode($json, 1);
        if (!empty($data['message'])) {
            $msg = $data['message'];
            if (!empty($msg['from']) && !$msg['from']['is_bot']) {
                $user = $msg['from'];
                $peer = M3Peers::findOne(['uid' => $user['id']]);
                if (empty($peer)) {
                    $peer = new M3Peers();
                    $peer->peer_stage = 'start';
                    $peer->uid = $user['id'];
                    $peer->save();
                }
                $message = new M3Messages();
                $message->username = $user['username'];
                $message->uid = $user['id'];
                $message->message = $msg['text'];
                $message->task = $peer->peer_stage;
                $message->save();
            }
        }
    }

}