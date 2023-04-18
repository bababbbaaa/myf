<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\TgMessages;

/**
 * TgMessagesSearch represents the model behind the search form of `common\models\TgMessages`.
 */
class TgMessagesSearch extends TgMessages
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'is_loop', 'is_done', 'minimum_time'], 'integer'],
            [['peer', 'bot', 'message', 'date_to_post', 'days_to_post', 'date_create'], 'safe'],
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
        $query = TgMessages::find();

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
            'is_loop' => $this->is_loop,
            'date_to_post' => $this->date_to_post,
            'is_done' => $this->is_done,
            'minimum_time' => $this->minimum_time,
            'date_create' => $this->date_create,
        ]);

        $query->andFilterWhere(['like', 'peer', $this->peer])
            ->andFilterWhere(['like', 'bot', $this->bot])
            ->andFilterWhere(['like', 'message', $this->message])
            ->andFilterWhere(['like', 'days_to_post', $this->days_to_post]);

        return $dataProvider;
    }
}
