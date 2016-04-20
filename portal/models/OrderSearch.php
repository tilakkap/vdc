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
class OrderSearch extends Order
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
            [['order_id', 'order_devid', 'order_service', 'order_accid', 'order_parentid'], 'integer'],
            [['dev_name', 'order_created', 'order_status', 'order_mobileno', 'order_ref1', 'order_ref2', 'order_ref3', 'order_remark'], 'safe'],
            [['order_amount', 'order_charge', 'order_coin', 'order_bill', 'order_paid', 'order_disc_old', 'order_disc_new'], 'number'],
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
        $query = Order::find()
            ->addSelect(['*','`order_charge` + `acc_service_amount` - `acc_amount` as profit',])
            ->joinWith(['device'])
            ->joinWith(['account'])
            ->joinWith(['service'])
            ->with('orderStatus')
            ->andFilterWhere(['in','order_devid', $this->devices]);

        $this->load($params);

        if (!($this->load($params) && $this->validate())) {
            // uncomment the following line if you do not want to return any records when validation fails
            $query->andWhere('1=0');
        }

        $from_date = DateHelper::getTimestamp($this->from_date, \Yii::$app->params['languages']);
        $to_date = DateHelper::getTimestamp($this->to_date, \Yii::$app->params['languages']);

        if (!$this->to_date) {
            $to_date = $from_date;
        }
        $to_date += 86399;

        $query->andFilterWhere(['BETWEEN', 'order_created', date('Y-m-d H:i:s', $from_date), date('Y-m-d H:i:s', $to_date)])
            ->andFilterWhere(['in', 'dev_id', $this->dev_name])
            ->andFilterWhere(['in', 'order_status', $this->order_status]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->sort->attributes['device.dev_name'] =[
            'asc'     => ['dev_name' => SORT_ASC],
            'desc'    => ['dev_name' => SORT_DESC],
            'default' => SORT_ASC,
        ];

        $dataProvider->sort->attributes['service.service_desc'] =[
            'asc'     => ['service_desc' => SORT_ASC],
            'desc'    => ['service_desc' => SORT_DESC],
            'default' => SORT_ASC,
        ];

        $dataProvider->sort->attributes['orderStatus.text'] =[
            'asc'     => ['order_status' => SORT_ASC],
            'desc'    => ['order_status' => SORT_DESC],
            'default' => SORT_ASC,
        ];

        $dataProvider->sort->attributes['profit'] =[
            'asc'     => ['profit' => SORT_ASC],
            'desc'    => ['profit' => SORT_DESC],
            'default' => SORT_ASC,
        ];

        return $dataProvider;
    }
}
