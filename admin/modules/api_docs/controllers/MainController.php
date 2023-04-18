<?php

namespace admin\modules\api_docs\controllers;

use admin\controllers\AccessController;
use common\models\helpers\CsvReader;
use common\models\JobsQueue;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\Controller;

/**
 * Default controller for the `api-docs` module
 */
class MainController extends AccessController
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        if (!empty($_GET['refresh'])) {
            unset($_SESSION['bitrix']);
            return $this->redirect(Url::to(['/api-docs/main']));
        }
        if (empty($_SESSION['bitrix'])) {
            $curl = curl_init();
            curl_setopt_array(
                $curl,
                [
                    CURLOPT_SSL_VERIFYPEER => false,
                    CURLOPT_POST => false,
                    CURLOPT_HEADER => false,
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_URL => \Yii::$app->params['bitrixUrl'] . "user.search?filter[ACTIVE]=true",
                ]
            );
            $result = curl_exec($curl);
            if (!empty($result)) {
                $json = json_decode($result, 1);
                foreach ($json['result'] as $item) {
                    if(!empty($item['NAME']) && !empty($item['LAST_NAME']))
                        $_SESSION['bitrix']['ASSIGNED_BY_ID'][$item['ID']] = "{$item['NAME']} {$item['LAST_NAME']}";
                }
            }
            usleep(300000);
            curl_setopt_array(
                $curl,
                [
                    CURLOPT_SSL_VERIFYPEER => false,
                    CURLOPT_POST => false,
                    CURLOPT_HEADER => false,
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_URL => \Yii::$app->params['bitrixUrl'] . "crm.dealcategory.list",
                ]
            );
            $result = curl_exec($curl);
            if (!empty($result)) {
                $json = json_decode($result, 1);
                foreach ($json['result'] as $item) {
                    $_SESSION['bitrix']['CATEGORY_ID'][$item['ID']] = $item['NAME'];
                }
            }
            usleep(300000);
            curl_setopt_array(
                $curl,
                [
                    CURLOPT_SSL_VERIFYPEER => false,
                    CURLOPT_POST => false,
                    CURLOPT_HEADER => false,
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_URL => \Yii::$app->params['bitrixUrl'] . "crm.status.entity.items?entityId=SOURCE",
                ]
            );
            $result = curl_exec($curl);
            if (!empty($result)) {
                $json = json_decode($result, 1);
                foreach ($json['result'] as $item) {
                    $_SESSION['bitrix']['SOURCE_ID'][$item['STATUS_ID']] = $item['NAME'];
                }
            }
            curl_close($curl);
        }
        return $this->render('index');
    }

    public function actionImportCsv() {
        $q['data'] = $_POST;
        unset($q['data']['_csrf-admin']);
        $file = $_FILES['file'];
        $path = pathinfo($file['name']);
        if ($file['error'] == 0 && $path['extension'] === 'csv') {
            $csv = new CsvReader($file['tmp_name']);
            //header('Content-type: text/plain; charset=windows-1251');
            foreach ($csv->rows() as $row) {
                $rowData = explode(';', $row[0]);
                $phone = preg_replace('/[^\d]+/', '', $rowData[1]);
                if (empty($phone))
                    continue;
                $contacts[] = [
                    'name' => mb_convert_encoding($rowData[0], "utf-8", "windows-1251"),
                    'phone' => $phone
                ];
            }
            if (!empty($contacts)) {
                $q['contacts'] = $contacts;
                $queue = new JobsQueue();
                $queue->params = json_encode($q, JSON_UNESCAPED_UNICODE);
                $queue->method = 'import__csv';
                $queue->date_start = date("Y-m-d H:i:s");
                $queue->status = 'wait';
                $queue->user_id = \Yii::$app->getUser()->getId();
                $queue->closed = 0;
                $queue->save();
                \Yii::$app->session->setFlash('import', 'Задача на импорт поставлена, время ожидания импорта - от 1 минуты и более.');
            } else {
                \Yii::$app->session->setFlash('import', 'Не найдены данные для импорта');
            }
            return \Yii::$app->response->redirect('/api-docs/main/index');
        }
    }
}
