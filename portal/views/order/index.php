<?php

use kartik\icons\Icon;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this kartik\grid\GridView */
/* @var $searchModel app\models\OrderSearch */
/* @var $service app\models\Service */
/* @var $device app\models\Device */
/* @var $account app\models\Account */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app/order', 'Transaction');
?>
<div class="order-index">

    <?php
    echo $this->render('_search', ['model' => $searchModel, 'action'=> $action]);
    ?>
    <?= GridView::widget(ArrayHelper::merge(Yii::$app->params['kartik/grid/'], [
        'dataProvider'       => $dataProvider,
        'columns'            => [
            ['class' => 'kartik\grid\SerialColumn'],
            [
                'format'    => 'raw',
                'class'       => '\kartik\grid\DataColumn',
                'attribute'   => 'order_created',
                'label'=> $searchModel->getAttributeLabel('order_created'),
                'value'     => function ($model) {
                    return Html::a($model['order_created'], ['/order/view', 'id' => $model['order_id']], ['title' => Yii::t('app', 'Details'), 'class' => 'showModalButton']);
                },
            ],
            [
                'class'       => '\kartik\grid\DataColumn',
                'attribute'   => 'device.dev_name',
                'label'=> $device->getAttributeLabel('dev_name'),
            ],
            [
                'class'       => '\kartik\grid\DataColumn',
                'attribute'   => 'orderStatus.text',
                'label'=> $searchModel->getAttributeLabel('order_status'),
            ],
            [
                'class'       => '\kartik\grid\DataColumn',
                'attribute'   => 'service.service_desc',
                'label'=> $service->getAttributeLabel('service_desc'),
            ],
            [
                'class'       => '\kartik\grid\DataColumn',
                'attribute'   => 'order_mobileno',
                'label'=> $searchModel->getAttributeLabel('order_mobileno'),
            ],
            [
                'class'       => '\kartik\grid\DataColumn',
                'attribute'   => 'order_amount',
                'pageSummary' => true,
                'format'      => ['decimal', 2],
                'label'=> $searchModel->getAttributeLabel('order_amount'),
            ],
            [
                'class'       => '\kartik\grid\DataColumn',
                'attribute'   => 'order_charge',
                'pageSummary' => true,
                'format'      => ['decimal', 2],
                'label'=> $searchModel->getAttributeLabel('order_charge'),
            ],
            [
                'class'       => '\kartik\grid\DataColumn',
                'attribute'   => 'order_coin',
                'pageSummary' => true,
                'format'      => ['decimal', 2],
                'label'=> $searchModel->getAttributeLabel('order_coin'),
            ],
            [
                'class'       => '\kartik\grid\DataColumn',
                'attribute'   => 'order_bill',
                'pageSummary' => true,
                'format'      => ['decimal', 2],
                'label'=> $searchModel->getAttributeLabel('order_bill'),
            ],
            [
                'class'       => '\kartik\grid\DataColumn',
                'attribute'   => 'order_paid',
                'pageSummary' => true,
                'format'      => ['decimal', 2],
                'label'=> $searchModel->getAttributeLabel('order_paid'),
            ],
//            [
//                'class'       => '\kartik\grid\DataColumn',
//                'attribute'   => 'acc_service_amount',
//                'pageSummary' => true,
//                'format'      => ['decimal', 2],
//            ],
//            [
//                'class'       => '\kartik\grid\DataColumn',
//                'attribute'   => 'acc_amount',
//                'pageSummary' => true,
//                'format'      => ['decimal', 2],
//            ],
            [
                'class'       => '\kartik\grid\DataColumn',
                'attribute'   => 'order_disc_old',
                'format'      => ['decimal', 2],
                'label'=> $searchModel->getAttributeLabel('order_disc_old'),
            ],
            [
                'class'       => '\kartik\grid\DataColumn',
                'attribute'   => 'order_disc_new',
                'format'      => ['decimal', 2],
                'label'=> $searchModel->getAttributeLabel('order_disc_new'),
            ],
            [
                'class'          => '\kartik\grid\DataColumn',
                'attribute'      => 'profit',
                'pageSummary'    => true,
                'format'         => ['decimal', 2],
                'contentOptions' => function ($model, $index, $dataColumn) {
                    if ($model['profit'] < 0) {
                        return ['class' => 'neg'];
                    }
                    return null;
                },
                'label'=> Yii::t('app/account', 'Profit'),
            ],
        ],
        'panel'              => [
            'heading' => Icon::show('leaf', ['class' => 'fa fa-money'], Icon::FA) . Html::encode($this->title),
        ],
        'exportConfig'       => [
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
        'floatHeader'        => true,
        'floatHeaderOptions' => ['top' => 65],
        'showPageSummary'    => true,
    ])); ?>


</div>
