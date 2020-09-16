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
                "password" => bcrypt('nurse1'),
                "admin_flg" => 0,
                "created_at" => $faker->dateTime("now"),
                "updated_at" => $faker->dateTime("now")
            ]);

            DB::table('users')->insert([
                "ward_id" => 1,
                "name" => '山本篤',
                "login_id" => 'nurse2',
                "password" => bcrypt('nurse2'),
                "admin_flg" => 0,
                "created_at" => $faker->dateTime("now"),
                "updated_at" => $faker->dateTime("now")
            ]);

            DB::table('users')->insert([
                "ward_id" => 1,
                "name" => '阿部 圭史',
                "login_id" => 'nurse3',
                "password" =>  bcrypt('nurse3'),
                "admin_flg" => 0,
                "created_at" => $faker->dateTime("now"),
                "updated_at" => $faker->dateTime("now")
            ]);

            DB::table('users')->insert([
                "ward_id" => 2,
                "name" => '難波江　基己',
                "login_id" => 'nurse4',
                "password" =>  bcrypt('nurse4'),
                "admin_flg" => 0,
                "created_at" => $faker->dateTime("now"),
                "updated_at" => $faker->dateTime("now")
            ]);
            DB::table('users')->insert([
                "ward_id" => 2,
                "name" => '石上 遼',
                "login_id" => 'nurse5',
                "password" =>  bcrypt('nurse5'),
                "admin_flg" => 0,
                "created_at" => $faker->dateTime("now"),
                "updated_at" => $faker->dateTime("now")
            ]);
            DB::table('users')->insert([
                "ward_id" => 2,
                "name" => '松本隼人',
                "login_id" => 'nurse6',
                "password" =>  bcrypt('nurse6'),
                "admin_flg" => 0,
                "created_at" => $faker->dateTime("now"),
                "updated_at" => $faker->dateTime("now")
            ]);


            DB::table('users')->insert([
                "ward_id" => 1,
                "name" => 'みっしー',
                "login_id" => 'nurse7',
                "password" => bcrypt('nurse7'),
                "admin_flg" => 0,
                "created_at" => $faker->dateTime("now"),
                "updated_at" => $faker->dateTime("now")
            ]);

            DB::table('users')->insert([
                "ward_id" => 1,
                "name" => 'いまっぱ',
                "login_id" => 'nurse8',
                "password" => bcrypt('nurse8'),
                "admin_flg" => 0,
                "created_at" => $faker->dateTime("now"),
                "updated_at" => $faker->dateTime("now")
            ]);

        }
    }