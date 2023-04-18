<?php

namespace common\models;

use common\models\UserModel;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * UserModelSearch represents the model behind the search form of `common\models\UserModel`.
 */
class UserModelSearch2 extends UserModel
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'status', 'created_at', 'updated_at', 'cc_daily_max', 'cc_daily_get', 'cc_status'], 'integer'],
            [['username', 'auth_key', 'password_hash', 'password_reset_token', 'email', 'verification_token', 'inner_name'], 'safe'],
            [['budget'], 'number'],
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
        $operators = UserModel::getAu();
        if (!empty($operators)) {
            $filter = ['in', 'id', $operators];
        } else {
            $filter = '0=1';
        }
        $query = UserModel::find()->where($filter)->andWhere(['status' => User::STATUS_ACTIVE]);

        // add conditions that should always apply here

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
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'budget' => $this->budget,
            'cc_daily_max' => $this->cc_daily_max,
            'cc_daily_get' => $this->cc_daily_get,
            'cc_status' => $this->cc_status,
        ]);

        $query->andFilterWhere(['like', 'username', $this->username])
            ->andFilterWhere(['like', 'auth_key', $this->auth_key])
            ->andFilterWhere(['like', 'password_hash', $this->password_hash])
            ->andFilterWhere(['like', 'password_reset_token', $this->password_reset_token])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'verification_token', $this->verification_token])
            ->andFilterWhere(['like', 'inner_name', $this->inner_name]);

        return $dataProvider;
    }
}
