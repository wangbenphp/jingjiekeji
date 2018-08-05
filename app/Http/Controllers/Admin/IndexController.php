<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

class IndexController extends BaseController
{
    public function index(Request $request)
    {
        $menu = $request->input('menu');
        return view('admin.index.index', ['menu' => $menu]);
    }

    public function show(Request $request)
    {
        $menu = $request->input('menu');
        return view('admin.index.show', ['menu' => $menu]);
    }
}
