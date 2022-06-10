<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\BaseBuildingController;
use App\Repositories\Eloquent\BuildingRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends BaseBuildingController
{
    protected $xxx;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(BuildingRepository $building)
    {
        $this->xxx = 'xxx';
        $this->buildingModel = $building;
        $this->buildingList = $building->all();

    }

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
        return view('home', $data);
    }
}
