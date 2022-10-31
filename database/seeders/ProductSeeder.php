<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Product::create([
            'id'=>1,
            'product_code'=>'P000000001',
            'product_name'=>'Kol Bunga',
            'satuan'=>'Kg',
            'price'=>25000,
            'created_by'=>1,
            'category_product_id'=>1,
        ]);
        Product::create([
            'id'=>2,
            'product_code'=>'P000000002',
            'product_name'=>'Danging Sapi',
            'satuan'=>'Kg',
            'price'=>100000,
            'created_by'=>1,
            'category_product_id'=>2,
        ]);
        Product::create([
            'id'=>3,
            'product_code'=>'P000000003',
            'product_name'=>'Ikan Nila',
            'satuan'=>'Kg',
            'price'=>50000,
            'created_by'=>1,
            'category_product_id'=>3,
        ]);
    }
}
