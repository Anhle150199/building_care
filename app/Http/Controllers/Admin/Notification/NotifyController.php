<?php

namespace App\Http\Controllers\Admin\Notification;

use App\Http\Controllers\Admin\BaseBuildingController;
use App\Jobs\PushNotificationJob;
use App\Models\Admin;
use App\Models\Apartment;
use App\Models\Building;
use App\Models\Customer;
use App\Models\Notification;
use App\Models\NotifyRelationship;
use App\Models\PushNotify;
use App\Models\PushNotifyRelationship;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class NotifyController extends BaseBuildingController
{

    public function generalData()
    {
        $data = [];
        $data['menu'] = ["menu-notify", "item-notify"];
        $data['buildingActive'] = $this->getBuildingActive();
        $data['buildingList'] = $this->buildingList;
        return $data;
    }

    public function showList()
    {
        $data = $this->generalData();
        $notifications = NotifyRelationship::where('building_id', $data['buildingActive'])->join('notifications', 'notify_id', 'notifications.id')
            ->join('admins', 'admin_id', 'admins.id')->orderBy('id', 'desc')
            ->select('notifications.id', 'notifications.title', 'notifications.status', 'notifications.category', 'notifications.created_at', 'admins.name', 'admins.id as adminId')->get();
        // dd($notifications);
        $data['notifications'] = $notifications;
        return view('notify.notifications', $data);
    }

    public function showCreate()
    {
        $data = $this->generalData();
        $data['typePage'] = 'new';
        $data['title'] = 'Soạn thông báo';
        $data['routeAjax'] = route('admin.notification.create');
        $data['methodAjax'] = 'post';
        $data['buildingSelected'] =[];

        return view('notify.detail', $data);
    }
    public function showUpdate($id)
    {
        $notify = Notification::find($id);
        if ($notify != null) {
            $data = $this->generalData();
            $data['typePage'] = 'edit';
            $data['title'] = 'Chi tiết thông báo';
            $data['routeAjax'] = route('admin.notification.update');
            $data['methodAjax'] = 'put';
            $data['buildingSelected'] =[];
            if($notify->sent_type == 0){
                $building = NotifyRelationship::where('notify_id', $id)->get();
                $listId = [];
                foreach ($building as $key => $value) {
                    $listId[$key] = $value->building_id;
                }
            $data['buildingSelected'] = $listId;

            }
            $data['item'] = $notify;
            return view('notify.detail', $data);
        }
    }

    public function create(Request $request)
    {
        $validate = Validator::make(
            $request->all(),
            [
                'title' => ['required', 'string'],
                'content' => 'string|required',
                'status' => 'string|required|in:public,private',
                'category' => ['string', 'in:event,notify', 'required'],
                'sent_type' => ['integer', 'in:0,1', 'required'],
            ]
        );

        if ($validate->fails()) {
            return new JsonResponse(['errors' => $validate->getMessageBag()->toArray()], 406);
        }

        $request->slug = $this->checkSlug($request->title);
        if($request->slug == false){
            return new JsonResponse(['errors' => ["title" => "Slug bị trùng"]], 406);
        }
        try {
            $request->admin_id = Auth::user()->id;
            $request->image_name = $this->saveImage($request->image);
            // $request->image_name = 'xxx';
            $new = new Notification();
            $new = $this->saveData($new, $request);
            if ($request->sent_type == 1) {
                $building = $this->buildingList;
                $list = [];
                foreach ($building as $key => $value) {
                    array_push($list, $value->id);
                }
                $building = $list;
            } else {
                $building = json_decode($request->building_select);
            }
            $this->saveRelation($new->id, $building);
        } catch (\Throwable $th) {
            return new JsonResponse(['errors' => ['Lỗi insert data.']], 406);
        }
        // Todo push notification "Có thông báo mới"
        if($new->category == "notify"){
            $apartments = Apartment::whereIn("building_id", $building)->pluck('id')->toArray();

            $pushNotify = new PushNotify();
            $pushNotify->category= "notify_event";
            $pushNotify->item_id = $new->id;
            $pushNotify->title = "Bạn có thông báo mới từ Ban quản lý toà nhà";
            $pushNotify->body = $new->title;
            $pushNotify->type_user = "customer";
            $pushNotify->click_action = url("/notify/").'/'.$new->slug;
            $pushNotify->save();

            foreach ($apartments as $key => $value) {
                PushNotifyRelationship::create([
                    'apartment_id' => $value,
                    'push_notify_id'=> $pushNotify->id,
                ]);
            }
            if ($request->sent_type == 1) {
            $deviceTokens = Customer::whereNotNull('device_key')->pluck('device_key')->toArray();
            } else{
                $userList1 = Apartment::whereIn("id", $apartments)->pluck('owner_id')->toArray();
                $userList2 = Customer::whereIn("apartment_id", $apartments)->pluck('id')->toArray();
                $userList = array_unique(array_merge($userList1, $userList2));
                $deviceTokens = Customer::whereIn("id", $userList)->whereNotNull('device_key')->pluck('device_key')->toArray();
            }
            PushNotificationJob::dispatch('sendBatchNotification', [
                $deviceTokens,
                [
                    'topicName' => $pushNotify->category,
                    'title' => $pushNotify->title,
                    'body' => $pushNotify->body,
                    'click_action' => $pushNotify->click_action,
                    'image'=>"<i class=\"bi bi-bell\"></i>"
                ],
            ]);

        }

        return new JsonResponse(['success'], 200);
    }

    public function update(Request $request)
    {
        $validate = Validator::make(
            $request->all(),
            [
                'id'=>'required',
                'title' => ['required', 'string'],
                'content' => 'string|required',
                'status' => 'string|required|in:public,private',
                'category' => ['string', 'in:event,notify', 'required'],
                'sent_type' => ['integer', 'in:0,1', 'required'],
            ]
        );

        if ($validate->fails()) {
            return new JsonResponse(['errors' => [$validate->getMessageBag()->toArray(), $request->all()]], 406);
        }
        try {
            $edit = Notification::find($request->id);
            if($edit->title != $request->title){
                $slug = Str::slug($request->title, '-');
                if($slug != $edit->slug){
                    $request->slug = $this->checkSlug($request->title);
                    if($request->slug == false){
                        return new JsonResponse(['errors' => ["title" => "Slug bị trùng"]], 406);
                    }
                } else {
                    $request->slug = $slug;
                }
            }else{
                $request->slug = $edit->slug;
            }

            $request->admin_id = $edit->admin_id;
            if ($request->image == 'null') {
                $request->image_name = $edit->image;
            }else{
                $request->image_name = $this->saveImage($request->image);
                if(file_exists(public_path('images/'.$edit->image))){
                    unlink(public_path('images/'.$edit->image));
                }
            }
            if ($request->sent_type == 1) {
                $building = $this->buildingList;
                $list = [];
                foreach ($building as $key => $value) {
                    array_push($list, $value->id);
                }
                $building = $list;
            } else {
                $building = json_decode($request->building_select);
            }
            if($request->sent_type == 1 && $edit->sent_type ==1){
            }else{
                $oldRelation = NotifyRelationship::where('notify_id', $request->id)->get();
                foreach ($oldRelation as $key => $value) {
                    if(in_array($value->building_id, $building)){
                        $key = array_search($value->building_id, $building);
                        if (false !== $key) {
                            unset($building[$key]);
                        }
                    } else{
                        $value->delete();
                    }
                }
                $this->saveRelation($request->id, $building);
            }
            $edit = $this->saveData($edit, $request);
        } catch (\Throwable $th) {
            return new JsonResponse(['errors' => ['Lỗi insert data.', $request->image]], 406);
        }
        // Todo push notification "Có thông báo mới"
        if($edit->category == "notify"){
            $apartments = Apartment::whereIn("building_id", $building)->pluck('id')->toArray();
            // Thêm trạng thái đọc người dùng
            PushNotify::where(["type_user" => "customer","item_id" => $edit->id, 'category'=> "notify_event"])->update([
                "title" => "Bạn có thông báo mới từ Ban quản lý toà nhà",
                "body" => $edit->title,
                "click_action" => url("/notify/").'/'.$edit->slug
            ]);
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
                Notification::whereIn('id', $id)->delete();
                NotifyRelationship::whereIn('notify_id', $id)->delete();
                // PushNotify::where(["type_user" => "customer", 'category'=> "notify_event"])->whereIn("item_id", $id)->delete();
            } catch (\Throwable $th) {
                return new JsonResponse(['errors' => ' lỗi truy vấn'], 406);
            }
            return new JsonResponse(['deleted'], 200);
        }
        return new JsonResponse(['errors' => 'không có id'], 406);
    }

    public function saveData($model, $request)
    {
        $model->admin_id = $request->admin_id;
        $model->category = $request->category;
        $model->sent_type = $request->sent_type;
        $model->title = $request->title;
        $model->content = $request->content;
        $model->image = $request->image_name;
        $model->status = $request->status;
        $model->slug = $request->slug;
        $model->save();
        return $model;
    }

    public function saveRelation($notifyId, $building)
    {
        foreach ($building as $value) {
            // $relation = NotifyRelationship::where(['notify_id'=> $notifyId,'building_id'=>$value])->first();
            // if ($relation == null) {
                $relation = new NotifyRelationship();
            // }
            $relation->building_id = $value;
            $relation->notify_id = $notifyId;
            $relation->save();
        }
    }

    public function saveImage($file)
    {
        $fileName = $file->getClientOriginalName();
        $fileExt = $file->getClientOriginalExtension();

        while (file_exists("images/" . $fileName)) {
            $fileName = strtotime("now") . '.' . $fileExt;
        }
        $file->move('images/', $fileName);
        return $fileName;
    }

    public function checkSlug($title)
    {
        $slug = Str::slug($title, '-');
        $check = Notification::where("slug", $slug)->count();
        if($check >0){
            return false;
        }
        return $slug;
    }
}
