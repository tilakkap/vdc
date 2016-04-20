<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Order */

$this->title = $model->order_id;
?>
<div class="order-view">
    <?= DetailView::widget([
        'options'    => [
            'class' => 'table table-striped table-bordered table-condensed detail-view',
        ],
        'model'      => $model,
        'attributes' => [
            'order_id',
            'order_created',
            'device.dev_name',
            'order_status',
            'service.service_desc',
            'order_mobileno',
            'order_amount',
            'order_charge',
            'order_coin',
            'order_bill',
            'order_paid',
            'order_disc_old',
            'order_disc_new',
            'order_ref1',
            'order_ref2',
            'order_ref3',
            'order_remark',
            'order_accid',
            'order_parentid',
        ],
    ]) ?>

</div>
