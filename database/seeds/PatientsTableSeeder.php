<?php
use Illuminate\Database\Seeder;

    class PatientsTableSeeder extends Seeder
    {
        /**
         * Run the database seeds.
         *
         * @return void
         */
        public function run()
        {
            //Cmd: php artisan db:seed --class="PatientsTableSeeder"
            
            $faker = Faker\Factory::create("ja_JP");
            
            for( $i=0; $i<10; $i++ ){

                App\Patient::create([
					"ward_id" => $faker->randomDigit(),
					"name" => $faker->name(),
					"birthday" => $faker->date()." ".$faker->time(),
					"sex" => $faker->word(),
					"room" => $faker->randomDigit(),
					"hospitalization_date" => $faker->date()." ".$faker->time(),
					"surgery_date" => $faker->date()." ".$faker->time(),
					"memo" => $faker->word(),
					"discharge_flg" => $faker->word(),
					"created_at" => $faker->dateTime("now"),
					"updated_at" => $faker->dateTime("now")
                ]);
            }
        }
    }