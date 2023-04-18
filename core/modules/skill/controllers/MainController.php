<?php

namespace app\modules\skill\controllers;

use common\models\News;
use common\models\SkillArticles;
use common\models\SkillPartners;
use common\models\SkillReviewsAboutTraining;
use common\models\SkillReviewsProfession;
use common\models\SkillReviewsVideo;
use common\models\SkillTrainings;
use common\models\SkillTrainingsAuthors;
use common\models\SkillTrainingsCategory;
use yii\helpers\Url;
use yii\web\Controller;
use Yii;
use yii\data\Pagination;

class MainController extends Controller
{

    public function actionIndex()
    {
        $this->view->registerMetaTag(['name' => 'keywords', 'content' => 'Онлайн-обучение, Онлайн курсы, Вебинары, Интенсивы, Курсы Skill.Force, SKILL.FORCE, skillforce']);
        $this->view->registerMetaTag(['name' => 'description', 'content' => 'Научитесь новому. Смените профессию. Найдите свое призвание.']);
        $this->view->registerMetaTag(['property' => 'og:title', 'content' => 'Онлайн-обучение востребованным навыкам']);
        $this->view->registerMetaTag(['property' => 'og:image', 'content' => 'https://myforce.ru/img/he-s1-bg.webp']);
        $this->view->registerMetaTag(['property' => 'og:url', 'content' => 'https://myforce.ru/skill']);
        $this->view->registerMetaTag(['property' => 'og:description', 'content' => 'Научитесь новому. Смените профессию. Найдите свое призвание.']);
        $category = SkillTrainingsCategory::find()->all();
        $courses = SkillTrainings::find()
            ->orderBy('id desc')
            ->limit(4)
            ->asArray()
            ->all();
        $bflCourses = SkillTrainings::find()
            ->orderBy('id desc')
            ->limit(3)
            ->where('content_block_tags' == 'smm')
            ->asArray()
            ->all();
        $videoReviews = SkillReviewsVideo::find()->asArray()->limit(6)->all();

        $garantCources = SkillTrainings::find()
            ->limit(2)
            ->where(['OR',
                ['like', 'tags', '%' . 'трудоустройство' . '%', false],
                ['like', 'tags', '%' . 'гарантия' . '%', false]
            ])
            ->asArray()
            ->all();
        $authors = SkillTrainingsAuthors::find()->asArray()->orderBy('rand()')->limit(6)->all();
        return $this->render('index',
            [
                'category' => $category,
                'courses' => $courses,
                'bflCourses' => $bflCourses,
                'garantCources' => $garantCources,
                'authors' => $authors,
                'videoReviews' => $videoReviews,
            ]);
    }

    public function actionWebinars()
    {
        $filters = ['AND'];

        $word = $_GET['Search'];
        if (!empty($word)) {
            $filters[] = ['OR',
                ['like', 'name', '%' . $word . '%', false],
                ['like', 'author_id', '%' . $word . '%', false],
                ['like', 'content_subtitle', '%' . $word . '%', false],
                ['like', 'content_about', '%' . $word . '%', false],
                ['like', 'content_block_description', '%' . $word . '%', false],
                ['like', 'content_block_tags', '%' . $word . '%', false],
                ['like', 'content_what_study', '%' . $word . '%', false],
                ['like', 'content_terms', '%' . $word . '%', false]
            ];
        }
        $direction = $_GET['direction'];
        if (!empty($direction)) {
            if ($direction == 'all') {
                $filters[] = '';
            } else {
                $filters[] = ['=', 'category_id', $direction];
            }
        }
        $level = $_GET['level'];
        if (!empty($level)) {
            $filters[] = ['=', 'student_level', $level];
        }
        $price = $_GET['price'];
        if (!empty($price)){
            if ($price === 'free'){
                $filters[] = ['=', 'price', 0];
            } else {
                $filters[] = ['>', 'price', 0];
            }
        }

        $free = SkillTrainings::find()->where(['price' => 0])->andWhere(['type' => 'Вебинар'])->andWhere(['active' => 1])->count();
        $paid = SkillTrainings::find()->where(['>', 'price', 0])->andWhere(['type' => 'Вебинар'])->andWhere(['active' => 1])->count();

        $webinars = SkillTrainings::find()
            ->where(['type' => 'Вебинар'])
            ->andWhere($filters)
            ->andWhere(['active' => 1])
            ->limit(!empty($_GET['count']) ? (int)$_GET['count'] : 2)
            ->asArray()
            ->all();
        $webinarsColl = SkillTrainings::find()->where(['type' => 'Вебинар'])->count();
        $level = SkillTrainings::find()->select('student_level')->distinct()->asArray()->all();
        $directions = SkillTrainingsCategory::find()->asArray()->all();

        $this->view->registerMetaTag(['name' => 'keywords', 'content' => 'Вебинары SKILL.FORCE, Вебинары, профессия за один день']);
        $this->view->registerMetaTag(['name' => 'description', 'content' => 'Прокачайтесь за 1 день']);
        $this->view->registerMetaTag(['property' => 'og:title', 'content' => 'Вебинары SKILL.FORCE']);
        $this->view->registerMetaTag(['property' => 'og:image', 'content' => 'https://myforce.ru/img/he-s1-bg.webp']);
        $this->view->registerMetaTag(['property' => 'og:url', 'content' => 'https://myforce.ru/skill/webinars']);
        $this->view->registerMetaTag(['property' => 'og:description', 'content' => 'Прокачайтесь за 1 день']);
        return $this->render('webinars', [
            'webinars' => $webinars,
            'webinarsColl' => $webinarsColl,
            'directions' => $directions,
            'level' => $level,
            'free' => $free,
            'paid' => $paid,
        ]);
    }

    public function actionAbout()
    {

        $category = SkillTrainingsCategory::find()->limit(8)->all();

        $this->view->registerMetaTag(['name' => 'keywords', 'content' => 'О проекте SKILL.FORCE, skillforce, skill.force, Курсы от SKILL.FORCE, MYFORCE, myforce']);
        $this->view->registerMetaTag(['name' => 'description', 'content' => 'Мы помогаем осваивать проффесии с нуля. Проводим онлайн-интенсивы и бесплатные вебинары, тестирования, чтобы каждый мог выбрать дело своей жизни']);
        $this->view->registerMetaTag(['property' => 'og:title', 'content' => 'SKILL.FORCE — образовательный портал']);
        $this->view->registerMetaTag(['property' => 'og:image', 'content' => 'https://myforce.ru/img/S1C.svg']);
        $this->view->registerMetaTag(['property' => 'og:url', 'content' => 'https://myforce.ru/skill/about']);
        $this->view->registerMetaTag(['property' => 'og:description', 'content' => 'Мы помогаем осваивать проффесии с нуля. Проводим онлайн-интенсивы и бесплатные вебинары, тестирования, чтобы каждый мог выбрать дело своей жизни']);
        return $this->render('about', [
            'category' => $category,
        ]);
    }

    public function actionIntensive()
    {

        $intensiveCount = SkillTrainings::find()
            ->where(['type' => 'Интенсив'])
            ->count();

        $filters = ['AND'];

        $word = $_GET['Search'];
        if (!empty($word)) {
            $filters[] = ['OR',
                ['like', 'name', '%' . $word . '%', false],
                ['like', 'author_id', '%' . $word . '%', false],
                ['like', 'content_subtitle', '%' . $word . '%', false],
                ['like', 'content_about', '%' . $word . '%', false],
                ['like', 'content_block_description', '%' . $word . '%', false],
                ['like', 'content_block_tags', '%' . $word . '%', false],
                ['like', 'content_what_study', '%' . $word . '%', false],
                ['like', 'content_terms', '%' . $word . '%', false]
            ];
        }
        $direction = $_GET['direction'];
        if (!empty($direction)) {
            if ($direction == 'all') {
                $filters[] = '';
            } else {
                $filters[] = ['=', 'category_id', $direction];
            }
        }
        $level = $_GET['level'];
        if (!empty($level)) {
            $filters[] = ['=', 'student_level', $level];
        }
        $intensive = SkillTrainings::find()
            ->where(['type' => 'Интенсив'])
            ->andWhere($filters)
            ->andWhere(['active' => 1])
            ->limit(!empty($_GET['count']) ? (int)$_GET['count'] : 2)
            ->orderBy('id desc')
            ->all();
        $directions = SkillTrainingsCategory::find()->asArray()->all();
        $level = SkillTrainings::find()->select('student_level')->distinct()->asArray()->all();

        $this->view->registerMetaTag(['name' => 'keywords', 'content' => 'Интенсивы SKILL.FORCE, Интенсивы, быстрое получение профессии']);
        $this->view->registerMetaTag(['name' => 'description', 'content' => 'Новая жизнь — новая профессия']);
        $this->view->registerMetaTag(['property' => 'og:title', 'content' => 'Интенсивы SKILL.FORCE']);
        $this->view->registerMetaTag(['property' => 'og:image', 'content' => 'https://myforce.ru/img/Rectangle%20584.webp']);
        $this->view->registerMetaTag(['property' => 'og:url', 'content' => 'https://myforce.ru/skill/intensive']);
        $this->view->registerMetaTag(['property' => 'og:description', 'content' => 'Новая жизнь — новая профессия']);
        return $this->render('intensive', [
            'intensiveCount' => $intensiveCount,
            'intensive' => $intensive,
            'directions' => $directions,
            'level' => $level,
        ]);
    }

    public function actionPrepodavanie()
    {

        $videoReviews = SkillReviewsVideo::find()->asArray()->limit(6)->all();
        $speacker = SkillTrainings::find()->asArray()->limit(4)
            ->where(['OR',
                ['like', 'tags', '%спикеры%', false],
                ['like', 'tags', '%спикеры%', false]
            ])->all();

        $this->view->registerMetaTag(['name' => 'keywords', 'content' => 'Обучение, стать спикером, Стать преподавателем, создать свой курс, личный вебинар, авторские курсы, интенсивы, вебинары']);
        $this->view->registerMetaTag(['name' => 'description', 'content' => 'Станьте спикером курсов и зарабатывайте, обучая людей по всему миру']);
        $this->view->registerMetaTag(['property' => 'og:title', 'content' => 'Мир ждет ваших знаний!']);
        $this->view->registerMetaTag(['property' => 'og:image', 'content' => 'https://myforce.ru/img/PS1.webp']);
        $this->view->registerMetaTag(['property' => 'og:url', 'content' => 'https://myforce.ru/skill/teaching']);
        $this->view->registerMetaTag(['property' => 'og:description', 'content' => 'Станьте спикером курсов и зарабатывайте, обучая людей по всему миру']);
        return $this->render('prepodavanie', [
            'videoReviews' => $videoReviews,
            'speacker' => $speacker,
        ]);
    }

    public function actionProfession()
    {
        $courceCount = SkillTrainings::find()
            ->where(['type' => 'Курс'])
            ->count();

        $filters = ['AND'];

        $word = $_GET['Search'];
        if (!empty($word)) {
            $filters[] = ['OR',
                ['like', 'name', '%' . $word . '%', false],
                ['like', 'author_id', '%' . $word . '%', false],
                ['like', 'content_subtitle', '%' . $word . '%', false],
                ['like', 'content_about', '%' . $word . '%', false],
                ['like', 'content_block_description', '%' . $word . '%', false],
                ['like', 'content_block_tags', '%' . $word . '%', false],
                ['like', 'content_what_study', '%' . $word . '%', false],
                ['like', 'content_terms', '%' . $word . '%', false]
            ];
        }
        $direction = $_GET['direction'];
        if (!empty($direction)) {
            if ($direction == 'all') {
                $filters[] = '';
            } else {
                $filters[] = ['=', 'category_id', $direction];
            }
        }
        $partners = $_GET['partner'];
        if (!empty($partners)) {
            $filters[] = ['=', 'partner_link', $partners];
        }
        $level = $_GET['level'];
        if (!empty($level)) {
            $filters[] = ['=', 'student_level', $level];
        }

        $cource = SkillTrainings::find()
            ->where(['type' => 'Курс'])
            ->andWhere($filters)
            ->andWhere(['active' => 1])
            ->limit(!empty($_GET['count']) ? (int)$_GET['count'] : 2)
            ->orderBy('id desc')
            ->all();

        $directions = SkillTrainingsCategory::find()->asArray()->all();
        $partners = SkillPartners::find()->all();
        $level = SkillTrainings::find()->select('student_level')->distinct()->asArray()->all();


        $this->view->registerMetaTag(['name' => 'keywords', 'content' => 'Получить работу, Курсы SKILL.FORCE, обучение профессии, SKILL.FORCE']);
        $this->view->registerMetaTag(['name' => 'description', 'content' => 'Получите работу в командах наших партнеров уже через 30 дней. После окончания курсов с трудойстройством вы получаете работу в ведущих компаниях страны']);
        $this->view->registerMetaTag(['property' => 'og:title', 'content' => 'Курсы SKILL.FORCE']);
        $this->view->registerMetaTag(['property' => 'og:image', 'content' => 'https://myforce.ru/img/Rectangle%20584.webp']);
        $this->view->registerMetaTag(['property' => 'og:url', 'content' => 'https://myforce.ru/skill/profession']);
        $this->view->registerMetaTag(['property' => 'og:description', 'content' => 'Получите работу в командах наших партнеров уже через 30 дней. После окончания курсов с трудойстройством вы получаете работу в ведущих компаниях страны']);
        return $this->render('profession', [
            'courceCount' => $courceCount,
            'cource' => $cource,
            'directions' => $directions,
            'partners' => $partners,
            'level' => $level,
        ]);
    }

    public function actionBlog()
    {
        $newsCount = News::find()->where(['OR', ['tag' => 'общие'], ['tag' => 'главная']])->count();

        $filters = ['AND'];

        $word = $_GET['Search'];
        if (!empty($word)) {
            $filters[] = ['OR',
                ['like', 'title', '%' . $word . '%', false],
                ['like', 'author', '%' . $word . '%', false],
                ['like', 'content', '%' . $word . '%', false],
            ];
        }
        $day = date('Y-m-d H:i:s', time() - (60 * 60 * 24));
        $week = date('Y-m-d H:i:s', time() - (60 * 60 * 24 * 7));
        $month = date('Y-m-d H:i:s', time() - (60 * 60 * 24 * 30));
        $year = date('Y-m-d H:i:s', time() - (60 * 60 * 24 * 365));
        $date = $_GET['date'];
        if (!empty($date)) {
            if ($date == 'all') {
                $filters[] = '';
            } elseif ($date == 'day') {
                $filters[] = ['>=', 'date', $day];
            } elseif ($date == 'week') {
                $filters[] = ['>', 'date', $week];
            } elseif ($date == 'month') {
                $filters[] = ['>', 'date', $month];
            } elseif ($date == 'year') {
                $filters[] = ['>', 'date', $year];
            }
        }

        $newsNew = News::find()
            ->where(['OR', ['tag' => 'общие'], ['tag' => 'главная']])
            ->asArray()
            ->orderBy('date desc')
            ->one();

        $news = News::find()
            ->where(['OR', ['tag' => 'общие'], ['tag' => 'главная']])
            ->andWhere(['!=', 'id', $newsNew['id']])
            ->andWhere($filters)
            ->asArray()
            ->orderBy('date desc');

        $pages = new Pagination(['totalCount' => $news->count(), 'pageSize' => 12]);
        $posts = $news->offset($pages->offset)
            ->limit($pages->limit)
            ->all();


        $this->view->registerMetaTag(['name' => 'keywords', 'content' => 'Новости SKILL.FORCE, новости банкротства, новости бизнесса, новости о профессиях']);
        $this->view->registerMetaTag(['name' => 'description', 'content' => 'Узнайте последние повости о бизнесе и актуальных сферах деятельности']);
        $this->view->registerMetaTag(['property' => 'og:title', 'content' => 'Блог SKILL.FORCE']);
        $this->view->registerMetaTag(['property' => 'og:image', 'content' => 'https://myforce.ru/img/bg-s1.webp']);
        $this->view->registerMetaTag(['property' => 'og:url', 'content' => 'https://myforce.ru/skill/blog']);
        $this->view->registerMetaTag(['property' => 'og:description', 'content' => 'Узнайте последние повости о бизнесе и актуальных сферах деятельности']);
        return $this->render('blog', [
            'news' => $posts,
            'pages' => $pages,
            'newsNew' => $newsNew,
            'newsCount' => $newsCount,
        ]);
    }

    public function actionArticle($link = null)
    {
        if (empty($link)){
            return $this->redirect('blog');
        }
        $news = News::find()->where(['link' => $link])->asArray()->one();
        if (empty($news)){
            return $this->redirect('blog');
        }
        $moreNews = News::find()
            ->where(['!=', 'id', $news['id']])
            ->andWhere(['OR', ['tag' => 'общие'], ['tag' => 'главная']])
            ->asArray()
            ->limit(4)
            ->all();

        $course = SkillTrainings::find()
            ->where(['type' => 'Курс'])
            ->limit(4)
            ->orderBy('id desc')
            ->all();


        $this->view->registerMetaTag(['name' => 'keywords', 'content' => $news['meta_keywords']]);
        $this->view->registerMetaTag(['name' => 'description', 'content' => $news['meta_description']]);
        $this->view->registerMetaTag(['property' => 'og:title', 'content' => $news['og_title']]);
        $this->view->registerMetaTag(['property' => 'og:type', 'content' => 'article']);
        $this->view->registerMetaTag(['property' => 'og:image', 'content' => $news['og_image']]);
        $this->view->registerMetaTag(['property' => 'og:url', 'content' => "https://myforce.ru/skill/article?link={$link}"]);
        $this->view->registerMetaTag(['property' => 'og:description', 'content' => $news['og_description']]);
        return $this->render('article', [
            'news' => $news,
            'moreNews' => $moreNews,
            'course' => $course,
        ]);
    }

    public function actionCareer()
    {

        $partner = SkillPartners::find()->limit(8)->asArray()->all();
        $id = $_POST['id'];
        $partnerInfo = SkillPartners::find()->where(['id' => $id])->asArray()->one();
        $reviews = SkillReviewsProfession::find()->asArray()->limit(8)->all();
        $garantCources = SkillTrainings::find()
            ->limit(2)
            ->where(['OR',
                ['like', 'tags', '%трудоустройст%', false],
                ['like', 'tags', '%гарантия%', false]
            ])
            ->asArray()
            ->all();

        $this->view->registerMetaTag(['name' => 'keywords', 'content' => 'Подобрать курс, курсы SKILL.FORCE, получить профессию, начать зарабатывать']);
        $this->view->registerMetaTag(['name' => 'description', 'content' => 'Чтобы наши студенты применили полученные знания на практике и нашли работу мечты, мы запустили курсы с гарантированным трудоустройтвом']);
        $this->view->registerMetaTag(['property' => 'og:title', 'content' => 'Начни карьеру вместе с SKILL.FORCE']);
        $this->view->registerMetaTag(['property' => 'og:type', 'content' => 'article']);
        $this->view->registerMetaTag(['property' => 'og:image', 'content' => 'https://myforce.ru/img/car-s1-bg.png']);
        $this->view->registerMetaTag(['property' => 'og:url', 'content' => 'https://myforce.ru/skill/career']);
        $this->view->registerMetaTag(['property' => 'og:description', 'content' => 'Чтобы наши студенты применили полученные знания на практике и нашли работу мечты, мы запустили курсы с гарантированным трудоустройтвом']);
        return $this->render('career', [
            'partner' => $partner,
            'partnerInfo' => $partnerInfo,
            'reviews' => $reviews,
            'garantCources' => $garantCources,
        ]);
    }

    public function actionCoursepage($link)
    {
        if (empty($link)) {
            return $this->redirect('catalog');
        }
        $cource = SkillTrainings::findOne(['link' => $link]);
        if (empty($cource)) {
            return $this->redirect('catalog');
        }
        $moreCource = SkillTrainings::find()
            ->where(['!=', 'id', $cource->id])
            ->andWhere(['author_id' => $cource->author_id])
            ->limit(4)
            ->asArray()
            ->all();

        $this->view->registerMetaTag(['name' => 'keywords', 'content' => $cource->meta_keywords]);
        $this->view->registerMetaTag(['name' => 'description', 'content' => $cource->meta_description]);
        $this->view->registerMetaTag(['property' => 'og:title', 'content' => $cource->og_title]);
        $this->view->registerMetaTag(['property' => 'og:image', 'content' => $cource->og_image]);
        $this->view->registerMetaTag(['property' => 'og:url', 'content' => "https://myforce.ru/skill/coursepage?link={$cource->link}"]);
        $this->view->registerMetaTag(['property' => 'og:description', 'content' => $cource->og_description]);
        return $this->render('coursepage', [
            'cource' => $cource,
            'moreCource' => $moreCource
        ]);
    }

    public function actionTeacher($link)
    {
        if (empty($link)) {
            return $this->redirect('/skill');
        }
        $author = SkillTrainingsAuthors::findOne(['link' => $link]);
        if (empty($author)) {
            return $this->redirect('/skill');
        }

        $this->view->registerMetaTag(['name' => 'keywords', 'content' => "{$author->name}, Авторы SKILL.FORCE, Авторы курсов"]);
        $this->view->registerMetaTag(['name' => 'description', 'content' => $author->small_description]);
        $this->view->registerMetaTag(['property' => 'og:title', 'content' => $author->name]);
        $this->view->registerMetaTag(['property' => 'og:type', 'content' => 'article']);
        $this->view->registerMetaTag(['property' => 'og:image', 'content' => "https://admin.myforce.ru{$author->photo}"]);
        $this->view->registerMetaTag(['property' => 'og:url', 'content' => "https://myforce.ru/skill/teacher?link={$author->link}"]);
        $this->view->registerMetaTag(['property' => 'og:description', 'content' => $author->small_description]);
        return $this->render('teacher', [
            'author' => $author,
        ]);
    }

    public function actionTest()
    {

        $post = $_POST['theme'];
        $course = [];
        if (!empty($post)){
            foreach ($post as $v){
                $course[] = SkillTrainings::find()->asArray()
                    ->where(['like', 'tags', '%'. $v . '%', false])
                    ->andWhere(['type' => 'Курс'])->all();;
            }
        }

        $this->view->registerMetaTag(['name' => 'keywords', 'content' => 'Выбрать профессию, Тест на определение профессии, узнать свою профессию']);
        $this->view->registerMetaTag(['name' => 'description', 'content' => 'Пройдите тест, у узнаете к какой подходящей профессии вы расположены']);
        $this->view->registerMetaTag(['property' => 'og:title', 'content' => 'Определите вашу профессию']);
        $this->view->registerMetaTag(['property' => 'og:image', 'content' => 'https://myforce.ru/img/he-s1-bg.webp']);
        $this->view->registerMetaTag(['property' => 'og:url', 'content' => 'https://myforce.ru/skill/test']);
        $this->view->registerMetaTag(['property' => 'og:description', 'content' => 'Пройдите тест, у узнаете к какой подходящей профессии вы расположены']);
        return $this->render('test', [
            'course' => $course,
            'post' => $post,
        ]);
    }


}
