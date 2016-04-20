<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Device */
$this->title = Yii::t('app', 'Update {modelClass}: ', ['modelClass' => 'Device',]) . ' ' . $model->dev_id;
$form = '_form';

if($model->scenario == $model::SCENARIO_HOME){
    $form = '_modal';
    $titel = Yii::t('app','Comment');
}
?>
<div class="device-update">

    <?= $this->render($form, [
        'model' => $model,
    ]) ?>

</div>
