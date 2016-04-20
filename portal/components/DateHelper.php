<?php
/**
 * Created by PhpStorm.
 * User: Thomas
 * Date: 10.03.16
 * Time: 09:20
 */

namespace app\components;

use DateTime;
use DateTimeZone;
use Yii;
use yii\helpers\FormatConverter;

class DateHelper
{
    /**
     * @var array the english date settings
     */
    private static $_enSettings = [
        'days' => ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'],
        'daysShort' => ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'],
        'months' => [
            'January', 'February', 'March', 'April', 'May', 'June', 'July',
            'August', 'September', 'October', 'November', 'December'
        ],
        'monthsShort' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
        'meridiem' => ['AM', 'PM']
    ];
    /**
     * Parses and normalizes a date source and converts it to a DateTime object
     * by parsing it based on specified format.
     * @param string $source the date source pattern
     * @param string $format the date format
     * @param string $timezone the date timezone
     * @param string $settings the locale/language date settings
     * @return DateTime object
     */
    public static function getTimestamp($source, $languageSettings, $language = null)
    {
        if (empty($source)) {
            return null;
        }

        $format = $languageSettings[\Yii::$app->language]['dateFormat'];
        $timezone = $languageSettings[\Yii::$app->language]['timezone'];
        $settings = $languageSettings[\Yii::$app->language]['dateSettings'];
        $yearOffset = $languageSettings[\Yii::$app->language]['yearOffset'];

        $format = FormatConverter::convertDateIcuToPhp($format);
        $source = static::parseLocale($source, $format, $settings);
        if (substr($format, 0, 1) !== '!') {
            $format = '!' . $format;
        }
        if ($timezone != null) {
            $date = DateTime::createFromFormat($format, $source, new DateTimeZone($timezone));
        } else {
            $date = DateTime::createFromFormat($format, $source);
        }
        if($yearOffset > 0) {
            $date->sub(new \DateInterval('P'.$yearOffset.'Y'));
        }
        if($date !== false) {
            return $date->format('U');
        }
        return false;
    }

    /**
     * @return String
     */
    public static function getFormat($languageSettings)
    {
        return $languageSettings[\Yii::$app->language]['dateFormat'];
    }

    /**
     * Parses locale data and returns an english format
     * @param string $source the date source pattern
     * @param string $format the date format
     * @param string $settings the locale/language date settings
     * @return the converted date source to english
     */
    protected static function parseLocale($source, $format, $settings = [])
    {
        if (empty($settings)) {
            return $source;
        }

        foreach (self::$_enSettings as $key => $value) {
            if (!empty($settings[$key]) && static::checkFormatKey($format, $key)) {
                $source = str_ireplace($settings[$key], $value, $source);
            }
        }
        return $source;
    }

    /**
     * Checks if the format string contains the relevant date format
     * pattern based on the passed key.
     * @param string $format the date format string
     * @param string $key the key to check
     * @return boolean
     */
    protected static function checkFormatKey($format, $key)
    {
        switch ($key) {
            case 'months':
                return strpos($format, 'F') !== false;
            case 'monthsShort':
                return strpos($format, 'M') !== false;
            case 'days':
                return strpos($format, 'l') !== false;
            case 'daysShort':
                return strpos($format, 'D') !== false;
            case 'meridiem':
                return stripos($format, 'A') !== false;
            default:
                return false;
        }
    }
}