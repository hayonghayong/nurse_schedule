<?php

use Illuminate\Database\Seeder;

class PatientUserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $faker = Faker\Factory::create("ja_JP");

            DB::table('patient_user')->insert([
                "user_id" => 1,
                "patient_id" => 1,
                "end_flg" => 0,
                "created_at" => $faker->dateTime("now"),
                "updated_at" => $faker->dateTime("now")
            ]);

            DB::table('patient_user')->insert([
                "user_id" => 1,
                "patient_id" => 2,
                "end_flg" => 0,
                "created_at" => $faker->dateTime("now"),
                "updated_at" => $faker->dateTime("now")
            ]);

            DB::table('patient_user')->insert([
                "user_id" => 2,
                "patient_id" => 1,
                "end_flg" => 0,
                "created_at" => $faker->dateTime("now"),
                "updated_at" => $faker->dateTime("now")
            ]);

            DB::table('patient_user')->insert([
                "user_id" => 2,
                "patient_id" => 2,
                "end_flg" => 0,
                "created_at" => $faker->dateTime("now"),
                "updated_at" => $faker->dateTime("now")
            ]);

    }
}
