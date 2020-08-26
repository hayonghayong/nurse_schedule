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
            
            DB::table('wards')->insert([
                "hospital_id" => 1,
                "name" => '一般病棟',
                "created_at" => $faker->dateTime("now"),
                "updated_at" => $faker->dateTime("now")
            ]);
            DB::table('wards')->insert([
                "hospital_id" => 1,
                "name" => '特殊病棟',
                "created_at" => $faker->dateTime("now"),
                "updated_at" => $faker->dateTime("now")
            ]);
            DB::table('wards')->insert([
                "hospital_id" => 2,
                "name" => '一般病棟',
                "created_at" => $faker->dateTime("now"),
                "updated_at" => $faker->dateTime("now")
            ]);
            DB::table('wards')->insert([
                "hospital_id" => 2,
                "name" => '特殊病棟',
                "created_at" => $faker->dateTime("now"),
                "updated_at" => $faker->dateTime("now")
            ]);
        }
    }