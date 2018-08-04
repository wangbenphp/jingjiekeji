<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

class IndexController extends BaseController
{
    public function index(Request $request)
    {
        //echo '<pre>';
        //print_r($request->input());
        $menu = $request->input('menu');
        return view('admin.index.index', ['menu' => $menu]);
    }

    public function menu()
    {
        $res = logic('AdminMenu')->get();
    }
}
