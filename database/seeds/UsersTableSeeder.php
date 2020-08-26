<?php
use Illuminate\Database\Seeder;

    class UsersTableSeeder extends Seeder
    {
        /**
         * Run the database seeds.
         *
         * @return void
         */
        public function run()
        {
            //Cmd: php artisan db:seed --class="UsersTableSeeder"
            
            $faker = Faker\Factory::create("ja_JP");

            DB::table('users')->insert([
                "ward_id" => 1,
                "name" => '中村ダイスケ',
                "login_id" => 'nurse1',
                "password" => 'nurse1',
                "admin_flg" => 0,
                "created_at" => $faker->dateTime("now"),
                "updated_at" => $faker->dateTime("now")
            ]);

            DB::table('users')->insert([
                "ward_id" => 1,
                "name" => '山本篤',
                "login_id" => 'nurse2',
                "password" => 'nurse2',
                "admin_flg" => 0,
                "created_at" => $faker->dateTime("now"),
                "updated_at" => $faker->dateTime("now")
            ]);

            DB::table('users')->insert([
                "ward_id" => 1,
                "name" => '阿部 圭史',
                "login_id" => 'nurse3',
                "password" => 'nurse3',
                "admin_flg" => 0,
                "created_at" => $faker->dateTime("now"),
                "updated_at" => $faker->dateTime("now")
            ]);

            DB::table('users')->insert([
                "ward_id" => 1,
                "name" => '山崎先生',
                "login_id" => 'admin1',
                "password" => 'admin1',
                "admin_flg" => 1,
                "created_at" => $faker->dateTime("now"),
                "updated_at" => $faker->dateTime("now")
            ]);

            DB::table('users')->insert([
                "ward_id" => 2,
                "name" => '難波江　基己',
                "login_id" => 'nurse4',
                "password" => 'nurse4',
                "admin_flg" => 0,
                "created_at" => $faker->dateTime("now"),
                "updated_at" => $faker->dateTime("now")
            ]);
            DB::table('users')->insert([
                "ward_id" => 2,
                "name" => '石上 遼',
                "login_id" => 'nurse5',
                "password" => 'nurse5',
                "admin_flg" => 0,
                "created_at" => $faker->dateTime("now"),
                "updated_at" => $faker->dateTime("now")
            ]);
            DB::table('users')->insert([
                "ward_id" => 2,
                "name" => '松本隼人',
                "login_id" => 'nurse6',
                "password" => 'nurse6',
                "admin_flg" => 0,
                "created_at" => $faker->dateTime("now"),
                "updated_at" => $faker->dateTime("now")
            ]);
            DB::table('users')->insert([
                "ward_id" => 2,
                "name" => '児玉さん',
                "login_id" => 'admin2',
                "password" => 'admin2',
                "admin_flg" => 1,
                "created_at" => $faker->dateTime("now"),
                "updated_at" => $faker->dateTime("now")
            ]);

        }
    }