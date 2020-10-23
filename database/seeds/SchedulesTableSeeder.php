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
        "user_id" => 11,
        "created_at" => $faker->dateTime("now"),
        "updated_at" => $faker->dateTime("now")
        ]);
      
      DB::table('schedules')->insert([
        "user_id" => 21,
        "created_at" => $faker->dateTime("now"),
        "updated_at" => $faker->dateTime("now")
        ]);
      DB::table('schedules')->insert([
        "user_id" => 31,
        "created_at" => $faker->dateTime("now"),
        "updated_at" => $faker->dateTime("now")
        ]);
      DB::table('schedules')->insert([
        "user_id" => 41,
        "created_at" => $faker->dateTime("now"),
        "updated_at" => $faker->dateTime("now")
        ]);
      DB::table('schedules')->insert([
        "user_id" => 51,
        "created_at" => $faker->dateTime("now"),
        "updated_at" => $faker->dateTime("now")
        ]);
      DB::table('schedules')->insert([
        "user_id" => 61,
        "created_at" => $faker->dateTime("now"),
        "updated_at" => $faker->dateTime("now")
        ]);
      DB::table('schedules')->insert([
        "user_id" => 71,
        "created_at" => $faker->dateTime("now"),
        "updated_at" => $faker->dateTime("now")
        ]);
    }
}
