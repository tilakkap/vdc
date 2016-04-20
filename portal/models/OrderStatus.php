<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%orderStatus}}".
 *
 * @property integer $id
 * @property string $status
 * @property string $language
 * @property string $text
 */
class OrderStatus extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%orderStatus}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['status', 'language', 'text'], 'required'],
            [['status'], 'string', 'max' => 1],
            [['language'], 'string', 'max' => 2],
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
            'status' => Yii::t('app', 'Status'),
            'language' => Yii::t('app', 'Language'),
            'text' => Yii::t('app', 'Text'),
        ];
    }
}
