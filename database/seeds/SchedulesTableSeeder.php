<?php

use Illuminate\Database\Seeder;

class SchedulesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $faker = Faker\Factory::create("ja_JP");

      DB::table('schedules')->insert([
        "user_id" => 1,
        "created_at" => $faker->dateTime("now"),
        "updated_at" => $faker->dateTime("now")
        ]);
      
      DB::table('schedules')->insert([
        "user_id" => 2,
        "created_at" => $faker->dateTime("now"),
        "updated_at" => $faker->dateTime("now")
        ]);
      
      DB::table('schedules')->insert([
        "user_id" => 8,
        "created_at" => $faker->dateTime("now"),
        "updated_at" => $faker->dateTime("now")
        ]);
    }
}
