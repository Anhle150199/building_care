<?php

namespace App\Http\Controllers\Admin\Building;

use App\Http\Controllers\Admin\BaseBuildingController;
use App\Models\Apartment;
use App\Models\Building;
use App\Repositories\Eloquent\BuildingRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;

class BuildingController extends BaseBuildingController
{

    public function showBuildingList(Request $request)
    {
        $data = [];
        $data['menu'] = ["menu-building", "item-building-list"];
        $building = Building::orderBy('name', 'asc')->get();
        $list = [];
        foreach ($building as $value) {
            $apartmentActive = Apartment::where('building_id', $value->id)->count();
            $value->apartment_active = $apartmentActive;
            array_push($list, $value);
        }
        $data['building'] = $list;
        $data['buildingActive'] = $this->getBuildingActive();
        $data['buildingList'] = $this->buildingList;
        return view('building-manage.building', $data);
    }

    public function showNewBuilding(Request $request)
    {
        $data = [];
        $data['menu'] = ["menu-building", "item-building-new"];
        $data['typePage'] = 'new';
        $data['title'] = 'Thêm mới toà nhà';
        $data['routeAjax'] = route('admin.building.create');
        $data['methodAjax'] = 'post';
        $data['buildingActive'] = $this->getBuildingActive();
        $data['buildingList'] = $this->buildingList;

        return view('building-manage.detail', $data);
    }

    public function create(Request $request)
    {
        $validate = Validator::make(
            $request->all(),
            [
                'name' => ['string', 'required', 'max:100', 'unique:building,name'],
                'description' => ['string'],
                'address' => ['string', 'required'],
                'status' => ['string', 'in:active,prepare,lock', 'required'],
                'acreage' => 'integer',
                'floors_number' => 'integer|required',
                'apartment_number' => 'string|integer',
            ]
        );

        if ($validate->fails()) {
            return new JsonResponse(['errors' => $validate->getMessageBag()->toArray()], 406);
        }
        try {
            $new = new Building();
            $new = $this->saveDataBuilding($new, $request);
            $this->buildingModel->updateBuildingList();

        } catch (\Throwable $th) {
            return new JsonResponse(['errors' => ['Lỗi insert data']], 406);
        }
        return new JsonResponse(['success'], 200);
    }

    public function showUpdate($id)
    {
        $building = Building::find($id);
        $data = [];
        $data['menu'] = ["menu-building", "item-building-new"];
        $data['typePage'] = 'edit';
        $data['title'] = 'Chi tiết toà nhà';
        $data['routeAjax'] = route('admin.building.update');
        $data['methodAjax'] = 'put';
        $data['building'] = $building;
        $data['buildingActive'] = $this->getBuildingActive();
        $data['buildingList'] = $this->buildingList;

        return view('building-manage.detail', $data);
    }

    public function update(Request $request)
    {
        $validate = Validator::make(
            $request->all(),
            [
                'id' => 'required|integer',
                'name' => ['string', 'required', 'max:100'],
                'description' => ['string'],
                'address' => ['string', 'required'],
                'status' => ['string', 'in:active,prepare,lock', 'required'],
                'acreage' => 'integer',
                'floors_number' => 'integer|required',
                'apartment_number' => 'string|integer',
            ]
        );

        if ($validate->fails()) {
            return new JsonResponse(['errors' => $validate->getMessageBag()->toArray()], 406);
        }
        $building = Building::find($request->id);
        if ($building->name != $request->name) {
            $check = Building::where(['name' => $request->name])->first();
            if ($check != null) {
                return new JsonResponse(['errors' => ['email' => 'Tên toà nhà bị trùng', $check]], 406);
            }
        }
        try {
            $building = $this->saveDataBuilding($building, $request);
            $this->buildingModel->updateBuildingList();
            $buildingActive = $this->getBuildingActive();
            if ($request->status != 'active' && $request->id == $buildingActive) {
                Cache::flush('building_active_'.Auth::user()->id);
            }
        } catch (\Throwable $th) {
            return new JsonResponse(['errors' => ['Lỗi insert data']], 406);
        }
        return new JsonResponse(['success'], 200);
    }

    public function delete(Request $request)
    {
        if ($request->has('id')) {
            $id = $request->id;
            if (sizeof($id) == 0) {
                return new JsonResponse(['errors' => 'input rỗng'], 406);
            }
            try {
                Building::whereIn('id', $id)->delete();
                $this->buildingModel->updateBuildingList();
                $buildingActive = $this->getBuildingActive();
                if (in_array($buildingActive, $request->id)) {
                    Cache::flush('building_active_'.Auth::user()->id);
                }
            } catch (\Throwable $th) {
                return new JsonResponse(['errors' => ' lỗi truy vấn'], 406);
            }
            return new JsonResponse(['deleted'], 200);
        }
        return new JsonResponse(['errors' => 'không có id'], 406);
    }
    public function saveDataBuilding(Building $building, Request $request)
    {
        $building->name = $request->name;
        $building->description = $request->description;
        $building->address = $request->address;
        $building->phone = $request->phone;
        $building->email = $request->email;
        $building->status = $request->status;
        $building->height = $request->height;
        $building->acreage = $request->acreage;
        $building->floors_number = $request->floors_number;
        $building->apartment_number = $request->apartment_number;
        $building->save();
        return $building;
    }
}
