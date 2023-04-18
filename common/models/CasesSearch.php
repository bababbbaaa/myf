<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Cases;

/**
 * CasesSearch represents the model behind the search form of `common\models\Cases`.
 */
class CasesSearch extends Cases
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'active'], 'integer'],
            [['link', 'name', 'type', 'logo', 'boss_img', 'small_description', 'input', 'result', 'from_to', 'comment', 'boss_name', 'boss_op', 'big_description', 'date'], 'safe'],
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
        $query = Cases::find();

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
            'date' => $this->date,
            'active' => $this->active,
        ]);

        $query->andFilterWhere(['like', 'link', $this->link])
            ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'type', $this->type])
            ->andFilterWhere(['like', 'logo', $this->logo])
            ->andFilterWhere(['like', 'boss_img', $this->boss_img])
            ->andFilterWhere(['like', 'small_description', $this->small_description])
            ->andFilterWhere(['like', 'input', $this->input])
            ->andFilterWhere(['like', 'result', $this->result])
            ->andFilterWhere(['like', 'from_to', $this->from_to])
            ->andFilterWhere(['like', 'comment', $this->comment])
            ->andFilterWhere(['like', 'boss_name', $this->boss_name])
            ->andFilterWhere(['like', 'boss_op', $this->boss_op])
            ->andFilterWhere(['like', 'big_description', $this->big_description]);

        return $dataProvider;
    }
}
