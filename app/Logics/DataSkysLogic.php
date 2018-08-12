<?php

namespace App\Logics;

use WbPHPLibraryPackage\Service\Redis;

/**
 * DataSky 数据处理逻辑
 * @author wangben
 * @date 20180812
 */
class DataSkysLogic extends BaseLogic
{
    /**
     * 数据分类处理
     */
    public function classify($data)
    {
        if (!$data) {
            return false;
        }
        $data = json_decode($data, true);
        if (!is_array($data)) {
            return false;
        }
        $abcd_m_id = Redis::getInstance()->hgetall('a.b.c.d.xy.info');
        $m_id = $abcd_m_id[$data['id']];//嗅探器设备ID转换成abcd
        $time = strtotime(date('Y-m-d ' . substr($data['time'], -13, 8)));//时间戳
        $rate = ($data['rate'] >= 1) ? $data['rate'] : 1;//发送频率
        if (isset($data['data']) && $data['data']) {
            $this->merge($m_id, $rate, $time, $data['data'], 4);
            return true;
        }
    }

    /**
     * 数据合并
     */
    private function merge($m_id, $rate, $time, $data, $num = 4)
    {
        $redis = Redis::getInstance();
        foreach ($data as $k => $v) {
            $range = $v['range'];
            if ($range <= 5.65) {
                $mac  = $v['mac'];//手机MAC地址
                $rssi = $v['rssi'];//信号强度
                if ($rate != 1) {
                    for ($i = ($time - $rate); $i <= ($time + $rate); $i++) {
                        //step1: 判断key是否存在
                        $step1 = $redis->keys('datasky.range.info.by.time.' . $i . '.mac:' . $mac);
                        if ($step1) {
                            //step2: 判断m_id是否存在
                            $step2 = $redis->hexists($step1[0], $mac);
                            if (!$step2) {
                                $time = $i;
                                break;
                            }
                        }
                    }
                }
                $key      = 'datasky.range.info.by.time.' . $time . '.mac:' . $mac;
                $rssi_key = 'datasky.range.info.by.time.' . $time . '.ressi.mac:' . $mac;
                $redis->hmset($key, [$m_id => $range]);
                $redis->hmset($rssi_key, [$m_id => $rssi]);
                $data_len = $redis->hlen($key);
                if ($data_len == $num) {
                    $this->full_range_to_queue($time, $mac, $redis);//加入计算XY的队列
                } else {
                    $redis->expire($key, 120);
                    $redis->expire($rssi_key, 120);
                }
            }
        }
        return true;
    }

    /**
     * 把XY坐标加入队列存入DB
     */
    private function xy_to_queue($xy, $mac, $time, $redis)
    {
        $data = json_encode(['x' => $xy['x'], 'y' => $xy['y'], 'mac' => $mac, 'time' => $time]);
        return $redis->rpush('xy.info.list.queue', $data);
    }

    /**
     * 把收集到4个macid的range值存入队列
     */
    private function full_range_to_queue($time, $mac, $redis)
    {
        $data = $time . '-' . $mac;
        return $redis->rpush('full.range.get.info.list', $data);
    }

    /**
     * 计算出XY坐标
     */
    private function jisuan($combination, $range_data, $class, $l = 4)
    {
        $a = $range_data['a'];
        $b = $range_data['b'];
        $c = $range_data['c'];
        $d = $range_data['d'];
        $xy = call_user_func_array([$class, $combination], [$a, $b, $c, $d, $l]);
        return $xy;
    }

    /**
     * 选择组合
     */
    private function choose_combination($rssi_info)
    {
        $new_info = array_value_sort_with_key($rssi_info);
        $new_ressi_info = array_keys($new_info);
        $str = $new_ressi_info[0] . $new_ressi_info[1] . $new_ressi_info[2];
        $string = str_disorder_compare($str, 'abc');
        if (!$string) {
            $string = str_disorder_compare($str, 'bcd');
            if (!$string) {
                $string = str_disorder_compare($str, 'cda');
                if (!$string) {
                    $string = str_disorder_compare($str, 'dac');
                }
            }
        }
        return $string;
    }

    /**
     * 定时任务队列toDB
     */
    public function xy_to_db($num = 20)
    {
        $redis = Redis::getInstance();
        $lens  = $redis->llen('xy.info.list.queue');
        if ($lens) {
            $db = model('Location/Datas');
            for ($i = 1; $i <= $num; $i++) {
                $info = $redis->lpop('xy.info.list.queue');
                if (!$info) {
                    break;
                }
                $data = json_decode($info, true);
                $db->timer($data['x'], $data['y'], $data['mac'], $data['time']);
            }
            return true;
        }
        return false;
    }

    public function data_to_xy_to_queue($num = 20)
    {
        $redis = Redis::getInstance();
        $lens  = $redis->llen('full.range.get.info.list');
        if ($lens) {
            $class = logic('Gongshi');
            for ($i = 1; $i <= $num; $i++) {
                $info = $redis->lpop('full.range.get.info.list');
                if (!$info) {
                    break;
                }
                $data     = explode('-', $info);
                $key      = 'datasky.range.info.by.time.' . $data[0] . '.mac:' . $data[1];
                $rssi_key = 'datasky.range.info.by.time.' . $data[0] . '.ressi.mac:' . $data[1];
                $range_data  = $redis->hgetall($key);
                $redis->del($key);
                $rssi_data   = $redis->hgetall($rssi_key);
                $combination = $this->choose_combination($rssi_data);//根据信号强弱判断出组合：abc,bcd,cda,dac
                $xy = $this->jisuan($combination, $range_data, $class);
                $this->xy_to_queue($xy, $data[1], $data[0], $redis);
            }
            return true;
        }
        return false;
    }
}