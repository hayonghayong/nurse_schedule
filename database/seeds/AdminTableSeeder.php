<?php

use Illuminate\Database\Seeder;

class AdminTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create("ja_JP");
        DB::table('admins')->insert([
            "ward_id" => 1,
            "name" => '山崎先生',
            "login_id" => 'admin1',
            "password" =>  bcrypt('admin1'),
            "created_at" => $faker->dateTime("now"),
            "updated_at" => $faker->dateTime("now")
        ]);
        DB::table('admins')->insert([
            "ward_id" => 2,
            "name" => '児玉さん',
            "login_id" => 'admin2',
            "password" =>  bcrypt('admin2'),
            "created_at" => $faker->dateTime("now"),
            "updated_at" => $faker->dateTime("now")
        ]);
    }
}
