<?php
use Illuminate\Database\Seeder;

    class AttendancesTableSeeder extends Seeder
    {
        /**
         * Run the database seeds.
         *
         * @return void
         */
        public function run()
        {
            //Cmd: php artisan db:seed --class="AttendancesTableSeeder"
            
            $faker = Faker\Factory::create("ja_JP");
            

            
                DB::table('attendances')->insert([
					"ward_id" => 1,
					"user_id" => 1,
					"attendance_flg" => 0,
					"created_at" => $faker->dateTime("now"),
					"updated_at" => $faker->dateTime("now")
                ]);
                DB::table('attendances')->insert([
					"ward_id" => 1,
					"user_id" => 1,
					"attendance_flg" => 1,
					"created_at" => $faker->dateTime("now"),
					"updated_at" => $faker->dateTime("now")
                ]);




        }
    }