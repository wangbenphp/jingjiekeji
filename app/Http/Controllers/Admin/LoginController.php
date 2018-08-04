<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    /**
     * 登录页面
     */
    public function index()
    {
        $adminInfo = Session::get('admin_user_info');
        if ($adminInfo) {
            echo '登录成功';exit;
        }
        return view('admin.login.index');
    }

    /**
     * 登录判断
     */
    public function login(Request $request)
    {
        $username = $request->input('username');
        $password = $request->input('password');
        $ip       = $request->ip();
        if (!$username || !$password) {
            return response()->json(failReturn(40001, '用户名或密码不能为空'));
        }
        $res = logic('adminLogin')->verify($username, $password, $ip);
        if ($res['code'] == 0) {
            Session::put('admin_user_info', $res['data']);
            return response()->json(successReturn());
        }
        return response()->json(failReturn($res['code'], $res['message']));
    }
}
