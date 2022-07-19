<?php

namespace App\Http\Controllers\Admin\Custommer;

use App\Http\Controllers\Admin\BaseBuildingController;
use App\Models\Apartment;
use App\Models\ApartmentsRelationship;
use App\Models\Building;
use App\Models\Customer;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use App\Repositories\Eloquent\ApartmentRepository;
use App\Repositories\Eloquent\BuildingRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;

class ApartmentController extends BaseBuildingController
{
    protected $apartmentModel;
    public function __construct(BuildingRepository $building, ApartmentRepository $apartment)
    {

        $this->buildingModel = $building;
        $this->buildingList = $building->getListActive();
        $this->apartmentModel = $apartment;
    }
    public function showApartmentList(Request $request)
    {
        $data = [];
        $data['menu'] = ["menu-customers", "item-apartment"];
        $data['buildingActive'] = $this->getBuildingActive();
        $data['buildingList'] = $this->buildingList;

        $apartmentList = Apartment::where('building_id', $data['buildingActive'])->get();
        $list = [];
        foreach ($apartmentList as $value) {
            if ($value->owner_id != null) {
                $owner = Customer::find($value->owner_id);
                if ($owner != null)
                    $value->owner = $owner->name;
                else $value->owner = 'noName';
            }
            $value->vehicle_number = Vehicle::where('apartment_id', $value->id)->count();
        }
        $data['apartmentList'] = $apartmentList;

        $check = Apartment::where("building_id",  $data['buildingActive'])->count();
        $apartmentCount = Building::find( $data['buildingActive']);
        $addCreate ="true";
        if($check >= $apartmentCount->apartment_number){
            $addCreate ="false";
        }
        $data['addCreate']=$addCreate;
        return view('customer.apartment', $data);
    }

    public function showNewApartment(Request $request)
    {
        $data = [];
        $data['menu'] = ["menu-customers", "item-apartment"];
        $data['typePage'] = 'new';
        $data['title'] = 'Thêm mới căn hộ';
        $data['routeAjax'] = route('admin.customers.apartment-create');
        $data['methodAjax'] = 'post';
        $data['buildingActive'] = $this->getBuildingActive();
        $data['buildingActiveInfo'] = $this->buildingModel->find($data['buildingActive']);
        $data['buildingList'] = $this->buildingList;
        $customers = Customer::all();
        $data['customers'] = $customers;

        return view('customer.apartment-detail', $data);
    }
    public function create(Request $request)
    {
        $validate = Validator::make(
            $request->all(),
            [
                'name' => ['string', 'required', 'max:50'],
                'apartment_code' => 'string|required',
                'building_id' => 'integer|required',
                'description' => ['string'],
                'status' => ['string', 'in:using,empty,absent', 'required'],
                'floor' => 'integer|required',
            ]
        );

        if ($validate->fails()) {
            return new JsonResponse(['errors' => $validate->getMessageBag()->toArray()], 406);
        }
        $check = Apartment::where('building_id', $this->getBuildingActive())->where('apartment_code', $request->apartment_code)->first();
        if ($check != null) {
            return new JsonResponse(['errors' => ['apartment_code' => 'Mã căn hộ bị trùng']], 406);
        }

        $check = Apartment::where("building_id",  $this->getBuildingActive())->count();
        $apartmentCount = Building::find( $this->getBuildingActive())->apartment_number;
        if($check >= $apartmentCount){
            return new JsonResponse(['errors' => 'full'], 406);
        }
        try {
            $new = new Apartment();
            $new = $this->saveDataApartment($new, $request);
        } catch (\Throwable $th) {
            return new JsonResponse(['errors' => ['Lỗi insert data']], 406);
        }
        return new JsonResponse(['success'], 200);
    }

    public function importExcel(Request $request)
    {
        $validate = Validator::make(
            $request->all(),
            [
                'data' => ['string', 'required'],
            ]
        );

        if ($validate->fails()) {
            return new JsonResponse(['errors' => $validate->getMessageBag()->toArray()], 406);
        }
        $codeDataError = [];
        $data = json_decode($request->data);

        foreach ($data as $key => $value) {
            $check = Apartment::where('apartment_code', $value->apartment_code)->first();
            if ($check != null) {
                array_push($codeDataError,  $value->apartment_code);
                continue;
            }
            $check = Apartment::where("building_id", $value->building_id)->count();
            $apartmentCount = Building::find($value->building_id)->apartment_number;
            if($check >= $apartmentCount){
                array_push($codeDataError,  $value->apartment_code);
                continue;
            }
            try {
                $apart = new Apartment();
                $apart->name = $value->name;
                $apart->apartment_code = $value->apartment_code;
                $apart->building_id = $value->building_id;
                $apart->status = $value->status;
                $apart->floor = $value->floor;
                if (isset($value->owner_id)) {
                    $apart->owner_id = $value->owner_id;
                }
                $apart->save();
            } catch (\Throwable $th) {
                array_push($codeDataError,  $value->apartment_code);
                continue;
            }
        }
        if(sizeof($codeDataError) >0){
            return new JsonResponse(['codeDataError'=>$codeDataError], 406);
        }
        return new JsonResponse(['success'], 200);
    }

    public function showUpdate($id)
    {
        $apartment = Apartment::find($id);
        $data = [];
        $data['menu'] = ["menu-customers", "item-apartment"];
        $data['typePage'] = 'edit';
        $data['title'] = 'Chi tiết căn hộ';
        $data['routeAjax'] = route('admin.customers.apartment-update');
        $data['methodAjax'] = 'put';
        $data['apartment'] = $apartment;
        $data['buildingActive'] = $this->getBuildingActive();
        if ($apartment->building_id != $data['buildingActive']) {
            return redirect()->route("admin.customers.apartment-list");
        }
        $data['buildingActiveInfo'] = $this->buildingModel->find($data['buildingActive']);
        $data['buildingList'] = $this->buildingList;
        $customers = Customer::all();
        $data['customers'] = $customers;
        $apartmentCustomer = Customer::where('apartment_id', $id)->get();
        $apartmentVehicle = Vehicle::where("apartment_id", $apartment->id)->get();
        $data['apartmentCustomer'] = $apartmentCustomer;
        $data['apartmentVehicle'] = $apartmentVehicle;
        return view('customer.apartment-detail', $data);
    }

    public function update(Request $request)
    {
        $validate = Validator::make(
            $request->all(),
            [
                'id' => 'required|integer',
                'name' => ['string', 'required', 'max:50'],
                'apartment_code' => 'string|required',
                'building_id' => 'integer|required',
                'description' => ['string'],
                'status' => ['string', 'in:using,empty,absent', 'required'],
                'floor' => 'integer|required',
            ]
        );

        if ($validate->fails()) {
            return new JsonResponse(['errors' => $validate->getMessageBag()->toArray()], 406);
        }
        $edit = Apartment::find($request->id);
        if ($edit->apartment_code != $request->apartment_code) {
            $check = Apartment::where('building_id', $this->getBuildingActive())->where('apartment_code', $request->apartment_code)->count();
            if ($check > 0) {
                return new JsonResponse(['errors' => ['apartment_code' => 'Mã căn hộ bị trùng']], 406);
            }
        }
        try {
            $edit = $this->saveDataApartment($edit, $request);
        } catch (\Throwable $th) {
            return new JsonResponse(['errors' => ['Lỗi insert data']], 406);
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
                Apartment::whereIn('id', $id)->delete();
            } catch (\Throwable $th) {
                return new JsonResponse(['errors' => ' lỗi truy vấn'], 406);
            }
            return new JsonResponse(['deleted'], 200);
        }
        return new JsonResponse(['errors' => 'không có id'], 406);
    }

    public function saveDataApartment($apartment, $request)
    {
        $apartment->name = $request->name;
        $apartment->apartment_code = $request->apartment_code;
        $apartment->building_id = $request->building_id;
        $apartment->owner_id = $request->owner_id;
        $apartment->status = $request->status;
        $apartment->floor = $request->floor;
        $apartment->description = $request->description;
        $apartment->save();
        return $apartment;
    }
}
