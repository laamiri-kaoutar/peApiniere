<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Plant>
 */
class PlantFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    // Schema::create('plants', function (Blueprint $table) {
    //     $table->id();
    //     $table->foreignId('category_id')->constrained('categories')->nullOnDelete();
    //     $table->decimal('price', 8, 2)->nullable();
    //     $table->string('name')->unique();
    //     $table->string('slug')->unique()->nullable();
    //     $table->text('description');
    //     $table->timestamps();

    // });
    public function definition(): array
    {
        return [
            'category_id'  => Category::inRandomOrder()->value('id'),
            'price'        => $this->faker->randomFloat(2, 5, 100), 
            'name'         => $this->faker->unique()->words(2, true),  
            'description'  => $this->faker->paragraph(), 
            'created_at'   => now(),
            'updated_at'   => now(),
        ];
    }
}
