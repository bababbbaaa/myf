<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\SkillTrainingsAuthors;

/**
 * SkillTrainingsAuthorsSearch represents the model behind the search form of `common\models\SkillTrainingsAuthors`.
 */
class SkillTrainingsAuthorsSearch extends SkillTrainingsAuthors
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['name', 'link', 'small_description', 'photo', 'about', 'specs', 'video', 'comment_article', 'comment_text', 'date'], 'safe'],
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
        $query = SkillTrainingsAuthors::find();

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

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'link', $this->link])
            ->andFilterWhere(['like', 'small_description', $this->small_description])
            ->andFilterWhere(['like', 'photo', $this->photo])
            ->andFilterWhere(['like', 'about', $this->about])
            ->andFilterWhere(['like', 'specs', $this->specs])
            ->andFilterWhere(['like', 'video', $this->video])
            ->andFilterWhere(['like', 'comment_article', $this->comment_article])
            ->andFilterWhere(['like', 'comment_text', $this->comment_text]);

        return $dataProvider;
    }
}
