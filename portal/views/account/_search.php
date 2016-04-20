<?php

use kartik\select2\Select2;
use yii\helpers\Html;
use kartik\form\ActiveForm;
use kartik\date\DatePicker;


/* @var $this yii\web\View */
/* @var $model app\models\AccountSearch */
/* @var $form kartik\form\ActiveForm */
?>

<div class="account-search">

    <?php $form = ActiveForm::begin([
        'action'     => [$action],
        'method'     => 'get',
        'type'       => ActiveForm::TYPE_INLINE,
        'formConfig' => [
            'showErrors' => true,
        ],
    ]); ?>


    <?= $form->field($model, 'from_date')->widget(DatePicker::classname(), [
        'options' => [
            'placeholder' => $model->getAttributeLabel('from_date'),
        ],
    ]); ?>

    <?= $form->field($model, 'to_date')->widget(DatePicker::classname(), [
        'options' => [
            'placeholder' => $model->getAttributeLabel('to_date'),
        ],

    ]);
    ?>


    <?= $form->field($model, 'member')->widget(Select2::classname(), [
        'data'          => \app\models\Member::getDropDownMember(['member_id' => \Yii::$app->getSession()->get("member_ids")]),
        'size'          => Select2::SMALL,
        'showToggleAll' => false,
        'options'       => [
            'placeholder' => Yii::t('app/member', 'Please Select Members'),
            'multiple'    => false,
        ],
        'pluginOptions' => [
            'allowClear'             => false,
            'closeOnSelect'          => true,
        ],
    ]);
    ?>

    <?= $form->field($model, 'acc_type')->hiddenInput() ?>
    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-sm btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Reset'), ['/account/reset'], ['class' => 'btn btn-sm btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
