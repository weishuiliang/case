<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "oa_group".
 *
 * @property integer $group_id
 * @property integer $pid
 * @property string $group_name
 * @property integer $create_user
 * @property integer $is_del
 * @property integer $create_time
 * @property integer $update_time
 */
class Group extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'oa_group';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['pid', 'create_user', 'is_del', 'create_time', 'update_time'], 'integer'],
            [['group_name'], 'string', 'max' => 64],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'group_id' => 'Group ID',
            'pid' => 'Pid',
            'group_name' => 'Group Name',
            'create_user' => 'Create User',
            'is_del' => 'Is Del',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
        ];
    }
}
