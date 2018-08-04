<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class User extends Model
{
    public function login($username, $password)
    {
        $res = DB::table('admin_user')
            ->where('username', $username)
            ->where('password', $password)
            ->where('is_delete', 0)
            ->first();
        return $res ? o2a($res) : null;
    }

    public function login_log($id, $ip, $time)
    {
        $res = DB::table('admin_user')
            ->where('id', $id)
            ->increment('login_num', 1, [
                'last_login_time' => $time,
                'last_login_ip'   => $ip,
                'update_time'     => $time,
            ]);
        return $res;
    }
}
