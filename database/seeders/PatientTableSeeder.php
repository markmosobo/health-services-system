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
        $gender = $faker->randomElements(['male', 'female'])[0];

        foreach (range(4,10) as $index) {
            DB::table('patients')->insert([
                'first_name' => $faker->firstName($gender),
                'last_name' => $faker->lastName,
                'dob' => $faker->date($format = 'Y-m-d', $max = 'now'),
                'gender' => $gender,
                'address' => $faker->address,
                'payment_id' => $faker->numberBetween($min = 1, $max = 4),
            ]);
        }
    }
}
