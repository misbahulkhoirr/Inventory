<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'id' => 1,
            'name' => 'Name User Admin',
            'username' => 'Admin',
            'email' => 'admin@gmail.com',
            'phone' => '082312543008',
            'role_id' => 1,
            'email_verified_at' => date('Y-m-d H:i:s'),
            'password' => Hash::make('123456'),
        ]);
        User::create([
            'id' => 2,
            'name' => 'Name User Gudang',
            'username' => 'Gudang',
            'email' => 'gudang@gmail.com',
            'phone' => '082312543009',
            'role_id' => 2,
            'email_verified_at' => date('Y-m-d H:i:s'),
            'password' => Hash::make('123456'),
        ]);
    }
}
