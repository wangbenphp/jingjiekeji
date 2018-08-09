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
        $redis  = Redis::getInstance();
        $class  = logic('Gongshi');
        $abcd   = $redis->hgetall('a.b.c.d.xy.info');
        $m_abcd = $abcd[$m_id];
        $db     = logic('Location/Datas');
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
                $redis->hmset('abcd.info.' . $time . '. mac:' . $mac, [$m_abcd => $range]);
                $range_data = $redis->hgetall($key);
                if (count($range_data) == $num) {
                    $rssi_data   = $redis->hgetall($rssi_key);
                    $combination = $this->choose_combination($rssi_data, $abcd);
                    $range_abcd  = $redis->hgetall('abcd.info.' . $time . '. mac:' . $mac);
                    $xy = $this->jisuan($combination, $range_abcd, $class);
                    $db->adds($xy, $mac, $time);
                    $redis->del($key);
                } else {
                    $redis->expire($key, 120);
                    $redis->expire($rssi_key, 120);
                    $redis->expire('abcd.info.' . $time . '. mac:' . $mac, 120);
                }
            }
        }
        return true;
    }

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
    public function choose_combination($rssi_info, $abcd)
    {
        $new_info = array_value_sort_with_key($rssi_info);
        $new_ressi_info = array_keys($new_info);
        $str = $abcd[$new_ressi_info[0]] . $abcd[$new_ressi_info[1]] . $abcd[$new_ressi_info[2]];
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
}