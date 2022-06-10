<?php

namespace App\Http\Controllers\Admin\Custommer;

use App\Http\Controllers\Admin\BaseBuildingController;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class VehicleController extends BaseBuildingController
{

    public function showVehicleList(Request $request)
    {
        $data=[];
        $data['menu'] = ["menu-customers", "item-customer"];
        $data['buildingActive'] = $this->getBuildingActive();
        $data['buildingList'] = $this->buildingList;

        return view('customer.customers', $data);
    }
}
