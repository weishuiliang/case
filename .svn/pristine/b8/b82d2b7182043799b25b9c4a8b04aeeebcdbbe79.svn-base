<?php

namespace manage\modules\home\controllers;

use common\extensions\Helper;
use common\models\Log;
use common\services\LogService;
use manage\modules\home\services\LoginService;
use Yii;
use yii\web\Controller;

/**
 * Home controller for the `home` module
 */
class LoginController extends Controller
{

    public function actionLogin()
    {
        $post = Yii::$app->request->post();
        if (!isset($post['account']) || !isset($post['pwd']) || empty(trim($post['account'])) || empty(trim($post['pwd']))) {
            return json_encode(Helper::msg(0, '请输入用户名及密码'));
        }
        $res = LoginService::service()->login($post);
        if (is_bool($res)) {
            return json_encode(Helper::msg(1, '登录成功'));
        }
        return json_encode(Helper::msg(0, $res));
    }

    public function actionLoginOut()
    {
        LogService::service()->saveLog($_COOKIE['account'], Log::MODULE_LOGIN, $_COOKIE['account'] . '登出了系统');
        $session = Yii::$app->session;
        $session->destroy();
        Helper::setCookie("user_id", '', 0, '/');
        Helper::setCookie("account", '', 0, '/');
        Helper::setCookie("name", '', 0, '/');
//        $this->redirect(yii::$app->urlManager->createUrl('login/index'));
        return json_encode(Helper::msg(1, '退出成功'));
    }

}
