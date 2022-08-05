<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\MaintenanceSchedule;
use App\Repositories\Eloquent\ApartmentRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MaintenanceController extends Controller
{
    protected $apartmentModel;
    public function __construct(ApartmentRepository $apartment)
    {
        $this->apartmentModel = $apartment;
    }
    public function show()
    {
        $data = [];
        $data['title'] = 'Lịch bảo trì';
        $list = $this->apartmentModel->getBuildingListForCustomer(Auth::user()->id);
        $maintenance = MaintenanceSchedule::whereIn('building_id', $list)->where('end_at',">=", now())->orderBy('start_at', 'desc')
        ->join('building', 'building.id', 'maintenance_schedule.building_id')
        ->select('title', "maintenance_schedule.description", "start_at", 'end_at', 'location', "name")->get();

        $data['list']=$maintenance;
        return view('page-customer.maintenance', $data);
    }
}
