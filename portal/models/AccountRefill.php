<?php

namespace app\models;

use app\components\DateHelper;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\data\SqlDataProvider;
use app\models\Account;

/**
 * AccountRefill represents the model behind the search form about `app\models\Account`.
 */
class AccountRefill extends Account
{
    public $from_date;
    public $to_date;
    public $dev_name;
    public $member;

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
        $query = Account::find()
            ->select([
                '`service_desc`',
                'Count(`acc_service_amount`) as refillCount',
                'Sum(`acc_service_amount`) as refillSum',
            ])
            ->joinWith(['service'])
            ->joinWith(['device'])
            ->andWhere(['not', ['acc_service' => null]])
            ->andFilterWhere(['in', 'acc_memberid', $this->acc_memberid])
            ->andFilterWhere(['in', 'dev_id', \Yii::$app->getSession()->get("device_ids")])
            ->groupBy(['service_desc']);
        $this->load($params);

        if (!($this->load($params) && $this->validate())) {
            // uncomment the following line if you do not want to return any records when validation fails
            $query->where('0=1');
        }

        $from_date = DateHelper::getTimestamp($this->from_date, \Yii::$app->params['languages']);
        $to_date = DateHelper::getTimestamp($this->to_date, \Yii::$app->params['languages']);

        if (!$this->to_date) {
            $to_date = $from_date;
        }
        $to_date += 86399;

        $query->andFilterWhere(['BETWEEN', 'acc_created', date('Y-m-d H:i:s', $from_date), date('Y-m-d H:i:s', $to_date)])
              ->andFilterWhere(['in', 'dev_id', $this->dev_name])
              ->andFilterWhere(['acc_memberid' => $this->member]);

        $sqlData = $query->createCommand()->rawSql;
        $sqlCount = 'SELECT COUNT(*) FROM (' . $sqlData . ') `c`';

        $totalCount = Yii::$app->db1->createCommand($sqlCount)->queryScalar();

        $dataProvider = new SqlDataProvider([
            'db'         => Yii::$app->db1,
            'sql'        => $sqlData,
            'totalCount' => $totalCount,
            'sort'       => [
                'attributes'   => [
                    'refillCount'  => [
                        'asc'     => ['refillCount' => SORT_ASC],
                        'desc'    => ['refillCount' => SORT_DESC],
                        'default' => SORT_ASC,
                    ],
                    'refillSum'    => [
                        'asc'     => ['refillSum' => SORT_ASC],
                        'desc'    => ['refillSum' => SORT_DESC],
                        'default' => SORT_ASC,
                    ],
                    'service_desc' => [
                        'asc'     => ['service_desc' => SORT_ASC],
                        'desc'    => ['service_desc' => SORT_DESC],
                        'default' => SORT_ASC,
                    ],
                ],
            ],
        ]);
        return $dataProvider;
    }
}
