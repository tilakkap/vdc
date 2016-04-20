<?php
use yii\helpers\Html;
use kartik\form\ActiveForm;
use app\components\LanguageSwitcher;
/* @var $this yii\web\View */
/* @var $form kartik\form\ActiveForm */
/* @var $model \app\models\PasswordResetRequestForm */
$this->title = Yii::t('app','Request password via email');
?>
<div class="col-md-4 col-md-offset-4 col-sm-12">
    <div class="panel  panel-primary">
        <div class="panel-heading">
            <div class="panel-title">
                <?= Html::encode($this->title) ?>
            </div>
        </div>

        <div class="panel-body">
            <div class="site-request-password-reset">
                <p><?=Yii::t('app','Please fill out your email. A link to reset password will be sent there.')?></p>
                <?php $form = ActiveForm::begin(['id' => 'request-password-reset-form']); ?>
                <?= $form->field($model, 'email') ?>
                <div class="row">
                    <div class="col-xs-6">
                        <!-- Button -->
                        <?= Html::submitButton(Yii::t('app','Send'), ['class' => 'btn btn-sm btn-primary']) ?>
                        <?= \yii\helpers\Html::a(Yii::t('app', 'Cancel'), Yii::$app->request->referrer, ['class' => 'btn btn-sm btn-default']); ?>
                    </div>
                </div>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>
