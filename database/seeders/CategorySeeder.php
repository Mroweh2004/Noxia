<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Add default categories for Noxia bags - customize as needed
        $categories = [
            ['name' => 'Handbags', 'category_image' => null],
            ['name' => 'Backpacks', 'category_image' => null],
            ['name' => 'Crossbody', 'category_image' => null],
            ['name' => 'Totes', 'category_image' => null],
            ['name' => 'Clutches', 'category_image' => null],
        ];

        foreach ($categories as $category) {
            Category::firstOrCreate(
                ['name' => $category['name']],
                ['category_image' => $category['category_image']]
            );
        }
    }
}
