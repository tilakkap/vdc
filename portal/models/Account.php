<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%VDC_MEMBER_ACCOUNT}}".
 *
 * @property integer $acc_id
 * @property integer $acc_memberid
 * @property string $acc_created
 * @property string $acc_type
 * @property string $acc_desc
 * @property integer $acc_service
 * @property string $acc_service_amount
 * @property string $acc_ref
 * @property string $acc_amount
 * @property string $acc_balance_before
 * @property string $acc_balance_after
 * @property string $acc_remark
 * @property string $acc_refund
 */
class Account extends BaseModel
{
    public $from_date;
    public $to_date;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%VDC_MEMBER_ACCOUNT}}';
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
            [['acc_memberid', 'acc_service'], 'integer'],
            [['acc_created'], 'safe'],
            [['acc_service_amount', 'acc_amount', 'acc_balance_before', 'acc_balance_after'], 'number'],
            [['acc_type', 'acc_refund'], 'string', 'max' => 1],
            [['acc_desc', 'acc_remark'], 'string', 'max' => 500],
            [['acc_ref'], 'string', 'max' => 45]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'acc_id' => Yii::t('app', 'ID'),
            'acc_memberid' => Yii::t('app/account', 'Member ID'),
            'acc_created' => Yii::t('app', 'Created At'),
            'acc_type' => Yii::t('app/account', 'Type'),
            'acc_desc' => Yii::t('app/account', 'Description'),
            'acc_service' => Yii::t('app/account', 'Service'),
            'acc_service_amount' => Yii::t('app/account', 'Service Amount'),
            'acc_ref' => Yii::t('app/account', 'Reference'),
            'acc_amount' => Yii::t('app/account', 'Amount'),
            'acc_balance_before' => Yii::t('app/account', 'Balance Before'),
            'acc_balance_after' => Yii::t('app/account', 'Balance After'),
            'acc_remark' => Yii::t('app', 'More'),
            'acc_refund' => Yii::t('app/account', 'Refund'),
            'from_date' => Yii::t('app', 'from'),
            'to_date' => Yii::t('app', 'to'),
            'profit' => Yii::t('app/account', 'Profit'),
            'refillCount' => Yii::t('app', 'Count'),
            'refillSum' => Yii::t('app', 'Total'),
        ];
    }

    public function getProfit()
    {
        return $this->acc_service_amount - $this->acc_amount;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAccountType()
    {
        return $this->hasOne(AccountType::className(), ['acc_type_id' => 'acc_type']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMember()
    {
        return $this->hasOne(Member::className(), ['member_id' => 'acc_memberid']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getService()
    {
        return $this->hasOne(Service::className(), ['service_id' => 'acc_service']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrders()
    {
        return $this->hasMany(Order::className(), ['order_accid' => 'acc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDevice()
    {
        return $this->hasOne(Device::className(), ['dev_member' => 'acc_memberid']);
    }

}
