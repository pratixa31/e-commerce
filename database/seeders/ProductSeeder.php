<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 1; $i <= 20; $i++) {
            \App\Models\Product::create([
                'product_category_id' => rand(1, 5),
                'name' => 'Product ' . $i,
                'price' => rand(10, 100),
                'description' => 'Description for Product ' . $i,
                'image' => 'product' . $i . '.jpg',
            ]);
        }
    }
}
