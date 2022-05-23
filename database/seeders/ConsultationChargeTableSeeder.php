<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ConsultationCharge;

class ConsultationChargeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ConsultationCharge::create([
            'consult_charge' => 200
        ]);
    }
}
