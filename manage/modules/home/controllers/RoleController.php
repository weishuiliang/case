<?php

namespace manage\modules\home\controllers;

use common\extensions\Helper;
use manage\modules\home\services\RoleService;
use Yii;
use yii\web\Controller;

/**
 * Description of RoleController
 *
 * @author wsl
 * @data 2017-11-9 15:02:17
 */
class RoleController extends Controller
{

    /**
     * @name 
     * @author wsl
     * @data 2017-11-9 15:02:17
     */
    public function actionList()
    {
        $list = RoleService::service()->getRoleList();
        return json_encode(Helper::msg(1, '', $list));
    }

    public function actionAdd()
    {
        $post = Yii::$app->request->post();
        if (empty($post['group_id'])) {
            return json_encode(Helper::msg(0, '缺少组织ID'));
        }
        if (empty($post['position'])) {
            return json_encode(Helper::msg(0, '缺少职位名称'));
        }
        $res = RoleService::service()->roleAdd($post);
        if ($res) {
            return json_encode(Helper::msg(1, '添加成功', $res));
        }
        return json_encode(Helper::msg(0, '添加失败'));
    }

    public function actionGroupPositionList()
    {
        $post = Yii::$app->request->post();
        if (empty($post['group_id'])) {
            return json_encode(Helper::msg(0, '缺少组织ID'));
        }
        $res = RoleService::service()->getGroupPositionList($post['group_id']);
        return json_encode(Helper::msg(1, '', $res));
    }

    public function actionUpdate()
    {
        $post = Yii::$app->request->post();
        if (empty($post['group_id'])) {
            return json_encode(Helper::msg(0, '缺少组织ID'));
        }
        if (empty($post['role_id'])) {
            return json_encode(Helper::msg(0, '缺少角色ID'));
        }
        if (empty($post['position'])) {
            return json_encode(Helper::msg(0, '缺少职位名称'));
        }
        $res = RoleService::service()->roleUpdate($post);
        return json_encode($res);
    }

    public function actionDel()
    {
        $role_id = Yii::$app->request->post('role_id');
        if (empty($role_id)) {
            return json_encode(Helper::msg(0, '缺少角色ID'));
        }
        $res = RoleService::service()->roleDel($role_id);
        return json_encode($res);
    }

}
