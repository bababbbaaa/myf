<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\CdbArticle;

/**
 * CdbArticleSearch represents the model behind the search form of `common\models\CdbArticle`.
 */
class CdbArticleSearch extends CdbArticle
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'category_id', 'subcategory_id', 'price', 'views', 'likes', 'downloads'], 'integer'],
            [['title', 'description', 'text', 'link', 'date', 'img', 'minimum_status', 'author', 'tags'], 'safe'],
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
        $query = CdbArticle::find();

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
            'category_id' => $this->category_id,
            'subcategory_id' => $this->subcategory_id,
            'date' => $this->date,
            'price' => $this->price,
            'views' => $this->views,
            'likes' => $this->likes,
            'downloads' => $this->downloads,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'text', $this->text])
            ->andFilterWhere(['like', 'link', $this->link])
            ->andFilterWhere(['like', 'img', $this->img])
            ->andFilterWhere(['like', 'minimum_status', $this->minimum_status])
            ->andFilterWhere(['like', 'author', $this->author])
            ->andFilterWhere(['like', 'tags', $this->tags]);

        return $dataProvider;
    }
}
