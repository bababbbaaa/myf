<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\M3Projects;

/**
 * M3ProjectsSearch represents the model behind the search form of `common\models\M3Projects`.
 */
class M3ProjectsSearch extends M3Projects
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'money_got'], 'integer'],
            [['date_start', 'date_end', 'name', 'source', 'specs_link', 'status', 'responsible'], 'safe'],
            [['price', 'costs'], 'number'],
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
        $query = M3Projects::find();

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
            'date_start' => $this->date_start,
            'date_end' => $this->date_end,
            'price' => $this->price,
            'costs' => $this->costs,
            'money_got' => $this->money_got,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'source', $this->source])
            ->andFilterWhere(['like', 'responsible', $this->source])
            ->andFilterWhere(['like', 'specs_link', $this->specs_link])
            ->andFilterWhere(['like', 'status', $this->status]);

        return $dataProvider;
    }
}
