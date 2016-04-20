<?php
/**
 * Created by PhpStorm.
 * User: Thomas
 * Date: 06.02.16
 * Time: 20:10
 */
namespace app\models;

use Yii;
use yii\base\Model;

/**
 * Password reset form
 */
class ResetPasswordSmsForm extends Model
{
    public $code;

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'Code' => Yii::t('app', 'Code'),
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['code'], 'required'],
        ];
    }
}
