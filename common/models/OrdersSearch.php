<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Orders;

/**
 * OrdersSearch represents the model behind the search form of `common\models\Orders`.
 */
class OrdersSearch extends Orders
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['client', 'leads_count', 'leads_get', 'leads_waste', 'sale', 'archive'], 'integer'],
            [['order_name', 'category_link', 'category_text', 'status', 'regions', 'id', 'params_category', 'date', 'date_end', 'commentary', 'params_special'], 'safe'],
            [['price'], 'number'],
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
        $query = Orders::find()->where(['!=', 'archive', 1]);

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
            #'id' => $this->id,
            'client' => $this->client,
            'price' => $this->price,
            'leads_count' => $this->leads_count,
            'leads_get' => $this->leads_get,
            'date' => $this->date,
            'date_end' => $this->date_end,
            'leads_waste' => $this->leads_waste,
            'sale' => $this->sale,
            'archive' => $this->archive,
        ]);

        if (is_numeric($this->id))
            $idFind = ['id' => $this->id];
        else
            $idFind = ['like', 'order_name', $this->id];

        $query->andFilterWhere($idFind)
            ->andFilterWhere(['like', 'category_link', $this->category_link])
            ->andFilterWhere(['like', 'category_text', $this->category_text])
            ->andFilterWhere(['like', 'status', $this->status])
            ->andFilterWhere(['like', 'regions', $this->regions])
            ->andFilterWhere(['like', 'params_category', $this->params_category])
            ->andFilterWhere(['like', 'commentary', $this->commentary])
            ->andFilterWhere(['like', 'params_special', $this->params_special]);

        return $dataProvider;
    }
}
