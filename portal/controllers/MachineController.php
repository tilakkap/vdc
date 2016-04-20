<?php

namespace app\controllers;

use app\models\Device;
use app\models\Machine;
use Yii;

use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

class MachineController extends \yii\web\Controller
{

    /**
     * Creates a new Machine model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Machine();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Machine model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionComment($id)
    {
        $model = $this->findModel($id);
        $model->scenario = $model::SCENARIO_COMMENT;
        if ($model->load(Yii::$app->request->post()) && $model->save() && Yii::$app->getRequest()->isAjax) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return [
                "success" => true,
                'apply'   => '$.pjax.reload({container: "#w2-pjax"});',
            ];

        } else {
            return $this->renderAjax('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Finds the Author model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Machine the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Machine::findOne($id)) !== null) {
            return $model;
        } else if (($model = Device::findOne($id)) !== null) {
            return new Machine(['id' => $model->dev_id]);
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
