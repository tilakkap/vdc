<?php

/* @var $this yii\web\View */
/* @var $searchModel app\models\SummaryHome */
/* @var $account app\models\Account */
/* @var $device app\models\Device */
/* @var $dataProvider yii\data\SqlDataProvider */
/* @var $prepaidList yii\data\SqlDataProvider */
/* @var $statusList yii\data\SqlDataProvider */

use app\components\DateHelper;
use kartik\date\DatePicker;
use kartik\grid\GridView;
use kartik\icons\Icon;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = Yii::$app->formatter->asDate($from_date, 'MMMM U');

$date= DatePicker::widget([
    'name'          => 'dp_6',
    'type'          => DatePicker::TYPE_BUTTON,
    'value'         => $from_date,
    'buttonOptions' =>[
        'class'=>'btn btn-link',
        'label'=> $this->title .' <span class="glyphicon glyphicon-triangle-bottom" aria-hidden="true"></span>',
    ],
    'pluginOptions' => [
        'format' => 'yyyy-mm-dd',
        'autoclose'   => true,
        'minViewMode' => 1,
        'endDate' => 'new Date();',
        'startDate' => '-2y',

    ],
    'pluginEvents' => [
        "changeDate" => "function(e) {  
            //alert(e);
            var d = e.date;
            var datestring = d.getFullYear() + \"-\" + (\"0\"+(d.getMonth()+1)).slice(-2) + \"-\" + (\"0\" + d.getDate()).slice(-2) ;
            
            document.location.href = '".Url::to(['/site/index'])."?from_date=' + datestring
        }",

    ]
]);
?>
<div class="site-index container-fluid">
    <div class="col-md-9">
        <?= GridView::widget(ArrayHelper::merge(Yii::$app->params['kartik/grid/'], [
            'dataProvider'       => $dataProvider,
            'columns'            => [
                ['class' => 'kartik\grid\SerialColumn'],
                [
                    'class'     => '\kartik\grid\DataColumn',
                    'format'    => 'raw',
                    'attribute' => 'device.dev_name',
                    'label'     => $device->getAttributeLabel('dev_name'),
                    'value'     => function ($model) use ($searchModel) {
                        return Html::a($model->device->dev_name, [
                            '/order/index',
                            'OrderSearch[dev_name][]' => $model->device->dev_id,
                            'OrderSearch[from_date]'  => $searchModel->from_date,
                            'OrderSearch[to_date]'    => $searchModel->to_date,
                        ],[
                            'data-pjax'=> 0
                        ]);
                    },

                ],
                [
                    'class'       => '\kartik\grid\DataColumn',
                    'attribute'   => 'PrepaidAmount',
                    'format'      => ['decimal', 2],
                    'label'       => $searchModel->getAttributeLabel('PrepaidAmount'),
                    'hAlign'      => 'right',
                    'pageSummary' => true,
                ],
                [
                    'class'       => '\kartik\grid\DataColumn',
                    'attribute'   => 'MonthAmount',
                    'format'      => ['decimal', 2],
                    'label'       => $searchModel->getAttributeLabel('MonthAmount'),
                    'hAlign'      => 'right',
                    'pageSummary' => true,
                ],
                [
                    'class'       => '\kartik\grid\DataColumn',
                    'attribute'   => 'OtherAmount',
                    'format'      => ['decimal', 2],
                    'label'       => $searchModel->getAttributeLabel('OtherAmount'),
                    'hAlign'      => 'right',
                    'pageSummary' => true,
                ],
                [
                    'class'          => '\kartik\grid\DataColumn',
                    'attribute'      => 'TotalProfit',
                    'format'         => ['decimal', 2],
                    'label'          => $searchModel->getAttributeLabel('TotalProfit'),
                    'hAlign'         => 'right',
                    'contentOptions' => function ($model, $index, $dataColumn) {
                        if ($model['TotalProfit'] < 0) {
                            return ['class' => 'neg'];
                        }
                        return null;
                    },
                    'pageSummary'    => true,
                ],
                [
                    'format'         => 'raw',
                    'value'          => function ($model) {
                        return Html::a(($model->machine && !empty($model->machine->comment)) ? $model->machine->comment : Yii::t('app', 'Add Comment'), ['/machine/comment', 'id' => $model->order_devid], ['title' => Yii::t('app', 'Add Comment'), 'class' => 'showModalButton']);
                    },
                    'hAlign'         => 'center',
                    'contentOptions' => ['class' => 'comment'],
                ],
            ],
            'panel'              => [
                'heading' => Icon::show('leaf', ['class' => 'fa fa-money'], Icon::FA) . Yii::t('app', 'Business Profits {Month}', ['Month' => $date]),
                'footer'  => false,
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
            //'floatHeader'        => true,
            'floatHeaderOptions' => ['top' => 65],
            'showPageSummary'    => true,
            //            'export' => [
            //                'menuOptions' =>[
            //                    'style' => 'z-index:2000',
            //                ]
            //            ]
        ]));
        ?>
    </div>
    <div class="col-md-3">
        <div class="row">
            <?= GridView::widget(ArrayHelper::merge(Yii::$app->params['kartik/grid/'], [
                'dataProvider'    => $prepaidListTest,
                'columns'         => [
                    [
                        'class'     => '\kartik\grid\DataColumn',
                        'attribute' => 'acc_service_amount',
                        'label'     => $account->getAttributeLabel('acc_service_amount'),
                        'hAlign'    => 'right',

                    ],
                    [
                        'class'       => '\kartik\grid\DataColumn',
                        'attribute'   => 'PrepaidAmount',
                        'format'      => ['decimal', 2],
                        'label'       => $account->getAttributeLabel('refillSum'),
                        'hAlign'      => 'right',
                        'pageSummary' => true,
                    ],
                    [
                        'class'       => '\kartik\grid\DataColumn',
                        'attribute'   => 'PrepaidCount',
                        'label'       => $account->getAttributeLabel('refillCount'),
                        'hAlign'      => 'right',
                        'pageSummary' => true,
                    ],
                ],
                'panel'           => [
                    'heading' => Icon::show('leaf', ['class' => 'fa fa-money'], Icon::FA) . Html::encode(Yii::t('app', 'Refill {Month}', ['Month' => $this->title])),
                    'footer'  => false,
                ],
                'exportConfig'    => [
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
                'toolbar'         => true,
                'showPageSummary' => true,

            ]));?>
        </div>

        <div class="row">
            <?= GridView::widget(ArrayHelper::merge(Yii::$app->params['kartik/grid/'], [
                'dataProvider' => $statusList,
                'columns'      => [
                    [
                        'class'     => '\kartik\grid\DataColumn',
                        'attribute' => 'countX',
                        'label'     => Yii::t('app/order', 'Execute'),
                        'hAlign'    => 'right',
                        'format'    => 'raw',
                        'value'     =>
                            function ($model) use ($searchModel) {
                                return Html::a($model['countX'], [
                                    '/order/index',
                                    'OrderSearch[order_status]' => 'X',
                                    'OrderSearch[from_date]'    => $searchModel->from_date,
                                    'OrderSearch[to_date]'      => $searchModel->to_date,
                                ],[
                                    'data-pjax'=> 0
                                ]);
                            },
                    ],
                    [
                        'class'     => '\kartik\grid\DataColumn',
                        'attribute' => 'countM',
                        'label'     => Yii::t('app/order', 'Incomplete'),
                        'hAlign'    => 'right',
                        'format'    => 'raw',
                        'value'     => function ($model) use ($searchModel) {
                            return Html::a($model['countM'], [
                                '/order/index',
                                'OrderSearch[order_status]' => 'M',
                                'OrderSearch[from_date]'    => $searchModel->from_date,
                                'OrderSearch[to_date]'      => $searchModel->to_date,
                            ],[
                                'data-pjax'=> 0
                            ]);
                        },
                    ],
                    [
                        'hAlign'    => 'right',
                        'attribute' => 'countC',
                        'label'     => Yii::t('app/order', 'Canceled'),
                        'format'    => 'raw',
                        'value'     => function ($model) use ($searchModel) {
                            return Html::a($model['countC'], [
                                '/order/index',
                                'OrderSearch[order_status]' => 'C',
                                'OrderSearch[from_date]'    => $searchModel->from_date,
                                'OrderSearch[to_date]'      => $searchModel->to_date,
                            ],[
                                'data-pjax'=> 0
                            ]);
                        },
                    ],
                ],
                'panel'        => [
                    'heading' => Icon::show('leaf', ['class' => 'fa fa-money'], Icon::FA) . Html::encode(Yii::t('app/order', 'Transaction Status {Month}', ['Month' => $this->title])),
                    'footer'  => false,
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
                'toolbar'      => true,
                // 'showPageSummary' => true,

            ])); ?>
        </div>

    </div>

</div>
