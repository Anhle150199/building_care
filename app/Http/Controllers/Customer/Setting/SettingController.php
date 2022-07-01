<?php

namespace App\Http\Controllers\Customer\Setting;

use App\Http\Controllers\Controller;
use App\Jobs\PushNotificationJob;
use App\Models\Admin;
use App\Models\Customer;
use App\Models\Notification;
use App\Models\NotifyRelationship;
use App\Repositories\Eloquent\ApartmentRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Claims\Custom;
use Kutia\Larafirebase\Facades\Larafirebase;

class SettingController extends Controller
{
    protected $apartmentModel;


    public function __construct(ApartmentRepository $apartment)
    {

        $this->apartmentModel = $apartment;
    }

    public function show(Request $request)
    {
        $data = [];
        $data['menu'] = 'setting';
        return view('page-customer.setting.setting', $data);
    }

    public function showProfile()
    {
        $data = [];
        $data['title'] = "Thông tin tài khoản";
        $data['user'] = Auth::user();
        return view('page-customer.setting.profile', $data);
    }

    public function updateProfile(Request $request)
    {
        $validate = Validator::make(
            $request->all(),
            [
                'name' => ['string', 'required', 'max:50'],
                'birthday' => 'required',
                'email' => ['required', 'string']
            ]
        );

        if ($validate->fails()) {
            return new JsonResponse(['errors' => $validate->getMessageBag()->toArray()], 406);
        }

        $edit = Customer::find(Auth::user()->id);
        try {

            $edit->name = $request->name;
            $edit->phone = $request->phone;
            if ($edit->email != $request->email) {
                $check = Customer::where('email', $request->email)->count();
                if ($check == 0)
                    $edit->email = $request->email;
            }
            $edit->birthday = $request->birthday;
            $edit->save();
        } catch (\Throwable $th) {
            return new JsonResponse(['errors' => ['Lỗi insert data']], 406);
        }

        return new JsonResponse(['success'], 200);
    }
}
