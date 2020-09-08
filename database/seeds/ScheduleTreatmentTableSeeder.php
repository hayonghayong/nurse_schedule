<?php

use Illuminate\Database\Seeder;

class ScheduleTreatmentTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $faker = Faker\Factory::create("ja_JP");

            DB::table('schedule_treatment')->insert([
                "schedule_id" => 1,
                "treatment_id" => 1,
                "created_at" => $faker->dateTime("now"),
                "updated_at" => $faker->dateTime("now")
            ]);

            DB::table('schedule_treatment')->insert([
                "schedule_id" => 2,
                "treatment_id" => 2,
                "created_at" => $faker->dateTime("now"),
                "updated_at" => $faker->dateTime("now")
            ]);

            DB::table('schedule_treatment')->insert([
                "schedule_id" => 3,
                "treatment_id" => 1,
                "created_at" => $faker->dateTime("now"),
                "updated_at" => $faker->dateTime("now")
            ]);

            DB::table('schedule_treatment')->insert([
                "schedule_id" => 4,
                "treatment_id" => 12,
                "created_at" => $faker->dateTime("now"),
                "updated_at" => $faker->dateTime("now")
            ]);

            DB::table('schedule_treatment')->insert([
                "schedule_id" => 5,
                "treatment_id" => 11,
                "created_at" => $faker->dateTime("now"),
                "updated_at" => $faker->dateTime("now")
            ]);
    }
}
