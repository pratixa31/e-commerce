<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductTagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 1; $i <= 40; $i++) {
            \App\Models\ProductTag::create([
                'tag_name' => 'Tag_' . $i,
                'product_id' => rand(1, 20),
            ]);
        }
    }
}
