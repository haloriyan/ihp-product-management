<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => "Makanan",
                'product_count' => 0,
            ],
            [
                'name' => "Minuman",
                'product_count' => 0,
            ],
            [
                'name' => "Obat-obatan & Kesehatan",
                'product_count' => 0,
            ],
            [
                'name' => "Mainan Anak",
                'product_count' => 0,
            ],
            [
                'name' => "Hobi",
                'product_count' => 0,
            ],
        ];

        DB::table('categories')->insert($categories);
    }
}
