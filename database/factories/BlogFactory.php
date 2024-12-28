<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Blog>
 */
class BlogFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    // protected $model = Blog::class;

    public function definition(): array
    {
         $name= fake()->name();


        return [
            'name' => $name,
            'content' => fake()->paragraph(1),
            'image' => fake()->imageUrl(600, 300) ?? 'https://images.unsplash.com/photo-1505330622279-bf7d7fc918f4?w=500&auto=format&fit=crop&q=60&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8Mnx8YmxvZ3xlbnwwfHwwfHx8MA%3D%3D',
            'slug'=>  Str::slug($name),
            'user_id'=>'',
            'category_id'=>'',
            
         
            
        ];
    }
}
