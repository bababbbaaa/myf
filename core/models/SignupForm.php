<?php
namespace core\models;

use common\models\helpers\Mailer;
use common\models\helpers\TelegramBot;
use common\models\JobsQueue;
use common\models\UsersBonuses;
use common\models\UsersProperties;
use Yii;
use yii\base\Model;
use common\models\User;
use yii\debug\models\search\Mail;

/**
 * Signup form
 */
class SignupForm extends Model
{
    public $username;
    public $email;
    public $password;
    public $is_client;


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['username', 'trim'],
            ['username', 'required'],
            ['username', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This username has already been taken.'],
            ['username', 'string', 'min' => 2, 'max' => 255],

            ['email', 'trim'],
            ['email', 'string', 'max' => 255],
            //['email', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This email address has already been taken.'],

            ['password', 'required'],
            ['password', 'string', 'min' => Yii::$app->params['user.passwordMinLength']],

            ['is_client', 'integer'],
        ];
    }

    /**
     * Signs user up.
     *
     * @return bool whether the creating new account was successful and email was sent
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function signup()
    {
        if (!$this->validate()) {
            return null;
        }
        $user = new User();
        $user->username = $this->username;
        $user->is_client = $this->is_client;
        $user->email = !empty($this->email) ? $this->email : null;
        $user->setPassword($this->password);
        $user->generateAuthKey();
        $user->generateEmailVerificationToken();
        $rsp = $user->save();
        if ($rsp) {
            $tg = new TelegramBot();
            $tg->new__message($tg::signup__message($user->username), $tg::PEER_SUPPORT);
            $user->status = User::STATUS_INACTIVE; #После готовых смс поменять на STATUS_ACTIVE
            $user->update();
            $props = new UsersProperties();
            $props->params = '{"profile":{"email":1,"status":1,"balance":1,"push":1,"push_status":1,"new_lead":1,"proposition":1}}';
            $props->user_id = $user->id;
            $props->save();
            $bonuses = new UsersBonuses();
            $bonuses->createDefault($user->id);
            $bonuses->save();
            if (is_numeric($user->username)) {
                $queue = new JobsQueue();
                $queue->method = "registration__passed__bitrix";
                $queue->params = json_encode(["phone" => $user->username], JSON_UNESCAPED_UNICODE);
                $queue->date_start = date("Y-m-d H:i:s");
                $queue->status = 'wait';
                $queue->user_id = $user->id;
                $queue->closed = 0;
                $queue->save();
                if (!empty($user->email) && $user->is_client === 1) {
                    Mailer::create__start__queue($user->email, $user->id);
                    Mailer::create__signup__queue($user->email, $user->id);
                    Mailer::create__signup__queue__12($user->email, $user->id);
                    Mailer::create__signup__queue__15($user->email, $user->id);
                    Mailer::create__signup__queue__16($user->email, $user->id);
                    Mailer::create__signup__queue__17($user->email, $user->id);
                    Mailer::create__orders__queue($user->email, $user->id);
                }
            }
        }
        return $rsp ? $user->id : $rsp;
    }

    /**
     * Sends confirmation email to user
     * @param User $user user model to with email should be send
     * @return bool whether the email was sent
     */
    protected function sendEmail($user)
    {
        return Yii::$app
            ->mailer
            ->compose(
                ['html' => 'emailVerify-html', 'text' => 'emailVerify-text'],
                ['user' => $user]
            )
            ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name . ' robot'])
            ->setTo($this->email)
            ->setSubject('Account registration at ' . Yii::$app->name)
            ->send();
    }

}
