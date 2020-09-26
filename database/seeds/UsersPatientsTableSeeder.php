<?php

use Illuminate\Database\Seeder;

class UsersPatientsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $faker = Faker\Factory::create("ja_JP");

            DB::table('users_patients')->insert([
                "schedule_id" => 1,
                "patient_id" => 1,
                "created_at" => $faker->dateTime("now"),
                "updated_at" => $faker->dateTime("now")
            ]);

            DB::table('users_patients')->insert([
                "schedule_id" => 1,
                "patient_id" => 2,
                "created_at" => $faker->dateTime("now"),
                "updated_at" => $faker->dateTime("now")
            ]);

            DB::table('users_patients')->insert([
                "schedule_id" => 2,
                "patient_id" => 1,
                "created_at" => $faker->dateTime("now"),
                "updated_at" => $faker->dateTime("now")
            ]);

            DB::table('users_patients')->insert([
                "schedule_id" => 2,
                "patient_id" => 2,
                "created_at" => $faker->dateTime("now"),
                "updated_at" => $faker->dateTime("now")
            ]);

    }
}
