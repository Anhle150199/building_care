<?php
namespace App\Repositories\Eloquent;

use App\Models\Building;
use App\Repositories\EloquentRepository;
use Illuminate\Support\Facades\Cache;

class BuildingRepository extends EloquentRepository
{
    public function getModel()
    {
        return Building::class;
    }

    // Get List Building has status = active
    public function getListActive()
    {
        $buildingList = Cache::get('building_list');
        if($buildingList != null){
            return $buildingList;
        }
        $buildingList = $this->_model->where('status', 'active')->orderBy('name', 'asc')->get();
        Cache::set('building_list', $buildingList, 600);
        return $buildingList;
    }

    // Get building id of current user
    public function getBuildingActive($id)
    {

        $buildingActive = Cache::get('building_active_'.$id);
        if($buildingActive != null){
            return $buildingActive;
        }
        $buildingActive = $this->_model->where('status', 'active')->orderBy('name', 'asc')->first();
        Cache::set('building_active_'.$id, $buildingActive->id);
        return $buildingActive->id;
    }

    // Update list building has status = active
    public function updateBuildingList()
    {
        $buildingList = $this->_model->where('status', 'active')->orderBy('name', 'asc')->get();
        Cache::set('building_list', $buildingList, 600);

    }

}
