<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\DevCases;

/**
 * DevCasesSearch represents the model behind the search form of `common\models\DevCases`.
 */
class DevCasesSearch extends DevCases
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['logo', 'name', 'description_works', 'fone_img', 'client', 'services', 'site', 'project_objective', 'results', 'done_big_image', 'done_description', 'done_small_image', 'done_small_image_description', 'functionality_lk_text', 'functionality_lk_image', 'site_screenshots', 'integrations', 'link', 'date'], 'safe'],
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
        $query = DevCases::find();

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

        $query->andFilterWhere(['like', 'logo', $this->logo])
            ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'description_works', $this->description_works])
            ->andFilterWhere(['like', 'fone_img', $this->fone_img])
            ->andFilterWhere(['like', 'client', $this->client])
            ->andFilterWhere(['like', 'services', $this->services])
            ->andFilterWhere(['like', 'site', $this->site])
            ->andFilterWhere(['like', 'project_objective', $this->project_objective])
            ->andFilterWhere(['like', 'results', $this->results])
            ->andFilterWhere(['like', 'done_big_image', $this->done_big_image])
            ->andFilterWhere(['like', 'done_description', $this->done_description])
            ->andFilterWhere(['like', 'done_small_image', $this->done_small_image])
            ->andFilterWhere(['like', 'done_small_image_description', $this->done_small_image_description])
            ->andFilterWhere(['like', 'functionality_lk_text', $this->functionality_lk_text])
            ->andFilterWhere(['like', 'functionality_lk_image', $this->functionality_lk_image])
            ->andFilterWhere(['like', 'site_screenshots', $this->site_screenshots])
            ->andFilterWhere(['like', 'integrations', $this->integrations])
            ->andFilterWhere(['like', 'link', $this->link]);

        return $dataProvider;
    }
}
