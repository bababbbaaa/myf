<?php

namespace common\models;

use common\models\Clients;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;

/**
 * ClientsSearch represents the model behind the search form of `common\models\Clients`.
 */
class ClientsSearch extends Clients
{
    /**
     * {@inheritdoc}
     */

    public $client_name;

    public function rules()
    {
        return [
            [['id', 'user_id'], 'integer'],
            [['f', 'i', 'o', 'client_name', 'email', 'commentary', 'company_info', 'requisites', 'date', 'custom_params'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {

        if(\Yii::$app->controller->action->id !== 'as-xls') {
            $query = Clients::find()->where(['!=', 'archive', 1]);
            $clientOrders = Orders::find()->where(['!=', 'archive', 1]);
            if (empty($_GET['statusFilter']))
                $clientOrders = $clientOrders->andWhere(['status' => Orders::STATUS_PROCESSING]);
            else
                $clientOrders = $clientOrders->andWhere(['status' => $_GET['statusFilter']]);
            $clientOrders = $clientOrders->select(['client'])->groupBy('client')->asArray()->all();
        } else {
            $query = Clients::find();
            $clientOrders = Orders::find()->where(['=', 'archive', 1])->select(['client'])->groupBy('client')->asArray()->all();
        }

        $clientOrders = ArrayHelper::getColumn($clientOrders, 'client');

        if (\Yii::$app->controller->action->id === 'index') {
            if (!empty($clientOrders)) {
                $query = $query->andWhere(['in', 'id', $clientOrders]);
            } else {
                $query = $query->where('0=1');
            }
        } elseif(\Yii::$app->controller->action->id === 'empty-orders') {
            if (!empty($clientOrders)) {
                $query = $query->andWhere(['not in', 'id', $clientOrders]);
            }
        } else {
            if (!empty($clientOrders)) {
                $query = $query->andWhere(['in', 'id', $clientOrders]);
            }
        }
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'user_id' => $this->user_id,
            'date' => $this->date,
        ]);

        $query->andFilterWhere(['like', 'f', $this->f])
            ->andFilterWhere(['like', 'i', $this->i])
            ->andFilterWhere(['like', 'o', $this->o])
            ->andFilterWhere(['OR', ['like', 'f', $this->client_name], ['like', 'i', $this->client_name]])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'commentary', $this->commentary])
            ->andFilterWhere(['like', 'company_info', $this->company_info])
            ->andFilterWhere(['like', 'requisites', $this->requisites])
            ->andFilterWhere(['like', 'custom_params', $this->custom_params]);

        return $dataProvider;
    }
}
