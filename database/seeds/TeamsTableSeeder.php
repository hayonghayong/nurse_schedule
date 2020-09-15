<?php
use Illuminate\Database\Seeder;

    class TeamsTableSeeder extends Seeder
    {
        /**
         * Run the database seeds.
         *
         * @return void
         */
        public function run()
        {
            //Cmd: php artisan db:seed --class="TeamsTableSeeder"
            
            $faker = Faker\Factory::create("ja_JP");

            DB::table('teams')->insert([
                "user_id" => 1,
                "created_at" => $faker->dateTime("now"),
                "updated_at" => $faker->dateTime("now")
            ]);
            
        }
    }