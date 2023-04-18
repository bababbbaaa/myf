<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\FranchiseCases;

/**
 * FranchiseCasesSearch represents the model behind the search form of `common\models\FranchiseCases`.
 */
class FranchiseCasesSearch extends FranchiseCases
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'franchise_id', 'is_active', 'investments', 'income_approx'], 'integer'],
            [['date', 'img', 'name', 'whois', 'status', 'feedback', 'offices', 'video'], 'safe'],
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
        $query = FranchiseCases::find();

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
            'franchise_id' => $this->franchise_id,
            'date' => $this->date,
            'is_active' => $this->is_active,
            'investments' => $this->investments,
            'income_approx' => $this->income_approx,
        ]);

        $query->andFilterWhere(['like', 'img', $this->img])
            ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'whois', $this->whois])
            ->andFilterWhere(['like', 'status', $this->status])
            ->andFilterWhere(['like', 'feedback', $this->feedback])
            ->andFilterWhere(['like', 'offices', $this->offices])
            ->andFilterWhere(['like', 'video', $this->video]);

        return $dataProvider;
    }
}
