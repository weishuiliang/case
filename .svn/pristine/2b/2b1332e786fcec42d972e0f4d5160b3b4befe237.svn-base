<?php

namespace common\services;

use common\models\Log;
use Yii;

/**
 * Description of LogService
 *
 * @author wsl
 * @data 2017-11-15 11:38:33
 */
class LogService extends BaseService
{

    public function saveLog($action_user, $module, $title, $detail='')
    {
        $model = new Log();
        $model->action_user = $action_user;
        $model->module = $module;
        $model->log_title = $title;
        $model->log_detail = empty($detail) ? $title : $detail;
        $model->ip = empty(Yii::$app->request->userIP) ? '127.0.0.1' : Yii::$app->request->userIP;
        $model->create_time = time();
        $model->save();
    }

}
