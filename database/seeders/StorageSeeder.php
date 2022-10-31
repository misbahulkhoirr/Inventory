<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Storage;

class StorageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Storage::create([
            'id'=>1,
            'label'=>'Label 1',
            'name'=>'Freezer',
            'temperature'=> "20 Derajat",
            'deleted_at'=>null,
        ]);
        Storage::create([
            'id'=>2,
            'label'=>'Label 2',
            'name'=>'Kulkas',
            'temperature'=> '40 Derajat',
            'deleted_at'=>null,
        ]);
    }
}
