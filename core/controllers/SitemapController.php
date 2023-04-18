<?php
/**
 * Created by PhpStorm.
 * User: DIO
 * Date: 23.09.2019
 * Time: 15:20
 */

namespace core\controllers;

use common\models\Cases;
use common\models\Franchise;
use common\models\LeadTemplates;
use common\models\LeadTypes;
use common\models\News;
use Yii;
use yii\web\Controller;


class SitemapController extends Controller
{

    public $staticPages = [
        'mainPage' => [
            '',
            'about',
            'events',
            'news',
        ],
        'femida' => [
            'femida',
            'femida/about',
            'femida/chto-takoe-franchaizing',
            'femida/kak-covid-19-povliyal-na-rasklad-sil',
            'femida/kak-kupit-franchizy',
            'femida/kak-polychit-vozvrat-deneg',
            'femida/kak-vubrat-horoshyu-franchizy',
            'femida/partnership',
            'femida/technologies',
            'femida/vidu-franchizy',
        ],
        'lead' => [
            'lead',
            'lead/about-leads',
            'lead/buy-leads',
            'lead/lead-auction',
            'lead/traffic-quality',
            'lead/types-of-leads',
            'lead/seller',
            'lead/seller/available-offers',
            'lead/seller/sell-traffic',
            'lead/seller/terms-of-cooperation',
        ]
    ];

    public function actionIndex(){

        Yii::$app->cache->delete('sitemap');

        #main: case, news-page
        #femida: franchize, news
        #lead: lead-plan, lead-offer, news x 2

        if (!$xml_sitemap = Yii::$app->cache->get('sitemap')){


            $dynamic_links = [];

            $cases = Cases::find()->orderBy('id desc')->select(['link'])->asArray()->all();
            foreach ($cases as $item){
                if(!empty($item['link']))
                    $dynamic_links[] = 'case/'.$item['link'];
            }

            $newsPage = News::find()->where(['OR', ['tag' => 'общие'], ['tag' => 'главная']])
                ->orderBy('id desc')->select(['link'])->asArray()->all();
            foreach ($newsPage as $item){
                if(!empty($item['link']))
                    $dynamic_links[] = 'news/'.$item['link'];
            }

            $franchize = Franchise::find()->orderBy('id desc')->select(['link'])->asArray()->all();
            foreach ($franchize as $item){
                if(!empty($item['link']))
                    $dynamic_links[] = 'femida/franchize/'.$item['link'];
            }

            $newsFranch = News::find()->where(['OR', ['tag' => 'общие'], ['tag' => 'франшиза']])
                ->orderBy('id desc')->select(['link'])->asArray()->all();;
            foreach ($newsFranch as $item){
                if(!empty($item['link']))
                    $dynamic_links[] = 'femida/news/'.$item['link'];
            }

            $leadPlan = LeadTemplates::find()->orderBy('id desc')->select(['link'])->asArray()->all();;
            foreach ($leadPlan as $item){
                if(!empty($item['link']))
                    $dynamic_links[] = 'lead/lead-plan/'.$item['link'];
            }

            $leadType = LeadTypes::find()->orderBy('id desc')->select(['link'])->asArray()->all();;
            foreach ($leadType as $item){
                if(!empty($item['link']))
                    $dynamic_links[] = 'lead/seller/lead-offer/'.$item['link'];
            }

            $newsLead = News::find()->where(['OR', ['tag' => 'общие'], ['tag' => 'маркетинг']])
                ->orderBy('id desc')->select(['link'])->asArray()->all();;
            foreach ($newsLead as $item){
                if(!empty($item['link']))
                    $dynamic_links[] = 'lead/news/'.$item['link'];
            }

            $sellerLeads = News::find()->where(['OR', ['tag' => 'общие'], ['tag' => 'вебмастер']])
                ->orderBy('id desc')->select(['link'])->asArray()->all();;
            foreach ($sellerLeads as $item){
                if(!empty($item['link']))
                    $dynamic_links[] = 'lead/seller/news/'.$item['link'];
            }

            $xml_sitemap = $this->renderPartial('index', array(
                'host' => Yii::$app->request->hostInfo,
                'urls' => $dynamic_links,
                'static' => $this->staticPages
            ));

            Yii::$app->cache->set('sitemap', $xml_sitemap, 60*60*12);

        } //76

        Yii::$app->response->format = \yii\web\Response::FORMAT_RAW;
        $headers = Yii::$app->response->headers;
        $headers->add('Content-Type', 'text/xml');

        return $xml_sitemap;

    }

}