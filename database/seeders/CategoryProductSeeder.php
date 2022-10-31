<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CategoryProduct;

class CategoryProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CategoryProduct::create([
            'id'=>1,
            'category'=>'Sayuran'
        ]);
        CategoryProduct::create([
            'id'=>2,
            'category'=>'Daging'
        ]);
        CategoryProduct::create([
            'id'=>3,
            'category'=>'Ikan'
        ]);
    }
}
