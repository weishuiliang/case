<?php
namespace common\services;

/**
 * Description of BaseService
 *
 * @author wsl
 * @data 2017-11-6 9:50:58
 */
class BaseService
{
    private static $_instance;

    final public static function service()
    {
        $class = get_called_class();
        if (!isset(self::$_instance[$class]) || !(self::$_instance[$class] instanceof BaseService)) {
            self::$_instance[$class] = new static();
        }
        return self::$_instance[$class];
    }

}
