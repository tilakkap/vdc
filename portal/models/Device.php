<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%VDC_DEVICE_PROFILE}}".
 *
 * @property integer $dev_id
 * @property string $dev_name
 * @property string $dev_serial_no
 * @property string $dev_status
 * @property string $dev_created
 * @property integer $dev_member
 * @property string $dev_first_activate
 * @property string $dev_last_activate
 * @property string $dev_last_use
 * @property string $dev_act_code
 * @property string $dev_act_pass
 * @property string $dev_simbundle_no
 * @property string $dev_simbundle_serial
 * @property string $dev_simoperator
 * @property string $dev_simcurrent_no
 * @property string $dev_simcurrent_serial
 * @property string $dev_remark
 * @property string $dev_remark2
 * @property string $dev_created_user
 * @property string $dev_seller_code
 */
class Device extends \yii\db\ActiveRecord
{

    const SCENARIO_HOME = 'home';
    const SCENARIO_ADMIN = 'admin';

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_HOME] = ['dev_remark'];
        return $scenarios;
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%VDC_DEVICE_PROFILE}}';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db1');
    }

    /* Getter for device version */
    public function getVersion() {
        return substr($this->dev_serial_no,0,2);
    }


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['dev_created', 'dev_first_activate', 'dev_last_activate', 'dev_last_use'], 'safe'],
            [['dev_member'], 'integer'],
            [['dev_name'], 'string', 'max' => 15],
            [['dev_serial_no'], 'string', 'max' => 50],
            [['dev_status', 'dev_simoperator'], 'string', 'max' => 1],
            [['dev_act_code', 'dev_act_pass', 'dev_simbundle_no', 'dev_simbundle_serial', 'dev_simcurrent_no', 'dev_simcurrent_serial', 'dev_created_user', 'dev_seller_code'], 'string', 'max' => 45],
            [['dev_remark', 'dev_remark2'], 'string', 'max' => 1000],
            [['dev_serial_no'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'dev_id' => Yii::t('app', 'ID'),
            'dev_name' => Yii::t('app/device', 'Device Number'),
            'dev_serial_no' => Yii::t('app/device', 'Serial No.'),
            'dev_status' => Yii::t('app/device', 'Status'),
            'dev_created' => Yii::t('app', 'Created At'),
            'dev_member' => Yii::t('app', 'Member'),
            'dev_first_activate' => Yii::t('app', 'First Activate'),
            'dev_last_activate' => Yii::t('app', 'Last Activate'),
            'dev_last_use' => Yii::t('app/device', 'Last Use'),
            'dev_act_code' => Yii::t('app', 'Act Code'),
            'dev_act_pass' => Yii::t('app', 'Act Pass'),
            'dev_simbundle_no' => Yii::t('app', 'Simbundle No'),
            'dev_simbundle_serial' => Yii::t('app/device', 'Simbundle Serial'),
            'dev_simoperator' => Yii::t('app', 'Simoperator'),
            'dev_simcurrent_no' => Yii::t('app/device', 'Current SIM No.'),
            'dev_simcurrent_serial' => Yii::t('app', 'Simcurrent Serial'),
            'dev_remark' => Yii::t('app', 'Remark'),
            'dev_remark2' => Yii::t('app', 'Remark2'),
            'dev_created_user' => Yii::t('app', 'Created By'),
            'dev_seller_code' => Yii::t('app', 'Seller Code'),
            'version' => Yii::t('app/device', 'Version')
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMember()
    {
        return $this->hasOne(Member::className(), ['member_id' => 'dev_member']);

    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMachine()
    {
        return $this->hasOne(Machine::className(), ['id' => 'dev_id']);

    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMachineStatus()
    {
        return $this->hasOne(MachineStatus::className(), ['status' => 'dev_status'])->where(['language' => Yii::$app->language]);
    }

    // we need a getter for select dropdown
    public static function getDropDownDevice($condition = [])
    {
        return \yii\helpers\ArrayHelper::map(static::find()->select(['dev_id', 'dev_name'])->asArray()->filterWhere($condition)->all(), 'dev_id', 'dev_name');
    }


}
