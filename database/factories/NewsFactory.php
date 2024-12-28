<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\News>
 */
class NewsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name= fake()->name();
        return [
            'name' => $name,
            'description' => fake()->paragraph(1),
            'image'=>'',
            'slug'=>  Str::slug($name),
            'user_id'=>'',
            'category_id'=>'',
            
         
            
        ];
    }
}
