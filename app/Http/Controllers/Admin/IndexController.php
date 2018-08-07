<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

class IndexController extends BaseController
{
    /**
     * 信号分布图
     */
    public function index(Request $request)
    {
        $menu = $request->input('menu');
        return view('admin.index.index', ['menu' => $menu]);
    }

    /**
     * 轨迹查询
     */
    public function show(Request $request)
    {
        $menu = $request->input('menu');
        return view('admin.index.show', ['menu' => $menu]);
    }

    /**
     * mac追踪图
     */
    public function bind(Request $request)
    {
        $menu = $request->input('menu');
        return view('admin.index.bind', ['menu' => $menu]);
    }
}
