<?php

namespace App\Http\Controllers\Test;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use WbPHPLibraryPackage\Service\Redis;

class IndexController extends Controller
{
    public function index(Request $request)
    {
        //step1: 接收数据
        $info = $request->input('data');
        //step2: Json to Array
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
                        $this->handels($infos);
                        $redis->del('range.info.by.time.' . $create_time . '.mac:' . $mac);
                    }
                    $redis->expire('range.info.by.time.' . $create_time . '.mac:' . $mac, 60);
                }
            }
        }
    }

    //定位处理
    public function handels($info)
    {
        $data1 = json_decode($info[0], true);
        $data2 = json_decode($info[1], true);
        $data3 = json_decode($info[2], true);
        unset($info);
    }
}
