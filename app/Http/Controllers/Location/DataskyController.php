<?php

namespace App\Http\Controllers\Location;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

/**
 * DataSky WIFI定位系统控制器
 */
class DataskyController extends Controller
{
    public function index(Request $request)
    {
        $info = $request->input('data');
        $frequency = ($request->input('frequency') >= 1) ? $request->input('frequency') : 1;
        if ($info) {
            $res = logic('Datasky')->data_dispose($info, $frequency);
            if ($res) {
                return response()->json(successReturn());
            }
        }
        return response()->json(failReturn(40005, '数据处理失败'));
    }
}
