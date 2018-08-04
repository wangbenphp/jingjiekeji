<?php

namespace App\Logics;

use WbPHPLibraryPackage\Service\Redis;

/**
 * 管理后台菜单
 * @author wangben
 * @date 20180804
 */
class AdminMenuLogic extends BaseLogic
{
    public function get()
    {
        $menu = false;
        $redis = Redis::getInstance();
        $res = $redis->get('admin.menu.list');
        if (!$res) {
            $menuM = model('Admin/Menu');
            $get_0 = $menuM->get_menu_0();
            if ($get_0) {
                foreach ($get_0 as $k => $v) {
                    if ($k == 0 && ($v['is_url'] == 0)) {
                        $is_first = 1;
                    } else {
                        $is_first = 0;
                    }
                    if ($v['is_url'] == 0) {
                        unset($get_0[$k]['url']);
                        $get_0[$k]['child_list'] = $menuM->get_menu_1($v['id']);
                    }
                    $get_0[$k]['is_first'] = $is_first;
                    unset($get_0[$k]['id']);
                }
                $menu = $get_0;
                $redis->setex('admin.menu.list', 120, json_encode($menu));
            }
        } else {
            $menu = json_decode($res, true);
        }
        return $menu;
    }
}