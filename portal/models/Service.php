<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%VDC_SERVICE}}".
 *
 * @property integer $service_id
 * @property string $service_code
 * @property string $service_desc
 */
class Service extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%VDC_SERVICE}}';
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
            [['service_id'], 'required'],
            [['service_id'], 'integer'],
            [['service_code'], 'string', 'max' => 30],
            [['service_desc'], 'string', 'max' => 45]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'service_id' => Yii::t('app', 'Service ID'),
            'service_code' => Yii::t('app', 'Service Code'),
            'service_desc' => Yii::t('app', 'Service'),
        ];
    }


}
