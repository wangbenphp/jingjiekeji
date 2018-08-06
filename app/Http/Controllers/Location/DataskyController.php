<?php

namespace App\Http\Controllers\Location;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use WbPHPLibraryPackage\Service\Log;

/**
 * DataSky WIFI定位系统控制器
 */
class DataskyController extends Controller
{
    public function index(Request $request)
    {
        $info = $request->input('data');
        Log::info($info);
        if ($info) {
            $res = logic('Datasky')->data_dispose($info);
            if ($res) {
                return response()->json(successReturn());
            }
        }
        return response()->json(failReturn(40005, '数据处理失败'));
    }
}
