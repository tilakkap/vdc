<?php
use yii\bootstrap\Dropdown;
use yii\helpers\Html;
use yii\bootstrap\Button;
use kartik\form\ActiveForm;
use app\components\LanguageSwitcher;

/* @var $this yii\web\View */
/* @var $form kartik\form\ActiveForm */
/* @var $model app\models\LoginForm */

$model->getErrors();

$this->title = Yii::t('app','Sign in to membership manager');
?>
<div class="col-md-4 col-md-offset-4 col-sm-12">
    <div class="panel panel-primary">
        <div class="panel-heading">
            <div class="panel-title">
                <div class="row">
                    <div class="col-xs-8">
                        <?=HTML::encode($this->title)?>
                    </div>
                    <div class="col-xs-4">
                        <div class="btn-group pull-right">
                            <button class="btn btn-default btn-xs dropdown-toggle" type="button" data-toggle="dropdown"><?= Yii::t('app', 'Forgot password!')?> <span class="caret"></span></button>
                            <?php
                            echo Dropdown::widget([
                                'items' => [
                                    ['label' => Yii::t('app', 'Request password via email' ), 'url' => ['site/request-password-reset']],
                                    ['label' => Yii::t('app', 'Request password via SMS' ), 'url' => ['site/request-password-reset-sms', 'group' => $group]],
                                ],
                            ]);
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="panel-body">
            <?php $form = ActiveForm::begin([
                'id' => 'login-form',
            ]);
            ?>

            <?= $form->field($model, 'username', [
                'addon' => ['prepend' => ['content' => '<i class="glyphicon glyphicon-user"></i>']]
            ]); ?>
            <?= $form->field($model, 'password', [
                'addon' => ['prepend' => ['content' => '<i class="glyphicon glyphicon-lock"></i>']]
            ])->passwordInput(); ?>

            <div class="row">
                <div class="col-xs-6">
                    <!-- Button -->
                    <?= Button::widget([
                        'label' => Yii::t('app', 'Login'),
                        'options' => ['class' => 'btn-sm btn-primary'],
                    ]); ?>
                </div>

            </div>

            <?php ActiveForm::end(); ?>

        </div>
    </div>
</div>
