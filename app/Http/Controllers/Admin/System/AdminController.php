<?php

namespace App\Http\Controllers\Admin\System;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function showAdminList()
    {
        $data=[];
        $data['menu'] = ["menu-setting", "item-admins"];
        return view('setting.admins', $data);
    }
}
