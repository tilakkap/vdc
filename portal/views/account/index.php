<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\icons\Icon;

/* @var $this yii\web\View */
/* @var $searchModel app\models\AccountSearch */
/* @var $accountType app\models\AccountType */
/* @var $dataProvider yii\data\SqlDataProvider */

$this->title = ($searchModel->acc_type) ? Yii::t('app/account', 'History, transfer money, buy airtime') : Yii::t('app/account', 'Account Balances and Movements');
?>
<div class="account-index">

    <?php echo $this->render('_search', ['model' => $searchModel, 'action' => $action]); ?>


    <?= GridView::widget(ArrayHelper::merge(Yii::$app->params['kartik/grid/'], [
        'dataProvider' => $dataProvider,
        'columns'      => [
            ['class' => 'kartik\grid\SerialColumn'],
            [
                'label'     => $searchModel->getAttributeLabel('acc_created'),
                'attribute' => 'acc_created',
            ],
            [
                'label'     => $accountType->getAttributeLabel('acc_type_desc'),
                'attribute' => 'acc_type_desc',
                'visible'   => ($searchModel->acc_type) ? true :false,
            ],
            [
                'label'     => $searchModel->getAttributeLabel('acc_desc'),
                'attribute' => 'acc_desc',
            ],
            [
                'label'     => $searchModel->getAttributeLabel('acc_balance_before'),
                'attribute' => 'acc_balance_before',
            ],
            [
                'label'     => $searchModel->getAttributeLabel('acc_balance_after'),
                'attribute' => 'acc_balance_after',
            ],
            [
                'label'     => $searchModel->getAttributeLabel('acc_amount'),
                'attribute' => 'acc_amount',
            ],
            [
                'label'     => $searchModel->getAttributeLabel('acc_ref'),
                'attribute' => 'acc_ref',
            ],
            [
                'label'     => $searchModel->getAttributeLabel('acc_service_amount'),
                'attribute' => 'acc_service_amount',
                'visible'   => (!$searchModel->acc_type) ? true :false,
            ],
            [
                'label'     => $searchModel->getAttributeLabel('acc_remark'),
                'attribute' => 'acc_remark',
                'visible'   => ($searchModel->acc_type) ? true :false,
            ],

        ],
        'panel'        => [
            'heading' => Icon::show('leaf', ['class' => 'fa fa-money'], Icon::FA) . Html::encode($this->title),
        ],
        'exportConfig' => [
            GridView::PDF => [
                'config' => [
                    'methods' => [
                        'SetHeader' => [
                            [
                                'odd'  => ArrayHelper::merge(Yii::$app->params['pdf']['header'], [
                                    'C' => [
                                        'content' => $this->title,
                                    ],
                                ]),
                                'even' => ArrayHelper::merge(Yii::$app->params['pdf']['header'], [
                                    'C' => [
                                        'content' => $this->title,
                                    ],
                                ]),
                            ],
                        ],
                        'SetFooter' => [
                            [
                                'odd'  => Yii::$app->params['pdf']['footer'],
                                'even' => Yii::$app->params['pdf']['footer'],
                            ],
                        ],
                    ],
                ],
            ],
        ],
    ])); ?>

</div>
