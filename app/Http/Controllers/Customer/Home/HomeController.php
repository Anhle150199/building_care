<?php

namespace App\Http\Controllers\Customer\Home;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Notification;
use App\Models\NotifyRelationship;
use App\Repositories\Eloquent\ApartmentRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    protected $apartmentModel;


    public function __construct(ApartmentRepository $apartment)
    {

        $this->apartmentModel = $apartment;
    }

    public function showHome()
    {
        $data = [];
        $data['menu'] = 'home';
        $buildingId = $this->apartmentModel->getBuildingListForCustomer(Auth::user()->id);
        // dd($buildingId);
        $notify = NotifyRelationship::whereIn('building_id', $buildingId)->join('notifications', 'notifications.id', 'notify_id')->orderBy('notifications.id', 'desc')->paginate(10);
        $data['list'] = $notify;
        return view('page-customer.home', $data);
    }

    public function showNotifyDetail($id, $title )
    {
        $notify = Notification::find($id);
        $admin = Admin::find($notify->admin_id);
        $data = [];
        $data['item'] = $notify;
        $data['admin'] = $admin;
        return view('page-customer.notify-detail', $data);

    }
}
