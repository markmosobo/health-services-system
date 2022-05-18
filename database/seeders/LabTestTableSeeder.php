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
            'code' => 'Hep-B'
        ]);
        LabTest::create([
            'name' => 'Hepatitis A',
            'code' => 'Hep-A'
        ]);
        LabTest::create([
            'name' => 'HIV-1',
            'code' => 'HIV-1'
        ]);
        LabTest::create([
            'name' => 'HIV-1/2',
            'code' => 'HIV-1/2'
        ]);
        LabTest::create([
            'name' => 'Clinical malaria',
            'code' => 'Malaria'
        ]);
        LabTest::create([
            'name' => 'Urinary tract infection',
            'code' => 'UTI'
        ]);
        LabTest::create([
            'name' => 'Typhoid fever (Salmonella Typhi)',
            'code' => 'Typhoid'
        ]);
        LabTest::create([
            'name' => 'Pneumonia',
            'code' => 'Pneumonia'
        ]);
        LabTest::create([
            'name' => 'Eye infection',
            'code' => 'Eye infection'
        ]);
        LabTest::create([
            'name' => 'Diarrhea',
            'code' => 'diarrhea'
        ]);
    }
}
