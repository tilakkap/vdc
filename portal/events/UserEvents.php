<?php
/**
 * Created by PhpStorm.
 * User: Thomas
 * Date: 01.03.16
 * Time: 21:24
 */
namespace app\events;

use app\models\Member;
use app\models\Sale;
use yii\helpers\Url;
use yii\web\ForbiddenHttpException;

class UserEvents
{
    public static function handleAfterLogin($event)
    {
        $session = \Yii::$app->getSession();
        $user = \Yii::$app->user;
        $roles = \Yii::$app->authManager->getRolesByUser($user->getId());

        // check if a session is already open
        if ($session->isActive) {
            //Member is logged in
            if (array_key_exists('Member', $roles)) {
                $member = Member::findOne(['member_username' => $user->identity->username]);
                $session->set("member_ids", [$member->member_id]);
                $session->set('device_ids', $member->getDeviceIds());
                $session->set("home", Url::to(['/site/index']));
                $session->set("login", Url::to(['/site/login']));
                $session->set("profile_id", $member->member_id);
                //Sale is logged in
            } else if (array_key_exists('Sale', $roles)) {
                $sale = Sale::findOne(['sale_username' => $user->identity->username]);
                $session->set('device_ids', $sale->getDeviceIds());
                $session->set('member_ids', $sale->getMemberIds());
                $session->set("home", Url::to(['/site/index']));
                $session->set("login", Url::to(['/site/sale-login']));
                //Admin is logged in
            } else if (array_key_exists('Admin', $roles)) {
                $session->set("member_ids", null);
                $session->set('device_ids', null);
                $session->set("home", Url::to(['/site/admin']));
                $session->set("login", Url::to(['/site/login']));
            }
        }

        //var_dump($event);
        //exit('UserEvents::handleBeforeLogin');
    }
}