<?php

namespace App\Logics;

use WbPHPLibraryPackage\Service\Redis;

/**
 * 核心数据处理
 * @author wangben
 * @date 20180808
 */
class CalculateLogic extends BaseLogic
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
        $m_id = $data['id'];//嗅探器设备ID
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
        $m_xy  = $this->get_m_xy($num);
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
                $range_data = $redis->hgetall($key);
                if (count($range_data) == $num) {
                    $rssi_data = $redis->hgetall($rssi_key);
                    $this->xy($range_data, $m_xy, $mac, $time, $num);
                    $redis->del($key);
                    $redis->del($rssi_key);
                } else {
                    $redis->expire($key, 120);
                    $redis->expire($rssi_key, 120);
                }
            }
        }
        return true;
    }

    /**
     * 选择组合
     */
    public function choose_combination($rssi_info)
    {
        $new_ressi_info = array_value_sort_with_key($rssi_info);
        $str = $new_ressi_info[0] . $new_ressi_info[1] . $new_ressi_info[2];
    }
}