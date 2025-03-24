<?php

namespace App\Http\Controllers;

use App\Models\Plant;
use Illuminate\Http\Request;
use App\Http\Requests\PlantRequest;

class PlantController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json( ['plants' => Plant::all()]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PlantRequest $request)
    {
        // dd($request->user());
        if ($request->user()->cannot('create', Plant::class)) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $validated = $request->validated();
        $plant = Plant::create($validated);
        return response()->json(['message' => 'plant created', 'plant' => $plant], 201);

        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Plant $plant)
    {
        // dd($plant);
        return response()->json(['plant' => $plant]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PlantRequest $request, Plant $plant)
    {
        if ($request->user()->cannot('update', Plant::class)) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }
        $validated = $request->validated();
        $plant->update($validated);
        return response()->json(['message' => 'plant updated', 'plant' => $plant], 201);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Plant $plant)
    {
        if (auth()->user()->cannot('delete', Plant::class)) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }
        $plant->delete();
        return [ 
            'message'=> "The plant deleted successfully"
        ];
    }
}
