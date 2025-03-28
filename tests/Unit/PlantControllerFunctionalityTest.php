<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Plant;
// use PHPUnit\Framework\TestCase;


class PlantControllerFunctionalityTest extends TestCase
{
    /**
     * A basic unit test example.
     */
    // public function test_get_plant_by_slug(): void
    // {
    //     $plant = Plant::factory()->create();

    //     // $response = $this->get("api/plants/{$plant->slug}");
    //     $response = $this->getJson("api/plants/{$plant->slug}");


    //     $response->assertStatus(200);
    //     $response->assertJson(['plant' => $plant->toArray()]);

    //     // $response->assertJson(['plant' => $plant]);
    //     // $response->assertJson([
    //     //     'plant' => [
    //     //         'id'          => $plant->id,
    //     //         'category_id' => $plant->category_id,
    //     //         'price'       => $plant->price,
    //     //         'name'        => $plant->name,
    //     //         'slug'        => $plant->slug,
    //     //         'description' => $plant->description,
    //     //     ]
    //     // ]);
    // }

//     public function test_get_plant_by_slug(): void
// {
//     // Create a plant using the factory
//     $plant = Plant::factory()->create();

//     // Call the 'show' route, passing the plant's slug
//     $response = $this->getJson("api/plants/{$plant->slug}");

//     // Assert that the status is 200 OK
//     $response->assertStatus(200);

//     // Assert that the response structure matches the actual response format
//     $response->assertJson([
//         'plant' => [
//             'id'          => $plant->id,
//             'category_id' => $plant->category_id,
//             'price'       => (string) $plant->price, // Ensure price is cast to string if it's a float in the response
//             'name'        => $plant->name,
//             'slug'        => $plant->slug,
//             'description' => $plant->description,
//         ]
//     ]);
// }

public function test_get_plant_by_slug(): void
{
    $plant = Plant::factory()->create();

    $response = $this->getJson("api/plants/{$plant->slug}");

    $response->assertStatus(200);

    // $response->assertJsonFragment([
    //     'plant' => [
    //         [
    //             'id' => $plant->id,
    //             'category_id' => $plant->category_id,
    //             'price' => $plant->price,
    //             'name' => $plant->name,
    //             'slug' => $plant->slug,
    //             'description' => $plant->description,
    //         ],
    //     ],
    // ]);

    // $response->assertJson([
    //     'plant' => [
    //         [
    //             'id' => $plant->id,
    //             'category_id' => $plant->category_id,
    //             'price' => (string) $plant->price,
    //             'name' => $plant->name,
    //             'slug' => $plant->slug,
    //             'description' => $plant->description,
    //             'created_at' => $plant->created_at->toIso8601String(),
    //             'updated_at' => $plant->updated_at->toIso8601String()
    //         ]
    //     ]
    // ]);
    
}


}
