<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%saleDevice}}".
 *
 * @property integer $sales_id
 * @property integer $device_id
 */
class SaleDevice extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%saleDevice}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['sale_id', 'device_id'], 'required'],
            [['sale_id', 'device_id'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'sale_id' => Yii::t('app', 'Sales ID'),
            'device_id' => Yii::t('app', 'Device ID'),
        ];
    }

    public function getSale() {
        // one-to-one
        return $this->hasOne(Sale::className(), ['id' => 'sale_id']);
    }


    public function getDevice() {
        // one-to-one
        return $this->hasMany(Device::className(), ['dev_id' => 'device_id']);
    }


}
