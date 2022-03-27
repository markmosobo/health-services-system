<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class PatientTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        foreach (range(4,10) as $index) {
            DB::table('patients')->insert([
                'first_name' => $faker->firstName,
                'last_name' => $faker->lastName,
                'dob' => $faker->date($format = 'D-m-y', $max = '2010',$min = '1980'),
                'gender' => 'Female',
                'address' => $faker->address,
                'payment_id' => $faker->numerify('1')
            ]);
        }
    }
}
