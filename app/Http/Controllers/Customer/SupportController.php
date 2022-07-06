<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Jobs\PushNotificationJob;
use App\Models\Admin;
use App\Models\Customer;
use App\Models\Department;
use App\Models\Feedback;
use App\Models\FeedbackType;
use App\Models\Notification;
use App\Models\NotifyRelationship;
use App\Repositories\Eloquent\ApartmentRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Claims\Custom;
use Kutia\Larafirebase\Facades\Larafirebase;
use Intervention\Image\Facades\Image;

class SupportController extends Controller
{
    public function showList(Request $request)
    {
        $data = [];
        $data['menu'] = 'support';
        $data['departments'] = Department::orderBy('name', 'asc')->get();
        $data['categories'] = FeedbackType::all();
        $list = Feedback::where('customer_id', Auth::user()->id)->join('departments', 'departments.id', 'department_id')->orderBy('id', 'desc')
        ->select('departments.name', 'feedback.id', 'feedback.title', 'feedback.content', 'feedback.image', 'feedback.status', 'feedback.updated_at', 'feedback.created_at' )
        ->paginate(10);
        $data['list'] =$list;
        // dd( $data['list']);
        return view('page-customer.support.list', $data);
    }

    public function create(Request $request)
    {

        $validate = Validator::make(
            $request->all(),
            [
                'to' => ['required', 'exists:departments,id'],
                'title' => 'required|string',
                'content' => ['required', 'string']
            ]
        );

        if ($validate->fails()) {
            return new JsonResponse(['errors' => $validate->getMessageBag()->toArray()], 406);
        }
        // return new JsonResponse(['errors' => $request->all()], 406);

        // try {
        $newFb = new Feedback();
        $newFb->title = $request->title;
        $newFb->content = $request->content;
        $newFb->customer_id = $request->customer_id;
        $newFb->department_id = $request->to;
        $newFb->status = 'request';
        $newFb->customer_id = Auth::user()->id;
        $newFb->image = json_encode($this->saveImage($request->images));
        $newFb->save();
        // } catch (\Throwable $th) {
        //     return new JsonResponse(['errors' => ['Lỗi insert data']], 406);
        // }

        return new JsonResponse(['success'], 200);
    }

    public static function saveImage($images)
    {
        $list = [];
        if ($images == null)
            return $list;
        $folder = 'images/feedback';
        foreach ($images as $key => $param) {
            list($extension, $content) = explode(';', $param);
            $tmpExtension = explode('/', $extension);

            preg_match('/.([0-9]+) /', microtime(), $m);
            $fileName = sprintf('img%s%s.%s', date('YmdHis'), $m[1], $tmpExtension[1]);

            while (file_exists($folder . $fileName)) {
                preg_match('/.([0-9]+) /', microtime(), $m);
                $fileName = sprintf('img%s_%s.%s', date('YmdHis'), $m[1], $tmpExtension[1]);
            }

            Image::make(file_get_contents($param))->save(public_path() . "/" . $folder . '/' . $fileName);

            array_push($list, $fileName);
        }
        return $list;
    }
}
