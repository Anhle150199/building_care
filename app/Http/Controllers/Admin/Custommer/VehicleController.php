<?php

namespace App\Http\Controllers\Admin\Custommer;

use App\Http\Controllers\Admin\BaseBuildingController;
use Illuminate\Http\Request;
use App\Models\Apartment;
use App\Models\Vehicle;
use App\Repositories\Eloquent\ApartmentRepository;
use App\Repositories\Eloquent\BuildingRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;

class VehicleController extends BaseBuildingController
{
    protected $apartmentModel;
    public function __construct(BuildingRepository $building, ApartmentRepository $apartment)
    {

        $this->buildingModel = $building;
        $this->buildingList = $building->getListActive();
        $this->apartmentModel = $apartment;
    }

    public function generalData()
    {
        $data = [];
        $data['menu'] = ["menu-customers", "item-vehicle"];
        $data['buildingActive'] = $this->getBuildingActive();
        $data['buildingList'] = $this->buildingList;
        return $data;
    }
    public function showList(Request $request)
    {
        $data = $this->generalData();

        $apartmentIdList = $this->apartmentModel->getApartmentList($data['buildingActive']);

        $list = Vehicle::whereIn('apartment_id', $apartmentIdList)->where('status', 'accept')->get();
        foreach ($list as $item) {
            $apartment = Apartment::find($item->apartment_id);
            $item->apartment = $apartment;
        }
        $data['list'] = $list;
        $data['typePage'] = "accept";
        $data['title'] = 'Danh sách phương tiện';
        return view('customer.vehicle', $data);
    }

    public function showRequest(Request $request)
    {
        $data = $this->generalData();
        $apartmentIdList = $this->apartmentModel->getApartmentList($data['buildingActive']);

        $list = Vehicle::whereIn('apartment_id', $apartmentIdList)->where('status', 'request')->get();
        foreach ($list as $item) {
            $apartment = Apartment::find($item->apartment_id);
            $item->apartment = $apartment;
        }
        $data['list'] = $list;
        $data['typePage'] = "request";
        $data['title'] = 'Đăng ký phương tiện';

        return view('customer.vehicle', $data);
    }

    public function showCreate(Request $request)
    {
        $data = $this->generalData();
        $data['typePage'] = 'new';
        $data['title'] = 'Thêm mới phương tiện';
        $data['routeAjax'] = route('admin.customers.vehicle-create');
        $data['methodAjax'] = 'post';

        $apartments = Apartment::where('building_id', $data['buildingActive'])->get();
        $data['apartments'] = $apartments;
        return view('customer.vehicle-detail', $data);
    }

    public function showUpdate($id)
    {
        $data = $this->generalData();

        $vehicle = Vehicle::find($id);
        $data['typePage'] = 'edit';
        $data['title'] = 'Chi tiết phương tiện';
        $data['routeAjax'] = route('admin.customers.vehicle-update');
        $data['methodAjax'] = 'put';
        $data['item'] = $vehicle;

        $apartments = Apartment::where('building_id', $data['buildingActive'])->get();
        $data['apartments'] = $apartments;

        return view('customer.vehicle-detail', $data);
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
            $request->status = 'accept';
            $vehicle = new Vehicle();
            $vehicle = $this->saveData($vehicle, $request);
        } catch (\Throwable $th) {
            return new JsonResponse(['errors' => ['Lỗi insert data cu dan']], 406);
        }
        // Todo push notification "Phương tiện đã được thêm"

        return new JsonResponse(['success'], 200);
    }
    public function update(Request $request)
    {
        $validate = Validator::make(
            $request->all(),
            [
                'id' => 'required|integer|exists:vehicle,id',
                'apartment_id' => [ 'required', 'exists:apartments,id'],
                'license_plate_number' => 'string|required',
                'model' => 'string|required',
                'category' => ['string', 'in:motorbike,electric_motorbike,car', 'required'],
            ]
        );

        if ($validate->fails()) {
            return new JsonResponse(['errors' => $validate->getMessageBag()->toArray()], 406);
        }
        $edit = Vehicle::find($request->id);
        if($edit->license_plate_number != $request->license_plate_number && Vehicle::where('license_plate_number', $request->license_plate_number)->count() != 0){
            return new JsonResponse(['errors' => ['license_plate_number' => 'Biển số xe bị trùng']], 406);
        }
        try {
            $request->status = $edit->status;
            $edit = $this->saveData($edit, $request);
        } catch (\Throwable $th) {
            return new JsonResponse(['errors' => ['Lỗi insert data phuong tien']], 406);
        }

        // Todo push notification "Phương tiện đã được cập nhật"

        return new JsonResponse(['success'], 200);
    }

    public function accept(Request $request)
    {
        if ($request->has('id')) {
            $id = $request->id;
            if (sizeof($id) == 0) {
                return new JsonResponse(['errors' => 'input rỗng'], 406);
            }
            try {
                Vehicle::whereIn('id', $id)->update([
                    'status'=>'accept'
                ]);
            } catch (\Throwable $th) {
                return new JsonResponse(['errors' => ' lỗi truy vấn'], 406);
            }
            return new JsonResponse(['accepted'], 200);
        }
        return new JsonResponse(['errors' => 'không có id'], 406);
    }

    public function delete(Request $request)
    {
        if ($request->has('id')) {
            $id = $request->id;
            if (sizeof($id) == 0) {
                return new JsonResponse(['errors' => 'input rỗng'], 406);
            }
            try {
                Vehicle::whereIn('id', $id)->delete();
            } catch (\Throwable $th) {
                return new JsonResponse(['errors' => ' lỗi truy vấn'], 406);
            }
            return new JsonResponse(['deleted'], 200);
        }
        return new JsonResponse(['errors' => 'không có id'], 406);
    }

    public function saveData($model, $request)
    {
        $model->apartment_id = $request->apartment_id;
        $model->category = $request->category;
        $model->model = $request->model;
        $model->license_plate_number = $request->license_plate_number;
        $model->description = $request->description;
        $model->status = $request->status;
        $model->save();
        return $model;
    }
}
