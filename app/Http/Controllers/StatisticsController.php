<?php 

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Plant;
use App\Models\OrderPlant;
use Illuminate\Routing\Controller;
use App\Interfaces\StatisticsRepositoryInterface;

/**
 * @OA\Tag(
 *     name="Statistics",
 *     description="Operations related to statistics"
 * )
 */
class StatisticsController extends Controller
{
    protected  $statisticsRepository;

    public function __construct(StatisticsRepositoryInterface $statisticsRepository) 
    {
        $this->statisticsRepository = $statisticsRepository;
    }

    /**
     * @OA\Get(
     *     path="/api/statistics/categories",
     *     summary="Get category statistics",
     *     tags={"Statistics"},
     *     @OA\Response(
     *         response=200,
     *         description="Category statistics data",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="categories statistics"),
     *             @OA\Property(property="total of categories", type="integer", example=10),
     *             @OA\Property(property="categories with numre of plants", type="array", @OA\Items(type="object")),
     *             @OA\Property(property="three categories with most plants", type="array", @OA\Items(type="object"))
     *         )
     *     )
     * )
     */
    public function categoryStatistics()
    {
        return response()->json([
            "message" => 'categories statistics',
            "total of categories" => $this->statisticsRepository->totalCategories(),
            "categories with numre of plants" => $this->statisticsRepository->categoriesWithNbrPlants(),
            "three categories with most plants" => $this->statisticsRepository->topCategoryWithmostPlants()
        ]);
    }

    /**
     * @OA\Get(
     *     path="/api/statistics/plants",
     *     summary="Get plant statistics",
     *     tags={"Statistics"},
     *     @OA\Response(
     *         response=200,
     *         description="Plant statistics data",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="plants statistics"),
     *             @OA\Property(property="total of plants", type="integer", example=100),
     *             @OA\Property(property="Top three plants", type="array", @OA\Items(type="object"))
     *         )
     *     )
     * )
     */
    public function plantStatistics()
    {
        return response()->json([
            "message" => 'plants statistics',
            "total of plants" => $this->statisticsRepository->totalPlants(),
            "Top three plants" => $this->statisticsRepository->topTreePlants(),
        ]);
    }

    /**
     * @OA\Get(
     *     path="/api/statistics/orders",
     *     summary="Get order statistics",
     *     tags={"Statistics"},
     *     @OA\Response(
     *         response=200,
     *         description="Order statistics data",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="orders statistics"),
     *             @OA\Property(property="total of orders", type="integer", example=50),
     *             @OA\Property(property="the order with the highest amount", type="object")
     *         )
     *     )
     * )
     */
    public function orderStatistics()
    {
        return response()->json([
            "message" => 'orders statistics',
            "total of orders" => $this->statisticsRepository->totalOrders(),
            "the order with the highest amount" => $this->statisticsRepository->mostExpensiveOrder(),
        ]);
    }
}
