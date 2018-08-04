<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class BaseController extends Controller
{
    public function __construct(Request $request)
    {
        $adminInfo = Session::get('admin_user_info');
        if (!is_array($adminInfo)) {
            redirection('/admin/login');
        }
    }
}
