<?php

namespace App\Repositories;

use App\Models\Plant;
use App\Interfaces\PlantRepositoryInterface;
 
class PlantRepository implements PlantRepositoryInterface 
{
    public function getAllPlants()
    {
        return Plant::all();
    }
    public function getPlantBySlug($slug)
    {

        return Plant::where('slug',$slug)->get();
    }
    public function deletePlant($slug)
    {
        Plant::where('slug',$slug)->delete();
    }
    public function createPlant(array $plantDetails)
    {
        return Plant::create($plantDetails);
    }
    public function updatePlant($slug, array $newDetails)
    {
        $plant = Plant::where('slug', $slug)->first();
    
        if (!$plant) {
            return null; 
        }
    
        $plant->update($newDetails);
        return $plant;
    }
}