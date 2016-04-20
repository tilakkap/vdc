<?php

namespace app\models;

use app\components\DateHelper;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Order;
use yii\data\SqlDataProvider;

/**
 * OrderSearch represents the model behind the search form about `app\models\Order`.
 */
class OrderProfitSearch extends Order
{

    public $from_date;
    public $to_date;
    public $dev_member;
    public $dev_name;
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['dev_name'], 'safe'],
            [['from_date'], 'required'],
            [['to_date', 'from_date'], 'date'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
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
            $this->DATE_FORMAT('`order_created`', '%M %Y', 'monthYear'),
            'service_desc as service',
            'SUM(IFNULL(`order_charge` + `acc_service_amount` - `acc_amount`,0)) AS `totalProfit`',
        ])
            ->joinWith(['device'])
            ->joinWith(['account'])
            ->joinWith(['service'])
            ->groupBy(['monthYear', 'service'])
            ->andFilterWhere(['in','order_devid', $this->devices]);

        $this->load($params);

        if (!($this->load($params) && $this->validate())) {
            // uncomment the following line if you do not want to return any records when validation fails
            $query->where('0=1');
            //return $dataProvider;
        }

        $from_date = DateHelper::getTimestamp($this->from_date, \Yii::$app->params['languages']);
        $to_date = DateHelper::getTimestamp($this->to_date, \Yii::$app->params['languages']);

        if (!$this->to_date) {
            $to_date = $from_date;
        }
        $to_date += 86399;

        $query->andFilterWhere(['BETWEEN', 'acc_created', date('Y-m-d H:i:s', $from_date), date('Y-m-d H:i:s', $to_date)])
                ->andFilterWhere(['in', 'dev_id', $this->dev_name]);

        $sqlData = $query->createCommand()->rawSql;
        $sqlCount = 'SELECT COUNT(*) FROM (' . $sqlData . ') `c`';

        $totalCount = Yii::$app->db1->createCommand($sqlCount)->queryScalar();

        $dataProvider = new SqlDataProvider([
            'db'         => Yii::$app->db1,
            'sql'        => $sqlData,
            'totalCount' => $totalCount,
            'sort'       => [
                'attributes' => [
                    'totalProfit' => [
                        'asc'     => ['totalProfit' => SORT_ASC],
                        'desc'    => ['totalProfit' => SORT_DESC],
                        'default' => SORT_ASC,
                    ],
                    'service'     => [
                        'asc'     => ['service_desc' => SORT_ASC],
                        'desc'    => ['service_desc' => SORT_DESC],
                        'default' => SORT_ASC,
                    ],
                    'monthYear'   => [
                        'asc'     => ['DATE_FORMAT(order_created,\'%y%m\')' => SORT_ASC],
                        'desc'    => ['DATE_FORMAT(order_created,\'%y%m\')' => SORT_DESC],
                        'default' => SORT_ASC,
                    ],
                    'created_on',
                ],
            ],
            'pagination' => [
                'pageSize' => 0,
            ],
        ]);
        return $dataProvider;
    }
}
