<?php

namespace App\Http\Controllers\Admin\Building;

use App\Http\Controllers\Admin\BaseBuildingController;
use App\Models\Equipment;
use App\Models\MaintenanceSchedule;
use DateTime;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MaintenanceController extends BaseBuildingController
{

    public function generalData()
    {
        $data = [];
        $data['menu'] = ["menu-building", "item-maintain"];
        $data['buildingActive'] = $this->getBuildingActive();
        $data['buildingList'] = $this->buildingList;
        return $data;
    }

    public function show()
    {
        $data = $this->generalData();
        $data['equipments'] = Equipment::all();
        return view('building-manage.maintenance-schedule', $data);
    }

    public function getCalendarList($id)
    {
        $list = MaintenanceSchedule::where('building_id', $id)->get();
        $result = [];
        foreach ($list as $value) {
            $item = new MaintenanceSchedule();
            $item->id = $value->id;
            $item->title = $value->title;
            $item->description = $value->description;
            $item->location = $value->location;
            if ($value->all_day == "1") {
                $item->start = date("Y-m-d", strtotime($value->start_at));
                $item->end = date("Y-m-d", strtotime($value->end_at));
                $item->className = "fc-event-primary";
            } else {
                $item->start = date("Y-m-d\TH:i:s", strtotime($value->start_at));
                $item->end = date("Y-m-d\TH:i:s", strtotime($value->end_at));
                $item->className = "fc-event-primary";
            }

            array_push($result, $item);
        }
        return new JsonResponse($result, 200);
    }

    public function create(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'building_id' => 'required|integer|exists:building,id',
                'title' => 'required|string|',
                'all_day' => 'required|integer|in:1,0',
                'start_at' => 'required',
                'end_at' => 'required',
                'location' => 'required|string'
            ]
        );

        if ($validator->fails()) {
            return new JsonResponse(['errors' => $validator->getMessageBag()->toArray()], 406);
        }

        $new = new MaintenanceSchedule();
        try {
            $new = $this->saveData($new, $request);
        } catch (\Throwable $th) {
            return new JsonResponse(['errors' => ['Lỗi insert data']], 406);
        }

        return new JsonResponse([$new], 200);
    }

    public function update(Request $request)
    {
    }

    public function delete(Request $request)
    {
    }

    public function saveData($model, $request)
    {
        $model->building_id = $request->building_id;
        $model->title = $request->title;
        $model->description = $request->description;
        $model->all_day = $request->all_day;
        $model->start_at = $request->start_at;
        $model->end_at = $request->end_at;
        $model->location = $request->location;
        $model->save();
        return $model;
    }
}
