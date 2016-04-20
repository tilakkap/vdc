<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\MachineStatus */

$this->title = Yii::t('app', 'Create Machine Status');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Machine Statuses'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="machine-status-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
