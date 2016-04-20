<?php

/**
 * @package   yii2-datecontrol
 * @author    Kartik Visweswaran <kartikv2@gmail.com>
 * @copyright Copyright &copy; Kartik Visweswaran, Krajee.com, 2014 - 2015
 * @version   1.9.4
 */

namespace app\controllers;

use DateTimeZone;
use Yii;
use yii\helpers\Json;
use yii\helpers\ArrayHelper;
use kartik\datecontrol\Module;
use kartik\datecontrol\DateControl;

class AjaxController extends \yii\web\Controller
{
    /**
     * Convert display date for saving to model
     *
     * @return string JSON encoded HTML output
     */
    public function actionConvertDateControl()
    {
        $output = '';
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $post = Yii::$app->request->post();
        if (isset($post['displayDate'])) {
            $saveFormat = ArrayHelper::getValue($post, 'saveFormat');
            $dispFormat = ArrayHelper::getValue($post, 'dispFormat');
            $dispTimezone = ArrayHelper::getValue($post, 'dispTimezone');
            $saveTimezone = ArrayHelper::getValue($post, 'saveTimezone');
            $settings = ArrayHelper::getValue($post, 'settings', []);
            $date = DateControl::getTimestamp($post['displayDate'], $dispFormat, $dispTimezone, $settings);
            if (empty($date) || !$date) {
                $value = '';
            } elseif ($saveTimezone != null) {

                $value = $date->setTimezone(new DateTimeZone($saveTimezone))->format($saveFormat);
            } else {
                //$date->sub(new \DateInterval('P543Y'));
                $value = $date->format($saveFormat);
            }
            return ['status' => 'success', 'output' => $value];
        } else {
            return ['status' => 'error', 'output' => 'No display date found'];
        }
    }
}