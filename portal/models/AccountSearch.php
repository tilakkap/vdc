<?php

namespace app\models;

use app\components\DateHelper;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\data\SqlDataProvider;

/**
 * AccountSearch represents the model behind the search form about `app\models\Account`.
 */
class AccountSearch extends Account
{
    public $from_date;
    public $to_date;
    public $member;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['acc_type', 'member'], 'safe'],
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
                $this->DATE_FORMAT('`acc_created`', '%d %b %Y %h:%i:%s', 'acc_created'),
                'acc_desc',
                'acc_type_desc',
                'acc_balance_before',
                'acc_balance_after',
                'acc_amount',
                'acc_ref',
                'acc_service_amount',
                'acc_remark',
            ])
            ->joinWith(['service'])
            ->joinWith(['accountType'])
            ->andFilterWhere(['in','acc_memberid', $this->acc_memberid])
            ->andFilterWhere(['acc_type' => $this->acc_type]);
        $this->load($params);

        if (!($this->load($params) && $this->validate())) {
            // uncomment the following line if you do not want to return any records when validation fails
            $query->where('0=1');
        }

        $from_date = DateHelper::getTimestamp($this->from_date, \Yii::$app->params['languages']);
        $to_date = DateHelper::getTimestamp($this->to_date, \Yii::$app->params['languages']);

        if (!$this->to_date) {
            $to_date = DateHelper::getTimestamp($this->from_date, \Yii::$app->params['languages']);
        }

        $to_date += 86399;

        $query->andFilterWhere(['BETWEEN', 'acc_created', date('Y-m-d H:i:s', $from_date), date('Y-m-d H:i:s', $to_date)]);
        $query->andFilterWhere(['acc_memberid' => $this->member]);

        $sqlData = $query->createCommand()->rawSql;
        $sqlCount = 'SELECT COUNT(*) FROM (' . $sqlData . ') `c`';

        $totalCount = Yii::$app->db1->createCommand($sqlCount)->queryScalar();

        $dataProvider = new SqlDataProvider([
            'db'         => Yii::$app->db1,
            'sql'        => $sqlData,
            'totalCount' => $totalCount,
            'sort'       => [
                'defaultOrder' => ['acc_created'=>SORT_ASC],
                'attributes' => [
                    'acc_created'        => [
                        'asc'     => ['DATE_FORMAT(acc_created,\'%y%m%d%H:%i:%m\')' => SORT_ASC],
                        'desc'    => ['DATE_FORMAT(acc_created,\'%y%m%d%H:%i:%m\')' => SORT_DESC],
                        'default' => SORT_ASC,
                    ],
                    'acc_type_desc'           => [
                        'asc'     => ['acc_type_desc' => SORT_ASC],
                        'desc'    => ['acc_type_desc' => SORT_DESC],
                        'default' => SORT_ASC,
                    ],
                    'acc_desc'           => [
                        'asc'     => ['acc_desc' => SORT_ASC],
                        'desc'    => ['acc_desc' => SORT_DESC],
                        'default' => SORT_ASC,
                    ],
                    'acc_balance_before' => [
                        'asc'     => ['acc_balance_before' => SORT_ASC],
                        'desc'    => ['acc_balance_before' => SORT_DESC],
                        'default' => SORT_ASC,
                    ],
                    'acc_balance_after'  => [
                        'asc'     => ['acc_balance_after' => SORT_ASC],
                        'desc'    => ['acc_balance_after' => SORT_DESC],
                        'default' => SORT_ASC,
                    ],
                    'acc_amount'         => [
                        'asc'     => ['acc_amount' => SORT_ASC],
                        'desc'    => ['acc_amount' => SORT_DESC],
                        'default' => SORT_ASC,
                    ],
                    'acc_ref'            => [
                        'asc'     => ['acc_ref' => SORT_ASC],
                        'desc'    => ['acc_ref' => SORT_DESC],
                        'default' => SORT_ASC,
                    ],
                    'acc_service_amount' => [
                        'asc'     => ['acc_ref' => SORT_ASC],
                        'desc'    => ['acc_ref' => SORT_DESC],
                        'default' => SORT_ASC,
                    ],
                    'acc_remark' => [
                        'asc'     => ['acc_remark' => SORT_ASC],
                        'desc'    => ['acc_remark' => SORT_DESC],
                        'default' => SORT_ASC,
                    ],

                ],
            ],
        ]);
        return $dataProvider;
    }
}
