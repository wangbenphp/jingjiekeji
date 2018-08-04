<?php

namespace App\Logics;

/**
 * 管理员后台登录
 * @author wangben
 * @date 20180804
 */
class AdminLoginLogic extends BaseLogic
{
    public function verify($username, $password, $ip)
    {
        $res = model('Admin/User')->login($username, md5($password));
        if ($res) {
            if ($res['status'] != 1) {
                return ['code' => 40004, 'message' => '账号已被冻结'];
            }
            model('Admin/User')->login_log($res['id'], ip2long($ip), time());
            return ['code' => 0, 'message' => 'Success', 'data' => $res];
        }
        return ['code' => 40003, 'message' => '账号或密码错误'];
    }
}