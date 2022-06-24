<?php

namespace App\Http\Controllers\Admin\User;

use App\Http\Controllers\Admin\BaseBuildingController;
use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Department;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends BaseBuildingController
{
    public function generalData()
    {
        $data = [];
        $data['menu'] = ["menu-setting", "item-admins"];
        $data['buildingActive'] = $this->getBuildingActive();
        $data['buildingList'] = $this->buildingList;
        return $data;
    }

    public function showProfile()
    {
        $data = $this->generalData();
        $departments = Department::all();
        $data['departments'] = $departments;

        return view('users.profile', $data);
    }

    public function showAdminList()
    {
        $data=[];
        $data['menu'] = ["menu-setting", "item-admins"];
        return view('setting.admins', $data);
    }
    public function profileDetail(Request $request)
    {
        $validate = Validator::make(
            $request->all(),
            [
                'name' => ['required', 'string'],
                'department_id' => 'integer|required',
                'position' => 'string|required'
            ]
        );

        if ($validate->fails()) {
            return new JsonResponse(['errors' => [$validate->getMessageBag()->toArray(), $request->all()]], 406);
        }

        $admin = Admin::find(Auth::user()->id);
        $admin->name = $request->name;
        $admin->department_id = $request->department_id;
        $admin->position = $request->position;
        if($request->has('avatar')){
            $admin->avatar = $this->saveImage($request->avatar);
        }
        $admin->save();
        return new JsonResponse([$request->all], 200);
    }

    public function updateEmail(Request $request)
    {
        $validate = Validator::make(
            $request->all(),
            [
                'password' => 'string|required',
                'email' => 'string|required|unique:admins,email',
            ]
        );

        if ($validate->fails()) {
            return new JsonResponse(['errors' => $validate->getMessageBag()->toArray()], 406);
        }
        $admin = Admin::find(Auth::user()->id);
        if(Hash::check($request->password, $admin->password)){
            $admin->email = $request->email;
            $admin->save();
            return new JsonResponse([$request->all()], 200);
        }
        return new JsonResponse(['errors' => ['password'=>"Mật khẩu không đúng"]], 406);
    }
    public function updatePassword(Request $request)
    {
        $validate = Validator::make(
            $request->all(),
            [
                'currentpassword' => 'string|required|',
                'newpassword' => 'string|required|',
                'confirmpassword' => 'string|required|',
            ]
        );
        if ($validate->fails()) {
            return new JsonResponse(['errors' => $validate->getMessageBag()->toArray()], 406);
        }
        $admin = Admin::find(Auth::user()->id);
        if(Hash::check($request->currentpassword, $admin->password)){
            $admin->password = Hash::make($request->newpassword);
            $admin->save();
            return new JsonResponse([$request->all()], 200);
        }
        return new JsonResponse(['errors' => ['currentpassword'=>"Mật khẩu không đúng"]], 406);
    }

    public function saveImage($file)
    {
        $fileName = $file->getClientOriginalName();
        $fileExt = $file->getClientOriginalExtension();

        while (file_exists("assets/media/avatars/" . $fileName)) {
            $fileName = strtotime("now") . '.' . $fileExt;
        }
        $file->move('assets/media/avatars/', $fileName);
        return $fileName;
    }
}
