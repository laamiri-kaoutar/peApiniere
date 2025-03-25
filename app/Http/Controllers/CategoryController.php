<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller ;
use App\Interfaces\CategoryRepositoryInterface;




class CategoryController extends Controller
{

    protected  $categoryRepository;

    public function __construct(CategoryRepositoryInterface $categoryRepository) 
    {
        $this->middleware('auth:api', ['except' => ['index', 'show']]);

        $this->categoryRepository = $categoryRepository;
    }

  
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json([ 'categories' =>  $this->categoryRepository->getAllCategories()]);
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

        return response()->json(['message' => 'Category created', 'category' =>  $this->categoryRepository->createCategory(['name' => $request->name])],
                                 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {

        return response()->json(['category' =>  $this->categoryRepository->getCategoryById($id)], 200);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        if ($request->user()->cannot('create', Category::class)) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

          $validated = $request->validate([
            'name' => 'required|string|max:255'
        ]);


        return response()->json(['message' => 'Category updated', 'category' => $this->categoryRepository->updateCategory($id , $validated)], 201);
    
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        if ($request->user()->cannot('create', Category::class)) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }
        $this->categoryRepository->deleteCategory($id);
        return [ 
            'message'=> "The category deleted successfully"
        ];
    }
}
