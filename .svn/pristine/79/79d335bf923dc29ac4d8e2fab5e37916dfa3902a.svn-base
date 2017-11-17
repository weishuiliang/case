<?php

namespace manage\modules\home\controllers;

use common\extensions\Helper;
use manage\modules\home\services\LogService;
use yii\web\Controller;

/**
 * Home controller for the `home` module
 */
class LogController extends Controller
{
    
    public function actionList()
    {
        $list = LogService::service()->getLogList();
        return json_encode(Helper::msg(1, '', $list));
    }


}
