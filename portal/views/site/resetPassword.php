<?php
use yii\helpers\Html;
use kartik\form\ActiveForm;
use app\components\LanguageSwitcher;
/* @var $this yii\web\View */
/* @var $form kartik\form\ActiveForm */
/* @var $model \app\models\ResetPasswordForm */
$this->title = Yii::t('app','Reset Password');
?>

<div class="col-md-4 col-md-offset-4 col-sm-12">
    <div class="panel panel-primary">
        <div class="panel-heading">
            <div class="panel-title">
                <?= Html::encode($this->title) ?>
            </div>
        </div>
        <div class="panel-body">
            <div class="site-reset-password">
                <p><?=Yii::t('app','Please choose your new password:')?></p>
                <?php $form = ActiveForm::begin(['id' => 'reset-password-form']); ?>
                <?= $form->field($model, 'password')->passwordInput() ?>
                <?= $form->field($model, 'password_repeat')->passwordInput() ?>
                <div class="row">
                    <div class="col-xs-12">
                        <!-- Button -->
                        <?= Html::submitButton(Yii::t('app','Send'), ['class' => 'btn btn-sm btn-primary']) ?>
                    </div>
                </div>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>

