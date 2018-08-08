<?php
/**
 * 全局助手函数
 * @author wangben
 * @date 2018-07-19
 */

/**
 * 获取logic
 * @author wangben
 */
if (!function_exists('logic')) {
    function logic($name)
    {
        $LogicName = ucfirst($name);
        $class = '\\App\Logics\\' . $LogicName . 'Logic';
        if (class_exists($class)) {
            $logic = $class::getInstance();
        } else {
            $logic = class_exists($class) ? $class::getInstance() : \App\Logics\BaseLogic::getInstance();
        }
        return $logic;
    }
}

/**
 * 获取service
 * @author wangben
 */
if (!function_exists('service')) {
    function service($name)
    {
        $LogicName = ucfirst($name);
        $class = '\\App\Services\\' . $LogicName . 'Service';
        if (class_exists($class)) {
            $logic = $class::getInstance();
        } else {
            $logic = class_exists($class) ? $class::getInstance() : \App\Logics\BaseLogic::getInstance();
        }
        return $logic;
    }
}

/**
 * 获取model
 * @author wangben
 */
if (!function_exists('model')) {
    function model($name)
    {
        $ModelDir = '';
        $ModelName = ucfirst($name);
        $sign = '';
        if (strpos($name, '/') !== false) {
            $arr = explode('/', $name);
            $ModelDir = ucfirst($arr[0]);
            $ModelName = ucfirst($arr[1]);
            $sign = '\\';
        }
        $class = 'App\Models\\' . $ModelDir . $sign . $ModelName;
        if (class_exists($class)) {
            return app($class);
        }
        return false;
    }
}

/**
 * Redis操作类
 * @author wangben
 */
if (!function_exists('redis')) {
    function redis($config = [])
    {
        $config = empty($config) ? (config('database.redis.default') ?: '') : $config;
        return \WbPHPLibraryPackage\Service\Redis::getInstance($config);
    }
}

/**
 * Log
 * @author wangben
 */
if (!function_exists('write_log')) {
    function write_log($message = '', $fileName = 'info', $desc = 'info')
    {
        return \WbPHPLibraryPackage\Service\Log::$fileName($message, $desc);
    }
}

/**
 * successReturn
 * @author wangben
 */
if (!function_exists('successReturn')) {
    function successReturn($data = [], $msg = 'Success')
    {
        return ['code' => 0, 'message' => $msg, 'data' => $data];
    }
}

/**
 * failReturn
 * @author wangben
 */
if (!function_exists('failReturn')) {
    function failReturn($code = 10000, $msg = 'Fail')
    {
        return ['code' => (int) $code, 'message' => $msg, 'data' => []];
    }
}

/**
 * ObjectToArray
 * @author wangben
 */
if (!function_exists('o2a')) {
    function o2a($d)
    {
        if (is_object($d)) {
            if (method_exists($d, 'getArrayCopy')) {
                $d = $d->getArrayCopy();
            } elseif (method_exists($d, 'getArrayIterator')) {
                $d = $d->getArrayIterator()->getArrayCopy();
            } elseif (method_exists($d, 'toArray')) {
                $d = $d->toArray();
            } else {
                $d = get_object_vars($d);
            }
        }
        if (is_array($d)) {
            return array_map(__FUNCTION__, $d);
        }
        return $d;
    }
}

/**
 * 获取分表后缀
 * @author wangben
 */
if (!function_exists('get_tb_num')) {
    function get_tb_num($value, $tbNum = 10)
    {
        if (!$value || is_object($value)) {
            return '';
        }
        if (is_numeric($value)) {
            $num = intval(substr($value, -2));
        } else if (is_string($value)) {
            $num = sprintf("%u", crc32($value));
        }
        return $num % $tbNum;
    }
}

/**
 * 页面跳转
 */
if (!function_exists('redirection')) {
    function redirection($route)
    {
        $route = ltrim($route, '/');
        header('Location: ' . $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . '/' . $route);exit;
    }
}

/**
 * 一维数组键值排序保留键名
 */
if (!function_exists('array_value_sort_with_key')) {
    function array_value_sort_with_key ($arr, $orderby = 'desc') {
        $new_array = [];
        $new_sort  = [];
        $orderby   = strtolower($orderby);
        foreach($arr as $v) {
            $new_array[] = $v;
        }
        if ($orderby == 'asc') {
            asort($new_array);
        } else {
            arsort($new_array);
        }
        foreach ($new_array as $v) {
            foreach ($arr as $kk => $vv) {
                if ($v == $vv) {
                    $new_sort[$kk] = $vv;
                    unset($arr[$kk]);
                    break;
                }
            }
        }
        return $new_sort;
    }
}

/**
 * 字符串无序比较
 */
if (!function_exists('str_disorder_compare')) {
    function str_disorder_compare($str, $target)
    {
        $a = str_split($str);
        $b = str_split($target);
        if (count(array_intersect($a, $b)) == count($a)) {
            return $target;
        }
        return false;
    }
}