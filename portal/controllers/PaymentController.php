<?php

namespace app\controllers;

use app\models\PaymentSearch;
use Yii;

class PaymentController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $searchModel = new PaymentSearch();
        $searchModel->kiosk_activate_code = Yii::$app->session->get('device_ids');
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel'  => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

}
