<?php
/**
 * Created by PhpStorm.
 * User: Thomas
 * Date: 05.02.16
 * Time: 12:45
 */

namespace app\components;


use yii\i18n\MissingTranslationEvent;

class TranslationEventHandler
{
    public static function handleMissingTranslation(MissingTranslationEvent $event) {
        if (YII_ENV_DEV) {
            $event->translatedMessage = "@MISSING: {$event->category}.{$event->message} FOR LANGUAGE {$event->language} @";
        }
    }
}