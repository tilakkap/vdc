<?php
/**
 * Created by PhpStorm.
 * User: Thomas
 * Date: 18.03.16
 * Time: 09:17
 */
namespace app\assets;

use yii\web\AssetBundle;

class JqueryDotDotDotAsset extends AssetBundle {

    public $sourcePath = '@vendor/bower/jquery.dotdotdot/src/';

    public $js = [
        'jquery.dotdotdot.js',
    ];

    public $depends = [
        'yii\web\JqueryAsset'
    ];
}