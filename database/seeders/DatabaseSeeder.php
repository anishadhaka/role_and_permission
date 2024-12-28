<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\News;
use App\Models\NewsCategory;
use App\Models\Pages;




class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $blogCategory=BlogCategory::all();
        $newsCategory=NewsCategory::all();

        User::factory(5)->create()->each(function($user) use($blogCategory,$newsCategory) {
             Blog::factory(1)->create([
                    'user_id' => $user->id,
                    'category_id' => $blogCategory->random()->id,
                ]);
                News::factory(1)->create([
                    'user_id' => $user->id,
                    'category_id' => $newsCategory->random()->id,
                ]);
                Pages::factory(1)->create([
                    'user_id' => $user->id,
                ]);
        });

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        // $this->call([
        //     BlogSeeder::class, 
        // ]);
    }
}
