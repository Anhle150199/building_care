<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Jobs\PushNotificationJob;
use App\Models\Admin;
use App\Models\Apartment;
use App\Models\Customer;
use App\Models\Notification;
use App\Models\NotifyRelationship;
use App\Models\PushNotify;
use App\Models\Vehicle;
use App\Repositories\Eloquent\ApartmentRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class VehicleController extends Controller
{
    protected $apartmentModel;


    public function __construct(ApartmentRepository $apartment)
    {

        $this->apartmentModel = $apartment;
    }

    public function show()
    {
        $data = [];
        $data['menu'] = '';
        $apartments1 = Apartment::where('owner_id', Auth::user()->id)->get();
        $apartments2 = Customer::find(Auth::user()->id);
        $list = [];
        foreach ($apartments1 as $key => $value) {
            array_push($list, $value->id);
        }
        if ($apartments2->apartment_id != null)
            array_push($list, $apartments2->apartment_id);
        // dd($list);
        $vehicle = Vehicle::whereIn('apartment_id', $list)->join('apartments', 'apartments.id', 'apartment_id')->select('vehicle.id', 'vehicle.category', 'vehicle.model', "vehicle.license_plate_number", 'vehicle.description', 'vehicle.updated_at', 'vehicle.status', 'apartments.name', 'apartments.apartment_code')->get();
        // dd($buildingId);

        $data['list'] = $vehicle;
        return view('page-customer.vehicle.vehicle', $data);
    }

    public function showForm()
    {
        $data = [];
        $data['menu'] ='';
        $data['title'] ='Thêm phương tiện';
        $apartments1 = Apartment::where('owner_id', Auth::user()->id)->get();
        $apartments2 = Customer::find(Auth::user()->id);
        $list = [];
        $check = 0;
        foreach ($apartments1 as $key => $value) {
            array_push($list, $value);
            if($apartments2->apartment_id == $value->id){
                $check =1;
            }
        }
        if ($check != 0){
            $apartment = Apartment::find($apartments2->apartment_id);
            array_push($list, $apartment);
        }
        $data['list'] = $list;
        return view('page-customer.vehicle.form-request', $data);
    }

    public function create(Request $request)
    {
        $validate = Validator::make(
            $request->all(),
            [
                'apartment_id' => [ 'required', 'exists:apartments,id'],
                'license_plate_number' => 'string|required|unique:vehicle,license_plate_number',
                'model' => 'string|required',
                'category' => ['string', 'in:motorbike,electric_motorbike,car', 'required'],
            ]
        );

        if ($validate->fails()) {
            return new JsonResponse(['errors' => $validate->getMessageBag()->toArray()], 406);
        }
        try {

            $model = new Vehicle();
            $model->apartment_id = $request->apartment_id;
            $model->category = $request->category;
            $model->model = $request->model;
            $model->license_plate_number = $request->license_plate_number;
            $model->description = $request->description;
            $model->status = 'request';
            $model->save();

        } catch (\Throwable $th) {
            return new JsonResponse(['errors' => ['Lỗi insert data cu dan']], 406);
        }
        // Todo push notification "Phương tiện đã được thêm"
        $apartment = Apartment::find($model->apartment_id);
        $adminId = Admin::pluck("id")->toArray();
        $pushNotify = new PushNotify();
        $pushNotify->category= "vehicle";
        $pushNotify->item_id = $model->id;
        $pushNotify->title = "Căn hộ".$apartment->apartment_code.": Có phương tiện đăng ký mới";
        $pushNotify->body = $model->model;
        $pushNotify->type_user = "admin";
        $pushNotify->click_action = route('admin.customers.vehicle-request')."?id=".$apartment->building_id;
        $pushNotify->receive_id = json_encode($adminId);
        $pushNotify->save();

        $deviceTokens = Admin::whereNotNull('device_key')->pluck('device_key')->toArray();

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

        return new JsonResponse(['success'], 200);

    }
    public function delete(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'id'=>'required|integer|exists:vehicle,id'
        ]);
        if ($validator->fails()) {
            return new JsonResponse(['errors'=>$validator->getMessageBag()->toArray()], 406);
        }
        try {
            Vehicle::where('id', $request->id)->delete();
        } catch (\Throwable $th) {
            return new JsonResponse(['errors'=>'Have error'], 406);
        }
        return new JsonResponse(['success'], 200);
    }
}
