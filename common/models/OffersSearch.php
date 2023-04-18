<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Offers;

/**
 * OffersSearch represents the model behind the search form of `common\models\Offers`.
 */
class OffersSearch extends Offers
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'leads_need', 'leads_confirmed', 'leads_waste', 'leads_total', 'offer_id', 'user_id', 'offer_token'], 'integer'],
            [['name', 'category', 'regions', 'date', 'special_params'], 'safe'],
            [['price', 'tax', 'total_payed'], 'number'],
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
        $query = Offers::find();

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
            'leads_need' => $this->leads_need,
            'leads_confirmed' => $this->leads_confirmed,
            'leads_waste' => $this->leads_waste,
            'leads_total' => $this->leads_total,
            'price' => $this->price,
            'tax' => $this->tax,
            'total_payed' => $this->total_payed,
            'date' => $this->date,
            'offer_id' => $this->offer_id,
            'user_id' => $this->user_id,
            'offer_token' => $this->offer_token,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'category', $this->category])
            ->andFilterWhere(['like', 'regions', $this->regions])
            ->andFilterWhere(['like', 'special_params', $this->special_params]);

        return $dataProvider;
    }
}
