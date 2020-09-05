<?php

use Illuminate\Database\Seeder;

class TeamUserUserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $faker = Faker\Factory::create("ja_JP");

            DB::table('team_user_user')->insert([
                "team_user_id" => 1,
                "user_id" => 2,
                "created_at" => $faker->dateTime("now"),
                "updated_at" => $faker->dateTime("now")
            ]);

            DB::table('team_user_user')->insert([
                "team_user_id" => 2,
                "user_id" => 3,
                "created_at" => $faker->dateTime("now"),
                "updated_at" => $faker->dateTime("now")
            ]);
    }
}
