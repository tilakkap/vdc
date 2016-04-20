<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\DeviceSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app/device', 'Device');
?>
<div class="device-index">
    <?php

    echo GridView::widget(ArrayHelper::merge(Yii::$app->params['kartik/grid/'], [
        'dataProvider' => $dataProvider,
        'columns'      => [
            ['class' => 'kartik\grid\SerialColumn'],
            'dev_name',
            'dev_serial_no',
            [
                'class'       => '\kartik\grid\DataColumn',
                'attribute'   => 'machineStatus.text',
                'label'=> $searchModel->getAttributeLabel('dev_status'),
            ],
            'dev_last_use',
            'dev_simcurrent_no',
            'version',
            [
                'attribute' => 'machine.comment',
                'format'    => 'raw',
                'value'     => function ($model) {
                    return Html::a(($model->machine) ? $model->machine->comment : Yii::t('app', 'Add Comment'), ['/machine/comment', 'id' => $model->dev_id], ['title' => Yii::t('app', 'Add Comment'), 'class' => 'showModalButton']);
                },
                'hAlign'    => 'center',
                'contentOptions' => ['class'=>'comment']
            ],
        ],
        'panel'        => [
            'heading' => '<i class="glyphicon glyphicon-book"></i>  ' . Html::encode($this->title),
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
