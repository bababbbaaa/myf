<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\RobokassaResult;

/**
 * RobokassaResultSearch represents the model behind the search form of `common\models\RobokassaResult`.
 */
class RobokassaResultSearch extends RobokassaResult
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['user_id', 'entity', 'entity_id', 'crc', 'status', 'summ', 'inv', 'description', 'date'], 'safe'],
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
        $query = RobokassaResult::find();

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
        ]);

        $query->andFilterWhere(['like', 'user_id', $this->user_id])
            ->andFilterWhere(['like', 'entity', $this->entity])
            ->andFilterWhere(['like', 'entity_id', $this->entity_id])
            ->andFilterWhere(['like', 'crc', $this->crc])
            ->andFilterWhere(['like', 'status', $this->status])
            ->andFilterWhere(['like', 'summ', $this->summ])
            ->andFilterWhere(['like', 'inv', $this->inv])
            ->andFilterWhere(['like', 'description', $this->description]);

        return $dataProvider;
    }
}
