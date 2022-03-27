<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Payment;

class PaymentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Payment::create([
            'name' => 'NHIF',
            'account_number' => '23788676'
        ]);
        Payment::create([
            'name' => 'CASH',
            'account_number' => '23788676'
        ]);
        Payment::create([
            'name' => 'MPESA',
            'account_number' => '23788676'
        ]);
        Payment::create([
            'name' => 'BANK',
            'account_number' => '23788676'
        ]);
    }
}
