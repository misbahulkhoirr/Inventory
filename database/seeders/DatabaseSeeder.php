<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            RoleSeeder::class,
        ]);
        $this->call([
            CategoryProductSeeder::class,
        ]);
        $this->call([
            UserSeeder::class,
        ]);
        $this->call([
            StorageSeeder::class,
        ]);
        $this->call([
            SatuanSeeder::class,
        ]);
        $this->call([
            ProductSeeder::class,
        ]);
        $this->call([
            GudangSeeder::class,
        ]);
        $this->call([
            SupplierSeeder::class,
        ]);
    }
}
