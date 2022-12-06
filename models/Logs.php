<?php

namespace app\models;

/**
 * This is the model class for table "logs".
 */
class Logs extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    /**
     * @inheritdoc
     */

    public $search_keyword;

    public static function tableName()
    {
        return 'logs';
    }
    public function rules()
    {
        return array_replace_recursive(parent::rules(),
	    [
            [['level', 'category', 'prefix', 'message'], 'string'],
            [['log_time'], 'safe'],
            [['user_email'], 'string', 'max' => 255],
            [['lock'], 'default', 'value' => '0'],
            [['lock'], 'mootensai\components\OptimisticLockValidator']
        ]);
    }
	
}
