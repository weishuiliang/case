<?php

namespace manage\modules\home\services;

use common\extensions\Helper;
use common\models\Log;
use common\services\BaseService;
use Yii;
use yii\data\Pagination;

/**
 * Description of HomeServices
 *
 * @author wsl
 * @data 2017-11-6 9:49:00
 */
class LogService extends BaseService
{
    
    public function getLogList()
    {
        $current_page = Yii::$app->request->get('page', 1);
        $query = Log::find();
        $total_count = $query->count();
        $page = new Pagination(['totalCount' => $total_count, 'pageSize' => 10]);
        $list = $query
                ->offset($page->offset)
                ->limit($page->limit)
                ->asArray()
                ->all();
        foreach ($list as &$val) {
            $val['create_time'] = Helper::toDateTime($val['create_time']);
        }
        return ['currentPage' =>$current_page, 'totalCount' =>$total_count, 'list' =>$list];
    }


}
