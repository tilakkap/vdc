<?php
use \kartik\grid\GridView;
use \kartik\mpdf\Pdf;

//test User AJT13913
$params = require(__DIR__ . '/params.php');

\Yii::$container->set('kartik\form\ActiveForm', [
    'fieldConfig' => [
        'autoPlaceholder' => true,
        'options'         => ['class' => 'form-group form-group-sm'],
    ],
]);

\Yii::$container->set('kartik\grid\GridView', [
    // set export properties
    'export' => [
        'fontAwesome' => true,
        'target'      => GridView::TARGET_SELF,
    ],
    'pager'  => [
        'options' => [
            'class' => 'pagination pagination-sm',
        ],
    ],
]);

\Yii::$container->set('yii\data\Pagination', [
    // set items per page of gridviwew
    'defaultPageSize' => 15,
    //'options',
]);

\Yii::$container->set('kartik\date\DatePicker', [
    'pluginOptions' => [
        'autoclose' => true,
        'format'    => 'dd MM yyyy',
    ],
]);

\Yii::$container->set('yii\widgets\DetailView', [
    'template' => function ($attribute, $index, $widget) {
        if ($attribute['value']) {
            return "<tr><th>{$attribute['label']}</th><td>{$attribute['value']}</td></tr>";
        }
    },
]);


$config = [
    'id'         => 'basic',
    'basePath'   => dirname(__DIR__),
    'bootstrap'  => [
        'log',
        'LanguageSwitcher',
        //'ErrorToolTip',
        'admin',
    ],
    'language'   => 'en',
    'components' => [
        'formatter'        => [
            'class'       => 'yii\i18n\Formatter',
            'nullDisplay' => '',
        ],
        'LanguageSwitcher' => [
            'class' => 'app\components\LanguageSwitcher',
        ],
        'ErrorToolTip'     => [
            'class' => 'hoppe\tooltip\ErrorToolTip',
        ],
        'i18n'             => [
            'translations' => [
                '*'      => [
                    'class'                 => 'yii\i18n\PhpMessageSource',
                    'basePath'              => '@app/messages',
                    'sourceLanguage'        => 'en',
                    'fileMap'               => [
                        'app'         => 'app.php',
                        'app/error'   => 'error.php',
                        'app/member'  => 'member.php',
                        'app/account' => 'account.php',
                        'app/device'  => 'device.php',
                        'app/pdf'     => 'pdf.php',
                        'app/order'   => 'order.php',
                        'app/site'    => 'site.php',
                        'app/payment' => 'payment.php',
                    ],
                    'on missingTranslation' => ['app\components\TranslationEventHandler', 'handleMissingTranslation'],
                ],
                'kvdate' => [
                    'class'          => 'yii\i18n\PhpMessageSource',
                    'sourceLanguage' => 'en',
                    'fileMap'        => [
                        'kvdate' => 'kvdate.php',
                    ],
                ],
                'yii'    => [
                    'class'          => 'yii\i18n\PhpMessageSource',
                    'sourceLanguage' => 'en',
                    'fileMap'        => [
                        'kvdate' => 'yii.php',
                    ],
                ],
            ],
        ],
        'request'          => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => '8bMVq_Dfr_y5DwS8DPtmeOAw_U2-NdoM',
        ],
        'cache'            => [
            'class' => 'yii\caching\FileCache',
        ],
        'user'             => [
            'identityClass'                          => 'app\models\User',
            'enableAutoLogin'                        => true,
            'on ' . \yii\web\User::EVENT_AFTER_LOGIN => ['app\events\UserEvents', 'handleAfterLogin'],
        ],
        'errorHandler'     => [
            'errorAction' => 'site/error',
        ],
        'mailer'           => [
            'class'     => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host'  => 'localhost',
                'port'  => '1025',
            ],
        ],
        'log'              => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets'    => [
                [
                    'class'  => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'urlManager'       => [
            'enablePrettyUrl' => true,
            'rules'           => [
                // your rules go here
            ],
            // ...
        ],
        'authManager'      => [
            'class'    => 'yii\rbac\DbManager',
            'cache'    => 'yii\caching\FileCache',
            'cacheKey' => 'rbac',
        ],
        'assetManager'     => [
            'class'   => 'yii\web\AssetManager',
            'bundles' => [
                'yii\web\JqueryAsset'                => [
                    'js' => [
                        YII_ENV_DEV ? 'jquery.js' : 'jquery.min.js',
                    ],
                ],
                'yii\bootstrap\BootstrapAsset'       => [
                    'css' => [
                        YII_ENV_DEV ? 'css/bootstrap.css' : 'css/bootstrap.min.css',
                    ],
                ],
                'yii\bootstrap\BootstrapPluginAsset' => [
                    'js' => [
                        YII_ENV_DEV ? 'js/bootstrap.js' : 'js/bootstrap.min.js',
                    ],
                ],
                'app\assets\JqueryDotDotDotAsset'    => [
                    'js' => [
                        YII_ENV_DEV ? 'jquery.dotdotdot.js' : 'jquery.dotdotdot..min.js',
                    ],
                ],

            ],
        ],
    ],
    'modules'    => [
        'admin'    => [
            'class'         => 'mdm\admin\Module',
            'userClassName' => 'app\models\User',
        ],
        'gridview' => [
            'class' => '\kartik\grid\Module',
        ],
        //        'datecontrol' => [
        //            'class'              => 'kartik\datecontrol\Module',
        //            'convertAction'      => '/ajax/convert-date-control',
        //
        //            // format settings for displaying each date attribute (ICU format example)
        //            'displaySettings'    => [
        //                Module::FORMAT_DATE => 'dd MMMM yyyy',
        //            ],
        //
        //            // format settings for saving each date attribute (PHP format example)
        //            'saveSettings'       => [
        //                Module::FORMAT_DATE => 'php:U', // saves as unix timestamp
        //            ],
        //
        //            // set your display timezone
        //            //'displayTimezone' => 'Asia/Bangkok',
        //
        //            // set your timezone for date saved to db
        //            //'saveTimezone' => 'UTC',
        //
        //            // automatically use kartik\widgets for each of the above formats
        //            'autoWidget'         => true,
        //
        //            // default settings for each widget from kartik\widgets used when autoWidget is true
        //            'autoWidgetSettings' => [
        //                Module::FORMAT_DATE     => [
        //                    'language'      => \Yii::$app->language,
        //                    //'removeButton' => false,
        //                    'pluginOptions' => [
        //                        'autoclose' => true,
        //                    ],
        //                ], // example
        //                Module::FORMAT_DATETIME => [], // setup if needed
        //                Module::FORMAT_TIME     => [], // setup if needed
        //            ],
        //
        //            // custom widget settings that will be used to render the date input instead of kartik\widgets,
        //            // this will be used when autoWidget is set to false at module or widget level.
        //            // other settings
        //        ],
    ],
    'as access'  => [
        'class'        => 'mdm\admin\classes\AccessControl',
        'allowActions' => [
            'site/*',
            'admin/*',
            'debug/*',
            'gridview/*',
            'gii/*',
            'datecontrol/*',
            'ajax/*',
            'order/*',
            'machine/*',
            'order-status/*',
            '*/back'

            // The actions listed here will be allowed to everyone including guests.
            // So, 'admin/*' should not appear here in the production, of course.
            // But in the earlier stages of your development, you may probably want to
            // add a lot of actions here until you finally completed setting up rbac,
            // otherwise you may not even take a first step.
        ],

    ],
    'aliases'    => [
        'hoppe/tooltip' => '@app/components/ErrorToolTip',
    ],
    'params'     => $params,
];

$db = require(__DIR__ . '/' . gethostname() . '/' . 'server.php');

return $config;
