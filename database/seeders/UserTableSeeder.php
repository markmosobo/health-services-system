<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'SuperAdmin',
            'email' => 'superadmin@gmail.com',
            'role' => 'superadmin',
            'password' => Hash::make(123456)
        ]);
        User::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'role' => 'superadmin',
            'password' => Hash::make(123456)
        ]);
        User::create([
            'name' => 'Emmanuel Chemwotei',
            'email' => 'doctor@gmail.com',
            'role' => 'doctor',
            'password' => Hash::make(123456)
        ]);
        User::create([
            'name' => 'Sephrine Kesis',
            'email' => 'nurse@gmail.com',
            'role' => 'nurse',
            'password' => Hash::make(123456)
        ]);
        User::create([
            'name' => 'Robert Otieno',
            'email' => 'pharmacist@gmail.com',
            'role' => 'pharmacist',
            'password' => Hash::make(123456)
        ]); 
        User::create([
            'name' => 'Terry Muthoni',
            'email' => 'accountant@gmail.com',
            'role' => 'accountant',
            'password' => Hash::make(123456)
        ]); 
        User::create([
            'name' => 'Brian Nyambene',
            'email' => 'staff@gmail.com',
            'role' => 'staff',
            'password' => Hash::make(123456)
        ]);                                       
    }
}
