<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Device */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="device-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'dev_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'dev_serial_no')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'dev_status')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'dev_created')->textInput() ?>

    <?= $form->field($model, 'dev_member')->textInput() ?>

    <?= $form->field($model, 'dev_first_activate')->textInput() ?>

    <?= $form->field($model, 'dev_last_activate')->textInput() ?>

    <?= $form->field($model, 'dev_last_use')->textInput() ?>

    <?= $form->field($model, 'dev_act_code')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'dev_act_pass')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'dev_simbundle_no')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'dev_simbundle_serial')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'dev_simoperator')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'dev_simcurrent_no')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'dev_simcurrent_serial')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'dev_remark')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'dev_remark2')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'dev_created_user')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'dev_seller_code')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
