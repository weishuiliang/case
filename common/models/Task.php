<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "oa_task".
 *
 * @property integer $task_id
 * @property string $task_name
 * @property integer $task_level
 * @property integer $create_user
 * @property integer $create_time
 * @property integer $over_time
 */
class Task extends \yii\db\ActiveRecord
{
    const LEVEL_EASY = 10;
    const LEVEL_NORMAL = 20;   
    const LEVEL_HARD = 30;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'oa_task';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['task_level', 'create_user', 'create_time', 'over_time'], 'integer'],
            [['task_name'], 'string', 'max' => 64],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'task_id' => 'Task ID',
            'task_name' => 'Task Name',
            'task_level' => 'Task Level',
            'create_user' => 'Create User',
            'create_time' => 'Create Time',
            'over_time' => 'Over Time',
        ];
    }
}
