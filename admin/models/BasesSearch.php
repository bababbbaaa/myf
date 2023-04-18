<?php

namespace admin\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use admin\models\Bases;

/**
 * BasesSearch represents the model behind the search form of `admin\models\Bases`.
 */
class BasesSearch extends Bases
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'is_new'], 'integer'],
            [['name', 'category', 'provider', 'geo', 'date_create'], 'safe'],
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
        $query = Bases::find();

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
            'date_create' => $this->date_create,
            'is_new' => $this->is_new,
        ]);



        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'category', $this->category])
            ->andFilterWhere(['like', 'provider', $this->provider])
            ->andFilterWhere(['like', 'geo', $this->geo]);

        if(!empty($params['filter'])) {
            $p = $params['filter'];
            $filters = ['AND'];
            if (!empty($p['utm'])) {
                $filters[] = ['like', 'name', "%{$p['utm']}%", false];
            }
            if (isset($p['is_1']) && strlen($p['is_1']) > 0) {
                $filters[] = ['is_1' => $p['is_1']];
            }
            $contacts = BasesUtm::find()->where($filters)->groupBy(['base_id'])->select(['base_id'])->asArray()->all();
            if (!empty($contacts)) {
                $bases = [];
                foreach ($contacts as $item)
                    $bases[] = $item['base_id'];
                $query->andFilterWhere(['in', 'id', $bases]);
            } else
                $query->where('0=1');
        }


        return $dataProvider;
    }
}
