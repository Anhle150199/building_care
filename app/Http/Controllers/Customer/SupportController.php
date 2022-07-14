<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Jobs\PushNotificationJob;
use App\Models\Admin;
use App\Models\Customer;
use App\Models\Department;
use App\Models\Feedback;
use App\Models\FeedbackType;
use App\Models\Notification;
use App\Models\NotifyRelationship;
use App\Models\PushNotify;
use App\Models\PushNotifyRelationship;
use App\Models\ReplyFeedback;
use App\Repositories\Eloquent\ApartmentRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Claims\Custom;
use Kutia\Larafirebase\Facades\Larafirebase;
use Intervention\Image\Facades\Image;

class SupportController extends Controller
{
    public function showList(Request $request)
    {
        $data = [];
        $data['menu'] = 'support';
        $data['departments'] = Department::orderBy('name', 'asc')->get();
        $data['categories'] = FeedbackType::all();
        $list = Feedback::where('customer_id', Auth::user()->id)->join('departments', 'departments.id', 'department_id')->orderBy('id', 'desc')
        ->select('departments.name', 'feedback.id', 'feedback.title', 'feedback.content', 'feedback.image', 'feedback.status', 'feedback.updated_at', 'feedback.created_at' )
        ->paginate(10);
        $data['list'] =$list;
        // dd( $data['list']);
        return view('page-customer.support.list', $data);
    }

    public function showDetail($id)
    {
        $data = [];
        $feedback = Feedback::find($id);
        $reply = ReplyFeedback::where('feedback_id', $id)->get();
        $data['reply'] = $reply;

        $data['title']= $feedback->title;
        $data['feedback']= $feedback;
        return view("page-customer.support.detail", $data);
    }

    public function create(Request $request)
    {

        $validate = Validator::make(
            $request->all(),
            [
                'to' => ['required', 'exists:departments,id'],
                'title' => 'required|string',
                'content' => ['required', 'string']
            ]
        );

        if ($validate->fails()) {
            return new JsonResponse(['errors' => $validate->getMessageBag()->toArray()], 406);
        }
        // return new JsonResponse(['errors' => $request->all()], 406);

        try {
        $newFb = new Feedback();
        $newFb->title = $request->title;
        $newFb->content = $request->content;
        $newFb->customer_id = $request->customer_id;
        $newFb->department_id = $request->to;
        $newFb->status = 'request';
        $newFb->customer_id = Auth::user()->id;
        $newFb->image = json_encode($this->saveImage($request->images));
        $newFb->save();

        } catch (\Throwable $th) {
            return new JsonResponse(['errors' => ['Lỗi insert data']], 406);
        }
        // Todo push notification
        $department = Department::find($newFb->department_id);
        $userList = Admin::where("department_id", $department->id)->pluck("id")->toArray();
        $pushNotify = new PushNotify();
        $pushNotify->category= "support";
        $pushNotify->item_id = $newFb->id;
        $pushNotify->title = " Có một thư mới";
        $pushNotify->body = $newFb->title;
        $pushNotify->type_user = "admin";
        $pushNotify->click_action = route('admin.support.show-detail', ['id'=> $newFb]);
        $pushNotify->receive_id = json_encode($userList);
        $pushNotify->save();

        PushNotifyRelationship::create([
            'apartment_id' => $department->id,
            'push_notify_id'=> $pushNotify->id,
        ]);
        $deviceTokens = Admin::where("department_id", $department->id)->whereNotNull('device_key')->pluck('device_key')->toArray();

        // $deviceTokens = Customer::where('apartment_id', $apartment->id)->whereNotNull('device_key')->pluck('device_key')->toArray();

        PushNotificationJob::dispatch('sendBatchNotification', [
            $deviceTokens,
            [
                'topicName' => $pushNotify->category,
                'title' => $pushNotify->title,
                'body' => $pushNotify->body,
                'click_action' => $pushNotify->click_action,
                'image'=>"<i class=\"bi bi-chat-right-dots\"></i>",
                "category"=>'support_request',
                "for"=>"admin",
            ],
        ]);
        return new JsonResponse(['success'], 200);
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
        $reply->user_type = 1;
        $reply->image = json_encode($this->saveImage($request->images));
        $reply->save();
        $reply->image = json_decode($reply->image);
        $reply->time = $reply->created_at->format('H:s d-m-Y');

        $feedback = Feedback::find($request->feecback_id);
        if ($feedback->admin_id != null) {
                // Todo push notification
            $pushNotify = new PushNotify();
            $pushNotify->category= "support";
            $pushNotify->item_id = $feedback->id;
            $pushNotify->title = Auth::user()->name." đã trả lời";
            $pushNotify->body = $reply->content;
            $pushNotify->type_user = "admin";
            $pushNotify->click_action = route('admin.support.show-detail', ['id'=> $feedback->id]);
            $pushNotify->receive_id = json_encode([$feedback->admin_id]);
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
                    'image'=>"<i class=\"bi bi-chat-right-dots\"></i>",
                    "category"=>'support_reply_admin',
                    "images_support"=> $reply->image,
                    "for"=>"admin",
                ],
            ]);
        }
        return new JsonResponse($reply->toArray(), 200);
    }

    public static function saveImage($images)
    {
        $list = [];
        if ($images == null)
            return $list;
        $folder = 'images/feedback';
        foreach ($images as $key => $param) {
            list($extension, $content) = explode(';', $param);
            $tmpExtension = explode('/', $extension);

            preg_match('/.([0-9]+) /', microtime(), $m);
            $fileName = sprintf('img%s%s.%s', date('YmdHis'), $m[1], $tmpExtension[1]);

            while (file_exists($folder . $fileName)) {
                preg_match('/.([0-9]+) /', microtime(), $m);
                $fileName = sprintf('img%s_%s.%s', date('YmdHis'), $m[1], $tmpExtension[1]);
            }

            Image::make(file_get_contents($param))->save(public_path() . "/" . $folder . '/' . $fileName);

            array_push($list, $fileName);
        }
        return $list;
    }

}
