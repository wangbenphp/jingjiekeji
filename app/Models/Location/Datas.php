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
}
