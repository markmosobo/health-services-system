<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Drug;

class DrugTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Drug::create([
            'name' => 'Acetylcysteine',
            'dose_form' => 'Injection',
            'quantity' => '200mg/mL(10 mL amp)'
        ]);

        Drug::create([
            'name' => 'Benztropine56',
            'dose_form' => 'Injection',
            'quantity' => '2mg/mL'
        ]);

        Drug::create([
            'name' => 'Paracetamol',
            'dose_form' => 'Tablet(scored)',
            'quantity' => '500mg'
        ]);

        Drug::create([
            'name' => 'Paracetamol',
            'dose_form' => 'Oral liquid',
            'quantity' => '120mg.5mL(c)'
        ]);

        Drug::create([
            'name' => 'Acetylsalicylic acid (Aspirin)',
            'dose_form' => 'Tablet',
            'quantity' => '300mg'
        ]);
    }
}
