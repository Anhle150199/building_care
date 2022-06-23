<?php

namespace App\Http\Controllers\Admin\Notification;

use App\Http\Controllers\Admin\BaseBuildingController;
use App\Mail\NotifyEmail;
use App\Models\Admin;
use App\Models\Building;
use App\Models\Notification;
use App\Models\NotifyRelationship;
use App\Models\SentMail;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class MailController extends BaseBuildingController
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
        $list = SentMail::all();
        foreach ($list as $key => $value) {
            $admin = Admin::find($value->admin_id);
            if ($admin != null)
                $value->admin = $admin->name;
            else $value->admin = 'noName';
            $value->to = json_decode($value->to);
            if($value->subject == null){
                $value->subject = "(Không có tiêu đề)";
            }
        }
        // dd($list);
        $data['list']= $list;
        return view('notify.email.list', $data);
    }

    public function showCreate()
    {
        $data = $this->generalData();

        return view('notify.email.create', $data);
    }

    public function create(Request $request)
    {
        $email = new SentMail();
        $email->to =$request->to;
        $email->cc =$request->cc;
        $email->bcc =$request->bcc;
        $email->subject =$request->subject;
        $email->content =$request->content;
        $email->admin_id=Auth::user()->id;
        $email->save();
        $emailsTo =json_decode($request->to);
        $emailsCc =json_decode($request->cc);
        $emailsBcc =json_decode($request->bcc);

        foreach ($emailsTo as $key => $value) {
            $emailsTo[$key]=$value->email;
        }
        if($emailsCc != null)
        foreach ($emailsCc as $key => $value) {
            $emailsCc[$key]=$value->email;
        }
        if($emailsBcc != null)

        foreach ($emailsBcc as $key => $value) {
            $emailsBcc[$key]=$value->email;
        }
        $mailable = new NotifyEmail($email->subject, $email->content);
        Mail::to($emailsTo)->cc($emailsCc)->bcc($emailsBcc)->send($mailable);


        return new JsonResponse(['success', $emailsCc], 200);
    }

    public function update(Request $request)
    {
    }

    public function delete(Request $request)
    {
    }
}
