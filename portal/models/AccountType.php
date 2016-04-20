<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%VDC_ACCOUNT_TYPE}}".
 *
 * @property string $acc_type_id
 * @property string $acc_type_desc
 */
class AccountType extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%VDC_ACCOUNT_TYPE}}';
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
            [['acc_type_id'], 'required'],
            [['acc_type_id'], 'string', 'max' => 1],
            [['acc_type_desc'], 'string', 'max' => 45]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'acc_type_id' => Yii::t('app', 'ID'),
            'acc_type_desc' => Yii::t('app', 'Type'),
        ];

    }
}
