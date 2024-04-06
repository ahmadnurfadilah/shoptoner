<?php

namespace Database\Seeders;

use App\Models\Product\ProductType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $types = [
            ['Digital product', 'A digital product like service, downloadable book, music or video.'],
            ['Physical product (Coming Soon)', 'A tangible item that gets delivered to customers.'],
        ];

        foreach ($types as $type) {
            ProductType::create([
                'name' => $type[0],
                'description' => $type[1],
            ]);
        }
    }
}
