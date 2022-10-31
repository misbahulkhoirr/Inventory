<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Satuan;

class SatuanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Satuan::create([
            'id'=>1,
            'satuan'=>'Gram',
        ]);
        Satuan::create([
            'id'=>2,
            'satuan'=>'Kg',
        ]);
    }
}
