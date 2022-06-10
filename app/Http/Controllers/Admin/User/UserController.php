<?php

namespace App\Http\Controllers\Admin\User;

use App\Http\Controllers\Admin\BaseBuildingController;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends BaseBuildingController
{

    public function showProfile()
    {
        return view('users.profile');
    }

    public function showAdminList()
    {
        $data=[];
        $data['menu'] = ["menu-setting", "item-admins"];
        return view('setting.admins', $data);
    }
}
