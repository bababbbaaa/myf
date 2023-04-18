<?php

namespace app\modules\aspb\controllers;

use common\models\AspbAy;
use common\models\AspbHelpers;
use common\models\AspbInfo;
use common\models\AspbPartner;
use common\models\AspbRemovingInBanks;
use common\models\AspbResponsible;
use common\models\AspbWithdrawalRegister;
use yii\data\Pagination;
use yii\web\Controller;
use Yii;
use yii\web\Response;

/**
 * Default controller for the `aspb` module
 */
class MainController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        $order = [];
        if (!empty($_POST['check']))
            foreach ($_POST['check'] as $v)
                $order[$v] = SORT_DESC;
        if (empty($order))
            $order = ['id' => SORT_ASC];

        $orders = [];
        if (!empty($_POST['checks']))
            foreach ($_POST['checks'] as $v)
                $orders[$v] = SORT_DESC;
        if (empty($orders))
            $orders = ['id' => SORT_ASC];

        $ord = [];
        if (!empty($_POST['chec']))
            foreach ($_POST['chec'] as $v)
                $ord[$v] = SORT_DESC;
        if (empty($ord))
            $ord = ['id' => SORT_ASC];

        $filter = ['AND'];
        if (!empty($_POST['search'])) {
            $filter[] = ['like', 'fio', '%' . $_POST['search'] . '%', false];
        }
        $clients = AspbInfo::find()->asArray()->orderBy($order)->where($filter);
        $pagesC = new Pagination(['totalCount' => $clients->count(), 'pageSize' => 50]);
        $clients = $clients->offset($pagesC->offset)->limit($pagesC->limit)->all();

        $aspbInfo = AspbInfo::find()->where(['status_affairs' => AspbInfo::STATUS_CONFIRM])->andWhere($filter)->orderBy($order)->asArray();
        $pagesI = new Pagination(['totalCount' => $aspbInfo->count(), 'pageSize' => 50]);
        $aspbInfo = $aspbInfo->offset($pagesI->offset)->limit($pagesI->limit)->all();

        $withdrawals = AspbRemovingInBanks::find()->orderBy($orders)->where($filter)->asArray();
        $pagesW = new Pagination(['totalCount' => $withdrawals->count(), 'pageSize' => 50]);
        $withdrawals = $withdrawals->offset($pagesW->offset)->limit($pagesW->limit)->all();

        $withdrawal_register = AspbWithdrawalRegister::find()->orderBy($ord)->where($filter)->asArray();
        $pagesR = new Pagination(['totalCount' => $withdrawal_register->count(), 'pageSize' => 50]);
        $withdrawal_register = $withdrawal_register->offset($pagesR->offset)->limit($pagesR->limit)->all();

        $clientsAll = AspbInfo::find()->asArray()->select('id, fio')->all();
        $arrClient = [];
        foreach ($clientsAll as $v)
            $arrClient[$v['id']] = $v['fio'];
        $ay = AspbAy::find()->asArray()->all();
        $partner = AspbPartner::find()->asArray()->all();
        $responsible = AspbResponsible::find()->asArray()->all();
        $helpers = AspbHelpers::find()->asArray()->all();
        $withdrawalsAll = AspbRemovingInBanks::find()->asArray()->select('id, fio')->all();
        $arrWithdrawals = [];
        foreach ($withdrawalsAll as $v)
            $arrWithdrawals[$v['id']] = $v['fio'];
        return $this->render('index', [
            'clients' => $clients,
            'pagesC' => $pagesC,
            'aspbInfo' => $aspbInfo,
            'pagesI' => $pagesI,
            'ay' => $ay,
            'partner' => $partner,
            'responsible' => $responsible,
            'helpers' => $helpers,
            'withdrawals' => $withdrawals,
            'pagesW' => $pagesW,
            'arrClient' => $arrClient,
            'arrWithdrawals' => $arrWithdrawals,
            'withdrawal_register' => $withdrawal_register,
            'pagesR' => $pagesR,
        ]);
    }

    public function actionClient($id)
    {
        if (empty($id)) return $this->redirect('/aspb-main#tab7');
        $data = AspbInfo::find()->asArray()->where(['id' => $id])->one();
        if (empty($data)) return $this->redirect('/aspb-main#tab7');
        $ay = AspbAy::find()->asArray()->where(['id' => $data['ay']])->one();
        $respbank = AspbRemovingInBanks::find()->asArray()->where(['client_id' => $id])->one();
        $filter = ['AND'];
        if (!empty($_POST['date'])) {
            $dateStart = date('Y-m-d', strtotime($_POST['date']));
            $dateEnd = date('Y-m-d', strtotime('+1 month', strtotime($_POST['date'])));
            $filter[] = [
                'AND',
                ['>=', 'withdrawal_date', $dateStart],
                ['<=', 'withdrawal_date', $dateEnd],
            ];
        }
        $with = AspbWithdrawalRegister::find()->asArray()
            ->where(['id_removing' => $respbank['id']])
            ->andWhere($filter)
            ->select('withdrawal_date, withdrawal_summ, pm_debtor, transfer_status')
            ->all();


        return $this->render('client', [
            'data' => $data,
            'ay' => $ay,
            'respbank' => $respbank,
            'with' => $with,
        ]);
    }

    public function actionAddClient()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $client = new AspbInfo();
        if ($client->save())
            return ['status' => 'success'];
        else
            return ['status' => 'error', 'message' => 'Ошибка создания клиента'];
    }

    public function actionRemoveClient()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        if (empty($_POST['id']))
            return ['status' => 'error', 'message' => 'Отсутствует ID клиента'];
        $client = AspbInfo::findOne($_POST['id']);
        if (empty($client))
            return ['status' => 'error', 'message' => 'Клиент не найден'];
        if ($client->delete())
            return ['status' => 'success'];
        else
            return ['status' => 'error', 'message' => 'Ошибка удаления клиента'];
    }

    public function actionRemoveRemove()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        if (empty($_POST['id']))
            return ['status' => 'error', 'message' => 'Отсутствует ID клиента'];
        $client = AspbRemovingInBanks::findOne($_POST['id']);
        if (empty($client))
            return ['status' => 'error', 'message' => 'Клиент не найден'];
        if ($client->delete())
            return ['status' => 'success'];
        else
            return ['status' => 'error', 'message' => 'Ошибка удаления клиента'];
    }

    public function actionRemoveWithdrawal()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        if (empty($_POST['id']))
            return ['status' => 'error', 'message' => 'Отсутствует ID клиента'];
        $client = AspbWithdrawalRegister::findOne($_POST['id']);
        if (empty($client))
            return ['status' => 'error', 'message' => 'Клиент не найден'];
        if ($client->delete())
            return ['status' => 'success'];
        else
            return ['status' => 'error', 'message' => 'Ошибка удаления клиента'];
    }

    public function actionAddAy()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        if (empty($_POST['ay__fio']) || empty($_POST['reg_number']) || empty($_POST['address']) || empty($_POST['email']))
            return ['status' => 'error', 'message' => 'Заполните все необходимые поля'];
        $ay = new AspbAy();
        $ay->fio = $_POST['ay__fio'];
        $ay->reg_number = $_POST['reg_number'];
        $ay->address = $_POST['address'];
        $ay->email = $_POST['email'];
        if ($ay->save())
            return ['status' => 'success'];
        else
            return ['status' => 'error', 'message' => 'Ошибка создания клиента'];
    }

    public function actionAddHelpers()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        if (empty($_POST['helper__fio']) || empty($_POST['helper__phone']))
            return ['status' => 'error', 'message' => 'Заполните все необходимые поля'];
        $ay = new AspbHelpers();
        $ay->fio = $_POST['helper__fio'];
        $ay->phone = $_POST['helper__phone'];
        if ($ay->save())
            return ['status' => 'success'];
        else
            return ['status' => 'error', 'message' => 'Ошибка создания клиента'];
    }

    public function actionAddResponsible()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        if (empty($_POST['responsible__fio']))
            return ['status' => 'error', 'message' => 'Укажите ФИО'];
        $ay = new AspbResponsible();
        $ay->fio = $_POST['responsible__fio'];
        if ($ay->save())
            return ['status' => 'success'];
        else
            return ['status' => 'error', 'message' => 'Ошибка создания клиента'];
    }

    public function actionAddPartner()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        if (empty($_POST['partner__fio']))
            return ['status' => 'error', 'message' => 'Укажите ФИО'];
        $ay = new AspbPartner();
        $ay->name = $_POST['partner__fio'];
        $ay->phone = $_POST['partner__phone'];
        if ($ay->save())
            return ['status' => 'success'];
        else
            return ['status' => 'error', 'message' => 'Ошибка создания клиента'];
    }

    public function actionAddRemove()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        if (empty($_POST['id']))
            return ['status' => 'error', 'message' => 'Отсутствует ID клиента'];
        $client = AspbInfo::findOne($_POST['id']);
        if (empty($client))
            return ['status' => 'error', 'message' => 'Клиент не найден'];

        $removing = AspbRemovingInBanks::find()->asArray()->where(['client_id' => $client->id])->one();
        if (!empty($removing))
            return ['status' => 'error', 'message' => 'Клиент уже добавлен'];

        $model = new AspbRemovingInBanks();
        $model->client_id = $client->id;
        $model->fio = $client->fio;
        $model->ay = $client->ay;
        $model->partner = $client->partner;
        $model->number_affairs = $client->number_affairs;
        $model->status_affairs = $client->status_affairs;
        $model->sz_date_upon_completion = $client->sz_date_upon_completion;
        $model->validate();
        if ($model->save())
            return ['status' => 'success'];
        else
            return ['status' => 'error', 'message' => $model->errors];
    }

    public function actionAddWithdrawals()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        if (empty($_POST['id']))
            return ['status' => 'error', 'message' => 'Отсутствует ID клиента'];
        $client = AspbRemovingInBanks::findOne($_POST['id']);
        if (empty($client))
            return ['status' => 'error', 'message' => 'Клиент не найден'];

        $model = new AspbWithdrawalRegister();
        $model->id_removing = $client->id;
        $model->fio = $client->fio;
        $model->withdrawal_date = date('Y-m-d');
        $model->partner = $client->partner;
        $model->requisites = $client->requisites;
        $model->banks = $client->banks;

        $model->validate();
        if ($model->save())
            return ['status' => 'success'];
        else
            return ['status' => 'error', 'message' => $model->errors];
    }

    public function actionSaveParams()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        if (empty($_POST['name'] || empty($_POST['val']) || empty($_POST['id']) || empty($_POST['type']))) {
            return ['status' => 'error', 'message' => 'Отсутствуют обязательные параметры'];
        }
        $client = AspbInfo::findOne($_POST['id']);
        if (empty($client))
            return ['status' => 'error', 'message' => 'Клиент не найден'];
        switch ($_POST['type']) {
            case 'date':
                $val = date('Y-m-d H:i:s', strtotime($_POST['val']));
                break;
            case 'string':
                $val = $_POST['val'];
                break;
            case 'int':
                $val = (int)$_POST['val'];
                break;
        }
        $name = $_POST['name'];
        if ($name === 'status_affairs' && $val === AspbInfo::STATUS_CONFIRM) {
            $inventory = [
                'date' => date('Y-m-d', time() + 3600 * 24 * 45),
                'confirm' => 0
            ];
            $fictitious = [
                'date' => date('Y-m-d', time() + 3600 * 24 * 110),
                'confirm' => 0
            ];
            $client->$name = $val;
            $client->inventory_of_property = json_encode($inventory, JSON_UNESCAPED_UNICODE);
            $client->deliberate_fictitious = json_encode($fictitious, JSON_UNESCAPED_UNICODE);
            $client->assembly_of_creditors = json_encode($fictitious, JSON_UNESCAPED_UNICODE);
        } elseif ($name === 'confirm_inventory_of_property') {
            $arr = json_decode($client->inventory_of_property, 1);
            $arr['confirm'] = $val;
            $client->inventory_of_property = json_encode($arr, JSON_UNESCAPED_UNICODE);
        } elseif ($name === 'confirm_deliberate_fictitious') {
            $arr = json_decode($client->deliberate_fictitious, 1);
            $arr['confirm'] = $val;
            $client->deliberate_fictitious = json_encode($arr, JSON_UNESCAPED_UNICODE);
        } elseif ($name === 'confirm_assembly_of_creditors') {
            $arr = json_decode($client->assembly_of_creditors, 1);
            $arr['confirm'] = $val;
            $client->assembly_of_creditors = json_encode($arr, JSON_UNESCAPED_UNICODE);
        } else {
            $client->$name = $val;
        }
        if ($name === 'income' && $val > 0) {
            $rem = AspbRemovingInBanks::find()->asArray()->where(['client_id' => $client->id])->one();
            if (empty($rem)) {
                $model = new AspbRemovingInBanks();
                $model->client_id = $client->id;
                $model->fio = $client->fio;
                $model->ay = $client->ay;
                $model->partner = $client->partner;
                $model->status_affairs = $client->status_affairs;
                $model->sz_date_upon_completion = $client->sz_date_upon_completion;
                $model->validate();
                if (!$model->save()) {
                    return ['status' => 'error', 'message' => $model->errors];
                }
            }
        }
        if ($client->update() !== false) {
            return ['status' => 'success'];
        } else {
            return ['status' => 'error', 'message' => 'Ошибка сохранения клиента'];
        }
    }

    public function actionSaveRemoving()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        if (empty($_POST['name'] || empty($_POST['val']) || empty($_POST['id']) || empty($_POST['type']))) {
            return ['status' => 'error', 'message' => 'Отсутствуют обязательные параметры'];
        }
        $client = AspbRemovingInBanks::findOne($_POST['id']);
        if (empty($client))
            return ['status' => 'error', 'message' => 'Клиент не найден'];
        switch ($_POST['type']) {
            case 'date':
                $val = date('Y-m-d H:i:s', strtotime($_POST['val']));
                break;
            case 'string':
                $val = $_POST['val'];
                break;
            case 'int':
                $val = (int)$_POST['val'];
                break;
        }
        $name = $_POST['name'];
        $client->$name = $val;
        $client->validate();
        if ($client->update() !== false) {
            return ['status' => 'success'];
        } else {
            return ['status' => 'error', 'message' => $client->errors];
        }
    }

    public function actionSaveWithdrawal()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        if (empty($_POST['name'] || empty($_POST['val']) || empty($_POST['id']) || empty($_POST['type']))) {
            return ['status' => 'error', 'message' => 'Отсутствуют обязательные параметры'];
        }
        $client = AspbWithdrawalRegister::findOne($_POST['id']);
        if (empty($client))
            return ['status' => 'error', 'message' => 'Клиент не найден'];
        switch ($_POST['type']) {
            case 'date':
                $val = date('Y-m-d H:i:s', strtotime($_POST['val']));
                break;
            case 'string':
                $val = $_POST['val'];
                break;
            case 'int':
                $val = (int)$_POST['val'];
                break;
        }
        $name = $_POST['name'];
        if ($name === 'from_their') {
            $removing = AspbRemovingInBanks::findOne($client->id_removing);
            $removing->debt = $removing->debt + $val;
            $client->$name = $val;
            $removing->update();
        } else {
            $client->$name = $val;
        }
        if ($client->update() !== false) {
            return ['status' => 'success'];
        } else {
            return ['status' => 'error', 'message' => 'Ошибка сохранения клиента'];
        }
    }

    public function actionShowBank()
    {
        if (!empty($_POST['id']))
            $popupdata = AspbRemovingInBanks::findOne($_POST['id']);
        return $this->renderPartial('_banks', [
            'popupdata' => $popupdata,
        ]);
    }

    public function actionShowRequisites()
    {
        if (!empty($_POST['id']))
            $popupdata = AspbRemovingInBanks::findOne($_POST['id']);
        return $this->renderPartial('_requisites', [
            'popupdata' => $popupdata,
        ]);
    }

    public function actionShowIncomes()
    {
        if (!empty($_POST['id']))
            $popupdata = AspbRemovingInBanks::findOne($_POST['id']);
        return $this->renderPartial('_incomes', [
            'popupdata' => $popupdata,
        ]);
    }

    public function actionSetBank()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        if (empty($_POST['id'])) return ['status' => 'error', 'message' => 'ID клиента не указан'];
        $user = AspbRemovingInBanks::findOne($_POST['id']);
        if (empty($user)) return ['status' => 'error', 'message' => 'Клиент не найден'];
        $arr = json_decode($user->banks, 1);
        if (is_array($arr)) {
            $newArr = array_unique(array_merge($arr, $_POST['banks']));
        } else {
            $newArr = $_POST['banks'];
        }
        $user->banks = json_encode($newArr, JSON_UNESCAPED_UNICODE);
        $user->validate();
        if ($user->update() !== false) {
            $model = AspbWithdrawalRegister::findOne(['id_removing' => $user->id]);
            if (!empty($model)) {
                $model->banks = $user->banks;
                $model->validate();
                $model->update();
            }
            return $this->renderPartial('_banks', [
                'popupdata' => $user,
            ]);
        } else return ['status' => 'error', 'message' => $user->errors];
    }

    public function actionSetRequisites()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        if (empty($_POST['id'])) return ['status' => 'error', 'message' => 'ID клиента не указан'];
        $user = AspbRemovingInBanks::findOne($_POST['id']);
        if (empty($user)) return ['status' => 'error', 'message' => 'Клиент не найден'];
        $arr = json_decode($user->requisites, 1);
        if (is_array($arr)) {
            $newArr = array_unique(array_merge($arr, $_POST['requisites']));
        } else {
            $newArr = $_POST['requisites'];
        }
        $user->requisites = json_encode($newArr, JSON_UNESCAPED_UNICODE);
        $user->validate();
        if ($user->update() !== false) {
            $model = AspbWithdrawalRegister::findOne(['id_removing' => $user->id]);
            if (!empty($model)) {
                $model->requisites = $user->requisites;
                $model->validate();
                $model->update();
            }
            return $this->renderPartial('_requisites', [
                'popupdata' => $user,
            ]);
        } else return ['status' => 'error', 'message' => $user->errors];
    }

    public function actionSetIncomes()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        if (empty($_POST['id'])) return ['status' => 'error', 'message' => 'ID клиента не указан'];
        $user = AspbRemovingInBanks::findOne($_POST['id']);
        if (empty($user)) return ['status' => 'error', 'message' => 'Клиент не найден'];
        $arr = json_decode($user->incomes, 1);
        if (is_array($arr)) {
            $newArr = array_unique(array_merge($arr, $_POST['incomes']));
        } else {
            $newArr = $_POST['incomes'];
        }
        $user->incomes = json_encode($newArr, JSON_UNESCAPED_UNICODE);
        $user->validate();
        if ($user->update() !== false)
            return $this->renderPartial('_incomes', [
                'popupdata' => $user,
            ]);
        else return ['status' => 'error', 'message' => $user->errors];
    }

    public function actionRemoveBank()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        if (empty($_POST['id'])) return ['status' => 'error', 'message' => 'ID клиента не указан'];
        if (!isset($_POST['id_bank'])) return ['status' => 'error', 'message' => 'ID банка не указан'];
        $user = AspbRemovingInBanks::findOne($_POST['id']);
        if (empty($user)) return ['status' => 'error', 'message' => 'Клиент не найден'];
        $arr = json_decode($user->banks, 1);
        unset($arr[$_POST['id_bank']]);
        $user->banks = json_encode($arr);
        if ($user->update() !== false)
            return $this->renderPartial('_banks', [
                'popupdata' => $user,
            ]);
        else return ['status' => 'error', 'message' => $user->errors];
    }

    public function actionRemoveRequisites()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        if (empty($_POST['id'])) return ['status' => 'error', 'message' => 'ID клиента не указан'];
        if (!isset($_POST['id_bank'])) return ['status' => 'error', 'message' => 'ID банка не указан'];
        $user = AspbRemovingInBanks::findOne($_POST['id']);
        if (empty($user)) return ['status' => 'error', 'message' => 'Клиент не найден'];
        $arr = json_decode($user->requisites, 1);
        unset($arr[$_POST['id_bank']]);
        $user->requisites = json_encode($arr);
        if ($user->update() !== false)
            return $this->renderPartial('_requisites', [
                'popupdata' => $user,
            ]);
        else return ['status' => 'error', 'message' => $user->errors];
    }

    public function actionRemoveIncomes()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        if (empty($_POST['id'])) return ['status' => 'error', 'message' => 'ID клиента не указан'];
        if (!isset($_POST['id_bank'])) return ['status' => 'error', 'message' => 'ID банка не указан'];
        $user = AspbRemovingInBanks::findOne($_POST['id']);
        if (empty($user)) return ['status' => 'error', 'message' => 'Клиент не найден'];
        $arr = json_decode($user->incomes, 1);
        unset($arr[$_POST['id_bank']]);
        $user->incomes = json_encode($arr);
        if ($user->update() !== false)
            return $this->renderPartial('_incomes', [
                'popupdata' => $user,
            ]);
        else return ['status' => 'error', 'message' => $user->errors];
    }

    public function actionShowBankInfo()
    {
        if (!empty($_POST['id']))
            $popupdata = AspbWithdrawalRegister::findOne($_POST['id']);
        return $this->renderPartial('_show-bank', [
            'popupdata' => $popupdata,
        ]);
    }

    public function actionShowRequisitesInfo()
    {
        if (!empty($_POST['id']))
            $popupdata = AspbWithdrawalRegister::findOne($_POST['id']);
        return $this->renderPartial('_show-requisites', [
            'popupdata' => $popupdata,
        ]);
    }
}
