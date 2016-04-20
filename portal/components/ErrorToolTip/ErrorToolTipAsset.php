<?php

namespace hoppe\tooltip;
use yii\web\View;
use yii\web\AssetBundle;

/**
 * Asset bundle for ErrorToolTip Widget
 *
 * @author Thomas Hoppe <webhoppe@web.de>
 * @since  1.0
 */
class ErrorToolTipAsset extends AssetBundle
{
    public $sourcePath = '@hoppe/tooltip/assets';

    public $css = [
    ];
    public $js = [
        "js/errortooltip.js"
    ];

    public $depends = [
        'yii\bootstrap\BootstrapPluginAsset'
    ];
}
