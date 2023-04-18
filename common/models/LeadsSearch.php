<?php

namespace common\models;

use common\behaviors\JsonQuery;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Leads;
use yii\helpers\ArrayHelper;

/**
 * LeadsSearch represents the model behind the search form of `common\models\Leads`.
 */
class LeadsSearch extends Leads
{
    /**
     * {@inheritdoc}
     */

    public $dateStartFilter;
    public $dateStopFilter;
    public $dateStartFilterOpened;
    public $dateStopFilterOpened;
    public $opens;

    public function rules()
    {
        $params = self::categoryParams();
        $add = [];
        if (!empty($params)) {
            foreach ($params as $item) {
                $add[] = $item->name;
            }
        }
        $p = ['ip', 'cc_check', 'id', 'dateStartFilter', 'dateStopFilter', 'dateStartFilterOpened', 'dateStopFilterOpened', 'date_income', 'source', 'utm_source', 'utm_campaign', 'utm_medium', 'utm_content', 'utm_term', 'utm_title', 'utm_device_type', 'utm_age', 'utm_inst', 'utm_special', 'date_change', 'status', 'system_data', 'type', 'name', 'email', 'phone', 'region', 'city', 'comments', 'params', 'leadsParamsValues', 'opens'];
        #$p = array_merge($p, $add);
        return [
            //[['id'], 'integer'],
            [$p, 'safe'],
            [['dateStartFilter', 'dateStopFilter'], 'default', 'value' => null],
        ];
    }

    public function behaviors()
    {
        return Model::behaviors(); // TODO: Change the autogenerated stub
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
        if(empty($_GET['special_filter']))
            $query = Leads::find()->with('opens');
        else {
            $filter = ['AND'];
            if(!empty($_GET['special_filter']['wasteOnlyOrder'])) {
                $filter[] = ['leads_sent_report.order_id' => $_GET['special_filter']['wasteOnlyOrder'], 'leads_sent_report.status' => 'брак',];
            }
            if(!empty($_GET['special_filter']['qualityOnlyOrder'])) {
                $filter[] = ['leads_sent_report.order_id' => $_GET['special_filter']['qualityOnlyOrder']];
            }
            $query = Leads::find()->with('opens')->joinWith('leadsSentReports')->where($filter);
        }

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            #$query->joinWith(['leadsParamsValues']);
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'date_income' => $this->date_income,
            'date_change' => $this->date_change,
        ]);

        if (mb_strripos($this->id, '.') !== false)
            $idFind = ['like', 'ip', $this->id];
        elseif (mb_strripos($this->id, '-') !== false) {
            $arPlode = explode('-', $this->id);
            $buf = $arPlode[count($arPlode) - 1];
            $arPlode[count($arPlode) - 1] = $arPlode[0];
            $arPlode[0] = $buf;
            $str = implode('-', $arPlode);
            $idFind = ['like', 'date_income', $str];
        }
        elseif (!is_numeric($this->id))
            $idFind = ['like', 'status', $this->id];
        else
            $idFind = ['leads.id' => $this->id,];


        $query->andFilterWhere($idFind)
            #->andFilterWhere(['like', 'status', $this->status])
            ->andFilterWhere(['like', 'system_data', $this->system_data])
            ->andFilterWhere(['like', 'type', empty($this->type) ? 'dolgi' : $this->type])
            ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['>=', 'date_income', is_null($this->dateStartFilter) ? null : date("Y-m-d", strtotime($this->dateStartFilter)) . " 00:00:00"])
            ->andFilterWhere(['<=', 'date_income', is_null($this->dateStopFilter) ? null : date("Y-m-d", strtotime($this->dateStopFilter)) . " 23:59:59"])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'phone', $this->phone])
            ->andFilterWhere(['like', 'region', $this->region])
            ->andFilterWhere(['like', 'city', $this->city])
            ->andFilterWhere(['like', 'source', $this->source])
            ->andFilterWhere(['like', 'utm_source', $this->utm_source])
            ->andFilterWhere(['like', 'utm_campaign', $this->utm_campaign])
            ->andFilterWhere(['like', 'cc_check', $this->cc_check])
            #->andFilterWhere(['like', 'leadsParamsValues.param', $this->leadsParamsValues->param])
            ->andFilterWhere(['like', 'comments', $this->comments]);
            #->andFilterWhere(['like', 'params', json_encode($this->params)]);

        $ps = self::categoryParams();
        if (!empty($ps)) {
            foreach ($ps as $item) {
                if(!empty($_GET["LeadsSearch"][$item->name])) {
                    $jsonQuery = new JsonQuery('params');
                    $p = $_GET['LeadsSearch'][$item->name];
                    if($item->filter_type === '=')
                        $query->andWhere($jsonQuery->JsonExtract($item->name, "= '$p'"));
                    elseif($item->filter_type === 'like') {
                        $add = $item->type === 'string' ? '"'.$p : $p;
                        $query->andFilterWhere(['like', 'params', '"'.$item->name.'":'.$add]);
                    } else {
                        $query->andWhere($jsonQuery->JsonExtract($item->name, ">= $p"));
                    }
                }
            } #$jsonQuery->JsonContains([$item->name => $item->type === 'string' ? (string)$_GET["LeadsSearch"][$item->name] : (int)$_GET["LeadsSearch"][$item->name]])
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
                ->andWhere(['lead_type' => 'lead'])
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
        if(!empty($_GET["LeadsSearch"]['opens'])) {
            $opens = LeadsActions::find()
                ->select('*, COUNT(id) AS B')
                ->groupBy('lead_id')
                ->having('B='.$_GET["LeadsSearch"]['opens'])
                ->where(['lead_type' => 'lead'])
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
        /*if (!empty($ps)) {
            $paramsz = [];
            foreach ($ps as $p)
                if (!empty($_GET['LeadsSearch'][$p->name])) {
                    $paramsz[$p->name] = $_GET['LeadsSearch'][$p->name];
                }
            if (!empty($paramsz)) {
                $where = ['AND'];
                foreach ($paramsz as $key => $item)
                    $where[] = ['like', 'value', $item];
                $h = LeadsParamsValues::find()
                    ->where($where)
                    ->groupBy('lead')->select('lead')->all();
                if (!empty($h)) {
                    $ids = [];
                    foreach ($h as $hh)
                        $ids[] = $hh->lead;
                    $query->andFilterWhere(['in', 'leads.id', $ids]);
                }
            }
        }*/

        return $dataProvider;
    }
}
