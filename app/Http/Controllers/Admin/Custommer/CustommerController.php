<?php

namespace App\Http\Controllers\Admin\Custommer;

use App\Http\Controllers\Admin\BaseBuildingController;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class CustommerController extends BaseBuildingController
{

    public function showCustomerList(Request $request)
    {
        $data=[];
        $data['menu'] = ["menu-customers", "item-customer"];
        $data['buildingActive'] = $this->getBuildingActive();
        $data['buildingList'] = $this->buildingList;

        return view('customer.customers', $data);
    }
}
