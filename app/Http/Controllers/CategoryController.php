<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller ;


class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['store', 'update', 'destroy']]);

        // $this->middleware(IsAdmin::class)->only(['store', 'update', 'destroy']);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json([ 'categories' => Category::all()]);

        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if ($request->user()->cannot('create', Category::class)) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $request->validate([
            'name' => 'required|string|max:255'
        ]);

        $category = Category::create(['name' => $request->name]);

        return response()->json(['message' => 'Category created', 'category' => $category], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {

        return response()->json(['category' => $category], 200);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        if ($request->user()->cannot('create', Category::class)) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

          $validated = $request->validate([
            'name' => 'required|string|max:255'
        ]);

        $category->update($validated);

        return response()->json(['message' => 'Category updated', 'category' => $category], 201);
    
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        if ($request->user()->cannot('create', Category::class)) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }
         $category->delete();
        return [ 
            'message'=> "The category deleted successfully"
        ];
    }
}
