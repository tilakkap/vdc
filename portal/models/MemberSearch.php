<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Member;

/**
 * MemberSearch represents the model behind the search form about `app\models\Member`.
 */
class MemberSearch extends Member
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['member_id'], 'integer'],
            [['member_username', 'member_fname', 'member_lname', 'member_pid', 'member_address', 'member_city', 'member_province', 'member_zipcode', 'member_email', 'member_telno', 'member_smsno', 'member_created', 'member_bankref', 'member_created_user'], 'safe'],
            [['member_balance'], 'number'],
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
        $query = Member::find()
        ->andFilterWhere(['in','member_id', $this->member_id]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'member_id' => $this->member_id,
            'member_created' => $this->member_created,
            'member_balance' => $this->member_balance,
        ]);

        $query->andFilterWhere(['=', 'member_username', $this->member_username])
            ->andFilterWhere(['like', 'member_fname', $this->member_fname])
            ->andFilterWhere(['like', 'member_lname', $this->member_lname])
            ->andFilterWhere(['like', 'member_pid', $this->member_pid])
            ->andFilterWhere(['like', 'member_address', $this->member_address])
            ->andFilterWhere(['like', 'member_city', $this->member_city])
            ->andFilterWhere(['like', 'member_province', $this->member_province])
            ->andFilterWhere(['like', 'member_zipcode', $this->member_zipcode])
            ->andFilterWhere(['like', 'member_email', $this->member_email])
            ->andFilterWhere(['like', 'member_telno', $this->member_telno])
            ->andFilterWhere(['like', 'member_smsno', $this->member_smsno])
            ->andFilterWhere(['like', 'member_bankref', $this->member_bankref])
            ->andFilterWhere(['like', 'member_created_user', $this->member_created_user]);

        return $dataProvider;
    }
}
