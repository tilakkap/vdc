<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\DeviceSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="device-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'dev_id') ?>

    <?= $form->field($model, 'dev_name') ?>

    <?= $form->field($model, 'dev_serial_no') ?>

    <?= $form->field($model, 'dev_status') ?>

    <?= $form->field($model, 'dev_created') ?>

    <?php // echo $form->field($model, 'dev_member') ?>

    <?php // echo $form->field($model, 'dev_first_activate') ?>

    <?php // echo $form->field($model, 'dev_last_activate') ?>

    <?php // echo $form->field($model, 'dev_last_use') ?>

    <?php // echo $form->field($model, 'dev_act_code') ?>

    <?php // echo $form->field($model, 'dev_act_pass') ?>

    <?php // echo $form->field($model, 'dev_simbundle_no') ?>

    <?php // echo $form->field($model, 'dev_simbundle_serial') ?>

    <?php // echo $form->field($model, 'dev_simoperator') ?>

    <?php // echo $form->field($model, 'dev_simcurrent_no') ?>

    <?php // echo $form->field($model, 'dev_simcurrent_serial') ?>

    <?php // echo $form->field($model, 'dev_remark') ?>

    <?php // echo $form->field($model, 'dev_remark2') ?>

    <?php // echo $form->field($model, 'dev_created_user') ?>

    <?php // echo $form->field($model, 'dev_seller_code') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
