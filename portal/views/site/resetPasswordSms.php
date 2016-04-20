<?php
use yii\helpers\Html;
use kartik\form\ActiveForm;
use app\components\LanguageSwitcher;
/* @var $this yii\web\View */
/* @var $form kartik\form\ActiveForm */
/* @var $model \app\models\PasswordResetRequestForm */
$this->title = Yii::t('app','Enter SMS Code');
?>
<div class="col-md-4 col-md-offset-4 col-sm-12">
    <div class="panel panel-primary">
        <div class="panel-heading">
            <div class="panel-title">
                <?= Html::encode($this->title) ?>
            </div>
        </div>

        <div class="panel-body">
            <div class="site-request-password-reset">
                <p><?=Yii::t('app','Please enter the Code that you recieved per SMS')?></p>
                <?php $form = ActiveForm::begin(['id' => 'reset-password-sms-form']); ?>
                <?= $form->field($model, 'code')?>
                <div class="row">
                    <div class="col-xs-6">
                        <!-- Button -->
                        <?= Html::submitButton(Yii::t('app','Send'), ['class' => 'btn btn-default']) ?>
                    </div>
                    <div class="col-xs-6">
                        <div class="pull-right">
                           
                        </div>
                    </div>
                </div>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>
