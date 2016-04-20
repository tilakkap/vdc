<?php

use kartik\icons\Icon;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this kartik\grid\GridView */
/* @var $searchModel app\models\OrderSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app/order', 'Profit Summary');
?>
<div class="order-summary">

    <?php
    echo $this->render('_search', ['model' => $searchModel, 'action' => $action]);
    ?>


    <?= GridView::widget(ArrayHelper::merge(Yii::$app->params['kartik/grid/'], [
        'dataProvider'       => $dataProvider,
        'columns'            => [
            ['class' => 'kartik\grid\SerialColumn'],
            [
                'class'       => '\kartik\grid\DataColumn',
                'label'     => Yii::t('app','Month'),
                'attribute' => 'monthYear',
                'group'=>true,
                'groupFooter'=>function ($model, $key, $index, $widget) { // Closure method
                    return [
                        'mergeColumns'=>[[1,2]], // columns to merge in summary
                        'content'=>[             // content to show in each summary cell
                                                 2=>Yii::t('app/order','Summary {monthYear}',['monthYear'=>$model['monthYear']]),
                                                 3=>GridView::F_SUM,

                        ],
                        'contentFormats'=>[      // content reformatting for each summary cell
                                                 3=>['format'=>'number', 'decimals'=>2],

                        ],
                        'contentOptions'=>[      // content html attributes for each summary cell
                                                 3=>['style'=>'text-align:right'],
                        ],
                        // html attributes for group summary row
                        'options'=>['class'=>'danger','style'=>'font-weight:bold;']
                    ];
                }
            ],
            [
                'label'     => Yii::t('app', 'Service'),
                'attribute' => 'service',
            ],
            [
                'label'     => Yii::t('app/order', 'Total Profit'),
                'attribute' => 'totalProfit',
                'pageSummary'    => true,
                'format'         => ['decimal', 2],
                'contentOptions' => function ($model, $index, $dataColumn) {
                    if ($model['totalProfit'] < 0) {
                        return ['class' => 'neg'];
                    }
                    return null;
                },
                'hAlign'=>'right',
            ],
        ],
        'panel'              => [
            'heading' => Icon::show('leaf', ['class' => 'fa fa-money'], Icon::FA) . Html::encode($this->title),
            'footer' => false,
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
