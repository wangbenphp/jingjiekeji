<?php

namespace App\Http\Controllers\Test;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use WbPHPLibraryPackage\Service\Redis;
use Illuminate\Support\Facades\DB;

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
                        $get_x_y = $redis->hgetall('a.b.c.x.y.info');
                        $this->handels($infos, $get_x_y, $create_time);
                        $redis->del('range.info.by.time.' . $create_time . '.mac:' . $mac);
                    }
                    $redis->expire('range.info.by.time.' . $create_time . '.mac:' . $mac, 60);
                }
            }
        }
    }

    /**
     * 定位处理
     * 1 a
     * 2 b
     * 3 c
     */
    public function handels($info, $get_x_y, $time)
    {
        $a = json_decode($info['00f9282e'], true);
        $b = json_decode($info['00f92830'], true);
        $c = json_decode($info['00f9282f'], true);
        unset($info);
        $mac = $a['mac'];

        ///////////////////////////

        $a_x = $get_x_y['a_x'];//x1
        $a_y = $get_x_y['a_y'];//y1
        $b_x = $get_x_y['b_x'];//x2
        $b_y = $get_x_y['b_y'];//y2
        $c_x = $get_x_y['c_x'];//x3
        $c_y = $get_x_y['c_y'];//y3
        $a_r = $a['range'];//r1
        $b_r = $b['range'];//r2
        $c_r = $c['range'];//r3

        $A = ($a_r*$a_r-$b_r*$b_r-$a_x*$a_x-$a_y*$a_y+$b_x*$b_x+$b_y*$b_y)/2;
        $B = ($a_r*$a_r-$c_r*$c_r-$a_x*$a_x-$a_y*$a_y+$c_x*$c_x+$c_y*$c_y)/2;
        $X = ($A*($c_y-$a_y) - $B*($b_y-$a_y)) / (($b_x-$a_x) * ($c_y-$a_y) - ($c_x-$a_x) * ($b_y-$a_y));
        $Y = ($A*($c_x-$a_x) - $B*($b_x-$a_x)) / (($b_y-$a_y) * ($c_x-$a_x) - ($c_y-$a_y) * ($b_x-$a_x));

        $redis = Redis::getInstance();
        $redis->hmset($time . $mac, ['x' => $X, 'y' => $Y]);
        $redis->expire($time . $mac, 1200);
        $time = time();
        DB::table('test')->insert([
            'mac'         => $mac,
            'x'           => $X,
            'y'           => $Y,
            'create_time' => $time
        ]);
        DB::table('test1')->insert([
            'mac'         => $mac,
            'a'           => $a_r,
            'b'           => $b_r,
            'c'           => $c_r,
            'create_time' => $time
        ]);
        return true;
    }

    /**
     * 设置坐标
     * A 00f9282e
     * B 00f92830
     * C 00f9282f
     */
    public function setting(Request $request)
    {
        $a_x = $request->input('a_x');
        $a_y = $request->input('a_y');
        $b_x = $request->input('b_x');
        $b_y = $request->input('b_y');
        $c_x = $request->input('c_x');
        $c_y = $request->input('c_y');
        if (!is_numeric($a_x) || !is_numeric($a_y) || !is_numeric($b_x) || !is_numeric($b_y) || !is_numeric($c_x) || !is_numeric($c_y)) {
            echo '参数不合法';exit;
        }
        $res = Redis::getInstance()->hmset('a.b.c.x.y.info', [
            'a_x' => $a_x,
            'a_y' => $a_y,
            'b_x' => $b_x,
            'b_y' => $b_y,
            'c_x' => $c_x,
            'c_y' => $c_y,
        ]);
        print_r($res);
    }
}
