<?php
namespace app\components;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use app\assets\JqueryDotDotDotAsset;

class BaseController extends Controller
{
    public function init() {
        parent::init();
        JqueryDotDotDotAsset::register($this->view);
    }
    
    public function actionBack() {
        return parent::goBack(Yii::$app->request->referrer);
        
    }
}