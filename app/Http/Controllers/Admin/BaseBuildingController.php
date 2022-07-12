<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Building;
use App\Models\PushNotify;
use App\Models\PushNotifyRelationship;
use App\Repositories\Eloquent\ApartmentRepository;
use App\Repositories\Eloquent\BuildingRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;

class BaseBuildingController extends Controller
{
    protected $buildingList;
    protected $buildingModel;


    public function __construct(BuildingRepository $building,ApartmentRepository $apartment)
    {

        $this->buildingModel = $building;
        $this->buildingList = $building->getListActive();
    }

    public function updateBuildingActive(Request $request)
    {
        $validate = Validator::make(
            $request->all() ,
            [
                'id' => ['integer', 'required', 'exists:building,id'],
            ]
        );

        if ($validate->fails()) {
            return new JsonResponse(['errors' => $validate->getMessageBag()->toArray()], 406);
        }
        try {
            Cache::set('building_active_'.Auth::id(), $request->id);

        } catch (\Throwable $th) {
            return new JsonResponse(['errors' => ['Lỗi insert data']], 406);
        }
        return new JsonResponse(['success'], 200);
    }

    public function getBuildingActive()
    {
        return $this->buildingModel->getBuildingActive(Auth::user()->id);
    }

    public function getPushNotify()
    {
        $notify = PushNotify::where("type_user", "admin")->whereJsonContains('receive_id', Auth::user()->id)->orderBy("id", 'desc')->limit(5)->get();
        foreach ($notify as $key => $value) {
            $value->time = $value->created_at->diffForHumans();
        }
        return new JsonResponse($notify, 200);

    }

}
