<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\LabTest;

class LabTestTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        LabTest::create([
            'name' => 'Hepatitis B',
            'code' => 'Hep-B',
            'charge' => 150
        ]);
        LabTest::create([
            'name' => 'Hepatitis A',
            'code' => 'Hep-A',
            'charge' => 200
        ]);
        LabTest::create([
            'name' => 'HIV-1',
            'code' => 'HIV-1',
            'charge' => 100
        ]);
        LabTest::create([
            'name' => 'HIV-1/2',
            'code' => 'HIV-1/2',
            'charge' => 100
        ]);
        LabTest::create([
            'name' => 'Clinical malaria',
            'code' => 'Malaria',
            'charge' => 150
        ]);
        LabTest::create([
            'name' => 'Urinary tract infection',
            'code' => 'UTI',
            'charge' => 150
        ]);
        LabTest::create([
            'name' => 'Typhoid fever (Salmonella Typhi)',
            'code' => 'Typhoid',
            'charge' => 300
        ]);
        LabTest::create([
            'name' => 'Pneumonia',
            'code' => 'Pneumonia',
            'charge' => 150
        ]);
        LabTest::create([
            'name' => 'Eye infection',
            'code' => 'Eye infection',
            'charge' => 150
        ]);
        LabTest::create([
            'name' => 'Diarrhea',
            'code' => 'diarrhea',
            'charge' => 150
        ]);
    }
}
