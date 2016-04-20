<?php
/*
author :: Pitt Phunsanit
website :: http://plusmagi.com
change language by get language=EN, language=TH,...
or select on this widget
*/

namespace app\components;

use Yii;
use yii\base\Component;
use yii\base\Widget;
use yii\bootstrap\ButtonDropdown;
use yii\helpers\Url;
use yii\web\Cookie;

class LanguageSwitcher extends \yii\bootstrap\Widget
{

    public $languages;
    public $asArray = false;

    public function init()
    {
        if(php_sapi_name() === 'cli')
        {
            return true;
        }

        parent::init();

        //echo Yii::$app->getRequest()->getCookies()->getValue('language');
        $this->languages = \Yii::$app->params['languages'];
        $languageNew = Yii::$app->request->get('language');
        if($languageNew)
        {
            if(isset($this->languages[$languageNew]))
            {
                $cookie = new Cookie([
                    'name' => 'language',
                    'value' => $languageNew,
                ]);
                \Yii::$app->getResponse()->getCookies()->add($cookie);
                \Yii::$app->language = $languageNew;
            }
        }
        elseif(\Yii::$app->getRequest()->getCookies()->has('language'))
        {
            \Yii::$app->language = \Yii::$app->getRequest()->getCookies()->getValue('language');
        }
        else {
            \Yii::$app->language = 'th';
        }

        \Yii::$app->formatter->dateFormat = $this->languages[\Yii::$app->language]['dateFormat'];
        \Yii::$app->db1->createCommand('SET lc_time_names = "'.$this->languages[\Yii::$app->language]['LC'].'"')->execute();
        \Yii::$app->db2->createCommand('SET lc_time_names = "'.$this->languages[\Yii::$app->language]['LC'].'"')->execute();
    }

    public function run(){

        $buttonsize = isset($this->options['buttonsize']) ? $this->options['buttonsize']  : 'md';
        $flagsize = isset($this->options['flagsize']) ? $this->options['flagsize']  : 'sm';

        $appendCss = isset($this->options['class']) ? ' ' . $this->options['class'] : '';



        $data =self::getData($flagsize);
        echo ButtonDropdown::widget([
            'label' => $data['label'],
            'encodeLabel' => false,
            'containerOptions'=>[
                'class' => 'languageSwitcher '
            ],
            'options' => [
                'class' => 'btn-'.$buttonsize.' btn-default'
            ],
            'dropdown' => [
                'items' => $data['items'],
                'encodeLabels' => false,
            ],
        ]);

    }

    private static function getData($size="sm"){
        $languages = \Yii::$app->params['languages'];
        unset($languages[Yii::$app->language]);

        $label = '<span class="lang-'.$size.'" lang="'.Yii::$app->language.'"></span>';
        $items = [];

        foreach($languages as $code => $language)
        {
            $temp = [];
            $temp['label'] = '<span class="lang-lbl-full lang-'.$size.'" lang="'.$code.'"></span>';
            $temp['url'] = Url::current(['language' => $code]);
            array_push($items, $temp);
        }
        return [
            'label' => $label,
            'items' => $items,
        ];
    }

    public static function asArray() {
        $data =self::getData();
        return [
            'label' => $data['label'],
            'items' => $data['items'],
            'encodeLabels' => false,
        ];


    }
}