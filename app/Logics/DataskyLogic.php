<?php

namespace App\Logics;

use WbPHPLibraryPackage\Service\Redis;

/**
 * DataSky 数据处理逻辑
 * @author wangben
 * @date 20180805
 */
class DataskyLogic extends BaseLogic
{
    /**
     * 数据处理
     */
    public function data_dispose($info)
    {
        $data = json_decode($info, true);
        if ($data) {
            $m_id = $data['id'];//嗅探器设备ID
            $time = strtotime(date('Y-m-d ' . substr($data['time'], -13, 8)));//时间戳
            $rate = ($data['rate'] >= 1) ? $data['rate'] : 1;//发送频率
            if ($data['data']) {
                $this->merge($m_id, $rate, $time, $data['data']);
                return true;
            }
        }
        return false;
    }

    /**
     * 数据合并
     */
    private function merge($m_id, $rate, $time, $data, $num = 4)
    {
        $redis = Redis::getInstance();
        $m_xy  = $this->get_m_xy($num);
        foreach ($data as $k => $v) {
            $mac = $v['mac'];
            $range = $v['range'];
            if ($rate == 1) {
                $key = 'datasky.range.info.by.time.' . $time . '.mac:' . $mac;
            } else {
                $create_key = false;
                for ($i = ($time - $rate); $i <= ($time + $rate); $i++) {
                    //step1: 判断key是否存在
                    $step1 = $redis->keys('datasky.range.info.by.time.' . $i . '.mac:' . $mac);
                    if ($step1) {
                        //step2: 判断m_id是否存在
                        $step2 = $redis->hexists($step1[0], $mac);
                        if (!$step2) {
                            $key = 'datasky.range.info.by.time.' . $i . '.mac:' . $mac;
                            break;
                        }
                    } else {
                        $create_key = true;
                    }
                }
                if ($create_key) {
                    $key = 'datasky.range.info.by.time.' . $time . '.mac:' . $mac;
                }
            }
            $redis->hmset($key, [$m_id => $range]);
            $get_data = $redis->hgetall($key);
            if (count($get_data) == $num) {
                $this->xy($get_data, $m_xy, $mac, $time, $num);
                $redis->del($key);
            } else {
                $redis->expire($key, 600);
            }
        }
        return true;
    }

    /**
     * 计算XY
     */
    private function xy($info, $m_xy, $mac, $time, $num)
    {
        $gongshiM = logic('Gongshi');
        $keys_list = array_keys($m_xy);
        if ($num == 4) {
            $ak = $keys_list[0];
            $bk = $keys_list[1];
            $ck = $keys_list[2];
            $dk = $keys_list[3];
            $ax = $m_xy[$ak . '_x'];
            $ay = $m_xy[$ak . '_y'];
            $bx = $m_xy[$bk . '_x'];
            $by = $m_xy[$bk . '_y'];
            $cx = $m_xy[$ck . '_x'];
            $cy = $m_xy[$ck . '_y'];
            $dx = $m_xy[$dk . '_x'];
            $dy = $m_xy[$dk . '_y'];
            $a = $info[$ak];
            $b = $info[$bk];
            $c = $info[$ck];
            $d = $info[$dk];
            $xy = $gongshiM->four($ax, $ay, $bx, $by, $cx, $cy, $dx, $dy, $a, $b, $c, $d);
        } else {
            $ak = $keys_list[0];
            $bk = $keys_list[1];
            $ck = $keys_list[2];
            $ax = $m_xy[$ak . '_x'];
            $ay = $m_xy[$ak . '_y'];
            $bx = $m_xy[$bk . '_x'];
            $by = $m_xy[$bk . '_y'];
            $cx = $m_xy[$ck . '_x'];
            $cy = $m_xy[$ck . '_y'];
            $a = $info[$ak];
            $b = $info[$bk];
            $c = $info[$ck];
            $xy = $gongshiM->three($ax, $ay, $bx, $by, $cx, $cy, $a, $b, $c);
        }
        $this->save_mac_x_y_to_db($mac, $xy['x'], $xy['y'], $time);
        return true;
    }

    private function save_mac_x_y_to_db($mac, $x, $y, $time)
    {
        return model('Location/Datas')->adds($mac, $x, $y, $time);
    }

    /**
     * 获取基站XY坐标
     */
    private function get_m_xy($num = 4)
    {
        if ($num == 4) {
            $key = 'a.b.c.d.x.y.info';
        } else {
            $key = 'a.b.c.x.y.info';
        }
        return Redis::getInstance()->hgetall($key);
    }
}