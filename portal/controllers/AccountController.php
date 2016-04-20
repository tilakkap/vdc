<?php

namespace app\controllers;

use app\models\AccountRefill;
use app\models\AccountType;
use app\models\Service;
use Yii;
use app\models\Account;
use app\models\AccountSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * AccountController implements the CRUD actions for Account model.
 */
class AccountController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class'   => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all Account models.
     * @return mixed
     */
    public function actionIndex($accType = null)
    {
        $accountType = new AccountType();
        $searchModel = new AccountSearch();
        $searchModel->acc_type = $accType;
        $searchModel->acc_memberid = \Yii::$app->getSession()->get("member_ids");
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $action = ($accType) ? 'transfer' : 'index';

        return $this->render('index', [
            'searchModel'  => $searchModel,
            'dataProvider' => $dataProvider,
            'accountType'  => $accountType,
            'action'       => $action,
        ]);
    }

    /**
     * Lists all Refills.
     * @return mixed
     */
    public function actionRefill()
    {
        $service = new Service();
        $searchModel = new AccountRefill();
        $searchModel->acc_memberid = \Yii::$app->getSession()->get("member_ids");
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $action = 'refill';

        return $this->render($action, [
            'searchModel'  => $searchModel,
            'dataProvider' => $dataProvider,
            'service'      => $service,
            'action'       => $action,
        ]);
    }


    /**
     * Lists all Account models for account type 3.
     * @return mixed
     */
    public function actionTransfer()
    {
        return $this->actionIndex(3);
    }

    /**
     * Reset Search Form.
     * @return mixed
     */
    public function actionReset()
    {
        return $this->redirect('index');
    }

    /**
     * Displays a single Account model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Finds the Account model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Account the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Account::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
