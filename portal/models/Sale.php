<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "{{%sale}}".
 *
 * @property integer $id
 * @property string $sale_username
 * @property string $phone
 * @property string $firstname
 * @property string $lastname
 */
class Sale extends \yii\db\ActiveRecord
{
    // declare deviceIds property
    public $deviceIds = [];
    // declare memberIds property
    public $memberIds = [];

    private $deviceModels = null;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%sale}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'sale_username', 'phone', 'firstname', 'lastname'], 'required'],
            [['id'], 'integer'],
            [['sale_username', 'firstname', 'lastname'], 'string', 'max' => 50],
            [['phone'], 'string', 'max' => 25]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'sale_username' => Yii::t('app', 'Sale Username'),
            'phone' => Yii::t('app', 'Phone'),
            'firstname' => Yii::t('app', 'Firstname'),
            'lastname' => Yii::t('app', 'Lastname'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['username' => 'sale_username']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSaleDevice()
    {
        return $this->hasMany(SaleDevice::className(), ['sale_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDevice()
    {
        return $this->hasMany(Device::className(), ['dev_id' => 'device_id'])
            ->via('saleDevice');
    }

    // We will need a getter for the current set of Devices of a Sale
    public function getDeviceIds()
    {
        $this->getDeviceModels();
        $this->deviceIds = \yii\helpers\ArrayHelper::getColumn(
            $this->deviceModels,
            'dev_id'
        );
        return $this->deviceIds;
    }

    // We will need a getter for the current set of Members of a Sale
    public function getMemberIds()
    {
        $this->getDeviceModels();
        $this->memberIds = \yii\helpers\ArrayHelper::getColumn(
            $this->deviceModels,
            'dev_member'
        );
        return $this->memberIds;
    }

    private function getDeviceModels(){
        if($this->deviceModels === null) {
            $this->deviceModels = $this->getDevice()->select(['dev_member', 'dev_id'])->asArray()->all();
        }
    }
}
