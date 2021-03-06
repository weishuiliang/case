<?php

namespace manage\modules\home\controllers;

use common\extensions\Helper;
use manage\modules\home\services\GroupService;
use Yii;
use yii\web\Controller;

/**
 * Description of GroupController
 *
 * @author wsl
 * @data 2017-11-6 11:46:49
 */
class GroupController extends Controller
{

    public function actionGroupList()
    {
        $is_page = Yii::$app->request->get('is_page', 1);

        $list = GroupService::service()->getGroupList($is_page);

        return json_encode(Helper::msg(1, '', $list));
    }

    /**
     * @name 获取所有部门
     * @return array
     */
    public function actionGroupAll()
    {
        $list = GroupService::service()->getGroupAll();
        return json_encode(Helper::msg(1, '', $list));
    }

    public function actionSonGroupList()
    {
        $group_id = Yii::$app->request->post('group_id');
        if (empty($group_id)) {
            return json_encode(Helper::msg(0, '缺少部门名称'));
        }
        $list = GroupService::service()->getSonGroupList($group_id);

        return json_encode(Helper::msg(1, '', $list));
    }

    public function actionGroupAdd()
    {
        $post = Yii::$app->request->post();
        if (empty($post['group_name'])) {
            return json_encode(Helper::msg(0, '缺少部门名称'));
        }
        $res = GroupService::service()->groupAdd($post);
        return json_encode($res);
    }

    public function actionGroupEdit()
    {
        $post = Yii::$app->request->post();
        if (empty($post['group_id']) || empty($post['group_name'])) {
            return json_encode(Helper::msg(0, '缺少必要参数'));
        }
        $res = GroupService::service()->groupEdit($post);
        return json_encode($res);
    }

    public function actionGroupDel()
    {
        $post = Yii::$app->request->post();
        if (empty($post['group_id'])) {
            return json_encode(Helper::msg(0, '缺少必要参数'));
        }
        $res = GroupService::service()->groupDel($post);
        return json_encode($res);
    }

}
