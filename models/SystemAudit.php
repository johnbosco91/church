<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "system_audit".
 *
 * @property integer $auditId
 * @property integer $userId
 * @property string $action
 * @property string $date
 * @property string $data_change
 */
class SystemAudit extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'system_audit';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['userId', 'action'], 'required'],
            [['userId'], 'integer'],
            [['date', 'data_change'], 'safe'],
            [['action'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'auditId' => 'Audit ID',
            'userId' => 'User ID',
            'action' => 'Action',
            'date' => 'Date',
            'data_change' => 'Data Changed',
        ];
    }
}
