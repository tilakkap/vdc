<?php
/**
 * Created by PhpStorm.
 * User: Thomas
 * Date: 06.02.16
 * Time: 20:12
 */
namespace app\models;

use Yii;
use yii\base\Model;

/**
 * Password reset request form
 * @property mixed member_telno
 */
class PasswordResetRequestForm extends Model
{
    public $email;
    public $member_telno;
    public $member_username;
    public $phone;


    const SCENARIO_SMS = 'sms';
    const SCENARIO_SALE = 'sale';
    const SCENARIO_EMAIL = 'email';

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_EMAIL] = ['email'];
        $scenarios[self::SCENARIO_SMS] = ['member_telno', 'member_username'];
        $scenarios[self::SCENARIO_SALE] = ['phone'];
        return $scenarios;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            [
                'email', 'exist',
                'targetClass' => '\app\models\User',
                'filter'      => ['status' => User::STATUS_ACTIVE],
                'message'     => 'There is no user with such email.',
            ],

            ['member_telno', 'filter', 'filter' => 'trim'],
            
            ['member_telno', 'required'],
            [
                ['member_telno', 'member_username'], 'exist',
                'targetClass'     => '\app\models\Member',
                'targetAttribute' => ['member_telno', 'member_username'],
                'message'         => Yii::t('app','There is no user with such phone number.'),
            ],

            ['phone', 'filter', 'filter' => 'trim'],
            ['phone', 'required'],
            [
                'phone', 'exist',
                'targetClass' => '\app\models\Sale',
                'message'     => Yii::t('app','There is no user with such phone number.'),
            ],
        ];
    }

    public function attributeLabels()
    {
        return [
            'email'           => Yii::t('app/member', 'Email Address'),
            'member_telno'    => Yii::t('app/member', 'SMS Number'),
            'phone'           => Yii::t('app/member', 'SMS Number'),
            'member_username' => Yii::t('app', 'Username'),
        ];
    }


    /**
     * Sends an email with a link, for resetting the password.
     *
     * @return boolean whether the email was send
     */
    public function sendEmail()
    {
        /* @var $user User */
        $user = User::findOne([
            'status' => User::STATUS_ACTIVE,
            'email'  => $this->email,
        ]);
        if ($user) {
            if (!User::isPasswordResetTokenValid($user->password_reset_token)) {
                $user->generatePasswordResetToken();
            }
            if ($user->save()) {
                return \Yii::$app->mailer->compose('passwordResetToken', ['user' => $user])
                    ->setFrom([\Yii::$app->params['supportEmail'] => \Yii::$app->name . ' robot'])
                    ->setTo($this->email)
                    ->setSubject('Password reset for ' . \Yii::$app->name)
                    ->send();
            }
        }
        return false;
    }

    /**
     * Sends an email with a link, for resetting the password.
     *
     * @return boolean whether the email was send
     */
    public function sendSMS()
    {
        $addRole = true;
        $person = $this->getPerson();
        if ($user = $person['user']) {
            if (!User::isPasswordResetTokenValid($user->password_reset_token)) {
                $user->generatePasswordResetToken('S');
            }
            $addRole = false;
        } else {
            $user = new User();
            $user->username = $person['username'];
            $user->generatePasswordResetToken('S');
            $user->status = $user::STATUS_ACTIVE;

        }

        if ($user->save()) {
            if ($addRole) {
                // the following three lines were added:
                $auth = Yii::$app->authManager;
                $authorRole = $auth->getRole($person['role']);
                $auth->assign($authorRole, $user->getId());
            }

            $Username = \Yii::$app->params['sms']['username'];
            $Password = \Yii::$app->params['sms']['password'];
            $PhoneList = $person['phone'];
            //$PhoneList = '0909497888';
            $Message = \Yii::t('app', 'Reset Code: {token} for User: {user} If you did not request a password reset please contact your administrator', ['token' => $user->password_reset_token, 'user'=>$user->username]);
            $Sender = \Yii::$app->params['sms']['sender'];

            $Message = iconv('UTF-8', 'TIS-620', $Message);
            $Message = urlencode($Message);

            $Parameter = "User=$Username&Password=$Password&Msnlist=$PhoneList&Msg=$Message&Sender=$Sender";
            $API_URL = \Yii::$app->params['sms']['gateway'];

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $API_URL);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $Parameter);

            $Result = curl_exec($ch);
            curl_close($ch);
            //echo($Result);
            return true;
        }
        return false;
    }


    private function getPerson()
    {
        if ($this->scenario === self::SCENARIO_SALE) {
            $sale = Sale::find()->where(['phone' => $this->phone])->with('user')->one();
            return [
                'username' => $sale->sale_username,
                'phone'    => $sale->phone,
                'user'     => $sale->user,
                'role'     => 'Sale',
            ];

        } else if ($this->scenario === self::SCENARIO_SMS) {
            $member = Member::find()->where(['member_telno' => $this->member_telno])
                ->andWhere(['member_username' => $this->member_username])->with('user')->one();

            return [
                'username' => $member->member_username,
                'phone'    => $member->member_telno,
                'user'     => $member->user,
                'role'     => 'Member',

            ];
        }
        return null;
    }


    private static function utf8_to_tis620($string)
    {
        $str = $string;
        $res = "";
        for ($i = 0; $i < strlen($str); $i++) {
            if (ord($str[$i]) == 224) {
                $unicode = ord($str[$i + 2]) & 0x3F;
                $unicode |= (ord($str[$i + 1]) & 0x3F) << 6;
                $unicode |= (ord($str[$i]) & 0x0F) << 12;
                $res .= chr($unicode - 0x0E00 + 0xA0);
                $i += 2;
            } else {
                $res .= $str[$i];
            }
        }
        return $res;
    }
}