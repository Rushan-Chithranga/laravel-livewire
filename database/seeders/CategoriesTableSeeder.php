<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Technology', 'description' => 'Latest tech news and reviews'],
            ['name' => 'Fashion', 'description' => 'Trends in fashion and style'],
            ['name' => 'Sports', 'description' => 'Updates on sports events and athletes'],
            // Add more categories as needed
        ];

        foreach ($categories as $categoryData) {
            Category::create([
                'name' => $categoryData['name'],
                'description' => $categoryData['description'],
            ]);
        }
    }
}
