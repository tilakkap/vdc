<?php

use app\models\Device;
use app\models\OrderStatus;
use kartik\date\DatePicker;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use kartik\form\ActiveForm;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model app\models\OrderSearch */
/* @var $form kartik\form\ActiveForm */
?>

<div class="order-search">

    <?php $form = ActiveForm::begin([
        'action'     => [$action],
        'method'     => 'get',
        'type'       => ActiveForm::TYPE_INLINE,
        'formConfig' => [
            'showErrors' => true,
        ],
    ]); ?>


    <?= $form->field($model, 'from_date')->widget(DatePicker::classname(), [
        'options'       => [
            // you can hide the input by setting the following
            'placeholder' => $model->getAttributeLabel('from_date'),
        ],
    ]); ?>

    <?= $form->field($model, 'to_date')->widget(DatePicker::classname(), [
        'options'       => [
            // you can hide the input by setting the following
            'placeholder' => $model->getAttributeLabel('to_date'),
        ],

    ]); ?>


    <?= $form->field($model, 'dev_name')->widget(Select2::classname(), [
        'data' => Device::getDropDownDevice(['dev_id' => \Yii::$app->getSession()->get("device_ids")]),
        'size' => Select2::SMALL,
        'showToggleAll' => false,
        'pluginEvents' => [
            "change" => "function() {
            var ele = $(this);
            if(ele.val() && ele.val().length==5)
            {ele.select2('close');}
            }",

        ],
        'options' => [
            'placeholder' => Yii::t('app/device', 'Please Select Devices'),
            'multiple' => true
        ],
        'pluginOptions' => [
            'allowClear' => true,
            'closeOnSelect' => false,
            'maximumSelectionLength' => 5,
        ],
    ]);
    ?>


    <?= $form->field($model, 'order_status')->widget(Select2::classname(), [
        'data' => ArrayHelper::map(OrderStatus::findAll(['language'=>yii::$app->language]), 'status', 'text'),
        'size' => Select2::SMALL,
        'showToggleAll' => false,
        'options' => [
            'placeholder' => Yii::t('app/order', 'Please Select Status'),
            //'multiple' => true
        ]
    ]);
    ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-sm btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Reset'), ['/order/reset'], ['class'=>'btn btn-sm btn-default']) ?>
    </div>
    <?php ActiveForm::end(); ?>

</div>