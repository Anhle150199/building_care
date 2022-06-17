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
}
