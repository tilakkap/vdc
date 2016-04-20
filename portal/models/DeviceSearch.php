<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Device;
use yii\data\Sort;

/**
 * DeviceSearch represents the model behind the search form about `app\models\Device`.
 */
class DeviceSearch extends Device
{
    public $version;
    public $devices;

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
        $query = Device::find()
            ->addSelect(['*', 'LEFT({{%VDC_DEVICE_PROFILE}}.`dev_serial_no`, 2) as version'])
            ->with('machine')
            ->with('machineStatus')
            ->andFilterWhere(['in','dev_id',$this->devices]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->sort->attributes['version'] = [
            'asc'     => ['LEFT(dev_serial_no,2)' => SORT_ASC],
            'desc'    => ['LEFT(dev_serial_no,2)' => SORT_DESC],
            'default' => SORT_ASC,
        ];

        $dataProvider->sort->attributes['machine.comment'] = [
            'asc'     => ['dev_id' => SORT_ASC],
            'desc'    => ['dev_id' => SORT_DESC],
            'default' => SORT_ASC,
        ];

        $dataProvider->sort->attributes['machineStatus.text'] = [
            'asc'     => ['dev_status' => SORT_ASC],
            'desc'    => ['dev_status' => SORT_DESC],
            'default' => SORT_ASC,
        ];
        
        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        return $dataProvider;
    }
}
