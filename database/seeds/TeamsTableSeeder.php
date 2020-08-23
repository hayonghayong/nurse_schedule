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
            
            for( $i=0; $i<10; $i++ ){

                App\Team::create([
					"ward_id" => $faker->randomDigit(),
					"user_id" => $faker->randomDigit(),
					"created_at" => $faker->dateTime("now"),
					"updated_at" => $faker->dateTime("now")
                ]);
            }
        }
    }