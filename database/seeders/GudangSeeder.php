<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Gudang;

class GudangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Gudang::create([
            'id'=>1,
            'name'=>'Gudang 1',
            'alamat'=>'Jln. Gudang 1 yang dulu pernah ada'
        ]);
        Gudang::create([
            'id'=>2,
            'name'=>'Gudang 2',
            'alamat'=>'Jln. Gudang 2 yang tak pernah tergantikan'
        ]);
    }
}
