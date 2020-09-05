<?php
use Illuminate\Database\Seeder;

    class TeamUsersTableSeeder extends Seeder
    {
        /**
         * Run the database seeds.
         *
         * @return void
         */
        public function run()
        {
            //Cmd: php artisan db:seed --class="TeamUsersTableSeeder"
            
            $faker = Faker\Factory::create("ja_JP");

            DB::table('team_users')->insert([
                "user_id" => 2,
                "team_id" => 1,
                "created_at" => $faker->dateTime("now"),
                "updated_at" => $faker->dateTime("now")
            ]);

            DB::table('team_users')->insert([
                "user_id" => 3,
                "team_id" => 1,
                "created_at" => $faker->dateTime("now"),
                "updated_at" => $faker->dateTime("now")
            ]);
            
        }
    }