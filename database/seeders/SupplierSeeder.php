<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Supplier;

class SupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Supplier::create([
            'id'=>1,
            'name'=>'Name Supplier 1',
            'alamat'=>'Jln. Supplier 1',
            'phone'=>'082312543008'
        ]);
        Supplier::create([
            'id'=>2,
            'name'=>'Name Supplier 2',
            'alamat'=>'Jln. Supplier 2',
            'phone'=>'082312543009'
        ]);
    }
}
