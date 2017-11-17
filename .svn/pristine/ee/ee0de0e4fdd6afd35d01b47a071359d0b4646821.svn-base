<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "oa_task_process".
 *
 * @property integer $process_id
 * @property integer $task_id
 * @property integer $process_user_id
 * @property integer $plan_time
 * @property integer $status
 * @property integer $over_time
 * @property integer $create_time
 */
class TaskProcess extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'oa_task_process';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['task_id', 'process_user_id'], 'required'],
            [['task_id', 'process_user_id', 'plan_time', 'status', 'over_time', 'create_time'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'process_id' => 'Process ID',
            'task_id' => 'Task ID',
            'process_user_id' => 'Process User ID',
            'plan_time' => 'Plan Time',
            'status' => 'Status',
            'over_time' => 'Over Time',
            'create_time' => 'Create Time',
        ];
    }
}
