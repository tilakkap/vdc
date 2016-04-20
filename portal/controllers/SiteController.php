<?php

namespace app\controllers;

use app\components\BaseController;
use app\components\DateHelper;
use app\models\Account;
use app\models\Device;
use app\models\Member;
use app\models\ResetPasswordSmsForm;
use app\models\Sale;
use app\models\SaleDevice;
use app\models\SummaryHome;
use DateInterval;
use DateTime;
use Yii;
use yii\base\InvalidParamException;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\SignupForm;
use app\models\PasswordResetRequestForm;
use app\models\ResetPasswordForm;
use app\models\ChangePasswordForm;
use yii\helpers\Url;
use yii\web\ForbiddenHttpException;
use yii\web\Response;
use yii\widgets\ActiveForm;


class SiteController extends BaseController
{

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only'  => ['logout', 'index'],
                'rules' => [
                    [
                        'actions' => ['logout', 'index'],
                        'allow'   => true,
                        'roles'   => ['@'],
                    ],
                ],
            ],
            'verbs'  => [
                'class'   => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    public function actions()
    {
        return [
            'error'   => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class'           => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionIndex($from_date=null)
    {
        if($from_date){
            $to_date = date_format(date_add(new DateTime($from_date), new DateInterval('P1M')),'Y-m-d');

        } else {
            $from_date = date("Y-m-01");
            $to_date = date("Y-m-t");
        }

        $account = new Account();
        $device = new Device();
        $searchModel = new SummaryHome();
        $searchModel->dev_member = \Yii::$app->getSession()->get("member_ids");
        $searchModel->devices = \Yii::$app->getSession()->get("device_ids");
        $searchModel->from_date = \Yii::$app->formatter->asDate($from_date, DateHelper::getFormat(\Yii::$app->params['languages']));
        $searchModel->to_date = \Yii::$app->formatter->asDate($to_date, DateHelper::getFormat(\Yii::$app->params['languages']));
        $prepaidListTest = $searchModel->prepaidListTest();
        $statusList = $searchModel->statusList();

        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel'     => $searchModel,
            'dataProvider'    => $dataProvider,
            'prepaidListTest' => $prepaidListTest,
            'statusList'      => $statusList,
            'account'         => $account,
            'device'          => $device,
            'from_date'       => $from_date,
        ]);
    }

    public function actionLogin($group='')
    {
        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            if(Yii::$app->user->can('login')) {
                return $this->redirect(\Yii::$app->getSession()->get("home"));
            }
            else {
                throw new ForbiddenHttpException(\Yii::t('yii', 'You are not allowed to perform this action.'));
            }
        }
        return $this->render('login', [
            'model' => $model,
            'group' => $group
        ]);
    }

    public function actionSaleLogin()
    {
        return $this->redirect(['login','group' => 'sale']);
    }

    public function actionLogout()
    {
        $login = \Yii::$app->getSession()->get("login");
        Yii::$app->user->logout();
        return $this->redirect($login);
    }

    public function actionAdmin()
    {
        return $this->render('admin');
    }

    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {
                if (Yii::$app->getUser()->login($user)) {
                    return $this->goHome();
                }
            }
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }


    public function actionResetPasswordSms()
    {
        $model = new ResetPasswordSmsForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            return $this->redirect(['reset-password', 'token' => $model->code]);
        }
        return $this->render('resetPasswordSms', [
            'model' => $model,
        ]);
    }


    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        $model->scenario = $model::SCENARIO_EMAIL;
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->getSession()->setFlash('success', Yii::t('app','Check your email for further instructions.'));
                return $this->redirect('login');
            } else {
                Yii::$app->getSession()->setFlash('error', Yii::t('app','Sorry, we are unable to reset password for email provided.'));
            }
        }
        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    /**
     * @param string $group
     * @return string|Response
     */
    public function actionRequestPasswordResetSms($group='')
    {
        $model = new PasswordResetRequestForm();
        if($group === $model::SCENARIO_SALE){
            $model->scenario = $model::SCENARIO_SALE;
            $view = 'requestPasswordResetTokenSale';
        } else {
            $model->scenario = $model::SCENARIO_SMS;
            $view = 'requestPasswordResetTokenSms';
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendSMS()) {
                Yii::$app->getSession()->setFlash('success', Yii::t('app','Check your sms for further instructions.'));
                return $this->redirect('reset-password-sms');
            } else {
                Yii::$app->getSession()->setFlash('error', Yii::t('app','Sorry, we are unable to reset password for sms provided.'));
            }
        }
        return $this->render($view, [
            'model' => $model,
            'view' => $view,
        ]);
    }

    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }
        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->getSession()->setFlash('success', yii::t('app','New password was saved.'));
            return $this->redirect(\Yii::$app->getSession()->get("home"));
        }
        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }


    public function actionChangePassword()
    {
        $model = new ChangePasswordForm();

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->changePassword()) {
            Yii::$app->getSession()->setFlash('success', yii::t('app','New password was saved.'));
        }
        return $this->render('changePassword', [
            'model' => $model,
        ]);
    }
}
