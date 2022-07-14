<?php

namespace App\Http\Controllers\Admin\Custommer;

use App\Http\Controllers\Admin\BaseBuildingController;
use App\Jobs\MailJob;
use App\Mail\VerifyMail;
use App\Models\AccessToken;
use Illuminate\Http\Request;
use App\Models\Apartment;
use App\Models\Customer;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class CustommerController extends BaseBuildingController
{

    public function showCustomerList(Request $request)
    {
        $data = [];
        $data['menu'] = ["menu-customers", "item-customer"];
        $data['buildingActive'] = $this->getBuildingActive();
        $data['buildingList'] = $this->buildingList;
        $apartmentList = Apartment::where('building_id', $data['buildingActive'])->get(['id']);

        $customers = Customer::whereIn('apartment_id', $apartmentList->toArray())->orWhereNull('apartment_id')->get();
        $list = [];
        foreach ($customers as $value) {
            if ($value->apartment_id != null)
                $value->apartment = Apartment::where('id', $value->apartment_id)->first()->name;
        }
        $data['customersList'] = $customers;
        return view('customer.customers', $data);
    }

    public function showCreate(Request $request)
    {
        $data = [];
        $data['menu'] = ["menu-customers", "item-customer"];
        $data['typePage'] = 'new';
        $data['title'] = 'Thêm mới cư dân';
        $data['routeAjax'] = route('admin.customers.customer-create');
        $data['methodAjax'] = 'post';
        $data['buildingActive'] = $this->getBuildingActive();
        $data['buildingList'] = $this->buildingList;
        $apartments = Apartment::where('building_id', $data['buildingActive'])->get();
        $data['apartments'] = $apartments;

        return view('customer.customer-detail', $data);
    }

    public function create(Request $request)
    {
        $validate = Validator::make(
            $request->all(),
            [
                'name' => ['string', 'required', 'max:50'],
                'customer_code' => 'string|required|unique:customers,customer_code',
                'birthday' => 'required',
                'status' => ['string', 'in:stay,leave,absent', 'required'],
                'email' => ['required', 'string', 'unique:customers,email']
            ]
        );

        if ($validate->fails()) {
            return new JsonResponse(['errors' => $validate->getMessageBag()->toArray()], 406);
        }
        $check = Customer::where('customer_code', $request->customer_code)->first();
        if ($check != null) {
            return new JsonResponse(['errors' => ['customer_code' => 'Mã người dùng bị trùng']], 406);
        }
        try {
            $customer = new Customer();
            $new = $this->saveDataCustomer($customer, $request);
            // Gửi mail
            $token = AccessToken::createToken($new->id, 'verify-email','customer');
            $link = route('auth.verify-email', ['token'=>$token]); //1: admin, 0: user
            // $mailable = new VerifyMail($new->name, $link);
            // Mail::to($new->email)->send($mailable);
            MailJob::dispatch([
                'link'=>$link,
                "name"=>$new->name,
                "email" =>$new->email,
                'type'=>"verify",
            ]);
        } catch (\Throwable $th) {
            return new JsonResponse(['errors' => ['Lỗi insert data cu dan']], 406);
        }
        // if ($request->status != 'leave') {
        //     $apartment = Apartment::where('id', $request->apartment_id)->first();
        //     if ($apartment->status == 'empty') {
        //         $apartment->status = 'using';
        //         $apartment->save();
        //     }
        // }
        return new JsonResponse(['success'], 200);
    }

    public function showUpdate($id)
    {
        $customerCurrent = Customer::find($id);
        $data = [];
        $data['menu'] = ["menu-customers", "item-customer"];
        $data['typePage'] = 'edit';
        $data['title'] = 'Chi tiết cư dân';
        $data['routeAjax'] = route('admin.customers.customer-update');
        $data['methodAjax'] = 'put';
        $data['customerCurrent'] = $customerCurrent;
        $data['buildingActive'] = $this->getBuildingActive();
        $buildingCustomer = Apartment::find($customerCurrent->apartment_id)->building_id;
        if($buildingCustomer != $data['buildingActive'] ){
            return redirect()->route("admin.customers.customer-list");
        }
        $data['buildingList'] = $this->buildingList;
        $apartments = Apartment::where('building_id', $data['buildingActive'])->get();
        $data['apartments'] = $apartments;
        $ownedApartment = Apartment::where('owner_id', $id)->join('building', 'building_id', 'building.id')
            ->select('apartments.id as apartmentId', 'apartments.name as apartmentName', 'building.name as buildingName')->get();
        $data['ownedApartment'] = $ownedApartment;
        return view('customer.customer-detail', $data);
    }

    public function update(Request $request)
    {
        $validate = Validator::make(
            $request->all(),
            [
                'id' => 'required|integer',
                'name' => ['string', 'required', 'max:50'],
                'customer_code' => 'string|required',
                'birthday' => 'required',
                'status' => ['string', 'in:stay,leave,absent', 'required'],
                'email' => ['required', 'string']
            ]
        );

        if ($validate->fails()) {
            return new JsonResponse(['errors' => $validate->getMessageBag()->toArray()], 406);
        }
        $edit = Customer::find($request->id);
        if ($edit->customer_code != $request->customer_code) {
            $check = Customer::where('customer_code', $request->customer_code)->count();
            if ($check > 0) {
                return new JsonResponse(['errors' => ['customer_code' => 'Trường bị trùng']], 406);
            }
        }
        if ($edit->apartment_id != null) {
            $countCustomerApartment = Customer::where('apartment_id', $edit->apartment_id)->count();

            if ($edit->apartment_id != $request->apartment_id && $countCustomerApartment == 1) {
                    $oldApartmnet = Apartment::where('id', $edit->apartment_id)->first();
                    $oldApartmnet->status = 'absent';
                    $oldApartmnet->save();
            }
        }
        if($edit->email != $request->email){
            $count = Customer::where('email', $request->email)->count();
            if($count >0){
                return new JsonResponse(['errors' => ['email' => 'Email bị trùng']], 406);
            }
        }
        try {
            $edit = $this->saveDataCustomer($edit, $request);
        } catch (\Throwable $th) {
            return new JsonResponse(['errors' => ['Lỗi insert data']], 406);
        }
        // if ($request->status != 'leave') {
        //     $apartment = Apartment::where('id', $request->apartment_id)->first();
        //     if ($apartment->status == 'empty') {
        //         $apartment->status = 'using';
        //         $apartment->save();
        //     }
        // }

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
                Customer::whereIn('id', $id)->delete();
                Apartment::whereIn('owner_id', $id)->update(['owner_id'=>null, 'status'=>'empty']);
            } catch (\Throwable $th) {
                return new JsonResponse(['errors' => ' lỗi truy vấn'], 406);
            }
            return new JsonResponse(['deleted'], 200);
        }
        return new JsonResponse(['errors' => 'không có id'], 406);
    }
    public function saveDataCustomer($customer, $request)
    {
        $customer->name = $request->name;
        $customer->customer_code = $request->customer_code;
        $customer->birthday = $request->birthday;
        $customer->status = $request->status;
        $customer->email = $request->email;
        $customer->phone = $request->phone;
        $customer->apartment_id = $request->apartment_id;
        $customer->save();
        return $customer;
    }

    public function getUsers(Request $request)
    {
        $users = Customer::whereNotNull('email')->select('id as value', 'name', 'email')->get();
        return new JsonResponse($users, 200);
    }
}
