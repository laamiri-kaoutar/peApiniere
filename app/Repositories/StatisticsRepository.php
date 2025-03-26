<?php

namespace App\Repositories;

use App\Models\Order;
use App\Models\Plant;
use App\Models\Category;
use Illuminate\Support\Facades\DB;
use App\Interfaces\StatisticsRepositoryInterface;
 
class StatisticsRepository implements StatisticsRepositoryInterface 
{

    public function totalCategories()
    {
        return Category::count();
    }

    public function totalPlants()
    {
        return Plant::count();
    }
    public function totalOrders()
    {
        return Order::count();
    }

    public function topTreePlants()
    {
        return DB::table('plants as p')
                ->join('order_plant as op', 'p.id' , '=' , 'op.plant_id' )
                ->join('orders as o', 'o.id' , '=' , 'op.order_id' )
                ->select('p.name' , DB::raw('Count(o.id) as total_orders'))
                ->groupBy('p.id')
                ->orderBy('total_orders','desc')
                ->limit(3)
                ->get();
    }

    public function mostExpensiveOrder()
    {
        return DB::table('orders')
        ->orderByDesc('total_amount')
        ->first();
    }

    public function topCategoryWithmostPlants()
    {
        return DB::table('categorie as c')
                  ->join('plants as p' , 'p.category_id' , '=' , 'c.id')
                  ->select('c.name' , DB::raw('Count(p.id) as total_plants'))
                  ->groupBy('c.id')
                  ->orderBy('total_plants','desc')
                  ->limit(3)
                  ->get();
    }

    public function categoriesWithNbrPlants()
    {
        return DB::table('categorie as c')
                   ->select('c.name')
                   ->withCount('plants')
                   ->get();
    }


}