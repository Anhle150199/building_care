<?php

namespace App\Http\Controllers\Admin\Support;

use App\Http\Controllers\Admin\BaseBuildingController;
use App\Http\Controllers\Customer\SupportController as CustomerSupportController;
use App\Jobs\PushNotificationJob;
use App\Mail\NotifyEmail;
use App\Models\Admin;
use App\Models\Building;
use App\Models\Customer;
use App\Models\Department;
use App\Models\Feedback;
use App\Models\Notification;
use App\Models\NotifyRelationship;
use App\Models\PushNotify;
use App\Models\ReplyFeedback;
use App\Models\SentMail;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class SupportController extends BaseBuildingController
{

    public function generalData()
    {
        $data = [];
        $data['menu'] = ["menu-support"];
        $data['buildingActive'] = $this->getBuildingActive();
        $data['buildingList'] = $this->buildingList;
        return $data;
    }

    public function showList()
    {
        $data = $this->generalData();
        $role = Auth::user()->role;
        if ($role == 'super') {
            $list = Feedback::join('departments', "departments.id", "department_id")
                ->join('customers', "customers.id", "customer_id")->orderBy('feedback.id', 'desc')
                ->select('feedback.id', 'feedback.customer_id', 'feedback.admin_id', 'feedback.title', 'feedback.status', 'feedback.created_at', 'departments.name as department', "customers.name as customer")->get();;
        } else {
            $list = Feedback::where('department_id', Auth::user()->department_id)->join('departments', "departments.id", "department_id")
                ->join('customers', "customers.id", "customer_id")->orderBy('feedback.id', 'desc')
                ->select('feedback.id', 'feedback.customer_id', 'feedback.admin_id', 'feedback.title', 'feedback.status', 'feedback.created_at', 'departments.name as department', "customers.name as customer")->get();
        }
        foreach ($list as $key => $value) {
            if ($value->admin_id != null) {
                $value->admin_name = Admin::find($value->admin_id)->name;
            }
        }
        $data['list'] = $list;
        return view('support-admin.support', $data);
    }

    public function showDetail($id)
    {
        $data = $this->generalData();
        $feedback = Feedback::find($id);
        $department = Department::find($feedback->department_id);
        $user = Customer::find($feedback->customer_id);
        $data['feedback'] = $feedback;
        $data['user'] = $user;
        $data['department'] = $department;
        if ($feedback->admin_id != null) {
            $admin = Admin::find($feedback->admin_id);
            $data['admin'] = $admin;
        }
        $reply = ReplyFeedback::where('feedback_id', $id)->get();
        $data['reply'] = $reply;
        return view("support-admin.detail", $data);
    }

    public function acceptRequest(Request $request)
    {
        if ($request->has("feedback")) {
            $feedback = Feedback::find($request->feedback);
            $feedback->status = "processing";
            $feedback->admin_id = Auth::user()->id;
            $feedback->save();
            return redirect()->back();
        } else {
            return redirect()->back();
        }
    }

    public function close(Request $request)
    {
        if ($request->has("feedback")) {
            $feedback = Feedback::find($request->feedback);
            $feedback->status = "processed";
            $feedback->save();
            return redirect()->back();
        } else {
            return redirect()->back();
        }
    }

    public function reply(Request $request)
    {
        $valitator = Validator::make(
            $request->all(),
            [
                'feecback_id' => 'required|integer|exists:feedback,id',
                'content' => 'required|string'
            ]
        );
        if($valitator->fails()){
            return new JsonResponse(['errors'=>$valitator->getMessageBag()->toArray()], 406);
        }
        $reply = new ReplyFeedback();
        $reply->feedback_id = $request->feecback_id;
        $reply->content = $request->content;
        $reply->user_type = 0;
        $reply->image = json_encode(CustomerSupportController::saveImage($request->images));
        $reply->save();
        $reply->image = json_decode($reply->image);
        $reply->time = $reply->created_at->format('H:s d-m-Y');
        $reply->admin = Auth::user()->name;
        $reply->avatar = Auth::user()->avatar;

        $feedback = Feedback::find($request->feecback_id);
        if ($feedback->customer_id != null) {
                // Todo push notification
                $pushNotify = new PushNotify();
                $pushNotify->category= "support";
                $pushNotify->item_id = $feedback->id;
                $pushNotify->title = "Admin đã trả lờibạn";
                $pushNotify->body = $feedback->title;
                $pushNotify->type_user = "customer";
                $pushNotify->click_action = route('user.support.show-detail', ['id'=> $feedback->id]);
                $pushNotify->receive_id = json_encode([$feedback->customer_id]);
                $pushNotify->save();

                $deviceTokens = Admin::where("id", $feedback->admin_id)->whereNotNull('device_key')->pluck('device_key')->toArray();

                // $deviceTokens = Customer::where('apartment_id', $apartment->id)->whereNotNull('device_key')->pluck('device_key')->toArray();

                PushNotificationJob::dispatch('sendBatchNotification', [
                    $deviceTokens,
                    [
                        'topicName' => $pushNotify->category,
                        'title' => $pushNotify->title,
                        'body' => $pushNotify->body,
                        'click_action' => $pushNotify->click_action,
                        'image'=>"<i class=\"bi bi-chat-right-dots\"></i>"
                    ],
                ]);
            }
        return new JsonResponse($reply->toArray(), 200);
    }

}
