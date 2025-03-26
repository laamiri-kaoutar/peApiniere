<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Interfaces\CategoryRepositoryInterface;

class CategoryController extends Controller
{
    protected $categoryRepository;

    public function __construct(CategoryRepositoryInterface $categoryRepository) 
    {
        $this->middleware('auth:api', ['except' => ['index', 'show']]);
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * @OA\Get(
     *     path="/categories",
     *     summary="Get all categories",
     *     tags={"Categories"},
     *     @OA\Response(response=200, description="List of categories")
     * )
     */
    public function index()
    {
        return response()->json(['categories' => $this->categoryRepository->getAllCategories()]);
    }

    /**
     * @OA\Post(
     *     path="/categories",
     *     summary="Create a new category",
     *     tags={"Categories"},
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name"},
     *             @OA\Property(property="name", type="string", example="Web Development")
     *         )
     *     ),
     *     @OA\Response(response=201, description="Category created"),
     *     @OA\Response(response=403, description="Unauthorized")
     * )
     */
    public function store(Request $request)
    {
        if ($request->user()->cannot('create', Category::class)) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $request->validate([
            'name' => 'required|string|max:255'
        ]);

        return response()->json([
            'message' => 'Category created',
            'category' => $this->categoryRepository->createCategory(['name' => $request->name])
        ], 201);
    }

    /**
     * @OA\Get(
     *     path="/categories/{id}",
     *     summary="Get a category by ID",
     *     tags={"Categories"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer"),
     *         description="Category ID"
     *     ),
     *     @OA\Response(response=200, description="Category details"),
     *     @OA\Response(response=404, description="Category not found")
     * )
     */
    public function show($id)
    {
        return response()->json(['category' => $this->categoryRepository->getCategoryById($id)], 200);
    }

    /**
     * @OA\Put(
     *     path="/categories/{id}",
     *     summary="Update a category",
     *     tags={"Categories"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer"),
     *         description="Category ID"
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name"},
     *             @OA\Property(property="name", type="string", example="Graphic Design")
     *         )
     *     ),
     *     @OA\Response(response=200, description="Category updated"),
     *     @OA\Response(response=403, description="Unauthorized")
     * )
     */
    public function update(Request $request, $id)
    {
        if ($request->user()->cannot('update', Category::class)) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255'
        ]);

        return response()->json([
            'message' => 'Category updated',
            'category' => $this->categoryRepository->updateCategory($id, $validated)
        ], 200);
    }

    /**
     * @OA\Delete(
     *     path="/categories/{id}",
     *     summary="Delete a category",
     *     tags={"Categories"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer"),
     *         description="Category ID"
     *     ),
     *     @OA\Response(response=200, description="Category deleted"),
     *     @OA\Response(response=403, description="Unauthorized")
     * )
     */
    public function destroy(Request $request, $id)
    {
        if ($request->user()->cannot('delete', Category::class)) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $this->categoryRepository->deleteCategory($id);

        return response()->json(['message' => 'The category was deleted successfully'], 200);
    }
}
