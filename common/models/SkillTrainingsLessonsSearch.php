<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\SkillTrainingsLessons;

/**
 * SkillTrainingsLessonsSearch represents the model behind the search form of `common\models\SkillTrainingsLessons`.
 */
class SkillTrainingsLessonsSearch extends SkillTrainingsLessons
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'training_id', 'block_id'], 'integer'],
            [['name', 'lesson_link', 'main_text', 'video', 'content', 'date'], 'safe'],
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
        $query = SkillTrainingsLessons::find();

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
            'training_id' => $this->training_id,
            'block_id' => $this->block_id,
            'date' => $this->date,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'lesson_link', $this->lesson_link])
            ->andFilterWhere(['like', 'main_text', $this->main_text])
            ->andFilterWhere(['like', 'video', $this->video])
            ->andFilterWhere(['like', 'content', $this->content]);

        return $dataProvider;
    }
}
