<?php

namespace App\Http\Controllers;

use App\Models\Plant;
use Illuminate\Http\Request;
use App\Http\Requests\PlantRequest;
use App\Interfaces\PlantRepositoryInterface;
use Illuminate\Routing\Controller;

/**
 * @OA\Tag(
 *     name="Plant",
 *     description="Operations related to plants"
 * )
 */
class PlantController extends Controller
{
    protected  $plantRepository;

    public function __construct(PlantRepositoryInterface $plantRepository) 
    {
        $this->middleware('auth:api', ['except' => ['index', 'show']]);
        $this->plantRepository = $plantRepository;
    }

    /**
     * @OA\Get(
     *     path="/api/plants",
     *     summary="Display a listing of the plants",
     *     tags={"Plant"},
     *     @OA\Response(
     *         response=200,
     *         description="List of plants",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 type="object",
     *                 @OA\Property(property="id", type="integer"),
     *                 @OA\Property(property="category_id", type="integer"),
     *                 @OA\Property(property="price", type="number", format="float", nullable=true),
     *                 @OA\Property(property="name", type="string"),
     *                 @OA\Property(property="slug", type="string", nullable=true),
     *                 @OA\Property(property="description", type="string"),
     *                 @OA\Property(property="created_at", type="string", format="date-time"),
     *                 @OA\Property(property="updated_at", type="string", format="date-time")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized"
     *     )
     * )
     */
    public function index()
    {
        return response()->json(['plants' => $this->plantRepository->getAllPlants()]);
    }

    /**
     * @OA\Post(
     *     path="/api/plants",
     *     summary="Store a newly created plant in storage",
     *     tags={"Plant"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="category_id", type="integer"),
     *             @OA\Property(property="price", type="number", format="float", nullable=true),
     *             @OA\Property(property="name", type="string"),
     *             @OA\Property(property="slug", type="string", nullable=true),
     *             @OA\Property(property="description", type="string")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Plant created",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string"),
     *             @OA\Property(property="plant", type="object",
     *                 @OA\Property(property="id", type="integer"),
     *                 @OA\Property(property="category_id", type="integer"),
     *                 @OA\Property(property="price", type="number", format="float", nullable=true),
     *                 @OA\Property(property="name", type="string"),
     *                 @OA\Property(property="slug", type="string", nullable=true),
     *                 @OA\Property(property="description", type="string"),
     *                 @OA\Property(property="created_at", type="string", format="date-time"),
     *                 @OA\Property(property="updated_at", type="string", format="date-time")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized"
     *     )
     * )
     */
    public function store(PlantRequest $request)
    {
        $validated = $request->validated();
        return response()->json(['message' => 'plant created', 'plant' => $this->plantRepository->createPlant($validated)], 201);
    }

    /**
     * @OA\Get(
     *     path="/api/plants/{slug}",
     *     summary="Display the specified plant",
     *     tags={"Plant"},
     *     @OA\Parameter(
     *         name="slug",
     *         in="path",
     *         required=true,
     *         description="The slug of the plant",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="The specified plant",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="id", type="integer"),
     *             @OA\Property(property="category_id", type="integer"),
     *             @OA\Property(property="price", type="number", format="float", nullable=true),
     *             @OA\Property(property="name", type="string"),
     *             @OA\Property(property="slug", type="string", nullable=true),
     *             @OA\Property(property="description", type="string"),
     *             @OA\Property(property="created_at", type="string", format="date-time"),
     *             @OA\Property(property="updated_at", type="string", format="date-time")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Plant not found"
     *     )
     * )
     */
    public function show($slug)
    {
        return response()->json(['plant' => $this->plantRepository->getPlantBySlug($slug)]);
    }

    /**
     * @OA\Put(
     *     path="/api/plants/{slug}",
     *     summary="Update the specified plant",
     *     tags={"Plant"},
     *     @OA\Parameter(
     *         name="slug",
     *         in="path",
     *         required=true,
     *         description="The slug of the plant",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="category_id", type="integer"),
     *             @OA\Property(property="price", type="number", format="float", nullable=true),
     *             @OA\Property(property="name", type="string"),
     *             @OA\Property(property="slug", type="string", nullable=true),
     *             @OA\Property(property="description", type="string")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Plant updated",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string"),
     *             @OA\Property(property="plant", type="object",
     *                 @OA\Property(property="id", type="integer"),
     *                 @OA\Property(property="category_id", type="integer"),
     *                 @OA\Property(property="price", type="number", format="float", nullable=true),
     *                 @OA\Property(property="name", type="string"),
     *                 @OA\Property(property="slug", type="string", nullable=true),
     *                 @OA\Property(property="description", type="string"),
     *                 @OA\Property(property="created_at", type="string", format="date-time"),
     *                 @OA\Property(property="updated_at", type="string", format="date-time")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Plant not found"
     *     )
     * )
     */
    public function update(PlantRequest $request, $slug)
    {
        $validated = $request->validated();
        $plant = $this->plantRepository->updatePlant($slug, $validated);
        if (!$plant) {
            return response()->json(['message' => 'the plant not found'], 404);
        }
        return response()->json(['message' => 'plant updated', 'plant' => $plant], 200);
    }

    /**
     * @OA\Delete(
     *     path="/api/plants/{slug}",
     *     summary="Remove the specified plant from storage",
     *     tags={"Plant"},
     *     @OA\Parameter(
     *         name="slug",
     *         in="path",
     *         required=true,
     *         description="The slug of the plant",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Plant deleted",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Plant not found"
     *     )
     * )
     */
    public function destroy($slug)
    {
        if (auth()->user()->cannot('delete', Plant::class)) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }
        $this->plantRepository->deletePlant($slug);
        return [
            'message' => "The plant deleted successfully"
        ];
    }
}
