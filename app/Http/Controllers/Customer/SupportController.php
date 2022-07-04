<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Jobs\PushNotificationJob;
use App\Models\Admin;
use App\Models\Customer;
use App\Models\Department;
use App\Models\FeedbackType;
use App\Models\Notification;
use App\Models\NotifyRelationship;
use App\Repositories\Eloquent\ApartmentRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Claims\Custom;
use Kutia\Larafirebase\Facades\Larafirebase;

class SupportController extends Controller
{
    public function showList(Request $request)
    {
        $data = [];
        $data['menu'] = 'support';
        $data['departments'] = Department::orderBy('name', 'asc')->get();
        $data['categories']=FeedbackType::all();
        return view('page-customer.support.list', $data);
    }

}
