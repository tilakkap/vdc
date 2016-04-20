<?php
/**
 * Created by PhpStorm.
 * User: Thomas
 * Date: 03.03.2016
 * Time: 20:10
 */
namespace app\models;

use yii\base\Model;
use Yii;
/**
 * Password reset form
 */
class ChangePasswordForm extends Model
{
    public $old_password;
    public $new_password;
    public $new_password_repeat;

    private $_user;


    /**
     * Creates a form model current User
     */
    public function __construct($config=[])
    {
        $this->_user = User::findOne(['id' => \yii::$app->user->id]);
        parent::__construct($config);
    }


    public function comparePasswordHash($attribute) {
        if (!\Yii::$app->getSecurity()->validatePassword($this->$attribute, $this->_user->password_hash)) {
            $this->addError($attribute, Yii::t("app", "Old Password is not correct"));
            return false;
        }
    }


    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'old_password' => Yii::t('app', 'Old Password'),
            'new_password' => Yii::t('app', 'New Password'),
            'new_password_repeat' => Yii::t('app', 'Repeat New Password'),
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['new_password','new_password_repeat', 'old_password'], 'required'],
            [['new_password','new_password_repeat'], 'string', 'min' => 6],
            ['new_password_repeat', 'compare', 'compareAttribute'=>'new_password', 'message' => Yii::t("app", "The passwords must match")],
            ['old_password', 'comparePasswordHash'],

        ];
    }
    /**
     * Resets password.
     *
     * @return boolean if password was reset.
     */
    public function changePassword()
    {
        $user = $this->_user;
        $user->password = $this->new_password;
        return $user->save();
    }
}
