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
                        //$redis->del('range.info.by.time.' . $create_time . '.mac:' . $mac);
                    }
                    $redis->expire('range.info.by.time.' . $create_time . '.mac:' . $mac, 120);
                }
            }
        }
    }

    public function test()
    {
        $data  = [];
        $redis = Redis::getInstance();

        //step2: 处理数据
        $machine_id  = $data['id'];//嗅探器设备 id
        $create_time = substr($data['time'], -13, 8);
        if ($data['data']) {
            foreach ($data['data'] as $k => $v) {
                $redis->hmset('range.info.by.time.' . $create_time . '.mac:' . $v['mac'], [$machine_id => json_encode($data[$k])]);
                $info = $redis->hgetall('range.info.by.time.' . $create_time . '.mac:' . $v['mac']);
                if (count($info) == 3) {
                    //定位计算
                    $redis->del('range.info.by.time.' . $create_time . '.mac:' . $v['mac']);
                }
            }
        }
        //
    }
}
