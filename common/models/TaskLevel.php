<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "oa_task_level".
 *
 * @property integer $level_id
 * @property integer $task_level
 * @property string $task_level_name
 * @property integer $create_time
 */
class TaskLevel extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'oa_task_level';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['task_level', 'create_time'], 'integer'],
            [['task_level_name'], 'string', 'max' => 64],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'level_id' => 'Level ID',
            'task_level' => 'Task Level',
            'task_level_name' => 'Task Level Name',
            'create_time' => 'Create Time',
        ];
    }
}
