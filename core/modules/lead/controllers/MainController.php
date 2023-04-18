<?php

namespace app\modules\lead\controllers;

use common\models\helpers\UrlHelper;
use common\models\LeadsCategory;
use common\models\LeadTemplates;
use common\models\News;
use yii\helpers\Html;
use yii\web\Controller;
use yii\web\Response;
Use yii\helpers\Url;
Use Yii;

class MainController extends Controller
{

    public function beforeAction($action)
    {
        Yii::$app->session->set('voronka', 104);
        return parent::beforeAction($action); // TODO: Change the autogenerated stub
    }

//    public function actionIndex()
//    {
//        $this->view->registerMetaTag(['name' => 'keywords', 'content' => 'генерация лидов, продать лиды, купить лиды, бизнес лиды ']);
//        $this->view->registerMetaTag(['name' => 'description', 'content' => 'LEAD.FORCE - биржа лидов и трафика. Покупайте и продавайте лиды от клиентов и рекламный трафик по выгодным ценам вместе с лидфорс']);
//        $this->view->registerMetaTag(['property' => 'og:title', 'content' => 'Начните зарабатывать на арбитраже трафика']);
//        $this->view->registerMetaTag(['property' => 'og:image', 'content' => 'https://myforce.ru/img/flex__img.webp']);
//        $this->view->registerMetaTag(['property' => 'og:url', 'content' => 'https://myforce.ru/lead']);
//        $this->view->registerMetaTag(['property' => 'og:description', 'content' => 'LEAD.FORCE - биржа лидов и трафика. Покупайте и продавайте лиды от клиентов и рекламный трафик по выгодным ценам вместе с лидфорс']);
//        $niche = LeadsCategory::find()->asArray()->orderBy('id desc')->all();
//        return $this->render('index', ['niche' => $niche]);
//    }
    public function actionBuyLeads()
    {
        $this->view->registerMetaTag(['name' => 'keywords', 'content' => 'Купить лиды, лиды для бизнеса, лиды бфл, купить лиды на списание долгов']);
        $this->view->registerMetaTag(['name' => 'description', 'content' => 'С нами вы можете легко приобрести лиды для своего бизнесса']);
        $this->view->registerMetaTag(['property' => 'og:title', 'content' => 'Купить лиды']);
        $this->view->registerMetaTag(['property' => 'og:image', 'content' => 'https://myforce.ru/img/assurance-3.webp']);
        $this->view->registerMetaTag(['property' => 'og:url', 'content' => 'https://myforce.ru/lead/buy-leads']);
        $this->view->registerMetaTag(['property' => 'og:description', 'content' => 'С нами вы можете легко приобрести лиды для своего бизнесса']);
        $niche = LeadsCategory::find()->asArray()->orderBy('id desc')->all();
        return $this->render('buy-leads', ['niche' => $niche]);
    }
    public function actionLeadAuction()
    {
        $this->view->registerMetaTag(['name' => 'keywords', 'content' => 'Аукцион лидов, Биржа лидов, купить лиды, продать лиды']);
        $this->view->registerMetaTag(['name' => 'description', 'content' => 'Аукцино лидов - биржа лидов от Лидфорс. Продавайте свои лиды, или покупайте заявки от клиентов, которые нужны вашему бизнесу']);
        $this->view->registerMetaTag(['property' => 'og:title', 'content' => 'Аукцион лидов']);
        $this->view->registerMetaTag(['property' => 'og:type', 'content' => 'article']);
        $this->view->registerMetaTag(['property' => 'og:image', 'content' => 'https://myforce.ru/img/LA-top.webp']);
        $this->view->registerMetaTag(['property' => 'og:url', 'content' => 'https://myforce.ru/lead/lead-auction']);
        $this->view->registerMetaTag(['property' => 'og:description', 'content' => 'Аукцино лидов - биржа лидов от Лидфорс. Продавайте свои лиды, или покупайте заявки от клиентов, которые нужны вашему бизнесу']);
        return $this->render('lead-auction');
    }
    public function actionTrafficQuality()
    {
        $this->view->registerMetaTag(['name' => 'keywords', 'content' => 'Аукцион лидов, Биржа лидов, купить лиды, купить заявки, купить горячие лиды']);
        $this->view->registerMetaTag(['name' => 'description', 'content' => 'Аукцино лидов - биржа лидов от Лидфорс. Продавайте свои лиды, или покупайте заявки от клиентов, которые нужны вашему бизнесу']);
        $this->view->registerMetaTag(['property' => 'og:title', 'content' => 'Аукцион лидов']);
        $this->view->registerMetaTag(['property' => 'og:image', 'content' => 'https://myforce.ru/img/coop-1.webp']);
        $this->view->registerMetaTag(['property' => 'og:url', 'content' => 'https://myforce.ru/lead/traffic-quality']);
        $this->view->registerMetaTag(['property' => 'og:description', 'content' => 'Аукцино лидов - биржа лидов от Лидфорс. Продавайте свои лиды, или покупайте заявки от клиентов, которые нужны вашему бизнесу']);
        return $this->render('traffic-quality');
    }
    public function actionIndex()
    {
        $this->view->registerMetaTag(['name' => 'keywords', 'content' => 'Лиды для бизнеса, выбрать лиды для бизнеса, виды лидов, какие бывают лиды для бизнеса']);
        $this->view->registerMetaTag(['name' => 'description', 'content' => 'Выберите лиды для вашего бизнеса по низким ценам. Лиды для юристов, кредитные лиды, лиды на банкротство, и прочие сферы бизнеса']);
        $this->view->registerMetaTag(['property' => 'og:title', 'content' => 'Виды лидов для вашего бизнеса']);
        $this->view->registerMetaTag(['property' => 'og:image', 'content' => 'https://myforce.ru/img/coop-1.webp']);
        $this->view->registerMetaTag(['property' => 'og:url', 'content' => 'https://myforce.ru/lead/types-of-leads']);
        $this->view->registerMetaTag(['property' => 'og:description', 'content' => 'Выберите лиды для вашего бизнеса по низким ценам. Лиды для юристов, кредитные лиды, лиды на банкротство, и прочие сферы бизнеса']);
        $select = LeadTemplates::find()->select('category')->where(['active' => 1])->distinct()->asArray()->all();
        $region = LeadTemplates::find()->select('regions')->where(['active' => 1])->distinct()->asArray()->all();
        $category = LeadsCategory::find()->with('templates')->asArray()->orderBy('id asc')->all();
        $niche = LeadsCategory::find()->with('templates')->asArray()->orderBy('id desc')->all();
        if (!empty($_GET['filter'])) {
            $postFilter = $_GET['filter'];
            $filter = ['AND'];
            if (!empty($postFilter['price'])) {
                $filter[] = ['<', 'price', $postFilter['price']];
            }
            if (!empty($postFilter['category'])) {
                $buf = ['OR'];
                foreach ($postFilter['category'] as $item){
                    $buf[] = ['category_link' => $item];
                }
                $filter[] = $buf;
            }
//            if (!empty($postFilter['regions'])) {
//                $buf = ['OR'];
//                foreach ($postFilter['regions'] as $item){
//                    $buf[] = ['like', 'regions', "%$item%", false];
//                }
//                $filter[] = $buf;
//            }
            $lead_type = LeadTemplates::find()->select(['id', 'image', 'category', 'category_link','link', 'regions', 'name', 'price'])->where($filter)->andWhere(['active' => 1])->orderBy(['id' => !empty($postFilter['new']) ? SORT_DESC:SORT_ASC])->asArray()->all();
        } else{
            $lead_type = LeadTemplates::find()->select(['id', 'image', 'category', 'link','regions', 'name', 'price'])->where(['active' => 1])->orderBy('price')->asArray()->all();
        }

        return $this->render('index', ['leadType' => $lead_type, 'select' => $select, 'region' => $region, 'category' => $category, 'niche' => $niche]);
    }


    public function actionAboutLeads()
    {
        if (!empty($_GET['ref'])) {
            setcookie('referal', Html::encode($_GET['ref']), time() + 3600 * 24 * 365 * 10, '/');
        }
        $this->view->registerMetaTag(['name' => 'keywords', 'content' => 'Купить лиды, Лиды для бизнеса, Качественные лиды, Лиды с гарантиями']);
        $this->view->registerMetaTag(['name' => 'description', 'content' => 'Купите целевые и качественные лиды для бизнеса на площадке Lead.Force. Лиды с гарантиями и бесплатные лиды для отдела продаж ']);
        $this->view->registerMetaTag(['property' => 'og:title', 'content' => 'Купить лиды для бизнеса']);
        $this->view->registerMetaTag(['property' => 'og:image', 'content' => 'https://myforce.ru/img/LeadsS1Targ.svg']);
        $this->view->registerMetaTag(['property' => 'og:url', 'content' => 'https://myforce.ru/lead/about-leads']);
        $this->view->registerMetaTag(['property' => 'og:description', 'content' => 'Купите целевые и качественные лиды для бизнеса на площадке Lead.Force. Лиды с гарантиями и бесплатные лиды для отдела продаж ']);
        $arr = ['dolgi', 'lidy-na-kredit', 'investicii-biznes-franshiza', 'kriptovaluta-tokeny-maining'];
        $leads = LeadTemplates::find()->asArray()
            ->orderBy('price asc')
            ->where(['OR',
                ['category_link' => 'dolgi'],
                ['category_link' => 'lidy-na-kredit'],
                ['category_link' => 'investicii-biznes-franshiza'],
                ['category_link' => 'kriptovaluta-tokeny-maining'],
            ])
            ->andWhere(['active' => 1])
            ->all();
        $category = LeadsCategory::find()->asArray()
            ->orderBy('id asc')
            ->where(['OR',
                    ['link_name' => 'dolgi'],
                    ['link_name' => 'lidy-na-kredit'],
                    ['link_name' => 'investicii-biznes-franshiza'],
                    ['link_name' => 'kriptovaluta-tokeny-maining'],
                ])
            ->all();
        return $this->render('about-leads', ['leads' => $leads, 'category' => $category]);
    }
    public function actionLeadPlan($link)
    {
        if(!empty($link)){
            $article = LeadTemplates::findOne(['link'=>$link]);
            $this->view->registerMetaTag(['name' => 'keywords', 'content' => $article['meta_keywords']]);
            $this->view->registerMetaTag(['name' => 'description', 'content' => $article['meta_description']]);
            $this->view->registerMetaTag(['property' => 'og:title', 'content' => $article['og_title']]);
            $this->view->registerMetaTag(['property' => 'og:type', 'content' => 'article']);
            $this->view->registerMetaTag(['property' => 'og:image', 'content' => Url::to('https://myforce.ru/lead/lead-plan/'.$article['og_image'])]);
            $this->view->registerMetaTag(['property' => 'og:url', 'content' => 'http://myforce/lead/lead-plan/'.$article['link']]);
            $this->view->registerMetaTag(['property' => 'og:description', 'content' => $article['og_description']]);
            if(!empty($article)){
                $lead_type = LeadTemplates::find()
                    ->where(['category' => $article['category']])
                    ->andWhere(['!=', 'id', $article['id']])
                    ->select(['id', 'image', 'category', 'regions', 'name', 'price', 'link'])
                    ->orderBy('id')
                    ->asArray()
                    ->limit(3)
                    ->all();
                return $this->render('lead-plan', ['article' => $article, 'leadType' => $lead_type]);
            } else return Yii::$app->response
                ->redirect(Url::to(['index']));
        } else return Yii::$app->response
            ->redirect(Url::to(['index']));
    }

    public function actionReturninfo()
    {

        \Yii::$app->response->format = Response::FORMAT_JSON;
        if (!empty($_POST['id'])){
            $list__popup = LeadTemplates::findOne($_POST["id"]);
            if (!empty($list__popup)){
                return ['status' => 'success', 'message' => $list__popup];
            } else return['status' => 'error', 'message' => 'Данные не найдены'];
        }else return ['status' => 'error', 'message' => 'ID не существует'];
    }

    public function actionNews($link)
    {
        if(!empty($link)){
            $article = News::findOne(['link'=>$link]);
            $this->view->registerMetaTag(['name' => 'keywords', 'content' => $article['meta_keywords']]);
            $this->view->registerMetaTag(['name' => 'description', 'content' => $article['og_description']]);
            $this->view->registerMetaTag(['property' => 'og:title', 'content' => $article['og_title']]);
            $this->view->registerMetaTag(['property' => 'og:type', 'content' => 'article']);
            $this->view->registerMetaTag(['property' => 'og:image', 'content' => UrlHelper::admin($article['og_image'])]);
            $this->view->registerMetaTag(['property' => 'og:url', 'content' => Url::to('https://myforce.ru/lead/news/'.$article['link'])]);
            $this->view->registerMetaTag(['property' => 'og:description', 'content' => $article['og_description']]);
            if(!empty($article)){
                $news = News::find()
                    ->asArray()
                    ->where(['!=','id',$article->id])
                    ->orderBy('id desc')
                    ->limit(5)
                    ->all();
                return $this->render('news', ['news' => $news, 'article' => $article]);
            } else return Yii::$app->response
                ->redirect(Url::to(['index']));
        } else return Yii::$app->response
            ->redirect(Url::to(['index']));
    }
    public function actionGetRegionsAjax() {
        Yii::$app->response->format = Response::FORMAT_JSON;
        if (isset($_POST['find'])) {
            $value = $_POST['find'];
            $regionsRends = new Admin('clients');
            return $regionsRends->getAjaxGeo($value);
        } else
            return ['status' => 'error', 'message' => "Поисковое значение не найдено"];
    }
}
