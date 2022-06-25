<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\BaseBuildingController;
use App\Models\Apartment;
use App\Models\Customer;
use App\Models\MaintenanceSchedule;
use App\Models\Notification;
use App\Models\NotifyRelationship;
use App\Models\Vehicle;
use App\Repositories\Eloquent\BuildingRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends BaseBuildingController
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $data = [];
        $data['menu'] = ["menu-dashboard"];
        $data['buildingActive'] = $this->getBuildingActive();
        $data['buildingList'] = $this->buildingList;
        $data['buildingActiveInfo'] = $this->buildingModel->find($data['buildingActive']);

        $maintenance_schedule = MaintenanceSchedule::where('building_id', $data['buildingActive'])->orderBy('start_at', 'desc')->limit('5')->get();
        foreach($maintenance_schedule as $value){
            $value->start_at = date("d/m/Y", strtotime($value->start_at));
            $value->end_at = date("d/m/Y", strtotime($value->end_at));
        }
        $data['maintenance_schedule']=$maintenance_schedule;

        $apartment = Apartment::where('building_id', $data['buildingActive'])->get('id');
        $data['apartmentCount'] = sizeof($apartment->toArray());

        $customerCount = Customer::whereIn('apartment_id', $apartment->toArray())->count();
        $data['customerCount'] = $customerCount;

        $vehicleCount = Vehicle::whereIn('apartment_id', $apartment->toArray())->where('status', 'accept')->count();
        $data['vehicleCount'] = $vehicleCount;

        $notifications = NotifyRelationship::where('building_id', $data['buildingActive'])->join('notifications', 'notify_id', 'notifications.id')
        ->select('notifications.id', 'notifications.title', 'notifications.status', 'notifications.category')->orderBy('id', 'desc')->limit('5')->get();
        $data['notifications'] = $notifications;

        return view('home', $data);
    }
}
