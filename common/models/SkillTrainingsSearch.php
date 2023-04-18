<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\SkillTrainings;

/**
 * SkillTrainingsSearch represents the model behind the search form of `common\models\SkillTrainings`.
 */
class SkillTrainingsSearch extends SkillTrainings
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'discount', 'author_id', 'category_id', 'lessons_count', 'study_hours', 'exist_videos', 'exist_bonuses'], 'integer'],
            [['name', 'link', 'type', 'tags', 'preview_logo', 'content_subtitle', 'content_about', 'content_block_income', 'content_block_description', 'content_block_tags', 'content_for_who', 'content_what_study', 'content_terms', 'discount_expiration_date', 'date', 'date_meetup'], 'safe'],
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
        $query = SkillTrainings::find();

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
            'discount' => $this->discount,
            'author_id' => $this->author_id,
            'category_id' => $this->category_id,
            'price' => $this->price,
            'discount_expiration_date' => $this->discount_expiration_date,
            'date' => $this->date,
            'date_meetup' => $this->date_meetup,
            'lessons_count' => $this->lessons_count,
            'study_hours' => $this->study_hours,
            'exist_videos' => $this->exist_videos,
            'exist_bonuses' => $this->exist_bonuses,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'link', $this->link])
            ->andFilterWhere(['like', 'type', $this->type])
            ->andFilterWhere(['like', 'tags', $this->tags])
            ->andFilterWhere(['like', 'preview_logo', $this->preview_logo])
            ->andFilterWhere(['like', 'content_subtitle', $this->content_subtitle])
            ->andFilterWhere(['like', 'content_about', $this->content_about])
            ->andFilterWhere(['like', 'content_block_income', $this->content_block_income])
            ->andFilterWhere(['like', 'content_block_description', $this->content_block_description])
            ->andFilterWhere(['like', 'content_block_tags', $this->content_block_tags])
            ->andFilterWhere(['like', 'content_for_who', $this->content_for_who])
            ->andFilterWhere(['like', 'content_what_study', $this->content_what_study])
            ->andFilterWhere(['like', 'content_terms', $this->content_terms]);

        return $dataProvider;
    }
}
