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

}
