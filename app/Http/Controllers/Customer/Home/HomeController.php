<?php

namespace App\Http\Controllers\Customer\Home;

use App\Http\Controllers\Controller;
use App\Jobs\PushNotificationJob;
use App\Models\Admin;
use App\Models\Customer;
use App\Models\Notification;
use App\Models\NotifyRelationship;
use App\Repositories\Eloquent\ApartmentRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Claims\Custom;
use Kutia\Larafirebase\Facades\Larafirebase;

class HomeController extends Controller
{
    protected $apartmentModel;


    public function __construct(ApartmentRepository $apartment)
    {

        $this->apartmentModel = $apartment;
    }

    public function showHome(Request $request)
    {
        $data = [];
        $data['menu'] = 'home';
        $buildingId = $this->apartmentModel->getBuildingListForCustomer(Auth::user()->id);
        // dd($buildingId);
        $notify = NotifyRelationship::whereIn('building_id', $buildingId)->join('notifications', 'notifications.id', 'notify_id')->where('status', 'public')->orderBy('notifications.id', 'desc')->paginate(10);
        $data['list'] = $notify;
        return view('page-customer.home', $data);
    }

    public function showNotifyDetail($id, $title )
    {
        $notify = Notification::find($id);
        $admin = Admin::find($notify->admin_id);
        if($notify->status != 'public'){
            abort(404);
        }
        $data = [];
        $data['item'] = $notify;
        $data['admin'] = $admin;
        return view('page-customer.notify-detail', $data);
    }

    public function updateDeviceKey(Request $request)
    {
        try{

            $userCurrent = Customer::find(Auth::user()->id);
            $userCurrent->device_key=$request->token;
            $userCurrent->save();
            return response()->json([
                'success'=>true, $request->all()
            ]);
        }catch(\Exception $e){
            report($e);
            return response()->json([
                'success'=>false,$request->all()
            ],500);
        }

    }

    public function notification(Request $request){
        $deviceTokens = Customer::whereNotNull('device_key')->pluck('device_key')->toArray();

    PushNotificationJob::dispatch('sendBatchNotification', [
        $deviceTokens,
        [
            'topicName' => 'birthday',
            'title' => 'Chúc mứng sinh nhật',
            'body' => 'Chúc bạn sinh nhật vui vẻ',
            'image' => 'https://picsum.photos/536/354',
        ],
    ]);

    }


    public function pushNotification()
    {

        // $data=[];
        // $data['message']= "Some message";

        // $data['booking_id']="my booking booking_id";

        $fcmTokens = Customer::whereNotNull('device_key')->pluck('device_key')->toArray();

        // $response = $this->sendFirebasePush($fcmTokens,$data);
        var_dump( $fcmTokens);
        // $fcmTokens=["xxxx"];
        $dataEndCode = json_encode([
            "registration_ids" => $fcmTokens,
            "notification" => [
                "title" => 'Thông báo thử nghiệm',
                "body" => "Some message",
            ]
        ]);

        $headerRequest = [
            'Authorization: key=' . env('FIREBASE_SERVER_KEY'),
            'Content-Type: application/json'
        ];
        // FIRE_BASE_FCM_KEY mình có note ở phần 2.setting firebase nhé

          // CURL
          $ch = curl_init();
          curl_setopt($ch, CURLOPT_URL, env('FIRE_BASE_URL'));
          //FIRE_BASE_URL = https://fcm.googleapis.com/fcm/send
          curl_setopt($ch, CURLOPT_POST, true);
          curl_setopt($ch, CURLOPT_HTTPHEADER, $headerRequest);
          curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
          curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
          curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
          curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
          curl_setopt($ch, CURLOPT_POSTFIELDS, $dataEndCode);
        // Mục đích mình đưa các tham số kia vào env để tùy biến nhé
        $output = curl_exec($ch);
        if ($output === FALSE) {
            echo 'Curl error: ' . curl_error($ch);
        }
        curl_close($ch);
        echo $output;

    }
    public function sendFirebasePush($tokens, $data)
    {

        $serverKey = env("FIREBASE_SERVER_KEY");

        // prep the bundle
        $msg = array
        (
            'message'   => $data['message'],
            'booking_id' => $data['booking_id'],
        );

        $notifyData = [
             "body" => $data['message'],
             "title"=> "Port App"
        ];

        $registrationIds = $tokens;

        if(count($tokens) > 1){
            $fields = array
            (
                'registration_ids' => $registrationIds, //  for  multiple users
                'notification'  => $notifyData,
                'data'=> $msg,
                'priority'=> 'high'
            );
        }
        else{

            $fields = array
            (
                'to' => $registrationIds[0], //  for  only one users
                'notification'  => $notifyData,
                'data'=> $msg,
                'priority'=> 'high'
            );
        }

        $headers[] = 'Content-Type: application/json';
        $headers[] = 'Authorization: key='. $serverKey;

        $ch = curl_init();
        curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );
        curl_setopt( $ch,CURLOPT_POST, true );
        curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
        curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
        // curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
        curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
        $result = curl_exec($ch );
        if ($result === FALSE)
        {
            die('FCM Send Error: ' . curl_error($ch));
        }
        curl_close( $ch );
        echo $result;
        return $result;
    }

}
