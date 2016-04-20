<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;
use kartik\builder\Form;

/* @var $this yii\web\View */
/* @var $model app\models\Member */
/* @var $form kartik\form\ActiveForm */
?>

<div class="member-form">
    <?php

    $form = ActiveForm::begin([
        'type'       => ActiveForm::TYPE_HORIZONTAL,
        'formConfig' => [
            'labelSpan' => 3,
        ],
    ]);
    $form->fieldConfig['autoPlaceholder'] = false;

    echo Form::widget([
        'model'             => $model,
        'form'              => $form,

        // set global attribute defaults
        'attributeDefaults' => [
            'type' => Form::INPUT_STATIC,
        ],

        'attributes' => $model->formAttribs,

    ]);
    ?>

    <div class="row">
        <div class="col-xs-12">
            <!-- Button -->
            <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Save'), ['class' => $model->isNewRecord ? 'btn-sm btn btn-success' : 'btn-sm btn btn-primary']) ?>
            <?= Html::a(Yii::t('app', 'Cancel'), Yii::$app->request->referrer, ['class' => 'btn-sm btn btn-default']) ?>
        </div>

    </div>

    <?php ActiveForm::end(); ?>
</div>
