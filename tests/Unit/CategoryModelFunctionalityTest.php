<?php

namespace Tests\Unit;

use App\Models\Category;
// use PHPUnit\Framework\TestCase;
use Tests\TestCase;


class CategoryModelFunctionalityTest extends TestCase
{
    /**
     * A basic unit test example.
     */
    


    public function test_list_all_categories()
    {

        $response = $this->get('api/categories'); 

        $response->assertStatus(200);
        $response->assertJsonCount(16, 'categories'); 
    }

    
    public function test_show_a_single_category()
    {
        $category = Category::factory()->create(); 

        $response = $this->get("api/categories/{$category->id}");

        $response->assertStatus(200);
        $response->assertJson(['category' => $category->toArray()]);
    }

    
    public function test_create_a_category()
    {
        $data = ['name' => 'New category'];

        $response = $this->post('api/categories', $data);

        $response->assertStatus(201);
        $this->assertDatabaseHas('categories', $data); 

    }


    public function test_update_a_category()
    {
        $category = Category::factory()->create();

        $newData = ['name' => 'test update category'];

        $response = $this->put("api/categories/{$category->id}", $newData);

        $response->assertStatus(200);
        $this->assertDatabaseHas('categories', $newData); 
    }

    
    public function test_delete_a_category()
    {
        $category = Category::factory()->create();

        $response = $this->delete("api/categories/{$category->id}");

        $response->assertStatus(200);
        $this->assertDatabaseMissing('categories', ['id' => $category->id]); // Vérifie que la catégorie a été supprimée
    }
}
