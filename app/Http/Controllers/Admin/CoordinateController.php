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
        $num = mt_rand(60, 100);
        $bl  = sprintf("%.2f", (100 / $num));
        $bili = 0;
        $str = '@keyframes anims{';
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
            'time'   => mt_rand(20, 100),
            'values' => $str,
        ]));
    }
}
