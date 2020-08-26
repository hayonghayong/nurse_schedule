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
            
            DB::table('patients')->insert([
                "ward_id" => 1,
                "name" => '佐藤智哉',
                "birthday" => $faker->date()." ".$faker->time(),
                "sex" => 1,
                "room" => 101,
                "hospitalization_date" => $faker->date()." ".$faker->time(),
                "surgery_date" => $faker->date()." ".$faker->time(),
                "memo" => '佐藤です',
                "discharge_flg" => 0,
                "created_at" => $faker->dateTime("now"),
                "updated_at" => $faker->dateTime("now")
            ]);
            DB::table('patients')->insert([
                "ward_id" => 1,
                "name" => '崔　賀英',
                "birthday" => $faker->date()." ".$faker->time(),
                "sex" => 2,
                "room" => 201,
                "hospitalization_date" => $faker->date()." ".$faker->time(),
                "surgery_date" => $faker->date()." ".$faker->time(),
                "memo" => 'はよんです',
                "discharge_flg" => 0,
                "created_at" => $faker->dateTime("now"),
                "updated_at" => $faker->dateTime("now")
            ]);
            DB::table('patients')->insert([
                "ward_id" => 2,
                "name" => '宮本一成',
                "birthday" => $faker->date()." ".$faker->time(),
                "sex" => 1,
                "room" => 101,
                "hospitalization_date" => $faker->date()." ".$faker->time(),
                "surgery_date" => $faker->date()." ".$faker->time(),
                "memo" => 'イッセーです',
                "discharge_flg" => 0,
                "created_at" => $faker->dateTime("now"),
                "updated_at" => $faker->dateTime("now")
            ]);

            DB::table('patients')->insert([
                "ward_id" => 2,
                "name" => '安養寺遥',
                "birthday" => $faker->date()." ".$faker->time(),
                "sex" => 2,
                "room" => 201,
                "hospitalization_date" => $faker->date()." ".$faker->time(),
                "surgery_date" => $faker->date()." ".$faker->time(),
                "memo" => '安養寺です',
                "discharge_flg" => 0,
                "created_at" => $faker->dateTime("now"),
                "updated_at" => $faker->dateTime("now")
            ]);
 
            DB::table('patients')->insert([
                "ward_id" => 3,
                "name" => '川邊拓哉',
                "birthday" => $faker->date()." ".$faker->time(),
                "sex" => 1,
                "room" => 101,
                "hospitalization_date" => $faker->date()." ".$faker->time(),
                "surgery_date" => $faker->date()." ".$faker->time(),
                "memo" => 'カワベです',
                "discharge_flg" => 0,
                "created_at" => $faker->dateTime("now"),
                "updated_at" => $faker->dateTime("now")
            ]);
            DB::table('patients')->insert([
                "ward_id" => 3,
                "name" => '辻 志穂里',
                "birthday" => $faker->date()." ".$faker->time(),
                "sex" => 2,
                "room" => 201,
                "hospitalization_date" => $faker->date()." ".$faker->time(),
                "surgery_date" => $faker->date()." ".$faker->time(),
                "memo" => 'つじです',
                "discharge_flg" => 0,
                "created_at" => $faker->dateTime("now"),
                "updated_at" => $faker->dateTime("now")
            ]);

            DB::table('patients')->insert([
                "ward_id" => 4,
                "name" => '櫨元航太',
                "birthday" => $faker->date()." ".$faker->time(),
                "sex" => 1,
                "room" => 101,
                "hospitalization_date" => $faker->date()." ".$faker->time(),
                "surgery_date" => $faker->date()." ".$faker->time(),
                "memo" => 'ハゼもとです',
                "discharge_flg" => 0,
                "created_at" => $faker->dateTime("now"),
                "updated_at" => $faker->dateTime("now")
            ]);

            DB::table('patients')->insert([
                "ward_id" => 4,
                "name" => 'Mayo Nakamura',
                "birthday" => $faker->date()." ".$faker->time(),
                "sex" => 2,
                "room" => 201,
                "hospitalization_date" => $faker->date()." ".$faker->time(),
                "surgery_date" => $faker->date()." ".$faker->time(),
                "memo" => 'マヨです',
                "discharge_flg" => 0,
                "created_at" => $faker->dateTime("now"),
                "updated_at" => $faker->dateTime("now")
            ]);
        }
    }