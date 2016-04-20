<?php

namespace app\models;


use Yii;
use kartik\builder\Form;

/**
 * This is the model class for table "{{%VDC_MEMBER_PROFILE}}".
 *
 * @property integer $member_id
 * @property string $member_username
 * @property string $member_fname
 * @property string $member_lname
 * @property string $member_pid
 * @property string $member_address
 * @property string $member_city
 * @property string $member_province
 * @property string $member_zipcode
 * @property string $member_email
 * @property string $member_telno
 * @property string $member_smsno
 * @property string $member_created
 * @property string $member_balance
 * @property string $member_bankref
 * @property string $member_created_user
 */
class Member extends \yii\db\ActiveRecord
{
    const SCENARIO_ADMIN = 'admin';
    const SCENARIO_MEMBER = 'member';
    // declare deviceIds property
    public $deviceIds = [];

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_MEMBER] = ['member_email', 'member_telno', 'member_smsno'];
        return $scenarios;
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%VDC_MEMBER_PROFILE}}';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db1');
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['member_created'], 'safe'],
            [['member_balance'], 'number'],
            [['member_username', 'member_fname', 'member_lname', 'member_pid', 'member_city', 'member_province', 'member_zipcode', 'member_email', 'member_telno', 'member_smsno', 'member_bankref', 'member_created_user'], 'string', 'max' => 45],
            [['member_address'], 'string', 'max' => 200],
            [['member_username'], 'unique'],
            [['member_email'], 'email', 'skipOnEmpty' => true],
        ];
    }

    /**
     * @inheritdoc
     */
    public function getFormAttribs()
    {
        $labels = $this->attributeLabels();
        return [
//            'member_id'           => [
//                'label' => $labels['member_id'],
//            ],
            'member_username'     => [
                'label' => $labels['member_username'],
            ],
            'member_fname'        => [
                'label' => $labels['member_fname'],
            ],
            'member_lname'        => [
                'label' => $labels['member_lname'],
            ],
            'member_pid'          => [
                'label' => $labels['member_pid'],
            ],
            'member_address'      => [
                'label' => $labels['member_address'],
            ],
            'member_city'         => [
                'label' => $labels['member_city'],
            ],
            'member_province'     => [
                'label' => $labels['member_province'],
            ],
            'member_zipcode'      => [
                'label' => $labels['member_zipcode'],
            ],
            'member_email'        => [
                'label' => $labels['member_email'],
                //'type'  => Form::INPUT_TEXT,
            ],
            'member_telno'        => [
                'label' => $labels['member_telno'],
                //'type'  => Form::INPUT_TEXT,
            ],
            'member_smsno'        => [
                'label' => $labels['member_smsno'],
                //'type'  => Form::INPUT_TEXT,
            ],
//            'member_created'      => [
//                'label' => $labels['member_created'],
//            ],
//            'member_balance'      => [
//                'label' => $labels['member_balance'],
//            ],
//            'member_bankref'      => [
//                'label' => $labels['member_bankref'],
//            ],
//            'member_created_user' => [
//                'label' => $labels['member_created_user'],
//            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'member_id' => Yii::t('app/member', 'ID'),
            'member_username' => Yii::t('app/member', 'Username'),
            'member_fname' => Yii::t('app/member', 'First Name'),
            'member_lname' => Yii::t('app/member', 'Surname'),
            'member_pid' => Yii::t('app/member', 'Id Card Number'),
            'member_address' => Yii::t('app/member', 'Address'),
            'member_city' => Yii::t('app/member', 'City'),
            'member_province' => Yii::t('app/member', 'Province'),
            'member_zipcode' => Yii::t('app/member', 'Zip Code'),
            'member_email' => Yii::t('app/member', 'Email Address'),
            'member_telno' => Yii::t('app/member', 'Phone Number'),
            'member_smsno' => Yii::t('app/member', 'SMS Number'),
            'member_created' => Yii::t('app/member', 'Created At'),
            'member_balance' => Yii::t('app/member', 'Balance'),
            'member_bankref' => Yii::t('app/member', 'Bank Reference'),
            'member_created_user' => Yii::t('app/member', 'Created By'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDevice()
    {
        return $this->hasMany(Device::className(), ['dev_member' => 'member_id']);
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['member_username' => $username]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['username' => 'member_username']);
    }

    // we need a getter for select dropdown
    public static function getDropDownMember($condition = [])
    {
        return \yii\helpers\ArrayHelper::map(static::find()->select(['member_id', 'member_username'])->asArray()->filterWhere($condition)->all(), 'member_id', 'member_username');
    }

    // We will need a getter for the current set of Devices of a Sale
    public function getDeviceIds()
    {
        $this->deviceIds = \yii\helpers\ArrayHelper::getColumn(
            $this->getDevice()->select(['dev_id'])->asArray()->all(),
            'dev_id'
        );
        return $this->deviceIds;
    }
    
    
}
