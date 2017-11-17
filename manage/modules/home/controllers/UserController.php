<?php

namespace manage\modules\home\controllers;

use common\extensions\Helper;
use manage\modules\home\services\UserService;
use Yii;
use yii\web\Controller;

class UserController extends Controller
{

    public function actionUserAdd()
    {
        $post = Yii::$app->request->post();
        if (empty($post['account'])) {
            return json_encode(Helper::msg(0, '缺少账号名称'));
        }
        if (empty($post['name'])) {
            return json_encode(Helper::msg(0, '缺少称呼名称'));
        }
        if (empty($post['mobile'])) {
            return json_encode(Helper::msg(0, '缺少手机号'));
        }
        if (empty($post['role_id'])) {
            return json_encode(Helper::msg(0, '缺少角色ID'));
        }
        if (empty($post['group_id'])) {
            return json_encode(Helper::msg(0, '缺少部门ID'));
        }
        $res = UserService::service()->userAdd($post);
        return json_encode($res);
    }

    public function actionUserList()
    {
        $list = UserService::service()->getUserList();

        return json_encode(Helper::msg(1, '', $list));
    }

    public function actionUserUpdate()
    {
        $post = Yii::$app->request->post();
        if (empty($post['user_id'])) {
            return json_encode(Helper::msg(0, '缺少必要参数'));
        }
//        if (empty($post['name'])) {
//            return json_encode(Helper::msg(0, '缺少称呼名称'));
//        }
//        if (empty($post['mobile'])) {
//            return json_encode(Helper::msg(0, '缺少手机号'));
//        }
//        if (empty($post['role_id'])) {
//            return json_encode(Helper::msg(0, '缺少角色ID'));
//        }
//        if (empty($post['group_id'])) {
//            return json_encode(Helper::msg(0, '缺少部门ID'));
//        }
        $res = UserService::service()->userUpdate($post);
        return json_encode($res);
    }

    public function actionUserDel()
    {
        $post = Yii::$app->request->post();
        if (empty($post['user_id'])) {
            return json_encode(Helper::msg(0, '缺少必要参数'));
        }
        $res = UserService::service()->userDel($post);
        if ($res === true) {
            return json_encode(Helper::msg(1, '删除成功'));
        }
        return json_encode(Helper::msg(0, $res));
    }

    public function actionChangePwd()
    {
        $post = Yii::$app->request->post();
        if (!isset($post['user_id']) || !isset($post['pwd']) || empty(trim($post['user_id'])) || empty(trim($post['pwd']))) {
            return json_encode(Helper::msg(0, '缺少必要参数'));
        }
        $res = UserService::service()->changePwd($post);
        if ($res === true) {
            return json_encode(Helper::msg(1, '修改成功'));
        }
        return json_encode(Helper::msg(0, $res));
    }

    public function actionUserRoleList()
    {
        $role_type = Yii::$app->request->post('role_type');
        if (empty($role_type)) {
            return json_encode(Helper::msg(0, '不支持该类型'));
        }
        $res = UserService::service()->getUserRoleList($role_type);
        return json_encode(Helper::msg(1, '', $res));
    }

}
