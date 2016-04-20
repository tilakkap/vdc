<?php
/*
author :: Pitt Phunsanit
website :: http://plusmagi.com
change language by get language=EN, language=TH,...
or select on this widget
*/

namespace hoppe\tooltip;
use Yii;
use yii\base\Component;
use yii\base\Widget;



class ErrorToolTip extends Widget
{
    public function init()
    {
        if(php_sapi_name() === 'cli')
        {
            return true;
        }

        parent::init();

        $view = $this->getView();


        ErrorToolTipAsset::register($view);
        //\Yii::$app->request->BaseUrl

    }
}