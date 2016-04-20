<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Machine */
$this->title = Yii::t('app', 'Update {modelClass}: ', ['modelClass' => 'Device',]) . ' ' . $model->id;
$form = '_form';

if($model->scenario == $model::SCENARIO_COMMENT){
    $form = '_modal';
    $titel = Yii::t('app','Comment');
}
?>
<div class="device-update">

    <?= $this->render($form, [
        'model' => $model,
    ]) ?>

</div>
