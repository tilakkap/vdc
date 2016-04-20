<?php
use yii\helpers\Html;
use kartik\form\ActiveForm;
use app\components\LanguageSwitcher;

/* @var $this yii\web\View */
/* @var $form kartik\form\ActiveForm */
/* @var $model \app\models\ChangePasswordForm */
$this->title = Yii::t('app', Yii::t('app', 'Change Password'));
?>

<div class="col-md-4 col-md-offset-4 col-sm-12">
    <div class="panel panel-primary">
        <div class="panel-heading">
            <div class="panel-title">
                <?= Html::encode($this->title) ?>
            </div>
        </div>
        <div class="panel-body">
            <div>
                <p><?= Yii::t('app', 'Please choose your new password:') ?></p>
                <?php $form = ActiveForm::begin([
                    'id' => 'change-password-form',
                ]);; ?>
                <?= $form->field($model, 'old_password', ['enableAjaxValidation' => true])->passwordInput() ?>
                <?= $form->field($model, 'new_password')->passwordInput() ?>
                <?= $form->field($model, 'new_password_repeat')->passwordInput() ?>
                <div class="row">
                    <div class="col-xs-12">
                        <!-- Button -->
                        <?= Html::submitButton(Yii::t('app', 'Change'), ['class' => 'btn btn-sm btn-primary']) ?>
                        <?= \yii\helpers\Html::a(Yii::t('app', 'Cancel'), Yii::$app->request->referrer, ['class' => 'btn btn-sm btn-default']); ?>
                    </div>
                </div>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>

