<?php

namespace App\Http\Controllers\Admin\Support;

use App\Http\Controllers\Admin\BaseBuildingController;
use App\Mail\NotifyEmail;
use App\Models\Admin;
use App\Models\Building;
use App\Models\Feedback;
use App\Models\Notification;
use App\Models\NotifyRelationship;
use App\Models\SentMail;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class SupportController extends BaseBuildingController
{

    public function generalData()
    {
        $data = [];
        $data['menu'] = ["menu-notify", "item-email"];
        $data['buildingActive'] = $this->getBuildingActive();
        $data['buildingList'] = $this->buildingList;
        return $data;
    }

    public function showList()
    {
        $data = $this->generalData();
        $role = Auth::user()->role;
        if($role == 'super'){
            $list = Feedback::join('departments', "departments.id", "department_id")
            ->join('customers', "customers.id", "customer_id")->orderBy('feedback.id', 'desc')
            ->select('feedback.id', 'feedback.title', 'feedback.status', 'feedback.created_at', 'departments.name as department', "customers.name as customer")->get();
            ;
        }else {
            $list = Feedback::where('department_id', Auth::user()->department_id)->join('departments', "departments.id", "department_id")
            ->join('customers', "customers.id", "customer_id")->orderBy('feedback.id', 'desc')
            ->select('feedback.id', 'feedback.title', 'feedback.status', 'feedback.created_at', 'departments.name as department', "customers.name as customer")->get();
        }
        foreach ($list as $key => $value) {
            if($value->admin_id != null){
                $value->admin_name = Admin::find($value->admin_id);
            }
        }
        $data['list'] = $list;
        return view('support-admin.support', $data);
    }
}
