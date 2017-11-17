<?php

namespace manage\modules\task\controllers;

use common\extensions\Helper;
use manage\modules\task\services\TaskExcelService;
use manage\modules\task\services\TaskService;
use Yii;
use yii\web\Controller;

/**
 * Default controller for the `task` module
 */
class TaskController extends Controller
{

    public function actionTaskList()
    {
        $sort_name = Yii::$app->request->get('sort_name', 'task_id');
        $sort_val = Yii::$app->request->get('sort_val', 'desc');

        $front_user_name = Yii::$app->request->get('front_user_name', '');
        $back_user_name = Yii::$app->request->get('back_user_name', '');

        $front_start_time_from = Yii::$app->request->get('front_start_time_from', '');
        $front_start_time_to = Yii::$app->request->get('front_start_time_to', '');

        $front_end_time_from = Yii::$app->request->get('front_end_time_from', '');
        $front_end_time_to = Yii::$app->request->get('front_end_time_to', '');

        $back_start_time_from = Yii::$app->request->get('back_start_time_from', '');
        $back_start_time_to = Yii::$app->request->get('back_start_time_to', '');

        $back_end_time_from = Yii::$app->request->get('back_end_time_from', '');
        $back_end_time_to = Yii::$app->request->get('back_end_time_to', '');

        $over_time_from = Yii::$app->request->get('over_time_from', '');
        $over_time_to = Yii::$app->request->get('over_time_to', '');

        $search_arr = compact('front_user_name', 'back_user_name', 'front_start_time_from', 'front_start_time_to', 'front_end_time_from', 'front_end_time_to', 'back_start_time_from', 'back_start_time_to', 'back_end_time_from', 'back_end_time_to', 'over_time_from', 'over_time_to');

        $list = TaskService::service()->getTaskList($sort_name, $sort_val, $search_arr);
        $list['search_arr'] = $search_arr;
        return json_encode(Helper::msg(1, '', $list));
    }

    public function actionTaskAdd()
    {
        $post = Yii::$app->request->post();
        if (empty($post['task_name'])) {
            return json_encode(Helper::msg(0, '缺少任务名称'));
        }
        if (empty($post['front_start_time']) || empty($post['front_end_time'])) {
            return json_encode(Helper::msg(0, '缺少前端开发时间'));
        }
        if (empty($post['back_start_time']) || empty($post['back_end_time'])) {
            return json_encode(Helper::msg(0, '缺少后端开发时间'));
        }
        if (empty($post['front_user_id'])) {
            return json_encode(Helper::msg(0, '缺少前端开发人员'));
        }
        if (empty($post['back_user_id'])) {
            return json_encode(Helper::msg(0, '缺少后端开发人员'));
        }
        if (empty($post['task_level'])) {
            return json_encode(Helper::msg(0, '缺少任务困难等级'));
        }

        $res = TaskService::service()->taskAdd($post);
        if ($res) {
            return json_encode(Helper::msg(1, '添加成功', $res));
        }
        return json_encode(Helper::msg(0, '添加失败', $res));
    }

    public function actionTaskLevelList()
    {
        $list = TaskService::service()->getTaskLevelList();
        return json_encode(Helper::msg(1, '', $list));
    }

    public function actionTaskOver()
    {
        $post = Yii::$app->request->post();
        if (empty($post['task_id']) || empty($post['over_time'])) {
            return json_encode(Helper::msg(0, '缺少必要参数'));
        }
        $res = TaskService::service()->taskOver($post);
        return json_encode($res);
    }

    public function actionTaskUpdate()
    {
        $post = Yii::$app->request->post();
        if (empty($post['task_id'])) {
            return json_encode(Helper::msg(0, '缺少必要参数'));
        }
        $res = TaskService::service()->taskUpdate($post);
        return json_encode($res);
    }

    public function actionTaskDel()
    {
        $post = Yii::$app->request->post();
        if (empty($post['task_id'])) {
            return json_encode(Helper::msg(0, '缺少必要参数'));
        }
        $res = TaskService::service()->taskDel($post);
        return json_encode($res);
    }

    public function actionImport()
    {
        if (!isset($_FILES['file']) || empty($_FILES['file'])) {
            return json_encode(Helper::msg(0, '没有接受到文件，请重新上传'));
        }
        $file = $_FILES['file'];
        $res = TaskService::service()->taskImport($file);
        return json_encode($res);
    }

    public function actionExport()
    {
        $request = json_decode(file_get_contents('php://input'));
        $task_id_list = $request->task_id_list;
//        $task_id_list = [84,83];
        if (empty($task_id_list)) {
            return json_encode(Helper::msg(0, '缺少任务ID'));
        }
        if (!is_array($task_id_list)) {
            return json_encode(Helper::msg(0, '参数格式不正确'));
        }
        $res = TaskService::service()->taskExport($task_id_list);
        $excelService = new TaskExcelService();
        //设置表格数据内容
        $objPHPExcel = $excelService->setTaskExportList($res);
        //导出excel文件
        $excelService->exportListToFile($objPHPExcel, '任务列表' . date('Y-m-d'));
    }

}
