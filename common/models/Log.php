<?php

namespace common\models;

/**
 * This is the model class for table "oa_log".
 *
 * @property integer $log_id
 * @property string $action_user
 * @property string $module
 * @property string $log_title
 * @property string $log_detail
 * @property string $ip
 * @property integer $create_time
 */
class Log extends \yii\db\ActiveRecord
{
    const MODULE_LOGIN = 'login';
    const MODULE_GROUP = 'group';
    const MODULE_ROLE = 'role';
    const MODULE_USER = 'user';
    const MODULE_TASK = 'task';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'oa_log';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['log_title', 'log_detail'], 'string'],
            [['create_time'], 'integer'],
            [['action_user', 'module'], 'string', 'max' => 20],
            [['ip'], 'string', 'max' => 15],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'log_id' => 'Log ID',
            'action_user' => 'Action User',
            'module' => 'Module',
            'log_title' => 'Log Title',
            'log_detail' => 'Log Detail',
            'ip' => 'Ip',
            'create_time' => 'Create Time',
        ];
    }
}
