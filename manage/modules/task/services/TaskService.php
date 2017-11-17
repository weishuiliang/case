<?php

namespace manage\modules\task\services;

use common\extensions\Helper;
use common\models\Log;
use common\models\Task;
use common\models\TaskLevel;
use common\models\User;
use common\services\BaseService;
use common\services\LogService;
use PHPExcel_Cell;
use PHPExcel_IOFactory;
use PHPExcel_Shared_Date;
use Yii;
use yii\data\Pagination;

/**
 * Description of TaskService
 *
 * @author wsl
 * @data 2017-11-6 9:49:19
 */
class TaskService extends BaseService
{

    public function getTaskList($sort_name, $sort_val, $search_arr)
    {
        $current_page = Yii::$app->request->get('page', 1);
        $order = $sort_name . ' ' . $sort_val;

        $where[0] = 'and';
        if (!empty($search_arr['front_user_name'])) {
            $where[] = ['like', 'front_user_name', $search_arr['front_user_name']];
        }
        if (!empty($search_arr['back_user_name'])) {
            $where[] = ['like', 'back_user_name', $search_arr['back_user_name']];
        }

        if (!empty($search_arr['front_start_time_from'])) {
            $where[] = ['>=', 'front_start_time', $search_arr['front_start_time_from']];
        }
        if (!empty($search_arr['front_start_time_to'])) {
            $where[] = ['<=', 'front_start_time', $search_arr['front_start_time_to']];
        }

        if (!empty($search_arr['front_end_time_from'])) {
            $where[] = ['>=', 'front_end_time', $search_arr['front_end_time_from']];
        }
        if (!empty($search_arr['front_end_time_to'])) {
            $where[] = ['<=', 'front_end_time', $search_arr['front_end_time_to']];
        }

        if (!empty($search_arr['back_start_time_from'])) {
            $where[] = ['>=', 'back_start_time', $search_arr['back_start_time_from']];
        }
        if (!empty($search_arr['back_start_time_to'])) {
            $where[] = ['<=', 'back_start_time', $search_arr['back_start_time_to']];
        }

        if (!empty($search_arr['back_end_time_from'])) {
            $where[] = ['>=', 'back_end_time', $search_arr['back_end_time_from']];
        }
        if (!empty($search_arr['back_end_time_to'])) {
            $where[] = ['<=', 'back_end_time', $search_arr['back_end_time_to']];
        }

        if (!empty($search_arr['over_time_from'])) {
            $where[] = ['>=', 'over_time', $search_arr['over_time_from']];
            $where[] = ['<>', 'over_time', 0];
        }
        if (!empty($search_arr['over_time_to'])) {
            $where[] = ['<=', 'over_time', $search_arr['over_time_to']];
            $where[] = ['<>', 'over_time', 0];
        }

        $task_query = Task::find()
                ->alias('t')
                ->select('task_id, task_name, t.task_level, l.task_level_name, front_user_id, front_user_name, front_start_time,'
                        . 'front_end_time, front_status,'
                        . 'back_user_id, back_user_name, back_start_time, back_end_time,'
                        . 'back_status, t.create_time, over_time')
                ->leftJoin(['l' => TaskLevel::tableName()], 't.task_level = l.task_level')
                ->andWhere($where);
        $total_count = $task_query->count();
        $page = new Pagination(['totalCount' => $total_count, 'pageSize' => 10]);
        $task_list = $task_query
                ->offset($page->offset)
                ->limit($page->limit)
                ->orderBy($order)
                ->asArray()
                ->all();
        foreach ($task_list as &$val) {
            $val['front_start_time'] = Helper::toDate($val['front_start_time']);
            $val['front_end_time'] = Helper::toDate($val['front_end_time']);
            $val['back_start_time'] = Helper::toDate($val['back_start_time']);
            $val['back_end_time'] = Helper::toDate($val['back_end_time']);
            $val['create_time'] = Helper::toDate($val['create_time']);
            $val['over_time'] = Helper::toDate($val['over_time']);
        }
        return ['currentPage' => $current_page, 'totalCount' => $total_count, 'list' => $task_list];
    }

    public function taskAdd($post)
    {
        $task_model = new Task();
        $task_model->task_name = $post['task_name'];
        $task_model->task_level = isset($post['task_level']) ? $post['task_level'] : Task::LEVEL_EASY;
        $task_model->front_user_id = $post['front_user_id'];
        $task_model->front_user_name = User::find()->select('name')->where(['user_id' =>$post['front_user_id']])->scalar();
        $task_model->back_user_id = $post['back_user_id'];
        $task_model->back_user_name = User::find()->select('name')->where(['user_id' =>$post['back_user_id']])->scalar();
        $task_model->front_start_time = $post['front_start_time'];
        $task_model->front_end_time = $post['front_end_time'];
        $task_model->back_start_time = $post['back_start_time'];
        $task_model->back_end_time = $post['back_end_time'];
        $task_model->create_user = 1;
        $task_model->create_time = time();
        $is_save = $task_model->save();
        if ($is_save) {
            LogService::service()->saveLog($_COOKIE['account'], Log::MODULE_TASK, $_COOKIE['account'] . '新增了任务' . $post['task_name']);
        }
        return $is_save;
    }

    public function getTaskLevelList()
    {
        return TaskLevel::find()->asArray()->all();
    }

    public function taskOver($post)
    {
        $model = Task::findOne(['task_id' => $post['task_id']]);
        if (!$model) {
            return Helper::msg(0, '该任务不存在或已删除');
        }
        if ($model->over_time != 0) {
            return Helper::msg(0, '该任务已结束');
        }
        $model->over_time = $post['over_time'];
        $is_save = $model->save();
        if ($is_save) {
            LogService::service()->saveLog($_COOKIE['account'], Log::MODULE_TASK, $_COOKIE['account'] . '完结了任务' . $model->task_name);
            return Helper::msg(1, '操作成功');
        }
        return Helper::msg(0, '操作失败');
    }

    public function taskUpdate($post)
    {
        $model = Task::findOne(['task_id' => $post['task_id']]);
        $before = $model->toArray();
        if (!$model) {
            return Helper::msg(0, '该任务不存在或已删除');
        }
        if ($model->over_time != 0) {
            return Helper::msg(0, '该任务已结束,不能修改');
        }
        if (isset($post['task_name']) && !empty($post['task_name'])) {
            $model->task_name = $post['task_name'];
        }
        if (isset($post['front_user_id']) && !empty($post['front_user_id'])) {
            $model->front_user_id = $post['front_user_id'];
            $model->front_user_name = User::find()->select('name')->where(['user_id' =>$post['front_user_id']])->scalar();
        }
        if (isset($post['front_start_time']) && !empty($post['front_start_time'])) {
            $model->front_start_time = $post['front_start_time'];
        }
        if (isset($post['front_end_time']) && !empty($post['front_end_time'])) {
            $model->front_end_time = $post['front_end_time'];
        }
        if (isset($post['back_user_id']) && !empty($post['back_user_id'])) {
            $model->back_user_id = $post['back_user_id'];
            $model->back_user_name = User::find()->select('name')->where(['user_id' =>$post['back_user_id']])->scalar();
        }
        if (isset($post['back_start_time']) && !empty($post['back_start_time'])) {
            $model->back_start_time = $post['back_start_time'];
        }
        if (isset($post['back_end_time']) && !empty($post['back_end_time'])) {
            $model->back_end_time = $post['back_end_time'];
        }
        if (isset($post['task_level']) && !empty($post['task_level'])) {
            $model->task_level = $post['task_level'];
        }
        $is_save = $model->save();
        $after = $model->attributes;
        $diff = array_diff($after, $before);
        if ($is_save) {
            LogService::service()->saveLog($_COOKIE['account'], Log::MODULE_TASK, $_COOKIE['account'] . '更新了任务' . $model->task_name, 
                    json_encode($diff));
            return Helper::msg(1, '操作成功');
        }
        return Helper::msg(0, '操作失败');
    }

    public function taskDel($post)
    {
        $model = Task::findOne(['task_id' => $post['task_id']]);
        if (!$model) {
            return Helper::msg(0, '该任务不存在或已删除');
        }
        if ($model->over_time != 0) {
            return Helper::msg(0, '该任务已结束不能删除');
        }
        $is_del = $model->delete();
        if ($is_del) {
            LogService::service()->saveLog($_COOKIE['account'], Log::MODULE_TASK, $_COOKIE['account'] . '删除了任务' . $model->task_name);
            return Helper::msg(1, '删除成功');
        }
        return Helper::msg(0, '删除失败');
    }

    public function taskImport($file)
    {
        include_once(__DIR__ . '/../../../../common/extensions/phpexcel/PHPExcel/IOFactory.php');
        include_once(__DIR__ . '/../../../../common/extensions/phpexcel/PHPExcel/Cell.php');
        $ext_name = pathinfo($file['name'], PATHINFO_EXTENSION);
        if ($ext_name == 'xlsx') {
            $obj_reader = PHPExcel_IOFactory::createReader('Excel2007');
        } elseif ($ext_name == 'xls') {
            $obj_reader = PHPExcel_IOFactory::createReader('Excel5');
        } else {
            return Helper::msg(0, '只支持excel格式,导入失败');
        }
        $tmp_file = $file['tmp_name'];
        $objPHPExcel = (object) $obj_reader->load($tmp_file);  //文件对象
        $objWorksheet = (object) $objPHPExcel->getActiveSheet();
        $highestRow = $objWorksheet->getHighestRow();  //最高行
        $highestColumn = $objWorksheet->getHighestColumn();  //列 A
        $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);  //列 1

        for ($j = 2; $j <= $highestRow; $j++) {
            $task_name = $objWorksheet->getCellByColumnAndRow(0, $j)->getValue();
            $task_level = Helper::toTaskLevel($objWorksheet->getCellByColumnAndRow(1, $j)->getValue());
            $front_user_name = $objWorksheet->getCellByColumnAndRow(2, $j)->getValue();
            $back_user_name = $objWorksheet->getCellByColumnAndRow(3, $j)->getValue();
            $front_start_time = PHPExcel_Shared_Date::ExcelToPHP($objWorksheet->getCellByColumnAndRow(4, $j)->getValue());
            $front_end_time = PHPExcel_Shared_Date::ExcelToPHP($objWorksheet->getCellByColumnAndRow(5, $j)->getValue());
            $back_start_time = PHPExcel_Shared_Date::ExcelToPHP($objWorksheet->getCellByColumnAndRow(6, $j)->getValue());
            $back_end_time = PHPExcel_Shared_Date::ExcelToPHP($objWorksheet->getCellByColumnAndRow(7, $j)->getValue());
            $rows[] = array(
                'task_name' => $task_name,
                'task_level' => $task_level,
                'front_user_name' => $front_user_name,
                'back_user_name' => $back_user_name,
                'front_start_time' => $front_start_time,
                'front_end_time' => $front_end_time,
                'back_start_time' => $back_start_time,
                'back_end_time' => $back_end_time
            );
        }
        $columns = ['task_name', 'task_level', 'front_user_name', 'back_user_name', 'front_start_time',
            'front_end_time', 'back_start_time', 'back_end_time'];
        $insert_suc = \Yii::$app->db->createCommand()->batchInsert(Task::tableName(), $columns, $rows)->execute();
        if ($insert_suc) {
            return Helper::msg(1, '导入成功');
        }
        return Helper::msg(0, '导入失败');
    }

    public function taskExport($task_id_list)
    {
        $list = Task::find()->where(['in', 'task_id', $task_id_list])->asArray()->all();
        return $list;
    }

}
