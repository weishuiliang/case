<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "oa_role".
 *
 * @property integer $role_id
 * @property string $position
 * @property integer $group_id
 * @property integer $role_type
 * @property integer $create_time
 * @property integer $update_time
 */
class Role extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'oa_role';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['group_id', 'role_type', 'create_time', 'update_time'], 'integer'],
            [['position'], 'string', 'max' => 32],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'role_id' => 'Role ID',
            'position' => 'Position',
            'group_id' => 'Group ID',
            'role_type' => 'Role Type',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
        ];
    }
}
