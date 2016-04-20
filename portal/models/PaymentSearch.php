<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Payment;
use yii\helpers\ArrayHelper;

/**
 * PaymentSearch represents the model behind the search form about `app\models\Payment`.
 */
class PaymentSearch extends Payment
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'kiosk_id', 'payment_status', 'payment_type', 'invoice_id', 'customer_id', 'totalday_t0', 'totalday_t1', 'totalday_t2'], 'integer'],
            [['payment_code', 'payment_desc', 'kiosk_code', 'kiosk_activate_code', 'payment_date', 'payment_time', 'batch_code', 'create_byuser', 'create_datetime', 'payment_ref1', 'payment_ref2', 'receipt_no', 'invoice_code', 'customer_code', 'customer_firstname', 'customer_lastname', 'payment_cancel_byuser', 'payment_cancel_datetime', 'payment_remark'], 'safe'],
            [['payment_amount', 'tax_amount', 'interest_amount', 'principle_amount', 'interest_i0', 'interest_i1', 'interest_i2', 'floatrate_r', 'vat_v', 'principle_p', 'fee'], 'number'],
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
        $query = Payment::find()
                ->select(['id',
                          'kiosk_code',
                          'payment_code',
                          $this->DATE_FORMAT('`payment_date`', '%d. %b %Y', 'payment_date'),
                          $this->DATE_FORMAT('`payment_date`', '%b %d, %Y', 'description'),
                          'payment_amount'
                ])
                ->andFilterWhere(['in','kiosk_activate_code', $this->kiosk_activate_code]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->setSort([
            'attributes' => [
                'kiosk_code' => [
                    'asc'     => ['kiosk_code' => SORT_ASC],
                    'desc'    => ['kiosk_code' => SORT_DESC],
                    'default' => SORT_ASC,
                ],
                'payment_code'     => [
                    'asc'     => ['payment_code' => SORT_ASC],
                    'desc'    => ['payment_code' => SORT_DESC],
                    'default' => SORT_ASC,
                ],
                'payment_date'   => [
                    'asc'     => ['payment_date' => SORT_ASC],
                    'desc'    => ['payment_date' => SORT_DESC],
                    'default' => SORT_ASC,
                ],
                'description'   => [
                    'asc'     => ['payment_date' => SORT_ASC],
                    'desc'    => ['payment_date' => SORT_DESC],
                    'default' => SORT_ASC,
                ],
                'payment_amount' => [
                    'asc'     => ['payment_amount' => SORT_ASC],
                    'desc'    => ['payment_amount' => SORT_DESC],
                    'default' => SORT_ASC,
                ],

            ]]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'kiosk_id' => $this->kiosk_id,
            'payment_amount' => $this->payment_amount,
            'tax_amount' => $this->tax_amount,
            'interest_amount' => $this->interest_amount,
            'principle_amount' => $this->principle_amount,
            'payment_date' => $this->payment_date,
            'payment_time' => $this->payment_time,
            'payment_status' => $this->payment_status,
            'create_datetime' => $this->create_datetime,
            'payment_type' => $this->payment_type,
            'invoice_id' => $this->invoice_id,
            'customer_id' => $this->customer_id,
            'payment_cancel_datetime' => $this->payment_cancel_datetime,
            'interest_i0' => $this->interest_i0,
            'interest_i1' => $this->interest_i1,
            'interest_i2' => $this->interest_i2,
            'floatrate_r' => $this->floatrate_r,
            'totalday_t0' => $this->totalday_t0,
            'totalday_t1' => $this->totalday_t1,
            'totalday_t2' => $this->totalday_t2,
            'vat_v' => $this->vat_v,
            'principle_p' => $this->principle_p,
            'fee' => $this->fee,
        ]);

        $query->andFilterWhere(['like', 'payment_code', $this->payment_code])
            ->andFilterWhere(['like', 'payment_desc', $this->payment_desc])
            ->andFilterWhere(['like', 'kiosk_code', $this->kiosk_code])
            ->andFilterWhere(['like', 'kiosk_activate_code', $this->kiosk_activate_code])
            ->andFilterWhere(['like', 'batch_code', $this->batch_code])
            ->andFilterWhere(['like', 'create_byuser', $this->create_byuser])
            ->andFilterWhere(['like', 'payment_ref1', $this->payment_ref1])
            ->andFilterWhere(['like', 'payment_ref2', $this->payment_ref2])
            ->andFilterWhere(['like', 'receipt_no', $this->receipt_no])
            ->andFilterWhere(['like', 'invoice_code', $this->invoice_code])
            ->andFilterWhere(['like', 'customer_code', $this->customer_code])
            ->andFilterWhere(['like', 'customer_firstname', $this->customer_firstname])
            ->andFilterWhere(['like', 'customer_lastname', $this->customer_lastname])
            ->andFilterWhere(['like', 'payment_cancel_byuser', $this->payment_cancel_byuser])
            ->andFilterWhere(['like', 'payment_remark', $this->payment_remark]);

        return $dataProvider;
    }
}
