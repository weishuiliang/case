<?php

namespace manage\modules\home\services;

use common\extensions\Helper;
use common\models\Log;
use common\models\User;
use common\services\BaseService;
use common\services\LogService;
use Yii;

/**
 * Description of HomeServices
 *
 * @author wsl
 * @data 2017-11-6 9:49:00
 */
class LoginService extends BaseService
{

    public function login($post)
    {
        $msg = '';
        $user_info = User::findOne(['account' => $post['account']]);
        if (empty($user_info)) {
            return $msg = '该用户不存在';
        }
        if ($user_info['pwd'] !== md5($post['pwd'] . $user_info['salt'])) {
            return $msg = '密码错误,请重试';
        }
        Yii::$app->session->set('user_id', $user_info['user_id']);
        Yii::$app->session->set('account', $user_info['account']);
        Yii::$app->session->set('name', $user_info['name']);

        Helper::setCookie("user_id", json_encode($user_info['user_id']), 0, '/');
        Helper::setCookie("account", json_encode($user_info['account']), 0, '/');
        Helper::setCookie("name", json_encode($user_info['name']), 0, '/');

        $user_info['last_login_time'] = time();
        $user_info->save();
        
        LogService::service()->saveLog($user_info['account'], Log::MODULE_LOGIN, $user_info['account'] . '登录了系统');
        return true;
    }

}
