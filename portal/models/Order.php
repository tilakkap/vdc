<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%VDC_ORDER_COMPLETE}}".
 *
 * @property integer $order_id
 * @property string $order_created
 * @property integer $order_devid
 * @property string $order_status
 * @property integer $order_service
 * @property string $order_mobileno
 * @property string $order_amount
 * @property string $order_charge
 * @property string $order_coin
 * @property string $order_bill
 * @property string $order_paid
 * @property string $order_disc_old
 * @property string $order_disc_new
 * @property string $order_ref1
 * @property string $order_ref2
 * @property string $order_ref3
 * @property string $order_remark
 * @property integer $order_accid
 * @property integer $order_parentid
 */
class Order extends BaseModel
{
    public $monthYear;
    public $TotalProfit;
    public $PrepaidAmount;
    public $PrepaidCount;
    public $acc_service_amount;
    public $MonthAmount;
    public $OtherAmount;
    public $profit;
    public $devices;


    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%VDC_ORDER_COMPLETE}}';
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
            [['order_id'], 'required'],
            [['order_id', 'order_devid', 'order_service', 'order_accid', 'order_parentid'], 'integer'],
            [['order_created'], 'safe'],
            [['order_amount', 'order_charge', 'order_coin', 'order_bill', 'order_paid', 'order_disc_old', 'order_disc_new'], 'number'],
            [['order_status'], 'string', 'max' => 1],
            [['order_mobileno', 'order_ref2', 'order_ref3'], 'string', 'max' => 45],
            [['order_ref1'], 'string', 'max' => 100],
            [['order_remark'], 'string', 'max' => 80]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'order_id' => Yii::t('app', 'ID'),
            'order_created' => Yii::t('app', 'Created At'),
            'order_devid' => Yii::t('app', 'Device ID'),
            'order_status' => Yii::t('app/order', 'Status'),
            'order_service' => Yii::t('app', 'Service ID'),
            'order_mobileno' => Yii::t('app/order', 'Mobile No.'),
            'order_amount' => Yii::t('app/order', 'Amount'),
            'order_charge' => Yii::t('app/order', 'Charge'),
            'order_coin' => Yii::t('app/order', 'Coin'),
            'order_bill' => Yii::t('app/order', 'Bill'),
            'order_paid' => Yii::t('app/order', 'Total Paid'),
            'order_disc_old' => Yii::t('app/order', 'Previous Discount'),
            'order_disc_new' => Yii::t('app/order', 'Next Discount'),
            'order_ref1' => Yii::t('app', 'Order Ref1'),
            'order_ref2' => Yii::t('app', 'Order Ref2'),
            'order_ref3' => Yii::t('app', 'Order Ref3'),
            'order_remark' => Yii::t('app', 'Order Remark'),
            'order_accid' => Yii::t('app', 'Order Accid'),
            'order_parentid' => Yii::t('app', 'Order Parentid'),
            'from_date' => Yii::t('app', 'from'),
            'to_date' => Yii::t('app', 'to'),
            'dev_name' => Yii::t('app/order', 'Device'),

        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDevice()
    {
        return $this->hasOne(Device::className(), ['dev_id' => 'order_devid']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMachine()
    {
        return $this->hasOne(Machine::className(), ['id' => 'order_devid']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAccount()
    {
        return $this->hasOne(Account::className(), ['acc_id' => 'order_accid']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getService()
    {
        return $this->hasOne(Service::className(), ['service_id' => 'order_service']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrderStatus()
    {
        return $this->hasOne(OrderStatus::className(), ['status' => 'order_status'])->where(['language' => Yii::$app->language]);
    }
}
