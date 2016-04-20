<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\MemberSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="member-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'member_id') ?>

    <?= $form->field($model, 'member_username') ?>

    <?= $form->field($model, 'member_fname') ?>

    <?= $form->field($model, 'member_lname') ?>

    <?= $form->field($model, 'member_pid') ?>

    <?php // echo $form->field($model, 'member_address') ?>

    <?php // echo $form->field($model, 'member_city') ?>

    <?php // echo $form->field($model, 'member_province') ?>

    <?php // echo $form->field($model, 'member_zipcode') ?>

    <?php // echo $form->field($model, 'member_email') ?>

    <?php // echo $form->field($model, 'member_telno') ?>

    <?php // echo $form->field($model, 'member_smsno') ?>

    <?php // echo $form->field($model, 'member_created') ?>

    <?php // echo $form->field($model, 'member_balance') ?>

    <?php // echo $form->field($model, 'member_bankref') ?>

    <?php // echo $form->field($model, 'member_created_user') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
