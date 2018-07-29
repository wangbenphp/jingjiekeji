<?php

namespace App\Http\Controllers\Test;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use WbPHPLibraryPackage\Service\Redis;

class IndexController extends Controller
{
    public function index(Request $request)
    {
        $info = file_get_contents('php://input') ?: $request->input();
        $res = is_array($info) ? json_encode($info) : (is_string($info) ?: json_encode($info));
        $result = Redis::getInstance()->rpush('jingjiekeji.push.info', $res);
        var_dump($result);
    }
}
