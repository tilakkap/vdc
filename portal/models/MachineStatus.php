<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%machineStatus}}".
 *
 * @property integer $id
 * @property string $status
 * @property string $language
 * @property string $text
 */
class MachineStatus extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%machineStatus}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['status', 'language', 'text'], 'required'],
            [['status'], 'string', 'max' => 1],
            [['language'], 'string', 'max' => 5],
            [['text'], 'string', 'max' => 50]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'status' => Yii::t('app/device', 'Status'),
            'language' => Yii::t('app', 'Language'),
            'text' => Yii::t('app', 'Text'),
        ];
    }
}
