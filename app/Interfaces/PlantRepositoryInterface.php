<?php
namespace App\Interfaces;

interface PlantRepositoryInterface 
{
    public function getAllPlants();
    public function getPlantBySlug($plantId);
    public function deletePlant($plantId);
    public function createPlant(array $plantDetails);
    public function updatePlant($plantId, array $newDetails);
}
