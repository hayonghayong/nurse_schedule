<?php
use Illuminate\Database\Seeder;

    class TreatmentsTableSeeder extends Seeder
    {
        /**
         * Run the database seeds.
         *
         * @return void
         */
        public function run()
        {
            //Cmd: php artisan db:seed --class="TreatmentsTableSeeder"
            
            $faker = Faker\Factory::create("ja_JP");
            
            for( $i=0; $i<10; $i++ ){

                App\Treatment::create([
					"ward_id" => $faker->randomDigit(),
					"name" => $faker->name(),
					"time_required" => $faker->randomDigit(),
					"required_flg" => $faker->word(),
					"created_at" => $faker->dateTime("now"),
					"updated_at" => $faker->dateTime("now")
                ]);
            }
        }
    }