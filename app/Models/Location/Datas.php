<?php

namespace App\Models\Location;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Datas extends Model
{
    public function adds($xy, $mac, $time)
    {
        $res = DB::table('datas')
            ->insert([
                'mac'         => $mac,
                'x'           => $xy['x'],
                'y'           => $xy['y'],
                'time'        => $time,
                'create_time' => time()
            ]);
        return $res;
    }

    public function get_info_by_time($time)
    {
        $res = DB::table('datas')
            ->select('x', 'y')
            ->where('create_time', $time)
            ->get();
        return $res ? o2a($res) : null;
    }

    public function selects($mac)
    {
        $res = DB::table('datas')
            ->select('x', 'y')
            ->where('mac', $mac)
            ->orderByRaw('id ASC')
            ->get();
        return $res ? o2a($res) : null;
    }
}
