<?php
namespace App\Repositories\Eloquent;

use App\Models\Apartment;
use App\Models\Customer;
use App\Repositories\EloquentRepository;
use Illuminate\Support\Facades\Cache;

class ApartmentRepository extends EloquentRepository
{
    public function getModel()
    {
        return Apartment::class;
    }

    public function getApartmentList($buildingId)
    {
        $list = $this->_model->where('building_id', $buildingId)->get('id');
        return $list->toArray();
    }

    public function getBuildingListForCustomer($userId)
    {
        $apartmentList = Cache::get('apartment_list_'.$userId);
        if($apartmentList != null){
            return $apartmentList;
        }
        $list = $this->_model->where('owner_id', $userId)->distinct('building_id')->pluck('building_id')->toArray();
        $customer = Customer::find($userId);
        array_push($list, $customer->id);
        return $list;
    }
}
