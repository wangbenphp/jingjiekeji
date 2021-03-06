<?php

namespace App\Http\Controllers\Crontab;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DataskyController extends Controller
{
    public function db()
    {
        return view('crontab.db');
    }

    public function xy()
    {
        return view('crontab.xy');
    }

    public function xy_to_db(Request $request)
    {
        $num  = $request->input('num') ?: 50;
        $info = logic('DataSkys')->xy_to_db($num);
        if ($info) {
            return response()->json(successReturn());
        }
        return response()->json(failReturn(40005, '数据处理失败'));
    }

    public function list_to_xy(Request $request)
    {
        $num  = $request->input('num') ?: 50;
        $info = logic('DataSkys')->data_to_xy_to_queue($num);
        if ($info) {
            return response()->json(successReturn());
        }
        return response()->json(failReturn(40005, '数据处理失败'));
    }
}
