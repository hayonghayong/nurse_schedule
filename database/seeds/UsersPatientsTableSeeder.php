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
            //Cmd: php artisan db:seed --class="UsersPatientsTableSeeder"
            
            $faker = Faker\Factory::create("ja_JP");

            DB::table('users_patients')->insert([
                "ward_id" => 1,
                "user_id" => 1,
                "patient_id" => 1,
                "end_flg" => 0,
                "created_at" => $faker->dateTime("now"),
                "updated_at" => $faker->dateTime("now")
            ]);

            DB::table('users_patients')->insert([
                "ward_id" => 1,
                "user_id" => 1,
                "patient_id" => 3,
                "end_flg" => 0,
                "created_at" => $faker->dateTime("now"),
                "updated_at" => $faker->dateTime("now")
            ]);

            DB::table('users_patients')->insert([
                "ward_id" => 1,
                "user_id" => 1,
                "patient_id" => 5,
                "end_flg" => 0,
                "created_at" => $faker->dateTime("now"),
                "updated_at" => $faker->dateTime("now")
            ]);

            DB::table('users_patients')->insert([
                "ward_id" => 1,
                "user_id" => 1,
                "patient_id" => 7,
                "end_flg" => 0,
                "created_at" => $faker->dateTime("now"),
                "updated_at" => $faker->dateTime("now")
            ]);

            DB::table('users_patients')->insert([
                "ward_id" => 1,
                "user_id" => 2,
                "patient_id" => 2,
                "end_flg" => 0,
                "created_at" => $faker->dateTime("now"),
                "updated_at" => $faker->dateTime("now")
            ]);

            DB::table('users_patients')->insert([
                "ward_id" => 1,
                "user_id" => 2,
                "patient_id" => 4,
                "end_flg" => 0,
                "created_at" => $faker->dateTime("now"),
                "updated_at" => $faker->dateTime("now")
            ]);

            DB::table('users_patients')->insert([
                "ward_id" => 2,
                "user_id" => 1,
                "patient_id" => 1,
                "end_flg" => 0,
                "created_at" => $faker->dateTime("now"),
                "updated_at" => $faker->dateTime("now")
            ]);

            DB::table('users_patients')->insert([
                "ward_id" => 2,
                "user_id" => 1,
                "patient_id" => 2,
                "end_flg" => 0,
                "created_at" => $faker->dateTime("now"),
                "updated_at" => $faker->dateTime("now")
            ]);

          
        }
            
        }