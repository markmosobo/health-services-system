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
            'quantity' => '200mg/mL(10 mL amp)',
            'price' => 300
        ]);

        Drug::create([
            'name' => 'Benztropine56',
            'dose_form' => 'Injection',
            'quantity' => '2mg/mL',
            'price' => 150
        ]);

        Drug::create([
            'name' => 'Paracetamol',
            'dose_form' => 'Tablet(scored)',
            'quantity' => '500mg',
            'price' => 200
        ]);

        Drug::create([
            'name' => 'Paracetamol',
            'dose_form' => 'Oral liquid',
            'quantity' => '120mg.5mL(c)',
            'price' => 100
        ]);

        Drug::create([
            'name' => 'Acetylsalicylic acid (Aspirin)',
            'dose_form' => 'Tablet',
            'quantity' => '300mg',
            'price' => 200
        ]);
    }
}
