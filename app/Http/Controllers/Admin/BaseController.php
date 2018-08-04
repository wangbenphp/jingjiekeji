<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class BaseController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $info = $request->session()->all();
            if (isset($info['admin_user_info'])) {
                if (is_array($info['admin_user_info'])) {
                    $menu = logic('AdminMenu')->get();
                    $request->merge(['menu' => $menu]);
                    return $next($request);
                }
            }
            return redirect('/admin/login');
        });
    }
}
