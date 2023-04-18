<?php


namespace console\controllers;


use admin\models\Admin;
use admin\models\CookieValidator;
use common\models\BavariaBotMessages;
use common\models\helpers\LawyerBot;
use common\models\helpers\M3Bot;
use common\models\helpers\TelegramBot;
use common\models\helpers\UrlHelper;
use common\models\JobsQueue;
use common\models\LbMessages;
use common\models\Leads;
use common\models\LogProcessor;
use common\models\m3\M3TelegramBot;
use common\models\M3Messages;
use common\models\TgMessages;
use console\models\ConsoleIntervalQuery;
use Yii;
use yii\console\Controller;
use yii\db\Expression;

class DaemonController extends Controller
{

    public function actionIntervalLeads() {
        gc_enable();
        while (!connection_aborted() || PHP_SAPI == "cli") {
            Yii::$app->db->close();
            Yii::$app->db->open();
            $current_time = date("Y-m-d H:i:s");
            $intervals = ConsoleIntervalQuery::find()
                ->where(['status' => ConsoleIntervalQuery::STATUS_WAIT])
                ->andWhere(['<=', 'process_time', $current_time])
                ->all();
            if (!empty($intervals)) {
                foreach ($intervals as $item) {
                    $sender = new Admin('leads');
                    $response = $sender->massLead(json_encode([$item->lead_id]), $item->order_id);
                    if ($response['status'] === 'error' && isset($response['systemErr'])) {
                        $item->status = ConsoleIntervalQuery::STATUS_ERROR;
                        $item->reason = $response['message'];
                        $item->update();
                        $lead = Leads::findOne($item->lead_id);
                        if (!empty($lead)) {
                            $lead->status = Leads::STATUS_MODERATE;
                            $lead->update();
                        }
                    } else {
                        $item->status = ConsoleIntervalQuery::STATUS_SUCCESS;
                        $item->update();
                        $lead = Leads::findOne($item->lead_id);
                        if (!empty($lead)) {
                            $lead->status = Leads::STATUS_SENT;
                            $lead->update();
                        }
                    }
                }
            }
            unset($intervals);
            unset($current_time);
            sleep(60);
            if (PHP_SAPI == "cli") {
                if (rand(5, 100) % 5 == 0) {
                    gc_collect_cycles();
                }
            }
        }
    }

    public function actionTelegramBot() {
        gc_enable();
        $nextPost = null;
        while (!connection_aborted() || PHP_SAPI == "cli") {
            Yii::$app->db->close();
            Yii::$app->db->open();
            $current_time = date("Y-m-d H:i:s");
            $tg = TgMessages::find()
                ->where(['is_done' => 0])
                ->andWhere(['<=', 'date_to_post', $current_time])
                ->andWhere(['is_loop' => 0])
                ->one();
            if (!empty($tg)) {
                $bot = new TelegramBot();
                $tg->convert__emoji();
                $bot->new__message($tg->message, $tg->peer, $tg->bot, 'markdown');
                if (!empty($tg->image)) {
                    usleep(100000);
                    $bot->send__image(UrlHelper::admin($tg->image), $tg->peer, $tg->bot);
                }
                $tg->is_done = 1;
                $tg->update();
            } else {
                if (empty($nextPost)) {
                    $next = new \DateTime();
                    $dayEnd = strtotime('tomorrow') - time();
                    $start = 5*60;
                    if ($dayEnd <= $start)
                        $start = 0;
                    $rand = mt_rand($start, $dayEnd);
                    if ($rand > 3600 * 2)
                        $rand = 3600 * 2 - mt_rand(60, 600);
                    $next->modify("+{$rand} seconds");
                    $nextPost = $next->format("Y-m-d H:i:s");
                    $this->stdout($nextPost);
                } else {
                    if ($current_time >= $nextPost) {
                        $nextPost = null;
                        $tg = TgMessages::find()
                            ->where(['is_done' => 0])
                            ->andWhere(['is_loop' => 1])
                            ->orderBy(new Expression('rand()'))
                            ->all();
                        if (!empty($tg)) {
                            /**
                             * @var TgMessages $item
                             */
                            $currentDay = date("N");
                            $currentHour = (int)date("G");
                            foreach ($tg as $item) {
                                $days = json_decode($item->days_to_post, 1);
                                if (!empty($days)) {
                                    if (!in_array($currentDay, $days))
                                        continue;
                                }
                                if ($currentHour < $item->minimum_time)
                                    continue;
                                $bot = new TelegramBot();
                                $bot->new__message($item->convert__emoji(), $item->peer, $item->bot, 'markdown');
                                if (!empty($item->image)) {
                                    usleep(100000);
                                    $bot->send__image(UrlHelper::admin($item->image), $item->peer, $item->bot);
                                }
                                $item->is_done = 1;
                                $item->update();
                                break;
                            }
                        }
                    }
                }
            }
            unset($current_time);
            unset($next);
            unset($dayEnd);
            unset($rand);
            unset($days);
            unset($currentDay);
            unset($currentHour);
            unset($bot);
            unset($tg);
            unset($start);
            sleep(60);
            if (PHP_SAPI == "cli") {
                if (rand(5, 100) % 5 == 0) {
                    gc_collect_cycles();
                }
            }
        }
    }

    /** Do jobs
     * @throws \Throwable
     * @throws \yii\db\Exception
     * @throws \yii\db\StaleObjectException
     */
    public function actionBackgroundJobs() {
        gc_enable();
        while (!connection_aborted() || PHP_SAPI == "cli") {
            Yii::$app->db->close();
            Yii::$app->db->open();
            $current_time = date("Y-m-d H:i:s");
            $jobs = JobsQueue::find()
                ->where(['<=', 'date_start', $current_time])
                ->andWhere(['status' => 'wait'])
                ->all();
            if (!empty($jobs)) {
                /**
                 * @var JobsQueue $item
                 */
                foreach ($jobs as $item) {
                    $response = $item->use__method();
                    $item->status = !empty($response['status']) ? $response['status'] : 'error';
                    if ($item->status === 'success')
                        $item->date_end = date("Y-m-d H:i:s");
                    $item->update();
                    usleep(100000);
                }
            }
            unset($current_time);
            unset($jobs);
            sleep(60);
            if (PHP_SAPI == "cli") {
                if (rand(5, 100) % 5 == 0) {
                    gc_collect_cycles();
                }
            }
        }
    }

    public function actionM3Helper() {
        gc_enable();
        $currHash = CookieValidator::findOne(3)->hash;
        while (!connection_aborted() || PHP_SAPI == "cli") {
            Yii::$app->db->close();
            Yii::$app->db->open();
            $messages = M3Messages::find()
                ->where(['status' => 'wait'])
                ->all();
            if (!isset($current_time)) {
                $current_time = time();
            }
            if (time() > $current_time + 3600) {
                $currHash = CookieValidator::findOne(3)->hash;
                unset($current_time);
            }
            if (!empty($messages)) {
                $tasks = [];
                $bot = new M3Bot();
                $bot->setCurrentHash($currHash);
                foreach ($messages as $item) {
                    if (isset($tasks[$item->uid]) && $tasks[$item->uid] === $item['task']) {
                        $item->delete();
                        continue;
                    }
                    $bot
                        ->setTask($item['task'])
                        ->taskChecker($item);
                    $tasks[$item->uid] = $item->task;
                    $item->status = 'done';
                    $item->update();
                }
            }
            unset($messages);
            unset($bot);
            sleep(1);
            if (PHP_SAPI == "cli") {
                if (rand(5, 100) % 5 == 0) {
                    gc_collect_cycles();
                }
            }
        }
    }

    public function actionLawyerHelper() {
        gc_enable();
        while (!connection_aborted() || PHP_SAPI == "cli") {
            Yii::$app->db->close();
            Yii::$app->db->open();
            $messages = LbMessages::find()
                ->where(['status' => 'wait'])
                ->all();
            if (!empty($messages)) {
                $tasks = [];
                $bot = new LawyerBot();
                foreach ($messages as $item) {
                    if (isset($tasks[$item->uid]) && $tasks[$item->uid] === $item['task']) {
                        $item->delete();
                        continue;
                    }
                    $bot
                        ->setTask($item['task'])
                        ->taskChecker($item);
                    $tasks[$item->uid] = $item->task;
                    $item->status = 'done';
                    $item->update();
                }
            }
            unset($messages);
            unset($bot);
            sleep(1);
            if (PHP_SAPI == "cli") {
                if (rand(5, 100) % 5 == 0) {
                    gc_collect_cycles();
                }
            }
        }
    }


    public function actionBavaria() {
        gc_enable();
        while (!connection_aborted() || PHP_SAPI == "cli") {
            Yii::$app->db->close();
            Yii::$app->db->open();
            $messages = BavariaBotMessages::find()
                ->where(['status' => 'wait'])
                ->all();
            if (!empty($messages)) {
                foreach ($messages as $item) {
                    M3TelegramBot::respond($item);
                }
            }
            unset($messages);
            sleep(1);
            if (PHP_SAPI == "cli") {
                if (rand(5, 100) % 5 == 0) {
                    gc_collect_cycles();
                }
            }
        }
    }

}