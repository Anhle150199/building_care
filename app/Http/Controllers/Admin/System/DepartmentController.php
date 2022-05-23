<?php

namespace App\Http\Controllers\Admin\System;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Department;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

class DepartmentController extends Controller
{
    public function showDepartmentList()
    {
        $data = [];
        $departments = Department::all();
        foreach ($departments as $value) {
            $countUser = Admin::where('department_id', $value->id)->count();
            Cache::put('department_count_' . $value->id, $countUser, 600);
        }
        $data['departments'] = $departments;
        $data['menu'] = ["menu-setting", "item-departments"];
        return view('setting.departments', $data);
    }

    // public function getAll()
    // {
    //     $departments = Department::all();
    //     $rs =[];
    //     foreach ($departments as $value) {
    //         $countUser = Admin::where('department_id', $value->id)->count();
    //         $value->count = $countUser;
    //         $value->time = $value->created_at->format("d M Y, h:i a");
    //         array_push($rs, $value);
    //     }
    //     $data['recordsTotal'] = sizeof($rs);
    //     $data['recordsFiltered'] = sizeof($rs);
    //     $data['data'] = $rs;

    //     return Response::json($data, 200);
    // }

    public function createDepartment(Request $request)
    {
        $validate = Validator::make(
            $request->all(),
            ['name' => 'string|required|max:255|unique:departments,name'],
            [
                'name.required' => "Tên là bắt buộc",
                'name.max' => "tên quá dài, giới hạn 255 ký tự",
                'name.unique' => "Tên bị trùng"
            ]
        );
        if ($validate->fails()) {
            return new JsonResponse(['errors' => $validate->getMessageBag()->toArray()], 406);
        }
        try {
            $new = new Department();
            $new->name = $request->name;
            $new->save();
            $new->time = $new->created_at->format('d M Y, h:i a');
        } catch (\Throwable $th) {
            return new JsonResponse(['errors' => ['Có lỗi xảy ra']], 406);
        }
        return new JsonResponse($new, 200);
    }

    public function updateDepartment(Request $request)
    {
        $validate = Validator::make(
            $request->all(),
            [
                'name' => 'string|required|max:255',
                'id' => 'required|exists:departments,id'
            ],
            [
                'name.required' => "Tên là bắt buộc",
                'name.max' => "tên quá dài, giới hạn 255 ký tự",
                'name.unique' => "Tên bị trùng",
                'id.required' => "Đầu vào bị thiếu",
            ]
        );
        if ($validate->fails()) {
            return new JsonResponse(['errors' => $validate->getMessageBag()->toArray()], 406);
        }
        try {
            $editDepartment = Department::where('id', $request->id)->first();
            $editDepartment->name = $request->name;
            $editDepartment->save();
            $editDepartment->time = $editDepartment->created_at->format('d M Y, h:i a');
            $editDepartment->count = Admin::where('department_id', $editDepartment->id)->count();

        } catch (\Throwable $th) {
            return new JsonResponse(['errors' => ['id' => 'Có lỗi xảy ra']], 406);
        }
        return new JsonResponse($editDepartment, 200);
    }

    public function deleteDepartment(Request $request)
    {
        if ($request->has('id')) {
            $id = $request->id;
            if(sizeof($id) == 0){
                return new JsonResponse( ['errors'=> ''], 406);
            }
            try {
                Department::whereIn('id',$id)->delete();
                $admins = Admin::whereIn('department_id',$id)->update([
                    "department_id"=>0
                ]);
            } catch (\Throwable $th) {
                return new JsonResponse( ['errors'=> ''], 406);
            }
            return new JsonResponse( [ 'deleted'], 200);

        }
        return new JsonResponse( ['errors'=> ''], 406);

    }

}
