<?php

namespace app\models;

use Yii;
use yii\db\Expression;

/**
 * OrderSearch represents the model behind the search form about `app\models\Order`.
 */
class BaseModel extends \yii\db\ActiveRecord
{
    public function DATE_FORMAT($date, $format, $alias)
    {
        return 'DATE_FORMAT('.$date.', REPLACE(\''.$format.'\', \'%Y\', YEAR('.$date.')+' . \Yii::$app->params['languages'][\Yii::$app->language]['yearOffset'] .')) as '.$alias;
    }
}
