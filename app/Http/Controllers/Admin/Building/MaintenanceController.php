<?php

namespace App\Http\Controllers\Admin\Building;

use App\Http\Controllers\Admin\BaseBuildingController;
use App\Jobs\PushNotificationJob;
use App\Models\Apartment;
use App\Models\Building;
use App\Models\Customer;
use App\Models\Equipment;
use App\Models\MaintenanceSchedule;
use App\Models\PushNotify;
use App\Models\PushNotifyRelationship;
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
        // $data['equipments'] = Equipment::all();
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
        // Todo push notification "Có lịch bảo trì "
        $apartments = Apartment::where("building_id", $request->building_id)->pluck('id')->toArray();
        $building = Building::find($request->building_id);
        $pushNotify = new PushNotify();
        $pushNotify->category= "maintenance";
        $pushNotify->item_id = $new->id;
        $pushNotify->title = "Toà ".$building->name.": Có lịch bảo trì mới!";
        $pushNotify->body = $new->title;
        $pushNotify->type_user = "customer";
        $pushNotify->click_action = route('user.maintenance');
        $pushNotify->save();
        foreach ($apartments as $key => $value) {
            PushNotifyRelationship::create([
                'apartment_id' => $value,
                'push_notify_id'=> $pushNotify->id,
            ]);
        }

        $userList1 = Apartment::whereIn("id", $apartments)->pluck('owner_id')->toArray();
        $userList2 = Customer::whereIn("apartment_id", $apartments)->pluck('id')->toArray();
        $userList = array_unique(array_merge($userList1, $userList2));
        $deviceTokens = Customer::whereIn("id", $userList)->whereNotNull('device_key')->pluck('device_key')->toArray();

        PushNotificationJob::dispatch('sendBatchNotification', [
            $deviceTokens,
            [
                'topicName' => $pushNotify->category,
                'title' => $pushNotify->title,
                'body' => $pushNotify->body,
                'click_action' => $pushNotify->click_action,
                'image'=>"<i class=\"bi bi-calendar2-event\"></i>"
            ],
        ]);
        return new JsonResponse([$new], 200);
    }

    public function update(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'id'=>'integer|required|exists:maintenance_schedule,id',
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

        $edit = MaintenanceSchedule::find($request->id);
        try {
            $edit = $this->saveData($edit, $request);
        } catch (\Throwable $th) {
            return new JsonResponse(['errors' => ['Lỗi cập nhật data']], 406);
        }

        return new JsonResponse([$edit], 200);
    }

    public function delete(Request $request)
    {
        if ($request->has('id')) {
            $id = $request->id;
            try {
                MaintenanceSchedule::where('id', $id)->delete();
            } catch (\Throwable $th) {
                return new JsonResponse(['errors' => ' lỗi truy vấn'], 406);
            }
            return new JsonResponse(['deleted'], 200);
        }
        return new JsonResponse(['errors' => 'không có id'], 406);
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
