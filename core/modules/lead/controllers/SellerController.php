<?php


namespace app\modules\lead\controllers;

use admin\models\Admin;
use common\models\helpers\UrlHelper;
use common\models\LeadTypes;
use common\models\News;
use yii\web\Controller;
use yii\web\Response;
use yii\helpers\Url;
use Yii;

class SellerController extends Controller
{
    public $layout = 'seller';

    public function actionIndex()
    {
        $this->view->registerMetaTag(['name' => 'keywords', 'content' => 'Арбитраж трафика, партнерка для арбитражников, продать трафик, партнерская сеть по арбитражу трафика, заработать на трафике']);
        $this->view->registerMetaTag(['name' => 'description', 'content' => 'Заработок на арбитраже трафика. Стабильные и высокооплачиваемые партнерки, большая партнерская сеть, высокий доход с оферов для арбитражников']);
        $this->view->registerMetaTag(['property' => 'og:title', 'content' => 'Начните зарабатывать на арбитраже трафика']);
        $this->view->registerMetaTag(['property' => 'og:image', 'content' => 'https://myforce.ru/img/sl-top.webp']);
        $this->view->registerMetaTag(['property' => 'og:url', 'content' => 'https://myforce.ru/lead/seller']);
        $this->view->registerMetaTag(['property' => 'og:description', 'content' => 'Заработок на арбитраже трафика. Стабильные и высокооплачиваемые партнерки, большая партнерская сеть, высокий доход с оферов для арбитражников']);
        $select = LeadTypes::find()->select('name, category_link')->distinct()->asArray()->all();
        $region = LeadTypes::find()->select('regions')->distinct()->asArray()->all();

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
/*            if (!empty($postFilter['regions'])) {
                $buf = ['OR'];
                foreach ($postFilter['regions'] as $item){
                    $buf[] = ['like', 'regions', "%$item%", false];
                }
                $filter[] = $buf;
            }*/
            $lead_type = LeadTypes::find()->select(['id', 'image', 'category', 'category_link', 'link','regions', 'name', 'price'])->where($filter)->orderBy(['id' => !empty($postFilter['new']) ? SORT_DESC:SORT_ASC])->asArray()->all();
        } else{
            $lead_type = LeadTypes::find()->select(['id', 'image', 'category', 'category_link', 'link','regions', 'name', 'price'])->asArray()->all();
        }
        return $this->render('index', ['leadType' => $lead_type, 'select' => $select, 'region' => $region]);
    }
    public function actionAvailableOffers()
    {
        $this->view->registerMetaTag(['name' => 'keywords', 'content' => 'офферы для трафика, офферы с высоким апрувом, заработок на арбитраже, заработок на трафике']);
        $this->view->registerMetaTag(['name' => 'description', 'content' => 'Офферы для партнеров по арбитражу трафика. Выберите свой оффер из зарабатывайте на партнерке с высоким апрувоп']);
        $this->view->registerMetaTag(['property' => 'og:title', 'content' => 'Доступные партнерские офферы']);
        $this->view->registerMetaTag(['property' => 'og:image', 'content' => 'https://myforce.ru/img/of-web.webp']);
        $this->view->registerMetaTag(['property' => 'og:url', 'content' => 'https://myforce.ru/lead/seller/available-offers']);
        $this->view->registerMetaTag(['property' => 'og:description', 'content' => 'Офферы для партнеров по арбитражу трафика. Выберите свой оффер из зарабатывайте на партнерке с высоким апрувоп']);
        $select = LeadTypes::find()->select('name, category_link')->distinct()->asArray()->all();
        $region = LeadTypes::find()->select('regions')->distinct()->asArray()->all();

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

            $lead_type = LeadTypes::find()->select(['id', 'image', 'category', 'category_link', 'regions', 'name', 'link', 'price'])->where($filter)->orderBy(['id' => !empty($postFilter['new']) ? SORT_DESC:SORT_ASC])->asArray()->all();
        } else{
            $lead_type = LeadTypes::find()->select(['id', 'image', 'category', 'category_link', 'regions', 'name', 'link', 'price'])->asArray()->all();
        }
        return $this->render('available-offers', ['leadType' => $lead_type, 'select' => $select, 'region' => $region]);
    }

    public function actionReturninfo()
    {

        \Yii::$app->response->format = Response::FORMAT_JSON;
        if (!empty($_POST['id'])){
            $list__popup = LeadTypes::findOne($_POST["id"]);
            if (!empty($list__popup)){
                return ['status' => 'success', 'message' => $list__popup];
            } else return['status' => 'error', 'message' => 'Данные не найдены'];
        }else return ['status' => 'error', 'message' => 'ID не существует'];
    }

    public function actionTermsOfCooperation()
    {
        $this->view->registerMetaTag(['name' => 'keywords', 'content' => 'сотрудничество с myforce, сотрудничество с lead.force, условия лидфорс, разабатывать с лидфорс']);
        $this->view->registerMetaTag(['name' => 'description', 'content' => 'Узнайте как зарабатывать вместе с нами! О наших преимуществах, а также условиях сотрудничества']);
        $this->view->registerMetaTag(['property' => 'og:title', 'content' => 'Условия сотрудничества']);
        $this->view->registerMetaTag(['property' => 'og:image', 'content' => 'https://myforce.ru/img/cpa.webp']);
        $this->view->registerMetaTag(['property' => 'og:url', 'content' => 'https://myforce.ru/lead/seller/terms-of-cooperation']);
        $this->view->registerMetaTag(['property' => 'og:description', 'content' => 'Узнайте как зарабатывать вместе с нами! О наших преимуществах, а также условиях сотрудничества']);
        return $this->render('terms-of-cooperation');
    }
    public function actionSellTraffic()
    {
        $this->view->registerMetaTag(['name' => 'keywords', 'content' => 'Продать трафик лидов, продать лидов, продать лиды бфл, торговать лидами, заявки на бфл, продать заявки']);
        $this->view->registerMetaTag(['name' => 'description', 'content' => 'Мы приглашаем вас присоединиться к прогрессивной партнерской сети LEAD.FORCE и начать зарабатывать деньги, уже сегодня!']);
        $this->view->registerMetaTag(['property' => 'og:title', 'content' => 'Продать трафик']);
        $this->view->registerMetaTag(['property' => 'og:image', 'content' => 'https://myforce.ru/img/cpa.webp']);
        $this->view->registerMetaTag(['property' => 'og:url', 'content' => 'https://myforce.ru/lead/seller/sell-traffic']);
        $this->view->registerMetaTag(['property' => 'og:description', 'content' => 'Мы приглашаем вас присоединиться к прогрессивной партнерской сети LEAD.FORCE и начать зарабатывать деньги, уже сегодня!']);
        $offers = LeadTypes::find()->asArray()->distinct()->select(['category'])->all();
        return $this->render('sell-traffic', ['offers' => $offers]);
    }
    public function actionLeadOffer($link)
    {
        if(!empty($link)){
            $article = LeadTypes::findOne(['link'=>$link]);
            $this->view->registerMetaTag(['name' => 'keywords', 'content' => $article['meta_keywords']]);
            $this->view->registerMetaTag(['name' => 'description', 'content' => $article['meta_description']]);
            $this->view->registerMetaTag(['property' => 'og:title', 'content' => $article['og_title']]);
            $this->view->registerMetaTag(['property' => 'og:type', 'content' => 'article']);
            $this->view->registerMetaTag(['property' => 'og:image', 'content' => UrlHelper::admin($article['og_image'])]);
            $this->view->registerMetaTag(['property' => 'og:url', 'content' => 'https://myforce.ru/lead/seller/lead-offer/'.$article['link']]);
            $this->view->registerMetaTag(['property' => 'og:description', 'content' => $article['og_description']]);
            if(!empty($article)){
                $lead_type = LeadTypes::find()
                    ->where(['category' => $article['category']])
                    ->andWhere(['!=', 'id', $article['id']])
                    ->select(['id', 'image', 'category', 'regions', 'name', 'price', 'link'])
                    ->orderBy('id')
                    ->asArray()
                    ->limit(3)
                    ->all();
                return $this->render('lead-offer', ['article' => $article, 'leadType' => $lead_type]);
            } else return Yii::$app->response
                ->redirect(Url::to(['index']));
        } else return Yii::$app->response
            ->redirect(Url::to(['index']));
    }
    public function actionNews($link)
    {
        if(!empty($link)){
            $article = News::findOne(['link'=>$link]);
            $this->view->registerMetaTag(['name' => 'keywords', 'content' => $article['meta_keywords']]);
            $this->view->registerMetaTag(['name' => 'description', 'content' => $article['meta_description']]);
            $this->view->registerMetaTag(['property' => 'og:title', 'content' => $article['og_title']]);
            $this->view->registerMetaTag(['property' => 'og:type', 'content' => 'article']);
            $this->view->registerMetaTag(['property' => 'og:image', 'content' => $article['og_image']]);
            $this->view->registerMetaTag(['property' => 'og:url', 'content' => 'https://myforce.ru/lead/seller/news/'.$article['link']]);
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