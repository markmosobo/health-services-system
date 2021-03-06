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
        $this->call(UserTableSeeder::class);
        $this->call(PaymentsTableSeeder::class);
        $this->call(LabTestTableSeeder::class);
        $this->call(PatientTableSeeder::class);
        $this->call(DrugTableSeeder::class);
        $this->call(ConsultationChargeTableSeeder::class);
    }
}
