<?php

namespace admin\modules\reports\controllers;

use admin\controllers\AccessController;
use admin\models\Bases;
use common\models\LeadsSave;
use DateInterval;
use DatePeriod;
use DateTime;
use yii\data\Pagination;
use yii\web\Controller;

/**
 * Default controller for the `reports` module
 */
class MainController extends AccessController
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    private static function generate__interval($start, $stop) {
        $begin = new DateTime(!empty($start) ? $start : date('Y-m-d', time() - 3600 * 24 * 7));
        $end = new DateTime(!empty($stop) ? $stop : date('Y-m-d') );
        $end = $end->modify('+1 day');
        $interval = new DateInterval('P1D');
        $daterange = new DatePeriod($begin, $interval ,$end);
        return ['begin' => $begin, 'end' => $end, 'daterange' => $daterange];
    }

    public function actionLeads() {
        extract(static::generate__interval($_GET['date_start'], $_GET['date_stop']));
        $filter = [
            'AND',
            ['>=', 'date_income', $begin->format('Y-m-d 00:00:00')],
            ['<=', 'date_income', $end->format('Y-m-d 23:59:59')]
        ];
        if (!empty($_GET['area'])) {
            $filter[] = ['type' => $_GET['area']];
        }
        if (!empty($_GET['source'])) {
            $filter[] = ['like', 'source', "%{$_GET['source']}%", false];
        }
        $leads = LeadsSave::find()
            ->select('DATE(`date_income`) as `date_lead`, count(1) as `summ`')
            ->where($filter)
            ->asArray()
            ->groupBy('date_lead')
            ->orderBy('date_income')
            ->all();
        if (!empty($leads))
            extract(static::generate__interval($leads[0]['date_lead'], $_GET['date_stop']));
        return $this->render('leads', ['range' => $daterange, 'leads' => $leads]);
    }
    

}
