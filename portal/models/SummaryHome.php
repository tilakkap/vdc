<?php

namespace app\models;

use app\components\DateHelper;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Order;
use yii\data\SqlDataProvider;
use yii\helpers\ArrayHelper;

/**
 * OrderSearch represents the model behind the search form about `app\models\Order`.
 */
class SummaryHome extends Order
{

    public $dev_member;
    public $dev_name;
    public $from_date;
    public $to_date;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['dev_name'], 'safe'],
            [
                ['from_date'], 'compare', 'compareAttribute' => 'to_date', 'operator' => '<=', 'when' => function ($model) {
                return $model->to_date != '';
            }, 'whenClient'                                  => "function (attribute, value) {return $('#orderprofitsearch-to_date').val() != '';}",
            ],
            [['to_date'], 'compare', 'compareAttribute' => 'from_date', 'operator' => '>='],
            [['to_date', 'from_date'], 'date'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {

        return ArrayHelper::merge(parent::attributeLabels(),[
            'PrepaidAmount' => Yii::t('app/site', 'Prepaid'),
            'PrepaidCount' => Yii::t('app/site', 'Count Prepaid'),
            'MonthAmount' => Yii::t('app/site', 'Monthly Pay'),
            'OtherAmount' => Yii::t('app/site', 'Other Pay'),
            'TotalProfit' => Yii::t('app/order', 'Total Profit'),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function prepaidListTest(){


        $query = Order::find()->addSelect([
            '`acc_service_amount`',
            'count(`acc_service_amount`) AS `PrepaidCount`',
            'sum(`acc_service_amount`) As PrepaidAmount'
        ])
            ->joinWith(['device'])
            ->joinWith(['account'])
            ->joinWith(['service'])
            ->groupBy(['acc_service_amount'])
            ->andFilterWhere(['in','order_devid', $this->devices])
            ->andFilterWhere(['in','service_id',[1,2,3,4,11,12]]);

        $from_date = DateHelper::getTimestamp($this->from_date, \Yii::$app->params['languages']);
        $to_date = DateHelper::getTimestamp($this->to_date, \Yii::$app->params['languages']);

        if (!$this->to_date) {
            $to_date = $from_date;
        }
        $to_date += 86399;

        $query->andFilterWhere(['BETWEEN', 'acc_created', date('Y-m-d H:i:s', $from_date), date('Y-m-d H:i:s', $to_date)]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'       => [
                'attributes' => [
                    'acc_service_amount' => [
                        'asc'     => ['acc_service_amount' => SORT_ASC],
                        'desc'    => ['acc_service_amount' => SORT_DESC],
                        'default' => SORT_ASC,
                    ],
                    'PrepaidCount'     => [
                        'asc'     => ['PrepaidCount' => SORT_ASC],
                        'desc'    => ['PrepaidCount' => SORT_DESC],
                        'default' => SORT_ASC,
                    ],
                    'PrepaidAmount'   => [
                        'asc'     => ['PrepaidAmount' => SORT_ASC],
                        'desc'    => ['PrepaidAmount' => SORT_DESC],
                        'default' => SORT_ASC,
                    ],
                ],
            ],
        ]);

        Order::getDb()->cache(function ($db) use ($dataProvider) {
            $dataProvider->prepare();
        }, 3600);

        return $dataProvider;
    }


    public function statusList(){

        $query = Order::find()->addSelect([
            'SUM(IF(`order_status` = "C",1,0)) AS `countC`',
            'SUM(IF(`order_status` = "M",1,0)) AS `countM`',
            'SUM(IF(`order_status` = "X",1,0)) AS `countX`'
        ])
            ->joinWith(['device'])
            ->joinWith(['account'])
            ->joinWith(['service'])
            //->groupBy(['acc_service_amount'])
            ->andFilterWhere(['in','order_devid', $this->devices]);

        $from_date = DateHelper::getTimestamp($this->from_date, \Yii::$app->params['languages']);
        $to_date = DateHelper::getTimestamp($this->to_date, \Yii::$app->params['languages']);

        if (!$this->to_date) {
            $to_date = $from_date;
        }
        $to_date += 86399;

        $query->andFilterWhere(['BETWEEN', 'order_created', date('Y-m-d H:i:s', $from_date), date('Y-m-d H:i:s', $to_date)]);

        $sqlData = $query->createCommand()->rawSql;
        $sqlCount = 'SELECT COUNT(*) FROM (' . $sqlData . ') `c`';
        $totalCount = Yii::$app->db1->createCommand($sqlCount)->queryScalar();

        $dataProvider = new SqlDataProvider([
            'db'         => Yii::$app->db1,
            'sql'        => $sqlData,
            'totalCount' => $totalCount,
            'pagination' => [
                'pageSize' => 0,
            ],
            'sort'       => [
                'attributes' => [
                    'countC' => [
                        'asc'     => ['countC' => SORT_ASC],
                        'desc'    => ['countC' => SORT_DESC],
                        'default' => SORT_ASC,
                    ],
                    'countM'     => [
                        'asc'     => ['countM' => SORT_ASC],
                        'desc'    => ['countM' => SORT_DESC],
                        'default' => SORT_ASC,
                    ],
                    'countX'   => [
                        'asc'     => ['countX' => SORT_ASC],
                        'desc'    => ['countX' => SORT_DESC],
                        'default' => SORT_ASC,
                    ],
                ],
            ],
        ]);
        Order::getDb()->cache(function ($db) use ($dataProvider) {
            $dataProvider->prepare();
        }, 3600);

        return $dataProvider;
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Order::find()->addSelect([
            '*',
            'SUM(IF(`service_id` in(1,2,3,4,11,12),`acc_service_amount`,0)) AS `PrepaidAmount`',
            'SUM(IF(`service_id` in(5),`acc_service_amount`,0)) AS `MonthAmount`',
            'SUM(IF(`service_id` not in(1,2,3,4,5,11,12),`acc_service_amount`,0)) AS `OtherAmount`',
            'SUM(`order_charge` + `acc_service_amount` - `acc_amount`) AS `TotalProfit`',
        ])
            ->joinWith(['device'])
            ->joinWith(['account'])
            ->joinWith(['service'])
            ->groupBy(['dev_name'])
            ->with('machine')
            ->andFilterWhere(['in','order_devid', $this->devices]);

        $this->load($params);

        if (!($this->load($params) && $this->validate())) {
            // uncomment the following line if you do not want to return any records when validation fails
            //$query->where('0=1');
            //return $dataProvider;
        }

        $from_date = DateHelper::getTimestamp($this->from_date, \Yii::$app->params['languages']);
        $to_date = DateHelper::getTimestamp($this->to_date, \Yii::$app->params['languages']);

        if (!$this->to_date) {
            $to_date = $from_date;
        }
        $to_date += 86399;

        $query->andFilterWhere(['BETWEEN', 'acc_created', date('Y-m-d H:i:s', $from_date), date('Y-m-d H:i:s', $to_date)]);
        
        $dataProvider = new ActiveDataProvider([
            'query'     => $query,
            'sort'       => [
                'attributes' => [
                    'PrepaidAmount' => [
                        'asc'     => ['PrepaidAmount' => SORT_ASC],
                        'desc'    => ['PrepaidAmount' => SORT_DESC],
                        'default' => SORT_ASC,
                    ],
                    'MonthAmount'     => [
                        'asc'     => ['MonthAmount' => SORT_ASC],
                        'desc'    => ['MonthAmount' => SORT_DESC],
                        'default' => SORT_ASC,
                    ],
                    'OtherAmount'   => [
                        'asc'     => ['OtherAmount' => SORT_ASC],
                        'desc'    => ['OtherAmount' => SORT_DESC],
                        'default' => SORT_ASC,
                    ],
                    'TotalProfit'   => [
                        'asc'     => ['TotalProfit' => SORT_ASC],
                        'desc'    => ['TotalProfit' => SORT_DESC],
                        'default' => SORT_ASC,
                    ],
                    'device.dev_name' => [
                        'asc'     => ['dev_name' => SORT_ASC],
                        'desc'    => ['dev_name' => SORT_DESC],
                        'default' => SORT_ASC,
                    ],

                ],
            ],
            'pagination' => [
                'pageSize' => 0,
            ],
        ]);

        return $dataProvider;
    }
}
