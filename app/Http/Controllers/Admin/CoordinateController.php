<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CoordinateController extends Controller
{
    public function get(Request $request)
    {
        $num = mt_rand(40, 60);
        for ($i=0; $i<$num; $i++) {
            $data[] = ['x' => mt_rand(0, 400), 'y' => mt_rand(0, 400)];
        }
        return response()->json(successReturn($data));
    }

    public function one_old(Request $request)
    {
        $num = mt_rand(60, 6000);
        $bl  = sprintf("%.2f", (100 / $num));
        $bili = 0;
        for ($i=0; $i<$num; $i++) {
            if ($i == 0) {
                $bili = '0';
            } else if ($i == ($num - 1)) {
                $bili = '100';
            } else {
                $bili += $bl;
            }
            $data['time'] = mt_rand(20, 100);
            $data['list'][] = ['x' => mt_rand(0, 400) . 'px', 'y' => mt_rand(0, 400) . 'px', 'bili' => $bili . '%'];
        }
        return response()->json(successReturn($data));
    }

    public function one(Request $request)
    {
        //$mac = $request->input('mac');
        $times = $request->input('times') > 0 ? $request->input('times') : 20;
        //$start_time = $request->input('start_time') ? strtotime($request->input('start_time')) : null;
        //$end_time = $request->input('end_time') ? strtotime($request->input('end_time')) : null;

        $anim = 'anims' . time() . mt_rand(100, 999);
        $num = mt_rand(60, 100);
        $bl  = sprintf("%.2f", (100 / $num));
        $bili = 0;
        $str = '@keyframes ' . $anim . '{';
        for ($i=0; $i<$num; $i++) {
            if ($i == 0) {
                $bili = '0';
            } else if ($i == ($num - 1)) {
                $bili = '100';
            } else {
                $bili += $bl;
            }
            $str .= $bili . '% {left: ' . mt_rand(0, 400) . 'px; top:' . mt_rand(0, 400) . 'px;}';
        }
        $str .= '}';
        return response()->json(successReturn([
            'time'   => $times,
            'values' => $str,
            'anim'   => $anim,
        ]));
    }

    public function bind(Request $request)
    {
        $mac1 = $request->input('mac1');
        $mac2 = $request->input('mac2');
        $mac3 = $request->input('mac3');
        $mac4 = $request->input('mac4');
        $num = 0;
        if ($mac1) {
            $num += 1;
        }
        if ($mac2) {
            $num += 1;
        }
        if ($mac3) {
            $num += 1;
        }
        if ($mac4) {
            $num += 1;
        }
        for ($i=0; $i<$num; $i++) {
            $data[] = ['x' => mt_rand(0, 400), 'y' => mt_rand(0, 400)];
        }
        return response()->json(successReturn($data));
    }
}
