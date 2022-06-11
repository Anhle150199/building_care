<?php

namespace App\Http\Controllers\Admin\System;

use App\Http\Controllers\Admin\BaseBuildingController;
use App\Models\Admin;
use App\Models\Equipment;
use App\Models\EquipmentRelationship;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EquipmentController extends BaseBuildingController
{
    public function showList()
    {
        $data = [];
        $equipments = Equipment::all();
        $data['equipments'] = $equipments;
        $data['menu'] = ["menu-setting", "item-equipments"];
        $data['buildingActive'] = $this->getBuildingActive();
        $data['buildingList'] = $this->buildingList;

        return view('setting.equipments', $data);
    }

    public function create(Request $request)
    {
        $validate = Validator::make(
            $request->all(),
            ['name' => 'string|required|max:150|unique:equipment,name'],
            [
                'name.required' => "Tên là bắt buộc",
                'name.max' => "tên quá dài, giới hạn 150 ký tự",
                'name.unique' => "Tên bị trùng"
            ]
        );
        if ($validate->fails()) {
            return new JsonResponse(['errors' => $validate->getMessageBag()->toArray()], 406);
        }
        try {
            $new = new Equipment();
            $new->name = $request->name;
            $new->save();
            $new->time = $new->created_at->format('d M Y, h:i a');
        } catch (\Throwable $th) {
            return new JsonResponse(['errors' => ['Có lỗi xảy ra']], 406);
        }
        return new JsonResponse($new, 200);
    }

    public function update(Request $request)
    {
        $validate = Validator::make(
            $request->all(),
            [
                'name' => 'string|required|max:255',
                'id' => 'required|exists:equipment,id'
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
            $edit = Equipment::find($request->id);
            $edit->name = $request->name;
            $edit->save();
            $edit->time = $edit->updated_at->format('d M Y, h:i a');

        } catch (\Throwable $th) {
            return new JsonResponse(['errors' => ['id' => 'Có lỗi xảy ra']], 406);
        }
        return new JsonResponse($edit, 200);
    }

    public function delete(Request $request)
    {
        if ($request->has('id')) {
            $id = $request->id;
            if(sizeof($id) == 0){
                return new JsonResponse( ['errors'=> ''], 406);
            }
            try {
                Equipment::whereIn('id',$id)->delete();
                EquipmentRelationship::whereIn('equipment_id',$id)->delete();
            } catch (\Throwable $th) {
                return new JsonResponse( ['errors'=> ''], 406);
            }
            return new JsonResponse( [ 'deleted'], 200);

        }
        return new JsonResponse( ['errors'=> ''], 406);

    }

}
