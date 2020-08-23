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
            
            for( $i=0; $i<10; $i++ ){

                App\Attendance::create([
					"ward_id" => $faker->randomDigit(),
					"user_id" => $faker->randomDigit(),
					"attendance_flg" => $faker->randomDigit(),
					"created_at" => $faker->dateTime("now"),
					"updated_at" => $faker->dateTime("now")
                ]);
            }
        }
    }