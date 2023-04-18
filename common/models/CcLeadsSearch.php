<?php

namespace common\models;

use common\behaviors\JsonQuery;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\CcLeads;
use yii\helpers\ArrayHelper;

/**
 * CcLeadsSearch represents the model behind the search form of `common\models\CcLeads`.
 */
class CcLeadsSearch extends CcLeads
{

    public $sum;
    public $opens;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'dateType', 'showAwait'], 'integer'],
            [['source', 'assigned_to', 'utm_source', 'dateStartFilter', 'dateStopFilter', 'dateStartFilterOpened', 'dateStopFilterOpened', 'date_income', 'date_outcome', 'status_temp', 'status', 'name', 'phone', 'region', 'city', 'category', 'params', 'info', 'sum', 'opens'], 'safe'],
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
        $query = CcLeads::find()->with('opens');

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
            #'date_income' => $this->date_income,
            #'date_outcome' => $this->date_outcome,
            'assigned_to' => $this->assigned_to,
        ]);

        if (!empty($this->showAwait)) {
            $query->andWhere(['is', 'status', null]);
        } else {
            $query->andFilterWhere(['like', 'status', $this->status]);
        }

        $query->andFilterWhere(['like', 'source', $this->source])
            ->andFilterWhere(['like', 'utm_source', $this->utm_source])
            ->andFilterWhere(['like', 'status_temp', $this->status_temp])
            ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'phone', $this->phone])
            ->andFilterWhere(['like', 'region', $this->region])
            ->andFilterWhere(['like', 'city', $this->city])
            ->andFilterWhere(['like', 'category', $this->category])
            ->andFilterWhere(['like', 'params', $this->params])
            ->andFilterWhere(['like', 'info', $this->info]);

        if (!empty($this->dateType)) {
            if ((int)$this->dateType === 1) {
                $query->andFilterWhere(['>=', 'date_income', date("Y-m-d 00:00:00", strtotime($this->dateStartFilter))]);
                $query->andFilterWhere(['<=', 'date_income', date("Y-m-d 23:59:59", strtotime($this->dateStopFilter))]);
            } else {
                $query->andFilterWhere(['>=', 'date_outcome', date("Y-m-d 00:00:00", strtotime($this->dateStartFilter))]);
                $query->andFilterWhere(['<=', 'date_outcome', date("Y-m-d 23:59:59", strtotime($this->dateStopFilter))]);
            }
        }

        if (!empty($this->dateStartFilterOpened) || !empty($this->dateStopFilterOpened)) {
            $s1 = date("Y-m-d 00:00:00", strtotime($this->dateStartFilterOpened));
            $s2 = date("Y-m-d 23:59:59", strtotime($this->dateStopFilterOpened));
            $fOpens = ['AND'];
            if (!empty($s1)) {
                $qj = ['>=', 'date', $s1];
                $fOpens[] = $qj;
            }
            if (!empty($s2)) {
                $qj = ['<=', 'date', $s2];
                $fOpens[] = $qj;
            }
            $finder = LeadsActions::find()
                ->where($fOpens)
                ->andWhere(['lead_type' => 'cc'])
                ->select('lead_id')
                ->asArray()
                ->all();
            if (!empty($finder)) {
                $ids = ArrayHelper::getColumn($finder, 'lead_id');
                $query->andFilterWhere(['id' => $ids]);
            } else {
                $query->andFilterWhere(['id' => 0]);
            }
        }


        if(!empty($_GET["CcLeadsSearch"]['sum'])) {
            $jsonQuery = new JsonQuery('params');
            $p = $_GET['CcLeadsSearch']['sum'];
            $query->andWhere($jsonQuery->JsonExtract('sum', ">= $p"));
        }

        if(!empty($_GET["CcLeadsSearch"]['opens'])) {
            $opens = LeadsActions::find()
                ->select('*, COUNT(id) AS B')
                ->groupBy('lead_id')
                ->having('B='.$_GET["CcLeadsSearch"]['opens'])
                ->where(['lead_type' => 'cc'])
                ->orderBy('B desc')
                ->asArray()
                ->all();
            $ids = [];
            if (!empty($opens)) {
                $ids = ArrayHelper::getColumn($opens, 'lead_id');
            }
            if (empty($ids))
                $query->andFilterWhere(['id' => 0]);
            $query->andFilterWhere(['id' => $ids]);
        }

        return $dataProvider;
    }
}
