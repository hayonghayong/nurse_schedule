<?php
use Illuminate\Database\Seeder;

    class HospitalsTableSeeder extends Seeder
    {
        /**
         * Run the database seeds.
         *
         * @return void
         */
        public function run()
        {
            //Cmd: php artisan db:seed --class="HospitalsTableSeeder"
            
            $faker = Faker\Factory::create("ja_JP");
            $data=[
                [
                    "name" => "ジーズ病院",
                    "created_at" => $faker->dateTime("now"),
                    "updated_at" => $faker->dateTime("now")
                ],
                [
                    "name" => "アカデミー病院",
                    "created_at" => $faker->dateTime("now"),
                    "updated_at" => $faker->dateTime("now")
                ]
            ];
            DB::table('hospitals')->insert($data);
        }
    }