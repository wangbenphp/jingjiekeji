<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CoordinateController extends Controller
{
    public function get(Request $request)
    {
        $num = mt_rand(40, 60);
        for ($i=0; $i<$num; $i++) {
            $data[] = ['x' => mt_rand(0, 400), 'y' => mt_rand(0, 400)];
        }
        return response()->json(successReturn($data));
    }
}
