<?php

namespace App\Http\Controllers\Admin\System;

use App\Http\Controllers\Admin\BaseBuildingController;
use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Department;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AdminController extends BaseBuildingController
{
    public function showAdminList()
    {
        $data=[];
        $admins1 = Admin::join('departments', 'admins.department_id', '=', 'departments.id')
                        ->select('admins.id', 'admins.name', 'admins.email', 'admins.phone', 'admins.role', 'admins.position', 'admins.avatar', 'admins.created_at', 'admins.status', 'departments.name as department' )
                        ->get();
        $admins2 = Admin::where('department_id', 0)->get();
        $departments = Department::all();

        $data['admins1'] = $admins1;
        $data['admins2'] = $admins2;
        $data['departments'] = $departments;
        $data['menu'] = ["menu-setting", "item-admins"];
        $data['buildingActive'] = $this->getBuildingActive();
        $data['buildingList'] = $this->buildingList;

        return view('setting.admins', $data);
    }

    public function create(Request $request)
    {
        $validate = Validator::make(
            $request->all(),
            [
                'name' => 'string|required|max:255',
                'email' => 'string|required|unique:admins,email',
                'department' => 'integer|required',
                'role'=> ['required','in:super,admin'],
                'position' => 'required| string',
            ],
            [
                'name.required' => "Tên là bắt buộc",
                'name.max' => "tên quá dài, giới hạn 255 ký tự",
                'name.unique' => "Tên bị trùng",
                'email.required' => "Email là bắt buộc",
                'email.unique' => "Email bị trùng",
                'department.required' => "Bộ phận là bắt buộc",
                'role.required' => "Quyền là bắt buộc",
                'position.required' => "Chức cụ là bắt buộc",
            ]
        );
        if ($validate->fails()) {
            return new JsonResponse(['errors' => $validate->getMessageBag()->toArray()], 406);
        }
        try {
            $new = new Admin();
            $new->name = $request->name;
            $new->email = $request->email;
            $new->department_id = $request->department;
            $new->role = $request->role;
            $new->position = $request->position;
            $new->avatar = 'avatar-1.png';
            $new->status = 'verifying';
            // $new->password = 
            $new->save();
            $new->department = Department::find($request->department)->name;
            $new->time = $new->created_at->format('d M Y, h:i a');
            return new JsonResponse($new, 200);
        } catch (\Throwable $th) {
            return new JsonResponse(['errors' => ['Có lỗi xảy ra', $request->all()]], 406);
        }
    }

    public function update(Request $request)
    {
        $validate = Validator::make(
            $request->all(),
            [
                'name' => 'string|required|max:255',
                'email' => 'string|required',
                'department' => 'integer|required',
                'role'=> ['required','in:super,admin'],
                'position' => 'required| string',
                'id' => 'required'
            ],
            [
                'name.required' => "Tên là bắt buộc",
                'name.max' => "tên quá dài, giới hạn 255 ký tự",
                'email.required' => "Email là bắt buộc",
                'department.required' => "Bộ phận là bắt buộc",
                'role.required' => "Quyền là bắt buộc",
                'position.required' => "Chức cụ là bắt buộc",
            ]
        );
        if ($validate->fails()) {
            return new JsonResponse(['errors' => $validate->getMessageBag()->toArray()], 406);
        }
        try {
            $admin = Admin::find($request->id);
            if($admin->email != $request->email){
                $check = Admin::where('email', $request->email)->count();
                if ($check > 0){
                    return new JsonResponse(['errors' => ['email'=>'Email bị trùng']], 406);
                }
                $admin->email = $request->email;
            }
            $admin->name = $request->name;
            $admin->department_id = $request->department;
            $admin->role = $request->role;
            $admin->position = $request->position;
            $admin->save();
            $admin->department = Department::find($request->department)->name;
            $admin->time = $admin->created_at->format('d M Y, h:i a');
            return new JsonResponse($admin, 200);
        } catch (\Throwable $th) {
            return new JsonResponse(['errors' => ['Có lỗi xảy ra']], 406);
        }
    }

    public function delete(Request $request)
    {
        if ($request->has('id')) {
            $id = $request->id;
            if(sizeof($id) == 0){
                return new JsonResponse( ['errors'=> ''], 406);
            }
            try {
                Admin::whereIn('id',$id)->delete();
            } catch (\Throwable $th) {
                return new JsonResponse( ['errors'=> ''], 406);
            }
            return new JsonResponse( [ 'deleted'], 200);

        }
        return new JsonResponse( ['errors'=> ''], 406);

    }

    public function updateStatus(Request $request)
    {
        $validate = Validator::make(
            $request->all(),
            [
                'status' => 'required|string|in:activated,lock',
                'id' => 'required|exists:admins,id'
            ]
        );
        if ($validate->fails()) {
            return new JsonResponse(['errors' => $validate->getMessageBag()->toArray()], 406);
        }
        try {
            $admin = Admin::find($request->id);
            $admin->status = $request->status;
            $admin->save();
        } catch (\Throwable $th) {
            return new JsonResponse( ['errors'=> ''], 406);
        }
        return new JsonResponse($admin, 200);

    }
}
