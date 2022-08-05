<?php

namespace App\Http\Controllers\Admin\Notification;

use App\Http\Controllers\Admin\BaseBuildingController;
use App\Jobs\MailJob;
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
        $list = SentMail::orderBy('id', 'desc')->get();
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
        $data['type'] ='list';
        return view('notify.email.list', $data);
    }

    public function showCreate()
    {
        $data = $this->generalData();
        $data['type'] ='new';

        return view('notify.email.create', $data);
    }

    public function create(Request $request)
    {
        $email = new SentMail();
        $email->to =$request->to;
        $email->cc =$request->cc;
        $email->bcc =$request->bcc;
        $email->subject =$request->subject;
        if($email->subject == null){
            $email->subject = "(Không có tiêu đề)";
        }
        $email->content =$request->content;
        $email->admin_id = Auth::user()->id;
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
        // $mailable = new NotifyEmail($email->subject, $email->content);
        // Mail::to($emailsTo)->cc($emailsCc)->bcc($emailsBcc)->send($mailable);
        MailJob::dispatch([
            'subject'=>$email->subject,
            "content" =>$email->content,
            'to'=>$emailsTo,
            'cc'=>$emailsCc,
            'bcc'=>$emailsBcc,
            'type'=>"notify",
        ]);
        return new JsonResponse(['success', $emailsCc], 200);
    }

    public function showDetail($id)
    {
        $email = SentMail::find($id);
        if($email != null ){
            $email->to = json_decode($email->to);
            $email->cc = json_decode($email->cc);
            $email->bcc = json_decode($email->bcc);
            $data = $this->generalData();
            $data['type'] ='list';
            $data['item'] = $email;
            $admin = Admin::find($email->admin_id);
            if($admin == null){

                $admin = new Admin();
                $admin->name ='noName';
                $admin->avatar = "blank.png";
            }
            $data['admin'] = $admin;

            return view('notify.email.detail', $data);

        }
    }

    public function delete(Request $request)
    {
    }
}
