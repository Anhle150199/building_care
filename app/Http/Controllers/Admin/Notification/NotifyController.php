<?php

namespace App\Http\Controllers\Admin\Notification;

use App\Http\Controllers\Admin\BaseBuildingController;
use App\Models\Building;
use App\Models\Notification;
use App\Models\NotifyRelationship;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

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

    }

    public function showCreate()
    {
        $data=$this->generalData();
        $data['typePage'] = 'new';
        $data['title'] = 'Soạn thông báo';
        $data['routeAjax'] = route('admin.notification.create');
        $data['methodAjax'] = 'post';
        return view('notify.detail', $data);
    }
    public function showUpdate($id)
    {

    }

    public function create(Request $request)
    {
        $validate = Validator::make(
            $request->all(),
            [
                'title' => [ 'required', 'string'],
                'content' => 'string|required',
                'status' => 'string|required|in:public,private',
                'category' => ['string', 'in:event,notify', 'required'],
                'sent_type' => ['integer', 'in:0,1', 'required'],
            ]
        );

        if ($validate->fails()) {
            return new JsonResponse(['errors' => $validate->getMessageBag()->toArray()], 406);
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
                    array_push($list,$value->id);
                }
                $building = $list;
            } else{
                $building = json_decode($request->building_select);
            }
            $this->saveRelation($new->id, $building);
        } catch (\Throwable $th) {
            return new JsonResponse(['errors' => ['Lỗi insert data.']], 406);
        }
        // Todo push notification "Có thông báo mới"

        return new JsonResponse(['success'], 200);
    }

    public function update(Request $request)
    {

    }

    public function delete(Request $request)
    {

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
        $model->save();
        return $model;
    }

    public function saveRelation($notifyId, $building)
    {
        // NotifyRelationship::where('notify_id', $notifyId)->delete();
        foreach ($building as $value) {
            $relation = new NotifyRelationship();
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
            $fileName = strtotime("now") .'.'. $fileExt;
        }
        $file->move('images/', $fileName);
        return $fileName;
    }
}
