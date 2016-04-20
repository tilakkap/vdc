<?php

use kartik\form\ActiveForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Device */

?>

<div class="device-form">

    <?php $form = ActiveForm::begin([
        'options' => [
            'id' => 'machine-comment'
        ]
    ]); ?>

    <?= $form->field($model, 'dev_remark')->textarea(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Update'), ['class' => 'btn btn-sm btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
