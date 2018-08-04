<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Menu extends Model
{
    /**
     * 获取0级菜单列表
     */
    public function get_menu_0()
    {
        $res = DB::table('admin_menu')
            ->select('id', 'name', 'url', 'is_url')
            ->where('parent_id', 0)
            ->where('status', 1)
            ->where('is_delete', 0)
            ->orderByRaw('sort DESC')
            ->get();
        return $res ? o2a($res) : null;
    }

    /**
     * 获取1级菜单列表
     */
    public function get_menu_1($parent_id = '')
    {
        $res = DB::table('admin_menu')
            ->select('name', 'url')
            ->where('parent_id', $parent_id)
            ->where('status', 1)
            ->where('is_delete', 0)
            ->orderByRaw('sort DESC')
            ->get();
        return $res ? o2a($res) : null;
    }
}
