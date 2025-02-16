<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Recipe;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $japan = Category::factory()->has(Recipe::factory()->count(10), 'recipes')->create(['name' => "Japanese"]);
        $vege = Category::factory()->has(Recipe::factory()->count(10), 'recipes')->create(['name' => "Vegeterian"]);
        $meat = Category::factory()->has(Recipe::factory()->count(10), 'recipes')->create(['name' => "Meat"]);
        $fast = Category::factory()->has(Recipe::factory()->count(10), 'recipes')->create(['name' => "Fast & Easy"]);
    }
}
