<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%t_payment}}".
 *
 * @property integer $id
 * @property string $payment_code
 * @property string $payment_desc
 * @property integer $kiosk_id
 * @property string $kiosk_code
 * @property string $kiosk_activate_code
 * @property string $payment_amount
 * @property string $tax_amount
 * @property string $interest_amount
 * @property string $principle_amount
 * @property string $payment_date
 * @property string $payment_time
 * @property integer $payment_status
 * @property string $batch_code
 * @property string $create_byuser
 * @property string $create_datetime
 * @property integer $payment_type
 * @property string $payment_ref1
 * @property string $payment_ref2
 * @property string $receipt_no
 * @property integer $invoice_id
 * @property string $invoice_code
 * @property integer $customer_id
 * @property string $customer_code
 * @property string $customer_firstname
 * @property string $customer_lastname
 * @property string $payment_cancel_byuser
 * @property string $payment_cancel_datetime
 * @property string $payment_remark
 * @property string $interest_i0
 * @property string $interest_i1
 * @property string $interest_i2
 * @property string $floatrate_r
 * @property integer $totalday_t0
 * @property integer $totalday_t1
 * @property integer $totalday_t2
 * @property string $vat_v
 * @property string $principle_p
 * @property string $fee
 */
class Payment extends BaseModel
{
    public $description;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%t_payment}}';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db2');
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['kiosk_id', 'payment_status', 'payment_type', 'invoice_id', 'customer_id', 'totalday_t0', 'totalday_t1', 'totalday_t2'], 'integer'],
            [['payment_amount', 'tax_amount', 'interest_amount', 'principle_amount', 'interest_i0', 'interest_i1', 'interest_i2', 'floatrate_r', 'vat_v', 'principle_p', 'fee'], 'number'],
            [['payment_date', 'payment_time', 'create_datetime', 'payment_cancel_datetime'], 'safe'],
            [['payment_code', 'kiosk_code', 'kiosk_activate_code', 'create_byuser', 'payment_ref1', 'payment_ref2', 'receipt_no', 'invoice_code', 'customer_code', 'customer_firstname', 'customer_lastname', 'payment_cancel_byuser'], 'string', 'max' => 50],
            [['payment_desc', 'payment_remark'], 'string', 'max' => 150],
            [['batch_code'], 'string', 'max' => 20]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'payment_code' => Yii::t('app/payment', 'Payment Code'),
            'payment_desc' => Yii::t('app/payment', 'Payment Desc'),
            'kiosk_id' => Yii::t('app/payment', 'Kiosk ID'),
            'kiosk_code' => Yii::t('app/payment', 'Kiosk Code'),
            'kiosk_activate_code' => Yii::t('app/payment', 'Kiosk Activate Code'),
            'payment_amount' => Yii::t('app/payment', 'Payment Amount'),
            'tax_amount' => Yii::t('app/payment', 'Tax Amount'),
            'interest_amount' => Yii::t('app/payment', 'Interest Amount'),
            'principle_amount' => Yii::t('app/payment', 'Principle Amount'),
            'payment_date' => Yii::t('app/payment', 'Payment Date'),
            'payment_time' => Yii::t('app/payment', 'Payment Time'),
            'payment_status' => Yii::t('app/payment', 'Payment Status'),
            'batch_code' => Yii::t('app/payment', 'Batch Code'),
            'create_byuser' => Yii::t('app/payment', 'Create Byuser'),
            'create_datetime' => Yii::t('app/payment', 'Create Datetime'),
            'payment_type' => Yii::t('app/payment', 'Payment Type'),
            'payment_ref1' => Yii::t('app/payment', 'Payment Ref1'),
            'payment_ref2' => Yii::t('app/payment', 'Payment Ref2'),
            'receipt_no' => Yii::t('app/payment', 'Receipt No'),
            'invoice_id' => Yii::t('app/payment', 'Invoice ID'),
            'invoice_code' => Yii::t('app/payment', 'Invoice Code'),
            'customer_id' => Yii::t('app/payment', 'Customer ID'),
            'customer_code' => Yii::t('app/payment', 'Customer Code'),
            'customer_firstname' => Yii::t('app/payment', 'Customer Firstname'),
            'customer_lastname' => Yii::t('app/payment', 'Customer Lastname'),
            'payment_cancel_byuser' => Yii::t('app/payment', 'Payment Cancel Byuser'),
            'payment_cancel_datetime' => Yii::t('app/payment', 'Payment Cancel Datetime'),
            'payment_remark' => Yii::t('app/payment', 'Payment Remark'),
            'interest_i0' => Yii::t('app/payment', 'Interest I0'),
            'interest_i1' => Yii::t('app/payment', 'Interest I1'),
            'interest_i2' => Yii::t('app/payment', 'Interest I2'),
            'floatrate_r' => Yii::t('app/payment', 'Floatrate R'),
            'totalday_t0' => Yii::t('app/payment', 'Totalday T0'),
            'totalday_t1' => Yii::t('app/payment', 'Totalday T1'),
            'totalday_t2' => Yii::t('app/payment', 'Totalday T2'),
            'vat_v' => Yii::t('app/payment', 'Vat V'),
            'principle_p' => Yii::t('app/payment', 'Principle P'),
            'fee' => Yii::t('app', 'Fee/payment'),
            'description' => Yii::t('app', 'Description'),
        ];
    }
}
