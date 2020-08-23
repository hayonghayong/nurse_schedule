<?php
use Illuminate\Database\Seeder;

    class WardsTableSeeder extends Seeder
    {
        /**
         * Run the database seeds.
         *
         * @return void
         */
        public function run()
        {
            //Cmd: php artisan db:seed --class="WardsTableSeeder"
            
            $faker = Faker\Factory::create("ja_JP");
            
            for( $i=0; $i<10; $i++ ){

                App\Ward::create([
					"hospital_id" => $faker->randomDigit(),
					"name" => $faker->name(),
					"created_at" => $faker->dateTime("now"),
					"updated_at" => $faker->dateTime("now")
                ]);
            }
        }
    }