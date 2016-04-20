<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Order */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="order-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'order_id')->textInput() ?>

    <?= $form->field($model, 'order_created')->textInput() ?>

    <?= $form->field($model, 'order_devid')->textInput() ?>

    <?= $form->field($model, 'order_status')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'order_service')->textInput() ?>

    <?= $form->field($model, 'order_mobileno')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'order_amount')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'order_charge')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'order_coin')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'order_bill')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'order_paid')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'order_disc_old')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'order_disc_new')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'order_ref1')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'order_ref2')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'order_ref3')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'order_remark')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'order_accid')->textInput() ?>

    <?= $form->field($model, 'order_parentid')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
