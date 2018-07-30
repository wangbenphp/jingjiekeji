<?php

namespace App\Http\Controllers\Test;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use WbPHPLibraryPackage\Service\Redis;

class IndexController extends Controller
{
    public function index(Request $request)
    {
        //$info = file_get_contents('php://input');
        $info = $request->input('data');
        $res = is_array($info) ? json_encode($info) : (is_string($info) ? $info : json_encode($info));
        $redis = Redis::getInstance();
        $time = time();
        $result = $redis->rpush('jingjiekeji.push.info.' . $time, $res);
        $redis->expire('jingjiekeji.push.info.' . $time, 120);
        var_dump($result);
    }

    public function chuli()
    {
        $str = '{
                    "id": "00f92830",
                    "data": [{
                        "mac": "08:10:79:f3:3b:41",
                        "rssi": "-87",
                        "router": "Yang_luck",
                        "range": "65.2"
                    }, {
                        "mac": "d4:ee:07:53:4a:ea",
                        "rssi": "-83",
                        "router": "PandoraBox",
                        "range": "46.4"
                    }, {
                        "mac": "ec:3d:fd:f9:28:31",
                        "rssi": "-59",
                        "router": "DataSky_f92830",
                        "range": "5.9"
                    }, {
                        "mac": "c8:3a:35:05:58:71",
                        "rssi": "-89",
                        "router": "Tenda_055870",
                        "range": "77.4"
                    }, {
                        "mac": "48:7d:2e:d5:20:7a",
                        "rssi": "-83",
                        "router": "momoda",
                        "range": "46.4"
                    }, {
                        "mac": "c8:e7:d8:2e:82:70",
                        "rssi": "-90",
                        "router": "MERCURY_704",
                        "range": "84.3"
                    }, {
                        "mac": "c8:3a:35:0e:dc:38",
                        "rssi": "-45",
                        "router": "AiryBen",
                        "range": "1.8"
                    }, {
                        "mac": "10:44:00:64:84:70",
                        "rssi": "-90",
                        "router": "大罗金仙殿",
                        "range": "84.3"
                    }, {
                        "mac": "d0:c7:c0:2b:64:70",
                        "rssi": "-85",
                        "router": "lm_520",
                        "range": "55.0"
                    }, {
                        "mac": "50:3a:a0:e3:fb:82",
                        "rssi": "-88",
                        "router": "MERCURY_FB82",
                        "range": "71.0"
                    }, {
                        "mac": "bc:5f:f6:be:02:8a",
                        "rssi": "-87",
                        "router": "603",
                        "range": "65.2"
                    }, {
                        "mac": "bc:46:99:0d:b7:f2",
                        "rssi": "-96",
                        "router": "Q",
                        "range": "140.6"
                    }, {
                        "mac": "94:d9:b3:6a:65:13",
                        "rssi": "-85",
                        "router": "123456789",
                        "range": "55.0"
                    }, {
                        "mac": "8c:be:be:42:37:9e",
                        "rssi": "-83",
                        "router": "Burst_Link",
                        "range": "46.4"
                    }, {
                        "mac": "7c:03:c9:4f:ea:a5",
                        "rssi": "-88",
                        "router": "ChinaNet-Qf6X",
                        "range": "71.0"
                    }, {
                        "mac": "84:74:60:88:92:68",
                        "rssi": "-66",
                        "router": "DuoDuo",
                        "range": "10.8"
                    }, {
                        "mac": "c8:3a:35:1b:27:e0",
                        "rssi": "-93",
                        "router": "wujunxi",
                        "range": "108.9"
                    }, {
                        "mac": "0c:4b:54:4e:16:ad",
                        "rssi": "-93",
                        "tmc": "da:a1:19:0a:59:55",
                        "router": "TP-LINK",
                        "range": "108.9"
                    }, {
                        "mac": "64:09:80:5d:b1:e6",
                        "rssi": "-92",
                        "range": "100.0"
                    }, {
                        "mac": "64:09:80:68:17:cb",
                        "rssi": "-92",
                        "router": "Yrm",
                        "range": "100.0"
                    }, {
                        "mac": "ec:3d:fd:f9:28:30",
                        "rssi": "-7",
                        "rssi1": "-7",
                        "ts": "DuoDuo",
                        "tmc": "84:74:60:88:92:68",
                        "tc": "N",
                        "range": "1.0"
                    }, {
                        "mac": "f4:70:ab:8a:74:b4",
                        "rssi": "-76",
                        "rssi1": "-77",
                        "ts": "DataSky_f92830",
                        "tmc": "ec:3d:fd:f9:28:31",
                        "tc": "N",
                        "range": "25.5"
                    }, {
                        "mac": "54:66:6c:b5:26:30",
                        "rssi": "-90",
                        "router": "ChinaNet-4ZGy",
                        "range": "84.3"
                    }, {
                        "mac": "c0:9f:05:2d:8d:1c",
                        "rssi": "-49",
                        "ts": "DuoDuo",
                        "tmc": "84:74:60:88:92:68",
                        "tc": "Y",
                        "ds": "Y",
                        "range": "2.5"
                    }, {
                        "mac": "8c:ab:8e:bc:63:40",
                        "rssi": "-83",
                        "router": "dd",
                        "range": "46.4"
                    }, {
                        "mac": "ee:d0:9f:3f:56:81",
                        "rssi": "-85",
                        "router": "mqa",
                        "range": "55.0"
                    }, {
                        "mac": "6c:e8:73:85:9d:70",
                        "rssi": "-88",
                        "router": "pixcir",
                        "range": "71.0"
                    }, {
                        "mac": "fc:d7:33:10:a0:04",
                        "rssi": "-92",
                        "router": "偷你妹啊偷",
                        "range": "100.0"
                    }, {
                        "mac": "8c:a6:df:2b:cf:32",
                        "rssi": "-84",
                        "tmc": "4c:32:75:82:c8:ef",
                        "router": "sunshine",
                        "range": "50.5"
                    }, {
                        "mac": "0c:4b:54:34:ee:c2",
                        "rssi": "-94",
                        "router": "djc",
                        "range": "118.5"
                    }],
                    "mmac": "ec:3d:fd:f9:28:30",
                    "rate": "2",
                    "time": "Sun Jul 29 18:12:56 2018",
                    "lat": "22.573488",
                    "lon": "113.862411"
                }';
        $arr = json_decode($str, true);
        echo '<pre>';
        print_r($arr);
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
