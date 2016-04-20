<?php

/* @var $this \yii\web\View */
/* @var $content string */
/* @var $member \app\models\Member */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\helpers\Url;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use app\components\LanguageSwitcher;
use app\widgets\Alert;
use kartik\icons\Icon;

// Initialize a specific framework - e.g. Web Hosting Hub Glyphs
Icon::map($this, Icon::FA);

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php

    NavBar::begin([
        'brandLabel' => Html::img('@web/img/logo.png'),
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-fixed-top navbar-default',
        ],
        'innerContainerOptions' => ['class'=>'container-fluid'],
    ]);

    $item = [];

    if(!Yii::$app->user->isGuest) {
        array_push($item, [
            'label' => Yii::t('app', 'Report'), 'url' => ['/site/index'],
            'items' => [
                ['label' => Yii::t('app/order', 'Transaction'), 'url' => ['/order/index']],
                ['label' => Yii::t('app/order', 'Profit Summary'), 'url' => ['/order/summary']],
                ['label' => Yii::t('app/account', 'Account Balances and Movements'), 'url' => ['/account/index']],
                ['label' => Yii::t('app/account', 'History, transfer money, buy airtime'), 'url' => ['/account/transfer']],
                ['label' => Yii::t('app/account', 'Statistics Refill'), 'url' => ['/account/refill']],
                ['label' => Yii::t('app/payment', 'Payments'), 'url' => ['/payment/index']],
            ],
        ]);
        array_push($item, [
            'label' => Yii::t('app', 'Settings'), 'url' => ['/site/about'],
            'items' => [
                ['label' => Yii::t('app', 'Equipment'), 'url' => ['/device/']],
                ['label' => Yii::t('app', 'Profile'), 'url' => ['/member/index', 'id'=>\Yii::$app->getSession()->get("profile_id")]],
                ['label' => Yii::t('app', 'Change Password'), 'url' => ['/site/change-password']],
            ],
        ]);
        array_push($item, [
            'label'       => Yii::t('app', 'Sign out ({username})', ['username' => Yii::$app->user->identity->username]),
            'url'         => ['/site/logout'],
            'linkOptions' => ['data-method' => 'post']
        ]);
    }

    array_push($item, LanguageSwitcher::asArray());

    echo Nav::widget([
        'encodeLabels' => false,
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => $item,
    ]);
    NavBar::end();

    ?>


    <div class="container-fluid">
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</div>
<?php
yii\bootstrap\Modal::begin([
    'header' => '<div id="modalHeaderTitel"></div>',
    'headerOptions' => ['id' => 'modalHeader'],
    'id' => 'modal',
    'size' => 'modal-md',
    //keeps from closing modal with esc key or by clicking out of the modal.
    // user must click cancel or X to close
    'clientOptions' => ['backdrop' => 'static', 'keyboard' => FALSE]
]);
echo "<div id='modalContent'></div>";
yii\bootstrap\Modal::end();
?>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
