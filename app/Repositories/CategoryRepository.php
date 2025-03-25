<?php

namespace App\Repositories;

use App\Models\Category;
use App\Interfaces\CategoryRepositoryInterface;
 
class CategoryRepository implements CategoryRepositoryInterface 
{
    public function getAllCategories()
    {
        return Category::all();
    }
    public function getCategoryById($CategoryId)
    {

        return Category::findOrFail($CategoryId);
    }
    public function deleteCategory($CategoryId)
    {
        Category::destroy($CategoryId);
    }
    public function createCategory(array $CategoryDetails)
    {
        return Category::create($CategoryDetails);
    }
    public function updateCategory($CategoryId, array $newDetails)
    {
        $category =  Category::findOrFail($CategoryId);
         $category->update($newDetails);
         return $category;
    }
}