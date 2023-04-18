<?php
/* @var $this yii\web\View
 * @var $article \common\models\News
 */

use yii\helpers\Url;
use common\models\helpers\UrlHelper;

$this->title = $article['title'];

$link = $_GET['link'];

print_r($link);

header('Location: https://myforce.ru/news-page/'. $link)



?>