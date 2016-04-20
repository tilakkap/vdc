<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%machine}}".
 *
 * @property integer $id
 * @property string $comment
 */
class Machine extends \yii\db\ActiveRecord
{

    const SCENARIO_COMMENT = 'comment';

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_COMMENT] = ['comment'];
        return $scenarios;
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%machine}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'required'],
            [['id'], 'integer'],
            [['comment'], 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'comment' => Yii::t('app', 'Comment'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDevice()
    {
        return $this->hasOne(Device::className(), ['dev_id' => 'id']);

    }
}
