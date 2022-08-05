<?php
namespace App\Repositories\Eloquent;

use App\Models\Customer;
use App\Repositories\EloquentRepository;
use Illuminate\Support\Facades\Cache;

class CustomerRepository extends EloquentRepository
{
    public function getModel()
    {
        return Customer::class;
    }

}
