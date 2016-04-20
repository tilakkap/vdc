<?php
/**
 * Created by PhpStorm.
 * User: Thomas
 * Date: 06.02.16
 * Time: 20:24
 */
use yii\helpers\Html;
/* @var $this yii\web\View */
/* @var $user app\models\User */
$resetLink = Yii::$app->urlManager->createAbsoluteUrl(['site/reset-password', 'token' => $user->password_reset_token]);
?>

    Hello <?= Html::encode($user->username) ?>,

    Follow the link below to reset your password:

<?= Html::a(Html::encode($resetLink), $resetLink) ?>