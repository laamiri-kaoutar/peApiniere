<?php
namespace App\Interfaces;

interface StatisticsRepositoryInterface 
{
    public function totalCategories();
    public function totalPlants();
    public function totalOrders();
    public function topTreePlants();
    public function mostExpensiveOrder();
    public function topCategoryWithmostPlants();

}