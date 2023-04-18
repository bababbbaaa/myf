<?php

namespace admin\modules\logs\controllers;

use admin\controllers\AccessController;
use admin\models\ActionLogger;
use common\models\CronLog;
use common\models\LogInput;
use common\models\LogProcessor;
use common\models\UsersProviderUploads;
use common\models\UsersProviderUploadsSigned;
use yii\data\Pagination;
use yii\web\Controller;
use yii\web\Response;

/**
 * Default controller for the `logs` module
 */
class MainController extends AccessController
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionCron() {
        $query = CronLog::find();
        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count()]);
        $models = $query->offset($pages->offset)
            ->limit($pages->limit)
            ->asArray()
            ->orderBy('id desc')
            ->all();
        return $this->render('cron', ['logs' => $models, 'pages' => $pages]);
    }

    public function actionSent() {
        $query = LogProcessor::find();
        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count()]);
        $models = $query->offset($pages->offset)
            ->limit($pages->limit)
            ->asArray()
            ->orderBy('id desc')
            ->all();
        return $this->render('sent', ['logs' => $models, 'pages' => $pages]);
    }

    public function actionInput() {
        $query = LogInput::find();
        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count()]);
        $models = $query->offset($pages->offset)
            ->limit($pages->limit)
            ->asArray()
            ->orderBy('date desc')
            ->all();
        return $this->render('input', ['logs' => $models, 'pages' => $pages]);
    }

    public function actionProviders() {
        $docs = UsersProviderUploadsSigned::find()
            ->asArray()
            ->all();
        return $this->render('providers', ['docs' => $docs]);
    }

    public function actionStatusProviderDocs() {
        \Yii::$app->response->format = Response::FORMAT_JSON;
        if (!empty($_POST['id']) && !empty($_POST['action'])) {
            $type = $_POST['action'];
            $docs = UsersProviderUploadsSigned::findOne($_POST['id']);
            if (empty($docs))
                return ['status' => 'error', 'message' => 'Документы не найдены'];
            if ($type === 'success') {
                $docs->status = 1;
                if ($docs->update() !== false)
                    return ['status' => 'success'];
                else {
                    return ['status' => 'error', 'message' => 'Ошибка сохранения'];
                }
            } else {
                $getUpload = UsersProviderUploads::findOne($docs->upload_id);
                if (!empty($getUpload)) {
                    $getUpload->status = 0;
                    $getUpload->date = date("Y-m-d H:i:s");
                    $getUpload->date_exp = date("Y-m-d H:i:s", time() + 3600 * 24 * 5);
                    $getUpload->update();
                }
                $docs->delete();
                return ['status' => 'success'];
            }
        } else
            return ['status' => 'error', 'message' => 'Данные не найдены'];
    }

    public function actionActionLogs() {
        $query = ActionLogger::find();
        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count()]);
        $models = $query->offset($pages->offset)
            ->limit($pages->limit)
            ->asArray()
            ->orderBy('id desc')
            ->all();
        return $this->render('action-logs', ['logs' => $models, 'pages' => $pages]);
    }


}
