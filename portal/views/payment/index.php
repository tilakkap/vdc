<?php

use kartik\icons\Icon;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this kartik\grid\GridView */
/* @var $searchModel app\models\OrderSearch */
/* @var $model app\models\Payment */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app/payment', 'Payments');
?>
<div class="payment-index">

    <?= GridView::widget(ArrayHelper::merge(Yii::$app->params['kartik/grid/'], [
        'dataProvider'       => $dataProvider,
        'columns'            => [
            ['class' => 'kartik\grid\SerialColumn'],
            [
                'class'     => '\kartik\grid\DataColumn',
                'attribute' => 'kiosk_code',
                'label'     => $searchModel->getAttributeLabel('kiosk_code'),
            ],
            [
                'class'     => '\kartik\grid\DataColumn',
                'attribute' => 'payment_code',
                'label'     => $searchModel->getAttributeLabel('payment_code'),
            ],
            [
                'class'     => '\kartik\grid\DataColumn',
                'attribute' => 'payment_date',
                'label'     => $searchModel->getAttributeLabel('payment_date'),
            ],
            [
                'class'     => '\kartik\grid\DataColumn',
                'attribute' => 'description',
                'label'     => $searchModel->getAttributeLabel('description'),
                'value'     => function ($model) {
                    return Yii::t('app/payment', 'Monthly Dues, Kiosk Code:') . ' ' . $model['description'];
                },
            ],
            [
                'class'     => '\kartik\grid\DataColumn',
                'attribute' => 'payment_amount',
                'label'     => $searchModel->getAttributeLabel('payment_amount'),
                'format'    => ['decimal', 2],
                'hAlign'    => 'right',
            ],
            [
                'class'    => 'yii\grid\ActionColumn',
                'template' => '{pdf}',
                'buttons'  => [
                    'pdf' => function ($url, $model) {
                        return Html::a('<span class="fa fa-file-pdf-o"></span>', 'https://sc.vdc.co.th/PDF/index.php?r=printpdf/payment&id='.$model->id, [
                            'title' => Yii::t('app', 'Pdf'),
                            'target' => '_blank',
                        ]);
                    },
                ],
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
        'showPageSummary'    => false,
    ])); ?>
</div>
