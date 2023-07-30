<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            'Adventure',
            'Beach',
            'Culture',
            'Education',
            'Historical',
            'Mountain',
            'Natural',
            'Photography',
            'Religious',
            'Urban'
        ];

        foreach ($categories as $category) {
            Category::create([
                "category" => $category
            ]);
        }
    }
}
