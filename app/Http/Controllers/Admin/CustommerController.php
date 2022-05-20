<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class CustommerController extends Controller
{

    public function showCustomerList(Request $request)
    {
        $data=[];
        $data['menu'] = ["menu-customers", "item-customer"];
        return view('customer.customers', $data);
    }
}
