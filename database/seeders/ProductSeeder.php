<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('products')->insert([
            'id' => Str::uuid()->toString(),
            'name' => "Producto 1",
            'price' => "10",
            'stock' => 50,
            'image' => 'https://cdn.siroko.com/products/6335594807e10/1200x/crop_center.webp?v=1672158278',
            'created_at' => '2024-02-22 12:05:47',
            'updated_at' => '2024-02-22 12:05:47',
        ]);
        DB::table('products')->insert([
            'id' => Str::uuid()->toString(),
            'name' => "Producto 2",
            'price' => "10",
            'stock' => 50,
            'image' => 'https://cdn.siroko.com/products/633412190710b/1200x/crop_center.webp?v=1672147812',
            'created_at' => '2024-02-22 12:05:47',
            'updated_at' => '2024-02-22 12:05:47',
        ]);
        DB::table('products')->insert([
            'id' => Str::uuid()->toString(),
            'name' => "Producto 3",
            'price' => "10",
            'stock' => 50,
            'image' => 'https://cdn.siroko.com/products/6334125056ea4/1200x/crop_center.webp?v=1672147992',
            'created_at' => '2024-02-22 12:05:47',
            'updated_at' => '2024-02-22 12:05:47',
        ]);
        DB::table('products')->insert([
            'id' => Str::uuid()->toString(),
            'name' => "Producto 4",
            'price' => "10",
            'stock' => 50,
            'image' => 'https://cdn.siroko.com/products/65b25ba4e49a3/1200x/crop_center.webp?v=1706187729',
            'created_at' => '2024-02-22 12:05:47',
            'updated_at' => '2024-02-22 12:05:47',
        ]);
        DB::table('products')->insert([
            'id' => Str::uuid()->toString(),
            'name' => "Producto 5",
            'price' => "10",
            'stock' => 50,
            'image' => 'https://cdn.siroko.com/s/files/1/1220/6874/products/old-school-fitness-hoodie-estudio-lifestyle-04-man/1200x/crop_center.webp?v=1691130109',
            'created_at' => '2024-02-22 12:05:47',
            'updated_at' => '2024-02-22 12:05:47',
        ]);
        DB::table('products')->insert([
            'id' => Str::uuid()->toString(),
            'name' => "Producto 6",
            'price' => "10",
            'stock' => 50,
            'image' => 'https://cdn.siroko.com/products/6356412d1c663/1200x/crop_center.webp?v=1681916317',
            'created_at' => '2024-02-22 12:05:47',
            'updated_at' => '2024-02-22 12:05:47',
        ]);
    }
}
