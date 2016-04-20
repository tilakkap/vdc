<?php

use app\models\Device;
use kartik\date\DatePicker;
use kartik\form\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\icons\Icon;

/* @var $this yii\web\View */
/* @var $searchModel app\models\AccountRefill */
/* @var $service app\models\Service */
/* @var $device app\models\Device */
/* @var $dataProvider yii\data\SqlDataProvider */

$this->title = Yii::t('app/account', 'Statistics Refill');
?>
<div class="account-index">

    <div class="order-search">

        <?php $form = ActiveForm::begin([
            'action'     => [$action],
            'method'     => 'get',
            'type'       => ActiveForm::TYPE_INLINE,
            'formConfig' => [
                'showErrors' => true,
            ],
        ]); ?>


        <?= $form->field($searchModel, 'from_date')->widget(DatePicker::classname(), [
            'options'       => [
                // you can hide the input by setting the following
                'placeholder' => $searchModel->getAttributeLabel('from_date'),
            ],
        ]); ?>

        <?= $form->field($searchModel, 'to_date')->widget(DatePicker::classname(), [
            'options'       => [
                // you can hide the input by setting the following
                'placeholder' => $searchModel->getAttributeLabel('to_date'),
            ],

        ]); ?>


        <?= $form->field($searchModel, 'dev_name')->widget(Select2::classname(), [
            'data' => ArrayHelper::map(Device::find()->where(['dev_id' => \Yii::$app->getSession()->get("device_ids")])->all(), 'dev_id', 'dev_name'),
            'size' => Select2::SMALL,
            'showToggleAll' => false,
            'pluginEvents' => [
                "change" => "function() {
            var ele = $(this);
            if(ele.val() && ele.val().length==5)
            {ele.select2('close');}
            }",

            ],
            'options' => [
                'placeholder' => Yii::t('app/device', 'Please Select Devices'),
                'multiple' => true
            ],
            'pluginOptions' => [
                'allowClear' => true,
                'closeOnSelect' => false,
                'maximumSelectionLength' => 5,
            ],
        ]);
        ?>

        <div class="form-group">
            <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-sm btn-primary']) ?>
            <?= Html::a(Yii::t('app', 'Reset'), ['/order/reset'], ['class'=>'btn btn-sm btn-default']) ?>
        </div>
        <?php ActiveForm::end(); ?>

    </div>


    <?= GridView::widget(ArrayHelper::merge(Yii::$app->params['kartik/grid/'], [
        'dataProvider' => $dataProvider,
        'columns'      => [
            ['class' => 'kartik\grid\SerialColumn'],
            [
                'label'     => $service->getAttributeLabel('service_desc'),
                'attribute' => 'service_desc',
            ],
            [
                'label'     => $searchModel->getAttributeLabel('refillCount'),
                'attribute' => 'refillCount',
                'pageSummary'    => true,
                'hAlign'=>'right',
            ],
            [
                'label'     => $searchModel->getAttributeLabel('refillSum'),
                'attribute' => 'refillSum',
                'pageSummary'    => true,
                'hAlign'=>'right',
                'format'         => ['decimal', 2],
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
        'showPageSummary'    => true,
    ])); ?>

</div>
