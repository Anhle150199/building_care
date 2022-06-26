<?php
namespace App\Repositories\Eloquent;

use App\Models\Apartment;
use App\Repositories\EloquentRepository;

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
        // $apartmentList = Cache::get('apartment_list_'.$id);
        // if($apartmentList != null){
        //     return $apartmentList;
        // }
        $list = $this->_model->where('owner_id', $userId)->select('building_id')->distinct('building_id')->get('building_id');
        return $list->toArray();
    }
}
