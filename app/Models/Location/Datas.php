<?php

namespace App\Models\Location;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Datas extends Model
{
    public function adds($mac, $x, $y, $time)
    {
        $res = DB::table('datas')
            ->insert([
                'mac'         => $mac,
                'x'           => $x,
                'y'           => $y,
                'time'        => $time,
                'create_time' => time()
            ]);
        return $res;
    }
}
