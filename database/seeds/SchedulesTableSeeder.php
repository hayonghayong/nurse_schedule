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
            //Cmd: php artisan db:seed --class="SchedulesTableSeeder"
            
            $faker = Faker\Factory::create("ja_JP");
            
            for( $i=0; $i<10; $i++ ){

                App\Schedule::create([
					"ward_id" => $faker->randomDigit(),
					"user_id" => $faker->randomDigit(),
					"treatment_id" => $faker->randomDigit(),
					"patient_id" => $faker->randomDigit(),
					"start_date" => $faker->date()." ".$faker->time(),
					"created_at" => $faker->dateTime("now"),
					"updated_at" => $faker->dateTime("now")
                ]);
            }
        }
    }