<?php

use Illuminate\Database\Seeder;

class PatientScheduleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $faker = Faker\Factory::create("ja_JP");

            DB::table('patient_schedule')->insert([
                "patient_id" => 1,
                "schedule_id" => 1,
                "created_at" => $faker->dateTime("now"),
                "updated_at" => $faker->dateTime("now")
            ]);

            DB::table('patient_schedule')->insert([
                "patient_id" => 1,
                "schedule_id" => 2,
                "created_at" => $faker->dateTime("now"),
                "updated_at" => $faker->dateTime("now")
            ]);

            DB::table('patient_schedule')->insert([
                "patient_id" => 1,
                "schedule_id" => 3,
                "created_at" => $faker->dateTime("now"),
                "updated_at" => $faker->dateTime("now")
            ]);

            DB::table('patient_schedule')->insert([
                "patient_id" => 2,
                "schedule_id" => 4,
                "created_at" => $faker->dateTime("now"),
                "updated_at" => $faker->dateTime("now")
            ]);

            DB::table('patient_schedule')->insert([
                "patient_id" => 1,
                "schedule_id" => 5,
                "created_at" => $faker->dateTime("now"),
                "updated_at" => $faker->dateTime("now")
            ]);

            

    }
}
