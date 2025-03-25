<?php

namespace App\Http\Controllers;

use App\Models\Plant;
use Illuminate\Http\Request;
use App\Http\Requests\PlantRequest;
use App\Interfaces\PlantRepositoryInterface;

class PlantController extends Controller
{
    protected  $plantRepository;

    public function __construct(PlantRepositoryInterface $plantRepository) 
    {
        // $this->middleware('auth:api', ['except' => ['index', 'show']]);

        $this->plantRepository = $plantRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json( ['plants' => $this->plantRepository->getAllPlants()]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PlantRequest $request)
    {
        // if ($request->user()->cannot('create', Plant::class)) {
        //     return response()->json(['message' => 'Unauthorized'], 403);
        // }

        $validated = $request->validated();
        return response()->json(['message' => 'plant created', 'plant' => $this->plantRepository->createPlant($validated)], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($slug)
    {
        return response()->json(['plant' => $this->plantRepository->getPlantBySlug($slug)]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PlantRequest $request,  $slug)
    {
        // if ($request->user()->cannot('update', Plant::class)) {
        //     return response()->json(['message' => 'Unauthorized'], 403);
        // }
        $validated = $request->validated();
        $plant = $this->plantRepository->updatePlant($slug, $validated);
        if (!$plant) {
            return response()->json(['message' => 'the plant not fount'], 404);
        }
        return response()->json(['message' => 'plant updated', 'plant' => $plant], 201);

    }

  

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($slug)
    {
        if (auth()->user()->cannot('delete', Plant::class)) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }
        $this->plantRepository->deletePlant($slug);
        return [ 
            'message'=> "The plant deleted successfully"
        ];
    }
}
