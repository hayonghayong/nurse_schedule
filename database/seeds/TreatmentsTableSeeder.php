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

            DB::table('treatments')->insert([
                "ward_id" => 1,
                "name" => '点滴',
                "time_required" => 10,
                "required_flg" => 0,
                "created_at" => $faker->dateTime("now"),
                "updated_at" => $faker->dateTime("now")
            ]);

            DB::table('treatments')->insert([
                "ward_id" => 1,
                "name" => 'オペ出し',
                "time_required" => 20,
                "required_flg" => 1,
                "created_at" => $faker->dateTime("now"),
                "updated_at" => $faker->dateTime("now")
            ]);

            DB::table('treatments')->insert([
                "ward_id" => 1,
                "name" => 'バイタル測定',
                "time_required" => 5,
                "required_flg" => 0,
                "created_at" => $faker->dateTime("now"),
                "updated_at" => $faker->dateTime("now")
            ]);

            DB::table('treatments')->insert([
                "ward_id" => 2,
                "name" => '点滴',
                "time_required" => 10,
                "required_flg" => 0,
                "created_at" => $faker->dateTime("now"),
                "updated_at" => $faker->dateTime("now")
            ]);

            DB::table('treatments')->insert([
                "ward_id" => 2,
                "name" => '内服',
                "time_required" => 20,
                "required_flg" => 1,
                "created_at" => $faker->dateTime("now"),
                "updated_at" => $faker->dateTime("now")
            ]);

            DB::table('treatments')->insert([
                "ward_id" => 2,
                "name" => '食事補助',
                "time_required" => 5,
                "required_flg" => 0,
                "created_at" => $faker->dateTime("now"),
                "updated_at" => $faker->dateTime("now")
            ]);

            DB::table('treatments')->insert([
                "ward_id" => 3,
                "name" => '点滴',
                "time_required" => 10,
                "required_flg" => 0,
                "created_at" => $faker->dateTime("now"),
                "updated_at" => $faker->dateTime("now")
            ]);

            DB::table('treatments')->insert([
                "ward_id" => 3,
                "name" => 'バイタル測定',
                "time_required" => 20,
                "required_flg" => 1,
                "created_at" => $faker->dateTime("now"),
                "updated_at" => $faker->dateTime("now")
            ]);

            DB::table('treatments')->insert([
                "ward_id" => 3,
                "name" => '食事補助',
                "time_required" => 15,
                "required_flg" => 0,
                "created_at" => $faker->dateTime("now"),
                "updated_at" => $faker->dateTime("now")
            ]);

            DB::table('treatments')->insert([
                "ward_id" => 4,
                "name" => '点滴',
                "time_required" => 10,
                "required_flg" => 0,
                "created_at" => $faker->dateTime("now"),
                "updated_at" => $faker->dateTime("now")
            ]);

            DB::table('treatments')->insert([
                "ward_id" => 4,
                "name" => '内服',
                "time_required" => 20,
                "required_flg" => 1,
                "created_at" => $faker->dateTime("now"),
                "updated_at" => $faker->dateTime("now")
            ]);

            DB::table('treatments')->insert([
                "ward_id" => 4,
                "name" => '食事補助',
                "time_required" => 5,
                "required_flg" => 0,
                "created_at" => $faker->dateTime("now"),
                "updated_at" => $faker->dateTime("now")
            ]);

        }
    }