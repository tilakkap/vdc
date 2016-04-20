<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Device */

$this->title = $model->dev_id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Devices'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="device-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->dev_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->dev_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'dev_id',
            'dev_name',
            'dev_serial_no',
            'dev_status',
            'dev_created',
            'dev_member',
            'dev_first_activate',
            'dev_last_activate',
            'dev_last_use',
            'dev_act_code',
            'dev_act_pass',
            'dev_simbundle_no',
            'dev_simbundle_serial',
            'dev_simoperator',
            'dev_simcurrent_no',
            'dev_simcurrent_serial',
            'dev_remark',
            'dev_remark2',
            'dev_created_user',
            'dev_seller_code',
        ],
    ]) ?>

</div>
