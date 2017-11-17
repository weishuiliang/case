<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "oa_user".
 *
 * @property integer $user_id
 * @property string $account
 * @property string $pwd
 * @property string $salt
 * @property string $name
 * @property string $user_sn
 * @property string $avatar
 * @property string $mobile
 * @property integer $role_id
 * @property integer $group_id
 * @property integer $last_login_time
 * @property integer $is_del
 * @property integer $create_time
 * @property integer $update_time
 */
class User extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'oa_user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['role_id', 'group_id', 'last_login_time', 'is_del', 'create_time', 'update_time'], 'integer'],
            [['group_id'], 'required'],
            [['account'], 'string', 'max' => 64],
            [['pwd', 'name', 'user_sn'], 'string', 'max' => 32],
            [['salt'], 'string', 'max' => 8],
            [['avatar'], 'string', 'max' => 128],
            [['mobile'], 'string', 'max' => 11],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'user_id' => 'User ID',
            'account' => 'Account',
            'pwd' => 'Pwd',
            'salt' => 'Salt',
            'name' => 'Name',
            'user_sn' => 'User Sn',
            'avatar' => 'Avatar',
            'mobile' => 'Mobile',
            'role_id' => 'Role ID',
            'group_id' => 'Group ID',
            'last_login_time' => 'Last Login Time',
            'is_del' => 'Is Del',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
        ];
    }
}
