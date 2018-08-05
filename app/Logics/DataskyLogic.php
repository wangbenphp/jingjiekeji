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
    public function data_dispose($info, $frequency)
    {
        $data = json_decode($info, true);
        if ($data) {
            $redis = Redis::getInstance();
            //step3: 处理数据
            $machine_id  = $data['id'];//嗅探器设备 id
            $create_time = str_replace(':', '', substr($data['time'], -13, 8));
            if ($data['data']) {
                foreach ($data['data'] as $k => $v) {
                    $mac = str_replace(':', '', $v['mac']);
                    $redis->hmset('range.info.by.time.' . $create_time . '.mac:' . $mac, [$machine_id => json_encode($data['data'][$k])]);
                    $infos = $redis->hgetall('range.info.by.time.' . $create_time . '.mac:' . $mac);
                    if (count($infos) == 3) {
                        //定位计算
                        $get_x_y = $redis->hgetall('a.b.c.x.y.info');
                        $this->handels($infos, $get_x_y, $create_time);
                        $redis->del('range.info.by.time.' . $create_time . '.mac:' . $mac);
                    }
                    $redis->expire('range.info.by.time.' . $create_time . '.mac:' . $mac, 60);
                }
            }
        }
    }
}